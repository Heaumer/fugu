<?php
	session_start();

	function userexists($name, $email, &$db) {
		$stmt = $db->prepare(
			"SELECT * FROM user
				WHERE
					name	= :name
				OR	email	= :email");

		$stmt->execute(array(':name' => $name,
			':email' => $email));

		$r = $stmt->fetch();
		return empty($r);
	}

	function checkuser($name, $passwd, &$db) {
		$stmt = $db->prepare(
			"SELECT * FROM user
				WHERE
					name	= :name
				AND	passwd	= :passwd");

		$stmt->execute(array(':name' => $name,
			':passwd' => hash('sha512', $passwd)));

		$r = $stmt->fetch();

		return !empty($r);
	}

	function login($name, $passwd, &$db) {
		if (!checkuser ($name, $passwd, $db))
			return false;

		$_SESSION['connected'] = true;
		$_SESSION['user'] = $name;
		return true;
	}

	function logout() {
		$_SESSION['connected'] = false;
		
		// Détruit toutes les variables de session
		$_SESSION = array();

		// Si vous voulez détruire complètement la session, effacez également
		// le cookie de session.
		// Note : cela détruira la session et pas seulement les données de session !
		if (ini_get("session.use_cookies")) {
    		$params = session_get_cookie_params();
    		setcookie(session_name(), '', time() - 42000,
        		$params["path"], $params["domain"],
        		$params["secure"], $params["httponly"]
    		);
		}
		session_destroy ();
	}

	function register($name, $email, $passwd, &$db) {
		if (checkuser($name, $email, $db))
			return false;

		$stmt = $db->prepare(
			"INSERT INTO user (name, email, passwd)
				VALUES (:name, :email, :passwd)");

		$stmt->execute(array(':name' => $name,
			':email' => $email,
			':passwd' => hash('sha512', $passwd)));

		/* assume INSERT worked ;-) */
		return true;
	}

	function getdriver($name, &$db) {
		$stmt = $db->prepare(
			"SELECT * FROM route
				WHERE
					driver = :name");

		$stmt->execute(array(':name' => $name));

		return $stmt->fetchAll();
	}

	function getpassenger($name, &$db) {
		$stmt = $db->prepare(
			"SELECT * FROM passenger
				WHERE
					iduser = :name");

		$stmt->execute(array(':name' => $name));

		return $stmt->fetchAll();
	}
?>
