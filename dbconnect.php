<?php
function dbconnect(&$con){

$con;
$servername = "localhost";	
$username = "root";
$password = "";
$dbname = "webshop";

$con = new mysqli($servername,$username,$password,$dbname);

if($con->connect_error>0)
	die("<h1>Hiba az adatbázis csatlakozáskor!</h1>");
else
	$con->set_charset("utf8");


}
?>