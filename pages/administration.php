<?php

// Kig på comments i user.php
if(isset($_SESSION['uId'])){


	$uId = $_SESSION['uId'];
	$crud = new CRUD();

	$uArr = [
		'id',
		'username',
		'userType',
		'firstname',
		'lastname'
	];

	$user = $crud->Read('user', $uArr, "WHERE id = '$uId' AND userType = 1 LIMIT 1");

	if(mysqli_num_rows($user) == 1){

		if(isset($_GET['a'])){

			$a = $_GET['a'];

		}

		if(empty($a)){

			header('Location: administration&a=front');

		}elseif(!file_exists('pages/a/'.$a.'.php')){

			print "<script>window.location.replace('administration&a=404')</script>";

		}else{

			// require_once('assets/viewables/header.php');

			include('pages/a/'.$a.'.php');

			// require_once('assets/viewables/footer.php');
		}

	}else {

		header('Location: login&e=6');

	}

}else{

	header('Location: login&e=5');

}

?>
