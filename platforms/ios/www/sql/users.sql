CREATE TABLE users
(
UserID int NOT NULL auto_increment,
FullName VARCHAR(40) NOT NULL,
Email VARCHAR(40) NOT NULL,
Password VARCHAR(100) NOT NULL,
PRIMARY KEY(UserID)
);
