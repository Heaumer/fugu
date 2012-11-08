<?php
	include_once 'inc/user.php';
	include_once 'inc/utils.php';
	include_once 'inc/route.php';

	if (isset($_SESSION['connected']) == false || $_SESSION['connected'] == false)
		header('Location: index.php');

	include('static/header.html');	
	include('inc/menu.php');
?>
	<h1> connected! </h1>
<?php

	$err = "";
	$db = opendb("sql/app.db");

	if (isset($_POST['action'])) {
	if (strcmp($_POST['action'], "deleteroute") == 0) {
			array_walk($_POST, "sanitized");

			if (!deleteroute($_POST['idRoute'], $db))
				$err = "Route not deleted!";
			
	}
	else if (strcmp($_POST['action'], "deletepass") == 0) {
			array_walk($_POST, "sanitized");

			if (!deletepass($_POST['idRoute'], $_SESSION['user'], $db))
				$err = "Route not deleted!";
	}
	}
		
	prerr($err);	

	/* XXX obvious security issue */
	$asdriver = getdriver($_SESSION['user'], $db);
	$aspassenger = getpassenger($_SESSION['user'], $db);

	if (count($asdriver) == 0 && count($aspassenger) == 0)
		echo '<h2> No route yet </h2>';
	else {
		prroutes($asdriver);
		/* need db to retrieve route from passenger table */
		prpassengers($aspassenger, $db);
	}
?>

<?php include ('static/footer.html'); ?>
