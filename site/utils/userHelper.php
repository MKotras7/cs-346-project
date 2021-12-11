<?php 
	require_once "utils/dbConnect.php";
	require_once "utils/snakeGameClasses.php";
	
	function convertRowToUser($row)
	{
		$newUser = new User();
		$newUser->id = $row["id"];
		$newUser->username = $row["username"];
		return $newUser;
	}
	
	function isUserRegistered($user)
	{
		$db = db_connect();
		$query = "SELECT * FROM registereduser WHERE userID=?";
		$statement = $db->prepare($query);
		$statement->execute([$user->id]);
		return count($statement->fetchAll()) == 1;
	}
	
	function getAllUsers()
	{
		$db = db_connect();
		$result = $db->query("SELECT * FROM user");
		$allUsers = $result->fetchAll();
		$users = [];
		foreach($allUsers as $user)
		{
			array_push($users, convertRowToUser($user));
		}
		return $users;
	}
	
	function getUserByUsername($username)
	{
		$db = db_connect();
		$query = "SELECT * FROM user WHERE username=?";
		$statement = $db->prepare($query);
        $statement->execute([$username]);
		return convertRowToUser($statement->fetch());
	}
	
	function getUserByID($id)
	{ //Contains user information NOT PASSWORD
		$db = db_connect();
		$query = "SELECT * FROM user WHERE id=?";
		$statement = $db->prepare($query);
        $statement->execute([$id]);
		return convertRowToUser($statement->fetch());
	}

    function usernameIsTaken($username)
    {
        $db = db_connect();
        $alreadyExistsCheckQuery = "SELECT count(*) FROM user WHERE username=?";
        $alreadyExistsStatement = $db->prepare($alreadyExistsCheckQuery);
        $alreadyExistsStatement->execute([$username]);
        $alreadyExistsResult = $alreadyExistsStatement->fetchAll();
        return $alreadyExistsResult[0]["count(*)"] != 0;
    }

    //  Returns a username and password pair where the username is guarenteed
    //to not be an existing user. The username is derived from consecutive
    //sha256 hashes of the current system time, and re-hashed until a suitable
    //username is found.
    //  Since the guest name is 16 characters long, there is 1.1 trillion possible
    //usernames, thus, re-hashing to find a valid username will almost never cause
    //a significant delay.
    //Returns a dictionary { "username" : "guest_XXXXXXXXXXXXXXXX", "password" : "" }
    function generateGuestUser()
    {
        $alphabet = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ1234567890!@#$%^&*";
        $alphabetLength = strlen($alphabet);

        $curTime = microTime(true);
        $hash = hash("sha256", $curTime);
        while(usernameIsTaken("guest_".substr($hash,0,10)))
        {
            $hash = hash("sha256", $hash);
        }
        $guestUsername = "guest_".substr($hash,0,10);

        //Password is 16 characters
        $passwordHash = hash("sha256", $hash);
        $passwordSegment = substr($passwordHash, 0, 26);
        $passwordValue = hexdec($passwordSegment);
        
        $password = "";
        for($i = 0; $i < 16; $i++)
        {
            $password .= $alphabet[$passwordValue % $alphabetLength];
            $passwordValue /= $alphabetLength;
        }
        return ["username" => $guestUsername, "password" => $password];
    }

    //Tries to register a user.
    //Returns true if the registration succeeded.
    function registerUser($username, $password, $registered)
    {
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
        //echo $hashedPassword;
        
        require_once "utils/dbConnect.php";
        $db = db_connect();
        try {
            if(!usernameIsTaken($username))
            {
				
                $insertQuery = "INSERT INTO user (username, password) VALUES (?,?)";
                $insertStatement = $db->prepare($insertQuery);
                $insertStatement->execute([$username, $hashedPassword]);
				if($registered)
				{
					$user = getUserByUsername($username);
					$query = "INSERT INTO registereduser (userID) VALUES (?)";
					$statement = $db->prepare($query);
					$statement->execute([$user->id]);
				}
				return true;
            }
        }
        catch (PDOException $e) 
        {
            db_disconnect();
            echo $e;
            exit("Aborting: There was a database error when creating a new user.");
        }
        return False;
    }
?>