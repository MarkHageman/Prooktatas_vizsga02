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

    <main class="container main">
        <div class="row p-3">
            <div class="col-12 col-sm-12 col-md-7 col-lg-7 col-xl-7 col-xxl-7 p-2 my-2">
                <h2 class="mb-3">A kiadó</h2>
                <p class="mb-3 main-text">Az egy éve működő Magna Hungaria kiadó eddig tizenegy könyvet jelentetett meg. Célunk a tehetséges magyar írók, költők, képregény rajzolók felkarolása, műveik előtérbe helyezése, ezzel is tovább lendítve és mélyítve a magyar irodalom méltó hírnevét.</p>
                <p class="main-text">A kiadónál vásárolt könyvekre 30% kedvezményt adunk, illetve telefonon vagy e-mailben rendelt könyveket postázzuk.</p>
            </div>
            <div class="col-12 col-sm-12 col-md-4 col-lg-4 col-xl-4 col-xxl-4">
                <img class="main-img py-2 my-3" src="./media/books.png" alt="">
            </div>
            
            <a href="./megjelent.php" class="p-3 main-button">Megjelent kötetek</a>
            
        </div>    
    </main>

    <article class="container">
        <div class="row">
            <div class="course p-4">
                <p class="p-1 my-3">A könyvkiadás mellett szeretnénk egyengetni azon alkotók útját, akik akadályba ütköztek.</p>
                <div class="course-card p-2">
                    <img src="./media/course.png" alt="">
                    <h3 class="m-1 p-2">Író tanfolyam</h3>
                    <button class="p-2"><a class="m-1" href="./tanfolyam.php">Bővebben</a></button>
                </div>
            </div>
        </div>
    </article>

    <article class="container">
        <div class="row course-info p-5">
            <div class=" col-12 col-sm-12 col-md-4 col-lg-4 col-xl-4 col-xxl-4">
                <img class="course-img my-3" src="./media/lecture_room.png" alt="">
            </div>
            <div class="col-12 col-sm-12 col-md-7 col-lg-7 col-xl-7 col-xxl-7">
                <h2>Információ a tanfolyamokról</h2>
                <p class="main-text my-2">A tanfolyamokat a tavaszai és őszi félévben (február elején és október közepén) indítjuk.</p>
                <p class="main-text my-2">A tanfolyamok indulása előtt tájékoztatót tartunk, ahol a képzés tantervét ismertetjük, részletezzük a tematikát, válaszolunk a felmerülő kérdésekre. Ekkor történik a beiratkozás is, valamint az első havi tandíj befizetése (A tanfolyamok árai az áfát tartalmazzák.)</p>
                <p class="main-text my-2">Aki a tájékoztatóról lemarad (vagy nem tud részt venni), a képzés indulásakor is beiratkozhat – ebben az eseteben kérjük, hogy részvételi szándékát telefonon vagy e-mailen jelezze.</p>
                <p class="main-text">A tanfolyamok elvégzéséről és a sikeres vizsgáról tanúsítványt állítunk ki, valamint a legjobb eredménnyel végző hallgatónak segítünk kiadni egy könyvét/vers gyűjteményét/képregényét.</p>
            </div>
        </div>
        <div class="row location m-5">
            <h2 class="col-12 col-sm-12 col-md-12 col-lg-12 col-xl-12 col-xxl-12 mb-4">A képzések és a tájékozatók helye:</h2>
            <p class="col-12 col-sm-12 col-md-12 col-lg-12 col-xl-12 col-xxl-12 mb-5">2800 Tatabánya, Tas vezér u. 9. 3/12.(kaputelefon: 12)</p>
            <div class="col-12 col-sm-12 col-md-5 col-lg-5 col-xl-5 col-xxl-5">
                <iframe class="map my-3 mx-2" src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d2690.733733542365!2d18.390174317443847!3d47.5924209!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x476a41262d519041%3A0xefc474f83b07239!2zVGF0YWLDoW55YSwgVGFzIHZlesOpciB1LiA5LCAyODAw!5e0!3m2!1shu!2shu!4v1673291930875!5m2!1shu!2shu" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
            </div>
            <div class=" col-12 col-sm-12 col-md-5 col-lg-5 col-xl-5 col-xxl-5">
                <img class="place my-3 mx-2" src="./media/place.png" alt="Tas Vezér 9.">
            </div>
        </div>
    </article>


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