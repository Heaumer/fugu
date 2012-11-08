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
		
	function print_header_table($text, $array) {
		echo '<table>';
		echo '<caption>' . $text . '</caption>';

		echo '<thead><tr>';
		foreach ($array as $a)
			echo '<th>' . $a . '</th>';
		echo '</tr></thead>';
	}
	
	function print_table($routes, $array, $action) {
		echo '<tbody>';
		foreach ($routes as $r) {
			echo '<tr>';
			prroute($array, $r);
			echo '<td>';
			echo '<form action="#" method="post">';
				echo '<input type="submit" value="' . $action . '"/>';
				echo '<input type="hidden" name="action" value="' . $action .  'route" />';
				echo '<input type="hidden" name="idRoute" value="'.$r['id'].'" />';
			echo '</form>';
			echo '</td>';
			echo '</tr>';
		}
		echo '</tbody>';
		echo '</table>';
	}
	
	function prroute($arr, $r) {
		foreach($arr as $a)
			echo '<td>'.$r[$a].'</td>';
	}
	
	function print_filtered_routes($routes) {
		if (count($routes) == 0)
			return;

		print_header_table("Results", array('Driver', 'From', 'To', 'Duration', 'Distance', 'Description', 'Actions'));
		print_table($routes, array('driver', 'startpoint', 'endpoint', 'time', 'distance', 'description'), "join");
	}
	
	function prroutes($routes) {
		if (count($routes) == 0)
			return;

		print_header_table("Driver for", array('From', 'To', 'Duration', 'Distance', 'Description', 'Actions'));
		print_table($routes, array('startpoint', 'endpoint', 'time', 'distance', 'description'), "delete");
	}

	function prpassenger($r, &$db) {
		$stmt = $db->prepare(
			"SELECT * FROM route
				WHERE
					id = :idroute");

		$stmt->execute(array(':idroute' => $r['idroute']));

		$arr = $stmt->fetch();
		echo '<tr>';
		prroute(array('driver', 'startpoint', 'endpoint', 'time', 'distance', 'description'), $arr);
		echo '<td>';
		echo '<form action="#" method="post">';
			echo '<input type="submit" value="delete" />';
			echo '<input type="hidden" name="action" value="deletepass" />';
			echo '<input type="hidden" name="idRoute" value="'.$r['idroute'].'" />';
		echo '</form>';
		echo '</td>';
		echo '</tr>';
	}

	function prpassengers($routes, &$db) {
		if (count($routes) == 0)
			return;
		
		print_header_table("Passenger for", array('Driver', 'From', 'To', 'Duration', 'Distance', 'Description', 'Actions'));

		echo '<tbody>';
		foreach($routes as $r)
			prpassenger($r, $db);
		echo '</tbody>';
		
		echo '</table>';
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
