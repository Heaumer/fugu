<?php

	include_once 'inc/user.php';
	include_once 'inc/utils.php';
	include_once 'inc/route.php';

	$err = "";

	if (isset($_SESSION['connected']) == false || $_SESSION['connected'] == false)
		header('Location: index.php');
	
	include('static/header.html');	
	include('inc/menu.php');
		
?>

<h1 id="header">R&eacute;sultats de la recherche</h1>

<?php

	if (isset($_POST['action']))
	if (strcmp($_POST['action'], "chercher") == 0) {
		array_walk($_POST, "sanitized");
		
		$db = opendb("sql/app.db");
		
		// On cherche les trajets intéressants
		$simRoutes = get_similar_routes($_POST['adresseA_hidden'], $_POST['adresseB_hidden'], $_SESSION['user'], $db);
		
		if (count($simRoutes) == 0)
			echo '<h2> No route yet </h2>';
		else {
			// Afficher routes !
			print_filtered_routes($simRoutes);
		}
		
		$db = NULL;

	} else if (strcmp($_POST['action'], "joinroute") == 0) {
		array_walk($_POST, "sanitized");
		
		$db = opendb("sql/app.db");
		
		// On rejoint le trajet
		join_route($_SESSION['user'], $_POST['idRoute'], $db);
		
		$db = NULL;
		
		header('Location: user.php');
				
	}
		
?>

<?php include ('static/footer.html'); ?>
