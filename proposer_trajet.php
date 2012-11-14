<?php

	include_once 'inc/user.php';
	include_once 'inc/utils.php';
	include_once 'inc/route.php';
	include_once 'inc/xsrf.php';

	$secure = false;
	$err = "";

	if (isset($_SESSION['connected']) == false || $_SESSION['connected'] == false)
		header('Location: index.php');

	if (isset($_POST['action'])) {
	
		// Here with token in POST
		if (isset($_SESSION['token']) && isset($_POST['token'])) {	
			array_walk($_POST, "sanitized");
		
			if (compare_token_with($_POST['token'])) {
				// No XSRF attack, can continue
				$secure = true;
				$token = generate_token();
				
				if (strcmp($_POST['action'], "proposer") == 0) {
					$db = opendb("sql/app.db");

					if (register_route($_SESSION['user'], $_POST['adresseA'],
										$_POST['adresseB'],
										$_POST['distanceTotale'],
										$_POST['tempsTotal'],
										$_POST['description'], $db)) {
						
						$db = NULL;
						header('Location: user.php?token=' . $token);
					} else {
						$err = "Route not registered!";
					}
	
					$db = NULL;
				}	
			
			} else {
				$err = "XSRF attack";
			}
		} else {
			$err = "XSRF attack";
		}
	
	} else { // No action
	
		// Here with token in GET
		if (isset($_SESSION['token']) && isset($_GET['token'])) {
			if (compare_token_with($_GET['token'])) {
				// No XSRF attack, can continue
				$secure = true;
				$token = generate_token();
				
			} else {
				$err = "XSRF attack";
			}
		} else {
			$err = "XSRF attack";
		}
	}	
	
	include('static/header_proposition_trajet.html');
	include('inc/menu.php');
	prerr($err);
	
	if ($secure) {
	
?>
	<div id="header">
		<h1>Propose a route</h1>
	</div>
	
	<div id="carte" style="width: 550px; height: 500px;"></div>

	<div id="informations">
		<form action="#" method="post">
			<h3>Departure</h3>
			<div id="depart">
				<p>Coordinates : ( <span id="latA"></span> , <span id="longA"></span> )</p>
				<p>Address<input size="40" onChange="changerPoint(this, 'depart');" type="text" name="adresseA" id="adresseA" value="" /></p>
			</div>
			<h3>Arrival</h3>
			<div id="arrivee">
				<p>Coordinates : ( <span id="latB"></span> , <span id="longB"></span> )</p>
				<p>Address<input size="40" onChange="changerPoint(this, 'arrivee');" type="text" name="adresseB" id="adresseB" value="" /></p>
			</div>
			<p><strong>Total distance : </strong><span id="distanceTotale"></span></p>
			<input type="hidden" name="distanceTotale" id="dT" value="" />
			<p><strong>Duration : </strong><span id="tempsTotal"></span></p>
			<input type="hidden" name="tempsTotal" id="tT" value="" />
			<p><strong>Description</strong>
			<textarea rows="4" cols="50" name="description"></textarea></p>
			<input type="button" value="Propose" name="submit_button" onclick="this.form.submit();">
			<input type="hidden" name="action" value="proposer" />
			<input type="hidden" name="token" value="<?php echo $token; ?>" />
		</form>
	</div>';
				
<?php

	}

include('static/footer.html'); ?>
