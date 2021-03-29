<?php
session_start();
require_once("weboldal.php");

//Ez a kosárba tételt elvégző fájl a neve kosar.php
$ell = new FelhasznaloiDbMuveletek();
$megj = new Weboldal();


/* kosarat 'indító' kód , mint index.php-ban */
if($_SESSION['kosarid'] != 0)
	$_SESSION['kosarid'] = $_SESSION['kosarid'];
else
{
$_SESSION['kosarid'] = array();
$_SESSION['vegosszeg'] = 0;
}


if($_SESSION['darab'] != 0)	
	$_SESSION['darab'] = $_SESSION['darab'];
else
{
$_SESSION['darab'] = 0;
$_SESSION['vegosszeg'] = 0;
}
	



// Kosárból törlés!
if(isset($_POST['torlesrevarloid']))
{
$torlesrevarloid = "";
$torlesrevarloid = $ell->termekid($_POST['torlesrevarloid']); //Egyenlővé lehet tenni lekérdezés nélkül.
$kivonandoar = $ell->termekar($torlesrevarloid);

$_SESSION['darab']--;


$keresettindex = array_search("$torlesrevarloid",$_SESSION['kosarid']);
unset($_SESSION['kosarid'][$keresettindex]);
$_SESSION['kosarid'] = array_values($_SESSION['kosarid']); 
//újra kell indexelni a tömböt mert hibát dob.
$visszajelzes = "<p class='alert alert-danger'>Törölted a tételt  a kosárból!</p>";
if(empty($_SESSION['kosarid']))
	$_SESSION['vegosszeg'] = 0;

$megj->KosarTartalmaMegjelenites($visszajelzes);
}

	 
  
//Kosárba tétel!
if(isset($_POST['kosarid'])) 
{	
$kimentett_termekid = $ell->termekid($_POST['kosarid']);	

//Vizsgálni kell a kimentett_termekid -t hogy szerepel e már a SESSION tömbben! Ha nem akkor belemehet, ha igen hiba!
$vane = in_array($kimentett_termekid,$_SESSION['kosarid']);

	
	if($vane)
	{
	$visszajelzes = "<p class='alert alert-danger'>A termékből csak egy db-ot tehetsz a korasadba!</p>";
	}
	else
	{	
	array_push($_SESSION['kosarid'],$kimentett_termekid);
	$_SESSION['darab']++;
	$visszajelzes = "<p class='alert alert-primary'>Sikeresen bekerült a kosaradba a termék!</p>";
	}
		
$megj->Megjelenites($visszajelzes); 
}	


// Kosár teljes ürítése!
if(isset($_POST['kosarurites']))
{
$_SESSION['kosarid'] = 0;
$_SESSION['darab'] = 0;	
$_SESSION['vegosszeg'] = 0;
$visszajelzes = "<p class='alert alert-danger'>Törölted az összes tételed a kosárból!</p>";
$megj->KosarTartalmaMegjelenites($visszajelzes);
}

?>