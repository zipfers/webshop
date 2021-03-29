<?php
require("adminosztaly.php");

//Csak NEM aktiv terméket listáz
//Mivel a nem aktív termék listázást hívjuk ezért átadjuk neki az 0-át , amivel a 0-re SET-elt termékeket listázza ki.

$parameter = 0;
$megjel = new AdminNezet();
echo $megjel->AdminAlCsakTermekListazo($parameter);
?>

