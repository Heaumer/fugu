<?php

	function register_route($user, $depart, $arrivee, $temps,
		$distance, $description, &$db) {
	
		/* Assume different routes */
		$statement = $db->prepare(
			"INSERT INTO route
				(description, time, distance, driver, startpoint, endpoint)
				VALUES (:description, :time, :distance, :driver, :startPoint, :endPoint)");

		$r = $statement->execute(
			array(':description' => $description,
				':time' => $temps,
				':distance' => $distance,
				':driver' => $user,
				':startPoint' => $depart,
				':endPoint' => $arrivee));

		return $r;
	}

	function deleteroute($id, &$db) {
		$stmt = $db->prepare(
			"DELETE FROM route
				WHERE id = :id");

		if ($stmt->execute(array(':id' => $id)) == false)
			return false;

		/* delete passenger for this route too */
		$stmt = $db->prepare(
			"DELETE FROM passenger
				WHERE idroute = :id");

		return $stmt->execute(array(':id' => $id));
	}

	function deletepass($id, $user, &$db) {
		$stmt = $db->prepare(
			"DELETE FROM passenger
				WHERE	idroute = :idroute
					AND	iduser = :iduser");

		return $stmt->execute(array(':idroute' => $id, ':iduser' => $user));
	}

	function searchroute($from, $to, &$db) {
		$stmt = $db->prepare(
			"SELECT * FROM route
				WHERE	from = :from
					AND	to = :to");

		if ($stmt->execute(array(':from' => $from, ':to' => $to)) == false)
			return array();

		$a = $stmt->fetchAll();

		return $a;
	}
?>
