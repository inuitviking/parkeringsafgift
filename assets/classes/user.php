<?php

//This class is where all user functions are, like registering a registration regPlate
//or logging in.
class User{

	/*
	This method registers a registratin plate in the database,
	but the registration plate has to be registered as parked,
	defined by the timeParked column in the DB. If it's null
	it's not parked, but if it's a dateTime, it is parked,
	and one can register their car.
	*/
	public function RegPark($regPlate){
		// tag $con
		global $con;
		// tag dagens dato og nuens tid
		$today = new DateTime();
		// hvis $regPlate ikke er tom
		if($regPlate != ''){
			// Sørg for at det ikke er muligt at gøre SQL injection
			$regPlate = $con->real_escape_string($regPlate);
			// lav bogstaverne små
			$regPlate = strtolower($regPlate);
			// fjern usynlige tegn og mellemrum
			$regPlate = preg_replace('/\s+/', '', $regPlate);

			// kør det igennem databasen, for at se om nummerpladen eksisterer
			$checkRegPlate = $con->query("SELECT id, userId, timeParked, confirmed FROM regPlates WHERE regPlate = '$regPlate' LIMIT 1");

			// Hvis den gør
			if(mysqli_num_rows($checkRegPlate) == 1){
				// Så kør en while loop hvor du sætter alt i et object $crp
				while ($crp = $checkRegPlate->fetch_object()) {

					// Hvis bilen er parkeret
					if($crp->timeParked != null){

						// Hvis den ikke er blevet godkendt
						if($crp->confirmed == 0){
							// Put tidspunktet den parkerede i put det i en DateTime variabel
							$timeParked = new DateTime($crp->timeParked);
							// Hvis brugerns id ikke er 0
							if($crp->userId != 0){

								// Send en query afsted for at se om brugeren eksisterer
								$checkUser = $con->query("SELECT id FROM user WHERE id = ".$crp->userId." LIMIT 1");
								// hvis han gør
								if(mysqli_num_rows($checkUser) == 1){

									// Lav nogle variabler relateret til dag, time, og minut
									$interval = $today->diff($timeParked);
									$day = $interval->format('%d');
									$hour = $interval->format('%h');
									$minutes = $interval->format('%i');

									// formater dagens tid så den databasen kan acceptere den (den skal have bestemt format)
									$today = $today->format("Y-m-d H:i:s");

									//hvis $day, $hour er mindre end 0 og $minutes minder en 20
									if($day > 0 && $hour > 0 && $minutes > 20){
										// Opdater nummerpladen hvor der er en bruger, og giv ingen bøde
										$con->query("UPDATE regPlates SET confirmed = 1, confirmationTime = '$today', ticketType = 1 WHERE userId = $crp->userId");
									}else{
										// opdater nummerpladen hvor der er en bruger, og giv en bøde
										$con->query("UPDATE regPlates SET confirmed = 1, confirmationTime = '$today', ticketType = 3 WHERE userId = $crp->userId");
									}

									// send brugeren til en anden side, der forteller dem at bilen er registrerert
									header("Location: registreret&s=processed&id=$crp->userId");

								}else{
									header('Location: registrering&e=3');
								}

							}else{
								$interval = $today->diff($timeParked);
								$day = $interval->format('%d');
								$hour = $interval->format('%h');
								$minutes = $interval->format('%i');

								$today = $today->format("Y-m-d H:i:s");

								if($day > 0 && $hour > 0 && $minutes > 20){
									$con->query("UPDATE regPlates SET confirmed = 1, confirmationTime = '$today', ticketType = 1 WHERE regPlate = '$regPlate'");
								}else{
									$con->query("UPDATE regPlates SET confirmed = 1, confirmationTime = '$today', ticketType = 3 WHERE regPlate = '$regPlate'");
								}

								header("Location: registreret&s=processed&regPlate=$regPlate");

							}

						}else{
							header('Location: registrering&e=3');
						}

					}else{

						header('Location: registrering&e=2');

					}

				}

			}else{
				Header('Location: registrering&e=2');
			}

		}else{
			header('Location: registrering&e=1');
		}

	}//end of RegPark method


	/*
	This method logs the user in, but depending on
	the user type, they go to different pages.
	There are three types:
	user
	parking guard
	administrator
	*/
	public function Login($username, $password){

		global $con;

		// hvis formularen ikke var tom
		if($username != '' && $password != ''){

			// gør tingene sikre mod SQL injection
			$username = $con->real_escape_string($username);
			$password = $con->real_escape_string($password);

			// Se om brugeren eksisterer
			$checkUser = $con->query("SELECT id, username, password, userType FROM user WHERE username='$username' LIMIT 1");

			// Hvis han gør
			if(mysqli_num_rows($checkUser) == 1){

				// Loop ham igennem, fordi det er nemmer at køre objecter
				while($user = $checkUser->fetch_object()){

					// hvis koden er rigtig
					if(password_verify($password, $user->password)){
						// put deres id i en session
						$_SESSION['uId'] = $user->id;
						// alt efter hvilken brugertype de er
						// går de til den side der passer til dem
						switch ($user->userType) {
							case 1:
								header('Location: administration');
								break;
							case 2:
								header('Location: guard');
								break;
							case 3:
								header('Location: user');
								break;
							default://No user type assigned
								header('Location: login&e=4');
								break;
						}

					}else{
						//Wrong password
						header('Location: login&e=3');
					}

				}

			}else{

				//User doesn't exist
				header('Location: login&e=2');

			}

		}else{
			//username and password are empty
			header('Location: login&e=1');
		}

	}//end of Login method

}
