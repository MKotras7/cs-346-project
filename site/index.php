<!DOCTYPE html>
<?php
	date_default_timezone_set('Etc/UTC');
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
				<h1 class="centeredHeader">Welcome to the Snake Game website! </h1>
				<img style="float: left; width: 50%; margin-right: 30px;" src="./images/clip.gif" alt="A animated clip of the game being played" />
				<ul>	
					<li>
						You don't need to give us any information to start playing, simply <a href="guestAccount.php">get a guest account!</a>
						<ul>
							<li>A guest account is limited to strictly playing games.</li>
						</ul>
					</li>
					<li>You can register a new account to access advanced features such as:
						<ul>
							<li>Customizing your snake.</li>
							<li>Hosting your own games.</li>
						</ul>
					</li>
				</ul>
			</main>
			<?php include("./footer.php"); ?>
		</div>
    </body>
</html> 