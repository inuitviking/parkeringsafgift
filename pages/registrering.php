<main>

	<h1>Velkommen til EUC Syd Sønderborg</h1>
	<p>Skriv venligst din nummerplade, så du kan få den registreret</p>

<?php

if(isset($_GET['e'])){

	switch ($_GET['e']) {
		case 1:
			echo "Du skal indtaste en nummerplade!";
			break;
		case 2:
			echo "Nummerpladen er ikke registreret eller er ikke på parkeringspladsen.";
			break;
		case 3:
			echo "Bilen er allerede registreret.";
			break;
	}

}

?>

	<form action="" method="post">
		<label for="registrationPlate">Nummerplade</label>
		<input type="text" name="registrationPlate" maxlength="7" placeholder="f.eks. AB01001">
		<input type="submit" name="register" value="Registrer">

	</form>

	<p>Ændret nummerplade? <a href="login">Log ind her</a></p>

	<p><b>OBS!<b> Denne del ville selvfølgelig ikke være vist på den rigtige vare.<br>
	Den er der kun for at simulere at en bil er parkeret</p>
	<a href="registrering&car">Parkér bil</a><br>
	<p>Din nummerplade: <?=$_GET['np']?></p>

	<?php

	if(isset($_GET['car'])){

		$letters = '';
		$numbers = '';

		$seed = str_split('abcdefghijklmnopqrstuvwxyz');
		shuffle($seed); // probably optional since array_is randomized; this may be redundant
		$rand = '';
		foreach (array_rand($seed, 2) as $k) $letters .= $seed[$k];
		$numbers = rand(pow(10, 5-1), pow(10, 6)-1);
		$registrationPlate = $letters.$numbers;
		$crud = new CRUD();
		$now = new DateTime;
		$now = $now->format("Y-m-d H:i:s");
		$crud->Create('regPlates',['regPlate'=>$registrationPlate,'timeParked'=>$now]);
		header("Location: registrering&np=$registrationPlate");
	}

?>
<?php

	if(isset($_POST['register'])){

		$regPlate = $_POST['registrationPlate'];
		$register = new User();
		echo $register->RegPark($regPlate);

	}

	?>
</main>
