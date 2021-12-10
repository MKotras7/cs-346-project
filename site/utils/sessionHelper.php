<?php
	session_start();
	
	function redirect($url, $flash_message = NULL) 
	{
		if ($flash_message) {
			$_SESSION["flash"] = $flash_message;
		}
		header("Location: $url");
		die;
	}
?>