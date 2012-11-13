<?php
	include_once 'inc/user.php';
	include_once 'inc/utils.php';
	include_once 'inc/route.php';
	include_once 'inc/xsrf.php';

	if (isset($_SESSION['connected']) == false || $_SESSION['connected'] == false)
		header('Location: index.php');

	$secure = false;
	$err = "";

	if (isset($_POST['action'])) {
	
		// Here with token in POST
		if (isset($_SESSION['token']) && isset($_POST['token'])) {	
			array_walk($_POST, "sanitized");
			
			if (compare_token_with($_POST['token'])) {
				// No XSRF attack, can continue
				$secure = true;
				$token = generate_token();	
				$db = opendb("sql/app.db");
				
				if (strcmp($_POST['action'], "deleteroute") == 0) {

					if (!deleteroute($_POST['idRoute'], $db))
						$err = "Route not deleted!";
				
				} else if (strcmp($_POST['action'], "deletepass") == 0) {
					
					if (!deletepass($_POST['idRoute'], $_SESSION['user'], $db))
						$err = "Route not deleted!";
				}
			
			} else {
				$err = "XSRF attack";
			}
		} else {
			$err = "XSRF attack";
		}
		
	} else { // No action
	
		if (isset($_SESSION['token']) && isset($_GET['token'])) {
			if (compare_token_with($_GET['token'])) {
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
	}
	
	include('static/header.html');	
	include('inc/menu.php');

?>
	
	<h1 id="header">Dashboard</h1>
	
<?php
	
	prerr($err);	

	if ($secure) {	
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
	}
?>

<?php include ('static/footer.html'); ?>
