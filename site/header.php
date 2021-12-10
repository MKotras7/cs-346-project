<?php
	include_once("./utils/sessionHelper.php");
	$loggedIn = isset($_SESSION["name"]);
?>


<link rel="stylesheet" href="/styles/header.css">
<link rel="stylesheet" href="/styles/snake.css">
<header>
    <a href="./"><img src="./icon.png" alt="logo"/></a>
    <h1>🐍 Snake Game</h1>
    <div style="flex-grow: 1; display: flex; flex-direction: row; justify-content: space-between; padding: 0 30px; align-items: center;">
        <nav>
            <a class="anchorButton" href="./gameBrowser.php">Play</a>
			<p>The current time is <?=(new DateTime())->format("m-d-Y h:i:s a")?> </p>
			<span>
			<?php if($loggedIn) { ?>
				<a class="anchorButton" href="./logout.php">Logout</a>
			<?php } else { ?>
				<a class="anchorButton" href="./login.php">Login</a>
				<a class="anchorButton" href="./register.php">Register</a> 
			<?php } ?>
			</span>
            
        </nav>
    </div>
</header>