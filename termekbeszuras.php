<?php
require("adminosztaly.php");

//termék beszúrásakor szolgál átirányításra.
//Termékbeszúerásnál kötelezzük minden mező kitöltésére hogy mindenképp kapjon valamit POST-on, ettől még a DB-be nem lenne kötelező írni.
//Sikerült kiváltani a termekfelvitel.php-t! Az már nincs használva
$con;
dbconnect($con);

if(isset($_POST['termekar'])&& isset($_POST['termekleiras'])&& isset($_POST['termekkulcsszavak'])&& isset($_POST['termekdarab'])&& isset($_POST['termekcim'])&& isset($_POST['valasztottkategoria']))
{
$termekar = $_POST['termekar']; 	
$termekleiras = $_POST['termekleiras'];	
$termekkulcsszavak = $_POST['termekkulcsszavak']; 	
$termekdarab = $_POST['termekdarab'];	
$termekcim = $_POST['termekcim'];
$termekkategoria = $_POST['valasztottkategoria'];	
$fajlatvitel = new funkciok();
$filename = $fajlatvitel->fajl_feltolto();
$beszuras = new dbmuveletek();
$siker = $beszuras->termek_beszuras($termekar,$termekleiras,$termekkulcsszavak,$termekdarab,$termekcim,$termekkategoria,$filename);
}
	
	
$megjelenes = new AdminNezet();
$megjelenes->AdminTermekBeszuras($siker);
				
$con->close();
?>