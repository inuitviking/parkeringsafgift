<?php
date_default_timezone_set('Europe/Copenhagen');

session_start();

// ini_set('display_errors', 1);
// ini_set('display_startup_errors', 1);
// error_reporting(E_ALL);

$host = 'localhost';
$username = 'ivikknet';
$password = 'Freud.,562078';
$db = 'ivikknet_park';

$con = new mysqli($host, $username, $password, $db) or die("Unable to connect");
$con->set_charset("utf8");
global $con;
