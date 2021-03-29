<?php
//session_start();
require("adminosztaly.php");

//Ellenőrizzük hogy ahonnan érkezünk , hozzuk e a siker-t a session-ban,ami a felhasználó felivitelét igazolja vissza
// Gombnyomásra jöüvünk ide ADMIKN fő oldalról
if(isset($_SESSION['siker']))
	{		
	$siker = $_SESSION['siker'];
	}
unset($_SESSION['siker']);
//Elmentjük egy változóban az értékét a session-nek , amit átadunk a felhasználóbeszúrásnak!


$aladminoldal = new AdminNezet();
$aladminoldal->AdminFelhasznaloBeszuras($siker);

?>