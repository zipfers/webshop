<?php
session_start();
require_once("weboldal.php");

$dbmuvelet = new FelhasznaloiDbMuveletek();
$megj = new Weboldal();
$visszajelzes = "";
$tomb;


//Ha vizsgált változó létezik és nem null. Ha POST átadott akkor 1 a keresomezo értéke.
if(isset($_POST['keresomezo']))
{	
	
	$keresomezo = $_POST['keresomezo'];

	//Ez esetben van értelme vizsgálni hogy bármi más jött e post-on.
	if(isset($_POST['valaszto']))
	{
	$valaszto = $_POST['valaszto'];
	$valaszto = (int)$valaszto;
	}
	
	if(isset($_POST['cim']))
			$cim = $_POST['cim'];
	
	if(isset($_POST['min']))
		$min = $_POST['min'];
	
	if(isset($_POST['max']))
		$max = $_POST['max'];
	
	if(isset($_POST['kulcsszo']))
		$kulcsszo = $_POST['kulcsszo'];
			
	if(isset($_POST['valasztottkategoria']))
		$valasztottkategoria = $_POST['valasztottkategoria'];

	

		
	//1 /* HA nincs bejelentkezve és eladott terméket akar keresni */
		if($megj->IsLogin() == false && $valaszto == 0)
		{
		$visszajelzes = "<div class='alert alert-warning'>Eladott termékeket nem nézhetsz meg ,ahhoz be kell jelentkezned!</div>";
		$megj->MegjelenitesKeresoMezok($visszajelzes,$aktid="",$tomb="");
		}
	//2	/* Aktív termékek keresése mehet ha nincs bejelentkezve! */
		elseif($megj->IsLogin() == false && $valaszto == 1)
		{
		
			
			
		
		if($valasztottkategoria!=0)
		{
		$tomb = $dbmuvelet->termekkereses($valaszto,$cim,$min,$max,$kulcsszo,$valasztottkategoria);	
		}
		
		
		if($kulcsszo!="")
		{
		$tomb = $dbmuvelet->termekkereses($valaszto,$cim,$min,$max,$kulcsszo,$valasztottkategoria);		
		}
		
		
		if($max>$min)
		{	
		$tomb = $dbmuvelet->termekkereses($valaszto,$cim,$min,$max);		
		}
		
		if($min!=0)
		{
		$tomb = $dbmuvelet->termekkereses($valaszto,$cim,$min);		
		}
		
		if(isset($cim) && $cim!="")
		{	
		$tomb = $dbmuvelet->termekkereses($valaszto,$cim);
		}
	
		
		$db = count($tomb);
		$visszajelzes = "<div class='alert alert-success'>Az eredményhez görgess le hogy megnézd a(z) ".$db." találatot.</div>";
		$megj->MegjelenitesKeresoMezok($visszajelzes,$aktid="",$tomb);
		}
	//3	/* Ha bejelentkezve van vagy ha 1 vagy 0 hogy aktív vagy eladott terméket akar keresni , akkor is mehet! */
	/* Mivel a min alapból kap egy értéket (0) ezért figyelni kell az értékeket! */
		elseif($megj->IsLogin() == true)
		{	
		
		if($valasztottkategoria!=0)
		{
		$tomb = $dbmuvelet->termekkereses($valaszto,$cim,$min,$max,$kulcsszo,$valasztottkategoria);
		//echo "<br>Kategória ág fut!<br>";	
		}
		
		
		if($kulcsszo!="")
		{
		$tomb = $dbmuvelet->termekkereses($valaszto,$cim,$min,$max,$kulcsszo,$valasztottkategoria);		
		}
		
		
		if($max>$min)
		{	
		$tomb = $dbmuvelet->termekkereses($valaszto,$cim,$min,$max);		
		}
		
		if($min!=0)
		{
		$tomb = $dbmuvelet->termekkereses($valaszto,$cim,$min);		
		}
		
		if(isset($cim) && $cim!="")
		{	
		$tomb = $dbmuvelet->termekkereses($valaszto,$cim);
		}
		
		
		$db = count($tomb);
		$visszajelzes = "<div class='alert alert-success'>Az eredményhez görgess le hogy megnézd a(z) ".$db." találatot.</div>";
		$megj->MegjelenitesKeresoMezok($visszajelzes,$aktid="",$tomb);
		}
}
else{
$visszajelzes = "<div class='alert alert-warning'>Nem írtál be semmit a keresőbe!</div>";		
$megj->MegjelenitesKeresoMezok($visszajelzes,$aktid="",$tomb="");
}
?>







