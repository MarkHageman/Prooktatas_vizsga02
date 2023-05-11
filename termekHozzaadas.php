<?php
session_start();
//Adatbázis kapcsolódás
require_once('adatbazis.php');
$ujTermek = new AdatbazisRendezes("localhost", "root", "", "magnahungaria");
$hibak = [];
//Az űrlap elküldésekor ellenőrizzük és kezeljük az adatokat
if($_SERVER['REQUEST_METHOD'] === 'POST'){
    //Ellenőrizzük, hogy az összes kötelező mező ki van-e töltve
    if(empty($_POST['ISBN'])){
        $hibak[] = 'Az ISBN mező kitöltése kötelező';
        header('Location: raktar.php');
        exit();
    } else {
        $ISBN = $_POST['ISBN'];
    }
    if(empty($_POST['cim'])){
        $hibak[] = 'Az cim mező kitöltése kötelező';
        header('Location: raktar.php');
        exit();
    } else {
        $cim = $_POST['cim'];
    }
    if(empty($_POST['mu_tipusa'])){
        $hibak[] = 'Az mu_tipusa mező kitöltése kötelező';
        header('Location: raktar.php');
        exit();
    } else {
        $mu_tipusa = $_POST['mu_tipusa'];
    }
    if(empty($_POST['ar'])){
        $hibak[] = 'Az ar mező kitöltése kötelező';
        header('Location: raktar.php');
        exit();
    } else {
        (int)$ar = $_POST['ar'];
    }
    if(empty($_POST['szerzo'])){
        $hibak[] = 'Az szerzo mező kitöltése kötelező';
        header('Location: raktar.php');
        exit();
    } else {
        $szerzo = $_POST['szerzo'];
    }
    if(empty($_POST['mufaj'])){
        $hibak[] = 'Az mufaj mező kitöltése kötelező';
        header('Location: raktar.php');
        exit();
    } else {
        $mufaj = $_POST['mufaj'];
    }
    if(empty($_FILES['borito'])){
        $hibak[] = 'Az borito mező kitöltése kötelező';
        header('Location: raktar.php');
        exit();
    } else {
        $borito = $_FILES['borito'];
    }
    if(empty($_POST['szinopszis'])){
        $hibak[] = 'Az szinopszis mező kitöltése kötelező';
        header('Location: raktar.php');
        exit();
    } else {
        $szinopszis = $_POST['szinopszis'];
    }
    if(empty($_POST['kiadas_datum'])){
        $hibak[] = 'Az kiadas_datum mező kitöltése kötelező';
        header('Location: raktar.php');
        exit();
    } else {
        $kiadas_datum = $_POST['kiadas_datum'];
    }
}

//Ellenőrizzük, hogy a feltöltött fájl valóban képfájl-e
if(!empty($_FILES['borito']['name'])){
    $elfogadott = ['jpg', 'jpeg', 'png'];
    $celMappa = "./img/";
    $eleresiUtvonal = $celMappa . basename($_FILES['borito']['name']);
    $kepFajlTipusa = strtolower(pathinfo($eleresiUtvonal, PATHINFO_EXTENSION));    
    $ellenorzes = getimagesize($_FILES['borito']['tmp_name']);
    if($ellenorzes === false){
        $hibak[] = "A borító nem kép";
        header('Location: raktar.php');
        exit();
    }
    if(!in_array($kepFajlTipusa, $elfogadott)){
        $hibak[] = "A borító csak JPG, JPEG vagy PNG formátumba tölthető fel.";
        header('Location: raktar.php');
        exit();
    }
    if($_FILES['borito']['size'] > 5000000){
        $hibak[] = "A borító maximális mérete 5MB lehet.";
        header('Location: raktar.php');
        exit();
    }
    move_uploaded_file($_FILES['borito']['tmp_name'], $eleresiUtvonal);
} else {
    $hibak[] = "A borító mező kitöltése kötelező";
    header('Location: raktar.php');
    exit();
}

if(empty($hibak)){

    $where = "WHERE ISBN='" . $ISBN . "' LIMIT 1";
    $lekerdezes = $ujTermek->adatLekerdezes('termékek', '*', $where);
    if($lekerdezes != '0 találat'){
        $hibak[] = "Már létezik könyv ezzel az ISBN azonosítóval!";
        header('Location: raktar.php');
        exit();
    } elseif(!empty($hibak)){
        $_SESSION['hibaUzenet'] = $hibak;
        header('Location: raktar.php');
        exit();
    } else {
        $adatok = [
            'ISBN' => (int)$ISBN,
            'cim' => $cim,
            'mu_tipusa' => $mu_tipusa,
            'ar' => (int)$ar,
            'szerzo' => $szerzo,
            'mufaj' => $mufaj,
            'borito' => $eleresiUtvonal,
            'szinopszis' => $szinopszis,
            'kiadas_datum' => $kiadas_datum
        ];
        $ujTermek->adatBevitel('termékek', $adatok);
        header('Location: raktar.php');
    }
}

var_dump($_SESSION['hibaUzenet']);



?>