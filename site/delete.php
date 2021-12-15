<!DOCTYPE html>
<?php
	date_default_timezone_set('Etc/UTC');
?>
<?php
	include_once("./utils/sessionHelper.php");
	include_once("./utils/gameHelper.php");
	$success = false;
	if($sessionHelper["loggedIn"])
	{
		if(array_key_exists("gameID", $_GET))
		{
			$game = getGameInfoFromPublicID($_GET["gameID"]);
			if(isset($game))
			{
				if($game->hostID == $_SESSION["name"])
				{
					$db = db_connect();
					$query = "DELETE FROM game WHERE id=?";
					$statement = $db->prepare($query);
					$statement->execute([$game->id]);
					$success = true;
				}
				else
				{
				redirect("sorryNoPermissions.php");
				}
			}
			else
			{
				redirect("sorryError.php");
			}
		}
		else
		{
			redirect("sorryError.php");
		}
	}
	else
	{
		redirect("sorryLogIn.php");
	}
?>

<html lang="en">
    <head>
        <meta charset="UTF-8">
        <title>Main Menu</title>
        <meta name="viewport" content="width=device-width,initial-scale=1">
        <link rel="stylesheet" href="./styles/snake.css">
    </head>

    <body>
        <?php include("./header.php") ?>
		<div id="wrapper">
			<main>
				<?php if($success)
				{
					?> <h1> Game successfully deleted </h1> <?php
				}
				?>
			</main>
			<?php include("./footer.php"); ?>
		</div>
    </body>
</html> 