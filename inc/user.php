<?php
	session_start();

	function checkuser($name, $passwd, &$db) {
		$stmt = $db->prepare(
			"SELECT * FROM user
				WHERE
					name	= :name
				AND	passwd	= :passwd");

		$stmt->execute(array(':name' => $name,
			':passwd' => $passwd));

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
		session_destroy ();
	}
?>
