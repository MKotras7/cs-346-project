<?php date_default_timezone_set('Etc/UTC'); ?>

<?php
	include_once("./utils/sessionHelper.php");
	include_once("./utils/userHelper.php");
?>


<link rel="stylesheet" href="./styles/header.css">
<link rel="stylesheet" href="./styles/snake.css">
<script src="./scripts/moment.js"></script>
<script src="./scripts/header.js" defer></script>
<header>
    <a href="./"><img src="./icon.png" alt="logo"/></a>
    <h1 id="titleText">🐍 Snake Game</h1>
    <div style="flex-grow: 1; display: flex; flex-direction: row; justify-content: space-between; padding: 0 30px; align-items: center;">
        <nav>
            <div>
				<?php if($sessionHelper["loggedIn"]) { ?>
					<p> Welcome, <?= getUserById($_SESSION["name"])->username ?></p>
				<?php } ?>
				<p>The current time is <span id="dateDisplay"><?=time()?></span> </p>
			</div>
			
			
			<!--
			<p>The current time is <span id="asd"><?=(new DateTime())->format("m-d-Y h:i:s a")?></span> </p>
			-->
			
			<span id="headerButton">
				<a class="anchorButton" href="./gameBrowser.php">Play</a>
				<?php if($sessionHelper["loggedIn"]) { ?>
					<a class="anchorButton" href="./logout.php">Logout</a>
					<a class="anchorButton" href="./changePicture.php">Customize</a>
				<?php } else { ?>
					<a class="anchorButton" href="./login.php">Login</a>
					<a class="anchorButton" href="./register.php">Register</a> 
				<?php } ?>
			</span>
			<a id="moreButton" class="anchorButton"> More </a>
            
        </nav>
    </div>
</header>