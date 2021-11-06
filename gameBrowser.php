<?php
    function makeGameListing($name, $curPlayers, $maxPlayers, $startDate, $lastText)
    {
        ?>
            <li>
                <div class="gameDisplay">
                    <div>
                        <p><?=$name?></p>
                        <p><?=$curPlayers?>/<?=$maxPlayers?> players</p>
                        <p><?=$lastText?> <?=$startDate?> </p>
                    </div>
                    <a href="./gameScreen.php?gameId='123123'" class="anchorButton">View</a>    
                </div>
                
            </li>
        <?php
    }

    function makeCurrentGame($name, $curPlayers, $maxPlayers, $startDate)
    {
        makeGameListing($name, $curPlayers, $maxPlayers, $startDate, "Since: ");
    }
    
    function makeUpcomingGameListing($name, $curPlayers, $maxPlayers, $startDate)
    {
        makeGameListing($name, $curPlayers, $maxPlayers, $startDate, "Starts on: ");

    }
?>


<!DOCTYPE html>
<html lang="en">
    <meta charset="UTF-8">
    <title>Main Menu</title>
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <link rel="stylesheet" href="snake.css">
    <?php include("./header.php") ?>
    <body>
        <main>
            <h1 class="centeredHeader"> Browse Games </h1>
            <h2> Current Games </h2>
            <ul class="gameList">
                <?=makeCurrentGame("Gumby's Game", 5, 20, "10/20/2005")?>
                <?=makeCurrentGame("Trundler's Fun House", 20, 20, "10/20/2005")?>
                <?=makeCurrentGame("Ronaldo's Battleground", 20, 20, "10/20/2005")?>
                <?=makeCurrentGame("Justin's Game", 5, 5, "15/10/2005")?>
                <?=makeCurrentGame("Andre's Game", 5, 20, "10/20/2005")?>
            </ul>
            <h2> Upcoming Games </h2>
            <ul class="gameList">
                <?=makeUpcomingGameListing("Andre's Game", 5, 20, "10/20/2052")?>
            </ul>
            <a href="./createGame.php" class="anchorButton">Create Game</a>
            </main>
        <footer>

        </footer>
    </body>
</html> 