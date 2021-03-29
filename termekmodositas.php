<?php
require("adminosztaly.php");

//Átirányító oldal a termék módosítás oldalon megjelenítő kereső mezőkhöz.

$keresettcim;
$keresettar;
$keresettmennyiseg;
$keresettdatum;

if(isset($_POST['keresettcim']))
{
$keresettcim = $_POST['keresettcim'];	
}

if(isset($_POST['keresettar']))
{
$keresettar = $_POST['keresettar'];	
}

if(isset($_POST['keresettmennyiseg']))
{
$keresettmennyiseg = $_POST['keresettmennyiseg'];
}

if(isset($_POST['keresettdatum']))
{
$keresettdatum = $_POST['keresettdatum'];
}


$termekmodosito = new AdminNezet();
$termekmodosito->AdminAlTermekModosito($siker,$keresettcim,$keresettar,$keresettmennyiseg,$keresettdatum);

?>