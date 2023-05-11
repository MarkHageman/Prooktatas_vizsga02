<?php
require_once('adatbazis.php');
$torles = new AdatbazisRendezes("localhost", "root", "", "magnahungaria");

if(isset($_POST['id'])) {
    $id = $_POST['id'];
    $torles->sorTorlese('termékek', $id);
    header('Location: raktar.php');
}


?>