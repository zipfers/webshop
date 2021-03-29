<?php
session_start();
require("weboldal.php");
$kezdooldal = new Weboldal();


if($kezdooldal->IsLogin())
	$_SESSION['felhasznalo_nev'];


if(isset($_SESSION['kosarid']) != 0)
	$_SESSION['kosarid'] = $_SESSION['kosarid'];
else
{
$_SESSION['kosarid'] = array();
$_SESSION['vegosszeg'] = 0;
}


if(isset($_SESSION['darab']) != 0)	
	$_SESSION['darab'] = $_SESSION['darab'];
else
{
$_SESSION['darab'] = 0;
$_SESSION['vegosszeg'] = 0;
}
	

$kezdooldal->Megjelenites();
?>


