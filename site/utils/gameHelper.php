<?php
	require_once "utils/dbConnect.php";
	require_once "utils/snakeGameClasses.php";
	require_once "utils/userHelper.php";
	require_once "utils/inputHelper.php";

	function getGamePatrons($game)
	{
		$db = db_connect();
		$query = "SELECT * FROM patron WHERE gameID=?";
		$statement = $db->prepare($query);
        $statement->execute([$game->id]);
		$users = [];
		foreach($statement->fetchAll() as $userRow)
		{
			array_push($users, getUserByID($userRow["userID"]));
		}
		return $users;
	}

	function registerUserToGame($userID, $gameID)
	{
		$db = db_connect();
		$game = getGameInfoFromID($gameID);
		$maxPlayers = $game->maxPlayers;
		$users = getGamePatrons($game);
		$foundUser = false;
		foreach($users as $user)
		{
			if($user->id == $userID)
			{
				$foundUser = true;
				break;
			}
		}
		$numUsers = count($users);
		if(!$foundUser && $numUsers < $maxPlayers)
		{
			$query = "INSERT INTO patron (gameID, userID) VALUES (?, ?)";
			$statement = $db->prepare($query);
			$statement->execute([$gameID, $userID]);
			
			return true;
		}
		else			
		{
			return false;
		}
	}

	function getGameInfoFromPublicID($publicID)
	{
		$db = db_connect();
		$query = "SELECT * FROM game WHERE publicID=?";
		$statement = $db->prepare($query);
        $statement->execute([$publicID]);
		return convertRowToGame($statement->fetch());
	}

	function getGameInfoFromID($id)
	{
		$db = db_connect();
		$query = "SELECT * FROM game WHERE id=?";
		$statement = $db->prepare($query);
        $statement->execute([$id]);
		return convertRowToGame($statement->fetch());
	}
	
	function convertRowToGame($row)
	{
		$newGame = new Game();
		$newGame->id = $row["id"];
		$newGame->name = $row["name"];
		$newGame->dateCreated = $row["dateCreated"];
		$newGame->startDate = $row["startDate"];
		$newGame->hostID = $row["hostID"];
		$newGame->maxPlayers = $row["maxPlayers"];
		$newGame->boardSize = $row["boardSize"];
		$newGame->timeStep = $row["timeStep"];
		$newGame->multiStep = $row["multiStep"];
		$newGame->lookAhead = $row["lookAhead"];
		$newGame->publicID = $row["publicID"];
		return $newGame;
	}
	
	function getAllGames()
	{
		$db = db_connect();
		$result = $db->query("SELECT * FROM game");
		$allGames = $result->fetchAll();
		$games = [];
		foreach($allGames as $game)
		{
			array_push($games, convertRowToGame($game));
		}
		return $games;
	}
?>