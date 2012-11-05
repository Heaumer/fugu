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
				WHERE idroute = :id");

		$stmt->execute(array(':id' => $id));

		/* delete passenger for this route too */
		$stmt = $db->prepare(
			"DELETE FROM passenger
				WHERE idroute = :id");

		$stmt->execute(array(':id' => $id));
	}

?>
