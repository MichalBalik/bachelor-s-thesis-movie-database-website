<?php

error_reporting(E_ALL & ~E_NOTICE);
date_default_timezone_set('Europe/Bratislava');

// jwt udaje
$key = "kluc";
$iss = "http://localhost/bakalarka/index.php";
$aud = "http://localhost/bakalarka/index.php";
$iat = 1356999524;
$nbf = 1357000000;
?>