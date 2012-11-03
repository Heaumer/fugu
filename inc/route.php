<?php

	session_start();

	function enregistrer_trajet($user, $depart, $arrivee, $temps, $distance, $description, $db) {
	
		/* Assume different routes */
		
		$statement = $db->prepare(
			"INSERT INTO route (description, time, distance, driver, startpoint, endpoint)
				VALUES (:description, :time, :distance, :driver, :startPoint, :endPoint)");
				
		$statement->execute(array(':description' => $description,
			':time' => $temps,
			':distance' => $distance,
			':driver' => $user,
			':startPoint' => $depart,
			':endPoint' => $arrivee));
			
		/* assume INSERT worked ;-) */
		return true;
	}

?>
