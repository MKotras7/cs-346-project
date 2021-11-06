<!DOCTYPE html>
<html lang="en">
    <meta charset="UTF-8">
    <title>Login</title>
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <link rel="stylesheet" href="snake.css">
    <?php include("./header.php") ?>
    <body>
        <main class="singleCol">
            <form action="./createGame.php" class="inputForm">
                <h1>Create Game</h1>
                <label for="gameName"> Lobby Name </label>
                <input type="text" id="gameName" name="gameName" placeholder="name">

                <label for="startDate"> Time to start </label>
                <input type="datetime-local" id="startDate" name="startDate">

                <label for="maxPlayers"> Max player count </label>
                <input type="number" id="maxPlayers" name="maxPlayers" min=2 >

                <label for="boardSize"> Board size </label>
                <input type="number" id="boardSize" name="boardSize" min=10 max=100 >

                <input type="submit" value="Submit"/>
                <div class="formExtras" style="display: flex; flex-direction: row; justify-content: flex-start;">
                    <a href="./gameBrowser.php">Go Back</a>
                </div>
            </form>
            
            
        </main>
    </body>
</html> 