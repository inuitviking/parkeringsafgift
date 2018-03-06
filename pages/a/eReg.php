<?php
$regEdit = new CRUD();

if(isset($_POST['redit'])){
	$id = $con->real_escape_string($_GET['id']);

	switch ($_POST['confirmed']) {
		case '':
			$_POST['confirmed'] = 0;
			break;
	}

	$rArr = [
		'regPlate'=>$_POST['regPlate'],
		'userId'=>$_POST['userID'],
		'confirmed'=>$_POST['confirmed'],
		'ticketType'=>$_POST['ticketType']
	];

	$regEdit->Update('regPlates', $rArr, $id);

}

if(isset($_GET['id'])){

	$id = $con->real_escape_string($_GET['id']);

	if($id!=''){
		$redit = $regEdit->Read('regPlates', ['*'], "WHERE id=$id");

		while($re=$redit->fetch_object()){

	?>

			<form action="" method="post">

				<label for="regPlate">Nuværende nummerplade: <?=$re->regPlate ?><br>Ændre nummerplade</label>
				<input type="text" name="regPlate" placeholder="<?=$re->regPlate?>"><br>

				<label for="userID">Nuværende brugerID: <?=$re->userId ?><br>Ændre ID</label>
				<input type="number" name="userID" placeholder="<?=$re->userId?>"><br>

				<?php
				switch($re->confirmed){
					case 1:
						$c = 'Ja';
						break;
					case 0:
						$c = 'Næ';
						break;
				}
				?>
				<label for="confirmed">Godkendt: <?=$c ?><br>Ændr</label>
				<input type="text" name="confirmed" placeholder="<?=$c?>"><br>

				<label for="ticket">Bødetype: <?=$re->ticketType ?></label>
				<input type="number" name="ticketType" placeholder="<?=$re->ticketType?>"><br>

				<input type="submit" name="redit" value="Redigér">
			</form>

	<?

		}
	}else{
		echo 'Ingen nummerplade valgt';
	}

}else{
	echo 'Ingen nummerplade valgt';
}

?>
<a href="administration">Tilbage</a>
