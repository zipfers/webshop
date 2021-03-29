<?php
require("adminosztaly.php");

//Ha poston átvesz régi/uj kategória nevet akkor lép be , ellenőrzi a bemenetet és meghívja módosítást. 
//HA nem vesz át , csak megjelenít.

if(isset($_POST['regikategorianev']) && isset($_POST['ujkategorianev']))
	{	
	$ellenorzo = new funkciok();
	
	$regikategorianev = $_POST['regikategorianev'];
	$ujkategorianev = $_POST['ujkategorianev'];
	
	$ellenorzo->bemenet_ellenorzes($ujkategorianev);
	$ellenorzo->sql_tamadas($ujkategorianev);
	
	$kategoriamodosito = new dbmuveletek();
	$kategoriamodosito->kategoriamodositasdb($regikategorianev,$ujkategorianev);
	
	}
else
{
$kategoriamodosito = new AdminNezet();
$kategoriamodosito->AdminAlKategoriaModositas($siker);
}

?>