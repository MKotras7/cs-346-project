<?php
	if(!array_key_exists("gameId", $_GET))
	{
		header('HTTP/1.1 404 Not Found');
		die;
	}
	//Now, there is definitely a game ID;
	
	require_once "utils/dbConnect.php";
	$db = db_connect();
	$query = "SELECT name, startDate, boardSize, publicID FROM game WHERE publicID = ?";
	$statement = $db->prepare($query);
	$statement->execute([$_GET["gameId"]]);
	$gameData = $statement->fetch();
	print_r($gameData);
	
	$currentGames = [];
	$upcomingGames = [];
	$curTime = time();
	
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

    function generateInputbox($dateTimeString, $disabled)
    {
        $id = "snakeInput" . $dateTimeString;
        ?>
        <div class="snakeInput">
            <label for="<?=$id?>"><?=$dateTimeString?></label>
            <select name="<?=$id?>" id="<?=$id?>" <?php if($disabled) {echo 'disabled="disabled"';} ?>>
                <option value="none">None</option>
                <option value="up">Up</option>
                <option value="right">Right</option>
                <option value="down">Down</option>
                <option value="left">Left</option>
            </select>
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

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <title>Login</title>
        <meta name="viewport" content="width=device-width,initial-scale=1">
        <link rel="stylesheet" href="/styles/snake.css">
    </head>

    <body>
        <?php include("./header.php") ?>
        <main>
            <h1 style="text-align: center; margin: 0 15px;"><?=$gameData["name"]?></h1>
            <div id="horizontalSplit">
                <?=buildGameTable(intval($gameData["boardSize"]), intval($gameData["boardSize"]))?>
                <div id="chatBox">
                    <h2> chat </h2>
                    <div id="chatBoxContainer">
                        <ul id="chatBoxChannels" class="nobullet">
                            <li><img src="./icons/generalIcon.jpg" alt="General chat"/></li>
                            <li><img src="./icons/gumbyIcon.jpg" alt="General chat"/></li>
                            <li><img src="./icons/justinIcon.jpg" alt="General chat"/></li>
                            <li><img src="./icons/ruggIcon.jpg" alt="General chat"/></li>
                            <li><img src="./icons/trundlerIcon.jpg" alt="General chat"/></li>
                        </ul>
                        <div id="chatBoxText" style="display: flex; flex-direction: column">
                            <h3>General chat</h3>
                            <ul id="messages" class="nobullet" style="flex-grow: 1; margin: 0; padding: 0; display: flex; flex-direction: column; justify-content: flex-end;">
                                <li> 
                                    <div style="display: flex; flex-direction: row; align-items: center;">
                                        <img src="./icons/gumbyIcon.jpg" alt="General chat"/> 
                                        askjndfbhadshfajkhfa green is sus green is sus iashjrosahj
                                    </div>
                                </li>
                                <li> 
                                    <div style="display: flex; flex-direction: row; align-items: center;">
                                        <img src="./icons/trundlerIcon.jpg" alt="General chat"/> 
                                        jahahdahdosahr
                                    </div>
                                </li>
                            </ul>
                            <input type="text" id="chatTextBox" style="border-radius: 5px; margin: 5px; font-size: 18px;"/>
                        </div>
                    </div>
                </div>
            </div>
            <div id="inputBox">
                <form id="inputForm" action="./gameScreen.php">
					<?php
						$startTime = strtotime($gameData["startDate"]);
						$displayTime = $startTime;
						$curTime = time();
						$endTime = $curTime + (10*60*60);
						
						while($displayTime < $endTime)
						//for($i = 0; $i < 5; $i++)
						{
							generateInputbox(date('Y-m-d h:i:s', $displayTime), $curTime > $displayTime);
							$displayTime += 60*60;
						}
					?>
					
                </form>
                <a class="anchorButton" href="./gameScreen.php">Submit</a>
            </div>
        </main>
    </body>
</html> 
