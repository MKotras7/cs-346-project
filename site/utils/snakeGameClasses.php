<?php
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
	class Input
	{
		public $gameID;
		public $userID;
		public $iterationNumber;
		//0, 1, 2, 3 corresponding to right, down, left, up.
		public $direction;
	}
	class User
	{
		public $id;
		public $username;
	}
?>