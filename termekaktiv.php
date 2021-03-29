<?php
require("adminosztaly.php");

$modositandotermeknev;
$parameter;
$dbmodositas = new dbmuveletek();
$ellenorzes  = new AdminNezet();

if(isset($_SESSION['felhasznalo_nev']))
	$felhasznalonev = $_SESSION['felhasznalo_nev'];


		if($ellenorzes->BejelentkezettE()==false)
		{
		echo "<h1>Be kell jelentkezned!</h1>";
		}		
		else		
		{		
		
			//$ell = new dbmuveletek();
			
			
			if($dbmodositas->Admin_Ellenorzo($felhasznalonev)==true)
			{
		
				if(isset($_POST['modositandotermeknev']) && isset($_POST['parameter']))
				{
				$modositandotermeknev = $_POST['modositandotermeknev'];
				$parameter = $_POST['parameter'];
				
				$dbmodositas->TermekAktivArchivSet($modositandotermeknev,$parameter);
				}
			}
			else
			{
			echo "<h1>Nem sikerült a hitelesítés</h1>";		
			}
		
		}


?>
