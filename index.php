<?php
	include_once 'inc/user.php';

	$db = NULL;
	try {
		/* be sure BOTH .db file and sql directory have rw perm */
		$db = new PDO('sqlite:sql/app.db');

/*    	$db->setAttribute(PDO::ATTR_ERRMODE,
    				PDO::ERRMODE_EXCEPTION); */
	}
	catch(PDOException $e) {
		echo 'cannot load db';
	}

	if (isset($_POST['action']))
	if (strcmp($_POST['action'], "connect") == 0) {
		if (login(trim ($_POST['login']), $_POST['passwd'], $db)) {
			header('Location: user.php');
		}
		else {
			header('Location: index.php');
		}
	}
	include('static/header.html');
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
