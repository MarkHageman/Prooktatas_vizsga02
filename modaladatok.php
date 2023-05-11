<?php
session_start();
require_once('adatbazis.php');

$modositoModal = new AdatbazisRendezes("localhost", "root", "", "magnahungaria");

if(isset($_GET['id'])){
    $id = $_GET['id'];
    $oszlopok = "id, ISBN, cim, mu_tipusa, ar, szerzo, mufaj, szinopszis, kiadas_datum";
    $feltetel = "WHERE id = '$id'";

    $lekerdezes = $modositoModal->adatLekerdezes('termékek', $oszlopok, $feltetel);

    if(empty($lekerdezes)) {
        // Ha nincs ilyen termék, akkor visszaadunk egy hibaüzenetet
        echo json_encode(['error' => 'Nincs ilyen termék az adatbázisban.']);
    } else {
        // Ha van ilyen termék, akkor visszaadjuk az adatokat
        echo json_encode($lekerdezes);
    }
}

?>