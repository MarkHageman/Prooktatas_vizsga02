<?php

class AdatbazisRendezes
{
    //Adatbázis kapcsolathoz szükséges infók
    private $host;
    private $username;
    private $pass;
    private $db;
    private $conn;

    public function __construct($host, $username, $pass, $db){
        //Konstruktor: adatbázishoz kapcsolathoz szükséges infók beállítása
        $this->host = $host;
        $this->username = $username;
        $this->pass = $pass;
        $this->db = $db;

        //adatbázis kapcsolat létrehozása
        $this->conn = new mysqli($this->host, $this->username, $this->pass, $this->db);

        //Hibaellenőrzés: ha nem sikerül kapcsolódni, a script leállítása
        if($this->conn->connect_error){
            die("Sikertelen csatlakozás: " . $this->conn->connect_error);
        }
        //print("A csatlakozás sikeres.");
    }

    public function tablaKeszites($tablaNev, $oszlopok){
        //Tábla létrehozása sql lekérdezéssel
        $lekerdezes = "CREATE TABLE IF NOT EXISTS $tablaNev ($oszlopok)";
        if($this->conn->query($lekerdezes) === TRUE){
            //Sikeres tábla létrehozás
            print("$tablaNev tábla sikeresen létrehozva<br>");
        } else {
            //Sikertelen létrehozás és a hiba lekérése
            print("Hiba a tábla létrehozásában: " . $this->conn->error);
        }
    }
    
    //egy rekord alapján ellenőrzi, hogy az adott adatsor már szerepel-e az adott táblában
    public function rekordEllenorzesISBNAlapjan($tablaNev, $ISBN){
        //lekerdezés összeállítása
        $lekerdezes = "SELECT COUNT(*) FROM $tablaNev WHERE ISBN=?";
        //adatbázis kapcsolat a lekérdezés végrehajtásához
        $eredmeny = $this->conn->prepare($lekerdezes);
        //a lekérdezésben szereplő cím paramétert összekötöm a metódus paraméterében megadott cím értékével
        $eredmeny->bind_param("i", $ISBN);
        //lekérdezés végrehajtása
        $eredmeny->execute();
        //a lekérdezés eredményét lekérjük
        $ertek = $eredmeny->get_result();
        $rekord = $ertek->fetch_assoc();
        
        $eredmeny->close();
        //megnézzük, hogy az érték nagyobb-e mint nulla, ha igen hibát dob vissza
        if($rekord["COUNT(*)"] > 0){
            die("Az adatbázisban már létezik rekord az ISBN: $ISBN értékkel.<br>");
        }

    }

    //oszlop nevek duplikálódásának kijavítása
    private function oszlopNev($oszlopNev, $oszlopok){
        return in_array($oszlopNev, $oszlopok);
    }

    //Adatok beszúrása sql lekérdezéssel
    public function adatBevitel($tablaNev, $adat){
        //Lekérdezzük a tábla oszlop neveit
        $oszlopNevek = $this->conn->query("SHOW COLUMNS FROM $tablaNev");
        $oszlopok = [];
        while($sor = $oszlopNevek->fetch_assoc()){
            if($sor['Field'] !== 'id'){
                if(!$this->oszlopNev($sor['Field'], $oszlopok)){
                    $oszlopok[] = $sor['Field'];
                }
            }
            
        }
       
        //Az adatok értékeinek összefűzése elválasztójelenként
        //a real_escape_string() biztosítja az értékek biztonságos bevitelét
        $ertekek = [];
        foreach ($oszlopok as $oszlopNev) {
            $ertek = isset($adat[$oszlopNev]) ? $adat[$oszlopNev] : '';
            if($oszlopNev == 'jelszo_hash'){
                $ertek = password_hash($ertek, PASSWORD_DEFAULT, ['cost' => 12]);
            }
            if(is_numeric($ertek)){
                $ertekek[] =  "`$oszlopNev`=" . $this->conn->real_escape_string($ertek);
            } else {
                $ertekek[] =  "`$oszlopNev`='" . $this->conn->real_escape_string($ertek) . "'";
            }            
        }
        
        

        //Létrehozzuk a lekérdezést
        $lekerdezes = "INSERT INTO $tablaNev SET " . implode(",", $ertekek);
        /* print($lekerdezes); */
        if($this->conn->query($lekerdezes) === TRUE){
            //print("Adat sikeresen beszúrva.");
        } else{
            //Sikertelen létrehozás és a hiba lekérése
            //print("Hiba az adat beszúrásakor: " . $this->conn->error);
        } 
    }

    public function adatBeviteleFilebol($tablaNev, $fileEleres){
        //File létezésének ellenőrzése
        if(!file_exists($fileEleres)){
            die("A fájl nem elérhető.");
        }
        
        //File megnyitása
        $file = fopen($fileEleres, 'r');
        //Ellenőrzés: sikeres-e a file megnyitas
        if(!$file){
            die("A fájl nem elérhető");
        }

        //A fejléc sor kiolvasása
        $fejlec = fgets($file);
        $fejlecAdatai = str_getcsv(trim($fejlec), ';');
        $fejlecAdatai = array_filter($fejlecAdatai, function($value){
            return $value !== "";
        });

        //File sorain való végiglépkedés
        while(($sor = fgets($file)) !== FALSE){
            //Aktuális sor adatainak kiolvasása
            $adat = str_getcsv(trim($sor), ';');
            //Ha az adatok nem egyeznek meg a fejléc adataival akkor beszúrjuk őket
            if($adat !== $fejlecAdatai){
                //rekord ellenőrzés
                $this->rekordEllenorzesISBNAlapjan($tablaNev, $adat[0]);
                //üres elemek eltávolítása
                $adat = array_filter($adat);

                //ha az adatok száma megegyezik a fejléc adatainak számával, akkor beszúrjuk őket
                if(count($adat) == count($fejlecAdatai)){
                    //az adatok indexelése a fejléc adatai alapján
                    $adat = array_combine($fejlecAdatai, $adat);
                    //az értékek beszúrása a táblába
                    $this->adatBevitel($tablaNev, $adat);
                } else {
                    //hiba, ha nem egyezik meg az adatok száma a fejléc adatainek számával
                    print("Hiba az adat beszúrásakor: az adatok száma nem egyezik a fejléc adatainak számával.<br>");
                }
            }
        }
        //File beolvasása
        fclose($file);
    }

    public function adatLekerdezes($tablaNev, $oszlopok = "*", $feltetel = ""){
        //sql lekérdezés összeállítása
        $sql = "SELECT $oszlopok FROM $tablaNev $feltetel";
        //adatok lekérése az adatbázisból
        $eredmeny = $this->conn->query($sql);

        //ellenőrizzük, hogy találtunk-e eredményt
        if($eredmeny->num_rows > 0){
            //ha van eredmény, visszaadjuk az adatokat egy asszociatív tömbbe
            return $eredmeny->fetch_all(MYSQLI_ASSOC);
        } else {
            //ha nincs eredmény
            return "0 találat";
        }
    }

    public function rekordLekerdezes($tablaNev, $id){
        $sql = "SELECT * FROM $tablaNev WHERE id = '$id'";
        $eredmeny = $this->conn->query($sql);

        if($eredmeny && $eredmeny->num_rows > 0){
            return $eredmeny->fetch_assoc();
        } else {
            return "0 találat";
        }
    }

    public function sorFrissitese($tablaNev, $frissit, $id){
        $tablaNev = $this->conn->real_escape_string($tablaNev);
        /* $frissit = $this->conn->real_escape_string($frissit); */
        $id = $this->conn->real_escape_string($id);
        //sql frissítő lekérdezés összeállítása
        $sql = "UPDATE $tablaNev SET $frissit WHERE `id`='$id'";
        //frissítés végrehajtása
        if($this->conn->query($sql) === TRUE){
            //print("Sor frissítve a táblában.");
        } else {
            //print("Hiba a sor frissítése közben: " . $this->conn->error);
        }
    }

    public function sorTorlese($tablaNev, $id){
        //$tableNev és $id escapelése
        $tablaNev = $this->conn->real_escape_string($tablaNev);
        $id = $this->conn->real_escape_string($id);
        //sql törlő lekérdezés összeállítása
        $sql = "UPDATE `$tablaNev` SET `deleted`=1 WHERE `id`='$id'";
        //törlés végrehajtása

        if($this->conn->query($sql) === TRUE){
            print("Sor módosítva a táblában.");
        } else{
            print("Hiba a sor módosítása közben" . $this->conn->error);
        }
    }

    //adatbázis kapcsolat lezárása
    public function __destruct() {
        $this->conn->close();
    }

}




?>