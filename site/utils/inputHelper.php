<?php
	require_once "utils/dbConnect.php";
	require_once "utils/snakeGameClasses.php";
	require_once "utils/userHelper.php";
	require_once "utils/gameHelper.php";
	
	function addInput($input)
	{
		$game = getGameInfoFromID($input->gameID);
		$curTime = time();
		$startTime = strtotime($game->startDate);
		$startTime += ($input->iterationNumber+1) * 60 * 60;
		
		if($curTime >= $startTime)
		{
			return;
		}
		
		$db = db_connect();
		$query = "SELECT * FROM input WHERE gameID=? and userID=? and iterationNumber=?";
		$statement = $db->prepare($query);
        $statement->execute([$input->gameID, $input->userID, $input->iterationNumber+1]);
		$result = $statement->fetchAll();
		if(count($result) > 0)
		{
			$query = "UPDATE input SET direction=? WHERE gameID=? and userID=? and iterationNumber=?";
			$statement = $db->prepare($query);
			$statement->execute([$input->direction, $input->gameID, $input->userID, $input->iterationNumber+1]);
		}
		else
		{
			$query = "INSERT INTO input (gameID, userID, iterationNumber, direction) VALUES (?, ?, ?, ?)";
			$statement = $db->prepare($query);
			$statement->execute([$input->gameID, $input->userID, $input->iterationNumber+1, $input->direction]);
		}
	}
	
	
	function isValidDirectionString($string)
	{
		switch($string)
		{
			case "NONE": return true;
			case "RIGHT": return true;
			case "DOWN": return true;
			case "LEFT": return true;
			case "UP": return true;
			default: return false;
		}
	}
	
	function getDirectionNumber($input)
	{
		switch($input->direction)
		{
			case "NONE": return -1;
			case "RIGHT": return 0;
			case "UP": return 1;
			case "LEFT": return 2;
			case "DOWN": return 3;
			default: return -1;
		}
	}
	
	function buildInputFromRow($row)
	{
		$input = new Input();
		$input->gameID = $row["gameID"];
		$input->userID = $row["userID"];
		$input->iterationNumber = $row["iterationNumber"];
		$input->direction = $row["direction"];
		return $input;
	}

	function getAllInputs($game)
	{
		//Returns a list which contains user IDs
		//Each element indexed by an ID is a list of
		//input classes, which are indexed by their iterationnum
		$result = db_connect()->query("SELECT * FROM input WHERE gameID=" . $game->id)->fetchAll();
		$thisGameInputs = [];
		
		$players = getGamePatrons($game);
		foreach($players as $player)
		{
			$thisGameInputs[$player->id] = [];
		}
		
		foreach($result as $input)
		{
			$thisGameInputs[$input["userID"]][$input["iterationNumber"]] = buildInputFromRow($input);
		}
		return $thisGameInputs;
	}
?>