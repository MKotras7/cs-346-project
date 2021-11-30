<link rel="stylesheet" href="/styles/header.css">
<link rel="stylesheet" href="/styles/snake.css">
<header>
    <a href="./"><img src="./icon.png" alt="logo"/></a>
    <h1>🐍 Snake Game</h1>
    <div style="flex-grow: 1; display: flex; flex-direction: row; justify-content: space-between; padding: 0 30px; align-items: center;">
        <nav>
            <a class="anchorButton" href="./gameBrowser.php">Play</a>
            
            <?="You loaded this page at: " . date('Y-m-d h:i:s', time())?>
            <span>
                <a class="anchorButton" href="./login.php">Login</a>
                <a class="anchorButton" href="./register.php">Register</a> 
            </span>
        </nav>
    </div>
</header>