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
?>
