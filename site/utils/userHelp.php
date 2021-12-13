<?php 
    function usernameIsTaken($username)
    {
        require_once "utils/dbConnect.php";
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
    function registerUser($username, $password)
    {
        $hashedPassword = workaroundPasswordhash($password);
        //echo $hashedPassword;
        
        require_once "utils/dbConnect.php";
        $db = db_connect();
        try {
            if(!usernameIsTaken($username))
            {
                $insertQuery = "INSERT INTO user (username, password) VALUES (?,?)";
                $insertStatement = $db->prepare($insertQuery);
                return $insertStatement->execute([$username, $hashedPassword]);
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