DROP TABLE IF EXISTS MovieGenre;
DROP TABLE IF EXISTS MovieDirector;
DROP TABLE IF EXISTS MovieActor;
DROP TABLE IF EXISTS Review;
DROP TABLE IF EXISTS MaxPersonID;
DROP TABLE IF EXISTS MaxMovieID;
DROP TABLE IF EXISTS Director;
DROP TABLE IF EXISTS Actor;
DROP TABLE IF EXISTS Movie;
CREATE TABLE Movie
(
	id INT NOT NULL,
	title VARCHAR(100) NOT NULL,/*Every movie must have a title*/
	year INT,
	rating VARCHAR(10),
	company VARCHAR(50),
	PRIMARY KEY(id),/*Use primary key constraint as very movie must have an id and it's not null.*/
	CHECK(year>=1888)/*First film ever made*/
)ENGINE = INNODB;

CREATE TABLE Actor
(
	id INT NOT NULL,
	last VARCHAR(20),
	first VARCHAR(20),
	sex VARCHAR(6),
	dob DATE NOT NULL,/*Every Actor must have a date of birth*/
	dod DATE,
	PRIMARY KEY(id),/*Use primary key constraint as very actor must have an id and it's not null.*/
	CHECK(dod IS NULL OR dob<dod )/*Actor is alive or date of birth should be earlier than date of death.*/
)ENGINE = INNODB;

CREATE TABLE Director
(
	id INT NOT NULL,
	last VARCHAR(20),
	first VARCHAR(20),
	dob DATE NOT NULL,/*Every Director must have a date of birth*/
	dod DATE,
	PRIMARY KEY(id),/*Use primary key constraint as very director must have an id and it's not null.*/
	CHECK(dod IS NULL OR dob<dod )/*Director is alive or date of birth should be earlier than date of death.*/
)ENGINE = INNODB;

CREATE TABLE MovieGenre
(
	mid INT,
	genre VARCHAR(20),
	FOREIGN KEY (mid) REFERENCES Movie(id)/* id in Movie table is the referenced key for mid */
)ENGINE = INNODB;

CREATE TABLE MovieDirector
(
	mid INT,
	did INT,
	FOREIGN KEY (mid) REFERENCES Movie(id),/* id in Movie table is the referenced key for mid */
	FOREIGN KEY (did) REFERENCES Director(id)/* id in Director table is the referenced key for did */
)ENGINE = INNODB;

CREATE TABLE MovieActor
(
	mid INT,
	aid INT,
	role VARCHAR(50),
	FOREIGN KEY (mid) REFERENCES Movie(id),/* id in Movie table is the referenced key for mid */
	FOREIGN KEY (aid) REFERENCES Actor(id)/* id in Actor table is the referenced key for aid */
)ENGINE = INNODB;

CREATE TABLE Review
(
	name VARCHAR(20),
	time TIMESTAMP,
	mid INT,
	rating INT,
	comment VARCHAR(500),
	FOREIGN KEY (mid) REFERENCES Movie(id),/* id in Movie table is the referenced key for mid */
	CHECK(rating>=0 AND rating <=10)/*Rating of movie must be within the range of [0,10]*/
)ENGINE = INNODB;

CREATE TABLE MaxPersonID
(
	id INT NOT NULL
)ENGINE = INNODB;

CREATE TABLE MaxMovieID
(
	id INT NOT NULL
)ENGINE = INNODB;