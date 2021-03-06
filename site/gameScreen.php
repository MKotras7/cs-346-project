<?php date_default_timezone_set('Etc/UTC'); ?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <title>Game View</title>
        <meta name="viewport" content="width=device-width,initial-scale=1">
        <link rel="stylesheet" href="./styles/snake.css">
    </head>
    <body>
		<?php include("./header.php") ?>
		<div id="wrapper">
			<main>
			<?php
				include_once "./utils/gameHelper.php";
				if($_SERVER['REQUEST_METHOD'] != 'GET')
				{
					die();
				}
				include_once("./utils/gameHelper.php");
				$game = getGameInfoFromPublicID($_GET["gameId"]);
				if(empty($_GET["gameId"]) or strlen($game->id == null))
				{
					include("gameScreen/gameNotFound.php");
				}
				else
				{
					include("gameScreen/actualGame.php");
				}
			?>
			</main>
			<?php include("./footer.php"); ?>
		</div>
    </body>
</html> 