<?php
	include_once("./utils/sessionHelper.php");
?> 
<h1 style="text-align: center; margin: 0 15px;"><?=$game->name ?> </h1> 
<?php
	$curTime = time();
	if( time() < strtotime($game->startDate) )
	{
		include("pregame.php");
	}
	else
	{
		include("curGame.php");
	}
?>


