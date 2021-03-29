<?php
include_once("dbconnect.php");

class Weboldal{
	

	public $tartalom; //tagváltzók
	
	//public $cim = "<img class='img-fluid float-left' src='logo.png'></img>";
	
	public $udvozlet = "Üdvözöllek a Gyűjtő szentélyében, kedves: ";
	
	public $informaciok = 
	
	"<h4>Bármilyen kérdéssel bizalommal fordulj hozzám:</h4>
	
	<div class='p-3 mb-2 bg-info text-black'>A webáruházam a nap 24 órájában elérhető, viszont engem csak munkanapokon 12-18 óra között érsz el.</div>
	
	Email:<div class='p-3 mb-2 bg-info text-black'>rimoczykolos@gmail.com</div>
	
	Telefonszám:<div class='p-3 mb-2 bg-info text-black'>06601111111.</div>
	
	Fizetési módok:<div class='p-3 mb-2 bg-info text-black'>Bankszámlára utalás,Paypal fizetés.</div>
	
	
	
	A vásárlással kapcsolatos egyéb információk:
	
	<div class='p-3 mb-2 bg-info text-black'>A megjelölt árak áfát tartalmaznak!
	
	A termékeket megfelelő csomagolásban küldjük számodra 1-3 munkanap alatt.</div>
	
	A választható futárszolgálatok : 
	<div class='p-3 mb-2 bg-info text-black'>Magyar Posta , FoxPost , DHL , DPD.</div>
	
	Számlázás:
	<div class='p-3 mb-2 bg-danger text-black'>Minden vásárlásról számlát kapsz, ehhez kérjük majd add meg a pontos adataidat!
	
	A pontatlanul megadott adatok miatt felelősséget nem vállalunk!</div>
	
	A termékek:
	<div class='p-3 mb-2 bg-success text-black'>Termékeink egyedülálló dolgok, melyeket gyűjtőknek szánunk. Mivel a termékeink szinte minden esetben egyedülálló
	
	termékek, így fontos tudnod, hogy amiből esetleg több darab van, abból is csak egy darabot tehetsz a kosaradba egyszerre.
	
	Azért van ez, mert hiába van egy ritka érme a kínálatban, és hiába van belőle kettő darab, a kettő állapot nyilván eltérhet,még akkor 
	
	is ha csak minimálisan.
	
	Egy 'következő' vásárlásban természetesen újra vásárolhatsz belőle,de a termék fizikai paraméterei eltérhetnek.</div>
	
	Egyéb:
	<div class='p-3 mb-2 bg-warning text-black'>
	A személyes adatokat bizalmasan kezeljük,azokat harmadik félnek nem adjuk ki, csak hatósági megkeresés esetén. Az adatok és a személyes adatok tárolására vonatkozó alapelvek megfelelnek a GDPR elveinek.
	Az oldallal kapcsolatos minden jog a készítőt illet meg. Bármilyen adat vagy kép felhasználása csak a tulajdonos engedélyével lehetséges.
	</div>";
	

	
	
	
	//Változó gombsor elemei, át kell majd írni a gombokat. Később bővülhet
	public $gombok = array("Kezdőlap " 		=> 	"index.php",
						   "Regisztrálás/Adatmódosítás "	=>	"regisztracio.php",
						   "Információk " 		=>	"kontakt.php",
						   "Keresés "		=>  "kereses.php",
						   "Kijelentkezés " => "logout.php"
						   );
						   
						   
	function __set($nev, $ertek){
		$this->$nev = $ertek;
	}
	
	//Belépés vizsgáló függvény.
	public function IsLogin(){
		if(isset($_SESSION['felhasznalo_nev']) )
			return true;
		else
			return false;
	}
		
	/*A Nagy terméklapot megjelenítő függvény. Vizsgálja hogy aktív vagy nem aktív termék id-t kapott e,és eszerint jelenít meg!
	Alapesetben aktívat kap a főoldal/termékmegjelenítésről.*/
	public function Nagytermeklap($termekid){
	//SQL lekérdezés kell ami az adott ID kérdezi le.
	
	$meg = new FelhasznaloiDbMuveletek();
	
	//Ha a termek id aktive 1 és ha 0. HA 1 akkor az aktív termék lapot mutatja az elérhető termékkel
	//Ha 0 akkor a nem elérhető terméket mutatja.
	if($meg->termekaktive($termekid)==1)
	{	
	$tomb=$meg->termekidlekerdezes($termekid);
	}
	else
	{	
	$tomb=$meg->termekidlekerdezes_nemaktiv($termekid);
	}
	echo "<hr>";	
	
	//Ha aktív (1) akkor felkínáljuk a kosár gombot , ha nem akkor nem.
	if($meg->termekaktive($termekid)==1)
	{	
	echo "<form action='kosar.php' method='POST' >";
	echo "<input type='hidden' name='kosarid' value=".$termekid." />";
	echo "<input class='btn btn-outline-success btn-lg float-right' type='submit' value='Kosárba helyez!' />";
	echo "</form>";
	}

	/* Megjelenítés: */		
	echo "<h5 class='text-break'>".$tomb[0]["Termékcím"].".</h5><br><hr>";	
	echo "Elérhető:<b> ".$tomb[0]['Darab']."</b> darab.<hr>";
	
	echo "<h4><p class='text-warning'><b>".$tomb[0]["Termékár"]." Ft.</p></b></h4><hr>";	
	echo "<b>Kulcsszavak:</b></br>".$tomb[0]["Kulcsszavak"]."</br><hr>";	
	echo "<b>Leírás:</b><p class='text-break'>".$tomb[0]["Leírás"]."</p><br><br><br><hr>";	
	
	$kategoria = $meg->KategoriaNevListazo($tomb[0]['Kategória']);
	
	echo "<b>Kategória:</b> ".$kategoria."<br><hr>";
	
	echo "<a href='".$tomb[0]['Kep1']."' target='_blank'><img class='nagytermeklapkep' float:right;' src='".$tomb[0]['Kep1']."'></a>"; 			
	echo "<a href='".$tomb[0]['Kep2']."' target='_blank'><img class='nagytermeklapkep' float:right;' src='".$tomb[0]['Kep2']."'></a>";
	echo "<a href='".$tomb[0]['Kep3']."' target='_blank'><img class='nagytermeklapkep' float:right;' src='".$tomb[0]['Kep3']."'></a><hr>";
	}
		
	
	/*
	A fő oldalon a listázott termékeket megjelenítő függvény.
	Át kell neki adni a kiolvasott paramétereket, az adott termék paramétereit,mely egy asszoc. tömb!
	Egy $tomb - tömböt kap,  ami egy 10-es rendezett lekérdezés, melyet 'véletlenszerűen jelenítünk meg, a tömb elemeit keverő fgv. segítségével.
	A Függvény más esetben is alkalmas a termékek megjelenítésére , a lekérdezés milyenségétől függ hogy mit hogyan listáz.*/
	public function kistermeksav($tomb){	
			
			//bootstrap	
			for($i=0;$i<sizeof($tomb);$i++)	
			{			
				
			echo "<hr>";
			
			echo "<div class='container-fluid row'>";
			
					$aktualistermekid = $tomb[$i]['termekid'];
						
					echo "<div id='row'>";
					echo "<h3 class='text-break'><b class='text-muted'>".$tomb[$i]["Termékcím"]."</b></h3>";
									
							
					echo "<p class='text-success font-weight-bold h3'>".$tomb[$i]["Termékár"]." Ft.</p>";	
					echo "<b>Elérhető: </b>".$tomb[$i]["Darab"]." darab.<br>";			
					echo "<b>Kulcsszavak: </b>".$tomb[$i]["Kulcsszavak"]."<br>";		
					echo "</div>";
						
					echo "<div id='row'>";
						
						$aktive = $tomb[$i]['Aktive'];
						
						
						echo "<div class='col-sm-4 float-left d-block kepalul'>";
						echo "<a href='".$tomb[$i]['Kep1']."' target='_blank'><img class='img-fluid' src='".$tomb[$i]['Kep1']."'></a>";
						echo"</div>"; 			
							
						echo "<div class='col-sm-4 float-left d-none d-md-block kepalul'>";
						echo "<a href='".$tomb[$i]['Kep2']."' target='_blank'><img class='img-fluid' src='".$tomb[$i]['Kep2']."'></a>";
						echo"</div>"; 
					
						echo "<div class='col-sm-4 float-left d-none d-lg-block kepalul'>";
						echo "<a href='".$tomb[$i]['Kep3']."' target='_blank'><img class='img-fluid' src='".$tomb[$i]['Kep3']."'></a>";
						echo "</div>";				
					echo"</div>"; 
				
					echo "<div id='row'>";
					
					echo "<form class='float-left pr-2' action='teljestermeklap.php' method='POST' >";
					echo "<input type='hidden' name='termekid' value=".$aktualistermekid." >";
					echo "<input class='btn btn-success' type='submit' value='Terméklap' >";		
					echo "</form>";
							
					if($aktive == 1)
					{
					echo "<form class='float-left pr-2' action='kosar.php' method='POST' >";
					echo "<input type='hidden' name='kosarid' value=".$aktualistermekid." >";			
					echo "<input class='btn btn-primary' type='submit' value='Kosárba teszem!' >";
					echo "</form>";
					}						
					echo "</div>";					
			echo "</div>";				
			}			
			
			//JPG jegyzet
			//Kép átméretezéssel kapcsolatos jegyzetek.
			//$fixmeretw =200;
			//$fixmereth =120;
			//echo imagesy('$img1');
			//echo imagesx('$img1');
			// Kép átméretezés , fixálás a gond
			//https://prog.hu/tudastar/149345/imagecopyresampled-sugjatok
			// https://www.php.net/manual/en/function.imagecopyresampled.php
			//$meretek tombbe mentem a kép méreteit.  A 0 és 1 -es kulcsok a szélesség (W) és a magasság (H)
			// https://prog.hu/tudastar/165813/kep-atmeretezese-php
			//$meretek = getimagesize($img1);
			//$img1w = $meretek[0];
			//$img1h = $meretek[1];
			// bootstrap dropdown gomb menü használata
			//$ujkep = ImageCreateTrueColor($fixmeretw,$fixmereth);
			// tömbök https://www.fzolee.hu/fw/12_tombok_tombkezelo_fuggvenyek
			//ImageCopyResampled($ujkep ,$img1 ,0,0,0,0,$fixmeretw ,$fixmereth ,$img1w ,$img1h);
			//$imgjpg_dst=$img1;
			//ImageJPEG($ujkep, $imgjpg_dst, 100);
			//print_r($meretek);
			//print_r($img1w);
			//print_r($img1h); style='height:210px; width:150px; 
			// Kellene vizsgálani a képet hogy álló vagy fekvő és aszerint állítani
			//echo "<img style='height='200px'; width='300px'; float:left;' src='".$tomb[0]["Kép 2:"]				."'>";	
			//echo "<img style='height='25%'; width='25%'; float:left;' src='".$tomb[0]["Kép 3:"]				."'>";	
			//$meretek = getimagesize($img1);
			//$img1w = $meretek[0];
			//$img1h = $meretek[1];	
			/*if($img1w>$img1h)
			{	//Itt az fekvő képet
			$arany = "280px";
			echo "<img style='max-width:100%; max-height:100%; float:right;' src='".$tomb[0]["Kép 1:"]."'>"; 
			}
			else
			{  //Itt az álló képet
			$arany = "220px";
			echo "<img style='max-width:100%; max-height:100%; float:right;' src='".$tomb[0]["Kép 1:"]."'>";
				}*/								
		
	}
		
	/* A Regisztráció nélküli vásárló adatait beszúró űrlap! */
	public function RegNelkulUrlap(){
		
		echo "<h3>Add meg az adaidat a vásárlás folytatásához!</h3>";
		
		echo "<form action='vasarlas.php' method='POST' >";
		
			echo "<div class='row'>";
				echo "<div class='col'>";
				echo "Vezetéknévnév: (Max. 50 kar.)							
				</br><input class='form-control' type='text'  	name='veznev' minlength='2'	maxlength='50' required /></br>";
				echo "</div>";
				
				echo "<div class='col'>";
				echo "Keresztnév: (Max. 50 kar.)   	 					
				</br><input class='form-control' type='text'  	name='kernev' minlength='2'	maxlength='50' required /></br>";
				echo "</div>";
			echo "</div>";
			
			echo "<div class='row'>";
				echo "<div class='col'>";
				echo "Ország: (Max. 40 kar.)	
				</br><input class='form-control' type='text'  	name='orszag' minlength='2'	maxlength='40' required /></br>";
				echo "</div>";
		
				echo "<div class='col'>";
				echo "Irányítószám: (Max. 10 kar.)   	 					
				</br><input class='form-control' type='text'  	name='irsz' minlength='2'	maxlength='10' required /></br>";
				echo "</div>";
			echo "</div>";
		
			echo "<div class='row'>";
				echo "<div class='col'>";
				echo "Város: (Max. 50 kar.)	
				</br><input class='form-control' type='text'  	name='varos' minlength='2'	maxlength='50' required /></br>";
				echo "</div>";
		
				echo "<div class='col'>";
				echo "Utca: (Max. 60 kar.)   	 					
				</br><input class='form-control' type='text'  	name='utca' minlength='2'	maxlength='60' required /></br>";
				echo "</div>";
			echo "</div>";
			
			echo "<div class='row'>";
				echo "<div class='col'>";
				echo "Házszám: (Max. 30 kar.)	
				</br><input class='form-control' type='text'  	name='hazszam' minlength='2'	maxlength='30' required /></br>";
				echo "</div>";
		
				echo "<div class='col'>";
				echo "Telefon: (Max. 20 kar.)   	 					
				</br><input class='form-control' type='text'  	name='telefon' minlength='2'	maxlength='20' required /></br>";
				echo "</div>";
			echo "</div>";
			
			echo "<div class='row'>";
				echo "<div class='col'>";
				echo "email: (Max. 80 kar.)	
				</br><input class='form-control' type='text'  	name='email' minlength='2'	maxlength='80' required /></br>";
				echo "</div>";
			echo "</div>";
			
			
			echo "<hr>";
			
			echo "A vásárlás részleteit emailben is elküldjük neked.<br>";	
			echo "Hozzájárulsz hogy emailben megkeressünk kedvező ajánlatokkal?<br>";
			
			echo "<p class='text-success'>Hozzájárulok!<input type='radio' name='hozzajarul' checked value=1 /></p>";
			echo "<p class='text-danger'>Nem járulok hozzá!<input type='radio' name='hozzajarul' value=0 /></p>";
	
		echo "<input type='hidden' name='veglegesitesregnelkul' >";			
		echo "<input class='btn btn-outline-success' type='submit' value='Vásárlás véglegesítése!' >";
		echo "</form><br>";
		
		echo "<hr>";
		
		echo "<p class='float-left font-weight-bold text-info h4'>Fizetendő: ".$_SESSION['vegosszeg']."</p>";
	}
		
	/* A Regisztráció nélküli végleges vásárlás után betöltődő függvény mely betölti az űrlapot */
	public function RegNelkulVasarlasMegj($visszajelzes="",$aktid=""){
	
		echo "<!DOCTYPE html>";
		echo "<html>";
		echo "<head>";
		$this->MegjelenitesDesign();
		echo "</head>";
		
			//BODY
			echo "<body>";
					//KERET
					echo "<div id='keret'>";
						
						//FOCIM
						echo "<div id='focim'>";
						echo "<div class='container-fluid'><img class='container-fluid img-fluid 'src=hatt.png></div></img>";
						echo "</div>";
						//FOCIM
						
						//FEJLEC Itt van a visszajelző sáv,egy stringet kap és értesíti a vásárlót arról hogy sikeres volt
						//e az adott művelet.
						echo "<div class='container-fluid'>";
						echo "<div class='row'>";
						echo "<div id='fejlec'>";
						
						$this->MegjelenitesFejlec($visszajelzes);
								
							$this->KosarMegjelenites($aktid);
										
							echo "<div id='gombsor'>";
							$this->MegjelenitesGombok();
							echo "</div>";
						
						echo "</div>";
						echo "</div>";
						echo "</div>";
						//FEJLÉC
											
						//TARTALOM
						echo "<div id='tartalom'>";
													
							//KOZEPTARTALOM
							echo "<div id='baloldaltartalom'>";
							
							if($this->IsLogin())
							{
							//echo "Be vagy lépve függvény kell ide:";
							header("Location:vasarlas.php");
							/* Innen kell hívni a regelt felhasználü vásárlásait */ 
							
							
							}
							else{
							$this->RegNelkulUrlap();
							//IDE JÖN A TELJES TARTALOM!
							}
							
											
							echo "</div>";
							//KOZEPTARTALOM
							
							
							//JOBBOLDALTARTALOM
							echo "<div class='container-fluid'>";
							echo "<div class='row'>";
							echo "<div class='col-md-12'>";
							//echo "<div id='jobboldaltartalom'>";
							
							echo "<h3>Kategóriák:<br><br></h3>";
							$list = new FelhasznaloiDbMuveletek();
							
							$tomb = $list->kategorialistazo();
								
							echo "<h3 class='pb-2'>";	
							for($i=0; $i<sizeof($tomb); $i++)
							{		
							echo "<p><a href='kategszures.php?kategnev=".$tomb[$i]."'>".$tomb[$i]."</a></p>";
							}
							echo "</h3>";
							
							echo "</div>";
							echo "</div>";
							echo "</div>";
							//JOBBOLDALTARTALOM
												
						echo "</div>";	
						//TARTALOM
			
					
						//LÁBLÉC
						echo "<div id='lablec'>";
						$this->MegjelenitesLablec();
						echo "</div>";
						//LÁBLÉC
						
					
					echo "</div>";
					//KERET
		
			echo "</body>";		
		echo "</html>";	
			
	}
		
	//A kosár gombot megjelenító függvény. Session-ből kapja a darabszámot!
	public function KosarMegjelenites($aktid=""){

	echo "<div id='kosarhatter'>";		
	echo "<form class='float-right' action='kosarmegjelenites.php' method='POST' >";
	echo "<input type='hidden' name='termekid' value=".$aktid." />";
	echo "<input class='btn btn-outline-info' type='submit' value='KOSÁR(".$_SESSION['darab'].")'  />";
	echo "</form>";
	echo "</div>";	
	}

	//A regisztrációs űrlapot megjelenítő függvény
	public function RegisztraciosUrlap(){
					
		$felhasznalonev = "";
		$jelszo			= "";
		$vezeteknev 	= "";
		$keresztnev 	= "";
		$orszag			= "";
		$iranyitoszam  	= "";
		$varos			= "";
		$utca 			= "";
		$hazszam		= "";
		$telefon		= "";
		$email 			= "";

		
		//Ha valaki be van lépve , akkor kiolvassa az adatait , hogy egyből a módosítás lehetősége legyen meg. Ez esetben innen elérhető a korábbi 'vásárlásaim' is!
		if($this->IsLogin())
		{
		$felhasznalonev = $_SESSION['felhasznalo_nev'];
		$kiolvas 		= new FelhasznaloiDbMuveletek();
		
		$felhid = $kiolvas->felhidlekerdezes($felhasznalonev);
		
		echo "Korábbi vásárlásaim megtekintése: <br>";
		echo "<form class='float-left' action='korabbi-vasarlas.php' method='POST' >";
		echo "<input type='hidden' name='felhid' value=".$felhid." >";			
		echo "<input class='btn btn-outline-success' type='submit' value='Megtekintés!' >";
		echo "</form><br><br>";	
				
		echo "<br>Kedves <h4>".$_SESSION['felhasznalo_nev']."</h4>Itt tudod módosítani az adataid:";
		
		$outputtomb 	= $kiolvas->felhasznalolistazo($felhasznalonev);	
		$jelszo			= $outputtomb['jelszo'];
		$vezeteknev 	= $outputtomb['vezeteknev'];
		$keresztnev 	= $outputtomb['keresztnev'];	
		$orszag			= $outputtomb['orszag'];
		$iranyitoszam  	= $outputtomb['iranyitoszam'];
		$varos			= $outputtomb['varos'];
		$utca 			= $outputtomb['utca'];
		$hazszam		= $outputtomb['hazszam'];
		$telefon		= $outputtomb['telefon'];
		$email 			= $outputtomb['email'];			
		}
		
		
		echo "<form action='regisztral-modosit.php' method='POST'>";
		//echo "<input type='hidden' name='jogosultsag' value='3' required ></br>";
		
		echo "<div class='row'>";
			echo "<div class='col'>";
			echo "Vezetéknévnév: (Max. 50 kar.)							
			</br><input class='form-control' type='text'  	name='veznev' minlength='2'	maxlength='50' value='".$vezeteknev."' required /></br>";
			echo "</div>";
			
			echo "<div class='col'>";
			echo "Keresztnév: (Max. 50 kar.)   	 					
			</br><input class='form-control' type='text'  	name='kernev' minlength='2'	maxlength='50' value='".$keresztnev."' required /></br>";
			echo "</div>";
		echo "</div>";
		
		
		echo "<div class='row'>";
			echo "<div class='col'>";
			echo "Felhasználónév: (Max. 30 kar.) Ezzel a névvel és a jelszóval lehetséges a bejelentkezés.				
			</br><input class='form-control' type='text'  	name='felhnev' 	minlength='3' maxlength='30' value='".$felhasznalonev."' required /></br>";
			echo "</div>";
			
			echo "<div class='col'>";
			echo "Ország: (Max. 40 kar.)</br> 										
			</br><input class='form-control' type='text'  	name='orszag' minlength='2'		maxlength='40' value='".$orszag."' /></br>";
		echo "</div>";
		echo "</div>";
		
		
		echo "<div class='row'>";
		echo "<div class='col'>";
		echo "Jelszó: (Max. 40 kar.)						
		</br><input class='form-control' type='password' name='jelszo'  minlength='5' value='".$jelszo."' maxlength='40' required /></br>";		
		echo "</div>";
		
		echo "<div class='col'>";
		echo "Jelszó újra:						
		</br><input class='form-control' type='password' name='jelszoujra'  minlength='5' value='".$jelszo."' maxlength='40' required /></br>";		
		echo "</div>";
		echo "</div>";
			
		echo "<div class='row'>";
		echo "<div class='col'>";
		echo "Irányítószám: (Max 10 kar.)								    
		</br><input class='form-control' type='text'  	name='irsz'   minlength='2'		maxlength='10' value='".$iranyitoszam."' /></br>";
		echo "</div>";
		echo "<div class='col'>";
		echo "Város: (Max 50 kar.)								        
		</br><input class='form-control' type='text'  	name='varos'  minlength='2'	maxlength='50' value='".$varos."' /></br>";
		echo "</div>";
		echo "</div>";
		
		echo "<div class='row'>";
		echo "<div class='col'>";
		echo "Utca/Közterület: (Max. 60 kar.)								
		</br><input class='form-control' type='text'  	name='utca'   minlength='2'				maxlength='60' value='".$utca."' /></br>";
		echo "</div>";
		
		echo "<div class='col'>";
		echo "Házszám/Emelet/Ajtó: (Max. 30 kar.)						    
		</br><input class='form-control' type='text'  	name='hsz'  minlength='1' value='".$hazszam."'		maxlength='30' /></br>";
		echo "</div>";
		echo "</div>";
		
	
		echo "<div class='row'>";
		echo "<div class='col'>";
		echo "Telefonszám: (Max 20 kar.)									
		</br><input class='form-control' type='text'  	name='telefon'  		value='".$telefon."'		maxlength='20' /></br>";
		echo "</div>";
		echo "<div class='col'>";
		echo "Email cím: (Max 80 kar.)									
		</br><input class='form-control' type='email' 	name='email' 	maxlength='80' value='".$email."' pattern='+@+' /></br>";
		echo "</div>";
		echo "</div>";
		
		echo "</br><input type='submit' value='Regisztrálok/Módosítom az adataim!' /></br>";
		echo "</form>";				
	}	
			
	//A regisztrációs oldalt megjelenítő fő függvény és a KOSÁR gombot is!
	public function FoMegjelenesRegisztracio($visszajelzes="",$aktid=""){
	
				
				echo "<!DOCTYPE html>";
				echo "<html>";
				echo "<head>";
				$this->MegjelenitesDesign();
				echo "</head>";
				echo "<body>";
				
				//KERET
				echo "<div id='keret'>";	
				//FOCIM
					echo "<div id='focim'>";
					echo "<div class='container-fluid'>
					<img class='container-fluid img-fluid 'src=hatt.png></div></img>";
					echo "</div>";
				//FOCIM	
					
				//FEJLÉC
					echo "<div class='container-fluid'>";
					echo "<div class='row'>";
					echo "<div id='fejlec'>";
					
					$this->MegjelenitesFejlec($visszajelzes);
								
					$this->KosarMegjelenites();
				
				
					echo "<div id='gombsor'>";
					$this->MegjelenitesGombok();
					echo "</div>";
								
					echo "</div>";
					echo "</div>";
					echo "</div>";
				//FEJLÉC
								
								
					
				//TARTALOM
				echo "<div class='container-fluid'>";
				echo "<div class='row'>";
				echo "<div id='tartalom'>";
		
				echo "<div id='baloldaltartalom'>";
				$this->RegisztraciosUrlap();
				echo "</div>";
		
							echo "<div class='container-fluid'>";
							echo "<div class='row'>";
							echo "<div class='col-md-12'>";				
							
							echo "<h3>Kategóriák:<br><br></h3>";
							$list = new FelhasznaloiDbMuveletek();
							
							$tomb = $list->kategorialistazo();
							
							echo "<h3 class='pb-2'>";						
							for($i=0; $i<sizeof($tomb); $i++)
							{		
							echo "<a href='kategszures.php?kategnev=".$tomb[$i]."'>".$tomb[$i]."</a></p>";
							}	
							echo "</h3>";								
							
							echo "</div>";
							echo "</div>";
							echo "</div>";	
											
				echo "</div>";
				echo "</div>";	
				echo "</div>";
				
				//JOBBOLDALTARTALOM
				
		
		
				echo "<div id='lablec'>";
				$this->MegjelenitesLablec();
				echo "</div>";
				//LÁBLÉC
								
							
				echo "</div>";
				//KERET
				
				echo "</body>";		
				echo "</html>";
		}
	
	/* A kosár tartalmát és a teljes oldalt megjelenítő függvény! */
	public function KosarTartalmaMegjelenites($visszajelzes="",$aktid=""){
	echo "<!DOCTYPE html>";
		echo "<html>";
		echo "<head>";
		$this->MegjelenitesDesign();
		echo "</head>";
		
			//BODY
			echo "<body>";
					//KERET
					echo "<div id='keret'>";
						
						//FOCIM
						echo "<div id='focim'>";
						echo "<div class='container-fluid'><img class='container-fluid img-fluid 'src=hatt.png></div></img>";
						echo "</div>";
						//FOCIM
						
						//FEJLEC Itt van a visszajelző sáv,egy stringet kap és értesíti a vásárlót arról hogy sikeres volt
						//e az adott művelet.
						echo "<div id='fejlec'>";
						$this->MegjelenitesFejlec($visszajelzes);
				
							$this->KosarMegjelenites($aktid);
						
							echo "<div id='gombsor'>";
							$this->MegjelenitesGombok();
							echo "</div>";
						
						echo "</div>";
						//FEJLÉC
								
						//TARTALOM
						echo "<div class='container-fluid'>";
						//echo "<div class='row'>";
						echo "<div id='tartalom'>";
													
							//KOZEPTARTALOM-Fő TARTALOM BAL OLDAL.A kosarid a teljes kosarba tett tömb elemeket tartalamazza//	
							
								
								$sum = 0;
								
								echo "<div id='baloldaltartalom'>";	
								echo "A kosarad tartalma:<br>";
								
									if(!$_SESSION['kosarid'])
									{	
									echo "Nincs még a kosaradban semmi!<br>";
									}
									else
									{											
										echo "<div id='kosartermeklapsav'>";
											$ell = new FelhasznaloiDbMuveletek();
											$tomb = array();
											$tombaktive = array();
											
											for($i=0;$i<sizeof($_SESSION['kosarid']);$i++)
											{
											
												$termekid = ($_SESSION['kosarid'][$i]);
												$tomb = $ell->termekidlekerdezes($termekid);
												$tombaktive = $ell->termekaktive($termekid);
												
												if($tombaktive==1)
												{	
												echo "<a href='".$tomb[0]['Kep1']."' target='_blank'><img class='kosarminikep' src='".$tomb[0]['Kep1']."'></a><br>";
												echo "Cím: <span class='kiemeltcim text-break'>".$tomb[0]["Termékcím"]	."</span><br>";
												echo "Termék ID: ".$tomb[0]["termekid"]."<br>";
												
												echo "Ár: <span class='kiemeltar'>".$tomb[0]["Termékár"]."</span><br>";
												echo "Még elérhető darabok: ".$tomb[0]['Darab']."<br>";
												echo "Kategória Neve: ".$tomb[0]['Kategória név']."<br>";
																						
												
												$termekid = $tomb[0]["termekid"];
												echo "<form class='termeklapgombokjobbra' action='kosar.php' method='POST' >";
												echo "<input type='hidden' name='torlesrevarloid' value='".$termekid."' >";			
												echo "<input class='btn btn-warning' type='submit' value='Tétel törlése a kosárból!' >";
												echo "</form>";
												
												echo "<form class='termeklapgombokjobbra' action='teljestermeklap.php' method='POST' >";
												echo "<input type='hidden' name='termekid' value='".$termekid."' >";			
												echo "<input class='btn btn-info' type='submit' value='Terméklap megtekintés!' >";
												echo "</form>";
												echo "<br><hr style='border:1px solid gray;'>";
												
												
												$sum = $sum + $tomb[0]["Termékár"];	
												$_SESSION['vegosszeg'] = $sum;
													
											
												}
												else
												{
												echo "<hr style='border:1px solid gray;'>";
												echo "<br><b>Hopp!Időzköben elkelt egy termék amit a kosaradba tettél!</b>";
												echo "<hr style='border:1px solid gray;'>";
												//$sum = $sum - $tomb[0]["Termékár"];
												//$_SESSION['vegosszeg'] = $sum;
												}
											}
									
										echo "</div>";
			
								
								}				
								
								echo "<span class='kiemeltcim'>Fizetendő: ".$_SESSION['vegosszeg']."</span><br><br><hr>";
								
								
								echo "<div id='ktgombsav'>";
								
								echo "<form class='termeklapgombokjobbra' action='megrendelesvegleg.php' method='POST' >";
								echo "<input type='hidden' name='megrendeles' value='1' >";			
								echo "<input class='btn btn-success btn-lg' type='submit' value='Megrendelés véglegesítés!' >";
								echo "</form>";
								
								echo "<form class='termeklapgombokjobbra' action='kosar.php' method='POST' >";
								echo "<input type='hidden' name='kosarurites' >";	//ha 1 akkor engedi törlmni.		
								echo "<input class='btn btn-danger btn-lg' type='submit' value='Kosár teljes ürítése!' >";
								echo "</form>";
								
								echo "</div>";
								
								echo "</div>";
								//KOZEPTARTALOM-Fő tartalom BAL OLDAL//
							
		
							//JOBBOLDALTARTALOM
							echo "<div class='container-fluid'>";
							echo "<div class='row'>";
							echo "<div class='col-md-12'>";
							
							echo "<h3>Kategóriák:<br><br></h3>";
							
					
							$list = new FelhasznaloiDbMuveletek();
							
							
							$tomb = $list->kategorialistazo();
								
							echo "<h3 class='pb-2'>";	
							for($i=0; $i<sizeof($tomb); $i++)
							{		
							echo "<p><a href='kategszures.php?kategnev=".$tomb[$i]."'>".$tomb[$i]."</a></p>";
							}
							echo "</h3>";
							
							echo "</div>";
							echo "</div>";
							echo "</div>";
										
						//JOBBOLDALTARTALOM
												
						//echo "</div>";	
						echo "</div>";	
						echo "</div>";	
						//TARTALOM
			
					
						//LÁBLÉC
						echo "<div id='lablec'>";
						$this->MegjelenitesLablec();
						echo "</div>";
						//LÁBLÉC
						
					
					echo "</div>";
					//KERET
		
			echo "</body>";		
		echo "</html>";
	}
		
	/*Ez a 'fő' oldal megjelenítése és a KOSÁR gomb is!
	Ha kap kategóris ID-t akkor szűrve jelenít meg!
	*/
	public function Megjelenites($visszajelzes="",$aktid="",$kategid=""){
		echo "<!DOCTYPE html>";
		echo "<html>";
		echo "<head>";
		$this->MegjelenitesDesign();
		echo "</head>";
		
			//BODY
			echo "<body>";
					//KERET

					echo "<div id='keret'>";		
						
						
						//FOCIM
						echo "<div id='focim'>";	
						echo "<div class='container-fluid'><img class='container-fluid img-fluid 'src=hatt.png></div></img>";
						echo "</div>";
						//FOCIM
						
						//FEJLEC Itt van a visszajelző sáv,egy stringet kap és értesíti a vásárlót arról hogy sikeres volt
						//e az adott művelet.
						echo "<div class='container-fluid'>";
						echo "<div class='row'>";
						echo "<div id='fejlec'>";
							$this->MegjelenitesFejlec($visszajelzes);	
							$this->KosarMegjelenites($aktid);
					
							echo "<div id='gombsor'>";
							$this->MegjelenitesGombok();
							echo "</div>";
						
						echo "</div>";
						echo "</div>";
						echo "</div>";
						//FEJLÉC
						
						
						
						//TARTALOM
						echo "<div class='container-fluid'>";
						echo "<div class='row'>";
						echo "<div id='tartalom'>";
													
							
							
							//KOZEPTARTALOM
							if($aktid=="")
							{
							echo "<div id='baloldaltartalom'>";
						
								$kiir = new FelhasznaloiDbMuveletek();
								$tomb = $kiir->termeklekerdezesid($kategid);
								shuffle($tomb);
								$this->kistermeksav($tomb);
								
													
							echo "</div>";
							}
							else if($aktid!="")
							{
							echo "<div id='nagytermeklap'>";
							$this->Nagytermeklap($aktid);
							echo "</div>";
							}
							//KOZEPTARTALOM
							
							
							//JOBBOLDALTARTALOM
							echo "<div class='container-fluid'>";
							echo "<div class='row'>";
							echo "<div class='col-md-12'>";
							//echo "<div id='jobboldaltartalom'>";
							
							echo "<h3>Kategóriák:<br><br></h3>";
							
							
							
							$list = new FelhasznaloiDbMuveletek();
							
							$tomb = $list->kategorialistazo();
								
							echo "<h3 class='pb-2'>";	
							for($i=0; $i<sizeof($tomb); $i++)
							{		
							echo "<p><a href='kategszures.php?kategnev=".$tomb[$i]."'>".$tomb[$i]."</a></p>";
							}
							echo "</h3>";
							
							echo "</div>";
							echo "</div>";
							echo "</div>";						
							//echo "</div>";
							//JOBBOLDALTARTALOM
						
						echo "</div>";	
						echo "</div>";
						echo "</div>";
						//TARTALOM
			
					
					
						//LÁBLÉC
						echo "<div id='lablec'>";
						$this->MegjelenitesLablec();
						echo "</div>";
						//LÁBLÉC					
					echo "</div>";
					//KERET		
			echo "</body>";		
		echo "</html>";
	}
	
	/* Megjelenítés a saját vásárlások megtekintésére , visszanézésére! */
	public function MegjelenitesUres($visszajelzes="",$felhid="",$aktid=""){
		
	echo "<!DOCTYPE html>";
		echo "<html>";
		echo "<head>";
		$this->MegjelenitesDesign();
		echo "</head>";
		
			//BODY
			echo "<body>";
					//KERET
					echo "<div id='keret'>";
						
						//FOCIM
						echo "<div id='focim'>";
						echo "<div class='container-fluid'><img class='container-fluid img-fluid 'src=hatt.png></div></img>";
						echo "</div>";
						//FOCIM
						
						//FEJLEC Itt van a visszajelző sáv,egy stringet kap és értesíti a vásárlót arról hogy sikeres volt
						//e az adott művelet.
						
						echo "<div class='container-fluid'>";
						echo "<div class='row'>";
						echo "<div id='fejlec'>";
						$this->MegjelenitesFejlec($visszajelzes);
						
							$this->KosarMegjelenites($aktid);
						
							echo "<div id='gombsor'>";
							$this->MegjelenitesGombok();
							echo "</div>";
						
						echo "</div>";
						echo "</div>";
						echo "</div>";

						//FEJLÉC
						
						
						$list = new FelhasznaloiDbMuveletek();
						//TARTALOM
						echo "<div class='container-fluid'>";
						echo "<div class='row'>";
						echo "<div id='tartalom'>";
						
							
							//KOZEPTARTALOM
							echo "<div id='baloldaltartalom'>";
							
								echo "<h2>A korábbi vásárlásaid:</h2>";
							//Adott  felhasználó vásárlásai							
							//a termek_id_lekerdezes is  sima tömb termekid-k vannak benne felhid alapján kérdezve.	
							
								$termekid = array();
								$termekid = $list->termekid_lekerdezes_felhid_alapjan($felhid);						
																
								for($i=0;$i<sizeof($termekid);$i++)
								{
								//A temékek ID-jét kapó függvény mely a termék adataival tér vissza!
								$tomb[$i] = $list->termekidlekerdezes_nemaktiv($termekid[$i]);
																													
																
									echo "<div id='archivlistazosav container-fluid'>";										  
											
									echo "<p class='text-break text-muted h5 font-weight-bold'>".$tomb[$i][0]['Termékcím']."</p>";
									
									echo "Eladási ár: <p class='text-secondary text-muted h5 font-weight-bold'><b>".$tomb[$i][0]["Termékár"]." Ft.</p></b>";
																	
									echo "Vásárlás dátuma: <b>".$tomb[$i][0]['vasarlasdatum']."</b><br><br>";
									
									echo "<b>Kulcsszavak:</b> ".$tomb[$i][0]["Kulcsszavak"]."<br><br>";
									
									echo "<a href='".$tomb[$i][0]['Kep1']."' target='_blank'>
									<img class='listazominikep' src='".$tomb[$i][0]['Kep1']."'></a>";
									
									echo "<a href='".$tomb[$i][0]['Kep2']."' target='_blank'>
									<img class='listazominikep' src='".$tomb[$i][0]['Kep2']."'></a>";	
									
									echo "<a href='".$tomb[$i][0]['Kep3']."' target='_blank'>
									<img class='listazominikep' src='".$tomb[$i][0]['Kep3']."'></a>";
																								
									
									echo "<form action='teljestermeklap.php' method='POST' >";
									echo "<input type='hidden' name='termekid' value=".$termekid[$i]." >";
									echo "<input class='btn btn-outline-primary' type='submit' value='Teljes Terméklap' >";
									echo "</form><br><br><br><br>";
									echo "<hr>";					
									echo "</div>";								
									//}						
								}
																
							
							
							echo "</div>";
							//KOZEPTARTALOM
							
							
							//JOBBOLDALTARTALOM
							echo "<div class='container-fluid'>";
							echo "<div class='row'>";
							echo "<div class='col-md-12'>";				
							
							echo "<h3>Kategóriák:<br><br></h3>";
							$list = new FelhasznaloiDbMuveletek();
							
							$tomb = $list->kategorialistazo();
							
							echo "<h3 class='pb-2'>";						
							for($i=0; $i<sizeof($tomb); $i++)
							{		
							echo "<a href='kategszures.php?kategnev=".$tomb[$i]."'>".$tomb[$i]."</a></p>";
							}	
							echo "</h3>";								
							
							echo "</div>";
							echo "</div>";
							echo "</div>";

							//JOBBOLDALTARTALOM
												
						echo "</div>";
						echo "</div>";	
						echo "</div>";							
						//TARTALOM
						
					
						//LÁBLÉC
						echo "<div id='lablec'>";
						$this->MegjelenitesLablec();
						echo "</div>";
						//LÁBLÉC
						
					
					echo "</div>";
					//KERET
		
			echo "</body>";		
		echo "</html>";
	}
		
	/* A Termék keresést megjelenítő mezők! */
	public function MegjelenitesKeresoMezok($visszajelzes="",$aktid="",$tomb=""){
		
	echo "<!DOCTYPE html>";
		echo "<html>";
		echo "<head>";
		$this->MegjelenitesDesign();
		echo "</head>";
		
			//BODY
			echo "<body>";
					//KERET
					echo "<div id='keret'>";
						
						//FOCIM
						echo "<div id='focim'>";
						echo "<div class='container-fluid'><img class='container-fluid img-fluid 'src=hatt.png></div></img>";
						echo "</div>";
						//FOCIM
						
						//FEJLEC Itt van a visszajelző sáv,egy stringet kap és értesíti a vásárlót arról hogy sikeres volt
						//e az adott művelet.
						echo "<div class='container-fluid'>";
						echo "<div class='row'>";						
						echo "<div id='fejlec'>";
						$this->MegjelenitesFejlec($visszajelzes);
						
				
							$this->KosarMegjelenites($aktid);
						
						
							echo "<div id='gombsor'>";
							$this->MegjelenitesGombok();
							echo "</div>";
						
						echo "</div>";
						echo "</div>";
						echo "</div>";
						//FEJLÉC
						
						
						$list = new FelhasznaloiDbMuveletek();
						//TARTALOM
						echo "<div class='container-fluid'>";
						echo "<div class='row'>";
						echo "<div id='tartalom'>";
							
							
							//KOZEPTARTALOM - tévesen 'bal' van az elnevezésben, de a középső rész bal oldalát jelenti.
							
							echo "<div id='baloldaltartalom'>";
							
							//keresőmezők
							
							echo "<form action='kereses.php' method='POST'>";
								
								echo "<h3>Részletes keresés a termékek között:</h3>";
								echo "<hr><br>";
								
								echo "<div class='row'>";	
									echo "<div class='col-8'>";
									echo "Termékcím alapján: ";	
									echo "<input class='form-control' type='text' name='cim'  />";
									echo "</div>";
								echo "</div>";
								echo "<hr><br>";
								
								echo "Keresés ár alapján:";	
								
									echo "<div class='row'>";	
									echo "<div class='col-4'>";
									echo "Min:<input class='form-control' type='number' value='0' name='min' min='0' max='9999999999'  />";
									echo "</div>";
									
									echo "<div class='col-4'>";
									echo "Max:<input class='form-control' type='number' name='max' min='0' max='9999999999'  />";
									echo "</div>";
								
								echo "</div>";
								echo "<hr><br>";
								
								echo "Keresés kulcsszó alapján:";	
							
									echo "<div class='row'>";	
									echo "<div class='col-8'>";
									echo "<input class='form-control' type='text' name='kulcsszo'  />";
									echo "</div>";
									
								echo "</div>";
								echo "<hr><br>";
								
								//FIGYELEM , az adott kategória ID-jével és nem a nevével tér vissza!
								echo "Keresés kategória alapján!<br>";
								echo "<select name='valasztottkategoria' >";								
								$kategorialistazo = new FelhasznaloiDbMuveletek();
								$kategorialistazo->kategoria_listazo();
								echo "</select><br><br><br>";
																					
								echo "Keresés az eladott / nem eladott termékek alapján:<br>";	
							
									echo "<select name='valaszto' size='2' required>";
									echo "<option selected  value=1>Aktív</option>";
									echo "<option 			value=0>Eladott</option>";
									echo "</select>";

						
								echo "<br><br>";
								echo "<input type='hidden' name='keresomezo' value=1>";			
								echo "<input class='btn btn-outline-success float-left' type='submit' value='Keresés!' >";
							
							echo "</form><br><br>";
							
							
							if($tomb!="" && $tomb)
							{	
							echo "<hr>";
							echo "<h5>A keresésre a találataid:</h5>";
							$this->kistermeksav($tomb);					
							}
							
							echo "</div>";
							//KOZEPTARTALOM
							
							
							//JOBBOLDALTARTALOM
							echo "<div class='container-fluid'>";
							echo "<div class='row'>";
							echo "<div class='col-md-12'>";
							//echo "<div id='jobboldaltartalom'>";
							
							echo "<h3>Kategóriák:<br><br></h3>";
							$list = new FelhasznaloiDbMuveletek();
							
							$tomb = $list->kategorialistazo();
								
							echo "<h3 class='pb-2'>";	
							for($i=0; $i<sizeof($tomb); $i++)
							{		
							echo "<p><a href='kategszures.php?kategnev=".$tomb[$i]."'>".$tomb[$i]."</a></p>";
							}
							echo "</h3>";
							
							echo "</div>";
							echo "</div>";
							echo "</div>";		
							//JOBBOLDALTARTALOM
												
						echo "</div>";
						echo "</div>";
						echo "</div>";
						
						//TARTALOM
			
					
						//LÁBLÉC
						echo "<div id='lablec'>";
						$this->MegjelenitesLablec();
						echo "</div>";
						//LÁBLÉC
						
					
					echo "</div>";
					//KERET
		
			echo "</body>";		
		echo "</html>";
	}	
	
	
	//A felhasználói oldali formázása:
	//A BOOT-strap könyvtárat is itt húzzuk be, amit a localhost / server gyökérkönyvtárában el is helyeztünk,nem pedig a hivatkozásként.
	//A keywords - kulcsszavakat később dinamikussá lehet tenni.
	public function MegjelenitesDesign(){
		echo "<link href='style.css' rel='stylesheet' type='text/css' />";
		echo "<link href='bootstrap\css\bootstrap.css' rel='stylesheet' type='text/css' />";
		echo "<meta http-equiv='content-type' content='text/html; charset=UTF8'>";
		echo "<meta name='author' content='Rimóczy Kolos'>";
		echo "<meta name='keywords' content='retró,antik,régiség,gyűjtők boltja,plakát,érem,könyv,bélyeg'>";
		echo "<meta name='viewport' content='width=device-width, initial-scale=1, shrink-to-fit=no'>";
	}
	
	//Fejléc megjelenítés	
	public function MegjelenitesFejlec($visszajelzes){
				
			
			if($this->IsLogin())
			{	
				$con;
				dbconnect($con);
				$nev = $_SESSION['felhasznalo_nev'];
				
				echo "<h1>".$this->udvozlet."<u><b>".$_SESSION['felhasznalo_nev']."</u></b><br></h1>";								
				
				$sqljog = "SELECT felhnev FROM `felhasznalok` WHERE felhnev LIKE '$nev' AND jog = 1;";
			
				$resultjog = $con->query($sqljog);
				if($resultjog->num_rows == 1)
				{
				echo "<a class='btn btn-info float-right' href='admin.php'>Admin Oldal</a><br><br>";
				}				
			}
			
			
			if($visszajelzes!="")
			{
			echo $visszajelzes;		
			}	
	}
		
	public function MegjelenitesGombok(){		

				if($this->IsLogin()==false)
				{		
				echo "<form action='login.php' method='POST' >";
				echo "Név: <input type='text' name='nev' />";
				echo "Jelszó: <input type='password' name='psw' />";
				echo "<input type='submit' value='Bejelentkezés' />";
				echo "</form>";
				}
				/*else
				{
				echo "<form action='logout.php' method='POST'>";
				echo "<input type='submit' value='Kijelentkezés' />";
				echo "</form>";		
				}*/
							
				foreach($this->gombok as $key => $value){			
					
					if($this->IsCurrentURL($value))
					{		
					echo "<a class='btn btn-primary btn-lg btn btn-light float-left text-danger font-weight-bold ml-2'>".$key."</a>"; 	
					}
					else
					{	
					echo "<a class='btn btn-primary btn-lg btn btn-light float-left font-weight-bold ml-2' href='".$value."'>".$key."</a>";					
					}
					
				}	
	}
		
	public function IsCurrentURL($url){
		if( strpos($_SERVER['PHP_SELF'], $url) == false )
			return false;
		else
			return true;
	}	

	public function MegjelenitesLablec(){
		
		
		echo "<b class='float-left'>Az oldalt készítette: Rimóczy Kolos , 2020.";
		echo "<img style='width:5%; padding:1%;' class='float-left rounded img-fluid' src='boot.png'></img>";
		echo "<img style='width:5%; padding:1%;' class='float-left rounded img-fluid' src='css.png'></img>";
		echo "<img style='width:5%; padding:1%;' class='float-left rounded img-fluid' src='fb.png'></img>";
		echo "<img style='width:5%; padding:1%;' class='float-left rounded img-fluid' src='html.png'></img>";
		echo "<img style='width:7%; padding:1%;' class='float-left rounded img-fluid' src='logo.png'></img>";
		
		
	
	}

	/* A Kontakt fülre kattintva a kapcsolat és elérhetőségek */
	public function MegjelenitesKontakt($visszajelzes="",$aktid="",$kategid=""){

		echo "<!DOCTYPE html>";
		echo "<html>";
		echo "<head>";
		$this->MegjelenitesDesign();
		echo "</head>";
		
			//BODY
			echo "<body>";
					//KERET
					echo "<div id='keret'>";
						
						//FOCIM
						echo "<div id='focim'>";
						echo "<div class='container-fluid'><img class='container-fluid img-fluid 'src=hatt.png></div></img>";
						echo "</div>";
						//FOCIM
						
						//FEJLEC Itt van a visszajelző sáv,egy stringet kap és értesíti a vásárlót arról hogy sikeres volt
						//e az adott művelet.
						echo "<div id='fejlec'>";
						$this->MegjelenitesFejlec($visszajelzes);
						
				
							$this->KosarMegjelenites($aktid);
												
							echo "<div id='gombsor'>";
							$this->MegjelenitesGombok();
							echo "</div>";
						
						echo "</div>";
						//FEJLÉC
						
					
						
						//TARTALOM
						echo "<div id='tartalom'>";
													
							//KOZEPTARTALOM 
							
							echo "<div id='baloldaltartalom'>";
							echo $this->informaciok;
							echo "</div>";
							
							//KOZEPTARTALOM
							
							
							//JOBBOLDALTARTALOM
							echo "<div class='container-fluid'>";
							echo "<div class='row'>";
							echo "<div class='col-md-12'>";				
							
							echo "<h3>Kategóriák:<br><br></h3>";
							$list = new FelhasznaloiDbMuveletek();
							
							$tomb = $list->kategorialistazo();
							
							echo "<h3 class='pb-2'>";						
							for($i=0; $i<sizeof($tomb); $i++)
							{		
							echo "<a href='kategszures.php?kategnev=".$tomb[$i]."'>".$tomb[$i]."</a></p>";
							}	
							echo "</h3>";								
							
							echo "</div>";
							echo "</div>";
							echo "</div>";
							//JOBBOLDALTARTALOM
												
						echo "</div>";	
						//TARTALOM
			
					
						//LÁBLÉC
						echo "<div id='lablec'>";
						$this->MegjelenitesLablec();
						echo "</div>";
						//LÁBLÉC
						
					
					echo "</div>";
					//KERET
		
			echo "</body>";		
		echo "</html>";
	}
	
	

}

class FelhasznaloiDbMuveletek{
	
	function __set($nev, $ertek){
		$this->$nev = $ertek;
	}
	
	//A Kategóriát, listát , HTML select-ek közé kell tenni a megjelenítés érdekében!
	public function kategoria_listazo(){
	$con;
	dbconnect($con);

	$sql = "SELECT kategoriaid,kategorianev FROM kategoria;";
	$result = $con->query($sql);

	$output = "";
		if($result->num_rows>0)
		{	
			while($row = $result->fetch_assoc())
			{						
			echo "<option value='$row[kategoriaid]'>$row[kategorianev]</option>";		
			//KategoriaID az átadott érték egy SMALLINT					
			}
		}
		else
		{
		echo "Nem volt találat a kategóriák lekérdezésére!";	
		}
		
	$con->close();
	}
		
	/*A termékkeresés oldalról érkező keresési paraméterek alapján SQL lekérdezést végrehajtó
	függvény,  mely a találati listával, egy asszociatív tömbbel tér vissza.
	*/
	public function termekkereses($valaszto,$cim="",$min="",$max="",$kulcsszo="",$valasztottkategoria=""){
	$con;
	dbconnect($con);
	
	/* Ez a változó a termékkeresés oldalról érkező eladott/aktív értékét adja meg.
	Aktív = 1 , Nem aktív = 0 */
	$valaszto = (int)$valaszto;
	
	/* Keresés kategória alapján! */
	if($valasztottkategoria!="")
	{	
	$sql = "SELECT * FROM `termeklap` WHERE kategelh = $valasztottkategoria AND `aktive` = $valaszto";
	}
	
	/* Keresés kulcsszó alapján. */
	if($kulcsszo!="")
	{	
	$sql = "SELECT * FROM `termeklap` WHERE kulcssz LIKE '%$kulcsszo%' AND aktive = $valaszto";
	}
	
	/* Keresés CSAK cím alapján! */
	if($cim!="")
	{	
	$sql = "SELECT * FROM `termeklap` WHERE termekcim LIKE '%$cim%' AND aktive = $valaszto";
	}
	
	/* Keresés CSAK minimum ár alapján! LIMIT kell majd! */
	if($min!="" && $min!=0)
	{	
	$sql = "SELECT * FROM `termeklap` WHERE termekar >= $min AND aktive = $valaszto";
	}
	
	/* Keresés CSAK maximum ár alapján! */
	if($max!="")
	{
	$sql = "SELECT * FROM `termeklap` WHERE termekar <= $max AND aktive = $valaszto";
	}
	
	
	/* Szükséges később egy intervallum keresés is majd. Ez nem műküdik! */
	/*if($max!="" && $min!="")
	{
	$sql = "SELECT * FROM `termeklap` WHERE termekar >= $min AND termekar <= $max AND aktive = $valaszto; ";	
	}*/
	
	
	$result = $con->query($sql);
	
	$outputtomb = array();
	
	if($result->num_rows>0)
	{
		while($row = $result->fetch_assoc())
		{
		$outputtomb[]= array('termekid' => $row['termekid'],'Aktive' => $row['aktive'],'Termékcím' => $row['termekcim'],'Termékár' => $row['termekar'],'Leírás' => $row['leiras'],'Kulcsszavak' => $row['kulcssz'],'Darab' => $row['darab'],'Kategória' => $row['kategelh'],'Kep1' => $row['img1'],'Kep2' => $row['img2'],'Kep3' => $row['img3']);	
		}
	}
	else{
		
	//echo "Nem volt találatunk a keresésre";	
	}
	
	return $outputtomb;
	$con->close();	
	
	}
	
	/*Termék ID-t kérdezünk le felhid-alapján,tehát hogy az adott felhasználó miket vett meg! Ez 1 db vagy egy sima tömb lesz!
	*/
	public function termekid_lekerdezes_felhid_alapjan($felhid){
	$con;	
	dbconnect($con);	
	$sql = "SELECT termekid FROM `vasarlas` WHERE felhid = $felhid";
		
	$result = $con->query($sql);
	$outputtomb = array();
	
	if($result->num_rows>0)
	{
		while($row = $result->fetch_assoc())
		{
		$outputtomb[] = $row['termekid'];	
		}
	}
	else{
	echo "<p class='text-danger'>Nem volt még korábbi vásárlásod!</p>";	
	}
	
	return $outputtomb;		
	$con->close();
	}
	
	/*Nem regisztrált fehasználó adatait lekérdező, és helyes eredmény esetén egy ID-vel visszatérő függvény. A vasarlas.php-ban
	használjuk és ott a POST-on kapott adatokat adjuk át neki!
	Azonos adatok esetén több id-t fog kapni , de mindig a legutolsó ID-t adja vissza a lekérdezés.*/
	public function nemregfelhid_lekerdezo($veznev,$kernev,$orszag,$irsz,$varos,$utca,$hazszam,$telefon,$email,$hozzajarul){
	$con;
	dbconnect($con);
	
	$sql = "SELECT `nemregfelhid` FROM `regnelkulfelhasznalok` WHERE veznev = '$veznev' AND kernev = '$kernev' AND orsz = '$orszag' AND irsz = '$irsz' AND varos = '$varos' AND utca = '$utca' AND hsz = '$hazszam' AND telefon = '$telefon' AND email = '$email';";
	
	$resultid = $con->query($sql);
	$output;
	
	if($resultid)
	{
		while($row = $resultid->fetch_assoc())
		{
		$output = $row['nemregfelhid'];	
		}
			
	}
	else
	{
	echo "Nem sikerült a nem regisztrált felhasználó adatait (ID-jét) kiolvasó SQL lekérdezés. Lépj a kezdőlapra és próbáld újra.";		
	}
	
	return $output;
	
	$con->close();
	}
		
	/*Nem regisztrált felhasználó vásárlását beszúró függvény!
	A nem regisztrált felhasználó ID-jét és a megvásárolt termék ID-jét paraméteren kapó függvény.
	*/
	public function nemregvasarlasbeszuras($nemregfelhid,$termekid){
	$con;
	dbconnect($con);
	//$igaz;
	
	$sql = "INSERT INTO `vasarlas`(`vasarlasid`, `felhid`, `nemregfelhid`, `termekid`, `vasarlasdatum`) VALUES (NULL,NULL,$nemregfelhid,$termekid,NOW())";
	$result = $con->query($sql);

	if($con->affected_rows>=1)
	{
	//$visszajelzes = "<p class='text-success font-weight-bold'>Sikeresen vásároltál!Legközelebb regisztrálj is nálunk!</p>";
	//$igaz = true;
	}
	else
	{
	echo "<p class='text-danger font-weight-bold'>Sikertelen volt a regisztrálás nélkül végrehajtott vásárlásod,nem sikerült teljesíteni az ehhez kapcsololdó SQL műveleteket! Próbáld újra</p>";	
	//$igaz = false;
	}
		
	//return $visszajelzes;
	//return $igaz;
	$con->close();	
	}
		
	/* Regisztrált felhasználó vásárlását beszúró függvény! 
	A regisztrált felhasználó ID-jét és a vásárolt terméke ID-jét kapó függvény.
	*/
	public function vasarlasbeszuras($felhid,$termekid){
	$con;
	dbconnect($con);
	//$igaze;		
	$sql = "INSERT INTO `vasarlas`(`vasarlasid`, `felhid`, `nemregfelhid`, `termekid`, `vasarlasdatum`) VALUES (NULL,$felhid,NULL,$termekid,NOW())";
	$result = $con->query($sql);
	
	if($con->affected_rows>=1)
	{
	//$visszajelzes = "<div class='alert alert-success font-weight-bold'>Sikeresen vásároltál!</div>";
	}
	else
	{
	echo "<p class='text-danger font-weight-bold'>Sikertelen volt a vásárlásod,nem sikerült teljesíteni az ehhez kapcsoló SQL műveleteket! Próbáld újra!</p>";
	}
	
	//return $visszajelzes;
	$con->close();
	}
		
	/*Felhasználó ID-jét lekérdező függvény amely paraméteren felhaszánlónevet kap.
	A 'felhid' mező értékével tér vissza.
	*/
	public function felhidlekerdezes($felhasznalonev){
	$con;
	dbconnect($con);
	$sql = "SELECT felhid FROM `felhasznalok` WHERE felhnev = '$felhasznalonev'";
	$result = $con->query($sql);
	
	if($result)
	{
		while($row = $result->fetch_assoc())
		{
		$output = $row['felhid'];	
		}
	}
	else
	{
	echo "Nem volt találat a felhasználó ID-jét lekérdező SQL keresésre!";
	}
	
	return $output;
	$con->close();
	}
	
	/*Termék aktivítását vizsgáló fgv. mely termekid-t kap.*/
	public function termekaktive($termekid){
	$con;	
	dbconnect($con);
	$sql = "SELECT aktive FROM `termeklap` WHERE termekid = $termekid";
	$result = $con->query($sql);
	
	if($result)
	{
		while($row = $result->fetch_assoc())
		{
		$output = $row['aktive'];	
		}
	}
	else
	{
	echo "Nem volt találatunk a termék aktívítására vonatkozó lekérdezésre.";
	}
	
	return $output;	
	$con->close();	
	}
		
	/* Termék darabszámot visszaadó fgv. ami egy termekid-t kap. Aktív termékekben kérdez le! */
	public function termekdb($termekid){
	$con;
	dbconnect($con);
	$sql = "SELECT darab FROM termeklap WHERE termekid = $termekid AND aktive = 1 LIMIT 1";
	$result = $con->query($sql);
	$output = 0;
	
	if($result)
	{
			while($row = $result->fetch_assoc())
			{
			$output = $row['darab'];
			}
	
	}
	else
	{
	echo "Nem volt találatunk a termék darabszámát vizsgáló függvényre.";	
	}
	
	return $output;
	$con->close();
	}
	
	/* Adott termék darabszámát 1db-bal csökkentő függvény. Termekid-t kap. */
	public function termekdbminusz($keresettid){
	$con;	
	dbconnect($con);
	$sql = "UPDATE `termeklap` SET `darab` = `darab`-1 WHERE termekid = $keresettid";
	$result = $con->query($sql);
			
	$con->close();	
	}
	
	/*Adott termék darabszámát 1db-bal csökkentő függvény és aktive-0-ra állító függvény.*/
	public function termekkisetelo($keresettid){
	
	$con;	
	dbconnect($con);
	$sql = "UPDATE `termeklap` SET `darab` = `darab`-1,`aktive` = 0 WHERE termekid = $keresettid";
	
	$result = $con->query($sql);
		
	$con->close();	
	}
	
	/* Termék árát és címét lekérdező függvény , ami egy termek id-t kap. Mivel a függvényt csak akkor használjuk,
	ha már egy NEM elérhető termékről akarunk adatokat, ezért az aktive = 0 a lekérdezében! */
	public function nemaktivtermekar($termekid){
	$con;
	dbconnect($con);
	$sql = "SELECT termekar,termekcim FROM `termeklap` WHERE termekid = $termekid AND aktive = 0 LIMIT 1;";
	$result = $con->query($sql);
	
	if($result->num_rows>0)
	{
		while($row = $result->fetch_assoc())
		{
		$outputtomb[]= array('termekar' => $row['termekar'],'termekcim' => $row['termekcim']);	
		}
	}
	else{
	echo "Nem volt találatunk a nem aktív termék kereső lekérdezésre!";	
	}
	
	return $outputtomb;
	$con->close();	
	}
	
	/* Termék árát lekérdező függvény , amely a termék árával tér vissza.*/
	public function termekar($termekid){
	$con;
	dbconnect($con);	
	$sql = "SELECT termekar FROM `termeklap`,`kategoria` WHERE termekid = $termekid AND aktive = 1 LIMIT 1;";	
	$result = $con->query($sql);
	
	while($row = $result->fetch_assoc())
	{
	$output = $row['termekar'];	
	}
	
	return $output;
	$con->close();
	}
	
	//Ez csak 1 db termék adatait adja vissza! Ami elérhető egy db. termék-ID-t.
	public function termekid($termekid){
		
	$con;
	dbconnect($con);	
	//Ez a lekérdezés csak 'Limit'-el ad 1 találatot, egyébként sokszor adja vissza ugyanazt. Minden kérdezünk le mindent? Később javítani kell!
	//Elég csak a termekid-t.
	$sql = "SELECT termekid,aktive,termekcim,termekar,leiras,kulcssz,darab,kategelh,img1,img2,img3,kategoria.kategorianev FROM `termeklap`,`kategoria` WHERE termekid = $termekid AND aktive = 1 LIMIT 1;";	
	
	$result = $con->query($sql);

	while($row = $result->fetch_assoc())
	{
	$output = $row['termekid'];	
	}
	
	return $output;
	$con->close();
	}
				
	
	/* A vásárlás táblából termekid alapján a vásárlás dátumát lekérdező fgv. */ 
	public function eladott_termek_datuml_lekerdezes($termekid){
	$con;
	dbconnect($con);	
		
	$sql = "SELECT vasarlasdatum FROM vasarlas WHERE termekid = $termekid;";
	
	$result = $con->query($sql);
	$output = array();
	
	if($result->num_rows>0)
	{
		while($row = $result->fetch_assoc())
		{
		$output = $row['vasarlasdatum'];
		}
	}
	else{
	echo "Nem volt találatunk a a vásárlás dátumának lekérdezéséről!";	
	}
		
	return $output;
	$con->close();
	}
		
	
	/*A NEM AKTÍV , nem elérhető termékeket listázó függvény,melyet a belépett felhasználó vásárlásainak megtekintéséhez használunk.*/
	public function termekidlekerdezes_nemaktiv($termekid){
	$con;
	dbconnect($con);	

	/* 2020.10.29 működő */
	$sql = "SELECT vasarlas.vasarlasdatum,termeklap.* FROM vasarlas LEFT OUTER JOIN termeklap ON vasarlas.termekid = termeklap.termekid WHERE termeklap.termekid = $termekid";
		
	$result = $con->query($sql);
	$outputtomb = array();
	
	if($result->num_rows>0)
	{
		while($row = $result->fetch_assoc())
		{
		$outputtomb[] = array('vasarlasdatum' => $row['vasarlasdatum'],'termekid' => $row['termekid'],'Aktive' => $row['aktive'],'Termékcím' => $row['termekcim'],'Termékár' => $row['termekar'],'Leírás' => $row['leiras'],'Kulcsszavak' => $row['kulcssz'],'Darab' => $row['darab'],'Kategória' => $row['kategelh'],'Kep1' => $row['img1'],'Kep2' => $row['img2'],'Kep3' => $row['img3']);	
		}
	}
	else{
	echo "Nem volt találatunk a nem aktív termékek keresésére!";	
	}
	
	return $outputtomb;
	$con->close();	
			
	}
	
	
	/* A termék id-alapján a termék adatait lekérdező függvény , mely egy asszoc. tömbbel tér vissza. */
	public function termekidlekerdezes($termekid){
	$con;
	dbconnect($con);	
	//Ez a lekérdezés csak 'Limit'-el ad 1 találatot,  egyébként sokszor adja vissza ugyanazt. Javítani kell!
	$sql = "SELECT termekid,aktive,termekcim,termekar,leiras,kulcssz,darab,kategelh,img1,img2,img3,kategoria.kategorianev FROM `termeklap`,`kategoria` WHERE termekid = $termekid AND aktive = 1 LIMIT 1;";	
	
	$result = $con->query($sql);
	$outputtomb = array();
	
	if($result->num_rows>0)
	{
		while($row = $result->fetch_assoc())
		{
		$outputtomb[]= array('termekid' => $row['termekid'],'Aktive' => $row['aktive'],'Termékcím' => $row['termekcim'],'Termékár' => $row['termekar'],'Leírás' => $row['leiras'],'Kulcsszavak' => $row['kulcssz'],'Darab' => $row['darab'],'Kategória' => $row['kategelh'],'Kep1' => $row['img1'],'Kep2' => $row['img2'],'Kep3' => $row['img3'],'Kategória név' => $row['kategorianev']);	
		}
	}
	else{
	echo "Nem volt találatunk az aktív termék keresésre!";	
	}
	
	return $outputtomb;
	$con->close();
	}
	
	/* Ha a függvény kap kategelh-t akkor az adott kategória termékeinek adatait adja át.
	Ha nem kap csak alapértéket akkor csak a termék(ek) adatait adja vissza.
	Itt lehet beállítani hogy a függvény hány darab termékkel térjen vissza és főoldaton ennyit listáz! (LIMIT 10)
 	*/
	public function termeklekerdezesid($kategelh=""){
	$con;
	dbconnect($con);
	
	if($kategelh=="")
		$sql = "SELECT termekid,aktive,termekcim,termekar,leiras,kulcssz,darab,kategelh,img1,img2,img3 FROM termeklap WHERE termekid > 0 AND aktive != 0 ORDER BY termekid DESC LIMIT 20";
	
	if($kategelh!="")
		$sql = "SELECT termekid,aktive,termekcim,termekar,leiras,kulcssz,darab,kategelh,img1,img2,img3 FROM termeklap WHERE termekid > 0 AND aktive != 0 AND kategelh = $kategelh LIMIT 20";
	
	
	
	$result = $con->query($sql);	
	$outputtomb = array();
	
	if($result->num_rows>0)	
	{
		//Ékezet nélkülivé kell tenni az asszoc tömb kulcsait később!
		while($row = $result->fetch_assoc())
		{
		$outputtomb[]= array('termekid' => $row['termekid'],'Aktive' => $row['aktive'],'Termékcím' => $row['termekcim'],'Termékár' => $row['termekar'],'Leírás' => $row['leiras'],'Kulcsszavak' => $row['kulcssz'],'Darab' => $row['darab'],'Kategória' => $row['kategelh'],'Kep1' => $row['img1'],'Kep2' => $row['img2'],'Kep3' => $row['img3']);
		}
	}
	else
	{
	echo "Nem volt egy találatunk sem a keresésre!";
	}	
	
	return $outputtomb;
	
	$con->close();
	}
	
	/*Egy felhasználót /annak már meglévő adaitlistázó függvény, mely egy asszoc. tömbbel tér vissza.*/
	public function felhasznalolistazo($felhasznalonev){
	$con;
	dbconnect($con);
	$sql = "SELECT * FROM `felhasznalok` WHERE felhnev='".$felhasznalonev."';";
	$result = $con->query($sql);
	
	if($result->num_rows>0)	
	{
		while($row = $result->fetch_assoc())
		{
		$outputtomb = array('felhasznaloid' => $row['felhid'],'jogosultsag' => $row['jog'],'jelszo' => $row['jelszo'],'felhasznalonev' => $row['felhnev'],'vezeteknev' => $row['veznev'],'keresztnev' => $row['kernev'],'orszag' => $row['orsz'],'iranyitoszam' => $row['irsz'],'varos' => $row['varos'],'utca' => $row['utca'],'hazszam' => $row['hsz'],'telefon' => $row['telefon'],'email' => $row['email']);
		}
	}
	else
	{
	echo "Nem volt egy találatunk sem a lekérdezésre!";
	}	
	
	
	return $outputtomb;
	$con->close();
	}
	
	/* Kategória ID-jével visszatérő függvény amely kap egy kategória nevet.
	A kategóriákban lévő szóközök miatt % operátort használunk hogy megtalálja az adott kategóriát!
	*/
	public function kategoriaidlistazo($kategorianev){
	
	$con;
	dbconnect($con);
	$output = "";
	
	$sql = "SELECT kategoriaid FROM kategoria WHERE kategorianev LIKE '%$kategorianev%'";
	$result = $con->query($sql);	
	
	if($result->num_rows>0)
	{
		while($row = $result->fetch_assoc())
		{
			$output = $row['kategoriaid'];	
		}	
	}
	else
	{
	echo "Nem volt találatunk a kategória keresésre!";
	}
	
	return $output;
	$con->close();
	}
	
	/* A Fő oldalra listázza ki a kategóriákat, azok neveit!*/
	public function kategorialistazo(){
	$con;
	dbconnect($con);
	$outputtomb = array();
	
	$sql = "SELECT kategorianev FROM kategoria WHERE kategoriaid ORDER BY kategorianev ASC;";
	$result = $con->query($sql);	
	
	if($result->num_rows>0)
	{
		while($row = $result->fetch_assoc())
		{
			$outputtomb[] = $row['kategorianev'];	
		}	
	}
	else
	{
	echo "Nem volt találatunk a lekérdezésre!";
	}
	
	return $outputtomb;
	$con->close();
	}
	
	/* A már belépett felhasználó adait kezelő függvény. Paraméteren a felhasználók adait kapja. Később tömböt kell használni */
	public function Belepett_felhasznalo_modositasa($felhasznalonev,$jelszo,$jelszoujra,$felhnev,$veznev,$kernev,$orszag,$irsz,$varos,$utca,$hsz,$telefon,$email){

	$con;	
	$siker = "";
	$regijelszo;
	dbconnect($con);
	
	/*Ez a lekérdezés vizsgálja hogy a beléptetett (SESSION-ban) hozott felhasználó valóban azonos e azzak aki az adatbázisban van.
	Biztonsági ellenőrzés, a támadás kizárására.*/
	
	$sqlfelhnev = "SELECT felhnev FROM `felhasznalok` WHERE felhnev = '".$felhasznalonev."';";
	$resultfelhnev = $con->query($sqlfelhnev);
	if($resultfelhnev->num_rows>0)
	{					
		//Ha a két 'Újra beírt' jelszó egyezik: 
		if(strcmp($jelszo, $jelszoujra)== 0)
		{
				
			//Egy tömb létrehozása a lekérdezett nevek elmentésére!
			$vizsgalandonevek = array();
			$sqllistabol = "SELECT felhnev FROM `felhasznalok`;";
			$resultnevlist = $con->query($sqllistabol);
				
			while($row = $resultnevlist->fetch_assoc())
			{
			$vizsgalandonevek[] = $row['felhnev'];
			}
				
			//Vizsgáljuk hogy van e olyan felhasználónév az adatbázisban, amit bevitt a felhasználó a beviteli mezőben. ($felhnev)
			//Ha VAN , akkor a $vane változót igaz-ra állítjuk!
			$vane = false;
			for($i=0; $i<sizeof($vizsgalandonevek); $i++)
			{	
				if($vizsgalandonevek[$i] == $felhnev)
				{
				$vane = true;		
				}
			}			
				//Ha a név nem foglalt a db-ben vagy a SESSION-ben hozott név azononos a beírttal, akkor beengedjük az IF-be.
			if($vane == false|| strcmp($felhnev,$felhasznalonev)==0 )
			{
				//A bevitt jelszót kódolni kell!
				//$jelszo = sha1($jelszo);
	
				$sql = "UPDATE `felhasznalok` SET `jelszo`='$jelszo',`felhnev`='$felhnev',`veznev`='$veznev',`kernev`='$kernev',`orsz`='$orszag',`irsz`='$irsz',`varos`='$varos',`utca`='$utca',`hsz`='$hsz',`telefon`='$telefon',`email`='$email' WHERE felhnev ='".$felhasznalonev."';";
				$resultupdate = $con->query($sql);					
				if($con->affected_rows>=1)
				{	
				//Átmdosítjuk a SESSION tömb felh. nevét a bevitt névre,  mert különben hiba lesz.
				$_SESSION['felhasznalo_nev'] = $felhnev; 
				$siker = "<p class='text-success font-weight-bold'>Sikeresen módosítottad az adataid!</p>"; 	
				}
				else
				{	
				$siker = "<p class='text-danger font-weight-bold'>Hiba lépett fel,a módosítás nem sikerült!</p>";
				}	
			}
			else
			{
			$siker = "<p class='text-danger font-weight-bold'>Van ugyanilyen felhasználónevű felhasználó a rendszerben,próbáld meg újra másik felhasználónévvel!</p>";	
			}
		}
		else
		{
		//Ha két jelszó nem egyezik,akkor kiírjuk.
		$siker = "<p class='text-danger font-weight-bold'>A két újra megadott jelszó nem egyezik!</p>";
		}	
	}
	else
	{
	$siker = "<p class='text-danger font-weight-bold'>Hiba lépett fel a felhasználó azonosításával kapcsolatban</p>";	
	}
	$con->close();
	$megjelenites = new Weboldal();
	$megjelenites->FoMegjelenesRegisztracio($siker);
	}
	
	/*Felhasználót regisztráló/beléptető függvény. Ellenőrzi hogy van e ilyen felhasználónév.*/
	public function Felhasznalo_Regisztralasa($jogosultsag,$jelszo,$jelszoujra,$felhnev,$veznev,$kernev,$orszag,$irsz,$varos,$utca,$hsz,$telefon,$email){
		
	
	$con;
	$siker = "";
	dbconnect($con);
		  
	$sqlnevellenorzes = "SELECT felhnev FROM `felhasznalok` WHERE felhnev = '".$felhnev."';";
	$resultnevellenorzes = $con->query($sqlnevellenorzes);
	
	
	if($resultnevellenorzes->num_rows>0)
	{
	$siker = "<p class='text-danger font-weight-bold'>Van ugyanilyen felhasználónevű felhasználó a rendszerben!</p>";
	}
	else
	{	
		//kovacs -- e59aa4985cd7e492ead4e61c2f1745481d60e78c
		//f486aeab09912f2e4b99b0d13cd73bfddefc6289 - csernobil
		if(strcmp($jelszo, $jelszoujra)=== 0)
		{		
			$sqlreg = "INSERT INTO `felhasznalok` (`felhid`, `jog`, `jelszo`, `felhnev`, `veznev`, `kernev`, `orsz`, `irsz`, `varos`, `utca`, `hsz`, `telefon`, `email`, `regdatum`) 
			VALUES (NULL,'$jogosultsag','$jelszo','$felhnev','$veznev','$kernev','$orszag','$irsz','$varos','$utca','$hsz','$telefon','$email',NOW());";
			$result = $con->query($sqlreg);
			
			if($con->affected_rows>=1)
			{
			$_SESSION['felhasznalo_nev'] = $felhnev;
			$siker = "<p class='text-success font-weight-bold'>Sikeresen regisztráltál nálunk!</p>";	
			}
			else
			{
			$siker = "<p class='text-danger font-weight-bold'>Hiba lépett fel a regisztráció közben!</p>";	
			}	
		}
		else
		{			
		$siker = "<p class='text-danger font-weight-bold'>Kérlek a jelszó mezőkben azonos jelszavakat írj be!</p>";			
		}
	}
	
	
	$con->close();
	$megjelenites = new Weboldal();
	$megjelenites->Megjelenites($siker);			
	}
	
	/*A nem kívánatos támadásoktól és nem kívánt karakterektől levédő függvény.*/
	public function Ellenorzo($input){
	$con;
	dbconnect($con);	
	$input = $con->real_escape_string($input);	
	$input = trim($input); //A szöveg elejéről és végéről is levágja a space-t (sortörés,tab szóköz)
	$input = stripcslashes($input); //Egyszeres és kétszeres és a visszaper \ és a NULL karakterek. Hogy ne vezérlő karakternek vegye őket át.
	$input = htmlspecialchars($input); //Esetleges HTML vezérlő karakterek levágása
	$con->close();
	return $input;
	}

	/* A nem regisztrált felhasználó adatainak beszúrása! */
	public function Nem_Regisztralt_Felh_Beszurasa($veznev,$kernev,$orszag,$irsz,$varos,$utca,$hazszam,$telefon,$email,$hozzajarul){
	
	$con;	
	$visszajelzes;	
	
	$veznev			= $this->Ellenorzo($veznev);
	$kernev			= $this->Ellenorzo($kernev);
	$orszag			= $this->Ellenorzo($orszag);
	$irsz			= $this->Ellenorzo($irsz);
	$varos			= $this->Ellenorzo($varos);
	$utca			= $this->Ellenorzo($utca);
	$hazszam		= $this->Ellenorzo($hazszam);
	$telefon		= $this->Ellenorzo($telefon);
	$email			= $this->Ellenorzo($email);
	$hozzajarul		= $this->Ellenorzo($hozzajarul);
	
	dbconnect($con);
	
	$sql = "INSERT INTO `regnelkulfelhasznalok` (`nemregfelhid`,`veznev`,`kernev`,`orsz`,`irsz`,`varos`,`utca`,`hsz`,`telefon`,`email`, `hozzajarul`,`datum`) 
			VALUES 
			(NULL,'$veznev','$kernev','$orszag','$irsz','$varos','$utca','$hazszam','$telefon','$email','$hozzajarul',NOW());";
	
	$result = $con->query($sql);
		
	if($result)
	{
	$visszajelzes = true;	
	}
	else
	{
	$visszajelzes = false;	
	}

	return $visszajelzes;
	
	$con->close();					
	}
	
	/* 2020.11.22-én került be, a Teljes terméklap megjelenítésnél hívjuk */
	public function KategoriaNevListazo($kategid){
	$con;
	dbconnect($con);	
	
	$sql = "SELECT kategorianev FROM kategoria WHERE kategoriaid = $kategid";
	$result = $con->query($sql);	
	$input;
	
	if($result->num_rows>0)
	{
		while($row = $result->fetch_assoc())
		{
			$input= $row['kategorianev'];	
		}	
	}
	else
	{
	echo "Nem volt találatunk a lekérdezésre!";
	}


	$con->close();
	return $input;
	}
	
}
?>