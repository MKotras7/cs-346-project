<?php date_default_timezone_set('Etc/UTC'); ?>

<style>
	h1 {
		text-align: center;
	}
</style>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <title>Join Game</title>
        <meta name="viewport" content="width=device-width,initial-scale=1">
        <link rel="stylesheet" href="./styles/snake.css">
    </head>
    <body>
        <?php include("./header.php") ?>
		<div id="wrapper">
			<main>
				<?php
					include_once("./utils/sessionHelper.php");
					include_once "./utils/gameHelper.php";
					if(!$sessionHelper["loggedIn"])
					{
						redirect("sorryLogIn.php");
					}
					if($_SERVER['REQUEST_METHOD'] != 'GET')
					{
						die();
					}
					else
					{
						$game = getGameInfoFromPublicID($_GET["gameId"]);
						if(empty($_GET["gameId"]) or strlen($game->id == null))
						{
							include("gameScreen/gameNotFound.php");
						}
						else
						{
							$success = registerUserToGame($_SESSION["name"], $game->id);
							if($success)
							{
								?> <h1> Successfully joined game <h2> <?php
							}
							else
							{
								?> <h1> Sorry, couldn't get you into the game <h2> <?php
							}
						}
					}
				?>
			</main>
			<?php include("./footer.php"); ?>
		</div>
    </body>
</html> 