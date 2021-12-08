<?php
    $alphabet = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ1234567890!@#$%^&*_";
	$issues = [];
    require_once "utils/userHelp.php";

    function hasAnyInvalidCharacter($input)
    {
        global $alphabet;
        for($i = 0; $i < strlen($input); $i++)
        {
            if(strpos($alphabet, $input[$i]) === false)
            {
                return true;
            }
        }
        return false;
    }

    if ($_SERVER['REQUEST_METHOD'] == 'POST') 
    {
        if(strlen($_POST["username"]) < 4)
        {
            array_push($issues, "Username must be 4 or more characters");
        }
        if(strlen($_POST["username"]) > 60)
        {
            array_push($issues, "Username must be 60 or less characters");
        }
        if(strlen($_POST["username"]) != 0 and hasAnyInvalidCharacter($_POST["username"]))
        {
            array_push($issues, "Username has at least one invalid character.");
        }
        if(strlen($_POST["password"]) < 12)
        {
            array_push($issues, "Password must be 12 or more characters");
        }
        if(strlen($_POST["password"]) != 0 and hasAnyInvalidCharacter($_POST["password"]))
        {
            array_push($issues, "Password has at least one invalid character.");
        }
        if($_POST["password"] != $_POST["confirmPassword"])
        {
            array_push($issues, "Passwords are not the same.");
        }

        if(count($issues) == 0)
        {
            if(!usernameIsTaken($_POST["username"]))
            {
                if(registerUser($_POST["username"], $_POST["password"]))
                {
                    require_once "utils/dbConnect.php";
                    $db = db_connect();
                    $query = "INSERT INTO registeredUser (userID) SELECT id FROM user WHERE user.username=?";
                    $statement = $db->prepare($query);
                    $statement->execute([$_POST["username"]]);
                }
                else
                {
                    array_push($issues, "Registering failed");
                }
            }
            else
            {
                array_push($issues, "Username is already taken.");
            }
        }
        //INSERT INTO registeredUser (userID) SELECT id FROM user WHERE user.username="guest_0935b670d6";
    }
?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <title>Register</title>
        <meta name="viewport" content="width=device-width,initial-scale=1">
        <link rel="stylesheet" href="/styles/snake.css">
    </head>
    
    <body>
        <?php include("./header.php") ?>
        <main class="singleCol">
            <form action="./register.php" class="inputForm" method="POST">
                <h1>Create new account</h1>

                <?php if(count($issues) >0 )
                {
                    ?>
                    <ul class="errorBox">
                    <?php
                        foreach($issues as $issue)
                        {
                            ?> <li> <?=$issue?> </li> <?php
                        }
                    ?>
                    </ul>
                    <?php
                }
                ?>

                <label for="username"> Username </label>
                <input type="text" id="username" name="username" placeholder="Username">

                <label for="password"> Password </label>
                <input type="password" id="password" name="password" placeholder="Password">

                <label for="confirmPassword"> Confirm password </label>
                <input type="password" id="confirmPassword" name="confirmPassword" placeholder="Confirm password">

                <input class="anchorButton" type="submit" value="Submit"/>
                <div class="formExtras" style="display: flex; flex-direction: row; justify-content: space-between;">
                    <a href="./login.php">Back to login</a>
                    <a href="./guestAccount.php">Anonymous guest account</a>
                </div>
            </form>
        </main>
    </body>
</html> 