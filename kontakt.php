<?php
session_start();
require_once("weboldal.php");

$megj = new Weboldal();
$megj->MegjelenitesKontakt();
?>