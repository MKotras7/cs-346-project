<?php
    function usernameIsTaken($username)
    {
        return false;
    }
    
    //Returns a dictionary { "username" : "", "password" : "" }
    function generateGuestUser()
    {
        $alphabet = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ1234567890!@#$%^&*";
        $alphabetLength = strlen($alphabet);

        $curTime = microTime(true);
        //echo $curTime;
        $hash = hash("sha256", $curTime);
        while(usernameIsTaken("guest_".substr($hash,0,10)))
        {
            $hash = hash("sha256", $hash);
        }
        $guestUsername = "guest_".substr($hash,0,10);
        //echo $guestUsername;

        //Password is 20 characters
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

    function registerUser($username, $password)
    {
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
        //echo $hashedPassword;
        
        require_once "utils/dbConnect.php";
        $db = db_connect();
        try {
            $alreadyExistsCheckQuery = "SELECT count(*) FROM user WHERE username=?";
            $alreadyExistsStatement = $db->prepare($alreadyExistsCheckQuery);
            $alreadyExistsStatement->execute([$username]);
            $alreadyExistsResult = $alreadyExistsStatement->fetchAll();

            if($alreadyExistsResult[0]["count(*)"] != 0)
            {
                throw new Exception("Username is already in use.");
            }
            else
            {
                $insertQuery = "INSERT INTO user (username, password) VALUES (?,?)";
                $insertStatement = $db->prepare($insertQuery);
                $insertStatement->execute([$username, $hashedPassword]);
                //return $db->lastInsertId();
            }
        }
        catch (PDOException $e) 
        {
            db_disconnect();
            exit("Aborting: There was a database error when creating a new user.");
        }
    }

    $user = generateGuestUser();
    //print_r($user);
    registerUser($user["username"], $user["password"]);
?>