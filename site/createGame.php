<?php date_default_timezone_set('Etc/UTC'); ?>

<?php 
	include_once("./utils/sessionHelper.php");
	include_once("./utils/userHelper.php");
	include_once("./utils/gameHelper.php");

	if(!$sessionHelper["loggedIn"]) 
	{ 
		redirect("sorryLogIn.php");
	} 
	else if(!isUserRegistered(getUserByID($_SESSION["name"])))
	{ 
		redirect("sorryMustBeRegistered.php");
	}

	$issues = [];
	
    if ($_SERVER['REQUEST_METHOD'] == 'POST' and $sessionHelper["loggedIn"] and isUserRegistered(getUserByID($_SESSION["name"]))) 
    {
        $gameName = $_POST["gameName"];
        if(strlen($gameName) < 4)
        {
            array_push($issues, "Game Name is too short.");
        }
        if(strlen($gameName) > 30)
        {
            array_push($issues, "Game name is too long.");    
        }

        $curTime = time();
        try { 
            $dateTime = strtotime($_POST["startDate"]);
			if($dateTime < $curTime)
            {
                array_push($issues, "Date must be a time in the future.");
            }
        }
        catch(Exception $ex) 
        {
            array_push($issues, "Date was invalid");
            //echo $ex;
        }

        if(count($issues) == 0)
		{
			require_once "utils/dbConnect.php";
			$db = db_connect();
			$query = "INSERT INTO game (name, dateCreated, startDate, maxPlayers, boardSize, publicID, hostID) VALUES (?, ?, ?, ?, ?, ?, ?)";
			$dateTime = strtotime($_POST["startDate"]);
			$dateTime2 = date('Y-m-d H:i:s', $dateTime);
			//echo $dateTime2;
			$parameters = [$_POST["gameName"], date('Y-m-d H:i:s', time()), $dateTime2, $_POST["maxPlayers"], 20, uniqid(), $_SESSION["name"]];
			
			$alreadyExistsStatement = $db->prepare($query);
			$alreadyExistsStatement->execute($parameters);
			redirect("./gameBrowser.php");
		}
    }    
?>


<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <title>Create Game</title>
        <meta name="viewport" content="width=device-width,initial-scale=1">
        <link rel="stylesheet" href="./styles/snake.css">
    </head>
    
    <body>
        <?php include("./header.php") ?>
		
		<div id="wrapper">
			<main class="singleCol">
					<form action="./createGame.php" class="inputForm" method="POST">
						<h1>Create Game</h1>
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

						<label for="gameName"> Lobby Name </label>
						<input type="text" id="gameName" name="gameName" placeholder="Name" maxlength=30>

						<label for="startDate"> Time to start </label>
						<input type="datetime-local" id="startDate" name="startDate">

						<label for="maxPlayers"> Max player count </label>
						<input type="number" id="maxPlayers" name="maxPlayers" min=2 value=2>

						<label for="boardSize"> Board size </label>
						<input type="number" id="boardSize" name="boardSize" min=10 max=100 value=20>
						
						<label for="timeStep" class="splitLabel"> Time Step <span class="helpText">Whats this?</span> </label>
						<input type="number" id="timeStep" name="timeStep" min=15 max=1440 value=15 step=15>

						<label for="multiStep" class="splitLabel"> Multi Step <span class="helpText">Whats this?</span> </label>
						<input type="number" id="multiStep" name="multiStep" min=1 max=100 value=1>
						
						<label for="lookAhead" class="splitLabel"> Look Ahead <span class="helpText">Whats this?</span> </label>
						<input type="number" id="lookAhead" name="lookAhead" min=1 max=100 value=1>

						<input class="anchorButton" type="submit" value="Submit"/>
						<div class="formExtras" style="display: flex; flex-direction: row; justify-content: flex-start;">
							<a href="./gameBrowser.php">Go Back</a>
						</div>
					</form>
			</main>
			<?php include("./footer.php"); ?>
		</div>
    </body>
</html> 