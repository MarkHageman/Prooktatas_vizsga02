<?php
// adatbázis kapcsolat inicializálása
require_once('adatbazis.php');
$update = new AdatbazisRendezes("localhost", "root", "", "magnahungaria");

// űrlapról érkező adatok kezelése és feldolgozása
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id = $_POST["id"];
    $isbn = (int)$_POST["ISBN"];
    $cim = $_POST["cim"];
    $mu_tipusa = $_POST["mu_tipusa"];
    $ar = (int)$_POST["ar"];
    $szerzo = $_POST["szerzo"];
    $mufaj = $_POST["mufaj"];
    $borito = $_FILES["borito"]["name"];
    $szinopszis = $_POST["szinopszis"];
    $kiadas_datum = $_POST["kiadas_datum"];
    
    // borítókép fájl feltöltése és elmentése a szerverre
    if (!empty($borito)) {
        $target_dir = "img/";
        $target_file = $target_dir . basename($_FILES["borito"]["name"]);
        $imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));
        $ellenorzes = getimagesize($_FILES['borito']['tmp_name']);
        if($ellenorzes === false){
            $hiba = "A fájl nem kép!";
            exit();
        }
        move_uploaded_file($_FILES["borito"]["tmp_name"], $target_file);
    }
    
    // az adatbázisban tárolt adatok frissítése
    $frissit_arr = array(
        "`ISBN`=$isbn",
        "`cim`='$cim'",
        "`mu_tipusa`='$mu_tipusa'",
        "`ar`=$ar",
        "`szerzo`='$szerzo'",
        "`mufaj`='$mufaj'",
        "`szinopszis`='$szinopszis'",
        "`kiadas_datum`='$kiadas_datum'"
    );
    
    if (!empty($borito)) {
        $frissit_arr[] = "borito='$borito'";
    }

    $frissit = implode(", ", $frissit_arr);
    $update->sorFrissitese("termékek", $frissit, $id);
    $uzenet = "Az adat/adatok sikeresen frissítve lettek.";
    header('Location: raktar.php');
}










?>