<?php

	include_once 'inc/user.php';
	include_once 'inc/utils.php';
	include_once 'inc/xsrf.php';

	$err = "";

	if (isset($_POST['action'])) {
		if (strcmp($_POST['action'], "connect") == 0) {
		
			// Here with token in POST
			if (isset($_SESSION['token']) && isset($_POST['token'])) {
				array_walk($_POST, "sanitized");

				if (compare_token_with($_POST['token'])) {
					// No XSRF attack, can continue
					$token = generate_token();
					$db = opendb("sql/app.db");

					if (login($_POST['login'], $_POST['passwd'], $db)) {
						$db = NULL;
						header('Location: user.php?token=' . $token);
					}
					else
						$err = "Bad login or password";

					$db = NULL;			
				} else {
					$err = "XSRF attack";
				}
				
			} else {
				$err = "XSRF attack";
			}
		} 
	
	} else {
		$token = generate_token();
	}

	include('static/header.html');
	include('inc/menu.php');
	prerr($err);
?>

<div id="header">
   <h1>Find Your Guest Unisonously (FUGU!)</h1>
</div>
	<div class="login_box">
		<h2> Connection </h2>
			<form action="#" method="post">
				<ul>
					<li> Login: <input type="text" name="login" /> </li>
					<li> Password: <input type="password" name="passwd" /> </li>
				</ul>
				<input type="submit" value="Connect" />
				<input type="hidden" name="action" value="connect" />
				<input type="hidden" name="token" value="<?php echo $token; ?>" />
			</form>
			<p> No account? Feel free to <a href="register.php">register</a>! </p>
	</div>

<?php include ('static/footer.html'); ?>
