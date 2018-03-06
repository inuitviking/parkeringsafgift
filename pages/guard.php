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

	$user = $crud->Read('user', $uArr, "WHERE id = '$uId' AND userType = 2 LIMIT 1");

	if(mysqli_num_rows($user) == 1){

		if(isset($_GET['g'])){

			$g = $_GET['g'];

		}

		if(empty($g)){

			header('Location: guard&g=front');

		}elseif(!file_exists('pages/g/'.$g.'.php')){

			print "<script>window.location.replace('guard&g=404')</script>";

		}else{

			// require_once('assets/viewables/header.php');

			include('pages/g/'.$g.'.php');

			// require_once('assets/viewables/footer.php');
		}

	}else {

		header('Location: login&e=6');

	}

}else{

	header('Location: login&e=5');

}

?>
