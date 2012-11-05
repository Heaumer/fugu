	<div id="banniere"></div>
	<div id="menu">
		<div class="liens"><a href="user.php">Gérér</a></div>
		<div class="liens"><a href="proposer_trajet.php">Proposer</a></div>
		<div class="liens"><a href="chercher_trajet.php">Chercher</a></div>

<?php
	if (isset($_SESSION['connected']))
		echo '<div class="liens"><a href="disconnect.php">Se déconnecter</a></div>';
?>
	</div>
