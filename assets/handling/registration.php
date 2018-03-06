<?php

require_once('../connect.php');
require_once('../classes/crud.php');
require_once('../classes/user.php');

if(isset($_POST['guest'])){

	$regPlate = $con->real_escape_string($_POST['registrationPlate']);
	$register = new User();
	$register->RegPark($regPlate);

}
