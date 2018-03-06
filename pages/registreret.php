<!--
Taken from
https://stackoverflow.com/questions/6146391/how-can-i-make-a-10-second-countdown-timer-before-a-download-button-link-appears
Simplified down to just seconds and to redirect after five seconds back to the parking registration
-->
<main>
	<center>

		<!--Countdown er her-->
		<h1 id="countdowntimertxt" class="countdowntimer">0</h1>

<?php
#eksisterer s parameteren og er den lige med processed
if(isset($_GET['s']) && $_GET['s'] == 'processed'){

	#kalder vi CRUD class
	$user = new CRUD();

	#Hvis id paramteren eksisterer
	if(isset($_GET['id'])){

		#sætter vi den i en variabel
	 	$userId = $_GET['id'];

		#Vi laver en array med de kolonner vi skal bruger fra DB
		$uArr = [
			"regPlates.regPlate",
			"regPlates.confirmationTime",
			"regPlates.ticketType",
			"user.firstname",
			"user.lastname"
		];

		#Vi bruger Read metoden fra CRUD class til at læse både user og regPlates tabllerne
		$uResult = $user->Read('regPlates', $uArr, "INNER JOIN user ON regPlates.userId=user.id WHERE regPlates.userID = $userId");
		#Kører det igennem en while loop
		while($u = $uResult->fetch_object()){
			#putter confirmationTime fra databasen i en DateTime variable
			$date = new DateTime($u->confirmationTime);
			#Switch til at sige om man har fået bøde eller ej
			switch ($u->ticketType) {
				case NULL:
					$i='Nej';
					break;
				case 1:
					$i='Ja. 756kr';
					break;
				case 3:
					$i='Nej';
					break;
			}
?>
<!-- Skriver alt ud i HTML -->
		<p>Tak <?=$u->firstname." ".$u->lastname?></p>
		<p>Din parkering er registreret den	<?=$date->format("j / n");?></p>
		<p>Klokken <?=$date->format("G:i"); ?></p>
		<p>Nummerplade: <?=$u->regPlate ?></p>
		<p>Bøde: <?=$i ?></p>

<?php
		}
#hvis id parameteren ikke eksisterer, tager vi regPlate parameteren
	}elseif($_GET['regPlate']){
		#putter den i en variabel
		$regPlate = $_GET['regPlate'];
		#laver en array af de kolonner vi skal bruge
		$uArr = [
			"regPlate",
			"confirmationtime"
		];
		#Læser regPlates tabellen hvor regPlate er lige med nummerpladen der blev skrevet ind
		$uResult = $user->Read('regPlates', $uArr, "WHERE regPlate = '$regPlate'");

		#Kører det igennem en while loop
		#hvor vi gør det samme hvis id parameteren var der
		#bare uden brugerens navn
		while($u = $uResult->fetch_object()){
			$date = new DateTime($u->confirmationTime);
			switch ($u->ticketType) {
				case NULL:
					$i='Nej';
					break;
				case 1:
					$i='Ja. 756kr';
					break;
				case 3:
					$i='Nej';
					break;
			}
?>

		<p>Din parkering er registreret den	<?=$date->format("j / n");?></p>
		<p>Klokken <?=$date->format("G:i"); ?></p>
		<p>Nummerplade: <?=$u->regPlate ?></p>
		<p>Bøde: <?=$i ?></p>

<?php
		}

	}

}

?>

<!-- nedtæller tager fra stackoverflow. Credit er øverst -->
<script type="text/javascript">
var sTime = new Date().getTime();
var countDown = 5; // Number of seconds to count down from.

function UpdateCountDownTime() {
	var cTime = new Date().getTime();
	var diff = cTime - sTime;
	var seconds = countDown - Math.floor(diff / 1000);
	if(seconds >= 0){
		document.getElementById("countdowntimertxt").innerHTML = seconds;
}else{
	document.getElementById("countdowntimertxt").style.display="none";
	clearInterval(counter);
	window.location.replace('registrering');
}
}
UpdateCountDownTime();
var counter = setInterval(UpdateCountDownTime, 500);
</script>

	</center>
</main>
