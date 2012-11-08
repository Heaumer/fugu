	<div id="banniere"></div>
	<div id="menu">
		<div class="liens"><a href="user.php">Manage</a></div>
		<div class="liens"><a href="proposer_trajet.php">Propose</a></div>
		<div class="liens"><a href="chercher_trajet.php">Search</a></div>

<?php
	if (isset($_SESSION['connected']))
		echo '<div class="liens"><a href="disconnect.php">Disconnect</a></div>';
?>
	</div>
