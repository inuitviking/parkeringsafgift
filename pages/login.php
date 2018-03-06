<main>

	<?php

	if(isset($_GET['e'])){

		switch ($_GET['e']) {
			case 1:
				echo "Brugernavn og kodeord skal udfyldes!";
				break;
			case 2:
				echo "Brugeren findes ikke!";
				break;
			case 3:
				echo "Forkert kodeord!";
				break;
			case 4:
				echo "Der er en fejl på din profil! Kontakt administrationen!";
				break;
			case 5:
				echo "Du er ikke logget ind!";
				break;
			case 6:
				echo "Du må ikke være der!";
				break;
		}

	}

	?>

	<form action="" method="post">

		<label for="username">Brugernavn</label>
		<input type="text" name="username" placeholder="Brugernavn">
		<label for="password">Kodeord</label>
		<input type="password" name="password" placeholder="Kodeord">
		<input type="submit" name="login" value="Log ind">

	</form>

	<a href="registrering">Tilbage</a>

	<?php

if(isset($_POST['login'])){

	$username = $_POST['username'];
	$password = $_POST['password'];
	$user = new User();
	echo $user->Login($username, $password);

}

?>

</main>
