<?php

	include_once 'inc/user.php';
	include_once 'inc/utils.php';
	include_once 'inc/route.php';

	$err = "";

	if (isset($_SESSION['connected']) == false || $_SESSION['connected'] == false)
		header('Location: index.php');

	if (isset($_POST['action']))
	if (strcmp($_POST['action'], "proposer") == 0) {
			array_walk($_POST, "sanitized");

		$db = opendb("sql/app.db");

		if (register_route($_SESSION['user'], $_POST['adresseA'],
				$_POST['adresseB'],
				$_POST['distanceTotale'],
				$_POST['tempsTotal'],
				$_POST['description'], $db)) {
			$db = NULL;
			header('Location: user.php');
		}
		else
			$err = "Route not registered!";

		$db = NULL;
	}
	
	include('static/header_proposition_trajet.html');
	include('inc/menu.php');
	prerr($err);	
?>

	<div id="header">
		<h1>Proposer un trajet</h1>
	</div>

	<div id="carte" style="width: 550px; height: 500px;"></div>

	<div id="informations">
		<form action="#" method="post">
			<h3>Départ</h3>
			<div id="depart">
				<p>Coordonnées : ( <span id="latA"></span> , <span id="longA"></span> )</p>
				<p>Adresse<input size="40" onChange="changerPoint(this, 'depart');" type="text" name="adresseA" id="adresseA" value="" /></p>
			</div>
			<h3>Arrivée</h3>
			<div id="arrivee">
				<p>Coordonnées : ( <span id="latB"></span> , <span id="longB"></span> )</p>
				<p>Adresse<input size="40" onChange="changerPoint(this, 'arrivee');" type="text" name="adresseB" id="adresseB" value="" /></p>
			</div>
			<p><strong>Distance totale : </strong><span id="distanceTotale"></span></p>
			<input type="hidden" name="distanceTotale" id="dT" value="" />
			<p><strong>Temps : </strong><span id="tempsTotal"></span></p>
			<input type="hidden" name="tempsTotal" id="tT" value="" />
			<p><strong>Description</strong>
			<textarea rows="4" cols="50" name="description"></textarea></p>
			<!--<input type="submit" value="Proposer" />-->
			<input type="button" value="Proposer" name="submit_button" onclick="this.form.submit();">
			<input type="hidden" name="action" value="proposer" />
		</form>
	</div>

<?php include('static/footer.html'); ?>
