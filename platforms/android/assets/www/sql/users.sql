CREATE TABLE users
(
UserID int UNSIGNED NOT NULL auto_increment,
FullName VARCHAR(40) NOT NULL,
Email VARCHAR(40) NOT NULL,
Password VARCHAR(100) NOT NULL,
Following VARCHAR(20000),
PRIMARY KEY(UserID)
);
