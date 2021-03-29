<?php
session_start();
require("weboldal.php");
$megj =  new FelhasznaloiDbMuveletek();
$fold = new Weboldal();
$kategnev = "";

if(isset($_GET['kategnev']))
	$kategnev = $_GET['kategnev'];

$kategid = $megj->kategoriaidlistazo($kategnev);

$visszajelzes = "A kategóriaszűrés eredménye: ";

$fold->Megjelenites($visszajelzes="",$aktid="",$kategid);
?>