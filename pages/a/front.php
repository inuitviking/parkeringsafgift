<main>

<?php

$admin = new CRUD();

if(isset($_GET['dr']) || isset($_GET['du'])){

	$dr = $con->real_escape_string($_GET['dr']);
	$du = $con->real_escape_string($_GET['du']);

	if($dr !='' || $du !=''){

		if($_GET['dr']){
			$admin->Delete('regPlates', $dr);
		}elseif($_GET['du']){
			$admin->Delete('user', $du);
		}
		header('Location: administration');

	}else{

		echo "Blev ikke slettet.";

	}

}

?>

	<h1>Forside</h1>

	<p>Her kan du se alle brugere, registrerede nummereplader både med og uden brugere osv.</p>

	<div class="container">
		<div class="table">
			<div class="tableBody">
				<div class="tableRow tableTitle">
					<div class="tableCell"><pre>#</pre></div>
					<div class="tableCell"><pre>Nummerplade</pre></div>
					<div class="tableCell"><pre>Bruger ID</pre></div>
					<div class="tableCell"><pre>Tid Parkeret</pre></div>
					<div class="tableCell"><pre>Registreret</pre></div>
					<div class="tableCell"><pre>Registrerings tidspunkt</pre></div>
					<div class="tableCell"><pre>Bøde</pre></div>
				</div>
			<?php

			 $regPlates = $admin->Read('regPlates', ['*']);

			 while($rp = $regPlates->fetch_object()){
	?>

			<div class="tableRow">
				<div class="tableCell"><pre><?=$rp->id ?></pre></div>
				<div class="tableCell"><pre><?=$rp->regPlate ?></pre></div>
				<div class="tableCell"><pre><?=$rp->userId ?></pre></div>
				<div class="tableCell"><pre><?=$rp->timeParked ?></pre></div>
				<div class="tableCell"><pre><?=$rp->confirmed ?></pre></div>
				<div class="tableCell"><pre><?=$rp->confirmationTime ?></pre></div>
				<div class="tableCell"><pre><?=$rp->ticketType ?></pre></div>
				<div class="tableCell"><a href="administration&a=eReg&id=<?=$rp->id ?>">edit</a>/<a href="administration&a=front&dr=<?=$rp->id ?>">delete</a></div>
			</div>

	<?php

			 }

			?>
			</div>
		</div>
	</div>

	<div class="container">
		<div class="table">
			<div class="tableBody">
				<div class="tableRow tableTitle">
					<div class="tableCell"><pre>#</pre></div>
					<div class="tableCell"><pre>Brugernavn</pre></div>
					<div class="tableCell"><pre>Brugertype</pre></div>
					<div class="tableCell"><pre>Fornavn(e)</pre></div>
					<div class="tableCell"><pre>Efternavn</pre></div>
					<div class="tableCell"><a href="administration&a=cUser">Opret bruger</a></div>
				</div>
			<?php

			$uArr = [
				'id',
				'username',
				'userType',
				'firstname',
				'lastname'
			];

			$users = $admin->Read('user', $uArr);

			while($u = $users->fetch_object()){
	?>

			<div class="tableRow">
				<div class="tableCell"><pre><?=$u->id ?></pre></div>
				<div class="tableCell"><pre><?=$u->username ?></pre></div>
				<div class="tableCell"><pre><?=$u->userType ?></pre></div>
				<div class="tableCell"><pre><?=$u->firstname ?></pre></div>
				<div class="tableCell"><pre><?=$u->lastname ?></pre></div>
				<div class="tableCell"><a href="administration&a=eUser&id=<?=$u->id ?>">edit</a>/<a href="administration&a=front&du=<?=$u->id ?>">delete</a></div>
			</div>

	<?php

			 }

			?>
			</div>
		</div>
	</div>
</main>
<a href="administration&logoff">Log af</a>
