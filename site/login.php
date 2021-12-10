<?php
	include_once "./utils/sessionHelper.php";
	
    $attemptedLogin = $_SERVER['REQUEST_METHOD'] == 'POST';
    $succeedLogin = False;


    if ($_SERVER['REQUEST_METHOD'] == 'POST')
    {
        $username = $_POST["username"];
        $password = $_POST["password"];

        require_once "utils/dbConnect.php";
        $db = db_connect();

        $query = "SELECT password, id FROM user WHERE username=?";
        $statement = $db->prepare($query);
        $statement->execute([$username]);
        $result = $statement->fetch();
        if(password_verify($password, $result["password"]))
        {
			$_SESSION["name"] = $result["id"];
			echo $_SESSION["name"];
            echo "CORRECT PASSWORD";
            $succeedLogin = True;
			redirect("index.php", "Login Successful.");
        }
        else
        {
            echo "INCORRECT LOGIN";
        }
    }
?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <title>Login</title>
        <meta name="viewport" content="width=device-width,initial-scale=1">
        <link rel="stylesheet" href="/styles/snake.css">
    </head>

    <body>
        <?php include("./header.php") ?>
        <main class="singleCol">
            <form action="./login.php" class="inputForm" method="POST">
                <h1>Login</h1>
                <?php 
                    if($attemptedLogin && !$succeedLogin)
                    {
                        ?> <h2 style="color: red;"> Sorry, invalid credentials. </h2> <?php
                    } 
                ?>
                <label for="username"> Username </label>
                <input type="text" id="username" name="username" placeholder="username">

                <label for="password"> Password </label>
                <input type="password" id="password" name="password" placeholder="password ">

                <input class="anchorButton" type="submit" value="Submit"/>
                <div class="formExtras" style="display: flex; flex-direction: row; justify-content: space-between;">
                    <a href="./forgotPassword.php">Forgot password</a>
                    <span>
                        No account? <a href="./register.php">Register</a>
                    </span>
                </div>
                <div style="display: flex; flex-direction: row; justify-content: flex-start;">
                    <a href="./index.php">Back to main menu</a>
                </div>
            </form>
        </main>
    </body>
</html> 