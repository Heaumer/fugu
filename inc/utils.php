<?php
	function bademail($email) {
		$tmp = "";
		if (!ereg ("^[^@]{1,64}@[^@]{1,255}$", $email))
			return true;
		$tmp = explode ("@", $email);
		if (ereg ("^[^.]+$", $tmp[1]))
			return true;
		return false;
	}

	function prroute($r) {
		echo '<p>';
		echo $r['startpoint'].' to '.$r['endpoint'];
		echo '<br />';
		echo $r['description'];
		echo '</p>';
	}

	function prpass($r, &$db) {
		$stmt = $db->prepare(
			"SELECT * FROM route
				WHERE
					id = :idroute");

		$stmt->execute(array(':idroute' => $r['idroute']));

		$arr = $stmt->fetch();
		prroute($arr);
	}

	/*
	 * be sure webserver have rw perm for
	 * both .db file and its parent directory
	 */
	function opendb($file) {
		$db = NULL;

		try {
			$db = new PDO('sqlite:'.$file);
		}
		catch(PDOException $e) {
			echo 'Internal error: cannot load db';
			exit;
		}

		return $db;
	}

	function prerr(&$err) {
		if (strlen($err) > 0) {
			echo '<p><b> An error has occured: '.$err.'</b></p>';
			$err = "";
		}
	}

	function sanitized(&$val, $key) {
		$val = htmlspecialchars($val, ENT_QUOTES);
	}
?>
