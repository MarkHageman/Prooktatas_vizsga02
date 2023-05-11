<?php
session_start();
require_once('adatbazis.php');
$regist = new AdatbazisRendezes("localhost", "root", "", "magnahungaria");


if(empty($_POST['felhasznalo']) || empty($_POST['email']) || empty($_POST['email_megerosites']) || empty($_POST['jelszo']) || empty($_POST['jelszo_megerosites']) || !isset($_POST['aszf'])){
    $_SESSION['hibaUzenet'] = "Minden mező kitöltése kötelező és az ÁSZF elfogadása szükséges!";
} elseif(!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)){
    $_SESSION['hibaUzenet'] = "Helytelen e-mail formátum!";
} elseif($_POST['email'] !== $_POST['email_megerosites']){
    $_SESSION['hibaUzenet'] = "Az e-mail címek nem egyeznek!";
} elseif(strlen($_POST['jelszo']) < 8){
    $_SESSION['hibaUzenet'] = "A jelszónak legalább 8 karakter hosszúnak kell lennie!";
} elseif($_POST['jelszo'] !== $_POST['jelszo_megerosites']){
    $_SESSION['hibaUzenet'] = "A jelszavak nem egyeznek!";
}

if(empty($hibaUzenet)){
    $felhasznalo = $_POST['felhasznalo'];
    $email = $_POST['email'];
    $jelszo = $_POST['jelszo'];
    $hirlevel = 0;
    if(isset($_POST['hirlevel'])){
        $hirlevel = 1;
    }
    $jogosultsag_id = 0;

    
    //adatLekerdezes($tablaNev, $oszlopok = "*", $feltetel = "");
    //$sql = "SELECT $oszlopok FROM $tablaNev $feltetel";
    $where = "WHERE felhasznalonev='$felhasznalo' OR email='$email' LIMIT 1";
    $lekerdezes = $regist->adatLekerdezes('felhasznalok', '*', $where);
    if($lekerdezes != '0 találat'){
        $_SESSION['hibaUzenet'] = "Már van felhasználó regisztrálva ezzel a felhasználónévvel vagy e-mail címmel!";
        header('Location: regisztracio.php');
        exit;
    } elseif(!empty($_SESSION['hibaUzenet'])) {
       // Sikertelen regisztráció esetén megjelenítjük a hibaüzeneteket az űrlapon.
        header('Location: regisztracio.php');
        exit;    
    }   else {
        //Adatok mentése az adatbázisba
        $adatok = [
            'felhasznalonev' => $felhasznalo,
            'jelszo_hash' => $jelszo,
            'email' => $email,
            'hirlevel_feliratkozas' => $hirlevel,
            'jogosultsag_id' => $jogosultsag_id
        ];
        $regist->adatBevitel('felhasznalok', $adatok);
        //Sikeres mentés esetén átirányítás a bejelentkező oldalra
        header('Location: bejelentkezes.php');
    } 
} 


?>