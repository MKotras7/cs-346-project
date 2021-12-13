<?php
	$salt = "kcbLvP8t";
	function workaroundPasswordhash($password)
	{
		global $salt;
		return hash("sha512", $salt . $password);
	}
?>