<?php
	include_once 'inc/user.php';
	include_once 'inc/utils.php';

	$err = "";

	$db = NULL;
	try {
		/* be sure BOTH .db file and sql directory have rw perm */
		$db = new PDO('sqlite:sql/app.db');
	}
	catch(PDOException $e) {
		echo 'cannot load db';
		exit;
	}

	if (isset($_POST['action']))
	if (strcmp($_POST['action'], "register") == 0) {
		$login	= htmlspecialchars(trim($_POST['login']), ENT_QUOTES);
		$email	= htmlspecialchars(trim($_POST['email']), ENT_QUOTES);
		$passwd	= htmlspecialchars($_POST['passwd'], ENT_QUOTES);

		if (strlen($login) == 0)
			$err = "please, enter a login";
		else if (strlen($email) == 0 || bademail($email))
			$err = "please enter a valid email";
		else if (strlen($passwd) <= 8)
			$err = "password should be at least 8 characters long";
		else if (register($login, $email, $passwd, $db)) {
			login($login, $passwd, $db);
			header('Location: user.php');
		}
		else
			$err = "Login already taken. try again!";
	}

	include('static/header.html');

	if (strcmp($err, "")) {
		echo '<p><b> An error has occured: '.$err.'</b></p>';
		$err = "";
	}
?>

<div id="header">
   <h1> Registration </h1>
</div>
	<div class="register_box">
		<h2> Register </h2>
			<p> All the following fields are mandatory </p>
			<form action="#" method="post">
				<ul>
					<li> Login: <input type="text" name="login" /> </li>
					<li> Email: <input type="text" name="email" /> </li>
					<li> Password: <input type="password" name="passwd" /> </li>
				</ul>
				<input type="submit" value="Register" />
				<input type="hidden" name="action" value="register" />
			</form>
	</div>

<?php include ('static/footer.html'); ?>
