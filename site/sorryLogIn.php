<?php date_default_timezone_set('Etc/UTC'); ?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <title>Error</title>
        <meta name="viewport" content="width=device-width,initial-scale=1">
        <link rel="stylesheet" href="./styles/snake.css">
    </head>

    <body>
        <?php include("./header.php") ?>
		<div id="wrapper">
			<main class="singleCol">
				<div class="inputForm">
					<h1>Error</h1>
					<p style="display:flex; justify-content: center;">Sorry, please log in to use this feature.</p>
					<a href="login.php">Log in</a>
				 </div>
			</main>
			<?php include("./footer.php"); ?>
		</div>
    </body>
</html> 