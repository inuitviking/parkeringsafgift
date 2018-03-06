<?php

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

	$user = $crud->Read('user', $uArr, "WHERE id = '$uId' AND userType = 3 LIMIT 1");

	if(mysqli_num_rows($user) == 1){

		if(isset($_GET['u'])){

			$u = $_GET['u'];

		}

		if(empty($u)){

			header('Location: user&u=front');

		}elseif(!file_exists('pages/u/'.$u.'.php')){

			print "<script>window.location.replace('user&u=404')</script>";

		}else{

			// require_once('assets/viewables/header.php');

			include('pages/u/'.$u.'.php');

			// require_once('assets/viewables/footer.php');
		}

	}else {

		header('Location: login&e=6');

	}

}else{

	header('Location: login&e=5');

}

?>
