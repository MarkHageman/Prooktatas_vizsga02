<?php session_start(); ?>
<!DOCTYPE html>
<html lang="hu">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Magna Hungaria kiadó</title>
    <link rel="stylesheet" href="./dist/style.css">
    <link rel="shortcut icon" href="./media/favicon.png" type="image/x-icon">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/foundicons/3.0.0/foundation-icons.min.css" integrity="sha512-kDmbIQZ10fxeKP5NSt3+tz77HO42IJiS+YPIirOIKTdokl4LtuXYo3NNvq9mTAF+rzdV1plp0sm9E6nvtVpnFQ==" crossorigin="anonymous" referrerpolicy="no-referrer" />
</head>
<body>
    <header>
        <nav class="container-nav p-1">
            <div class="logo">
                <a href="./index.php" class="active" id="logo">
                    <img src="./media/logo.png" alt="">
                    <h5 >Magna </h5>
                    <h5><span id="hun">Hun</span>garia</h5>
                </a>                
                <svg id="hamburger"  class="m-1 p-1">
                    <line class="menuline" x1="2" y1="6" x2="22" y2="6" stroke-width="3" />
                    <line class="menuline" x1="2" y1="12" x2="22" y2="12" stroke-width="3" />
                    <line class="menuline" x1="2" y1="18" x2="22" y2="18" stroke-width="3" />
                </svg>     
            </div>
            <div class="menu">
                <ul>
                    <li><a href="./index.php" class="mx-1 p-2">Főoldal</a></li>
                    <li><a href="./megjelent.php" class="mx-1 p-2">Megjelent kötetek</a></li>
                    <li><a href="./tanfolyam.php" class="mx-1 p-2">Író tanfolyam</a></li>
                    <li><a href="./kapcsolat.php" class="mx-1 p-2">Kapcsolat</a></li>
                    <?php 
                    //ellenőrizzük, hogy a felhasználó bevan-e jelentkezve
                    //ha be van jelentkezve, akkor Kijelentkezés menüpont megjelenítése
                    //ha a felhasználó admin jogosultsággal rendelkezik Raktár menüpont megjelenítése
                    //ha nincs bejelentkezve, Bejelentkezés menüpont megjelenítése
                    if(isset($_SESSION['loggedIn']) && $_SESSION['loggedIn'] === TRUE){
                        print('<li><a href="./kijelentkezes.php" class="mx-1 p-2">Kijelentkezés</a></li>');
                        if((bool)$_SESSION['admin'] === TRUE){
                            print('<li><a href="./raktar.php" class="mx-1 p-2">Raktár</a></li>');
                        }
                    } else {
                        print('<li><a href="./bejelentkezes.php" class="mx-1 p-2">Bejelentkezés</a></li>');
                    }
                    ?>
                    
                </ul>
            </div>
        </nav>
        
    </header>
    <nav class="nav" >
        <ul>
            <li class="m-1 p-3"><a href="./index.php" class="">Főoldal</a></li>
            <li class="m-1 p-3"><a href="./megjelent.php" class="">Megjelent kötetek</a></li>
            <li class="m-1 p-3"><a href="./tanfolyam.php" class="">Író tanfolyam</a></li>
            <li class="m-1 p-3"><a href="./kapcsolat.php" class="">Kapcsolat</a></li>
            <?php 
                    //ellenőrizzük, hogy a felhasználó bevan-e jelentkezve
                    //ha be van jelentkezve, akkor Kijelentkezés menüpont megjelenítése
                    //ha a felhasználó admin jogosultsággal rendelkezik Raktár menüpont megjelenítése
                    //ha nincs bejelentkezve, Bejelentkezés menüpont megjelenítése
                    if(isset($_SESSION['loggedIn']) && $_SESSION['loggedIn'] === TRUE){
                        print('<li class="m-1 p-3"><a href="./kijelentkezes.php">Kijelentkezés</a></li>');
                        if((bool)$_SESSION['admin'] === TRUE){
                            print('<li class="m-1 p-3"><a href="./raktar.php">Raktár</a></li>');
                        }
                    } else {
                        print('<li class="m-1 p-3"><a href="./bejelentkezes.php">Bejelentkezés</a></li>');
                    }
            ?>
        </ul>
    </nav>
    <section class="header-img mb-2">
        <h1 class="mx-2">Magna<br>Hungaria</h1>
    </section>
    
    <div class="container">
        <div class="row">
            <div class="error">
                <ul>
                <?php if(isset($_SESSION['hibaUzenet'])):?>
                    <?php foreach($_SESSION['hibaUzenet'] as $hiba): ?>
                        <li><?php print($hiba); ?></li>
                    <?php endforeach; ?>
                    <?php unset($_SESSION['hibaUzenet']); ?>
                <?php endif ;?>
                </ul>
            </div>
        </div>
    </div>

    <section class="container">
        <div class="row">
            <div class="ujTermekGomb">
                <button id="openUjTermekModal" class="p-3 m-2" onclick="openUjTermekModal()"><span>+</span> Új termék hozzáadása</button>
            </div>            
        </div>
    </section>
    <main class="container main">
        <div class="row">
            
                    <?php
                        require_once('adatbazis.php');
                        $termekek = new AdatbazisRendezes("localhost", "root", "", "magnahungaria");
                        $oszlopok = "id, ISBN, cim, mu_tipusa, ar, szerzo, mufaj, szinopszis, kiadas_datum";
                        $feltetel = "WHERE deleted = 0";
                        //Lapozáshoz a megjelenítendő elemek száma
                        $termekOldalankent = isset($_GET['termekOldalankent']) ? $_GET['termekOldalankent'] : 10;
                        //Aktuális oldalszám
                        $oldalSzam = isset($_GET['oldalszam']) ? $_GET['oldalszam'] : 1;
                        //Összes sor
                        $osszSor = $termekek->adatLekerdezes('termékek', 'COUNT(*) as osszSor', $feltetel);
                        $sorokSzama = $osszSor[0]['osszSor'];
                        //Lapozó rendszerhez szükséges adatok
                        $oldalakSzama = ceil($sorokSzama / $termekOldalankent);
                        $kezdoIndex = ($oldalSzam - 1) * $termekOldalankent;
                        $limit = "LIMIT $kezdoIndex, $termekOldalankent";
                        //Adatok lekérése az adatbázisból, LIMIT klauzula használatával
                        $sorok = $termekek->adatLekerdezes('termékek', $oszlopok, "$feltetel $limit");
                    ?>
            <div class="lapozo-container">
                <div class="lapozo">
                    <?php for ($i=1; $i <= $oldalakSzama; $i++): ?>
                        <a href="?oldalszam=<?= $i ?>&termekOldalankent=<?= $termekOldalankent ?>">
                        <button class="oldalszamozas <?=  ((int)$i === (int)$oldalSzam) ? "active-lapozas" : '' ?> p-1"><?php echo $i ?></button>
                        </a>
                    <?php endfor; ?>
                </div>
            </div>
            <table class="m-2">
                <thead>
                    <tr>
                        <th class="p-1">ISBN</th>
                        <th class="p-1">Cím</th>
                        <th class="p-1">Típus</th>
                        <th class="p-1">Ár</th>
                        <th class="p-1">Szerző</th>
                        <th class="p-1">Műfaj</th>
                        <th class="p-1">Szinopszis</th>
                        <th class="p-1">Kiadás dátuma</th>
                        <th class="p-1">Műveletek</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                        foreach($sorok as $sor):
                    ?>
                    <tr>
                        <td class="p-1"><?php print($sor['ISBN']) ?></td>
                        <td class="p-1"><?php print($sor['cim']) ?></td>
                        <td class="p-1"><?php print($sor['mu_tipusa']) ?></td>
                        <td class="p-1"><?php print($sor['ar']) ?>.-</td>
                        <td class="p-1"><?php print($sor['szerzo']) ?></td>
                        <td class="p-1"><?php print($sor['mufaj']) ?></td>
                        <td class="p-1 szinopszis"><?php print($sor['szinopszis']) ?></td>
                        <td class="p-1"><?php print($sor['kiadas_datum']) ?></td>
                        <td class="p-1">
                            <button onclick="openTorlesModal(); document.getElementById('torolt-termek-id').value = <?php print($sor['id']) ?>;">
                                <i class="fi-trash p-1 mx-1"></i>
                            </button>
                            <button>
                            <i class="fi-clipboard-pencil p-1 mx-1" onclick="openModositoModal(<?php print($sor['id']) ?>)"></i>
                            </button>
                        </td>
                        <?php endforeach; ?>
                    </tr>                        
                </tbody>
            </table>
            <!--Lapozó rész-->
            <div class="lapozo-container">
                <div class="lapozo">
                    <?php for ($i=1; $i <= $oldalakSzama; $i++): ?>
                        <a href="?oldalszam=<?= $i ?>&termekOldalankent=<?= $termekOldalankent ?>">
                        <button class="oldalszamozas <?=  ((int)$i === (int)$oldalSzam) ? "active-lapozas" : '' ?> p-1"><?php echo $i ?></button>
                        </a>
                    <?php endfor; ?>
                </div>
            </div>
            <!-- Rész vége -->
        </div>
    </main>
    <div class="modal-hatter"></div>
    <!--Törlés modal rész-->
    <article class="container">
        <div class="row">
            <div class="torlesModal" id="torlesModal">
                <h2>Biztosan törölni szeretné a terméket?</h2>
                <button id="btn-yes" onclick="">Igen</button>
                <button class="btn-no" onclick="closeModal()">Nem</button>
                <input type="hidden" id="torolt-termek-id">
            </div>
        </div>
    </article>
    <!-- Rész vége -->
    <!--Módosító modal rész-->
    <article class="container">
        <div class="row">
            <div class="modositoModal" id="modositoModal">
                <h2>Termék adatainak módosítása</h2>
                <form id="modosito-form" method="POST" enctype="multipart/form-data" action="update.php">
                   <input type="hidden" name="id" id="modosito-id">
                   <div>
                        <input class="m-1 p-1" type="number" name="ISBN" id="ISBN" required>
                   </div>
                   <div>
                    <input class="m-1 p-1" type="text" name="cim" id="cim" required>
                   </div>
                   <div>
                    <input class="m-1 p-1" type="text" name="mu_tipusa" id="mu_tipusa" required>
                   </div>
                   <div>
                    <input class="m-1 p-1" type="number" name="ar" id="ar" required>
                   </div>
                   <div>
                    <input class="m-1 p-1" type="text" name="szerzo" id="szerzo" required>
                   </div>
                   <div>
                    <input class="m-1 p-1" type="text" name="mufaj" id="mufaj" required>
                   </div>
                   <div>
                    <input class="m-1 p-1" type="file" name="borito" id="borito" accept=".jpg, .jpeg, .png">
                   </div>
                   <div>
                    <textarea name="szinopszis" id="szinopszis" rows="3" required></textarea>
                   </div>
                   <div>
                    <input class="m-2 p-2" type="date" name="kiadas_datum" id="kiadas_datum">
                   </div>
                   <button type="submit">Módosítás</button>                   
                </form>
                <button onclick="closeMModal()">Mégsem</button>
                </div>
        </div>
    </article>
    <!-- Rész vége -->
    <!--Új termék modal rész-->
    <article class="container">
        <div class="row">
            <div class="ujTermekModal" id="ujTermekModal">
                <h2>Új termék hozzáadása</h2>
                <form id="ujTermek-form" method="POST" enctype="multipart/form-data" action="termekHozzaadas.php">
                   <div>
                        <input class="m-1 p-1" type="number" name="ISBN" id="ISBN" placeholder="ISBN" required>
                   </div>
                   <div>
                    <input class="m-1 p-1" type="text" name="cim" id="cim" placeholder="Könyv címe" required>
                   </div>
                   <div>
                    <input class="m-1 p-1" type="text" name="mu_tipusa" id="mu_tipusa" placeholder="Kiadás típusa" required>
                   </div>
                   <div>
                    <input class="m-1 p-1" type="number" name="ar" id="ar" placeholder="Könyv ára" required>
                   </div>
                   <div>
                    <input class="m-1 p-1" type="text" name="szerzo" id="szerzo" placeholder="Mű szerzője" required>
                   </div>
                   <div>
                    <input class="m-1 p-1" type="text" name="mufaj" id="mufaj" placeholder="Könyv műfaja" required>
                   </div>
                   <div>
                    <input class="m-1 p-1" type="file" name="borito" id="borito" accept=".jpg, .jpeg, .png" required>
                   </div>
                   <div>
                    <textarea name="szinopszis" id="szinopszis" rows="3" placeholder="Szinopszis röviden" required></textarea>
                   </div>
                   <div>
                    <input class="m-2 p-2" type="date" name="kiadas_datum" id="kiadas_datum" required>
                   </div>
                   <button type="submit">Hozzáadás</button>                   
                </form>
                <button onclick="closeUModal()">Mégsem</button>
            </div>
        </div>
    </article>
    <!-- Rész vége -->








    <footer class="container-footer ">
        <div class="container">
            <div class="row">
                <div class="datas m-3 col-12 col-sm-5 col-md-5 col-lg-3 col-xl-3 col-xxl-3">
                    <h4><strong>Magna Hungaria Bt.</strong></h4>
                    <p class="m-1 p-1"><strong>Cím:</strong><br> <a href="">2800 Tatabánya, Tas vezér u. 9<br>3/12.(kaputelefon: 12) </a></p>
                    <p class="m-1 p-1"><strong>Tel:</strong><br> <a href="tel:+06903219801">06-90-321-9801</a></p>
                    <p class="m-1 p-1"><strong>E-mail:</strong><br> <a href="mailto:info@magnahungaria.hu">info@magnahungaria.hu</a></p>
                    <p class="m-1 p-1"><strong>Facebook:</strong><br> <a href="https://www.facebook.com/MagnaHungaria">/Magna Hungaria</a></p>
                </div>
                <div class="sitemap m-3 col-12 col-sm-5 col-md-5 col-lg-3 col-xl-3 col-xxl-3">
                    <h4><strong>Honlaptérkép</strong></h4>
                    <p class="m-1 p-1"><a href="./index.php"  >Főoldal</a></p>
                    <p class="m-1 p-1"><a href="./megjelent.php">Megjelent kötetek</a></p>
                    <p class="m-1 p-1"><a href="./kapcsolat.php">Kapcsolat</a></p>
                </div>
                <div class="course m-3 col-12 col-sm-5 col-md-5 col-lg-3 col-xl-3 col-xxl-3">
                    <h4><strong>Tanfolyamunk</strong></h4>
                    <p class="m-1 p-1"><a href="./tanfolyam.php">Író tanfolyam</a></p>
                </div>
                
            </div>
            <p class="text-bottom">© 2022 Magna Hungaria Bt. – Minden jog fenntartva. | <a href="">Adatkezelési tájékoztató</a></p>
        </div>
        
        
    </footer>




<script src="./main.js"></script>
</body>
</html>