<?php
session_start();
//adatbázis csatlakozás
require_once('adatbazis.php');
$isFelhasznalo = new AdatbazisRendezes("localhost", "root", "", "magnahungaria");

//Ha a felhasználó elküldte a bejelentkezési űrlapot
if($_SERVER['REQUEST_METHOD'] == "POST"){
    //Felhasználó/email cím és jelszó ellenőrzése
    $felhasznalo_email = trim($_POST['username']);
    $jelszo = trim($_POST['password']);
    //sql lekérdezés megírása az adatLekerdezes() metódus felhasználásához
    $where = "WHERE felhasznalonev='$felhasznalo_email' OR email='$felhasznalo_email'";
    $sql = $isFelhasznalo->adatLekerdezes('felhasznalok', '*', $where);
    //ha az sql lekérdezés nem egyenlő '0 találat'-tal ellenőrizzük a jelszót
    if($sql != '0 találat'){
        //a '$felhasznalo' változóban elmentjük az '$eredmeny' változóba beírt sql lekérdezést első találatát
        //a $felhasznalo változó egy asszociatív tömb lesz amin belül
        //az adattábla oszlop nevein keresztül hivatkozunk és hasonlítunk össze
        $felhaszalo = $sql[0];
        if(password_verify($jelszo, $felhaszalo['jelszo_hash'])){
            //Sikeres bejelentkezés esetén átirányítás a főoldalra
            //a bejelentkezési adatok mentése a session-be
            $_SESSION['loggedIn'] = true;
            $_SESSION['id'] = $felhaszalo['id'];
            $_SESSION['felhasznalonev'] = $felhaszalo['felhasznalonev'];
            $_SESSION['admin'] = (bool)$felhaszalo['jogosultsag_id'];

            header('Location: index.php');
        } else {
            //Hibaüzenet, ha a jelszó helytelen
           $_SESSION['hibaUzenet'] = 'Hibás jelszó!';
           header('Location: bejelentkezes.php');
        }
    } else {
        //Hibaüzenet, ha a felhasználónév/e-mail cím nem található az adatbázisban
       $_SESSION['hibaUzenet'] = "Hibás felhasználónév/e-mail cím!";
       header('Location: bejelentkezes.php');
    }
}
?>