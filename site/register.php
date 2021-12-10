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
            <form action="./login.php" class="inputForm">
                <h1>Create new account</h1>
                <h4>Sorry, at the moment you cannot register a named account, however, you can <a href="guestAccount.php">get a guest account.</a></h4>
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