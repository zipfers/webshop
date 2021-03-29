<?php
require("adminosztaly.php");
//Átirányítás a felhasználó kereső oldalról, ahol ha a 'felhasználó törlése' gombra kattintunk hozza post-on a 'torlendonev'-et.


$ellenorzes = new AdminNezet();

if($ellenorzes->BejelentkezettE()==false)
{
echo "<h1>Be kell jelentkezned!</h1>";
}
else
{
$felhasznalonev = $_SESSION['felhasznalo_nev'];
$ell = new dbmuveletek();


	if($ell->Admin_Ellenorzo($felhasznalonev)==true)
	{
	$torlendonev;
		
		if(isset($_POST['torlendonev']))
		{		
		$torlendonev = $_POST['torlendonev'];
		}
		
	$felhasznalotorlmod = new dbmuveletek();
	$felhasznalotorlmod->felhasznalotorles($torlendonev);
	}
	else
	{
	echo "<h1>Nem sikerült a hitelesítés</h1>";	
	}
}

?>

