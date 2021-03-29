<?php
require("adminosztaly.php");
$megj =  new AdminNezet();


/* 0-át ad át ha a nem regelt-et akarjuk megnézni! */
$parameter = 1;

if(isset($_POST['nemregelt']))
{	
$parameter = 0;
}	
	
		
$megj->EladottTermekMegjelenites($siker="",$parameter);
?>