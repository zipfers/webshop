<?php
require("adminosztaly.php");


$con;
dbconnect($con);

if(isset($_POST['ujkategoria']))
	{	
	$ujkategoria = $_POST['ujkategoria'];
	$beszuras = new dbmuveletek();
	$siker = $beszuras->kategoria_beszuras($ujkategoria);
	}
	

$kategoriafel = new AdminNezet(); //eredeti
$kategoriafel->AdminKategoriaBeszuras($siker); //eredeti
$con->close();
?>