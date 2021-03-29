<?php
require("adminosztaly.php");
//Átirányító oldal a felhasználó kereső és módosító oldalról, POST-on kapjuk a módosítandó nevet.
//a modosito.php lehetne usermodosito.php is , uutalva arra hogy a user adatait módosítjuk vele.


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

		if(isset($_POST['modositandonev']))
		{
		$modositandonev = $_POST['modositandonev'];
		}
	
		$proba = new AdminNezet();
		$proba->AdminAlFelhasznaloModositoMegjelenito($siker,$modositandonev);
		  
	}
	else
	{
	echo "<h1>Nem sikerült a hitelesítés</h1>";		
	}
}

?>