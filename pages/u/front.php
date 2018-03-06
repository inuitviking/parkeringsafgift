<main>

	<form action="" method="post">

<?php
$uId = $_SESSION['uId'];

$regID = $crud->Read('regPlates',['id'], "WHERE userId=$uId LIMIT 1");

while($id = $regID->fetch_object()){
	if(isset($_POST['change'])){

		$crud->Update('regPlates',['regPlate'=>$_POST['regPlate']], $id->id);

	}
}

$regPlate = $crud->Read('regPlates', ['id','regPlate'], "WHERE userId=$uId LIMIT 1");

while($u = $regPlate->fetch_object()){

?>

	<label for="regPlate">Din nuværende nummerplade: <?=$u->regPlate ?><br>Ændr</label>
	<input type="text" name="regPlate" placeholder="<?=$u->regPlate?>"><br>
	<input type="submit" name="change" value="Ændre">
<?php

}

?>

	</form>

</main>
<a href="user&logoff">Log af</a>
