<?php
// Set tidsone til dansk tid
date_default_timezone_set('Europe/Copenhagen');

// start en session (så vi kan håndtere login og logud)
session_start();

$host = 'localhost';
$username = 'ivikknet';
$password = 'Freud.,562078';
$db = 'ivikknet_park';

// lav en variabel hvor vi kalder mysqli til at forbinde med databasen
//eller dø, hvis den ikke kan
$con = new mysqli($host, $username, $password, $db) or die("Unable to connect");
// Set alt til at være utf8
$con->set_charset("utf8");
// Gør $con global
global $con;
