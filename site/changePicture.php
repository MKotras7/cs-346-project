<?php date_default_timezone_set('Etc/UTC'); ?>

<?php
	include_once("./utils/sessionHelper.php");
	include_once("./utils/userHelper.php");
	if(!$sessionHelper["loggedIn"]) 
	{ 
		redirect("sorryLogIn.php");
	}
	else if(!isUserRegistered(getUserByID($_SESSION["name"])))
	{ 
		redirect("sorryMustBeRegistered.php");
	}
	
	try
	{
		if ($_SERVER['REQUEST_METHOD'] == 'POST' and $sessionHelper["loggedIn"] and isUserRegistered(getUserByID($_SESSION["name"]))) 
		{
			if ($_FILES['fileToUpload']['error'] == UPLOAD_ERR_OK 
				and is_uploaded_file($_FILES['fileToUpload']['tmp_name'])) 
			{
				file_put_contents("./userImages/" . $_SESSION["name"] . ".png", file_get_contents($_FILES['fileToUpload']['tmp_name']));
				//echo file_get_contents($_FILES['fileToUpload']['tmp_name']); 
			}
		}
	}
	catch(Exception $ex)
	{
	}
	
?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <title>Error</title>
        <meta name="viewport" content="width=device-width,initial-scale=1">
        <link rel="stylesheet" href="./styles/snake.css">
    </head>

    <body>
        <?php include("./header.php") ?>
		<div id="wrapper">
			<main class="singleCol">
				<form action="./changePicture.php" class="inputForm" method="POST" enctype="multipart/form-data">
					<h1> Change your profile picture </h1>
					<p>Your image should be 32x32 pixels</p>
					<input type="file" id="fileToUpload" name="fileToUpload">
					<input class="anchorButton" type="submit" value="Submit"/>
				</form>
			</main>
			<?php include("./footer.php"); ?>
		</div>
    </body>
</html> 