<?php
$userEdit = new CRUD();

if(isset($_POST['uedit'])){
	$id = $con->real_escape_string($_GET['id']);

	$rArr = [
		'username'=>$_POST['username'],
		'userType'=>$_POST['userType'],
		'firstname'=>$_POST['firstname'],
		'lastname'=>$_POST['lastname']
	];

	$userEdit->Update('user', $rArr, $id);

}

if(isset($_GET['id'])){

	$id = $con->real_escape_string($_GET['id']);

	if($id!=''){
		$uArr = [
			'id',
			'username',
			'userType',
			'firstname',
			'lastname'
		];

		$uedit = $userEdit->Read('user', $uArr, "WHERE id=$id");

		while($ue=$uedit->fetch_object()){

	?>

			<form action="" method="post">

				<label for="username">Nuværende brugernavn: <?=$ue->username ?><br>Ændre brugernavn</label>
				<input type="text" name="username" placeholder="<?=$ue->username?>"><br>

				<label for="userType">Nuværende brugertype: <?=$ue->userType ?><br>Ændre brugertype</label>
				<input type="number" name="userType" placeholder="<?=$ue->userType?>"><br>

				<label for="firstname">Fornavn: <?=$ue->firstname?><br>Ændr</label>
				<input type="text" name="firstname" placeholder="<?=$ue->firstname?>"><br>

				<label for="lastname">Efternavn: <?=$ue->lastname?><br>Ændr</label>
				<input type="text" name="lastname" placeholder="<?=$ue->lastname?>"><br>

				<input type="submit" name="uedit" value="Redigér">
			</form>

	<?

		}
	}else{
		echo 'Ingen bruger valgt';
	}

}else{
	echo 'Ingen bruger valgt';
}

?>

<a href="administration">Tilbage</a>
