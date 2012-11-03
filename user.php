<?php
	include_once 'inc/user.php';

	if (isset($_SESSION['connected'])) {
	
		if ($_SESSION['connected'] == false) {
			header('Location: index.php');
			
		} else {

			if (isset($_POST['action']))
			if (strcmp($_POST['action'], "disconnect") == 0) {
				logout();
				header('Location: index.php');
			}

			include('static/header.html');	
		}
	} else {
		header('Location: index.php');
	}
	
?>
	<h1> connected! </h1>
	<form action="#" method="post">
		<input type="submit" value="disconnect" />
		<input type="hidden" name="action" value="disconnect" />
	</form>
<?php include ('static/footer.html'); ?>
