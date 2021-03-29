<?php
require("adminosztaly.php");
/*A Konkrét termék módosítás átirányítója! Itt még csak beleírja a mezőkbe az adatokat.
A speciális karakterek levágása a DB függvényben történik meg!
A Termék módosítás és törlés opciók átirányítása PHP fájl:
Ez csak akkor hívódik ha a termékkeresésben , a 4 kereső mezőből bármlyikben kerestünk valamit.*/

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
		{
			$megjelenito = new AdminNezet();
			$mod = new funkciok(); //Karakter ellenőrzés miatt hívjuk meg
			$dbmodositas = new dbmuveletek();
			$modositandotermeknev;
			
			if(isset($_POST['modositandotermeknev']))
			{
			$modositandotermeknev = $_POST['modositandotermeknev'];
			$mod->sql_tamadas($modositandotermeknev);
			$mod->bemenet_ellenorzes($modositandotermeknev);
			$megjelenito->AdminAlTermekModositoMegjelenito($siker,$modositandotermeknev);
			}
			
	
			
			$termekcim;
			$termekar;
			$leiras;
			$termekkulcsszavak;
			$termekdarab;
			$modositasraszantermekcim;
			$aktive;
			if(isset($_POST['termekcim']) && isset($_POST['termekar']) && isset($_POST['leiras']) && isset($_POST['termekkulcsszavak']) && isset($_POST['termekdarab']) && isset($_POST['modositasraszantermekcim']) && isset($_POST['aktive']))
			{
			$termekcim				  =  $_POST['termekcim'];
			$termekar                 =  $_POST['termekar']; 
			$leiras                   =  $_POST['leiras']; 
			$termekkulcsszavak        =  $_POST['termekkulcsszavak']; 
			$termekdarab              =  $_POST['termekdarab']; 
			$modositasraszantermekcim =  $_POST['modositasraszantermekcim']; 
			$aktive					  =  $_POST['aktive'];
			$dbmodositas = new dbmuveletek();
			$dbmodositas->TermekModositoDB($termekcim,$termekar,$leiras,$termekkulcsszavak,$termekdarab,$modositasraszantermekcim,$aktive);	
			}
		
		
			$torlendonev;
			if(isset($_POST['torlendonev']))
			{
			$torlendonev = $_POST['torlendonev'];	
			$dbmodositas->TermekTorloDB($torlendonev);
			}
		
		}
	}
	else
	{
	echo "<h1>Nem sikerült a hitelesítés</h1>";	
	}
}
?>