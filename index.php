<?php

#requires the connection file
require_once('assets/connect.php');

#requires Classes
require_once('assets/classes/crud.php');
require_once('assets/classes/user.php');

if(isset($_GET['page'])){

	$page = $_GET['page'];

}

if(empty($page)){

	header('Location: registrering');

}elseif(!file_exists('pages/'.$page.'.php')){

	print "<script>window.location.replace('404')</script>";

}else{

	require_once('assets/viewables/header.php');

	include('pages/'.$page.'.php');

	require_once('assets/viewables/footer.php');
}

// echo password_hash("test", PASSWORD_DEFAULT);
