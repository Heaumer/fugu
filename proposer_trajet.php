<?php

	include_once 'inc/route.php';

	if (isset($_SESSION['connected']) && $_SESSION['user']) {
	
		if ($_SESSION['connected'] == false) {
			header('Location: index.php');
			
		} else {
		
			if (isset($_POST['action'])) {
			
				if (strcmp($_POST['action'], "proposer") == 0) {
					$startPoint = htmlspecialchars($_POST['adresseA'], ENT_QUOTES);
					$endPoint = htmlspecialchars($_POST['adresseB'], ENT_QUOTES);
					$distance = htmlspecialchars($_POST['distanceTotale'], ENT_QUOTES);
					$temps = htmlspecialchars($_POST['tempsTotal'], ENT_QUOTES);
					$description = htmlspecialchars($_POST['description'], ENT_QUOTES);
				}
		
				$db = NULL;
				try {
					/* be sure BOTH .db file and sql directory have rw perm */
					$db = new PDO('sqlite:sql/app.db');
				} catch(PDOException $e) {
					echo 'cannot load db';
					exit;
				}
		
				if (enregistrer_trajet($_SESSION['user'], $startPoint, $endPoint ,$distance , $temps, $description, $db)) {
					header('Location: user.php');
				}
			}
		}
	
	} else {
		header('Location: index.php');
	}
	
?>

<!DOCTYPE html>
<html>
<head>
	<title>Proposer un trajet</title>
	<meta charset="utf-8" />
	<script src="http://maps.google.com/maps/api/js?sensor=false" type="text/javascript"></script>
	<script src="js/carte.js" type="text/javascript"></script>
	<link rel="stylesheet" media="screen" href="css/carte.css" type="text/css"/>
</head>

<body onload="chargerCarte();">

	<h1>Proposer un trajet</h1>

	<div id="carte" style="width: 550px; height: 500px;"></div>

	<div id="informations">
		<form action="#" method="post">
			<h4>D&eacute;part</h4>
			<div id="depart">
				<p>Coordonn&eacute;es : ( <span id="latA"></span> , <span id="longA"></span> )</p>
				<p>Adresse<input size="30" onChange="changerPoint(this, 'depart');" type="text" name="adresseA" id="adresseA" value="" /></p>
			</div>
			<h4>Arriv&eacute;e</h4>
			<div id="arrivee">
				<p>Coordonn&eacute;es : ( <span id="latB"></span> , <span id="longB"></span> )</p>
				<p>Adresse<input size="30" onChange="changerPoint(this, 'arrivee');" type="text" name="adresseB" id="adresseB" value="" /></p>
			</div>
			<p><strong>Distance totale : </strong><span id="distanceTotale"></span></p>
			<input type="hidden" name="distanceTotale" id="dT" value="" />
			<p><strong>Temps : </strong><span id="tempsTotal"></span></p>
			<input type="hidden" name="tempsTotal" id="tT" value="" />
			<p><strong>Description</strong>
			<textarea rows="4" cols="40" name="description"></textarea></p>
			<input type="submit" value="Proposer" />
			<input type="hidden" name="action" value="proposer" />
		</form>
	</div>

<?php include('static/footer.html'); ?>
