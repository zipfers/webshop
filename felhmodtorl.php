<?php
require("adminosztaly.php");
//FŐ admin oldaóról gombnyomásra jön ez be


if(isset($_SESSION['siker']))
	{		
	$siker = $_SESSION['siker'];
	}
unset($_SESSION['siker']);

$aladminoldaltorlmod = new AdminNezet();
$aladminoldaltorlmod ->AdminFelhasznaloModTorl($siker,$keresettfelhnev);
?>

