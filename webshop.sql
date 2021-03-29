-- phpMyAdmin SQL Dump
-- version 5.0.2
-- https://www.phpmyadmin.net/
--
-- Gép: 127.0.0.1
-- Létrehozás ideje: 2021. Már 29. 16:01
-- Kiszolgáló verziója: 10.4.13-MariaDB
-- PHP verzió: 7.4.7

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Adatbázis: `webshop`
--

-- --------------------------------------------------------

--
-- Tábla szerkezet ehhez a táblához `felhasznalok`
--

CREATE TABLE `felhasznalok` (
  `felhid` int(6) UNSIGNED NOT NULL,
  `jog` tinyint(1) UNSIGNED NOT NULL,
  `jelszo` char(40) NOT NULL,
  `felhnev` char(30) NOT NULL,
  `veznev` varchar(50) NOT NULL,
  `kernev` varchar(50) NOT NULL,
  `orsz` varchar(40) DEFAULT NULL,
  `irsz` varchar(10) DEFAULT NULL,
  `varos` varchar(50) DEFAULT NULL,
  `utca` varchar(60) DEFAULT NULL,
  `hsz` varchar(30) DEFAULT NULL,
  `telefon` varchar(20) DEFAULT NULL,
  `email` varchar(80) DEFAULT NULL,
  `regdatum` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- A tábla adatainak kiíratása `felhasznalok`
--

INSERT INTO `felhasznalok` (`felhid`, `jog`, `jelszo`, `felhnev`, `veznev`, `kernev`, `orsz`, `irsz`, `varos`, `utca`, `hsz`, `telefon`, `email`, `regdatum`) VALUES
(255, 1, 'd033e22ae348aeb5660fc2140aec35850c4da997', 'admin', 'admin', 'admin', 'admin', 'admin', 'admin', 'admin', 'admin', 'admin', 'admin@admin.hu', '2021-03-29 15:59:25');

-- --------------------------------------------------------

--
-- Tábla szerkezet ehhez a táblához `kategoria`
--

CREATE TABLE `kategoria` (
  `kategoriaid` smallint(5) UNSIGNED NOT NULL,
  `kategorianev` varchar(40) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- A tábla adatainak kiíratása `kategoria`
--

INSERT INTO `kategoria` (`kategoriaid`, `kategorianev`) VALUES
(2, 'Reklámplakát'),
(44, 'Papírpénz'),
(45, 'Retró Műszaki cikk'),
(46, 'Régi Mobiltelefon'),
(48, 'Fénykép'),
(52, 'Szakkönyv'),
(53, 'Bakelit lemez'),
(54, 'Filatélia'),
(55, 'Numizmatika'),
(56, 'Dedikált könyvek'),
(59, 'Régi Autóalkatrész'),
(60, 'Személyautó'),
(61, 'Festmények'),
(62, 'Egyéb gyűjtői tárgyak'),
(63, 'Különleges tárgyak'),
(64, 'Filmplakát'),
(70, 'Órák'),
(71, 'Retró bútorok');

-- --------------------------------------------------------

--
-- Tábla szerkezet ehhez a táblához `regnelkulfelhasznalok`
--

CREATE TABLE `regnelkulfelhasznalok` (
  `nemregfelhid` int(6) UNSIGNED NOT NULL,
  `veznev` varchar(50) NOT NULL,
  `kernev` varchar(50) NOT NULL,
  `orsz` varchar(40) DEFAULT NULL,
  `irsz` varchar(10) DEFAULT NULL,
  `varos` varchar(50) DEFAULT NULL,
  `utca` varchar(60) DEFAULT NULL,
  `hsz` varchar(30) DEFAULT NULL,
  `telefon` varchar(20) DEFAULT NULL,
  `email` varchar(80) DEFAULT NULL,
  `hozzajarul` tinyint(1) UNSIGNED NOT NULL,
  `datum` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- A tábla adatainak kiíratása `regnelkulfelhasznalok`
--

INSERT INTO `regnelkulfelhasznalok` (`nemregfelhid`, `veznev`, `kernev`, `orsz`, `irsz`, `varos`, `utca`, `hsz`, `telefon`, `email`, `hozzajarul`, `datum`) VALUES
(87, 'regisztralasnelkuli', 'regisztralasnelkuli', 'regisztralasnelkuli', 'regisztral', 'regisztralasnelkuli', 'regisztralasnelkuli', 'regisztralasnelkuli', 'regisztralasnelkuli', 'regisztralasnelkuli@regisztralasnelkuli.hu', 1, '2020-11-22 18:37:49'),
(88, 'Teszt', 'Vásárló', 'Magyarország', '1081', 'Budapest', 'Falus', '22. II/4', '06205212345', 'tesztelek@tesztelek.hu', 1, '2020-12-01 23:41:24');

-- --------------------------------------------------------

--
-- Tábla szerkezet ehhez a táblához `termeklap`
--

CREATE TABLE `termeklap` (
  `termekid` int(8) UNSIGNED NOT NULL,
  `aktive` tinyint(1) UNSIGNED NOT NULL,
  `termekcim` char(120) NOT NULL,
  `termekar` int(10) UNSIGNED DEFAULT NULL,
  `leiras` text DEFAULT NULL,
  `kulcssz` char(80) DEFAULT NULL,
  `darab` int(3) UNSIGNED DEFAULT NULL,
  `feltoltdatum` datetime DEFAULT NULL,
  `kategelh` smallint(5) UNSIGNED DEFAULT NULL,
  `img1` varchar(100) DEFAULT NULL,
  `img2` varchar(100) DEFAULT NULL,
  `img3` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- A tábla adatainak kiíratása `termeklap`
--

INSERT INTO `termeklap` (`termekid`, `aktive`, `termekcim`, `termekar`, `leiras`, `kulcssz`, `darab`, `feltoltdatum`, `kategelh`, `img1`, `img2`, `img3`) VALUES
(300, 1, 'Jedi visszatér plakát', 30000, 'Jedi visszatér plakát', 'moziplakát,filmplakát,poszter', 13, '2020-09-06 23:39:39', 2, 'ujkonyvtar/300/48.jpg', 'ujkonyvtar/300/114.jpg', 'ujkonyvtar/300/jedi.jpg'),
(301, 1, 'Moziplakátok olcsón 3 db', 2000, 'Moziplakátok olcsón 3 db', 'moziplakát,filmplakát,poszter', 10, '2020-09-06 23:40:15', 2, 'ujkonyvtar/301/1449525036-i17ukxxo7kgdznqu8fb7.jpg', 'ujkonyvtar/301/robotzsaru.jpg', 'ujkonyvtar/301/Sivatagi show.jpg'),
(302, 1, 'Vaskorona Rend III. Osztály Jelzett Arany Kitüntetés', 650000, 'Vaskorona Rend III. Osztály Jelzett Arany Kitüntetés', 'kitüntetés,érem,jelvény', 1, '2020-09-06 23:40:50', 55, 'ujkonyvtar/302/v01 másolata.jpg', 'ujkonyvtar/302/v01.jpg', 'ujkonyvtar/302/v03.jpg'),
(303, 1, 'Katonák fényképei', 100000, 'Katonák fényképei', 'militária,katona,kitüntetés', 1, '2020-09-06 23:42:01', 48, 'ujkonyvtar/303/1160.jpg', 'ujkonyvtar/303/Bartha Károly.jpg', 'ujkonyvtar/303/DSCN5937.jpg'),
(304, 1, 'Robert De Niro Filmes Fotók', 4000, 'Robert De Niro Filmes Fotók , 3 db', 'moziplakát,filmplakát,poszter', 1, '2020-09-06 23:43:01', 48, 'ujkonyvtar/304/beolvasás0002.jpg', 'ujkonyvtar/304/beolvasás0004.jpg', 'ujkonyvtar/304/beolvasás0005.jpg'),
(305, 1, 'Bud Spencer moziképek egyben', 4000, 'Bud Spencer moziképek egyben', 'moziplakát,filmplakát,poszter', 1, '2020-09-06 23:43:54', 48, 'ujkonyvtar/305/beolvasás0053.jpg', 'ujkonyvtar/305/beolvasás0054.jpg', 'ujkonyvtar/305/beolvasás0056.jpg'),
(306, 1, 'Rubik Ernő Gyűjtemény , plakátok', 43000, 'Rubik Ernő Gyűjtemény , plakátok', 'moziplakát,filmplakát,poszter', 1, '2020-09-06 23:44:48', 2, 'ujkonyvtar/306/IMG_9278.JPG', 'ujkonyvtar/306/IMG_9283.JPG', 'ujkonyvtar/306/IMG_9286.JPG'),
(307, 1, 'Kultfilmek moziplakátja 3 db', 70000, 'Kultfilmek moziplakátja 3 db', 'moziplakát,filmplakát,poszter', 1, '2020-09-06 23:45:35', 2, 'ujkonyvtar/307/IMG_8766.JPG', 'ujkonyvtar/307/IMG_8783.JPG', 'ujkonyvtar/307/IMG_8824.JPG'),
(308, 1, 'Maximális karakter száma Maximális karakter száma Maximális karakter száma Maximális karakter száma Maximális karakter', 50000, 'karaktermaxikaraktermaxikaraktermaxikaraktermaxikaraktermaxikaraktermaxikaraktermaxikaraktermaxikaraktermaxikaraktermaxikaraktermaxikaraktermaxikaraktermaxikaraktermaxikaraktermaxikaraktermaxikaraktermaxikaraktermaxikaraktermaxikaraktermaxikaraktermaxikaraktermaxikaraktermaxikaraktermaxikaraktermaxikaraktermaxikaraktermaxikaraktermaxikaraktermaxikaraktermaxikaraktermaxikaraktermaxikaraktermaxikaraktermaxikaraktermaxikaraktermaxikaraktermaxikaraktermaxikaraktermaxikaraktermaxikaraktermaxikaraktermaxikaraktermaxikaraktermaxikaraktermaxikaraktermaxikaraktermaxikaraktermaxikaraktermaxikaraktermaxi', 'nyolcvankarekterekekaaaaa,nyolcvankarekterekekaaaaa,nyolcvankarekterekekaaaaaaaa', 10, '2020-09-07 00:33:50', 48, 'ujkonyvtar/308/ternegg.jpg', 'ujkonyvtar/308/vitéz Torontály Imre.jpg', 'ujkonyvtar/308/Wetaschek - 1930.jpg'),
(309, 1, 'Trainspotting Moziplakát', 50000, 'Trainspotting Moziplakát', 'moziplakát,filmplakát,poszter', 1, '2020-09-07 18:08:03', 2, 'ujkonyvtar/309/20190828_183320.jpg', 'ujkonyvtar/309/20191025_095444.jpg', 'ujkonyvtar/309/20191025_095450.jpg'),
(311, 1, 'Magyar köztársasági Sportérdemérem kitüntetés 1947', 120000, 'Magyar köztársasági Sportérdemérem kitüntetés 1947', 'kitüntetés,érem,jelvény', 1, '2020-09-07 21:30:40', 55, 'ujkonyvtar/311/DSCN3822.JPG', 'ujkonyvtar/311/DSCN3825.JPG', 'ujkonyvtar/311/DSCN3826.JPG'),
(312, 1, 'Remek Máltai Sör és Táj', 400000, 'Remek Máltai Sör és Táj', 'utazás,sör,kikapcsolódás', 3, '2020-09-07 21:32:21', 62, 'ujkonyvtar/312/20171017_144615.jpg', 'ujkonyvtar/312/20171017_162035.jpg', 'ujkonyvtar/312/20171017_162339.jpg'),
(315, 1, 'Birodalom Visszavág moziplakát (Mokép)', 180000, 'Birodalom Visszavág moziplakát (Mokép).\r\nEredeti , hajtott , jó állapotban.\r\n', 'csillagok háborúja,moziplakát,poszter', 1, '2020-09-22 00:28:09', 2, 'ujkonyvtar/315/1.JPG', 'ujkonyvtar/315/2.JPG', 'ujkonyvtar/315/3.JPG'),
(316, 1, 'Rákosi korszak kiváló dolgozó kitüntetései , három darab. Műszaki Kiváló Dolgozó, Szakma Kiváló Dolgozója , Könnyűipar', 5000, 'Rákosi korszak kiváló dolgozó kitüntetései , három darab. Műszaki Kiváló Dolgozó, Szakma Kiváló Dolgozója , Könnyűipar', 'kitüntetés,érem,jelvény', 1, '2020-09-23 00:47:21', 55, 'ujkonyvtar/316/IMG_2195.JPG', 'ujkonyvtar/316/IMG_2197.JPG', 'ujkonyvtar/316/IMG_2199.JPG'),
(317, 1, 'Híres hollywood-i filmszínészeket bemutató korabeli eredeti mozis vitrinfényképek, mozis kirakatfotók, hivatalos kiadás!', 10000, 'Híres hollywood-i filmszínészeket bemutató korabeli eredeti mozis vitrinfényképek, mozis kirakatfotók, hivatalos kiadás!\r\nHíres hollywood-i filmszínészeket bemutató korabeli eredeti mozis vitrinfényképek, mozis kirakatfotók, hivatalos kiadás!\r\nHíres hollywood-i filmszínészeket bemutató korabeli eredeti mozis vitrinfényképek, mozis kirakatfotók, hivatalos kiadás!\r\nHíres hollywood-i filmszínészeket bemutató korabeli eredeti mozis vitrinfényképek, mozis kirakatfotók, hivatalos kiadás!\r\nHíres hollywood-i filmszínészeket bemutató korabeli eredeti mozis vitrinfényképek, mozis kirakatfotók, hivatalos kiadás!\r\nHíres hollywood-i filmszínészeket bemutató korabeli eredeti mozis vitrinfényképek, mozis kirakatfotók, hivatalos kiadás!\r\nHíres hollywood-i filmszínészeket bemutató korabeli eredeti mozis vitrinfényképek, mozis kirakatfotók, hivatalos kiadás!\r\nHíres hollywood-i filmszínészeket bemutató korabeli eredeti mozis vitrinfényképek, mozis kirakatfotók, hivatalos kiadás!\r\nHíres hollywood-i filmszínészeket bemutató korabeli eredeti mozis vitrinfényképek, mozis kirakatfotók, hivatalos kiadás!\r\nHíres hollywood-i filmszínészeket bemutató korabeli eredeti mozis vitrinfényképek, mozis kirakatfotók, hivatalos kiadás!\r\nHíres hollywood-i filmszínészeket bemutató korabeli eredeti mozis vitrinfényképek, mozis kirakatfotók, hivatalos kiadás!\r\nHíres hollywood-i filmszínészeket bemutató korabeli eredeti mozis vitrinfényképek, mozis kirakatfotók, hivatalos kiadás!', 'moziplakát,filmplakát,poszter', 3, '2020-09-29 23:22:06', 48, 'ujkonyvtar/317/beolvasás0008.jpg', 'ujkonyvtar/317/beolvasás0012.jpg', 'ujkonyvtar/317/Vissza a jövőbe 001.jpg'),
(318, 1, 'Kitüntetés Adományozó Okiratok a Rákosi korból', 9800, 'Szép és jó , mint én , mint te , fáradt vagyok értelmes szöveghez.\r\n', 'kitüntetés,érem,jelvény', 3, '2020-10-05 23:48:52', 55, 'ujkonyvtar/318/Kossuth Érdemrend II.jpg', 'ujkonyvtar/318/MNK arany.jpg', 'ujkonyvtar/318/MNK BRONZ.jpg'),
(319, 1, 'Álom Luxuskivitelben plakát', 50000, 'Álom Luxuskivitelben plakát', 'plakát,moziplakát', 1, '2020-10-22 23:56:13', 64, 'ujkonyvtar/319/IMG_20201020_002244.jpg', 'ujkonyvtar/319/IMG_20201020_002249.jpg', 'ujkonyvtar/319/IMG_20201020_002313.jpg'),
(320, 1, 'Retró Motorkerékpár', 780000, 'Retró Motorkerékpár, működő állapotban. Megkímélt , itt ott javításra szorul.', 'Motorkerékpár,Veteránautó,Jármű', 1, '2020-10-25 13:56:31', 59, 'ujkonyvtar/320/20190912triumph-bd-250-w-veteran.jpg', 'ujkonyvtar/320/20190912triumph-bd-250-w-veteran17.jpg', 'ujkonyvtar/320/unnamed.jpg'),
(321, 1, 'Helényi Tibor Monokróm Star Wars - Csillagok Háborúja Plakátok az 1990-es évekből', 300000, 'Helényi Tibor Monokróm Star Wars - Csillagok Háborúja Plakátok az 1990-es évekből. Kalózmásolatként készültek , nagyon ritkák.', 'moziplakát,filmplakát,poszter', 1, '2020-10-31 00:40:47', 2, 'ujkonyvtar/321/hunesbaformon.jpg', 'ujkonyvtar/321/hunrotjaformon.jpg', 'ujkonyvtar/321/hunswaformona3.jpg'),
(322, 1, 'Magyar Népköztársaság Zászlórendjének minitűrje szalagsávon', 40000, 'Magyar Népköztársaság Zászlórendjének minitűrje szalagsávon. Eredeti , adományozott példány.', 'kitüntetés,érem,jelvény', 1, '2020-10-31 00:42:26', 55, 'ujkonyvtar/322/IMG_2018.JPG', 'ujkonyvtar/322/IMG_2019.JPG', 'ujkonyvtar/322/IMG_2020.JPG'),
(323, 1, 'Régi Működő Svájci Karóra az 1960-as évekből', 12000, 'Működik,  pontos , 12 köves , jó állapotban.', 'Óra,Zsebóra,Karóra', 1, '2020-10-31 00:43:57', 70, 'ujkonyvtar/323/IMG_1239.JPG', 'ujkonyvtar/323/IMG_1240.JPG', 'ujkonyvtar/323/IMG_1241.JPG'),
(324, 1, 'West Side Story című film eredeti magyar kiadású moziplakátja az 1960-as évekből', 85000, '60 x 40 cm-es , eredeti offset nyomat , hajtott , a sarkainál tű nyomok vannak.', 'moziplakát,filmplakát,poszter', 1, '2020-10-31 00:45:12', 2, 'ujkonyvtar/324/IMG_20201020_002409.jpg', 'ujkonyvtar/324/IMG_20201020_002416.jpg', 'ujkonyvtar/324/IMG_20201020_002421.jpg'),
(325, 1, 'Szárnyas Fejvadász moziplakát 1988', 160000, '60 x 80 cm-es , hajtatlan , szép állapotban.', 'moziplakát,filmplakát,poszter', 1, '2020-10-31 00:47:15', 64, 'ujkonyvtar/325/IMG_6381.JPG', 'ujkonyvtar/325/IMG_6382.JPG', 'ujkonyvtar/325/IMG_6383.JPG'),
(326, 1, 'Mozis vitrinfényképek híres színészekkel 4 db összen az 1980-as évekből', 12000, '24x18 cm-sek , eredeti 1980-as évekbeli nyomatok.', 'filmfotó,mozifotó,színészek,hollywood', 2, '2020-10-31 00:48:48', 48, 'ujkonyvtar/326/20191107_233059.jpg', 'ujkonyvtar/326/20191107_233105.jpg', 'ujkonyvtar/326/20191107_234358.jpg'),
(327, 1, 'Opel Astra H Caravan Enjoy 1.6 Benzin', 1450000, 'Tulajdonostól eladó megkímélt Opel Asra H kombi. Magyarországi autó, garázsban tartott, nem dohányzó! Szervizkönyv, törzskönyv, vonóhorog, elektromos ablak, elektromos tükrök, klíma, cd-s autórádió, multikormány, tempomat stb. Az autó decemberben nagy szervizen esett át: olaj csere, szűrők, első lengőkarok, fékbetét, féktárcsák kerültek kicserélésre az Opel Tormásinál. Az autó költség mentes!', 'autó,gépjármű,kocsi', 1, '2020-10-31 00:51:35', 60, 'ujkonyvtar/327/Opel_Astra_H_Caravan_Enjoy_1_6_Benzin_521191791512158.jpg', 'ujkonyvtar/327/Opel_Astra_H_Caravan_Enjoy_1_6_Benzin_523491791511993.jpg', 'ujkonyvtar/327/Opel_Astra_H_Caravan_Enjoy_1_6_Benzin_527771791511992.jpg'),
(328, 1, 'Halálosztó Terminátor Filmes plakát , moziplakát', 40000, 'Admin Teszt Termék', 'moziplakát,filmplakát,poszter', 1, '2020-11-10 00:45:13', 64, 'ujkonyvtar/328/114.jpg', 'ujkonyvtar/328/0126.jfif', 'ujkonyvtar/328/0183.jfif'),
(329, 1, 'Versenyautó , Grand Prix műsorfüzet', 30000, 'Versenyautó , Grand Prix műsorfüzet', 'Autóverseny,Veteránjármű,Sport', 1, '2020-11-10 00:47:37', 52, 'ujkonyvtar/329/beolvasás0031.jpg', 'ujkonyvtar/329/beolvasás0032.jpg', 'ujkonyvtar/329/beolvasás0033.jpg'),
(330, 1, 'Jamboree Cserkészettel kapcsolatos antik zsebkönyv gyűjtőknek', 2000, 'Jamboree Cserkészettel kapcsolatos antik zsebkönyv gyűjtőknek', 'könyv,szakkönyv,cserkész', 1, '2020-11-15 23:02:44', 52, 'ujkonyvtar/330/beolvasás0001.jpg', 'ujkonyvtar/330/beolvasás0002.jpg', 'ujkonyvtar/330/beolvasás0003.jpg'),
(331, 1, 'Régi Zsebóra', 10000, 'Régi Zsebóra, jó állapotban.', 'óra,zsebóra', 1, '2020-11-15 23:04:32', 70, 'ujkonyvtar/331/IMG_1186.JPG', 'ujkonyvtar/331/IMG_1187.JPG', 'ujkonyvtar/331/IMG_1188.JPG'),
(332, 1, 'Első Világháborús Sapkajelvényt ábrázoló tábori postai levelezőlap', 4000, 'Első Világháborús Sapkajelvényt ábrázoló tábori postai levelezőlap', 'Első világháború,képeslap,sapkajelvény', 2, '2020-11-17 23:12:10', 62, 'ujkonyvtar/332/beolvasás0011.jpg', '', ''),
(333, 1, 'Torpedó beemelés a hajóba , első világháborús fénykép', 5000, 'Torpedó beemelés a hajóba , első világháborús fénykép', 'Első világháború,képeslap,sapkajelvény', 1, '2020-11-17 23:21:13', 62, 'ujkonyvtar/333/beolvasás0009.jpg', '', ''),
(334, 1, 'Csokoládpapír , retró 1960-as évek', 1500, 'Csokoládpapír , retró 1960-as évekCsokoládpapír , retró 1960-as évekCsokoládpapír , retró 1960-as évekCsokoládpapír , retró 1960-as évekCsokoládpapír , retró 1960-as évekCsokoládpapír , retró 1960-as évekCsokoládpapír , retró 1960-as évekCsokoládpapír , retró 1960-as évekCsokoládpapír , retró 1960-as évekCsokoládpapír , retró 1960-as évekCsokoládpapír , retró 1960-as évekCsokoládpapír , retró 1960-as évekCsokoládpapír , retró 1960-as évekCsokoládpapír , retró 1960-as évekCsokoládpapír , retró 1960-as évekCsokoládpapír , retró 1960-as évekCsokoládpapír , retró 1960-as évekCsokoládpapír , retró 1960-as évekCsokoládpapír , retró 1960-as évekCsokoládpapír , retró 1960-as évek', 'Csokoláde', 1, '2020-11-17 23:27:02', 62, 'ujkonyvtar/334/beolvasás0038.jpg', '', ''),
(337, 1, '3 db mozifilmes fénykép , kirakatfénykép', 5000, '3 db mozifilmes fénykép , kirakatfénykép', 'mozis kirakatfényképek', 1, '2020-11-19 00:19:46', 48, 'ujkonyvtar/337/beolvasás0018.jpg', 'ujkonyvtar/337/beolvasás0019.jpg', 'ujkonyvtar/337/beolvasás0020.jpg'),
(338, 1, 'Régi Kultfilmek Mozis fényképei', 3000, '20x12 cm-sek , jó állapotuak.', 'moziplakát,filmplakát,poszter', 1, '2020-11-19 00:21:50', 48, 'ujkonyvtar/338/beolvasás0027.jpg', 'ujkonyvtar/338/beolvasás0032.jpg', 'ujkonyvtar/338/beolvasás0033.jpg'),
(339, 1, 'Mozifilmek kirakatfényképi , vitrinfényképei', 20000, 'mozikép,kultfilm', 'moziplakát,filmplakát,poszter', 1, '2020-11-19 00:23:28', 48, 'ujkonyvtar/339/beolvasás0010.jpg', 'ujkonyvtar/339/beolvasás0013.jpg', 'ujkonyvtar/339/beolvasás0014.jpg'),
(343, 1, 'Két darab moziplakát', 12000, 'Két darab moziplakát', 'Két darab moziplakát', 1, '2020-11-19 22:24:14', 2, 'ujkonyvtar/343/71486293_647955115728123_2029294145243185152_n.jpg', 'ujkonyvtar/343/71492822_1754416184690093_4715939799712661504_n.jpg', ''),
(344, 1, 'Commodore 64 Számítógép', 15000, 'Retrobright,C64,Commodore', 'Retró,C64,Számítógép', 1, '2020-11-22 20:34:15', 45, 'ujkonyvtar/344/IMG_20201108_165024.jpg', 'ujkonyvtar/344/IMG_20201108_172653.jpg', 'ujkonyvtar/344/IMG_20201108_185134.jpg'),
(345, 1, 'Régi Papírpénzek , Ritka Pengő Bankjegyek', 15000, 'Régi Papírpénzek , Ritka Pengő Bankjegyek.\r\nJó állapotban, eredeti bankjegyek.', 'Numizmatika,Papírpénz,Pénz', 1, '2020-11-30 01:06:14', 44, 'ujkonyvtar/345/HUP_5_1926_obverse.jpg', 'ujkonyvtar/345/HUP_100MB_1946_obverse.jpg', 'ujkonyvtar/345/HUP_1000MB_1946_obverse.jpg'),
(346, 1, 'Régi Forint Bankjegyek , ritkaságok', 120000, 'Régi Forint Bankjegyek , ritkaságok. Jó tartásban.', 'Numizmatika,Papírpénz,Pénz', 1, '2020-11-30 01:08:28', 44, 'ujkonyvtar/346/66e2bdea1fdfe93a96c47813be2f652b.jpg', 'ujkonyvtar/346/1947._10_forint_aunc_a.jpg', 'ujkonyvtar/346/1995._5000_forint_k_a.jpg'),
(348, 1, 'Nokia 3310-es Retró Mobiltelefon', 5000, 'Nokia 3310-es Retró Mobiltelefon ', 'Retró,Mobiltelefon,Maroktelefon', 1, '2020-11-30 01:16:41', 46, 'ujkonyvtar/348/1_20_64290140.jpg', 'ujkonyvtar/348/maxresdefault.jpg', 'ujkonyvtar/348/s-l300.jpg'),
(349, 1, 'C#, PHP Programozási szakkönyvek', 8500, 'C#, PHP Programozási szakkönyvek , olvasott állapotban.', 'Szakkönyv,Programozás,PHP', 1, '2020-11-30 01:50:14', 52, 'ujkonyvtar/349/823882_5.jpg', 'ujkonyvtar/349/854341_4.jpg', 'ujkonyvtar/349/887332_5.jpg'),
(350, 1, 'Süsü a Sárkány Bakelit LP Hanglemez', 3000, 'Süsü a Sárkány Bakelit LP Hanglemez', 'Bakelit,LP,Hanglemez', 1, '2020-11-30 01:53:00', 53, 'ujkonyvtar/350/f779.jpg', 'ujkonyvtar/350/letöltés.jfif', 'ujkonyvtar/350/s4_a_k.jpg'),
(351, 1, 'Ritka Magyar Bélyegek', 650000, '3 db. Ritka Magyar Bélyeg. Eredetiek', 'Filatélia,Bélyeg,Posta', 1, '2020-11-30 01:55:47', 54, 'ujkonyvtar/351/220px-NewspaperStampHungary1868Michel_I.jfif', 'ujkonyvtar/351/arató.jpg', 'ujkonyvtar/351/belyeg.jpg'),
(352, 1, 'Arany János Dedikált könyve , igaz ritkaság', 1500000, 'Arany János Dedikált könyve , igaz ritkaság', 'Dedikált,Könyv,Antik', 1, '2020-11-30 01:58:24', 56, 'ujkonyvtar/352/01.jpg', 'ujkonyvtar/352/arany_toldi_dedikacio_kartya.jpg', 'ujkonyvtar/352/IMG_0011.jpg'),
(353, 1, 'Feszty Árpád - Körkép című festmény', 500000000, 'Feszty Árpád - Körkép című festmény. Védett nemzeti műkincs.', 'Festmény,Feszty,Védett', 1, '2020-11-30 02:58:49', 61, 'ujkonyvtar/353/Arpadfeszty.jpg', 'ujkonyvtar/353/bridge.jfif', 'ujkonyvtar/353/feszty-korkep-opusztaszer-csodalatosmagyarorszag-latogatokozpont.jpg');

-- --------------------------------------------------------

--
-- Tábla szerkezet ehhez a táblához `vasarlas`
--

CREATE TABLE `vasarlas` (
  `vasarlasid` int(10) UNSIGNED NOT NULL,
  `felhid` int(6) UNSIGNED DEFAULT NULL,
  `nemregfelhid` int(6) UNSIGNED DEFAULT NULL,
  `termekid` int(8) UNSIGNED DEFAULT NULL,
  `vasarlasdatum` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Indexek a kiírt táblákhoz
--

--
-- A tábla indexei `felhasznalok`
--
ALTER TABLE `felhasznalok`
  ADD PRIMARY KEY (`felhid`);

--
-- A tábla indexei `kategoria`
--
ALTER TABLE `kategoria`
  ADD PRIMARY KEY (`kategoriaid`);

--
-- A tábla indexei `regnelkulfelhasznalok`
--
ALTER TABLE `regnelkulfelhasznalok`
  ADD PRIMARY KEY (`nemregfelhid`);

--
-- A tábla indexei `termeklap`
--
ALTER TABLE `termeklap`
  ADD PRIMARY KEY (`termekid`),
  ADD KEY `kategelh` (`kategelh`);

--
-- A tábla indexei `vasarlas`
--
ALTER TABLE `vasarlas`
  ADD PRIMARY KEY (`vasarlasid`),
  ADD KEY `felhid` (`felhid`),
  ADD KEY `termekid` (`termekid`),
  ADD KEY `nemregfelhid` (`nemregfelhid`);

--
-- A kiírt táblák AUTO_INCREMENT értéke
--

--
-- AUTO_INCREMENT a táblához `felhasznalok`
--
ALTER TABLE `felhasznalok`
  MODIFY `felhid` int(6) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=256;

--
-- AUTO_INCREMENT a táblához `kategoria`
--
ALTER TABLE `kategoria`
  MODIFY `kategoriaid` smallint(5) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=72;

--
-- AUTO_INCREMENT a táblához `regnelkulfelhasznalok`
--
ALTER TABLE `regnelkulfelhasznalok`
  MODIFY `nemregfelhid` int(6) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=89;

--
-- AUTO_INCREMENT a táblához `termeklap`
--
ALTER TABLE `termeklap`
  MODIFY `termekid` int(8) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=354;

--
-- AUTO_INCREMENT a táblához `vasarlas`
--
ALTER TABLE `vasarlas`
  MODIFY `vasarlasid` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=393;

--
-- Megkötések a kiírt táblákhoz
--

--
-- Megkötések a táblához `termeklap`
--
ALTER TABLE `termeklap`
  ADD CONSTRAINT `termeklap_ibfk_1` FOREIGN KEY (`kategelh`) REFERENCES `kategoria` (`kategoriaid`);

--
-- Megkötések a táblához `vasarlas`
--
ALTER TABLE `vasarlas`
  ADD CONSTRAINT `vasarlas_ibfk_1` FOREIGN KEY (`felhid`) REFERENCES `felhasznalok` (`felhid`),
  ADD CONSTRAINT `vasarlas_ibfk_3` FOREIGN KEY (`termekid`) REFERENCES `termeklap` (`termekid`),
  ADD CONSTRAINT `vasarlas_ibfk_4` FOREIGN KEY (`nemregfelhid`) REFERENCES `regnelkulfelhasznalok` (`nemregfelhid`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
