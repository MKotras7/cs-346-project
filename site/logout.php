<?php date_default_timezone_set('Etc/UTC'); ?>

<?php
	session_start();
	session_destroy();
?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <title>Logout</title>
        <meta name="viewport" content="width=device-width,initial-scale=1">
        <link rel="stylesheet" href="./styles/snake.css">
    </head>

    <body>
        <?php include("./header.php") ?>
		<div id="wrapper">
			<main class="singleCol">
				<div class="inputForm">
					<h1>Logout</h1>
					<p style="display:flex; justify-content: center;">You have been logged out</p>
				 </div>
			</main>
			<?php include("./footer.php"); ?>
		</div>
    </body>
</html> 