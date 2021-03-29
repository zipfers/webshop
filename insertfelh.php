<?php
require("adminosztaly.php");
//Felhasználó beszúrásakor szolgál átirányításra
$ellenorzes = new AdminNezet();

	if($ellenorzes->BejelentkezettE()==false)
	{
	echo "<h1>Be kell jelentkezned!</h1>";
	}
	else //else ágban még kéne egy admin user lekérdezés is!
	{
	$felhasznalonev = $_SESSION['felhasznalo_nev'];
	$ell = new dbmuveletek();
	//echo "<h1>".$felhasznalonev."</h1>";
	
		if($ell->Admin_Ellenorzo($felhasznalonev)==true)
		{
		$con;
		dbconnect($con);
		$jogosultsag = $_POST['jogosultsag'];
		$jelszo      = $_POST['jelszo'];
		$felhnev     = $_POST['felhnev'];
		$veznev      = $_POST['veznev'];
		$kernev      = $_POST['kernev'];
		$orszag      = $_POST['orszag'];
		$irsz        = $_POST['irsz'];
		$varos       = $_POST['varos'];
		$utca        = $_POST['utca'];
		$hsz         = $_POST['hsz'];
		$telefon     = $_POST['telefon'];
		$email       = $_POST['email'];
		$beszuras = new dbmuveletek();
		$beszuras->felhasznalo_beszuras($jogosultsag,$jelszo,$felhnev,$veznev,$kernev,$orszag,$irsz,$varos,$utca,$hsz,$telefon,$email);
		$con->close();
		}		
		else
		{
		echo "<h1>Nem sikerült a hitelesítés</h1>";
		}	
	}	
?>