<?php
	include_once 'inc/user.php';
	include_once 'inc/utils.php';

	$err = "";

	if (isset($_POST['action']))
	if (strcmp($_POST['action'], "connect") == 0) {
		array_walk($_POST, "sanitized");

		$db = opendb("sql/app.db");

		if (login($_POST['login'], $_POST['passwd'], $db)) {
			$db = NULL;
			header('Location: user.php');
		}
		else
			$err = "Bad login or password";

		$db = NULL;
	}

	include('static/header.html');
	include('inc/menu.php');
	prerr($err);
?>

<div id="header">
   <h1> Welcome </h1>
</div>
	<div class="login_box">
		<h2> Connexion </h2>
			<form action="#" method="post">
				<ul>
					<li> Login: <input type="text" name="login" /> </li>
					<li> Password: <input type="password" name="passwd" /> </li>
				</ul>
				<input type="submit" value="Connect" />
				<input type="hidden" name="action" value="connect" />
			</form>
			<p> No account? Feel free to <a href="register.php">register</a>! </p>
	</div>

<?php include ('static/footer.html'); ?>
