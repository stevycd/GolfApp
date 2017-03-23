CREATE TABLE rounds
(
RoundID int UNSIGNED NOT NULL auto_increment,
UserID int UNSIGNED NOT NULL,
Played Date NOT NULL,
CourseName VARCHAR(40) NOT NULL,
RoundData VARCHAR(20000) NOT NULL,
Private BOOLEAN NOT NULL,
PRIMARY KEY(RoundID)
);

