<?php 
    require_once "utils/rng.php";
    require_once "utils/dbConnect.php";

    $displayPassword = False;
    $seed = microtime(true);
    if(array_key_exists("id", $_GET))
    {
        $curTime = microtime(true);
        if($curTime + 5 > $_GET["id"] and $_GET["id"] > $curTime - 5)
        { // If The timestamp sent in was within 5 seconds of recieving this server.
            $seed = $_GET["id"];
            $displayPassword = True;

            $db = db_connect();
            try {
                $query = "INSERT INTO user (username, password) VALUES (?,?)";
                $stmt = $db->prepare($query);
                $stmt->execute(["Guest1237829276", "superPassword1"]);
                return $db->lastInsertId();
            }
            catch (PDOException $e) 
            {
                db_disconnect();
                exit("Aborting: There was a database error when creating a new user.");
            }
        }
    }
    $rng = new myRng($seed);
    $guestUsername = "Guest" . $rng->getValue();
    function conditionalDisplayPassword()
    {
        global $displayPassword;
        global $rng;
        if($displayPassword)
        {
            ?> <h2> password: <?php 
            $rng->nextRandom();
            echo substr(hash("sha256", $rng->getValue()), 0, 20);
            ?> </h2> <?php
        }
    }

    function getRandomUsername()
    {
        global $guestUsername;
        return $guestUsername;
    }
?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <title>Main Menu</title>
        <meta name="viewport" content="width=device-width,initial-scale=1">
        <link rel="stylesheet" href="/styles/snake.css">
    </head>

    <body>
        <?php include("./header.php") ?>
        <main class="singleCol">
            <form action="./guestAccount.php" class="inputForm" method="GET">
                <input id="id" name="id" value="<?= $seed ?>" hidden/> 
                <h1>Guest Account</h1>
                <h2><?=getRandomusername()?></h2>
                <?=conditionalDisplayPassword()?>
                <div style="display: flex; flex-direction: row;">
                    <a href="./guestAccount.php" class="anchorButton" style="flex-grow: 1; margin-right: 1em;" >New</a>
                    <input class="anchorButton" style="flex-grow: 1;" type="submit" value="Accept"/>
                </div>
                <div class="formExtras" style="display: flex; flex-direction: row; justify-content: space-between;">
                    <a href="./gameBrowser.php">Go Back</a>
                    <a href="./login.php">Login</a>
                </div>
            </form>
            <!--
            <img style="float: left; width: 50%; aspect-ratio: 1;" alt="Animanted gif of a cute snake." src="https://c.tenor.com/onkjRbfOrLEAAAAC/snake-crawling.gif" />
            <p style="margin-left: 10px;">
                🐍 Snake Game is a multiplayer take on the classic game of snake. You can get started by creating an account to start playing games!
            </p>
            -->
            </main>
    </body>
</html> 