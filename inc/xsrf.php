<?php

function generate_token() {
	$bytes = openssl_random_pseudo_bytes(15);
	$token = bin2hex($bytes);
	//$token = sha1(uniqid());
	$_SESSION['token'] = $token;
	return $token;
}

function compare_token_with($token) {
	if (!preg_match('/[a-f0-9]+/i', $token))
		return false;

	return ($_SESSION['token'] === $token) 
}

?>
