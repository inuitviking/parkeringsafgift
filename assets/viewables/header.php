<!DOCTYPE html>

<html>

	<head>

<?php
// hvis brugeren har trykket på log af
if(isset($_GET['logoff'])){
	// ødeleg sessionen
	session_destroy();
}

?>

		<title><?=$_GET['page'] ?></title>

		<link rel="stylesheet" type="text/css" href="assets/css/main.css">
		<meta charset="utf-8">

	</head>
