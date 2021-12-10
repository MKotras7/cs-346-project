<?php
    include_once "./utils/sessionHelper.php";
    include_once "./utils/gameHelper.php";
	if($_SERVER['REQUEST_METHOD'] != 'GET')
	{
		die();
	}
	
	$games = getAllGames();
	//print_r($games);
	
	foreach($games as $game)
	{
		echo $game->publicID;
		echo "    ";
		echo $game->id;
		echo "    ";
	}
	
	
	
	
	/*
	if(empty($_GET["gameId"]))
	{
		echo "GAME NOT FOUND";
	}
	else
	{
		
		echo "GAME FOUND";
	}
	*/
?>

<!--
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <title>Login</title>
        <meta name="viewport" content="width=device-width,initial-scale=1">
        <link rel="stylesheet" href="/styles/snake.css">
    </head>

    <body>
        <?php include("./header.php") ?>
        <main>
            <h1 style="text-align: center; margin: 0 15px;">This game's title</h1>
          
        </main>
    </body>
</html> 
-->
