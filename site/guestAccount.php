<?php 
    require_once "utils/userHelper.php";
    $user = generateGuestUser();
    $registerSuccess = registerUser($user["username"], $user["password"]);
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
            <form action="./guestAccount.php" class="inputForm" method="GET" style="width: 50%;">
                <!-- <input id="id" name="id" value="<?= $seed ?>" hidden/> -->
                <h1>Guest Account</h1>

                <?php if($registerSuccess) 
                {
                    ?> 
                    <p style="text-align: center;">Please write down these credentials</p>
                    <div style="display: flex; flex-direction: row; justify-content: space-between; align-items: center;">
                        <div style="width: 40%; display: flex; flex-direction: column; justify-content: center;">
                            <p style="text-align: center;">Username</p>
                            <p style="text-align: center;"><?=$user["username"]?></p>
                        </div>
                        <div style="width: 40%; display: flex; flex-direction: column; justify-content: center;">
                            <p style="text-align: center;">Password</p>
                            <p style="text-align: center;"><?=$user["password"]?></p>
                        </div>
                    </div>
                    
                    <?php
                }
                else
                {
                    ?> 
                    <p style="text-align: center;">Sorry, something went wrong when trying to register a guest account. Please try again later.</p>
                    <?php
                }
                ?>
                <div class="formExtras" style="display: flex; flex-direction: row; justify-content: space-between;">
                    <a href="./login.php">Back to login</a>
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