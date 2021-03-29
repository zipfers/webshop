<?php
session_start();
require_once("dbconnect.php");

/*Két fő megjelenítő rész van az ADMIN AL - oldala és az ADMIN FŐ oldalak!
Az ADMIN Fő oldalon a főbb funckiók érhetőek el , az AL oldalakon pedig a funkciók részletes működése.*/

class AdminNezet{
	
	//public $tartalom;
	private $alcim;

									  	
	function __set($nev, $ertek){
		$this->$nev = $ertek;	
	}
	
	/*FIGYELEM EZ A FŐ OLDAL!
	Itt lehetséges új funkcióknak gombokat,új gombsávot létrehozni.
	Az ADMIN Fő oldal megjelenítéséhez a függvény amit több másik függvényt hív.*/
	public function AdminMegjelenites(){
		if($this->BejelentkezettE()==false)
		{
		echo "<h1>Be kell jelentkezned!</h1>";
		}
		else
		{
		$felhasznalonev = $_SESSION['felhasznalo_nev'];
		$ell = new dbmuveletek();
		
			if($ell->Admin_Ellenorzo($felhasznalonev)==true)
			{
			echo "<!DOCTYPE HTML>";
			echo "<html>";
			echo "<head>";
			$this->AdminFoMegjelenesDesign();	
			echo "</head>";	
			echo "<body>";		
			echo "<div id='keret'>";
			$this->AdminFoMegjelenes();
			$this->AdminGombokFelhasznalo();
			$this->AdminGombokTermek();
			$this->KategoriaGombokTermek();
			$this->ArchivumTermek();
			$this->EladottTermek();
			$this->AdminLablec();
			echo "</div>";
			echo "</body>";		
			echo "</html>";	
			}
			else
			{
			echo "<h1>Nem sikerült a hitelesítés</h1>";	
			}
		}
	}
		
	
	//Az ADMIN user FŐ oldalának design fájlját tartalmazó függvény. styleadminfo.css
	public function AdminFoMegjelenesDesign(){
		echo "<link href='styleadminfo.css' type='text/css' rel='stylesheet'>";
		echo "<link href='bootstrap\css\bootstrap.css' rel='stylesheet' type='text/css' />";
		echo "<meta http-equiv='content-type' content='text/html; charset=UTF8'>";
		echo "<meta name='author' content='Rimóczy Kolos'>";
		echo "<meta name='keywords' content='retró,antik,régiség,gyűjtők boltja,plakát,érem,könyv,bélyeg'>";
	}
	
	/*Az ADMIN user oldalát megjelenítő függvény. Itt jelenítjük meg az admin felhasználó nevét.
    A címet manuálisan adtam meg. 
	Később tagváltozóként lehetne megadni.*/
	public function AdminFoMegjelenes(){
		$alcim = "Kérlek válassz a lehetőségek közül:";
		echo "<div id='fejlec'>";
		echo "Gyűjtők Boltja WebShop";
		echo "</div>";
		echo "<hr>";
		echo "Üdvözöllek<u> ".$_SESSION['felhasznalo_nev']."</u>!".$alcim;
		echo "<hr>";	
					
	}
	
	//Az ADMIN fő oldalán a Felhasználókkal kapcsolatos gombok,lehetősgek megjelenítése
	public function AdminGombokFelhasznalo(){
			echo "FELHASZNÁLÓK:";
			echo "<div id='felhasznalogombsor'>";
			echo "<a class='gomb' href='felhfelvitel.php'>Felvitel</a>";
			echo "<a class='gomb' href='felhmodtorl.php'>Törlés/Módosítás</a>";
			echo "</div>";
			echo "<hr>";
			echo "</br>";
			echo "</br>";
	}
	
	//Az ADMIN fő oldalán a termékekkel kapcsolatos gombok , lehetősgek megjelenítése
	public function AdminGombokTermek(){
		echo "TERMÉK:";
		echo "<div id='termekgombsor'>";
		echo "<a class='gomb' href='termekbeszuras.php'>Felvitel</a>";
		echo "<a class='gomb' href='termekmodositas.php'>Törlés/Módosítás</a>";	
		echo "<a class='gomb' href='termeklistazas.php'>Összes termék listázás</a>";		
		echo "</div>";
		echo "<hr>";
		echo "</br>";
		echo "</br>";
	}
	
	//Az ADMIN fő oldalán a kategóriákkal kapcsolatos műveletek megjelenítése
	public function KategoriaGombokTermek(){
		echo "KATEGÓRIA:";
		echo "<div id='kategoriagombsor'>";
		echo "<a class='gomb' href='kategoriafelvitel.php'>Felvitel</a>";
		echo "<a class='gomb' href='kategoriamodositas.php'>Módosítás</a>";
		echo "</div>";
		echo "<hr>";
		echo "</br>";
		echo "</br>";
	}
			
	//Az ADMIN fő oldalán az Archívummal kapcsolatos gombok,műveletek megjelenítése	
	public function ArchivumTermek(){
	echo "ARCHÍVUM:";
	echo "<div id='archivumgombsor'>";
	echo "<a class='gomb' href='archivumlistazas.php'>Összes archív megtekintése</a>";
	echo "</div>";
	echo "<hr>";
	echo "</br>";
	echo "</br>";
	}
	
	
	//Az ADMIN fő oldalán a vásárlásokkal kapcsolatos gombok / műveletek megjelenítése
	public function EladottTermek(){	
	echo "Eladott Termékek:";
	echo "<div id='archivumgombsor'>";
	echo "<a class='gomb' href='eladott-termek.php'>Eladások Megtekintése</a>";
	
	/* Nem reg-elt felh.nok */
	echo "<form action='eladott-termek.php' method='POST' >";
	echo "<input type='hidden' name='nemregelt' >";
	echo "<input type='submit' class='gomb' value='Nem reg. eladások!' >";
	echo "</form>";
	
	
	echo "</div>";
	echo "<hr>";
	echo "</br>";
	echo "</br>";	
	}
			
	//Az ADMIN fő oldalán a megjelenő LÁBLÉC és gombjai
	public function AdminLablec(){
		echo "<div id='lablec'>";
		echo "<div id='lablecgombsor'>";
		echo "<a class='gomb' href='index.php'>Webshop Főoldal</a>";
		echo "<a class='gomb' href='logout.php'>Kilépés</a>";
		echo "<a class='gomb' href='admin.php'>Admin Főoldal</a>";
		echo "</div>";
		echo "</div>";
	}
			
	//A bejelentkezést vizsgáló függvény.
	public function BejelentkezettE(){
		if(isset($_SESSION['felhasznalo_nev']) )
			return true;
		else
			return false;
	}
		
	
	// ADMIN AL OLDALAK megjelenítési függvényei: 	
	/*Az eladott termékek megtekintésére szolgáló megjelenítő függvény. */
	public function EladottTermekMegjelenites($siker="",$parameter){
	
	$alcim = "<br>Eladott termékek és a vevők adatai:";	
	
	if($this->BejelentkezettE()==false)
		{
		echo "<h1>Be kell jelentkezned!</h1>";
		}
		else
		{
		$felhasznalonev = $_SESSION['felhasznalo_nev'];
		$ell = new dbmuveletek();
			
			if($ell->Admin_Ellenorzo($felhasznalonev)==true)
			{	
				$listazo = new dbmuveletek();
				echo "<!DOCTYPE HTML>";
				echo "<html>";
				echo "<head>";
				$this->AdminAloldalMegjelenesDesign();	
				echo "</head>";		
				echo "<body>";		
				echo "<div id='keret'>";	
				echo "<h6 id=teteje>".$this->AdminAlMegjelenestFelvitel($alcim)."</h6>";
				
				$this->AdminAlVisszajelzosav($siker);		
	
				echo "<div id='felso'>";	  
		
				/* A regisztrált felhasználók vásárlásait egy tömbbe olvassuk a vasarlas táblából.  */ 	
	
				if($parameter == 1)
					$regeltvasarlasoktomb = $ell->regelt_felh_vasarlasok();
					
				
				if($parameter == 0)
					$regeltvasarlasoktomb = $ell->nem_regelt_felh_vasarlasok();
					
				
				if($parameter == 1)	
					echo "Regisztrált felhasználók vásárlásai:<br>";
								
				
				if($parameter == 0)
					echo "Nem regisztrált vásárlók vásárlásai:<br>";
							
					echo "<hr>";
					/* Eladott termék ID tömbön (regeltvasarlasoktomb) 
					végigmegyünk és az aktuális termékid-t,aktuális felh-id-t,vasarlas-id-t lekérdezzük.*/
						
					for($i=0;$i<sizeof($regeltvasarlasoktomb);$i++)
						{
						echo "<div id='eladott-termek-sav'>";
						$aktualistermekid = $regeltvasarlasoktomb[$i]['termekid']; 	
						
						if($parameter == 1)
							$aktualisfelhid = $regeltvasarlasoktomb[$i]['felhid'];
						
						if($parameter == 0)
							$aktualisfelhid = $regeltvasarlasoktomb[$i]['nemregfelhid'];
						
						
				
						$aktualisvasarlasid = $regeltvasarlasoktomb[$i]['vasarlasid'];
		
						echo "<p class='font-weight-bold'>A vásárlás adatai: </p>";
						echo "Aktuális vásárlás azonosítója (ID-je):<b>".$aktualisvasarlasid.".</b>";	
						echo "Aktuális termék ID: <b>".$aktualistermekid.".</b>.";
						echo "A terméket vásárló felhasznló ID-je: <b>".$aktualisfelhid.".</b>";
						
						/* Az eladott termékeket listázzuk a vasarlas-ból kiolvasott termek id alapján egy tömbbe */
						$eladotttermektomb = $listazo->eladott_termek_adatok_lekerdezes($aktualistermekid);
						echo "<br>";
						
						
							/* Az eladott termékeket megjelenítő függvénynek átadjuk a tömböt */
							echo "<div id='eladott-termek-sav-baloldal'>";
							echo "<p class='font-weight-bold'><u>Adott termék adatai :</u></p>";
							$this->EladottTermekAdatokMegjelenito($eladotttermektomb);
							echo "</div>";
						
							/* A vasarlas tömbből kiolvassuk az adott sor-hoz tartozó felh-id-t */
							$vasarloktomb = $listazo->Felh_adatok_lekerdezes($aktualisfelhid,$parameter);
											
							/* Megjelenítjük a felhasználó adatait a termék mellett */
							echo "<div id='eladott-termek-sav-jobboldal'>";
							echo "<p><b><u>Adott vásárló adatai :</u></b></p>";						
							$this->VasarloAdatokatMegjelenito($vasarloktomb,$parameter);						
							echo "</div>";
						
						echo "<hr>";
						echo "</div>";
						}
				
						
				echo "<hr>";
				echo "</div>"; 	
				echo "<div id='also'>"; 				
				echo "<hr>";
				echo "</div>"; 	
				echo "<a href='#teteje'>Ugrás az oldal tetejére</a>";
			
				$this->AdminLablec();
				echo "</div>";
				echo "</body>";		
				echo "</html>";	
			}
			else
			{
			echo "<h1>Nem sikerült a hitelesítés</h1>";		
			}	
		}
	}
	
	
	/*A FELHASZNÁLÓ FELVITELE TELJES OLDALT HOZZA BE a felhfelvitel.php-ből!Innen töltődik be beviteli mezőket betöltő függvény : AdminAlFelhasznaloFelvitel().
	A 'siker'-t hozza át,és az értéke egy string (tud lenni),amivel egy adott adatbázis érintő függvény visszatér. Így pontosan lehet mindig tudni mi történt!
	Szükséges levédeni a külső bejelentkezési használattól.*/
	public function AdminFelhasznaloBeszuras(&$siker){
		if($this->BejelentkezettE()==false)
		{
		echo "<h1>Be kell jelentkezned!</h1>";
		}
		else
		{
		$felhasznalonev = $_SESSION['felhasznalo_nev'];
		$ell = new dbmuveletek();
			
			if($ell->Admin_Ellenorzo($felhasznalonev)==true)
			{
			echo "<!DOCTYPE HTML>";
			echo "<html>";
			echo "<head>";
			$this->AdminAloldalMegjelenesDesign();	
			echo "</head>";	
			echo "<body>";		
			echo "<div id='keret'>";	
			$this->AdminAlMegjelenes();	
			$this->AdminAlVisszajelzosav($siker);
			$this->AdminAlFelhasznaloFelvitel();
			$this->AdminAlLablec();
			echo "</div>";
			echo "</body>";		
			echo "</html>";	
			}
			else
			{
			echo "<h1>Nem sikerült a hitelesítés</h1>";
			}
		}
	}
	
	//ADMIN AL OLDAL DESIGN része! styleadminal.css - fájl-t tölti be.
	public function AdminAloldalMegjelenesDesign(){
		echo "<link href='styleadminal.css' rel='stylesheet'  type='text/css'>";
		echo "<link href='bootstrap\css\bootstrap.css' rel='stylesheet' type='text/css' />";
		echo "<meta http-equiv='content-type' content='text/html; charset=UTF8'>";
		echo "<meta name='author' content='Rimóczy Kolos'>";
		echo "<meta name='keywords' content='retró,antik,régiség,gyűjtők boltja,plakát,érem,könyv,bélyeg,kitüntetés,jelvény'>";
	}

	//ADMIN AL OLDALAK 'fejléc' sávja hol a felhasználó neve is megjelenik
	public function AdminAlMegjelenes(){
		$alcim = "Új felhasznaló felvitele menüpont:";		
		echo "<div id='fejlec'>";
		echo "Gyűjtők Boltja WebShop";
		echo "</div>";
		echo "<hr>";
		echo "Kedves: <u>".$_SESSION['felhasznalo_nev']."</u>!".$alcim;	
		echo "<hr>";		
	}
	
	
	/* Visszajelző sáv */
	public function AdminAlVisszajelzosav($siker){		
		echo "<div id='allapotjelzo'>".$siker."</div>";
		echo "<hr>";	
	}


	//ADMIN AL OLDALA LÁBLÉCE - benne a gombok , stb.
	public function AdminAlLablec(){
		echo "<div id='lablec'>";
		echo "<div id='lablecgombsor'>";
		echo "<a class='gomb' href='admin.php'>Admin Főoldal</a>";
		echo "<a class='gomb' href='felhmodtorl.php'>Felhasználó módosítása/törlése</a>";
		echo "<a class='gomb' href='felhfelvitel.php'>Felhasználó felvitele</a>";
		echo "<a class='gomb' href='logout.php'>Kilépés</a>";
		echo "Ma " . date("Y/m/d") . "-e van.</br>";
		echo "Az idő: " . date("h:i:sa");
		echo "</div>";
		echo "</div>";
	}
	
	/*ADMIN AL OLDALON A FELHASZNÁLÓ BESZÚRÁSÁT megjelenítő oldal , mezők. 
	Tördelni kéne a kódot kis monitorra.*/
	public function AdminAlFelhasznaloFelvitel(){
		echo "<form action='insertfelh.php' method='POST'>";
		
		echo "Jogosultság:</br>1-es ADMIN jogok!</br>3-as felhasználói jogok! ALAP: 3-as,felhasználói jogok!Kötelező!
		</br><input class='keresomezo' type='number'  name='jogosultsag' min='1' max='9' value='3' required ></br>";
		
		echo "Jelszó: (Min. 5 - max. 40 karakter) Kötelező!						
		</br><input class='keresomezo' type='password' name='jelszo'  minlength='5' maxlength='40' required /></br>";
		
		echo "Felhasználónév: (Min. 3 - max. 30 karakter) Kötelező!				
		</br><input class='keresomezo' type='text'  	name='felhnev' 	minlength='3' maxlength='30' placeholder='Fantázianév' required /></br>";
		
		echo "Vezetéknév: (Min. 2 - max. 50 karakter)	Kötelező!   	 					
		</br><input class='keresomezo' type='text'  	name='veznev' minlength='2'		maxlength='50' required /></br>";
		
		echo "Keresztnév: (Min. 2 - max. 50 karakter) Kötelező!							
		</br><input class='keresomezo' type='text'  	name='kernev' minlength='2'		maxlength='50' required /></br>";
		
		echo "Ország: (Min. 2 - max. 40 karakter) 										
		</br><input class='keresomezo' type='text'  	name='orszag' minlength='2'		maxlength='40' value='Magyarország' /></br>";
		
		echo "Irányítószám: (Min 2. - max 10 hosszúság!)								    
		</br><input class='keresomezo' type='text'  	name='irsz'   minlength='2'		maxlength='10' /></br>";
		
		echo "Város: (Min 2. - max 50 hosszúság!)								        
		</br><input class='keresomezo' type='text'  	name='varos'  minlength='2'	maxlength='50' /></br>";
		
		echo "Utca/Közterület: (Min. 2 - max. 60 hosszúság!)								
		</br><input class='keresomezo' type='text'  	name='utca'   minlength='2'				maxlength='60' placeholder='Utca/Út/Köz/Park' /></br>";
		
		echo "Házszám/Emelet/Ajtó: (Min. 1 - max. 30 hosszúság!)						    
		</br><input class='keresomezo' type='text'  	name='hsz'  minlength='1' placeholder='33,2.Em.10/B'		maxlength='30' /></br>";
		
		echo "Telefonszám: (Max 20 hosszúság!)									
		</br><input class='keresomezo' type='text'  	name='telefon'  				maxlength='20' /></br>";
		
		echo "Email cím: (Max 80 hosszúság!)									
		</br><input class='keresomezo' type='email' 	name='email' 					maxlength='80' placeholder='valami@másvalami.hu' pattern='+@+' /></br>";
		
		echo "</br><input type='submit' name='send' value='Felvitel!' /></br>";
		echo "</form>";				
	}
		
	
	/*Az átirányító oldalról (modosito.php) hívjuk ezt meg,átadva a modositandonev-et
	amit a db-muveletek classból a keresettnevlistazo függvénnyel lekérdezünk és ki is iratunk.
	*/
	public function AdminAlFelhasznaloModositoMegjelenito(&$siker="",$modositandonev){
		
		
		if($this->BejelentkezettE()==false)
		{
		echo "<h1>Be kell jelentkezned!</h1>";
		}
		else
		{
		$felhasznalonev = $_SESSION['felhasznalo_nev'];
		$ell = new dbmuveletek();
			
			if($ell->Admin_Ellenorzo($felhasznalonev)==true)
			{
			echo "<!DOCTYPE HTML>";
			echo "<html>";
			echo "<head>";
			$this->AdminAloldalMegjelenesDesign();	
			echo "</head>";	
			echo "<body>";		
			echo "<div id='keret'>";	
			$this->AdminAlModTorl();
			$this->AdminAlVisszajelzosav($siker);	
			
			//Ez lenne belelistázó függvény,és a függvény (keresettnevlistazo) ki is írja!!
			$keresett = new dbmuveletek();
			echo $keresett->keresettnevlistazo($modositandonev);
					
			$this->AdminAlLablec();
			echo "</div>";
			echo "</body>";		
			echo "</html>";	
			}
			else
			{
			echo "<h1>Nem sikerült a hitelesítés</h1>";	
			}	
		}
	}
	
	
	/*FELHASZNÁLÓ MÓDOSÍTÓ OLDAL KERESŐ MEZŐIT MEGJELENÍTŐ függvény, SEARCH.PHP irányít át ide.
	Teljes Admin Felhasználó módosítás vagy törlés oldal megjelenítése. ÁTveszi POSTRÓL az adatokat a név keresésben.
	A siker változó azonos felhasználó esetén is már működik,ha a beszúró függvényben azonos a felh-név akkor nem veszi fel és itt kiírja hogy nem sikerült!*/	
	public function AdminFelhasznaloModTorl(&$siker="",&$keresettfelhnev="",&$keresettemail="",&$keresettvaros="",&$keresettnev=""){
		
		if($this->BejelentkezettE()==false)
		{
		echo "<h1>Be kell jelentkezned!</h1>";
		}
		else
		{
		$felhasznalonev = $_SESSION['felhasznalo_nev'];
		$ell = new dbmuveletek();
			
			if($ell->Admin_Ellenorzo($felhasznalonev)==true)
			{
			echo "<!DOCTYPE HTML>";
			echo "<html>";
			echo "<head>";
			$this->AdminAloldalMegjelenesDesign();	
			echo "</head>";	
			echo "<body>";		
			echo "<div id='keret'>";	
			echo "<div id='felso'>";
			$this->AdminAlModTorl();
			$this->AdminAlVisszajelzosav($siker);
			$this->AdminAlFelhKeresoMezo();
			echo "<hr>";
			echo "</div>";
			
			echo "<div id='felso'>";

			$this->AdminAlFelhTorloModosito($keresettfelhnev,$keresettemail,$keresettvaros,$keresettnev);	
			$this->AdminAlLablec();
			echo "</div>";
			
			echo "</div>";
			echo "</body>";		
			echo "</html>";
			}
			else
			{
			echo "<h1>Nem sikerült a hitelesítés</h1>";
			}
		}
	}
	
	//ADMIN AL oldal 'fejléc' része, ahol a felhasználónév megjelenik
	//FEJLÉC MEZŐ//
	public function AdminAlModTorl(){
		$alcim = "Felhasználó törlés vagy módosítás menüpont:";
		echo "<div id='fejlec'>";
		echo "Gyűjtők Boltja WebShop";
		echo "</div>";
		echo "<hr>";
		echo   "Kedves:<u> ".$_SESSION['felhasznalo_nev']."</u>!".$alcim;
		echo "<hr>";
	
	}
	

	/*Admin AL Oldal felh. módosító vagy törlő oldal ,kereső mezőkkel. Jelenleg 4 kereső mező van.*/
	public function AdminAlFelhKeresoMezo(){
					
					echo "Keresés vezetéknév alapján";
					echo "<form action='search.php' method='POST'>";
					echo "<input class='keresomezo' type='text' 	name='keresettnev' >";
					echo "<input type='submit' value='Keress!' >";
					echo "</form>";
					
					echo "Keresés város alapján";
					echo "<form action='search.php' method='POST'>";
					echo "<input class='keresomezo' type='text' placeholder='pl. Budapest' name='keresettvaros'  >";
					echo "<input type='submit' value='Keress!' >";
					echo "</form>";
					
					echo "Keresés email cím alapján";
					echo "<form action='search.php' method='POST'>";
					echo "<input class='keresomezo' type='text' name='keresettemail' >";
					echo "<input type='submit' value='Keress!' >";
					echo "</form>";
					
					echo "Keresés felhasználó név alapján";
					echo "<form action='search.php' method='POST'>";
					echo "<input class='keresomezo' type='text' name='keresettfelhnev' >";
					echo "<input type='submit' value='Keress!' >";
					echo "</form>";
					echo "</br></br></br>";
					
	}
	
	/*Admin felh listázó és módosízó/törlő oldala! Ha kap paramétert a benne meghívott függvény akkor az adott nevet keresi ki*/
	public function AdminAlFelhTorloModosito(&$keresettfelhnev,&$keresettemail,&$keresettvaros,&$keresettnev){  
	
		if($keresettfelhnev || $keresettemail || $keresettvaros || $keresettnev)
		{	
		$listazo = new dbmuveletek();
		echo $listazo->keresolistazo($keresettfelhnev,$keresettemail,$keresettvaros,$keresettnev);	
		}	
	}

	/*Termék AL oldalak lábléc gombsora*/
	public function AdminAlTermekLablec(){
		echo "<div id='lablec'>";
		echo "<div id='lablecgombsor'>";
		echo "<a class='gomb' href='admin.php'>Admin Főoldal</a>";
		echo "<a class='gomb' href='termekmodositas.php'>Termék módosítása</a>";
		echo "<a class='gomb' href='termekbeszuras.php'>Termék felvitele</a>";
		echo "<a class='gomb' href='termeklistazas.php'>Aktív term. listázás</a>";
		echo "<a class='gomb' href='logout.php'>Kilépés</a>";
		echo "Ma " . date("Y/m/d") . "-e van.</br>";
		echo "Az idő: " . date("h:i:sa");
		echo "</div>";
		echo "</div>";
	}

	/*ADMIN AL oldal TERMÉK FELVITELE MENÜPONT BEVITELI MEZŐKET MÁSIK FÜGGVÉNYBŐL HÍVÓ FŐ OLDALA!*/
	public function AdminTermekBeszuras(&$siker){
		
		if($this->BejelentkezettE()==false)
		{
		echo "<h1>Be kell jelentkezned!</h1>";
		}
		else
		{
		$felhasznalonev = $_SESSION['felhasznalo_nev'];
		$ell = new dbmuveletek();
			
			if($ell->Admin_Ellenorzo($felhasznalonev)==true)
			{
			$alcim = "Új termék felvitele menüpont:";
			echo "<!DOCTYPE HTML>";
			echo "<html>";
			echo "<head>";
			$this->AdminAloldalMegjelenesDesign();	
			echo "</head>";	
			echo "<body>";		
			echo "<div id='keret'>";	
			$this->AdminAlMegjelenestFelvitel($alcim);	
			$this->AdminAlVisszajelzosav($siker);
			$this->AdminAlTermekFelvetel();
			$this->AdminAlTermekLablec();
			echo "</div>";
			echo "</body>";		
			echo "</html>";	
			}
			else
			{
			echo "<h1>Nem sikerült a hitelesítés</h1>";	
			}
		}	
	}

	/*ADMIN AL oldal - TERMÉK FELVITEL MENÜPONT , BESZÚRÓ MEZŐK. Fájlkezelés */
	/*Betölti a termékfelviteli űrlapot, mely mezők egy részét a HTML segítségével validálok.*/
	public function AdminAlTermekFelvetel(){
	
		echo "<form action='termekbeszuras.php' method='POST' enctype='multipart/form-data' >";
		echo "Termék címe:  (Min 10. karakter , Max.:120)</br><input type='text' name='termekcim' 		 minlength='10' maxlength='120' required /></br>";	
		echo "Termék ára (A mezőbe lehet írni is!): </br><input type='number' name='termekar' 		     min='10' max='9999999999' required /></br>";	
		echo "Termék leírása (Max 65535 karakter): </br>";
		//A textarea mező engedi a beírt adat formázásának átvitelét is,legalábbis a sortörést megőrzi!!
		// Több űrlapot nem lehet egymásba ágyazni!
		echo "<textarea name='termekleiras' maxlength='65534' rows='40' cols='100' required >"; 
		echo "</textarea></br>";	
		echo "Termékkel kapcsolatos kulcssszavak (Max 80 karakter!):( ','-vel elválasztva!)   </br><input type='text' name='termekkulcsszavak'   maxlength='80' required /></br>";		
		echo "Termék darabszáma: (Max 999 db):      </br><input type='number' name='termekdarab'		 min='1' max='999' required /></br>";		
		echo "Képek feltöltése: (Maximum 3 fájl,10 Megabájt / fájl!)</br>";
		echo "<input type='hidden' name='MAX_FILE_SIZE' value='10000000' />"; //10MEGA MAX	
		echo "<input type='file' name='feltoltendofile[]' id='file_id' multiple='multiple' accept='image/jpg' /><br/> ";								
		echo "KATEGÓRIA:</br>";
		echo "<select name=valasztottkategoria >";								
		$kategorialistazo = new dbmuveletek();
		$kategorialistazo->kategoria_listazo();
		echo "</select>";						
		echo "</br><input type='submit' name='termekadatok' value='Termék felvétele!' /></br>";
		echo "</form>";	
	}

	//Kategória oldal lábléce megjelenítés
	public function AdminAlKategoriaLablec(){
		
		echo "<div id='lablec'>";
		echo "<div id='lablecgombsor'>";
		echo "<a class='gomb' href='admin.php'>Admin Főoldal</a>";
		echo "<a class='gomb' href='kategoriamodositas.php'>Kategória módosítása</a>";
		echo "<a class='gomb' href='kategoriafelvitel.php'>Kategória felvitele</a>";
		echo "<a class='gomb' href='logout.php'>Kilépés</a>";
		echo "Ma " . date("Y/m/d") . "-e van.</br>";
		echo "Az idő: " . date("h:i:sa");
		echo "</div>";
		echo "</div>";
			
	}

	//ADMIN AL OLDAL TERMÉK FELVITEL MENÜPONT alcím sáv és felhasználói név sáv
	public function AdminAlMegjelenestFelvitel($alcim){
	//$alcim = "Új termék felvitele menüpont:";
	echo "<div id='fejlec'>";
	echo "Gyűjtők Boltja WebShop";
	echo "</div>";	
	echo "<div id='bejelentkezesisav'>";
	echo "<hr>";
	echo "Kedves: <u>".$_SESSION['felhasznalo_nev']."</u>!".$alcim;	
	echo "<hr>";
	echo "</div>"; 
	}

	//Kategória felvitel oldal betöltése
	public function AdminAlKategoriaFelvitel(){
	
		echo "<form action='kategoriafelvitel.php' method='POST' >"; 
		echo "Add meg a kategória nevét! Az első betű nagy betű legyen,egyes számban írva! (Min. 2 - max. 40 hosszúság!)						    
		</br><input type='text'  name='ujkategoria'  minlength='2' maxlength='40' required /></br>";
		echo "</br><input type='submit' name='kategoriamodosito' value='Kategória felvitel!' /></br>";
		echo "</form>";
	
	} 


	
	/*ADMIN AL KATEGÓRIA FELVITEL AL OLDAL!*/
	public function AdminKategoriaBeszuras(&$siker){
		if($this->BejelentkezettE()==false)
		{
		echo "<h1>Be kell jelentkezned!</h1>";
		}
		else
		{
		$felhasznalonev = $_SESSION['felhasznalo_nev'];
		$ell = new dbmuveletek();
			
			if($ell->Admin_Ellenorzo($felhasznalonev)==true)
			{
			$alcim = "Új kategória felvitele!";
			echo "<!DOCTYPE HTML>";
			echo "<html>";
			echo "<head>";
			$this->AdminAloldalMegjelenesDesign();	
			echo "</head>";	
			echo "<body>";	
			echo "<div id='keret'>";		
			$this->AdminAlMegjelenestFelvitel($alcim);		
			echo "<div id='felso'>";	  
			$this->AdminAlVisszajelzosav($siker);
			$this->AdminAlKategoriaFelvitel();
			echo "<hr>";
			echo "</div>"; //div zár
			echo "<div id='also'>";
			$listazo = new dbmuveletek();
			$listazo->kategorialist();
			echo "<hr>";
			echo "</div>"; //div zár
			$this->AdminAlKategoriaLablec();
			echo "</div>";
			echo "</body>";		
			echo "</html>";	
			}
			else
			{
			echo "<h1>Nem sikerült a hitelesítés</h1>";		
			}
		}
	}
    
	//ADMIN AL KATEGÓRIA Listázás és módosító oldal! Fő megjelnítés
	public function AdminAlKategoriaModositas(&$siker){
		
		if($this->BejelentkezettE()==false)
		{
		echo "<h1>Be kell jelentkezned!</h1>";
		}
		else
		{
		$felhasznalonev = $_SESSION['felhasznalo_nev'];
		$ell = new dbmuveletek();
			
			if($ell->Admin_Ellenorzo($felhasznalonev)==true)
			{	
			$alcim = "Meglévő kategória módoítása! Kategóriát nem lehet törölni, mert az az adatbázis helytelen működéséhez vezetne.</br>";
			echo "<!DOCTYPE HTML>";
			echo "<html>";
			echo "<head>";
			$this->AdminAloldalMegjelenesDesign();	
			echo "</head>";	
			echo "<body>";	
			echo "<div id='keret'>";	
			$this->AdminAlMegjelenestFelvitel($alcim);
			$this->AdminAlVisszajelzosav($siker);
			echo "<div id='felso'>";	
			$listazo = new dbmuveletek();
			$listazo->kategorialist();
			echo "<hr>";
			echo "</div>";
			echo "<div id='also'>";
			$this->AdminAlKategoriaModosito();
			echo "<hr>";
			echo "</div>";
			$this->AdminAlKategoriaLablec();
			echo "</div>";
			echo "</body>";		
			echo "</html>";		
			}
			else
			{
			echo "<h1>Nem sikerült a hitelesítés</h1>";	
			}		
		}
	}	
	
	//A kategória módosító oldal megjelenítője a táblázatokkal , mely hívja módosító és listázót
	public function AdminAlKategoriaModosito(){
										
		echo "<table>";
		echo "<thead>";
		echo "<tr>";
		echo "<th>Kategória neve!</th>";
		echo "<tr>";
		echo "</thead>";
		echo "<tbody>";	
		$kategorialistazo = new dbmuveletek();
		echo $kategorialistazo->kategorialisttabl();
		echo "</tbody>";
		echo "</table>";		
	}

	/*Módosító oldal fő megjelenítője, ebben hívjuk a mezőkbe listázó módosítót. termekmod.php-ről érkezünk ide, már 1 
	konkrét kiválaszott termék módosítást,majd úra db-be való írását csináljuk.*/	
	public function AdminAlTermekModositoMegjelenito(&$siker,&$modositandotermeknev){
		
		if($this->BejelentkezettE()==false)
		{
		echo "<h1>Be kell jelentkezned!</h1>";
		}
		else
		{
		$felhasznalonev = $_SESSION['felhasznalo_nev'];
		$ell = new dbmuveletek();
			
			if($ell->Admin_Ellenorzo($felhasznalonev)==true)
			{	
			$alcim = " Termék módosítása oldal";
			echo "<!DOCTYPE HTML>";
			echo "<html>";
			echo "<head>";
			$this->AdminAloldalMegjelenesDesign();	
			echo "</head>";	
			echo "<body>";	
			echo "<div id='keret'>";		
			$this->AdminAlMegjelenestFelvitel($alcim);			
			$this->AdminAlVisszajelzosav($siker);		
			echo "<div id='felso'>";	  
			echo "<hr>";
			echo "</div>"; 	
			echo "<div id='also'>"; 
			$megj = new dbmuveletek();
			echo $megj->keresett_termek($modositandotermeknev);
							
			//Kategóira listázó egyelőre kivéve,nem műko9dik , használat 2020.08.30 , JS Kellene
			/*echo "<select name=valasztottkategoria >";									    
			$kategorialistazo = new dbmuveletek();
			$kategorialistazo->kategoria_listazo();
			echo "</select></br>";*/
		
			//Fájl feltöltés JS kellene 	
			//echo "Képek feltöltése: (Maximum 3 fájl,10 Megabájt / fájl!)</br>";
			//echo "<input type='hidden' name='MAX_FILE_SIZE' value='10000000' />"; //10MEGA MAX	
			//echo "<input type='file'  name='feltoltendofile[]' id='file_id' multiple='multiple' accept='image/jpg' /><br/> ";	
			//echo "ALSÓ";
			echo "<hr>";
			echo "</div>"; 
			$this->AdminAlTermekModositoLablec();
			echo "</div>";
			echo "</body>";		
			echo "</html>";	
			}
			else
			{
			echo "<h1>Nem sikerült a hitelesítés</h1>";		
			}
		}
	}
	
	//A Keresett,módosítandó terméket megjelenító függvény mely paraméteren kapja a keresést.
	public function AdminAlTermekListazo($termekcim,$termek,$termekmennyiseg,$termekdatum){
	// A Formázás a listázó függvényben van , itt listáztermek_lekerdezeszuk ki a keresett terméket.
	$termeklistazo = new dbmuveletek();
	echo $termeklistazo->termek_lekerdezes($termekcim,$termek,$termekmennyiseg,$termekdatum);
	}
	
	/*A termékek listázására és megjelenítésére használt függvény. A termeklistazas.php használja ezt a függvényt, csak ha meg akarunk nézni minden terméket.
	Az admin fő oldalról a gomb (Termék listázás) ezt tölti be és termékfelvétel menüben alul is megjelenik ez a gomb.
	A $siker a pontos visszajelzésre szolgál.*/
	public function AdminAlCsakTermekListazo($parameter,$siker=""){
		
		if($this->BejelentkezettE()==false)
		{
		echo "<h1>Be kell jelentkezned!</h1>";
		}
		else
		{
		$felhasznalonev = $_SESSION['felhasznalo_nev'];
		$ell = new dbmuveletek();
			
			if($ell->Admin_Ellenorzo($felhasznalonev)==true)
			{	
				if($parameter == 0)
				{	
				$alcim = " Archív termékek listázása oldal. ";
				}
				
				if($parameter == 1)
				{	
				$alcim = " Aktív termékek listázása oldal. ";
				}	
			
				$listazo = new dbmuveletek();
				echo "<!DOCTYPE HTML>";
				echo "<html>";
				echo "<head>";
				$this->AdminAloldalMegjelenesDesign();	
				echo "</head>";		
				echo "<body>";		
				echo "<div id='keret'>";	
				$this->AdminAlMegjelenestFelvitel($alcim);
				$this->AdminAlVisszajelzosav($siker);		
				echo "<h4 id='teteje'>Összesen: ".$listazo->termek_szamlalas($parameter)." darab termék található az adatbázisban.</h4>";		
				echo "<div id='felso'>";	  
		
				echo $listazo->Minden_termek_lekerdezes($parameter);
				echo "<hr>";
				echo "</div>"; 	
				echo "<div id='also'>"; 				
				echo "<hr>";
				echo "</div>"; 	
				echo "<a href='#teteje'>Ugrás az oldal tetejére</a>";
				$this->AdminAlTermekModositoLablec($parameter);
				
				echo "</div>";
				echo "</body>";		
				echo "</html>";	
			}
			else
			{
			echo "<h1>Nem sikerült a hitelesítés</h1>";		
			}	
		}
	}
		
	//A termék módosító oldal megjelenító függvény - Fő oldal.
	public function AdminAlTermekModosito(&$siker="",&$termekcim="",&$termekar="",&$termekmennyiseg="",&$termekdatum=""){
		
		if($this->BejelentkezettE()==false)
		{
		echo "<h1>Be kell jelentkezned!</h1>";
		}
		else
		{
		$felhasznalonev = $_SESSION['felhasznalo_nev'];
		$ell = new dbmuveletek();
			
			if($ell->Admin_Ellenorzo($felhasznalonev)==true)
			{		
				$alcim = " Termék módosítása oldal";
				echo "<!DOCTYPE HTML>";
				echo "<html>";
				echo "<head>";
				$this->AdminAloldalMegjelenesDesign();	
				echo "</head>";	
				echo "<body>";	
				echo "<div id='keret'>";		
				$this->AdminAlMegjelenestFelvitel($alcim);	
				$this->AdminAlVisszajelzosav($siker);		
				echo "<div id='felso'>";	  
				$this->AdminAlTermekModositoKeresoSav(); 
				echo "<hr>";
				echo "</div>";
				echo "<div id='also'>"; 	
					
					if($termekcim || $termekar || $termekmennyiseg || $termekdatum)
						$this->AdminAlTermekListazo($termekcim,$termekar,$termekmennyiseg,$termekdatum);
				
				//echo "ALSÓ";
				echo "<hr>";
				echo "</div>"; 
				$this->AdminAlTermekModositoLablec();
				echo "</div>";
				echo "</body>";		
				echo "</html>";	
			}
			else
			{
			echo "<h1>Nem sikerült a hitelesítés</h1>";		
			}
		}
	}
	
	//Termék módosító lábléc
	public function AdminAlTermekModositoLablec(){
		
		echo "<div id='lablec'>";
		echo "<div id='lablecgombsor'>";
		echo "<a class='gomb' href='admin.php'>Admin főoldal</a>";
		echo "<a class='gomb' href='termekbeszuras.php'>Termék felvétele</a>";
		echo "<a class='gomb' href='termektorles.php'>Termék törlése</a>";	
		echo "<a class='gomb' href='logout.php'>Kilépés</a>";
		echo "Ma " . date("Y/m/d") . "-e van.</br>";
		echo "Az idő: " . date("h:i:sa");
		echo "</div>";
		echo "</div>";
	}
	
	//Termék módosító oldal kereső mezői!
	public function AdminAlTermekModositoKeresoSav(){

	
		$parameter = 1; 
		/*Itt biztosan aktív termékekről beszélünk.*/
		$szamlalo = new dbmuveletek();
		$db = $szamlalo->termek_szamlalas($parameter);
		echo "Jelenleg : ";
		echo $db;
		echo " termék elérhető.</br></br>";
		
		echo "Keresés termékcím alapján";
		echo "<form action='termekmodositas.php' method='POST'>";
		echo "<input class='keresomezo' type='text'  name='keresettcim' />";
		echo "<input type='submit' value='Keress!' />";
		echo "</form>";
		
		echo "Keresés termékár alapján";
		echo "<form action='termekmodositas.php' method='POST'>";
		echo "<input class='keresomezo' type='text'  name='keresettar' />";
		echo "<input type='submit' value='Keress!' />";
		echo "</form>";
		
		echo "Keresés mennyiség alapján";
		echo "<form action='termekmodositas.php' method='POST'>";
		echo "<input class='keresomezo' type='text'  name='keresettmennyiseg' />";
		echo "<input type='submit' value='Keress!' />";
		echo "</form>";
		
		echo "Keresés feltöltés dátuma alapján (A keresett dátumtól régebbi dátum keresése!Formátum: '2020-07-13')";
		echo "<form action='termekmodositas.php' method='POST'>";
		echo "<input class='keresomezo' type='text'  name='keresettdatum' />";
		echo "<input type='submit' value='Keress!' />";
		echo "</form>";		
	}

	/* Eladott Termékeket megjelenítő függvény , egy tömböt kap. Mivel korábban a vasarlas táblából olvastuk ki az ide átadott
	tömböt így arra vigyázni kell hogy milyen tömböt adunk át a függvénynek. */
	public function EladottTermekAdatokMegjelenito($termektomb){
	
		
		for($i=0;$i<sizeof($termektomb);$i++)	
			{				
			echo "<b><u>A Termék címe:</b></u> ".$termektomb[$i]['termekcim'].".<br>";	
			echo "A tétel ára: <b>".$termektomb[$i]["termekar"]."</b><br>";	
			echo "A termékhez tartozó kulcsszavak: <b>".$termektomb[$i]['kulcsszavak']		."</b></br>";	
			echo "A termék feltöltésének dátuma <b>".$termektomb[$i]['feltoltdatum']."</b></br>";
			echo "Képek: <br>";			
			echo "<a href='".$termektomb[$i]['kep1']."' target='_blank'><img class='adminlistazokep' float-left;' src='".$termektomb[$i]['kep1']."'></a>"; 			
			echo "<a href='".$termektomb[$i]['kep2']."' target='_blank'><img class='adminlistazokep' float-left;' src='".$termektomb[$i]['kep2']."'></a>";
			echo "<a href='".$termektomb[$i]['kep3']."' target='_blank'><img class='adminlistazokep' float-left;' src='".$termektomb[$i]['kep3']."'></a>";		
			}
	}
	
	
	/* Admim Al oldalon a vásárlásban a vásárló adatait megjelenítő függvény. Tömb-öt kap a vasarlas táblából.
	A függvény máshonnan is hívható de figyelni kell mit adunk át neki.
	*/
	public function VasarloAdatokatMegjelenito($felhasznalotomb,$parameter){
	$con;
	dbconnect($con);
		
		if($parameter == 1){	
			for($i=0;$i<sizeof($felhasznalotomb);$i++)
			{
			echo "Felh. ID.: ".$felhasznalotomb[$i]['felhid']				."<br>";
			echo "Felh. neve: ".$felhasznalotomb[$i]['felhnev']				."<br>";
			echo "Felh. vezetékneve: ".$felhasznalotomb[$i]['veznev']		."<br>";
			echo "Felh. keresztneve:".$felhasznalotomb[$i]['kernev']		."<br>";
			echo "Ország: ".$felhasznalotomb[$i]['orsz']					."<br>";
			echo "Irányítószám: ".$felhasznalotomb[$i]['irsz']				."<br>";
			echo "Város: ".$felhasznalotomb[$i]['varos']					."<br>";
			echo "Utca: ".$felhasznalotomb[$i]['utca']						."<br>";
			echo "Házszám: ".$felhasznalotomb[$i]['hsz']					."<br>";
			echo "Telefon: ".$felhasznalotomb[$i]['telefon']				."<br>";
			echo "Email:<a href=mailto:".$felhasznalotomb[$i]['email'].">".$felhasznalotomb[$i]['email']."</a><br>";
			echo "Reg. Dátuma ".$felhasznalotomb[$i]['regdatum']			."<br>";
			}
		}
	
		
		if($parameter == 0){	
			for($i=0;$i<sizeof($felhasznalotomb);$i++)
			{
			echo "Nem reg. felh. ID.: ".$felhasznalotomb[$i]['nemregfelhid']."<br>";
			echo "Felh. vezetékneve: ".$felhasznalotomb[$i]['veznev']		."<br>";
			echo "Felh. keresztneve:".$felhasznalotomb[$i]['kernev']		."<br>";
			echo "Ország: ".$felhasznalotomb[$i]['orsz']					."<br>";
			echo "Irányítószám: ".$felhasznalotomb[$i]['irsz']				."<br>";
			echo "Város: ".$felhasznalotomb[$i]['varos']					."<br>";
			echo "Utca: ".$felhasznalotomb[$i]['utca']						."<br>";
			echo "Házszám: ".$felhasznalotomb[$i]['hsz']					."<br>";
			echo "Telefon: ".$felhasznalotomb[$i]['telefon']				."<br>";
			echo "Email:<a href=mailto:".$felhasznalotomb[$i]['email'].">".$felhasznalotomb[$i]['email']."</a><br>";
			echo "Vásárláskor létrehozott felhasználó és a vásárlás dátuma: ".$felhasznalotomb[$i]['datum']			."<br>";
			}
		}	
	}
}

				
class dbmuveletek{
		
	function __set($nev, $ertek){
	$this->$nev = $ertek;	
	}
		
	function Admin_Ellenorzo($admine){
	$con;
	dbconnect($con);
	
	$sql = "SELECT jog,felhnev FROM felhasznalok WHERE felhnev LIKE '$admine';";
	$result = $con->query($sql);
	$jog;
	$felhnev = "";
	
	if($result->num_rows>0)
	{
		while($row = $result->fetch_assoc())
		{
		$jog = $row['jog'];	
		$felhnev = $row['felhnev'];
		}
	}
	else
	{
	echo "<h1>Nem adott a lekérdezés jó eredményt!</h1>";	
	}
	
	
	if($jog == 1 && strcmp($felhnev,$admine) == 0)
	{
	return true;	
	}
	else
	{
	echo "<h1>Nincs admin jogosultságod</h1>";
	exit();
	}
	
	$con->close();
	}
	
	public function nem_regelt_felh_vasarlasok(){
	$con;
	dbconnect($con);
	$sql = "SELECT vasarlasid,nemregfelhid,termekid FROM vasarlas WHERE nemregfelhid is NOT NULL ORDER BY vasarlasdatum DESC";
	$result = $con->query($sql);
	
	$outputtomb = array();
	
	if($result->num_rows>0)
	{
		while($row = $result->fetch_assoc())
		{
		$outputtomb[]= array('vasarlasid' => $row['vasarlasid'],'nemregfelhid' => $row['nemregfelhid'],'termekid' => $row['termekid']);
		}
	}
	else{
	echo "Nem volt találatunk a lekérdezésre!";	
	}
	
	
	return $outputtomb;	
		
	$con->close();
	}
	
	/* Vásárlás táblából a reg-elt felhasználók vásárlásait és felhid-t és termekid-t olvassuk ki! */
	public function regelt_felh_vasarlasok(){
	$con;
	dbconnect($con);
	$sql = "SELECT vasarlasid,felhid,termekid FROM vasarlas WHERE nemregfelhid is NULL ORDER BY vasarlasdatum DESC";
	$result = $con->query($sql);
		
	$outputtomb = array();
	
	if($result->num_rows>0)
	{
		while($row = $result->fetch_assoc())
		{
		$outputtomb[]= array('vasarlasid' => $row['vasarlasid'],'felhid' => $row['felhid'],'termekid' => $row['termekid']);
		}
	}
	else{
	echo "Nem volt találatunk a lekérdezésre!";	
	}
	
	
	return $outputtomb;		
	$con->close();
	}
	
	
					
	/* Eladott terméket listáz. Levizsgált termek-idt kap meg, és az eladásban használjuk.
	Más is kaphat , figyelni kell hogy milyen termék - id-t kap. 
	*/
	public function eladott_termek_adatok_lekerdezes($termekid){
	$con;
	dbconnect($con);	
		
	$sql = "SELECT * FROM termeklap WHERE termekid = $termekid";
		
	$result=$con->query($sql);
	
	$outputtomb = array();
	
	if($result->num_rows>0)
	{
		while($row = $result->fetch_assoc())
		{
		$outputtomb[]= array(
		'termekid' => $row['termekid'],
		'aktive' => $row['aktive'],
		'termekcim' => $row['termekcim'],
		'termekar' => $row['termekar'],
		'leiras' => $row['leiras'],
		'kulcsszavak' => $row['kulcssz'],
		'darab' => $row['darab'],
		'feltoltdatum' => $row['feltoltdatum'],
		'kategoria' => $row['kategelh'],
		'kep1' => $row['img1'],
		'kep2' => $row['img2'],
		'kep3' => $row['img3']);		
		}
	}
	else{
	echo "Nem volt találatunk a lekérdezésre!";	
	}
	
	

	return $outputtomb;		
	$con->close();	
	}
	
	/* Felhasználó adatait lekérdező függvény a vásárlás listázáshoz 
	Paramétertől függően a regisztrált vagy a nem regisztrált felhasználókból olvassa ki az adatokat!
	*/ 
	public function Felh_adatok_lekerdezes($aktualisfelhid,$parameter){
	$con;
	dbconnect($con);

	if($parameter == 1)
		$sql = "SELECT * FROM `felhasznalok` WHERE felhid = $aktualisfelhid";
			
	if($parameter == 0)
		$sql = "SELECT * FROM `regnelkulfelhasznalok` WHERE nemregfelhid = $aktualisfelhid";
	
	
	$result = $con->query($sql);
		
	$outputtomb = array();
	
	if($parameter == 1)
	{
		if($result->num_rows>0)
		{
			while($row = $result->fetch_assoc())
			{
			$outputtomb[]= array(
			'felhid' => $row['felhid'],	
			'felhnev' => $row['felhnev'],
			'veznev' => $row['veznev'],
			'kernev' => $row['kernev'],
			'orsz' => $row['orsz'],
			'irsz' => $row['irsz'],
			'varos' => $row['varos'], 
			'utca' => $row['utca'],
			'hsz' => $row['hsz'],
			'telefon' => $row['telefon'],
			'email' => $row['email'],
			'regdatum' => $row['regdatum']);
			}
		}
		else
		{
		echo "Nem volt találatunk a lekérdezésre!";	
		}
	}
	
	
	if($parameter == 0)
	{	
		if($result->num_rows>0)
		{
			while($row = $result->fetch_assoc())
			{
			$outputtomb[]= array(
			'nemregfelhid' => $row['nemregfelhid'],	
			//'felhnev' => $row['felhnev'],
			'veznev' => $row['veznev'],
			'kernev' => $row['kernev'],
			'orsz' => $row['orsz'],
			'irsz' => $row['irsz'],
			'varos' => $row['varos'], 
			'utca' => $row['utca'],
			'hsz' => $row['hsz'],
			'telefon' => $row['telefon'],
			'email' => $row['email'],
			'hozzajarul' =>['hozzajarul'],
			'datum' => $row['datum']);
			}
		}
		else
		{
		echo "Nem volt találatunk a lekérdezésre!";	
		}
	}
	
	
	

	
	return $outputtomb;		
	$con->close();	
	}

		
	
	
	/*Minden terméket listázó függvény növekvő cím szerint. AZ ADMIN fő oldalról elérhetó gombsorból listázza.
	Adatbázis műveletet is végez,és egy output-tal tér vissza, amiben kiiratás is van.
	Lekérdez minden terméket,kap egy paramétert, mely alapján vagy az aktiv-at vagy az archívat írja ki , egy output-változóba!
	Paramétertől függően 0 vagy 1 jeleníti meg a gombot is.Ha 0 akkor az aktívvá tevőt, ha 1 akkor a passzívvá tevőt.*/
	function Minden_termek_lekerdezes($parameter){
	$con;	
	dbconnect($con);	
	
	if($parameter == 1)
	{
	$sql = "SELECT * FROM `termeklap` WHERE aktive = 1 ORDER BY termekcim ASC;";	
	$result = $con->query($sql);
	}
	
	if($parameter == 0)
	{
	$sql = "SELECT * FROM `termeklap` WHERE aktive = 0 ORDER BY termekcim ASC;";	
	$result = $con->query($sql);
	}
	
	
	$output = "";
	if($result->num_rows>0)
			{
				while($row = $result->fetch_assoc())
				{

					$output .= "<div id='termekmezo'>";
					// Termék listázó mező bal oldalának DIV kezdete.
					$output .= "<div id='termekmezobaloldal'>";
					$output .= "<h4>Termék címe: </br>'".$row['termekcim']."'</h4>"; //Az egyes idézőjel a "-előtt a .$row előtt a megjelenítést szolgálja
					
					$output .= "<ul>";
					$output .= "<li>Termék ID : ".$row['termekid'].			"</li>";
					$output .= "<li>Aktív e : ".$row['aktive'].				"</li>";
					$output .= "<li>Termék ára : ".$row['termekar'].		"</li>";
					
					//Esetleg kellene egy link ami megnyitja a teljes leírást.
					//$output .= "<li>Leírás : ".$row['leiras'].				"</li>";
					
					$output .= "<li>Kulcsszavak : ".$row['kulcssz'].		"</li>";
					$output .= "<li>Darab : ".$row['darab'].				"</li>";
					$output .= "<li>Felt. dátuma : ".$row['feltoltdatum'].	"</li>";
					
					//Mentem egy változóba a kategória ID-t ami egy szám , majd átadom a saját függvénynek,ami visszatér a kategória nevével.
					$kategoria = "".$row['kategelh']."";
					$listazo = new dbmuveletek();
					$output .= "<li>Kategória: ".$listazo->kategoria_nevlistazo($kategoria)."</li>";
					$output .= "</ul>";
					
					
					// Termék aktívvá tevő opció FORM
					$output .= "<form style='float:left;' action='termekaktiv.php' method='POST'>";
					$output .= "<input type='hidden' name='modositandotermeknev' value='".$row['termekcim']."' />";								
					
					if($parameter == 0)
					{	
					$ertek = "A termék aktívvá tétele!";
					$output .= "<input type='hidden' name='parameter' value='$parameter' />";
					}
					
					
					if($parameter == 1)
					{	
					$ertek = "A termék archívba tétele!";
					$output .= "<input type='hidden' name='parameter' value='$parameter' />";
					}
					
					$output .= "<input type='submit' value='$ertek' />";						
					$output .= "</form>";
					$output .= "</div>";
					// https://hetnap.rs/cikk/A-PHP-substr_replace-funkcioja-29225.html
					// Képeket listázó DIV kezdete
					$output .= "<div id='termekmezojobboldal'>";
					$output .= "<h3>Képek: </h3>";
					$output .= "<img class='adminlistazokep' src='".$row['img1']."'>";
					$output .= "<img class='adminlistazokep' src='".$row['img2']."'>";
					$output .= "<img class='adminlistazokep' src='".$row['img3']."'>";
					$output .= "</div>";	
					$output .= "</div>";		
				}		
			}
			else
			{
				echo "Nem volt egy találatunk sem a lekérdezésre!";
			}	
	return $output;
	$con->close();		
	}
	
	/*Termék minden adatát lekérdező függvény négy lehetséges paraméterrel! A lekérdezés után a megjelenés formáját is megadjuk itt.*/
	function termek_lekerdezes($termekcim,$termekar,$termekmennyiseg,$termekdatum){
	$con;	
	dbconnect($con);
	$ellenorzo = new funkciok();

	if($termekcim)
	{
	$ellenorzo->bemenet_ellenorzes($termekcim);
	$sql = "SELECT * FROM `termeklap` WHERE termekcim LIKE '%".$termekcim."%' && aktive = 1";
	}
	
	
	if($termekar)
	{
	$ellenorzo->bemenet_ellenorzes($termekar);
	$sql = "SELECT * FROM `termeklap` WHERE termekar = '$termekar' && aktive = 1";
	}
	
	
	if($termekmennyiseg)
	{
	$ellenorzo->bemenet_ellenorzes($termekmennyiseg);
	$sql = "SELECT * FROM `termeklap` WHERE darab = '$termekmennyiseg' && aktive = 1";
	}
	
	
	if($termekdatum)
	{
	$ellenorzo->bemenet_ellenorzes($termekdatum);
	$sql = "SELECT * FROM `termeklap` WHERE feltoltdatum < '$termekdatum' && aktive = 1";
	}
	
	
	$result = $con->query($sql);
	$output = "";
	if($result->num_rows>0)
			{
				while($row = $result->fetch_assoc())
				{

					$output .= "<div id='termekmezo'>";
					
					// Termék listázó mező bal oldalának DIV kezdete.
					$output .= "<div id='termekmezobaloldal'>";
					$output .= "<h4>Termék címe: </br>'".$row['termekcim']."'</h4>"; //Az egyes idézőjel a "-előtt a .$row előtt a megjelenítést szolgálja
					
					$output .= "<ul>";
					$output .= "<li>Termék ID : ".$row['termekid'].			"</li>";
					$output .= "<li>Aktív e : ".$row['aktive'].				"</li>";
					$output .= "<li>Termék ára : ".$row['termekar'].		"</li>";
					
					//Esetleg kellene egy link ami megnyitja a teljes leírást.
					$output .= "<li>Leírás : ".$row['leiras'].				"</li>";
					
					$output .= "<li>Kulcsszavak : ".$row['kulcssz'].		"</li>";
					$output .= "<li>Darab : ".$row['darab'].				"</li>";
					$output .= "<li>Felt. dátuma : ".$row['feltoltdatum'].	"</li>";
					
					//Mentem egy változóba a kategória ID-t ami egy szám , majd átadom a saját függvénynek,ami visszatér a kategória nevével.
					$kategoria = "".$row['kategelh']."";
					$listazo = new dbmuveletek();
					$output .= "<li>".$listazo->kategoria_nevlistazo($kategoria)."</li>";
					$output .= "</ul>";
					
					// Termék törlése opció FORM
					$output .= "<form style='float:left;' action='termekmod.php' method='POST' >";													
					$output .= "<input type='hidden' name='torlendonev' value= '".$row['termekcim']."'/>";
					$output .= "<input type='submit'  value='A termék törlése:' />";
					$output .= "</form>";
					
					// Termék módosítás opció FORM
					$output .= "<form style='float:left;' action='termekmod.php' method='POST'>";
					$output .= "<input type='hidden' name='modositandotermeknev' value='".$row['termekcim']."' />";								
					$output .= "<input type='submit' value='Az adatok módosítása!' />";						
					$output .= "</form>";
					$output .= "</div>";

					// Képeket listázó DIV kezdete
					$output .= "<div id='termekmezojobboldal'>";
					$output .= "<h3>Képek: </h3>";
					$output .= "<img class='adminlistazokep' src='".$row['img1']."'>";
					$output .= "<img class='adminlistazokep' src='".$row['img2']."'>";
					$output .= "<img class='adminlistazokep' src='".$row['img3']."'>";
					$output .= "</div>";	
					
					$output .= "</div>";		
				}		
			}
			else
			{
				echo "Nem volt egy találatunk sem a lekérdezésre!";
			}	
	return $output;
	$con->close();	
	
	}
	
	/*Az elérhető és nem elérhető termékek aktuális darabszámával visszatérő lekérdezés. Az SQL 'AS' mint darab adja vissza az eredményt */
	function termek_szamlalas($parameter){
	$db = 0;	
	
	if($parameter == 1)
	{	
	$sql = "SELECT COUNT(termekid) AS darab FROM termeklap WHERE aktive = 1;";
	}
	
	if($parameter == 0)
	{
	$sql = "SELECT COUNT(termekid) AS darab FROM termeklap WHERE aktive = 0;";
	}	
	
	$con;
	dbconnect($con);
	$resultdb = $con->query($sql);
	if($resultdb->num_rows>0)
	{
		while($row = $resultdb->fetch_assoc())
		{
		$db = $row['darab'];	
		}
	
	}

	$con->close();
	return $db;
	}

	/*Kategória beszúrás függvény. Az sql lekérdezés nem veszi figyelembe a lekérdezéseket,  tehát ha ékezettel keresek (Könyvek = Konyvek)	
	Függvény kapja az új kategóriát , levizsgálja hogy létezik e , ha nem akkor beszúrja a db-be.*/
	function kategoria_beszuras($ujkategoria){
	$con;
	dbconnect($con);
	$ellenorzes = new funkciok();
	$ellenorzes->sql_tamadas($ujkategoria); 
	$ellenorzes->bemenet_ellenorzes($ujkategoria);
	
	$sqlellenorzes = "SELECT kategorianev FROM kategoria WHERE kategorianev = '$ujkategoria'";
	$resultvizsgalat = $con->query($sqlellenorzes);
	
	if($resultvizsgalat->num_rows>0)
	{
		$siker = "Van ilyen nevű kategória,adj meg másikat!";
	}
	else
	{		
	$sqlkategoria = "INSERT INTO `kategoria`(`kategoriaid`, `kategorianev`) VALUES (NULL,'$ujkategoria');";
	$result = $con->query($sqlkategoria);		
	$siker = "Sikeres kategoria felvétel!";
	}
	
	$con->close();
	return $siker;
	}
	
	
	//Függvény mely termékcímet kap és termék ID-t ad vissza!
	function termekid_lekerdezes_termekcim($termekcim){
				
	$con;
	dbconnect($con);	
	$sqlid = "SELECT termekid FROM termeklap WHERE termekcim = '".$termekcim."';";
	$resultid = $con->query($sqlid);
	$eredmeny = "";
	
		if($resultid->num_rows>0)
		{
			while($row = $resultid->fetch_assoc())
			{
			$eredmeny.= $row['termekid'];
			}	
		}

	return $eredmeny;
	$con->close();
	}

	/*A Függvény átveszi a termékbeszúrás űrlapról az adatokat,és a file(okat),
	majd megnézi volt e ilyen című termék,ha nem akkor beszúrja az adatokat, majd létrehozza azt a mappát termék ID alapján ahova átmásolja a feltöltött
	fájlokat, majd a kép elérhetőségeit is beszúrja és 'módosítja' az adattáblában!*/
	function termek_beszuras($termekar,$termekleiras,$termekkulcsszavak,$termekdarab,$termekcim,$termekkategoria,$filename)
	{
	$con;
	$siker;
	
	$ellenorzes = new funkciok();
	$ellenorzes->sql_tamadas($termekar);
	$ellenorzes->sql_tamadas($termekleiras);
	$ellenorzes->sql_tamadas($termekkulcsszavak);
	$ellenorzes->sql_tamadas($termekdarab);
	$ellenorzes->sql_tamadas($termekcim);
	$ellenorzes->sql_tamadas($termekkategoria); //elméletileg felesleges
	
	$ellenorzes->bemenet_ellenorzes($termekar);
	$ellenorzes->bemenet_ellenorzes($termekleiras);
	$ellenorzes->bemenet_ellenorzes($termekkulcsszavak);
	$ellenorzes->bemenet_ellenorzes($termekdarab);
	$ellenorzes->bemenet_ellenorzes($termekcim);
	$ellenorzes->bemenet_ellenorzes($termekkategoria); //elméletileg felesleges
	dbconnect($con);
	
	$sqltermek = "SELECT termekcim FROM `termeklap` WHERE termekcim = '".$termekcim."';";
	$result = $con->query($sqltermek);
	
		if($result->num_rows>0)
		{
		$siker = "Létezik ilyen című termék, így nem lehet felvenni , adj meg mást!";
		}
		else
		{
		$sql = "INSERT INTO `termeklap`(`termekid`,`aktive`,`termekcim`,`termekar`,`leiras`,`kulcssz`,`darab`,`feltoltdatum`,`kategelh`,`img1`,`img2`,`img3`) 
				VALUES 
				(NULL,1,'$termekcim','$termekar','$termekleiras','$termekkulcsszavak','$termekdarab',NOW(),'$termekkategoria',NULL,NULL,NULL);";
		
		$con->query($sql);
		$siker = "Sikeresen beszúrtuk a termék adatait az adatbázisba. ";
		}	
	
	/*Szükséges volt egy másik könyvtárba tenni a fájlt, mert a PHP kézikönyv szerint ha ugyanoda akarjuk helyezni akkor hibár jelez!!
	Tehát a mkdir-nél létrehozunk egy új könyvtárat , és a 'tmp ideiglenes' mappából helyezi át!
	NTFS FÁJLRENDSZER , AZ TERMEKID -bőkl csinál mappát ennek a korlátai le kell írni, meg kell nézni.
	Hibakereséshez , kiiratani az asszoc tömb elemeit!!
	print_r($filename);*/
	
	
	//Saját függvény megoldás:
	$output = $this->termekid_lekerdezes_termekcim($termekcim);
	mkdir("ujkonyvtar/$output", 0777);
	
	for($i=0;$i<sizeof($filename);$i++)	
	{			
		foreach($filename[$i] as $key=>$value)
		{
		rename("konyvtar/$value","ujkonyvtar/$output/$value");
		$img[$i] = "ujkonyvtar/$output/$value";
		}				
	}
	
	//Kimentem a két kép eléréséi útját egy egy változóban , majd sql-ben beszúrjuk , update-eljük a táblát...
	// A Sikerben átadjuk az üzeenteket összefűzésdben!!
	// Az if szerkezet próbálkozás volt hogy a nem betallózott fájlok esetén ne adjon hibát.
	$db=0;
	
	if(isset($img[0]))
	{	
	$img1 = $img[0];
	$db++;
	}
	else
	{
	$img1 = null;			
	}
	
	
	
	if(isset($img[1]))
	{	
	$img2 = $img[1]; //Warning hibajelzést ad ha csak 1 fájlt tallózopk be. 
	$db++;
	}
	else
	{
	$img2 = null;				
	}
	
	
	
	if(isset($img[2]))
	{	
	$img3 = $img[2];
	$db++;
	$siker .= "Feltöltve ".$db." kép fájl.";
	}
	else
	{
	$img3 = null;				
	}
		
	
	$sqlupdate = "UPDATE `termeklap` SET img1 = '$img1', img2 = '$img2', img3 = '$img3' WHERE termekcim = '".$termekcim."';";
	$resultupdate = $con->query($sqlupdate);
		
	if($resultupdate)
	{
	$siker.= " A képfeltöltés is sikeres!";
	}
	else
	{
	$siker.= " Hiba a képfeltöltés - (Adatbázis) módosításnál!";
	}			
	$con->close();	
	return $siker;
	//$vissza = new AdminNezet();
	//$vissza->AdminTermekBeszuras($siker);		
	}
		
	/* 2020-08-03-án beépítve FELHASZNÁLÓ BESZÚRÁSA FGV.*/
	function felhasznalo_beszuras($jogosultsag,$jelszo,$felhnev,$veznev,$kernev,$orszag,$irsz,$varos,$utca,$hsz,$telefon,$email){
	$con;	
	$siker;	
	$ellenorzes = new funkciok();
	$vissza = new AdminNezet();
	// MySql Inejction elleni védelem saját osztályból.
	$ellenorzes->sql_tamadas($jogosultsag);
	$ellenorzes->sql_tamadas($jelszo);
	$ellenorzes->sql_tamadas($felhnev);
	$ellenorzes->sql_tamadas($veznev);
	$ellenorzes->sql_tamadas($kernev);
	$ellenorzes->sql_tamadas($orszag);
	$ellenorzes->sql_tamadas($irsz);
	$ellenorzes->sql_tamadas($varos);
	$ellenorzes->sql_tamadas($utca);
	$ellenorzes->sql_tamadas($hsz);
	$ellenorzes->sql_tamadas($telefon);
	$ellenorzes->sql_tamadas($email);      
	//Bemenet ellenőrzés védelem saját osztályból.
	$ellenorzes->bemenet_ellenorzes($jogosultsag);
	$ellenorzes->bemenet_ellenorzes($jelszo);	
	$ellenorzes->bemenet_ellenorzes($felhnev);	
	$ellenorzes->bemenet_ellenorzes($veznev);	
	$ellenorzes->bemenet_ellenorzes($kernev);	
	$ellenorzes->bemenet_ellenorzes($orszag);	
	$ellenorzes->bemenet_ellenorzes($irsz);
	$ellenorzes->bemenet_ellenorzes($varos);	
	$ellenorzes->bemenet_ellenorzes($utca);		 
	$ellenorzes->bemenet_ellenorzes($hsz);		 
	$ellenorzes->bemenet_ellenorzes($telefon);	
	$ellenorzes->bemenet_ellenorzes($email);
	$jelszo = sha1($jelszo);
	echo $jogosultsag;
	
	if($jogosultsag == 1 || $jogosultsag == 3)
	{
		dbconnect($con);
		$sqlfelhnev = "SELECT felhnev FROM `felhasznalok` WHERE felhnev = '".$felhnev."';";
		$result = $con->query($sqlfelhnev);
		if($result->num_rows>0)
		{
		$siker = "Létezik ilyen felhasználó,a beszúrás nem sikerült!";
		}
		else
		{
		$sql = "INSERT INTO `felhasznalok`(`felhid`, `jog`, `jelszo`, `felhnev`, `veznev`, `kernev`, `orsz`, `irsz`, `varos`, `utca`, `hsz`, `telefon`, `email`, `regdatum`) 
				VALUES 
				(NULL,'$jogosultsag','$jelszo','$felhnev','$veznev','$kernev','$orszag','$irsz','$varos','$utca','$hsz','$telefon','$email',NOW());";
		$con->query($sql);
		$siker = "Sikeres felhasználó beszúrás!";
		}
		//return $siker;
		$con->close();		
	}	
	else
	{	
	$siker = "Nem adhatsz csak ADMIN (1) vagy USER (3) jogosultságot!";	
	}		
	
	$vissza->AdminFelhasznaloBeszuras($siker);
	}
	
	/*Listázó , paraméteren kaphat egy keresett felhasználónevet , emailt, várost , vezetéknevet és akkor HA kap , csak az adottat listázza ki. */
	function keresolistazo($felhnev,$keresettemail,$keresettvaros,$keresettnev){
	$con;
	dbconnect($con);
	
	$ellenorzes = new funkciok();
		
	if($felhnev)
	{	
	$felhnev = $con->real_escape_string($felhnev);	
	$ellenorzes->bemenet_ellenorzes($felhnev);
	$sql  = "SELECT felhid,jog,veznev,kernev,varos,email,felhnev FROM felhasznalok WHERE felhnev LIKE '%".$felhnev."%' ";
	}

	
	if($keresettemail)
	{
	$keresettemail = $con->real_escape_string($keresettemail);
	$ellenorzes->bemenet_ellenorzes($keresettemail);
	$sql = "SELECT felhid,jog,veznev,kernev,varos,email,felhnev FROM felhasznalok WHERE email LIKE '%".$keresettemail."%' ";
	}

	if($keresettvaros)
	{
	$keresettvaros = $con->real_escape_string($keresettvaros);
	$ellenorzes->bemenet_ellenorzes($keresettvaros);
	$sql = "SELECT felhid,jog,veznev,kernev,varos,email,felhnev FROM felhasznalok WHERE varos LIKE '%".$keresettvaros."%' ";
	}
	
	if($keresettnev)
	{
	$keresettnev = $con->real_escape_string($keresettnev);	
	$ellenorzes->bemenet_ellenorzes($keresettnev);
	$sql = "SELECT felhid,jog,veznev,kernev,varos,email,felhnev FROM felhasznalok WHERE veznev LIKE '%".$keresettnev."%' ";
	}

	$result = $con->query($sql);
	$output = "";
	if($result->num_rows>0)
			{
				while($row = $result->fetch_assoc())
				{
											
					//Felhasználó listázó mező DIV kezdete.		
					$output .= "<div id='felhasznalomezo'>";			
					$output .= "<h4>Felhasználónév:</br>'".$row['felhnev']."'</h4>"; //Az egyes idézőjel a "-előtt a .$row előtt a megjelenítést szolgálja	
					$output .= "<ul>";
					$output .= "<li>Felh. ID   : ".$row['felhid'].		"</li>";
					
					if($row['jog']==1)
						$output .= "<li><h3>ADMINISZTRÁTOR.A Törlés nincs megengedve! Jogosultság: ".$row['jog']. 	    "</h3></li>";
					
					//if($row['jog']==3)
					$output .= "<li>Jogosultság: ".$row['jog']. 	    "</li>";
					
					$output .= "<li>Vezetéknév : ".$row['veznev'].		"</li>";
					$output .= "<li>Keresznév  : ".$row['kernev'].		"</li>";
					$output .= "<li>Lakhelye   : ".$row['varos'].		"</li>";	
					$output .= "<li>Email címe : ".$row['email'].		"</li>";
					$output .= "</ul>";	
					
					if($row['jog']!=1)
					{
					$output .= "<form style='float:left;' action='delete.php' method='POST' >";													
					$output .= "<input type='hidden' name='torlendonev' value= '".$row['felhnev']."'/>";
					$output .= "<input type='submit'  value='A felhasználó törlése:' />";
					$output .= "</form>";				
					}
					
					$output .= "<form style='float:left;' action='modosito.php' method='POST'>";
					$output .= "<input type='hidden' name='modositandonev' value= '".$row['felhnev']."' />";								
					$output .= "<input type='submit' value='Az adatok módosítása!' />";						
					$output .= "</form>";							
					$output .= "</div>";						
				}		
			}
			else
			{
				echo "Nem volt egy találatunk sem a lekérdezésre!";
			}
		
	return $output;
	$con->close();	
	}

	/*Felhasználói adatok módosítása
	Nem csak db-műveletet végez hanem ki is írja.*/
	function keresettnevlistazo($modositandonev){
	$ellenorzo = new funkciok();
	$con;
	dbconnect($con);	
	
	$ellenorzo = new funkciok();
	$ellenorzo->bemenet_ellenorzes($modositandonev);
	$ellenorzo->sql_tamadas($modositandonev);
	
	$sql = "SELECT * FROM `felhasznalok` WHERE felhnev LIKE '$modositandonev';";
	$result = $con->query($sql);

	$output = "";
	if($result->num_rows>0)
			{
				while($row = $result->fetch_assoc())
				{			
					$output .= "<form action='felhmodosito.php' method='POST'>";	
					//$output .= "Jogosultság: (1-es ADMIN jogok,3-as felhasználói jogok! Kötelező!)";					
					//$output .= "</br><input type='number'  name='jogosultsag' min='1' max='9' value='".$row['jog']."' required /></br>";		
					$output .= "Jelszó: (Min. 5 - max. 40 karakter) Kötelező!";						
					$output .= "</br><input type='password' name='jelszo'  minlength='5' maxlength='40' value='".$row['jelszo']."' required /></br>";	   
					$output .= "Felhasználónév: (Min. 3 - max. 30 karakter) Kötelező!";				
					$output .= "</br><input type='text'  	name='felhnev' 	minlength='3' maxlength='30' value='".$row['felhnev']."' required /></br>";		   
					$output .= "Vezetéknév: (Min. 2 - max. 50 karakter)	Kötelező!";  	 					
					$output .= "</br><input type='text'  	name='veznev' minlength='2'	maxlength='50' value='".$row['veznev']."' required /></br>";	   
					$output .= "Keresztnév: (Min. 2 - max. 50 karakter) Kötelező!";							
					$output .= "</br><input type='text'  	name='kernev' minlength='2'	maxlength='50' value='".$row['kernev']."' required /></br>";	   
					$output .= "Ország: (Min. 2 - max. 40 karakter)"; 										
					$output .= "</br><input type='text'  	name='orszag' minlength='2'	maxlength='40' value='".$row['orsz']."' /></br>";					   
					$output .= "Irányítószám: (Min 2. - max 10 hosszúság!)";								    
					$output .= "</br><input type='text'  	name='irsz'   minlength='2'	maxlength='10' value='".$row['irsz']."' /></br>";					   
					$output .= "Város: (Min 2. - max 50 hosszúság!)";								        
					$output .= "</br><input type='text'  	name='varos'  minlength='2'	maxlength='50' value='".$row['varos']."' /></br>";						   
					$output .= "Utca/Közterület: (Min. 2 - max. 60 hosszúság!)";								
					$output .= "</br><input type='text'  	name='utca'   minlength='2'	maxlength='60' value='".$row['utca']."' /></br>";				
					$output .= "Házszám/Emelet/Ajtó: (Min. 1 - max. 30 hosszúság!)";						    
					$output .= "</br><input type='text'  	name='hsz'  minlength='1' maxlength='30' value='".$row['hsz']."' /></br>";				
					$output .= "Telefonszám: (Max 20 hosszúság!)";									
					$output .= "</br><input type='text'  	name='telefon'  maxlength='20' value='".$row['telefon']."' /></br>";		
					$output .= "Email cím: (Max 80 hosszúság!)";							
					$output .= "</br><input type='email' name='email' maxlength='80' value='".$row['email']."' pattern='+@+' /></br>";	
					
					$output .= "<input type='hidden' name='modositandonev' value= '".$row['felhnev']."' />";								
					$output .= "<input type='submit' value='Az adatok módosítása!' />";						
					$output .= "</form>";	
					$output .= "</tr>";				
				}		
			}
			else
			{
				echo "Nem tudtuk betölteni a felhasználó adatait!";
			}
			
	
	return $output;
	$con->close();
	}

	/*Termék módosítás listázó , egy output-tal tér vissza ami megjelenít is.*/
	function keresett_termek($modositandotermeknev){
		
	$ellenorzo = new funkciok();
	$con;
	dbconnect($con);	
	
	$kiiro = new dbmuveletek();
	
	$sql = "SELECT aktive,termekcim,termekar,leiras,kulcssz,darab,kategelh,kategoria.kategorianev FROM termeklap,kategoria WHERE termekcim LIKE '$modositandotermeknev' AND termeklap.kategelh = kategoria.kategoriaid;";
	
	$result = $con->query($sql);
	$output = "";
	
	if($result->num_rows>0)
			{
				while($row = $result->fetch_assoc())
				{	
				$output.= "<form action='termekmod.php' method='POST' enctype='multipart/form-data' >";
				
				$output.= "Termék címe:  (Min 10. karakter , Max.:120)</br><input type='text' name='termekcim'  minlength='10' maxlength='120' value='".$row['termekcim']."' required /></br>";
				
				$output.= "Termék ára (A mezőbe lehet írni is!): </br><input type='number' name='termekar' min='10' max='9999999999' value='".$row['termekar']."' required /></br>";
				
				$output.= "Termék leírása (Max 65535 karakter): </br>";
				// Alapesetben a textarea nem támogatja a value funkciót
				//$output.= "<textarea name='termekleiras' maxlength='65534' rows='40' cols='100' palceholder='".$row['leiras']."' required >"; 
				//$output.= "</textarea></br>";
				
				$output.= "<input style='/*width:98%; height:500px; word-break:break-all;*/' name='leiras' type='text' maxlength='65535' value='".$row['leiras']."' required /></br>";
				
				$output.= "Termékkel kapcsolatos kulcssszavak (Max 80 karakter!):( ','-vel elválasztva!)   </br><input type='text' name='termekkulcsszavak'  maxlength='80' value='".$row['kulcssz']."' required /></br>";
				
				$output .= "Termék darabszáma: (Max 999 db):      </br><input type='number' name='termekdarab' min='1' max='999' value='".$row['darab']."' required /></br>";

				$output .= "Aktív e? (1-igen,0-nem) </br><input type='number' name='aktive' min='0' max='1' value='".$row['aktive']."' required /></br>";
					
				//A Kategória kiolvasást, és hogy alapból az legyen a selected, nem sikerült még megoldani. 2020.08.30
				//$output .= "<select name='valasztottkategoria' >";	
											
				//KategoriaID az átadott érték egy SMALLINT																				
				//$output .= "<option value=".$row['kategorianev']."selected>".$row['kategorianev']."</option>";	
				
				$output .= "</select></br>";
							
				$output .= "<input type='hidden' name='modositasraszantermekcim' value= '".$row['termekcim']."' />";								
				$output .= "<input type='submit' value='Az adatok módosítása!' />";						
				$output .= "</form>";	
				$output .= "</tr>";			
				}
			}
	return $output;		
	$con->close();
	}

	//A felhasználó törlését elvégző függvény. Megjelenítést hív eredménnyel.
	function felhasznalotorles($felhnev){
	$eredmeny;	
	$con;
	dbconnect($con);	
	//Tulajdonképp felesleges a védelem mert a beviteli mezőben védtük.
	if($felhnev)
	{
	$keresettnev = $con->real_escape_string($felhnev);	
	$sql = "DELETE FROM `felhasznalok` WHERE felhnev LIKE '$felhnev';";
	}

	$con->query($sql);	
	if($con->query($sql) == true)
			{
				$eredmeny = "Sikeres törlés";
			}
			else
			{
				$eredmeny = "Sikertelen törlés";
			}
		
	
	$con->close();		
	$amn = new AdminNezet(); 		
	$amn->AdminFelhasznaloModTorl($eredmeny);
	return $eredmeny;
	}

	//A termék elérhető paramétereit módosító függvény! Megjelenítést hív eredménnyel.
	function TermekModositoDB($termekcim,$termekar,$leiras,$termekkulcsszavak,$termekdarab,$modositasraszantermekcim,$aktive){
	$con;
	dbconnect($con);
	
	$ellenorzes = new funkciok();
	$ellenorzes->sql_tamadas($termekcim);
	$ellenorzes->sql_tamadas($termekar);
	$ellenorzes->sql_tamadas($leiras);
	$ellenorzes->sql_tamadas($termekkulcsszavak);
	$ellenorzes->sql_tamadas($termekdarab);
	$ellenorzes->sql_tamadas($modositasraszantermekcim);
	$ellenorzes->sql_tamadas($aktive);
	
	$ellenorzes->bemenet_ellenorzes($termekcim);
	$ellenorzes->bemenet_ellenorzes($termekar);
	$ellenorzes->bemenet_ellenorzes($leiras);
	$ellenorzes->bemenet_ellenorzes($termekkulcsszavak);
	$ellenorzes->bemenet_ellenorzes($termekdarab);
	$ellenorzes->bemenet_ellenorzes($modositasraszantermekcim);
	$ellenorzes->bemenet_ellenorzes($aktive);
	
	$sql = "UPDATE termeklap SET aktive = '$aktive', termekcim = '$termekcim',termekar = '$termekar',leiras = '$leiras',kulcssz = '$termekkulcsszavak',darab = '$termekdarab' WHERE termekcim LIKE '$modositasraszantermekcim';"; 
	
	$result = $con->query($sql);
	if($result)
			{
				$eredmeny = "Sikeres termék adat módosítás!";
			}
			else
			{
				$eredmeny = "Sikertelen termék adat módosítás!";
			}	
	
	
	$amn = new AdminNezet();
	$amn->AdminAlTermekModosito($eredmeny);
	$con->close();
	}		
	
	/*A terméket aktiv vagy archívba állító függvény. Megjelenítést hív eredménnyel. A $parameter-től függően adja vissza az eredményt is ami
	tájékoztatta az adminisztrátort hogy pontosan mi történt.*/
	function TermekAktivArchivSet($modositandotermeknev,$parameter){
	$con;
	dbconnect($con);
	$ellenorzes = new funkciok();
	
	$ellenorzes->sql_tamadas($modositandotermeknev);
	$ellenorzes->bemenet_ellenorzes($modositandotermeknev);
	$ellenorzes->sql_tamadas($parameter);
	$ellenorzes->bemenet_ellenorzes($parameter);
	
	if($parameter == 0)
		$sql = "UPDATE termeklap SET aktive = 1,darab = 1 WHERE termekcim LIKE '$modositandotermeknev';";
	
	
	if($parameter == 1)
		$sql = "UPDATE termeklap SET aktive = 0,darab = 0 WHERE termekcim LIKE '$modositandotermeknev';";
	
		
	$result = $con->query($sql);
	if($result)
			{
				if($parameter == 0)
					$eredmeny = "Sikeresen áthelyeztük a terméket az aktív termékek közé,és 1 db-ot tettünk elérhetővé!";
				
				if($parameter == 1)
					$eredmeny = "Sikeresen áthelyeztük a terméket az archívumba,és a darabszámát nullára csökkentettük!";
			}
			else
			{
				$eredmeny = "Sikertelen áthelyezés!";
			}	
		
	$amn = new AdminNezet();
	
	$amn->AdminAlCsakTermekListazo($parameter,$eredmeny);
	$con->close();
	}
		
	//A terméket törlő függvény. Megjelenítést hív eredménnyel.
	function TermekTorloDB($torlendonev){
	$con;
	dbconnect($con);
	
	$ellenorzes = new funkciok();
	
	$ellenorzes->sql_tamadas($torlendonev);
	$ellenorzes->bemenet_ellenorzes($torlendonev);
	
	$sql = "DELETE FROM `termeklap` WHERE termekcim LIKE '$torlendonev';";

	$result = $con->query($sql);
	if($result)
			{
				$eredmeny = "Sikeres termék törlés!";
			}
			else
			{
				$eredmeny = "Sikertelen termék törlés!";
			}	
	
	
	$amn = new AdminNezet();
	$amn->AdminAlTermekModosito($eredmeny);	
	$con->close();
	}
	
	//A felhasználó adatait módosító függvény , kizárólag adatbázis műveleteket végez.$jogosultsag kivéve mert a menetközbeni módosítás problémát okozott.
	function felhasznalo_osszes_adat_modosito($modositandonev,$jelszo,$felhnev,$veznev,$kernev,$orszag,$irsz,$varos,$utca,$hsz,$telefon,$email)
	{
	$con;
	dbconnect($con);
	$ellenorzes = new funkciok();
	
	//Sql Injection támadás elleni védelem.
	//$ellenorzes->sql_tamadas($jogosultsag);
	$ellenorzes->sql_tamadas($jelszo);
	$ellenorzes->sql_tamadas($felhnev);
	$ellenorzes->sql_tamadas($veznev);
	$ellenorzes->sql_tamadas($kernev);
	$ellenorzes->sql_tamadas($orszag);
	$ellenorzes->sql_tamadas($irsz);
	$ellenorzes->sql_tamadas($varos);
	$ellenorzes->sql_tamadas($utca);
	$ellenorzes->sql_tamadas($hsz);
	$ellenorzes->sql_tamadas($telefon);
	$ellenorzes->sql_tamadas($email);      	
	//Bemenet ellenőrzés védelem saját osztályból.
	//$ellenorzes->bemenet_ellenorzes($jogosultsag);
	$ellenorzes->bemenet_ellenorzes($jelszo);	
	$ellenorzes->bemenet_ellenorzes($felhnev);	
	$ellenorzes->bemenet_ellenorzes($veznev);	
	$ellenorzes->bemenet_ellenorzes($kernev);	
	$ellenorzes->bemenet_ellenorzes($orszag);	
	$ellenorzes->bemenet_ellenorzes($irsz);
	$ellenorzes->bemenet_ellenorzes($varos);	
	$ellenorzes->bemenet_ellenorzes($utca);		 
	$ellenorzes->bemenet_ellenorzes($hsz);		 
	$ellenorzes->bemenet_ellenorzes($telefon);	
	$ellenorzes->bemenet_ellenorzes($email); 
	$jelszo = sha1($jelszo);	
	$sql = "UPDATE felhasznalok SET jelszo = '$jelszo',felhnev = '$felhnev',veznev = '$veznev',kernev = '$kernev',orsz = '$orszag',irsz = '$irsz',varos = '$varos',utca = '$utca',hsz = '$hsz',telefon = '$telefon',email = '$email' WHERE felhnev LIKE '$modositandonev';";  
	
	$result = $con->query($sql);
	if($result)
			{
				$eredmeny = "Sikeres felhasználói adat módosítás!";
			}
			else
			{
				$eredmeny = "Sikertelen felhasználói adat módosítás!";
			}	
	
	$con->close();
	$amn = new AdminNezet();
	$amn->AdminFelhasznaloModTorl($eredmeny);
	//return $siker; íGY 'ÜRES' KÉPET ADOTT
	}

	//KATEGÓRIA nevét listázó és azzal visszatérő függvény
	function kategoria_nevlistazo($kategoriaid){
	$con;
	dbconnect($con);
	
	$sql = "SELECT kategorianev FROM kategoria WHERE kategoriaid = '$kategoriaid';";
	$result = $con->query($sql);
	$output = "";
	
	if($result->num_rows>0)
		{			
			while($row = $result->fetch_assoc())
			{						
			$output .= "$row[kategorianev]";					
			}
		}
		else
		{
		echo "Nem volt találat a kategóriák lekérdezésére!";	
		}
	return $output;	
	$con->close();
	}
	

	//KATEGÓRIA LISTÁZÓ a termék választáshoz legördülő menühöz. Használatban a termékfeltöltésnél.
	function kategoria_listazo(){
	$con;
	dbconnect($con);

	$sql = "SELECT kategoriaid,kategorianev FROM kategoria;";
	$result = $con->query($sql);

	$output = "";
		if($result->num_rows>0)
		{	
			while($row = $result->fetch_assoc())
			{						
			echo "<option value='$row[kategoriaid]'>$row[kategorianev]</option>";		//KategoriaID az átadott érték egy SMALLINT							
			}
	
		}
		else
		{
		echo "Nem volt találat a kategóriák lekérdezésére!";	
		}
	
		//próba volt alkategória listázásra
		/*$sql = "SELECT id, szuloid, kategorianev FROM kategoriakteszt WHERE szuloid = 0 ORDER BY kategorianev;";	
		$result = $con->query($sql);	
			
		if($result->num_rows>0)
		{	
			while($row = $result->fetch_assoc())
			{						
				$sqlalkategoria = "SELECT kategorianev FROM kategoriakteszt WHERE szuloid = '$row[szuloid]' "; 
				$resultkategoria = $con->query($sqlkategoria);
				
				echo "<option value='$row[id]'>$row[kategorianev]<select>'$row[id]'</select>
					</option></br>";							
				
				echo "<select>";
				echo "<option value=1>lldlld</option>";
				echo "</select>";
			}
	
		}
		else
		{
		echo "Nem volt találat a kategóriák lekérdezésére!";	
		}*/
			
	$con->close();
	}

	/*Kategória elemeit táblába listázza! Visszatért egy táblázatot tartalmazó stringgel.
	Kilistázza az eredeti kategória nevet , majd felkínálja az új név felvitelének lehetőségét is!
	A termékek kategóriáját nem kell át-setelni mert azok kategóriája csak hivatkozásként van meg a terméklapjukon.Módosítás után
	minden termék aminek az adott kategoria id volt a kategóriája már az új néven elérhető*/
    function kategorialisttabl(){
	$con;
	dbconnect($con);
	$sql = "SELECT kategoriaid,kategorianev FROM kategoria ORDER BY kategorianev;";
	$result = $con->query($sql);
	$output = "";
	if($result->num_rows>0)
	{	
		while($row = $result->fetch_assoc())
		{
			$output .= "<tr>";
			$output .= "<td>Eredeti kategória neve:</br>'".$row['kategorianev'].
						"'<form action='kategoriamodositas.php' method='POST'>
						 <input type='hidden' name='regikategorianev' value='".$row['kategorianev']."'/>
						 <input type='submit' value='A kategória módosítása:'/></br>";
			
			
			$output .= "<input type='text' placeholder='Új név!' name='ujkategorianev' required /></td>";
			$output .= "</form>";	
			$output .= "</tr>";
		}	
	}
	else
	{
	echo "Nem találtunk kategóriát a lekérdezésre!";	
	}
	
	return $output;
	$con->close();
	}
	
	//Egy sima kategória listázó a képernyő jobb oldalára
	function kategorialist(){
	$con;
	dbconnect($con);
	
	$sql = "SELECT kategoriaid,kategorianev FROM kategoria ORDER BY kategorianev;";
	$result = $con->query($sql);
	echo "<h3>Az elérhető kategóriák listája:</h3>";
		if($result->num_rows>0)
		{	
			
			while($row = $result->fetch_assoc())
			{						
			echo "$row[kategorianev]</br>";		
						
			}
		}
		else
		{
		echo "Nem volt találat a kategóriák lekérdezésére!";	
		}
	
	}

	//Kategória módosítását végrehajtó függvény.
	function kategoriamodositasdb($regikategorianev,$ujkategorianev){
		
		$con;
		dbconnect($con);
		$eredmeny;
		
		if($regikategorianev && $ujkategorianev)
		{
		$sql = "UPDATE `kategoria` SET kategorianev = '$ujkategorianev' WHERE kategorianev = '$regikategorianev';";
		}
		$con->query($sql);
		
		if($con->query($sql) == true)
		{
			$eredmeny = "Sikeres kategória módosítás!";
		}
		else
		{
			$eredmeny = "Sikertelen kategória módosítás!";
		}
		$con->close();
		$amn = new AdminNezet();
		$amn->AdminAlKategoriaModositas($eredmeny);
		//return $eredmeny;
	}

}


class funkciok{
	
	function set($nev, $ertek){
	$this->$nev = $ertek;
	}
		
	function bemenet_ellenorzes($input){
	$input = trim($input); //A szöveg elejéről és végéről is levágja a space-t (sortörés,tab szóköz)
	$input = stripcslashes($input); //Egyszeres és kétszeres és a visszaper \ és a NULL karakterek. Hogy ne vezérlő karakternek vegye őket át.
	$input = htmlspecialchars($input); //Esetleges HTML vezérlő karakterek levágása
	return $input;
	}
	
	
	function jelszo_vedelem($input){
	$input = sha1($input);
	return $input;
	}
	
	
	//real_escap...A MySqlInjection elleni védelem
	function sql_tamadas($input){
	$con;
	dbconnect($con);	
	$input = $con->real_escape_string($input);
	$con->close();
	return $input;
	}
	

	/*A Függvény vizsgálja hogy POSTON 'termekadatok' -on jött e valami , ha igen akkor a fájlt is átveszi.
	Tehát a függvény csak akkor működik ha a termékfeltöltő oldalról jövünk! És több fájlt is át tud venni , de csak három fájlt teszünk neki lehetővé.*/
	function fajl_feltolto(){
	
		$vissza = new AdminNezet();
			
			//Adminosztály termékfelvételénél ezek az adatok post-ról érkeznek.
			if(isset($_POST['termekadatok']))
			{
				//A fájlok száma,megszámoljuk hány fájl érkezett!
				$countfiles = count($_FILES["feltoltendofile"]["name"]); 	
		
					if($countfiles>3)
					{
					$siker = "HIBA! Csak három képfájlt tölthetsz fel!</br>";
					$vissza->AdminTermekBeszuras($siker);
					exit;
					}
					else
					{	
					//Sorra vesszük a fájlokat
					for($i=0;$i<$countfiles;$i++)
					{			
						if ($_FILES['feltoltendofile']['error'][$i] > 0)
						{
								echo 'HIBA: ';
								switch ($_FILES['feltoltendofile']['error'][$i])
								{
								case 0: echo 'Nincs hiba';
										break;
							
								case 1: echo 'A fájlméret meghaladja a maximálisan feltölthető méretet amelyet a php.ini beállítás megengedne!';
										break;
									
								case 2: echo 'A fájlméret meghaladja a HTML űrlapon limitált méretet! (10 Megabájt)';
										break;
									
								case 3: echo 'A fájl csak részlegesen lett feltöltve!';
										break;
									
								case 4: echo 'Nem történt meg a fájl feltöltése!';
										break;
									
								case 6: echo 'A php.ini fájlban nincs meghatározva az ideiglenes könyvtár a fájloknak!';
										break;
									
								case 7: echo 'A fájl lemezre írása nem sikertelen!';
										break;
								}
								exit;
						}	
						
						//Mime ellenőrzés nem jó! Kellene még ellenőrizn!i!					
						/*if ($_FILES['feltoltendofile']['type'][$i] != 'image/jpg')
						{
						$siker = "HIBA! A Fájl csak kép (jpg) fájl lehet. </br>";
						$vissza->AdminTermekBeszuras($siker);
						exit;
						}				
						else	
						{*/
							$filename[$i] = array($_FILES['feltoltendofile']['name'][$i]); //$filename tömb-be kerüljön be az aktuális i-edik eleme a $_FILES tömbnek.
							$FajlNev = $_FILES['feltoltendofile']['name'][$i]; // Feltöltött fájl elmentése
							$Forras  = $_FILES['feltoltendofile']['tmp_name'][$i];
							$Cel     = 'konyvtar/'.$_FILES['feltoltendofile']['name'][$i]; //A feltöltött fájl - kép ide kerül , de innen még áthelyeződik
							if (file_exists($Cel)) 
							{
							echo $Cel . " már létezik. ";
							echo "<br/>";	
							} 
							else 	
							{
							move_uploaded_file($Forras,$Cel);
							//echo "Feltöltve: " . $Cel;
							echo "<br/>";
							}							
						//}																
						}
					}			
			}
			
			else
			{
			echo "HIBA Az űrlap (POST) adatátadásnál!";
			}
			
	return $filename;
	}
} 

?>

