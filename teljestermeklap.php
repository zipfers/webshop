<?php
session_start();
require_once("weboldal.php");
$aktid = "";


if(isset($_POST['termekid']))
	$aktid = $_POST['termekid'];


$megjelenes = new Weboldal();
$megjelenes->Megjelenites($visszajelzes="",$aktid);
?>

