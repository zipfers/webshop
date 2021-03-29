<?php
session_start();

unset($_SESSION['felhasznalo_nev']);

//session_destroy();

header("Location: index.php");
?>