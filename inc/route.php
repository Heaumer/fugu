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
	
	function join_route($passenger, $idRoute, &$db) {
		$statement = $db->prepare(
			"INSERT INTO passenger
				(idroute, iduser)
				VALUES (:idRoute, :passenger)");

		$r = $statement->execute(
			array(':idRoute' => $idRoute,
				':passenger' => $passenger));

		echo $idRoute . $passenger;

		return $r;
	}

	function get_similar_routes($adresseA, $adresseB, $user, &$db) {
		// On sélectionne les trajets avec les mêmes points départ / arrivée
		// Il ne faut pas être le conducteur du trajet
		// On ne sélectionne que les trajets où on n'est pas déjà inscrit
		$stmt = $db->prepare("SELECT * FROM route 
								WHERE 
									startpoint = :addA 
								AND
									endpoint = :addB
								AND
									driver <> :user
								AND
									id NOT IN (SELECT idroute FROM passenger WHERE iduser = :user)");

		$stmt->execute(array(':addA' => $adresseA, ':addB' => $adresseB, ':user' => $user));

		return $stmt->fetchAll();
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
