<!DOCTYPE html>
<html lang="en">
    <meta charset="UTF-8">
    <title>Forgot Password</title>
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <link rel="stylesheet" href="snake.css">
    <body>
        <?php include("./header.php") ?>
        <main class="singleCol">
            <form action="./forgotPassword.php" class="inputForm">
                <h1>Forgot password</h1>
                <label for="username"> Username </label>
                <input type="text" id="username" name="username" placeholder="username">

                <input type="submit" value="Submit"/>
                <div class="formExtras" style="display: flex; flex-direction: row; justify-content: flex-start;">
                    <a href="./login.php">Back to login</a>
                </div>
            </form>
        </main>
    </body>
</html> 