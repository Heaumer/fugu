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
?>
