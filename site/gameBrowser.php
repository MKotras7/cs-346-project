<?php
	require_once "utils/dbConnect.php";
	$db = db_connect();
	$result = $db->query("SELECT name, maxPlayers, startDate, publicID FROM game");
	
	$currentGames = [];
	$upcomingGames = [];
	$curTime = time();
	echo $curTime;
	foreach($result as $q)
	{
		echo "____";
		echo strtotime($q["startDate"]);
		if($curTime > strtotime($q["startDate"]))
		{
			array_push($currentGames, $q);
		}
		else
		{
			array_push($upcomingGames, $q);
		}
	}

    function makeGameListing($name, $curPlayers, $maxPlayers, $startDate, $publicID, $lastText)
    {
        ?>
            <li>
                <div class="gameDisplay">
                    <div>
                        <p><?=$name?></p>
                        <p><?=$curPlayers?>/<?=$maxPlayers?> players</p>
                        <p><?=$lastText?> <?=$startDate?> </p>
                    </div>
                    <a href="./gameScreen.php?gameId='<?=$publicID?>'" class="anchorButton">View</a>    
                </div>
                
            </li>
        <?php
    }

    function makeCurrentGame($name, $curPlayers, $maxPlayers, $startDate, $publicID)
    {
        makeGameListing($name, $curPlayers, $maxPlayers, $startDate, $publicID, "Since: ");
    }
    
    function makeUpcomingGameListing($name, $curPlayers, $maxPlayers, $startDate, $publicID)
    {
        makeGameListing($name, $curPlayers, $maxPlayers, $startDate, $publicID, "Starts on: ");
    }
?>


<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <title>Main Menu</title>
        <meta name="viewport" content="width=device-width,initial-scale=1">
        <link rel="stylesheet" href="/styles/snake.css">
        <link rel="stylesheet" href="/styles/gameList.css">
    </head>

    <body>
        <?php include("./header.php") ?>
        <main>
            <h1 class="centeredHeader"> Browse Games </h1>
            <h2> Current Games </h2>
            <ul class="gameList">
				<?php
					foreach($currentGames as $game)
					{
						$dateTime = new DateTime($game["startDate"]);
						makeCurrentGame($game["name"], 0, $game["maxPlayers"], $dateTime->format('m-d-Y h:i:s a'), $game["publicID"]);
					}
				?>
            </ul>
            <h2> Upcoming Games </h2>
            <ul class="gameList">
				<?php
					foreach($upcomingGames as $game)
					{
						$dateTime = new DateTime($game["startDate"]);
						makeUpcomingGameListing($game["name"], 0, $game["maxPlayers"], $dateTime->format('Y/m/d'), $game["publicID"]);
					}
				?>
				<?php /*
					<?=makeUpcomingGameListing("Andre's Game", 5, 20, "10/20/2052")?>
				*/ ?>
			</ul>
            <a href="./createGame.php" class="anchorButton">Create Game</a>
            </main>
    </body>
</html> 