<?php
session_start();
require_once("weboldal.php");

$ell = new FelhasznaloiDbMuveletek();
$megj = new Weboldal();

/* A kosárban a véglegesítés gombra kattintva jön ez fájl be. HA érkezett valami , meghívja a regisztrálás nélküli fgv-t */ 
if(isset($_POST['megrendeles']) && $_SESSION['kosarid'])
	$megj->RegNelkulVasarlasMegj();	


if(!$_SESSION['kosarid'])
{	
$visszajelzes = "<p class='alert alert-danger font-weight-bold'>Nincs a kosaradban semmi,nem tudod folytatni a rendelést!</p>";	
$megj->KosarTartalmaMegjelenites($visszajelzes);	
}


?>