<?php
    require_once('utils/databaseCredentials.php');
    function db_connect() {
        try 
        {
            $db = new PDO("mysql:dbname=" . DB_DATABASE . ";host=" . DB_HOSTNAME, 
                DB_USERNAME,
                DB_PASSWORD,
                array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION));
        }
        catch (PDOException $e)
        {
            echo $e;
            echo "This application exited with failure because there was an error when trying to connect to its database.";
            exit();
        }
        return $db;
    }

    function db_disconnect() {
        global $db;
        if (isset($db)) 
        {
            $db = null;
        }
    }

    /*
    $db = db_connect();
    $query = "SELECT game.name, user.username FROM game LEFT JOIN patron on game.id=patron.gameID LEFT JOIN user ON patron.userID=user.id";
    $result = $db->query($query);
    $resultArray = $result->fetchAll(PDO::FETCH_ASSOC);
    foreach($resultArray as $row)
    {
        ?> <br> <?=$row["name"]?> <?=$row["username"]?> <?php
    }
    */

?>
