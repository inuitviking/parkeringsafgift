<!--
Taken from
https://stackoverflow.com/questions/6146391/how-can-i-make-a-10-second-countdown-timer-before-a-download-button-link-appears
Simplified down to just seconds and to redirect after five seconds back to the parking registration
-->
<main>
	<center>

		<h1 id="countdowntimertxt" class="countdowntimer">0</h1>

<?php
error_reporting(E_ALL ^ E_NOTICE);
if(isset($_GET['s']) && $_GET['s'] == 'processed'){

	$user = new CRUD();

	if(isset($_GET['id'])){

	 	$userId = $_GET['id'];

		$uArr = [
			"regPlates.regPlate",
			"regPlates.confirmationTime",
			"regPlates.ticketType",
			"user.firstname",
			"user.lastname"
		];

		$uResult = $user->Read('regPlates', $uArr, "INNER JOIN user ON regPlates.userId=user.id WHERE regPlates.userID = $userId");
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

		<p>Tak <?=$u->firstname." ".$u->lastname?></p>
		<p>Din parkering er registreret den	<?=$date->format("j / n");?></p>
		<p>Klokken <?=$date->format("G:i"); ?></p>
		<p>Nummerplade: <?=$u->regPlate ?></p>
		<p>Bøde: <?=$i ?></p>

<?php
		}

	}elseif($_GET['regPlate']){

		$regPlate = $_GET['regPlate'];

		$uArr = [
			"regPlate",
			"confirmationtime"
		];

		$uResult = $user->Read('regPlates', $uArr, "WHERE regPlate = '$regPlate'");

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
