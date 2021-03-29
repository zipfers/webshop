<?php
require("adminosztaly.php");
//Csak aktiv terméket listáz

//Mivel az aktív termék listázást hívjuk ezért átadjuk neki az 1-et , amivel a 1-re SET-elt termékeket listázza ki.

$parameter = 1;
$megjel = new AdminNezet();
echo $megjel->AdminAlCsakTermekListazo($parameter,$siker="");
?>