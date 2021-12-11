<?php
	session_start();
	$sessionHelper = [];
	$sessionHelper["loggedIn"] = isset($_SESSION["name"]);
	
	function redirect($url, $flash_message = NULL) 
	{
		if ($flash_message) {
			$_SESSION["flash"] = $flash_message;
		}
		header("Location: $url");
		die;
	}
?>