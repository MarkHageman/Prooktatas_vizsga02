# Prooktatas_vizsga02

Első körben létrehoztam egy 'AdatbazisRendezes()' osztályt, ami különböző adatbázis kezelő metódusokat használ, ezeket tesztelgettem, majd a hibák kijavítása után szerintem működő képessé is tettem.



Második körben, az osztály metódus segítségével létrehoztam különböző táblákat, ebből az egyiket a 'termekek.csv' fájlból fel is töltöttem.



Harmadik körben, a 'megjelent.php' oldal tartalmát az adatbázisból lekért adatokkal feltöltöttem, minden terméknél elhelyeztem egy 'Részletek' linket, ami a 'konyv.php' oldalra mutat, ahol az adott termék részletes adatait jelennek meg, annak függvényében, melyik terméknél kattintottunk rá, ezeket az adatokat a 'termékek' táblából kéri le.



Negyedik körben, létrehoztam a 'bejelentkezes.php' , 'kijelentkezes.php' és 'regisztracio.php' oldalakat.

A 'Bejelentkezés' oldalon, a form a 'login.php' fájlra mutat, ahol az adatbázisból lekért adatokat összehasonlítottam, a formba beírt adatokkal, mind felhasználó névvel, mind pedig e-mail címmel lehetséges a bejelenekezés. Ezen kívül a session-ök kulcsának megfelelő értéket adtam, hogy elmentsem a felhasználó bejelentkezését, plusz ellenőriztem a lekért adatok alapján, hogy az adott felhasználó admin-e. Az oldal ezek alapján jeleníti meg a 'Bejelentkezés', 'Kijelentkezés' és 'Raktár' menü pontokat.

A 'kijelentkezes.php' fájlban a 'session_unset()' és 'session_destroy()' függvényekkel, kiürítettem és megszüntettem a munkamenetet, majd 'header()' függvénnyel átirányítás történik az 'index.php' oldalra.

A 'Regisztráció' form-ja a 'regist.php'-ra mutat, ahol első körben az 'adatLekerdezes()' metódussal lekérem a táblában szereplő felhasználóneveket és e-mail címeket, amennyiben nincs találat és a '$_SESSION['hibaUzenet'] üres, az beírt adatokat az 'adatBevitel()' metódussal hozzáfűzöm a 'felhasznalok' táblához, majd a felhasználót átirányítom a 'bejelentkezes.php' oldalra.



Az ötödik és egyben utolsó körben, létrehoztam a 'raktar.php' oldalt, ahol igyekeztem a CRUD rendszer alapján megvalósítani az oldal működését.

Először létrehoztam egy táblázatot, amit az 'adatLekerdezes()' metódussal feltöltöttem, ezzel szimultán létrehoztam egy pagination-t a táblázat tetején és alján, az oldalon egyszerre maximum tíz táblázat sor jelenik meg, ha annál több terméket kérünk le az adatbázisból, akkor létrejön egy másik oldal, ahol további maximum tíz termék jelenhet meg egyszerre.

Ezután létrehoztam egy törlés gombot, ami az 'onlclick' eseménykezelőn keresztül, javascript-ben az 'XMLHTTpRequest()' objektumot használva, 'id' alapján lekéri a törölni kívánt termék adatait, majd a 'torles.php' fájlon keresztül, az adatbázis táblában a 'deleted' oszlop értékét '1'-re állítja.

Ezt az adatok módosítása funkció követte. A Módosítás gombra kattintva, egy 'onclick' eseménykezelő indul, ami az 'XMLHTTpRequest()' objektumon keresztül megjeleníti az adott termék adatait a modalon feltűnő űrlapon, amiben a 'modaladatok.php' fájl végzi az adatok lekérdezését az 'adatLekerdezes()' metódust használva. A rekordok frissítése az 'update.php' fájlon keresztül történik,  a 'sorFrissitese()' metódus használatával.

Végül jött az új termékek hozzáadása funkció, az 'Új termék hozzáadása' gombra kattintva, megjelenik egy modal, benne egy form amibe az új termék adatait hozzáfűzi az adattáblához, a 'termekHozzaadas.php' fájlon keresztül, az 'adatBevitel()' metódust használva.
