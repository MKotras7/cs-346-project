<?php
	require_once "utils/dbConnect.php";
	class Game
	{
		public $id;
		public $name;
		public $dateCreated;
		public $startDate;
		public $hostID;
		public $maxPlayers;
		public $boardSize;
		public $timeStep;
		public $multiStep;
		public $lookAhead;
		public $publicID;
	}

	function getGameInfoFromPublicID($publicID)
	{
		$db = db_connect();
		
	}

	function getGameInfoFromID($id)
	{
		$db = db_connect();
		$result = $db->query("SELECT * FROM game WHERE id=?");
		
		
		
		$game = new Game();
		
	}
	
	function getAllGames()
	{
		$db = db_connect();
		$result = $db->query("SELECT * FROM game");
		$allGames = $result->fetchAll();
		$games = [];
		foreach($allGames as $game)
		{
			$newGame = new Game();
			$newGame->id = $game["id"];
			$newGame->name = $game["name"];
			$newGame->dateCreated = $game["dateCreated"];
			$newGame->startDate = $game["startDate"];
			$newGame->hostID = $game["hostID"];
			$newGame->maxPlayers = $game["maxPlayers"];
			$newGame->boardSize = $game["boardSize"];
			$newGame->timeStep = $game["timeStep"];
			$newGame->multiStep = $game["multiStep"];
			$newGame->lookAhead = $game["lookAhead"];
			$newGame->publicID = $game["publicID"];
			array_push($games, $newGame);
		}
		return $games;
	}
?>