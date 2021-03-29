<?php
require("adminosztaly.php");
//Átirányításra szolgál a felhasználó adatainak módosításakor.


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
		
			$mod = new funkciok();
			$modosito = new dbmuveletek();
			$modositandonev;
		
			if(isset($_POST['modositandonev']))
			{
			$modositandonev = $_POST['modositandonev'];
			$mod->sql_tamadas($modositandonev);
			$mod->bemenet_ellenorzes($modositandonev);
			}
		
			$jogosultsag;
			$jelszo;
			$felhnev;
			$veznev;
			$kernev;
			$orszag;
			$irsz;
			$varos;
			$utca;
			$hsz;
			$telefon;
			$email;
		
			if($modositandonev == true)
			{
			
				if(isset($_POST['jogosultsag']))
				{		
				$jogosultsag = $_POST['jogosultsag'];
				$mod->sql_tamadas($jogosultsag);
				$mod->bemenet_ellenorzes($jogosultsag);
				}
			
				if(isset($_POST['jelszo']))
				{		
				$jelszo = $_POST['jelszo'];
				$mod->sql_tamadas($jelszo);
				$mod->bemenet_ellenorzes($jelszo);
				}
				
				if(isset($_POST['felhnev']))
				{		
				$felhnev = $_POST['felhnev'];
				$mod->sql_tamadas($felhnev);
				$mod->bemenet_ellenorzes($felhnev);
				}
				
				if(isset($_POST['veznev']))
				{		
				$veznev = $_POST['veznev'];
				$mod->sql_tamadas($veznev);
				$mod->bemenet_ellenorzes($veznev);
				}
				
				if(isset($_POST['kernev']))
				{		
				$kernev = $_POST['kernev'];
				$mod->sql_tamadas($kernev);
				$mod->bemenet_ellenorzes($kernev);
				}
				
				if(isset($_POST['orszag']))
				{		
				$orszag = $_POST['orszag'];
				$mod->sql_tamadas($orszag);
				$mod->bemenet_ellenorzes($orszag);
				}
				
				if(isset($_POST['irsz']))
				{		
				$irsz = $_POST['irsz'];
				$mod->sql_tamadas($irsz);
				$mod->bemenet_ellenorzes($irsz);
				}
				
				if(isset($_POST['varos']))
				{		
				$varos = $_POST['varos'];
				$mod->sql_tamadas($varos);
				$mod->bemenet_ellenorzes($varos);
				}
				
				if(isset($_POST['utca']))
				{		
				$utca = $_POST['utca'];
				$mod->sql_tamadas($utca);
				$mod->bemenet_ellenorzes($utca);
				}
				
				if(isset($_POST['hsz']))
				{		
				$hsz = $_POST['hsz'];
				$mod->sql_tamadas($hsz);
				$mod->bemenet_ellenorzes($hsz);
				}
				
				if(isset($_POST['telefon']))
				{		
				$telefon = $_POST['telefon'];
				$mod->sql_tamadas($telefon);
				$mod->bemenet_ellenorzes($telefon);
				}
				
				if(isset($_POST['email']))
				{		
				$email = $_POST['email'];
				$mod->sql_tamadas($email);
				$mod->bemenet_ellenorzes($email);
				}
				
			//$jogosultsag mezőt kivettem,mert a menetközbeni jog. módosítás hibát okozott,és a belépett felhasználót kidobta.
			$modosito->felhasznalo_osszes_adat_modosito($modositandonev,$jelszo,$felhnev,$veznev,$kernev,$orszag,$irsz,$varos,$utca,$hsz,$telefon,$email);
			}
		}
		else
		{
		"<h1>Be kell jelentkezned!</h1>";
		}
	}


?>