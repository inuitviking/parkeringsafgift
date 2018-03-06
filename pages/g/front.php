<main>

<?php


?>

	<h1>Forside</h1>

	<p>Her kan du se alle parkerede biler</p>

	<div class="container">
		<div class="table">
			<div class="tableBody">
				<div class="tableRow tableTitle">
					<div class="tableCell"><pre>#</pre></div>
					<div class="tableCell"><pre>Nummerplade</pre></div>
					<div class="tableCell"><pre>Tid Parkeret</pre></div>
					<div class="tableCell"><pre>Registreret</pre></div>
					<div class="tableCell"><pre>Registrerings tidspunkt</pre></div>
					<div class="tableCell"><pre>Bøde</pre></div>
				</div>
			<?php

			 $regPlates = $crud->Read('regPlates', ['*'], "WHERE timeParked IS NOT NULL");

			 while($rp = $regPlates->fetch_object()){

				if(isset($_GET['ticket'])){
					$ticket = $con->real_escape_string($_GET['ticket']);
					switch ($rp->ticketType) {
						case NULL:
							$i=1;
							break;
						case 1:
							$i=3;
							break;
						case 3:
							$i=1;
							break;
					}
					$rArr = ['ticketType'=>$i];
					$crud->Update('regPlates', $rArr, $ticket);
				}

				 switch ($rp->ticketType) {
					 case NULL:
						 $t = 'Ingen bøde';
						 break;
					 case 1:
						 $t = 'Bøde';
						 break;
					 case 3:
						 $t = 'Ingen bøde';
						 break;
				 }
	?>

			<div class="tableRow">
				<div class="tableCell"><pre><?=$rp->id ?></pre></div>
				<div class="tableCell"><pre><?=$rp->regPlate ?></pre></div>
				<div class="tableCell"><pre><?=$rp->timeParked ?></pre></div>
				<div class="tableCell"><pre><?=$rp->confirmed ?></pre></div>
				<div class="tableCell"><pre><?=$rp->confirmationTime ?></pre></div>
				<div class="tableCell"><pre><?=$t?></pre></div>
				<div class="tableCell"><a href="guard&g=front&ticket=<?=$rp->id ?>">Bøde</a></div>
			</div>

	<?php

			 }

			?>
			</div>
		</div>
	</div>



</main>
<a href="guard&logoff">Log af</a>
