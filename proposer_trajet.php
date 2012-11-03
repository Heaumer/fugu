<!DOCTYPE html>
<html>
<head>
	<title>Proposer un trajet</title>
	<meta charset="utf-8" />
	<script src="http://maps.google.com/maps/api/js?sensor=false" type="text/javascript"></script>
	<script src="js/carte2.js" type="text/javascript"></script>
	<link rel="stylesheet" media="screen" href="css/carte.css" type="text/css"/>
</head>

<body onload="chargerCarte();">

	<h1>Proposer un trajet</h1>

	<div id="carte" style="width: 550px; height: 500px;"></div>

	<div id="informations">
		<h3>D&eacute;part</h3>
		<div id="depart">
			<p>Coordonn&eacute;es : ( <span id="latA"></span> , <span id="longA"></span> )</p>
			<p>Adresse<input size="30" onChange="changerPoint(this, 'depart');" type="text" id="adresseA" value="" /></p>
		</div>
		<h3>Arriv&eacute;e</h3>
		<div id="arrivee">
			<p>Coordonn&eacute;es : ( <span id="latB"></span> , <span id="longB"></span> )</p>
			<p>Adresse<input size="30" onChange="changerPoint(this, 'arrivee');" type="text" id="adresseB" value="" /></p>
		</div>
		<h3>Distance totale</h3>
		<p><span id="distanceTotale"></span></p>
	</div>

<?php include('static/footer.html'); ?>
