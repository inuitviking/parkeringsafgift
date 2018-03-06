<!DOCTYPE html>

<html>

	<head>

<?php

if(isset($_GET['logoff'])){
	session_destroy();
}

?>

		<title><?=$_GET['page'] ?></title>

		<link rel="stylesheet" type="text/css" href="assets/css/main.css">
		<meta charset="utf-8">

	</head>
