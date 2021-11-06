<!DOCTYPE html>
<html lang="en">
    <meta charset="UTF-8">
    <title>Register</title>
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <link rel="stylesheet" href="snake.css">
    <?php include("./header.php") ?>
    <body>
        <main class="singleCol">
            <form action="./login.php" class="inputForm">
                <h1>Create new account</h1>
                <label for="username"> Username </label>
                <input type="text" id="username" name="username" placeholder="Username">

                <label for="password"> Password </label>
                <input type="password" id="password" name="password" placeholder="Password">

                <label for="confirmPassword"> Confirm password </label>
                <input type="password" id="confirmPassword" name="confirmPassword" placeholder="Confirm password">

                <input type="submit"/>
                <div class="formExtras" style="display: flex; flex-direction: row; justify-content: flex-start;">
                    <a href="./login.php">Back to login</a>
                </div>
            </form>
        </main>
    </body>
</html> 