<?php
require('adatbazis.php');

$termekTabla = new AdatbazisRendezes("localhost", "root", "", "magnahungaria");
$termekTetelek = "id INT(10) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
                ISBN INT(10) NOT NULL UNIQUE,
                cim VARCHAR(100) NOT NULL,
                mu_tipusa VARCHAR(100) NOT NULL,
                ar INT(15) NOT NULL,
                szerzo VARCHAR(50) NOT NULL,
                mufaj VARCHAR(100) NOT NULL,
                borito VARCHAR(100) NOT NULL,
                szinopszis TEXT NOT NULL,
                kiadas_datum DATE NOT NULL";

$termekTabla->tablaKeszites("Termékek", $termekTetelek);
$file = 'termekek.csv';
$termekTabla->adatBeviteleFilebol('termékek', $file);

$id = 39;
$termekTabla->sorTorlese("termékek", $id);
$termekTabla->sorFrissitese('termékek', 'deleted=0', $id);

//adatLekerdezes($tablaNev, $oszlopok = "*", $feltetel = "");
//$sql = "SELECT $oszlopok FROM $tablaNev $feltetel";
$oszlopok = "szerzo, cim, kiadas_datum, borito";
$feltetel = "WHERE szerzo LIKE '%Sörétes%'";
$adatok = $termekTabla->adatLekerdezes('termékek', $oszlopok, $feltetel);

print('<table>');
print('<tr><th>Cím</th><th>Szerző</th><th>Kiadás dátuma</th><th>Borító</th></tr>');
foreach ($adatok as $sor) {
    print('<tr><td>' . $sor['cim'] . '</td><td>' . $sor['szerzo'] . ' </td><td> ' . $sor['kiadas_datum'] . '</td><td> <img src=' . $sor['borito'] . '></td></tr>');
}
print("</table");

//$lekerdezes = "CREATE TABLE IF NOT EXISTS $tablaNev ($oszlopok)";
$felhasznalok = new AdatbazisRendezes("localhost", "root", "", "magnahungaria");
$felhasznaloOszlopok = "id INT(10) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
                        felhasznalonev VARCHAR(50) NOT NULL UNIQUE,
                        jelszo VARCHAR(255) NOT NULL,
                        email VARCHAR(255) NOT NULL UNIQUE,
                        hirlevel_feliratkozas TINYINT(1) NOT NULL DEFAULT 0
                        jogosultsag_id INT(10) NOT NULL FOREIGN KEY";
$felhasznalok->tablaKeszites('felhasznalok', $felhasznaloOszlopok);


$admin = new AdatbazisRendezes("localhost", "root", "", "magnahungaria");
$adat = [
    'felhasznalonev' => 'admin',
    'jelszo_hash' => 'admin',
    'email' => 'admin@example.com',
    'hirlevel_feliratkozas' => (int)0,
    'jogosultsag_id' => (int)1
];

$admin->adatBevitel('felhasznalok', $adat);



?>