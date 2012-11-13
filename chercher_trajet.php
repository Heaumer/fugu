<?php

	include_once 'inc/user.php';
	include_once 'inc/utils.php';
	include_once 'inc/xsrf.php';

	if (isset($_SESSION['connected']) == false || $_SESSION['connected'] == false)
		header('Location: index.php');
	
	$secure = false;
	
	if (isset($_SESSION['token']) && isset($_GET['token'])) {	
		if (compare_token_with($_GET['token'])) {
			// No XSRF attack, can continue
			$secure = true;
			$token = generate_token();
		}
	}
	
	include('static/header_chercher_trajet.html');
	include('inc/menu.php');
	
	if ($secure) {
	
?>

	<div id="header">
		<h1>Search a route</h1>
	</div>

	<div id="carte" style="width: 550px; height: 500px;"></div>

	<div id="informations">
		<form action="lister_trajets.php" method="post">
			<h3>Departure</h3>
			<div id="depart">
				<p>Coordinates : ( <span id="latA"></span> , <span id="longA"></span> )</p>
				<p>Address<input size="40" onChange="changerPoint(this, 'depart');" type="text" name="adresseA" id="adresseA" value="" /></p>
			</div>
			<input type="hidden" name="adresseA_hidden" id="adresseA_hidden" value="" />
			<h3>Arrival</h3>
			<div id="arrivee">
				<p>Coordinates : ( <span id="latB"></span> , <span id="longB"></span> )</p>
				<p>Address<input size="40" onChange="changerPoint(this, 'arrivee');" type="text" name="adresseB" id="adresseB" value="" /></p>
			</div>
			<input type="hidden" name="adresseB_hidden" id="adresseB_hidden" value="" />
			<p><strong>Total distance : </strong><span id="distanceTotale"></span></p>
			<p><strong>Duration : </strong><span id="tempsTotal"></span></p>
			<input type="button" value="Search" name="search_button" onclick="this.form.submit();">
			<input type="hidden" name="action" value="chercher" />
			<input type="hidden" name="token" value="<?php echo $token; ?>" />
		</form>
	</div>

<?php 

	}

	include('static/footer.html'); 
	
?>
