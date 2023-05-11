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
                    <li><a href="./bejelentkezes.php" class="mx-1 p-2">Bejelentkezés</a></li>
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
        </ul>
    </nav>
    <section class="header-img mb-2">
        <h1 class="mx-2">Magna<br>Hungaria</h1>
    </section>

    <main class="container main">
        <div class="row p-3">
            <div class="loginRegist">
                <form action="regist.php" method="post">
                    <?php if(isset($_SESSION['hibaUzenet'])):?>
                        <p class="p-2 m-2"><?php echo $_SESSION['hibaUzenet']?></p>
                        <?php unset($_SESSION['hibaUzenet']) ?>
                    <?php endif; ?>
                    <div>
                        <input class="m-3 p-2" type="text" name="felhasznalo" id="felhasznalo" placeholder="Felhasználó név" required>
                    </div>
                    <div>
                        <input class="m-3 p-2" type="email" name="email" id="email" placeholder="E-mail cím" required>
                        <input class="m-3 p-2" type="email" name="email_megerosites" id="email_megerosites" placeholder="E-mail cím megerősítése" required>
                    </div>
                    <div>
                        <input class="m-3 p-2" type="password" name="jelszo" id="jelszo" placeholder="Jelszó" required>
                        <input class="m-3 p-2" type="password" name="jelszo_megerosites" id="jelszo_megerosites" placeholder="Jelszó megerősítése" required>
                    </div>
                    <div>
                        <input class="m-3 p-2" type="checkbox" name="aszf" id="aszf" required>
                        <label class="m-3 p-2" for="aszf">Elolvastam és elfogadom az Általános Szerződési Feltételeket.</label>
                    </div>
                    <div>
                        <input class="m-3 p-2" type="checkbox" name="hirlevel" id="hirlevel">
                        <label class="m-3 p-2" for="hirlevel">Feliratkozom a hírlevélre.</label>
                    </div>
                    <div>
                        <button class="m-3 p-2" type="submit">Regisztráció</button>
                    </div>
                </form>
            </div>
        </div>
    </main>





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