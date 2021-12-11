<?php
	include_once("./utils/sessionHelper.php");
	include_once("./utils/userHelper.php");
	require_once "utils/dbConnect.php";
	if($sessionHelper["loggedIn"])
	{
		redirect("sorryCantBeLoggedIn.php");
	}
	$issues = [];
	$created = false;
	if ($_SERVER['REQUEST_METHOD'] == 'POST') 
    {
		$username = $_POST["username"];
		if(strlen($username) < 4)
        {
            array_push($issues, "Username is too short.");
        }
		if(strlen($username) > 30)
        {
            array_push($issues, "Username name is too long.");    
        }
		
		$password = $_POST["password"];
		$confirmPassword = $_POST["confirmPassword"];
		
		if($password != $confirmPassword)
		{
            array_push($issues, "Password and Confirmation must be identical.");
		}
		
		if(strlen($username) < 4)
        {
            array_push($issues, "Username is too short.");
        }
		if(strlen($username) > 30)
        {
            array_push($issues, "Username name is too long.");    
        }
		
		if(usernameIsTaken($username))
		{
			array_push($issues, "Username is already taken.");  
		}
		
		if(count($issues) == 0)
		{
			if(registerUser($username, $password, true))
			{
				redirect("./login.php");
			}
			else
			{
				array_push($issues, "Sorry, there was some error.");  
			}
					
		}
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