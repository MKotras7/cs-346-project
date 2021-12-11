<div class="singleCol">
	<div class="inputForm">
		<h1> Pregame </h1>
		<h4> Current players <h4>
		<ul>
			<?php 
				$users = getGamePatrons($game);
				foreach($users as $user)
				{
					?> <li> <?=$user->username?> </li> <?php
				}
			?>
			<a href="/joinGame.php?gameId=<?=$game->publicID?>">Join Game</a>
		</ul>
	</div>
</div>