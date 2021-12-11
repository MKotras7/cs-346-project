<?php
	include_once("./utils/sessionHelper.php");
	include_once("./utils/gameHelper.php");

    $alphabet = "ABCDEFGHIJKLMNOPQRSTUVWXYZ";
    function getAlphaBase($value)
    {
        global $alphabet;
        $result = [];
        $first = True;
        $alphabetLength = strlen($alphabet);
        do
        {
            array_push($result, $alphabet[($first ? $value : $value - 1) % $alphabetLength]);
            $value = floor($value / $alphabetLength);
            $first = False;
        } while($value != 0);
        $outText = '';
        for($i = count($result)-1; $i >= 0; $i--)
        {
            $outText .= $result[$i];
        }
        return $outText;
    }

    function buildGameTable($width, $height)
    {
        ?> <div id = "gameWrapper"> <?php
            ?> <table id="gameTable"> <?php
            ?> <tr> <td> </td> <?php
            for($i = 0; $i < $width; $i++)
            {
                ?> <td> <?=getAlphaBase($i)?> </td> <?php
            }
            ?> </tr> <?php
            for($i = 0; $i < $height; $i++)
            {
                ?> <tr> <?php
                ?> <td> <?=$i?> </td> <?php
                for($j = 0; $j < $width; $j++)
                {
                    ?> <td style="background-color: <?= rand(0, 1) == 0 ? "black" : "#7EBCA1" ?>;" id="<?= getAlphaBase($j).$i ?>">  </td> <?php
                }
                ?> </tr> <?php
            }
            ?> </table> <?php
        ?> </div> <?php
    }
	
	function getColorFromID($playerID)
	{
		return substr(hash("sha256", $playerID), 0, 6);
	}
	
	function displayNewTable($map)
	{
		global $game;
		$width = $game->boardSize;
		$height = $game->boardSize;
		
		?> <div id = "gameWrapper"> <?php
            ?> <table id="gameTable"> <?php
            ?> <tr> <td> </td> <?php
            for($i = 0; $i < $width; $i++)
            {
                ?> <td> <?=getAlphaBase($i)?> </td> <?php
            }
            ?> </tr> <?php
            for($i = 0; $i < $height; $i++)
            {
                ?> <tr> <?php
                ?> <td> <?=$i?> </td> <?php
                for($j = 0; $j < $width; $j++)
                {
					$foundFruit = false;
					$foundPlayer = false;
					foreach($map["fruits"] as $fruit)
					{
						if($fruit["x"] == $j and $fruit["y"] == $i)
						{
							?> <td style="background-color: green" id="<?= getAlphaBase($j).$i ?>">  </td> <?php
							$foundFruit = true;
							//echo "fruited";
						}
					}
					if(!$foundFruit)
					{
						foreach($map["players"] as $player)
						{
							for($k = 0; array_key_exists($k, $player); $k++)
							{
								$curPlayerSegment = $player[$k];
								if($curPlayerSegment["x"] == $j and $curPlayerSegment["y"] == $i)
								{
									//echo getColorFromID($player["id"]);
									?> <td style="background-color: "#"<?= getColorFromID($player["id"]) ?> " id="<?= getAlphaBase($j).$i ?>">  </td> <?php
									$foundPlayer = true;
								}
							}
						}
					}
					if(!$foundFruit and !$foundPlayer)
					{
						?> <td style="background-color: black ;" id="<?= getAlphaBase($j).$i ?>">  </td> <?php
					}
					
					
					/*
					?> <td style="background-color: <?= rand(0, 1) == 0 ? "black" : "#7EBCA1" ?>;" id="<?= getAlphaBase($j).$i ?>">  </td> <?php
					*/
				}
                ?> </tr> <?php
            }
            ?> </table> <?php
        ?> </div> <?php
	}

    function generateInputbox($iterNum, $enabled, $selected)
    {
		$iterNum++;
		global $game;
        $id = "snakeInput".$iterNum;
		$oneHour = 60*60;
		$gameStartTime = strtotime($game->startDate) + ($oneHour * $iterNum);
		$dateText = date("m-d-Y h:i:s a", $gameStartTime);
	
		
        ?>
        <div class="snakeInput">
            <label for="<?=$id?>"><?= $dateText ?> </label>
            <select name="<?=$id?>" id="<?=$id?>" <?= $enabled ? "" : "disabled"?> >
                <option value="none" <?=$selected==-1?"selected":""?> >None</option>
                <option value="up" <?=$selected==3?"selected":""?>>Up</option>
                <option value="right" <?=$selected==0?"selected":""?>>Right</option>
                <option value="down" <?=$selected==1?"selected":""?>>Down</option>
                <option value="left" <?=$selected==2?"selected":""?>>Left</option>
            </select>
        </div>
        <?php
    }
	
	$keys = array_keys($_GET);
	foreach($keys as $key)
	{
		if(preg_match("/snakeInput[0-9]+/", $key))
		{
			$value = strtoupper($_GET[$key]);
			preg_match("/[0-9]+/", $key, $match);
			$iterNum = $match[0];
			$iterNum = strval(intval($iterNum) - 1);
			if(isValidDirectionString($value))
			{
				$input = new Input();
				$input->gameID = $game->id;
				$input->userID = $_SESSION["name"];
				$input->iterationNumber = $iterNum;
				$input->direction = $value;
				addInput($input);
			}
		}
		
	}
	
	$hoursPassed;
	function generateInputBoxes()
	{
		global $hoursPassed;
		global $game;
		$curTime = time();
		$gameStartTime = strtotime($game->startDate);
		$timeDiff = $curTime - $gameStartTime;
		
		$oneHour = 60*60;
		$hoursPassed = floor($timeDiff / $oneHour);
		
		
		$inputs = getAllInputs($game);
		
		?> 
		<div id="inputBox">
                <form id="inputForm" action="./gameScreen.php" >
				<input type="submit" class="anchorButton" value="Submit"></input>
					<input name="gameId" value=<?= $game->publicID ?> hidden></input>
					<?php
						for($i = 0; $i < $hoursPassed + 10; $i++)
						{
							$selected = -1;
							if(isset($inputs[$_SESSION["name"]][$i+1]))
							{
								$selected = getDirectionNumber($inputs[$_SESSION["name"]][$i+1]);
							}
							generateInputbox($i, $i >= $hoursPassed, $selected);
						}
					?>
				</form>
		</div>
		<?php
		
	}
?>

<style>
    #gameWrapper {
        overflow-y: auto;
        overflow-x: auto;
        aspect-ratio: 1;
    }
    #gameTable {
        transform-origin: top left;
        scale: 1;
    }
    table {
        display: block;
    }
    table tr {
        display: flex;
    }
    table tr td {
        display: inline-block;
        border: 1px solid black;
        width: 25px;
        height: 25px;
        display: flex;
        justify-content: center;
        align-items: center;
    }
    #horizontalSplit {
        display: flex; 
        flex-direction: column; 
        justify-content: space-between;
    }
    #horizontalSplit > * {
        margin: 5px;
    }
    #chatBox {
        min-width: 250px;
        flex-grow: 1;
        background-color: #acd6e9;
        display: flex;
        flex-direction: column;
    }
    #chatBox h2 {
        text-align: center;
        margin: 0;
        padding: 5px;
        border-bottom: 1px solid black;
    }
    #chatBoxContainer {
        display: flex;
        flex-direction: row;
        align-items: stretch;
        flex-grow: 1;
    }
    #chatBoxChannels {
        height: 100%;
        margin: 0;
        padding: 0;
        border-right: 1px solid black;
    }
    #chatBoxText {
        flex-grow: 1;
    }
    #chatBox img {
        margin: 5px;
        height: 32px;
        width: 32px;
        border-radius: 50%;
    }
    #chatBox img:hover {
        cursor: pointer;
    }
    #chatBoxText h3 {
        text-align: center;
        margin: 10px 0 0 0;
        padding: 0;
    }

    #inputForm {
        display: flex;
        flex-direction: row; 
        flex-wrap: none;
        overflow-x: auto;
    }

    .snakeInput {
        display: flex;
        flex-direction: column;
        justify-content: center;
        align-items: center;

        height: 75px;
        width: 200px;
        min-width: 200px;
        display: flex;
        flex-direction: column;
        border: 2px solid black;
    }

    .noBullet {
        list-style: none;
    }

    @media all and (min-width: 800px)
    {
        #horizontalSplit {
            flex-direction: row;
        }
        #chatBox {
            max-width: 30%;
        }
    }
</style>

<?php
	$loggedIn = $sessionHelper["loggedIn"];
	$users = getGamePatrons($game);
	$isPlayingThisGame = false;
	foreach($users as $user)
	{
		if($user->id == $_SESSION["name"])
		{
			$isPlayingThisGame = true;
			break;
		}
	}
	if($isPlayingThisGame)
	{
		generateInputBoxes();
	}
	include("./snake/snakeManager.php");
	$map = simulateTo($game, $hoursPassed);
	displayNewTable($map);
?>