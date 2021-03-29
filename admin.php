<?php
require("adminosztaly.php");

//A belépő oldalról kerülünk ide a login-php-ról ha az admin a felhasználó akit beléptettünk.

//Az Admin Főoldalt jeleníti meg az Adminosztályból
$kezdoadminoldal = new AdminNezet();
$kezdoadminoldal->AdminMegjelenites();
?>



