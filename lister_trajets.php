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
			if (compare_token_with($_POST['token'])) {
				// No XSRF attack, can continue
				$secure = true;
				$token = generate_token();
				$db = opendb("sql/app.db");
				
			} else {
				$err = "XSRF attack"; 
			}
		} else {
			$err = "XSRF attack";
		}
	} else {
		$err = "XSRF attack";
	}
	
	include('static/header.html');	
	include('inc/menu.php');
	
?>

<h1 id="header">Research results</h1>

<?php

	if ($secure) {
	
		if (isset($_POST['action'])) {
	
			if (strcmp($_POST['action'], "chercher") == 0) {
				array_walk($_POST, "sanitized");
		
				// On cherche les trajets intéressants
				$simRoutes = get_similar_routes($_POST['adresseA_hidden'], $_POST['adresseB_hidden'], $_SESSION['user'], $db);
		
				if (count($simRoutes) == 0)
					echo "<h2>No route yet</h2>";
				else {
					print_filtered_routes($simRoutes); // Afficher routes !
				}
				$db = NULL;

			} else if (strcmp($_POST['action'], "joinroute") == 0) {
				array_walk($_POST, "sanitized");
		
				// On rejoint le trajet
				if (join_route($_SESSION['user'], $_POST['idRoute'], $db)) {
					$db = NULL;
					header('Location: user.php?token=' . $token);
				} else {
					$err = "Join failure";
				
				}
			}
		}
	
	}
	
	prerr($err);
	
	include ('static/footer.html'); 
	
?>
