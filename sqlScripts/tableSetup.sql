CREATE DATABASE IF NOT EXISTS kotram75;
USE kotram75;
DROP TABLE IF EXISTS input;
DROP TABLE IF EXISTS patron;
DROP TABLE IF EXISTS gameCache;
DROP TABLE IF EXISTS game;

DROP TABLE IF EXISTS admin;
DROP TABLE IF EXISTS registereduser;
DROP TABLE IF EXISTS user;

CREATE TABLE user (
	id INT UNSIGNED AUTO_INCREMENT,
	username VARCHAR(30) NOT NULL UNIQUE,
	password VARCHAR(255) NOT NULL,
	CONSTRAINT PRIMARY KEY (id)
);

CREATE TABLE registereduser (
	userID INT UNSIGNED NOT NULL UNIQUE,
	snakeIcon VARCHAR(255),
	CONSTRAINT FOREIGN KEY (userID) REFERENCES user(id),
	CONSTRAINT PRIMARY KEY (userID)
);

CREATE TABLE admin (
	userID INT UNSIGNED NOT NULL UNIQUE,
	CONSTRAINT FOREIGN KEY (userID) REFERENCES user(id),
	CONSTRAINT PRIMARY KEY (userID)
);

CREATE TABLE game (
	id INT UNSIGNED AUTO_INCREMENT,
	name VARCHAR(30) NOT NULL,
	dateCreated DATETIME NOT NULL,
	startDate DATETIME NOT NULL,
	hostID INT UNSIGNED,
	maxPlayers INT UNSIGNED NOT NULL,
	boardSize INT UNSIGNED NOT NULL,
	timeStep INT UNSIGNED NOT NULL DEFAULT 60,
	multiStep INT UNSIGNED NOT NULL DEFAULT 1,
	lookAhead INT UNSIGNED NOT NULL DEFAULT 1,
	publicID VARCHAR(13) NOT NULL,
	CONSTRAINT FOREIGN KEY (hostID) REFERENCES user(ID),
	CONSTRAINT PRIMARY KEY (id),
	CONSTRAINT CHECK (multiStep > 0),
	CONSTRAINT CHECK (maxPlayers >= 2),
	CONSTRAINT CHECK (boardSize >= 10)
);

CREATE TABLE gameCache (
	id INT UNSIGNED AUTO_INCREMENT,
	CONSTRAINT PRIMARY KEY (id)
);

CREATE TABLE input (
	gameID INT UNSIGNED NOT NULL,
	userID INT UNSIGNED NOT NULL,
	iterationNumber INT UNSIGNED NOT NULL,
	direction ENUM("NONE", "UP", "RIGHT", "DOWN", "LEFT") NOT NULL,
	CONSTRAINT FOREIGN KEY (gameID) REFERENCES game(id),
	CONSTRAINT FOREIGN KEY (userID) REFERENCES user(id),
	CONSTRAINT PRIMARY KEY (gameID, userID, iterationNumber)
);

CREATE TABLE patron (
	gameID INT UNSIGNED NOT NULL,
	userID INT UNSIGNED NOT NULL,
	CONSTRAINT FOREIGN KEY (gameID) REFERENCES game(id),
	CONSTRAINT FOREIGN KEY (userID) REFERENCES user(id),
	CONSTRAINT PRIMARY KEY (gameID, userID)
);

SHOW TABLES;
DESCRIBE user;
DESCRIBE registereduser;
DESCRIBE admin;

DESCRIBE gameCache;
DESCRIBE input;
DESCRIBE patron;
DESCRIBE game;

