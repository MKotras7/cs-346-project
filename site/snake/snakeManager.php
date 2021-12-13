<?php
	//This will assume a $game which is an object from snakeGameClasses.php exists.
	//Then, you will use simulateTo(x) to get that timestep's iteration.
	//It will return an array which says where to put colors
	
	function getNextRandom($curRandom)
	{
		return hexdec(substr($curRandom,0,8));
	}
	
	function replaceFruit(&$fruits, $x, $y, &$random, &$game)
	{ //If a fruit exists at [x,y] it will replace it.
		//$random = getNextRandom($random);
		//$x = $random % $game->boardSize;
		$keys = array_keys($fruits);
		foreach($keys as $fruitKey)
		{
			$fruit = $fruits[$fruitKey];
			if($fruit["x"] == $x and $fruit["y"] == $y)
			{
				do
				{
					$random = getNextRandom($random);
					$x = $random % $game->boardSize;
					$random = getNextRandom($random);
					$y = $random % $game->boardSize;
				} while(anyFruitHere($x, $y, $fruits) and anyPlayersHere($x, $y, $players));
				$fruits[$fruitKey] = ["x" => $x, "y" => $y];
				return;
			}
		}
	}
	
	function getUserDirection($inputs, $iteration, $userID)
	{
		if(isset($inputs[$userID][$iteration]))
		{
			return getDirectionNumber($inputs[$userID][$iteration]);
		}
		return -1;
	}
	
	function anyFruitHere($x, $y, $fruits)
	{
		foreach($fruits as $fruit)
		{
			if($fruit["x"] == $x and $fruit["y"] == $y)
			{
				return true;
			}
		}
		return false;
	}
	
	function getPlayerCollisions($x, $y, $players, $game)
	{
		//Returns list of player ID's who have collisions at x,y
		$playerIDs = [];
		foreach($players as $player)
		{
			for($j = 0; array_key_exists($j, $player); $j++)
			{
				$playerSegment = $player[$j];
				if($playerSegment["x"] == $x and $playerSegment["y"] == $y)
				{
					$alreadyAdded = false;
					foreach($playerIDs as $id)
					{
						if($id == $player["id"])
						{
							$alreadyAdded = true;
						}
					}
					if(!$alreadyAdded)
					{
						array_push($playerIDs, $player["id"]);
					}
				}
			}
		}
		return $playerIDs;
	}
	
	function anyPlayersHere($x, $y, $players, &$game)
	{
		foreach($players as $player)
		{
			for($j = 1; array_key_exists($j, $player); $j++)
			//foreach($player as $playerSegment)
			{
				$playerSegment = $player[j];
				if($playerSegment["x"] == $x and $playerSegment["y"] == $y)
				{
					return true;
				}
			}
		}
		return false;
	}
	
	function simulateTo($game, $iteration)
	{
		//echo $iteration;
		include_once("./utils/inputHelper.php");
		$inputs = getAllInputs($game);
		//print_r($inputs);
		$players = [];
		$fruits = [];
		$random = hash("sha256", $game->id);
		$random = getNextRandom($random);
		//These two statements wil be repeated constantly to get new random numbers
		
		for($currentIteration = -1; $currentIteration <= $iteration; $currentIteration++)
		{
			//echo "ITERATION: " . $currentIteration . "<br>";
			if($currentIteration == -1)
			{ //iteration -1 is when nothing exists
		
			}
			else if($currentIteration == 0)
			{ //Iteration 0 is when things exist, but no actions have been taken yet.
				//First, load all of the players.
				$users = getGamePatrons($game);
				$fruits = [];
				$players = [];
				foreach($users as $user)
				{
					do 
					{
						$random = getNextRandom($random);
						$x = $random % $game->boardSize;
						$random = getNextRandom($random);
						$y = $random % $game->boardSize;
					} while(anyPlayersHere($x, $y, $players, $game));
					$random = getNextRandom($random);
					$direction = $random % 4;
					array_push($players, [ ["x"=>$x, "y"=>$y], "direction" => $direction, "id" => $user->id]);
				}
				
				for($i = 0; $i < 3; $i++)
				{
					do
					{
						$random = getNextRandom($random);
						$x = $random % $game->boardSize;
						$random = getNextRandom($random);
						$y = $random % $game->boardSize;
					} while(anyFruitHere($x, $y, $fruits) and anyPlayersHere($x, $y, $players));
					array_push($fruits, ["x"=>$x, "y"=>$y]);
				} 
				
				//print_r($fruits);
				//echo "<br>";
				//print_r($players);
				//Each player is a series of [x, y] pairs
				//players[0][0] is the first player's head.
				//players also stores a direction, [0,3]
			}
			else
			{
				for($i = 0; $i < count($players); $i++)
				{
					//Rotation step
					$newDirection = getUserDirection($inputs, $currentIteration, $players[$i]["id"]);
					//echo "(" . $newDirection . ")";
					if($newDirection != -1)
					{
						$lowerChange = $players[$i]["direction"] - 1;
						$upperChange = $players[$i]["direction"] + 1;
						if($lowerChange < 0)
						{
							$lowerChange = 3;
						}
						if($upperChange > 3)
						{
							$upperChange = 0;
						}
						
						if($newDirection == $lowerChange or $newDirection == $upperChange)
						{
							//echo "cng";
							$players[$i]["direction"] = $newDirection;
						}
					}
					//Movement step
					$oldPosition = $players[$i][0];
					switch($players[$i]["direction"])
					{
						case 0:
							$players[$i][0]["x"]++;
							break;
						case 1:
							$players[$i][0]["y"]--;
							break;
						case 2:
							$players[$i][0]["x"]--;
							break;
						case 3:
							$players[$i][0]["y"]++;
							break;
					}
					for($j = 1; array_key_exists($j, $players[$i]); $j++)
					{
						$curPos = $players[$i][$j];
						$players[$i][$j] = $oldPosition;
						$oldPosition = $curPos;
					}
					//echo "<hr>";
					//print_r($players[$i]);
					if(anyFruitHere($players[$i][0]["x"], $players[$i][0]["y"], $fruits))
					{
						//echo "Fruit collision! <br>";
						array_push($players[$i], $oldPosition);
						replaceFruit($fruits, $players[$i][0]["x"], $players[$i][0]["y"], $random, $game);
						//print_r($fruits);
						//echo "<br>";
					}
				}
				//print_r($players);
				//echo "<br>";
				$deleteIDs = [];
				foreach($players as $player)
				{
					//print_r($player);
					//echo "checking " . $player["id"] . " ";
					$collisionsAtP = getPlayerCollisions($player[0]["x"], $player[0]["y"], $players, $fruits);
					//print_r($collisionsAtP);
					if(count($collisionsAtP) > 1)
					{
						//echo "hit" . $player[0]["x"] . $player[0]["y"];
						$deleteIDs[$player["id"]] = true;
						/*
						foreach($collisionsAtP as $id)
						{
							$deleteIDs[$id] = true;
						}
						*/
					}
					if($player[0]["x"] < 0 or $player[0]["x"] >= $game->boardSize or $player[0]["y"] < 0 or $player[0]["y"] >= $game->boardSize)
					{
						$deleteIDs[$player["id"]] = true;
					}
				}
				
				$keys = array_keys($deleteIDs);
				foreach($keys as $key)
				{
					$size = count($players);
					for($i = 0; $i < $size; $i++)
					{
						$player = $players[$i];
						if($player["id"] == $key)
						{
							unset($players[$i]);
							for($j = $i; $j < $size - 1; $j++)
							{
								$players[$j] = $players[$j+1];
							}
							break;
						}
					}
					unset($players[$size - 1]);
				}
			}
		}
		return ["players" => $players, "fruits" => $fruits];
	}
	
?>