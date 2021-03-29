<?php
//A felhasználó felületről belépett felhasználót regisztráló, vagy annak adatait módosító fájl
//átirányító fájl.
require_once("weboldal.php");
session_start();
$ellenorzes = new FelhasznaloiDbMuveletek();
$ell 		= new Weboldal();

$con;
dbconnect($con);
	
	//IF Ág igaz rész akkor ha nincs bejelentkezve,akkor regisztrációra készülünk.
	if($ell->IsLogin()==false)
	{

	$jogosultsag = 3;
	$jogosultsag = $ellenorzes->Ellenorzo($jogosultsag);

	if(isset($_POST['jelszo']))
	{
	$jelszo      = $_POST['jelszo'];
	$jelszo		 = $ellenorzes->Ellenorzo($jelszo);
	$jelszo 	 = sha1($jelszo);	
	}
	
	
	
	if(isset($_POST['jelszoujra']))
	{
	$jelszoujra  = $_POST['jelszoujra'];
	$jelszoujra  = $ellenorzes->Ellenorzo($jelszoujra);
	$jelszoujra  = sha1($jelszoujra);
	}
	
	
	
	if(isset($_POST['felhnev']))
	{
	$felhnev     = $_POST['felhnev'];
	$felhnev 	 = $ellenorzes->Ellenorzo($felhnev);		
	}
	
	
	if(isset($_POST['veznev']))
	{
	$veznev      = $_POST['veznev'];
	$veznev 	 = $ellenorzes->Ellenorzo($veznev);
	}
	
	if(isset($_POST['kernev']))
	{
	$kernev      = $_POST['kernev'];
	$kernev 	 = $ellenorzes->Ellenorzo($kernev);
	}
	
	if(isset($_POST['orszag']))
	{
	$orszag      = $_POST['orszag'];
	$orszag		 = $ellenorzes->Ellenorzo($orszag);
	}
	
	if(isset($_POST['irsz']))
	{
	$irsz        = $_POST['irsz'];
	$irsz 		 = $ellenorzes->Ellenorzo($irsz);	
	}
	
	
	if(isset($_POST['varos']))
	{
	$varos       = $_POST['varos'];
	$varos 		 = $ellenorzes->Ellenorzo($varos);
	}
	
	if(isset($_POST['utca']))
	{
	$utca        = $_POST['utca'];	
	$utca 		 = $ellenorzes->Ellenorzo($utca);
	}
	
	if(isset($_POST['hsz']))
	{
	$hsz         = $_POST['hsz'];
	$hsz 		 = $ellenorzes->Ellenorzo($hsz);
	}
	
	if(isset($_POST['telefon']))
	{
	$telefon     = $_POST['telefon'];
	$telefon 	 = $ellenorzes->Ellenorzo($telefon);
	}
	
	if(isset($_POST['email']))
	{
	$email       = $_POST['email'];
	$email  	 = $ellenorzes->Ellenorzo($email);
	}
	
	
	//Felhasználó saját adatait beszúró függvény.
	if(isset($_POST['jelszo']) || isset($_POST['jelszoujra']) || isset($_POST['felhnev']) || isset($_POST['veznev']) || isset($_POST['kernev']) ||isset($_POST['orszag']) ||isset($_POST['irsz']) || isset($_POST['varos']) || isset($_POST['utca']) || isset($_POST['hsz']) || isset($_POST['telefon']) || isset($_POST['email']))
		{
		
		$ellenorzes->Felhasznalo_Regisztralasa($jogosultsag,$jelszo,$jelszoujra,$felhnev,$veznev,$kernev,$orszag,$irsz,$varos,$utca,$hsz,$telefon,$email);
		}
	
	
	}
	else
	{ 
	//Módosításhoz kell! a Session FElh név: Ha már módosítunk , akkor átvesszük  
	//A jogosultságot semmi módon át sem vesszünk,mert ha admin volt akkor sem és
	//ha felhasználói szintet sem lehet módosítani.
	//$jogosultsag = $_POST['jogosultsag'];
	$felhasznalonev = $_SESSION['felhasznalo_nev'];
	
	
	$jelszo      = $_POST['jelszo'];
	$jelszo		 = $ellenorzes->Ellenorzo($jelszo);
	//$jelszo 	 = sha1($jelszo);
	
	$jelszoujra  = $_POST['jelszoujra'];
	$jelszoujra  = $ellenorzes->Ellenorzo($jelszoujra);
	//$jelszoujra  = sha1($jelszoujra);
	
	$felhnev     = $_POST['felhnev'];
	$felhnev 	 = $ellenorzes->Ellenorzo($felhnev);
	$veznev      = $_POST['veznev'];
	$veznev 	 = $ellenorzes->Ellenorzo($veznev);
	$kernev      = $_POST['kernev'];
	$kernev 	 = $ellenorzes->Ellenorzo($kernev);
	$orszag      = $_POST['orszag'];
	$orszag		 = $ellenorzes->Ellenorzo($orszag);
	$irsz        = $_POST['irsz'];
	$irsz 		 = $ellenorzes->Ellenorzo($irsz);
	$varos       = $_POST['varos'];
	$varos 		 = $ellenorzes->Ellenorzo($varos);
	$utca        = $_POST['utca'];
	$utca 		 = $ellenorzes->Ellenorzo($utca);
	$hsz         = $_POST['hsz'];
	$hsz 		 = $ellenorzes->Ellenorzo($hsz);
	$telefon     = $_POST['telefon'];
	$telefon 	 = $ellenorzes->Ellenorzo($telefon);
	$email       = $_POST['email'];
	$email  	 = $ellenorzes->Ellenorzo($email);
		
	//Felhasználó adatainak módosítása függvény,ha be van jelentkezve.
	$ellenorzes->Belepett_felhasznalo_modositasa($felhasznalonev,$jelszo,$jelszoujra,$felhnev,$veznev,$kernev,$orszag,$irsz,$varos,$utca,$hsz,$telefon,$email);
	}		
		


$con->close();
?>