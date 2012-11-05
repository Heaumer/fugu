<?php
	include_once 'inc/user.php';
	include_once 'inc/utils.php';

	if (isset($_SESSION['connected']) == false || $_SESSION['connected'] == false)
		header('Location: index.php');

	include('static/header.html');	
	include('inc/menu.php');
?>
	<h1> connected! </h1>
<?php

	$db = opendb("sql/app.db");

	/* XXX obvious security issue */
	$asdriver = getdriver($_SESSION['user'], $db);
	$aspassenger = getpassenger($_SESSION['user'], $db);

	if (count($asdriver) == 0 && count($aspassenger) == 0)
		echo '<h2> No route yet </h2>';
	else {
		if (count($asdriver) > 0) {
			echo '<h2> Driver for </h2>';
			foreach ($asdriver as $route)
				prroute($route);
		}
		if (count($aspassenger) > 0) {
			echo '<h2> Passenger for </h2>';
			foreach ($aspassenger as $route)
				prpass($route, $db);
		}
	}
?>

<?php include ('static/footer.html'); ?>
