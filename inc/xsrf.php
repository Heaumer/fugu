<?php

function generate_token() {
	$token = sha1(uniqid());
	$_SESSION['token'] = $token;
	return $token;
}

function compare_token_with($token) {
	if ($_SESSION['token'] === $token) 
		return true;		
	return false;
}

?>
