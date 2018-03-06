<?php

// Ser om der er en session array med uId
if(isset($_SESSION['uId'])){

	// $_SESSION['uId'] i en variable
	$uId = $_SESSION['uId'];
	// Kalder på CRUD
	$crud = new CRUD();

	// Vi laver en array med de kolonner vi skal bruge
	$uArr = [
		'id',
		'username',
		'userType',
		'firstname',
		'lastname'
	];

	// Vi bruger Read metoden til at læse fra user tabellen i databasen
	$user = $crud->Read('user', $uArr, "WHERE id = '$uId' AND userType = 3 LIMIT 1");

	// Hvis der er én i tabellen med de kriterier
	if(mysqli_num_rows($user) == 1){

		// Nu gør vi det samme som index.php hvor $u er det samme som $page
		if(isset($_GET['u'])){

			$u = $_GET['u'];

		}

		if(empty($u)){

			header('Location: user&u=front');

		}elseif(!file_exists('pages/u/'.$u.'.php')){

			print "<script>window.location.replace('user&u=404')</script>";

		}else{
			include('pages/u/'.$u.'.php');
		}

	}else {

		header('Location: login&e=6');

	}

}else{

	header('Location: login&e=5');

}

?>
