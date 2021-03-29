<?php
session_start();

$nev;
$psw;
$result = "";
$sql = "";

/* Ha az index.php-ről érkezünk akkor az alábbi feltételek közül valamelyik teljesül.Ha nem akkor
külső 'belépési' próbálkozás történt.
 */ 
if(isset($_POST['nev']) || isset($_POST['psw']))
{	
	$con = new mysqli("localhost", "root", "", "webshop");
	$con->set_charset("utf8");
	$nev = $_POST['nev'];
	$psw = $_POST['psw'];	
	$psw = sha1($psw);
	$nev = $con->real_escape_string($nev);
	$psw = $con->real_escape_string($psw);


	$sql = "SELECT felhnev
			FROM felhasznalok
			WHERE felhnev LIKE '$nev' AND jelszo LIKE '$psw'";
			
	$result = $con->query($sql);


	if($result->num_rows == 0)
	{		
	echo "<h1>A felhasználónév vagy a jelszó nem egyezik meg!</h1>";
	}	
	else	
	{
	$_SESSION['felhasznalo_nev'] = $nev;
		
		
	$sqljog = "SELECT felhnev FROM `felhasznalok` WHERE felhnev LIKE '$nev' AND jog = 1;";
		
	$resultjog = $con->query($sqljog);
			if($resultjog->num_rows == 0)
			{
			header("Location: index.php");
			die();
			}		
			else
			{
			header("Location: admin.php");
			die();
			}

}

}
else{
echo "Jogosulatlan belépési kísérlet!";	
}
?>




