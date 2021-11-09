INSERT INTO user (username, password) 
VALUES 
	("Rugg0060", "asdasdasd"),
	("Rugg0061", "asdasdasd"),
	("Rugg0062", "asdasdasd"),
	("Rugg0063", "asdasdasd"),
	("Rugg0064", "asdasdasd"),
	("Rugg0065", "asdasdasd"),
	("Rugg0066", "asdasdasd");
	
SELECT * FROM user;

INSERT INTO game (name, dateCreated, startDate, hostID, size) 
VALUES
	(	
		"Rugg0064's Fun house", 
		CURRENT_TIMESTAMP, 
		CURRENT_TIMESTAMP, 
		(SELECT id FROM user WHERE username="Rugg0064"), 
		20
	),
	(
		"Rugg0061's super game", 
		CURRENT_TIMESTAMP, 
		CURRENT_TIMESTAMP, 
		NULL, 
		20
	);

SELECT game.id, name, user.username FROM game LEFT JOIN user ON user.id=game.hostID;


INSERT INTO patron (gameID, userID)
VALUES
	(1, 1), (1, 2), (1,5),
	(2,1), (2, 2), (2,6), (2,7);
	
	
SELECT game.name, user.username FROM game LEFT JOIN patron on game.id=patron.gameID LEFT JOIN user ON patron.userID=user.id;