INSERT INTO user (username, password) 
VALUES 
	("Rugg0060", "$2y$10$u05ePgvzmZkMJB84fL11dO5PlZz3vrl2U/fXdxrWoKpzq6QSRgocS"),
	("Rugg0061", "$2y$10$u05ePgvzmZkMJB84fL11dO5PlZz3vrl2U/fXdxrWoKpzq6QSRgocS"),
	("Rugg0062", "$2y$10$u05ePgvzmZkMJB84fL11dO5PlZz3vrl2U/fXdxrWoKpzq6QSRgocS"),
	("Rugg0063", "$2y$10$u05ePgvzmZkMJB84fL11dO5PlZz3vrl2U/fXdxrWoKpzq6QSRgocS"),
	("Rugg0064", "$2y$10$u05ePgvzmZkMJB84fL11dO5PlZz3vrl2U/fXdxrWoKpzq6QSRgocS"),
	("Rugg0065", "$2y$10$u05ePgvzmZkMJB84fL11dO5PlZz3vrl2U/fXdxrWoKpzq6QSRgocS"),
	("Rugg0066", "$2y$10$u05ePgvzmZkMJB84fL11dO5PlZz3vrl2U/fXdxrWoKpzq6QSRgocS");
	
SELECT * FROM user;

INSERT INTO game (name, dateCreated, startDate, hostID, maxPlayers, boardSize) 
VALUES
	(	
		"Rugg0064's Fun house", 
		CURRENT_TIMESTAMP, 
		"2020-09-11 10:40:00", 
		(SELECT id FROM user WHERE username="Rugg0064"), 
		10,
		20
	),
	(
		"Rugg0061's super game", 
		CURRENT_TIMESTAMP, 
		"2022-09-11 10:40:00", 
		NULL,
		5,
		20
	);

SELECT game.id, name, user.username FROM game LEFT JOIN user ON user.id=game.hostID;


INSERT INTO patron (gameID, userID)
VALUES
	(1, 1), (1, 2), (1,5),
	(2,1), (2, 2), (2,6), (2,7);
	
	
SELECT game.name, user.username FROM game LEFT JOIN patron on game.id=patron.gameID LEFT JOIN user ON patron.userID=user.id;

SELECT game.id, game.name, COUNT(*) curPlayers, game.maxPlayers, game.startDate FROM game LEFT JOIN patron ON patron.gameID=game.id WHERE game.startDate<CURRENT_TIMESTAMP GROUP BY game.id HAVING curPlayers<>game.maxPlayers;

SELECT game.id, game.name, COUNT(*) curPlayers, game.maxPlayers, game.startDate FROM game LEFT JOIN patron ON patron.gameID=game.id WHERE game.startDate>CURRENT_TIMESTAMP GROUP BY game.id HAVING curPlayers<>game.maxPlayers;