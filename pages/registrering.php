<main>

	<h1>Velkommen til EUC Syd Sønderborg</h1>
	<p>Skriv venligst din nummerplade, så du kan få den registreret</p>

<?php

#Checker om $_GET['e'] eksisterer
#'e' bliver brugt som fejlkode
if(isset($_GET['e'])){

	#En switch der tager value fra $_GET['e'] og spytter tilsvarende advarsler ud
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

	<!--Denne formular tager nummerpladen og sender den videre med en POST
	der kan læses om $_POST her: http://php.net/manual/en/reserved.variables.post.php-->
	<form action="" method="post">
		<label for="registrationPlate">Nummerplade</label>
		<input type="text" name="registrationPlate" maxlength="7" placeholder="f.eks. AB01001">
		<input type="submit" name="register" value="Registrer">

	</form>

	<p>Ændret nummerplade? <a href="login">Log ind her</a></p>

	<p><b>OBS!<b> Denne del ville selvfølgelig ikke være vist på den rigtige vare.<br>
	Den er der kun for at simulere at en bil er parkeret</p>
	<!--Dette link sender en til den samme side, men med URL-parameteren 'car'. Denne parameter er tom-->
	<a href="registrering&car">Parkér bil</a><br>
	<p>Din nummerplade: <?=$_GET['np']?></p>

	<?php

	#Ser om car parameteren er til stede
	if(isset($_GET['car'])){

		#Nogle tomme variabler. PHP er glad for at man declarer dem, end bare "$variable;" alene
		$letters = '';
		$numbers = '';

		#Her splitter vi det engelske alfabet, og lægger den i en variabel der hedder $seed
		$seed = str_split('abcdefghijklmnopqrstuvwxyz');
		#Vi blander bogstaverne
		shuffle($seed);
		#her kører vi den gennem en foreach to gange
		#og tilsætter de to tilfældige bogstaver i $letters som er en string
		foreach (array_rand($seed, 2) as $k) $letters .= $seed[$k];
		#Her laver vi en tilfældigt 5 digit int
		$numbers = rand(pow(10, 5-1), pow(10, 5)-1);
		#Her setter vi dem sammen. Her bliver integers til string
		$registrationPlate = $letters.$numbers;
		#Vi kalder på CRUD classen
		$crud = new CRUD();
		#Vi kalder på DateTime classen (indbygget i PHP)
		#Denne tager nuens tidspunkt
		$now = new DateTime;
		#Vi formaterer den, så den ser ud som vi vil have den
		#I dette tilfælde skal den passe til databasen,
		#så år,måned,dag,timer,minutter,sekunder
		$now = $now->format("Y-m-d H:i:s");
		#Vi bruger Create metoden fra CRUD class, og registrer vores tilfældigt
		#genererede nummerplade som parkeret.
		$crud->Create('regPlates',['regPlate'=>$registrationPlate,'timeParked'=>$now]);
		#Vi sender brugeren til den side vi er på, men med np parameteren
		#som indeholder tilfældigtgenererede nummerpladen
		header("Location: registrering&np=$registrationPlate");
	}

?>
<?php

	#Hvis brugeren har trykket på Registrer
	if(isset($_POST['register'])){

		#Put nummerpladen i en variable
		$regPlate = $_POST['registrationPlate'];
		#Vi kalder User class
		$register = new User();
		#Vi bruger RegPark metoden fra User class til at godkende nummerpladen
		$register->RegPark($regPlate);

	}

	?>
</main>
