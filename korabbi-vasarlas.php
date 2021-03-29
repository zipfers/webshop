<?php
session_start();
require_once("weboldal.php");

$dbmuvelet = new FelhasznaloiDbMuveletek();
$megj = new Weboldal();
$visszajelzes = "";


if($megj->IsLogin())
{
	if(isset($_POST['felhid']))
	{
	$felhid = $_POST['felhid'];
	}
	else
	{	
	$felhid = $dbmuvelet->felhidlekerdezes($_SESSION['felhasznalo_nev']);
	}

$megj->MegjelenitesUres($visszajelzes,$felhid);
}
else
{
echo "Jogosulatlan hozzáférés!";	
}

?>