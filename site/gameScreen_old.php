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
            <h1 style="text-align: center; margin: 0 15px;">Ronaldo's Fun House</h1>
            <div id="horizontalSplit">
                <?=buildGameTable(30, 30)?>
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
                    <?= generateInputbox("11/05/2021", "9pm") ?>
                    <?= generateInputbox("11/05/2021", "10pm") ?>
                    <?= generateInputbox("11/05/2021", "11pm") ?>
                    <?= generateInputbox("11/05/2021", "12pm") ?>
                    <?= generateInputbox("11/05/2021", "1am") ?>
                    <?= generateInputbox("11/05/2021", "2am") ?>
                </form>
                <a class="anchorButton" href="./gameScreen.php">Submit</a>
            </div>
        </main>
    </body>
</html> 
