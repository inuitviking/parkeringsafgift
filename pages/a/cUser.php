<main>

	<form action="" method="post">

		<label for="username">Brugernavn</label>
		<input type="text" name="username" placeholder="indtast brugernavn"><br>

		<label for="password">Kodeord</label>
		<input type="password" name="password" placeholder="indtast kodeord"><br>

		<label for="userType">Brugertype</label>
		<input type="number" name="userType" placeholder="bruger type: 1/0"><br>

		<label for="firstname">Fornavn(e)</label>
		<input type="text" name="firstname" placeholder="f.eks. Jon"><br>

		<label for="lastname">Efternavn</label>
		<input type="text" name="lastname" placeholder="f.eks Doe"><br>

		<input type="submit" name="cUser" value="Opret bruger">

	</form>

</main>

<?php

if(isset($_POST['cUser'])){

	$username = $con->real_escape_string($_POST['username']);
	$password = $con->real_escape_string($_POST['password']);
	$userType = $con->real_escape_string($_POST['userType']);
	$firstname = $con->real_escape_string($_POST['firstname']);
	$lastname = $con->real_escape_string($_POST['lastname']);

	$password = password_hash($password, PASSWORD_DEFAULT);

	$uArr = [
		'username'=>$username,
		'password'=>$password,
		'userType'=>$userType,
		'firstname'=>$firstname,
		'lastname'=>$lastname
	];

	$create = new CRUD();
	$create->Create('user', $uArr);

}

?>
<a href="administration">Tilbage</a>
