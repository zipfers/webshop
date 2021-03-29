<?php
require("adminosztaly.php");

//átirányítás


$keresettfelhnev;
$keresettemail;
$keresettvaros;
$keresettnev;

if(isset($_POST['keresettfelhnev']))
	{		
	$keresettfelhnev = $_POST['keresettfelhnev'];
	}
	

if(isset($_POST['keresettemail']))
	{		
	$keresettemail = $_POST['keresettemail'];
	}
	

if(isset($_POST['keresettvaros']))
	{
	$keresettvaros = $_POST['keresettvaros'];
	}


if(isset($_POST['keresettnev']))
	{
	$keresettnev = $_POST['keresettnev'];
	}



$aladminoldaltorlmod = new AdminNezet();
$aladminoldaltorlmod->AdminFelhasznaloModTorl($siker,$keresettfelhnev,$keresettemail,$keresettvaros,$keresettnev);
?>