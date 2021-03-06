drop database if exists TeamDatabase;
create database if not exists TeamDatabase;

drop user if exists 'Observers'@'localhost';
create user if not exists 'Observers'@'localhost' IDENTIFIED BY 'OBSpassword';

drop user if exists 'Coaches'@'localhost';
create user if not exists 'Coaches'@'localhost' IDENTIFIED BY 'COApassword';


drop user if exists 'DBAdmin'@'localhost';
create user if not exists 'DBAdmin'@'localhost' IDENTIFIED BY 'DBApassword';
Grant ALL on TeamDatabase.* to 'DBAdmin'@'localhost';


use TeamDatabase;

create table Team
(
	Team_ID 	INTEGER UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY, 
	School 		VARCHAR(150),
	Team_State	VARCHAR(100)

);


create table Players
(
	Player_ID 	INTEGER UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
	First_Name	VARCHAR(100),
	Last_Name	VARCHAR(150),
	Position	VARCHAR(50),
	City		VARCHAR(100),
	State		VARCHAR(100),
	ZipCode 	CHAR(10),
	Team		INTEGER UNSIGNED NOT NULL,

	FOREIGN KEY(Team) REFERENCES Team(Team_ID) ON DELETE CASCADE,
	
	CHECK (ZipCode REGEXP '(?!0{5})(?!9{5})\\d{5}(-(?!0{4})(?!9{4})\\d{4})?'),

	INDEX(Last_Name),
	UNIQUE(First_Name, Last_Name)

);


create table Games
(
	HomeTeam_ID 	INTEGER UNSIGNED NOT NULL,
	AwayTeam_ID	Integer UNSIGNED NOT NULL,
	Game_ID		INTEGER UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
	Score		CHAR(10), 
	Winner		VARCHAR(150),

	FOREIGN KEY(HomeTeam_ID) REFERENCES Team(Team_ID) ON DELETE CASCADE,

	FOREIGN KEY(AwayTeam_ID) REFERENCES Team(Team_ID) ON DELETE CASCADE


);

create table Stats
(	
 	PID		INTEGER UNSIGNED NOT NULL,
	GID		INTEGER UNSIGNED NOT NULL,
	Points  	TINYINT    UNSIGNED  DEFAULT 0,
	Assists 	TINYINT    UNSIGNED  DEFAULT 0,
	Rebounds	TINYINT    UNSIGNED  DEFAULT 0,
	PlayingTimeMin  TINYINT(2) UNSIGNED  DEFAULT 0,
	PlayingTimeSec  TINYINT(2) UNSIGNED  DEFAULT 0,
	FOULS		INTEGER UNSIGNED DEFAULT 0,

	FOREIGN KEY(PID) REFERENCES Players(Player_ID) ON DELETE CASCADE,
	
	FOREIGN KEY(GID) REFERENCES Games(Game_ID) ON DELETE CASCADE,
	
	
	CHECK((PlayingTimeMin < 40 AND PlayingTimeSec < 60) OR 
        (PlayingTimeMin = 40 AND PlayingTimeSec = 0 ))
	
);


create table Users
(
	User_ID		INTEGER UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
	UserName	VARCHAR(150) NOT NULL,
	Password	VARCHAR(150) NOT NULL,
	Role		ENUM('Observers', 'Coaches', 'DBAdmin') NOT NULL,
	Email		VARCHAR(200) NOT NULL, 

	UNIQUE(UserName) 
);



create table AccessLog	
(
	LoggedID	INTEGER UNSIGNED NOT NULL, 
	LoggedUser	VARCHAR(150) NOT NULL, 
	TimeStamp	VARCHAR(150),

	FOREIGN KEY(LoggedID) REFERENCES Users(User_ID) ON DELETE CASCADE
	
	
	
);



GRANT SELECT, INSERT, UPDATE ON TeamDatabase.Team TO 'Coaches'@'localhost';
GRANT SELECT, INSERT, UPDATE ON TeamDatabase.Stats TO 'Coaches'@'localhost';
GRANT SELECT, INSERT, UPDATE ON TeamDatabase.Players TO 'Coaches'@'localhost';
GRANT SELECT, INSERT, UPDATE ON TeamDatabase.Games TO 'Coaches'@'localhost';

GRANT SELECT ON TeamDatabase.Team TO 'Observers'@'localhost';
GRANT SELECT ON TeamDatabase.Stats TO 'Observers'@'localhost';
GRANT SELECT ON TeamDatabase.Players TO 'Observers'@'localhost';
GRANT SELECT ON TeamDatabase.Games TO 'Observers'@'localhost';
 






