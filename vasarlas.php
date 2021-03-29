<?php
session_start();
require_once("weboldal.php");
$dbmuvelet = new FelhasznaloiDbMuveletek();
$megj = new Weboldal();
$visszajelzes = "";


if($_SESSION['kosarid']!=0)
{
	if(!$megj->IsLogin())
	{
		if(isset($_POST['veznev']) && isset($_POST['kernev']) && isset($_POST['orszag']) && isset($_POST['irsz']) && isset($_POST['varos']) && isset($_POST['utca']) && isset($_POST['hazszam'])&& isset($_POST['telefon'])&& isset($_POST['email'])&& isset($_POST['hozzajarul']))
		{
		$veznev 	= $_POST['veznev'];
		$kernev     = $_POST['kernev'];
		$orszag     = $_POST['orszag'];
		$irsz       = $_POST['irsz'];
		$varos      = $_POST['varos'];
		$utca       = $_POST['utca'];
		$hazszam    = $_POST['hazszam'];
		$telefon    = $_POST['telefon'];
		$email      = $_POST['email'];
		$hozzajarul = $_POST['hozzajarul'];	
		

			if($dbmuvelet->Nem_Regisztralt_Felh_Beszurasa($veznev,$kernev,$orszag,$irsz,$varos,$utca,$hazszam,$telefon,$email,$hozzajarul))
			{
				$kosartomb = $_SESSION['kosarid'];
				$kosarvegosszeg = $_SESSION['vegosszeg'];
				$darabszam = $_SESSION['darab'];
				
				$nemregfelhid = $dbmuvelet->nemregfelhid_lekerdezo($veznev,$kernev,$orszag,$irsz,$varos,$utca,$hazszam,$telefon,$email,$hozzajarul);
				
				//kosarid - kosár tömb!
				for($i=0;$i<sizeof($_SESSION['kosarid']);$i++)
				{

					$termekid = $_SESSION['kosarid'][$i];
					
					if($dbmuvelet->termekaktive($termekid)!=0)
					{
						if($dbmuvelet->termekdb($termekid)>2)
						{	
						$dbmuvelet->termekdbminusz($termekid); 						
						$dbmuvelet->nemregvasarlasbeszuras($nemregfelhid,$termekid);	
						}
						else 
						{						
						$dbmuvelet->termekkisetelo($termekid);						
						$dbmuvelet->nemregvasarlasbeszuras($nemregfelhid,$termekid);
						}						
					}
					else
					{
					//hogy a termék már nem elérhető.
					$tomb = array();
					$tomb = $dbmuvelet->nemaktivtermekar($termekid);
			
					$visszajelzes .= "<p class='text-danger'>Az adott termék ".$termekid. " (termékazonosító szám) már nem elérhető,időközben megvették!<br>";	
					
					$_SESSION['vegosszeg'] = $_SESSION['vegosszeg']-$tomb[0]["termekar"];					
					
					$visszajelzes .= "A ".$tomb[0]["termekcim"]." című termék nem elérhető! Sajnáljuk!";
					$visszajelzes .= "<br>A termék ára: ".$tomb[0]["termekar"]." ft volt!</p></br>";
					}					
				}
									
				$visszajelzes .= "<br><div class='alert alert-success'>Összesen: ".$_SESSION['vegosszeg']." ft. értékben vásároltál.A tájékozatót elküldtük neked email-ben az általad megadott email címre.Legközelebb regisztrálj is nálunk!</div>";
				
							
				$_SESSION['kosarid']   = 0;
				$_SESSION['vegosszeg'] = 0;
				$_SESSION['darab']     = 0;
			}
			else
			{
			echo "<p class='text-danger'>Nem sikerült a nem regisztrált felhasználó adatait beszúrni. Sikertelen SQL művelet!</p><br>";
			}
		}
		
		//Jogosulatlan 'nézelődés' hibaüzenet írás..ide később.
		
	}
	else /* Itt kezdődik az else ág , ha valaki BE van jelentkezve!! */
	{
		
			//Ha be vagyunk jelentkezve akkor SESSION fnev-et egyenlővé tesszük a beléptetett felhasználó felh. nevével.
			$felhasznalonev = $_SESSION['felhasznalo_nev'];
		
			//a 'KOSARID': A termékek ID-jét tartalmazó tömb!
			/* A tömbböl az id-ket kell lekérni,majd az adott terméket vizsgálni van e még belőle (Aktiv e), 
			ha igen és elérhető - 0-ra állítani a aktive értékét! 
			Lekérdezés - van e még , tehát több darabos , ha igen levonni egyet de ha 0 a db. szám akkor setelni a termeklapot 
			ezután beleírni a vásárlást táblába */
		
		
			$kosartomb = $_SESSION['kosarid'];
			$kosarvegosszeg = $_SESSION['vegosszeg'];
			$darabszam = $_SESSION['darab'];	
			//Végigmegyünk a kosarid-n , ez az id-ket tartalmazó tömb - egyenként egy for ciklussal.
			
			for($i=0;$i<sizeof($_SESSION['kosarid']);$i++)
			{
				
				$termekid = $_SESSION['kosarid'][$i];
					
				if($dbmuvelet->termekaktive($termekid)!=0)
				{
					if($dbmuvelet->termekdb($termekid)>2)
					{	
					$dbmuvelet->termekdbminusz($termekid);									
					$felhid = $dbmuvelet->felhidlekerdezes($felhasznalonev);				
					$dbmuvelet->vasarlasbeszuras($felhid,$termekid);					
					}
					else
					{						
					$dbmuvelet->termekkisetelo($termekid); 
					$felhid = $dbmuvelet->felhidlekerdezes($felhasznalonev);	
					$dbmuvelet->vasarlasbeszuras($felhid,$termekid);			
					}			
				}
				else
				{	
				$tomb = array();
				$tomb = $dbmuvelet->nemaktivtermekar($termekid);
				$visszajelzes .= "<p class='text-danger'>Az adott termék ".$termekid. " (termékazonosító szám) már nem elérhető,időközben megvették!<br>";			
				//$_SESSION['vegosszeg'] = $_SESSION['vegosszeg']-$tomb[0]["termekar"];						
				$visszajelzes .= "A ".$tomb[0]["termekcim"]." című termék nem elérhető! Sajnáljuk!";
				$visszajelzes .= "<br>A termék ára: ".$tomb[0]["termekar"]." ft volt!</p></br>";			
				}		
			}
	
			
			$visszajelzes .= "<div class='alert alert-success'>Összesen: ".$_SESSION['vegosszeg']." ft. értékben vásároltál.A tájékozatót elküldtük neked email-ben az általad megadott email címre.</div>";
			
			$_SESSION['kosarid']   = 0;
			$_SESSION['vegosszeg'] = 0;
			$_SESSION['darab']     = 0;	
	}




/* Kosarat beállító fgv-ek , mint az index.php-ban*/ 
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
	


	
}
$megj->Megjelenites($visszajelzes);
?>