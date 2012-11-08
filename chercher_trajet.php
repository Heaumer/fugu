<?php

	include_once 'inc/user.php';
	include_once 'inc/utils.php';

	if (isset($_SESSION['connected']) == false || $_SESSION['connected'] == false)
		header('Location: index.php');
	
	include('static/header_chercher_trajet.html');
	include('inc/menu.php');
?>

	<div id="header">
		<h1>Chercher un trajet</h1>
	</div>

	<div id="carte" style="width: 550px; height: 500px;"></div>

	<div id="informations">
		<form action="lister_trajets.php" method="post">
			<h3>Départ</h3>
			<div id="depart">
				<p>Coordonnées : ( <span id="latA"></span> , <span id="longA"></span> )</p>
				<p>Adresse<input size="40" onChange="changerPoint(this, 'depart');" type="text" name="adresseA" id="adresseA" value="" /></p>
			</div>
			<input type="hidden" name="adresseA_hidden" id="adresseA_hidden" value="" />
			<h3>Arrivée</h3>
			<div id="arrivee">
				<p>Coordonnées : ( <span id="latB"></span> , <span id="longB"></span> )</p>
				<p>Adresse<input size="40" onChange="changerPoint(this, 'arrivee');" type="text" name="adresseB" id="adresseB" value="" /></p>
			</div>
			<input type="hidden" name="adresseB_hidden" id="adresseB_hidden" value="" />
			<p><strong>Distance totale : </strong><span id="distanceTotale"></span></p>
			<p><strong>Temps : </strong><span id="tempsTotal"></span></p>
			<input type="button" value="Chercher" name="search_button" onclick="this.form.submit();">
			<input type="hidden" name="action" value="chercher" />
		</form>
	</div>

<?php include('static/footer.html'); ?>
