<?php
	include_once 'inc/user.php';
	include_once 'inc/xsrf.php';

	// Here with token in GET
	if (isset($_SESSION['token']) && isset($_GET['token'])) {
		if (compare_token_with($_GET['token'])) {
			// No XSRF attack, can continue
			$token = generate_token();

			logout();
			header('Location: index.php');
		} else {
			echo "XSRF attack";
		}
	} else {
		echo "XSRF attack";
	} 
?>
