-- --------------------------------------------------------
-- Hoszt:                        127.0.0.1
-- Szerver verzió:               8.0.32 - MySQL Community Server - GPL
-- Szerver OS:                   Win64
-- HeidiSQL Verzió:              12.3.0.6589
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8 */;
/*!50503 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;


-- Adatbázis struktúra mentése a magnahungaria.
CREATE DATABASE IF NOT EXISTS `magnahungaria` /*!40100 DEFAULT CHARACTER SET utf8mb3 */ /*!80016 DEFAULT ENCRYPTION='N' */;
USE `magnahungaria`;

-- Struktúra mentése tábla magnahungaria. felhasznalok
CREATE TABLE IF NOT EXISTS `felhasznalok` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `felhasznalonev` varchar(50) NOT NULL,
  `jelszo_hash` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `hirlevel_feliratkozas` tinyint(1) NOT NULL DEFAULT '0',
  `jogosultsag_id` int NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  UNIQUE KEY `felhasznalonev` (`felhasznalonev`),
  UNIQUE KEY `email` (`email`),
  KEY `fk_jogosultsag_id` (`jogosultsag_id`),
  CONSTRAINT `fk_jogosultsag_id` FOREIGN KEY (`jogosultsag_id`) REFERENCES `szerepkorok` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=21 DEFAULT CHARSET=utf8mb3;

-- Tábla adatainak mentése magnahungaria.felhasznalok: ~3 rows (hozzávetőleg)
INSERT INTO `felhasznalok` (`id`, `felhasznalonev`, `jelszo_hash`, `email`, `hirlevel_feliratkozas`, `jogosultsag_id`) VALUES
	(0, 'admin', '$2y$12$ebk/Vw98CuzJFfOLP9stBu67A7FW2Y9SGfupOHlHah1OTtsm1ld32', 'admin@example.com', 0, 1),
	(19, 'Zohan', '$2y$12$tHCKelkHDomFYqIXKyfaZOZEmcdUhU7WOZjt3EMjBQW.5vPmogCaa', 'neSzorakozz@zohannal.com', 0, 0),
	(20, 'BolomBika', '$2y$12$2LlQkhRRAcRqb5BhsebXAOeoohrV5mGhKwBUfX4sQxh.nXA4oKPPC', 'bolombika96@gmail.com', 1, 0);

-- Struktúra mentése tábla magnahungaria. szerepkorok
CREATE TABLE IF NOT EXISTS `szerepkorok` (
  `id` int NOT NULL,
  `nev` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

-- Tábla adatainak mentése magnahungaria.szerepkorok: ~2 rows (hozzávetőleg)
INSERT INTO `szerepkorok` (`id`, `nev`) VALUES
	(0, 'user'),
	(1, 'admin');

-- Struktúra mentése tábla magnahungaria. termékek
CREATE TABLE IF NOT EXISTS `termékek` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `ISBN` int NOT NULL,
  `cim` varchar(100) NOT NULL,
  `mu_tipusa` varchar(100) NOT NULL,
  `ar` int NOT NULL,
  `szerzo` varchar(50) NOT NULL,
  `mufaj` varchar(100) NOT NULL,
  `borito` varchar(100) NOT NULL,
  `szinopszis` text NOT NULL,
  `kiadas_datum` date NOT NULL,
  `deleted` tinyint(1) DEFAULT '0',
  PRIMARY KEY (`id`),
  UNIQUE KEY `ISBN` (`ISBN`)
) ENGINE=InnoDB AUTO_INCREMENT=44 DEFAULT CHARSET=utf8mb3;

-- Tábla adatainak mentése magnahungaria.termékek: ~12 rows (hozzávetőleg)
INSERT INTO `termékek` (`id`, `ISBN`, `cim`, `mu_tipusa`, `ar`, `szerzo`, `mufaj`, `borito`, `szinopszis`, `kiadas_datum`, `deleted`) VALUES
	(29, 1984570, 'A túlsó part', 'Regény', 3290, 'Magyari András', 'Történelmi', './img/a_hid.png', 'Egy anya az egyetlen életben maradt gyermekével próbál átkelni a Dunán a második világháború alatt, hogy eljussanak a menekülttáborba nyugaton. Mindenáron életben akarja tartani a gyermekét, miközben retteg, hogy az orosz katonák markaiban végzi.', '2022-03-24', 0),
	(30, 82692670, 'A következő nap', 'Regény', 3590, 'Szép Annamária', 'Kaland, túlélés', './img/a_kovetkezo_nap.png', 'Egy magyar harcos, miután elkeveredett a törzsétől, napi szinten küzd a túlélésért a sztyeppén. Egyre jobban gyengül, miközben körülötte folyamatosan zajlik a harc az állatokkal és a természettel.', '2023-01-05', 0),
	(31, 49565730, 'A mező hangjai', 'Verses kötet', 3290, 'Deák Ágoston', 'Lírai', './img/a_mezo_hangjai.png', 'Seregben álltunk, fegyverrel a kézben,<br>Nap mint nap az életünkért küzdve,<br>Ám most itt állok, egy réten legeltetek,<br>Nyájam őrzése közben, békességre lelek.', '2022-05-01', 0),
	(32, 2097380, 'Báthory Erzsébet', 'Regény', 2590, 'Magyari András', 'Thriller', './img/bathory.png', 'Báthory Erzsébet, a hírhedt sorozatgyilkos fiatal lányok után vadászik, miközben azon töpreng, vajon tényleg van-e ennek az egésznek értelme. Ennek ellenére folytatja a rituáléit, de hibát vét.', '2022-07-01', 0),
	(33, 58153010, 'Csodaszarvas', 'Regény', 5290, 'Kovács Réka', 'Kaland, fantasy', './img/csodaszarvas.png', 'Hunor és Magor rábukkannak a csodaszarvasra, amely megmutatja nekik az utat, melyet a magyaroknak kell követniük. A két testvér küldetése azonban nem könnyű, hiszen az emberek nem hisznek nekik, és a természet viszontagságainak is ki vannak téve.', '2022-10-30', 0),
	(34, 76328230, 'Emese álma', 'Regény', 4290, 'Kovács Réka', 'Fantasy', './img/emese_alma.png', 'Egy varázsló meglátogatja Emesét egy éjszaka, a nő ellenkezése ellenére teherbe ejti őt, erről pedig elveszi az emlékeit. Mikor Emese ráeszmél, hogy várandós, rejtegetni próbálja, de sikertelenül. A férj és a sámán hűtlenséggel vádolja Emesét, de a Turul madár áldásával meggyőzi őket arról, hogy ártatlan.', '2023-01-25', 0),
	(35, 14316210, 'Fekete sereg', 'Képregény', 3290, 'Sörétes Dénes', 'Sötét fantasy, kaland', './img/fekete_sereg.png', 'Mátyás király zsoldos serege meglehetősen híres volt a környéken. Egy fiatal, de ambiciózus fiú is csatlakozni akart a sereghez, hogy hírnevet szerezzen magának. Azonban egyedül nem jutott semmire, így egy kiöregedett lovag, Kálmán segítségét kérte. Kálmán felajánlotta neki, hogy megtanítja a harcra és a katonai taktikákra, hogy a fiú végül beteljesítse álmait és bekerüljön Mátyás király zsoldos seregébe.', '2022-08-21', 0),
	(36, 85485670, 'Magyar királyok', 'Regény', 6290, 'Magyari András', 'Történelmi', './img/magyar_kiralyok.png', 'A magyar Árpád-ház története és bukása, nagy alakjaik ráhatása a történelemre. Az uralkodók küzdelmei az ellenségeikkel és a belső konfliktusaikkal, miközben megpróbálják megőrizni a hatalmat és az országukat.', '2022-08-10', 0),
	(37, 80036320, 'Pilvax', 'Képregény', 3290, 'Sörétes Dénes', 'Detektív', './img/pilvax.png', 'Petőfi Sándor 1848-ban, a Pilvax kávéházban mielőtt maga köré gyűjtötte az embereket, meg kellett küzdeni a természet felettivel. Ki vagy inkább mi az a sötét entitás, aki fiatal lányokat mészárol le, vajon el lehet őt kapni a következő áldozat meggyilkolása előtt? Mária nyomora bukkan, de nem tudja kihez forduljon.', '2022-07-04', 0),
	(38, 74179130, 'S lőn világosság', 'Regény', 4290, 'Horváth Lilla', 'Sötét fantasy', './img/s_lon_vilagossag.png', 'Aranyapó álomba kényszerítésével a magyarok élete teljesen megváltozott. A törzsek egymás ellen fordultak, mind eközben egy sötét árnyék borult a világra. A történetek szerint az Ördög egy tréfával elaltatta Aranyapót, és így nem állíthatja őt meg senki. Azonban egy fiatal harcos, Koppány, úgy dönt, hogy útra kell és ha a világfát is kell megmásznia, de felébreszti Aranyapót.', '2022-11-17', 0),
	(39, 54004090, 'Aquincum', 'Képregény', 3590, 'Sörétes Dénes', 'Detektív, thriller', './img/szechenyi.png', 'Bár a vámpírt elkapták, de a szabadságharc leverése és Budapest elfoglalása után egy árny leselkedik az ártatlanokra a holdtalan éjszakákon. Mária különös képességei és titka egyre nagyobb aggodalomra adnak okot, félelme, hogy megszűnt embernek lenni, lehet igaznak bizonyul. A szabadságharc leverése, szerelme halála és az önmagától való félelem közben, vajon képes lesz rá, hogy megmentse az ártatlanokat?', '2023-02-01', 0),
	(40, 1938372, 'Tihany', 'Verses kötet', 4060, 'Tihanyi Róbert', 'Lírai', './img/tihany.png', 'Versek Tihany szépségéről.', '2023-04-16', 0);

/*!40103 SET TIME_ZONE=IFNULL(@OLD_TIME_ZONE, 'system') */;
/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IFNULL(@OLD_FOREIGN_KEY_CHECKS, 1) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40111 SET SQL_NOTES=IFNULL(@OLD_SQL_NOTES, 1) */;
