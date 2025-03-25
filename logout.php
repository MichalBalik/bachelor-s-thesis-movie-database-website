<?php
include_once "System.php";
setcookie('jwt', null, -1, '/');

session_unset();
session_destroy();
header("Location: index.php");
