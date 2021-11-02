<?php
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
                    ?> <td id="<?= getAlphaBase($j).$i ?>">  </td> <?php
                }
                ?> </tr> <?php
            }
            ?> </table> <?php
        ?> </div> <?php
    }
?>

<style>
    #gameWrapper {
        width: 500px;
        height: 500px;
        overflow-y: auto;
        overflow-x: auto;
    }
    #gameTable {
        transform-origin: top left;
        scale: 2;
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
</style>

<!DOCTYPE html>
<html lang="en">
    <meta charset="UTF-8">
    <title>Snake Game</title>
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <link rel="stylesheet" href="snake.css">
    <body>
        <?=buildGameTable(20, 20)?>
        <br>
        <input type="range" value="1.0" min="0.50" max="1.5"  step="0.05" oninput="
            var element = document.getElementById('gameTable');
            element.style.scale = this.value;">
    </body>
</html> 