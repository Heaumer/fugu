	<div id="banniere"></div>
	<div id="menu">
		<div class="liens"><a href="user.php?token=<?php echo $_SESSION['token'] ?>">Manage</a></div>
		<div class="liens"><a href="proposer_trajet.php?token=<?php echo $_SESSION['token'] ?>">Propose</a></div>
		<div class="liens"><a href="chercher_trajet.php?token=<?php echo $_SESSION['token'] ?>">Search</a></div>

<?php
	if (isset($_SESSION['connected']))
		echo '<div class="liens"><a href="disconnect.php?token=' . $_SESSION['token'] . '">Disconnect</a></div>';
?>
	</div>
