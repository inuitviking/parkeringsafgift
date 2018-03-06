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

		global $con;
		$today = new DateTime();

		if($regPlate != ''){

			$regPlate = $con->real_escape_string($regPlate);
			$regPlate = strtolower($regPlate);
			$regPlate = preg_replace('/\s+/', '', $regPlate);

			$checkRegPlate = $con->query("SELECT id, userId, timeParked, confirmed FROM regPlates WHERE regPlate = '$regPlate' LIMIT 1");

			if(mysqli_num_rows($checkRegPlate) == 1){

				while ($crp = $checkRegPlate->fetch_object()) {

					if($crp->timeParked != null){

						if($crp->confirmed == 0){
							$timeParked = new DateTime($crp->timeParked);
							if($crp->userId != 0){

								$checkUser = $con->query("SELECT id FROM user WHERE id = ".$crp->userId." LIMIT 1");

								if(mysqli_num_rows($checkUser) == 1){

									$interval = $today->diff($timeParked);
									$hour = $interval->format('%h');
									$minutes = $interval->format('%i');

									$today = $today->format("Y-m-d H:i:s");

									if($hour > 0 && $minutes > 20){
										$con->query("UPDATE regPlates SET confirmed = 1, confirmationTime = '$today', ticketType = 1 WHERE userId = $crp->userId");
									}else{
										$con->query("UPDATE regPlates SET confirmed = 1, confirmationTime = '$today', ticketType = 3 WHERE userId = $crp->userId");
									}

									header("Location: registreret&s=processed&id=$crp->userId");

								}else{
									header('Location: registrering&e=3');
								}

							}else{

								$interval = $today->diff($timeParked);
								$hour = $interval->format('%h');
								$minutes = $interval->format('%i');

								$today = $today->format("Y-m-d H:i:s");

								if($hour > 0 && $minutes > 20){
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

		if($username != '' && $password != ''){

			$username = $con->real_escape_string($username);
			$password = $con->real_escape_string($password);

			$checkUser = $con->query("SELECT id, username, password, userType FROM user WHERE username='$username' LIMIT 1");

			if(mysqli_num_rows($checkUser) == 1){

				while($user = $checkUser->fetch_object()){

					if(password_verify($password, $user->password)){

						$_SESSION['uId'] = $user->id;
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
