# Movie 
# Primary key must be unique
# ERROR 1062 (23000) at line 3: Duplicate entry '2' for key 'PRIMARY'
INSERT INTO Movie VALUES (2, 'Movie', '2014', 'G', 'Movie Company');

# Movie titles must be non null
# ERROR 1048 (23000) at line 7: Column 'title' cannot be null
INSERT INTO Movie VALUES (65536, NULL, '2014', 'G', 'Movie Company');

# Movie titles must be non-empty strings
INSERT INTO Movie VALUES (65536, '', '2014', 'G', 'Movie Company');


# Actor 
# Primary key id must be unique
# ERROR 1062 (23000) at line 16: Duplicate entry '1' for key 'PRIMARY'
INSERT INTO Actor VALUES (1, 'Smith', 'Joe', 'Male', '1980-1-1', NULL);

# Every actor must have a date of birth.
INSERT INTO Actor VALUES (65536, 'Smith', 'Joe', 'Male', NULL, '1970-1-1');


# Director
# Primary key id must be unique
# ERROR 1062 (23000) at line 25: Duplicate entry '1' for key 'PRIMARY'
INSERT INTO Director VALUES (1, 'Smith', 'Joe', 'Male', '1980-1-1', '1970-1-1'),(1, 'Smith', 'Joe', 'Male', '1980-1-1', '1970-1-1');

# Every director must have a date of birth.
# ERROR 1048 (23000) at line 28: Column 'dob' cannot be null
INSERT INTO Director VALUES (65536, 'Smith', 'Joe', 'Male', NULL, '1970-1-1');


# MovieGenre 
# mid must reference a valid row in the Movie table
# ERROR 1452 (23000): Cannot add or update a child row: a foreign key constraint fails (`CS143/MovieGenre`, CONSTRAINT `MovieGenre_ibfk_1` FOREIGN KEY (`mid`) REFERENCES `Movie` (`id`))
INSERT INTO MovieGenre VALUES (0, 'Comedy');


# MovieDirector
# mid must reference a valid movie id
# ERROR 1452 (23000) at line 41: Cannot add or update a child row: a foreign key constraint fails (`CS143`.`MovieDirector`, CONSTRAINT `MovieDirector_ibfk_1` FOREIGN KEY (`mid`) REFERENCES `Movie` (`id`))
INSERT INTO MovieDirector VALUES (0, 1);

# did must reference a valid director id
# ERROR 1452 (23000) at line 46: Cannot add or update a child row: a foreign key constraint fails (`CS143`.`MovieDirector`, CONSTRAINT `MovieDirector_ibfk_2` FOREIGN KEY (`did`) REFERENCES `Director` (`id`))
INSERT INTO MovieDirector VALUES (2, 0);


# MovieActor
# mid must reference a valid movie id
# ERROR 1452 (23000) at line 51: Cannot add or update a child row: a foreign key constraint fails (`CS143`.`MovieActor`, CONSTRAINT `MovieActor_ibfk_1` FOREIGN KEY (`mid`) REFERENCES `Movie` (`id`))
INSERT INTO MovieActor VALUES (0, 1, 'Lead Role');

# aid must reference a valid actor id
# ERROR 1452 (23000) at line 55: Cannot add or update a child row: a foreign key constraint fails (`CS143`.`MovieActor`, CONSTRAINT `MovieActor_ibfk_2` FOREIGN KEY (`aid`) REFERENCES `Actor` (`id`))
INSERT INTO MovieActor VALUES (2, 0, 'Lead Role');


# Review 
# mid must reference a valid movie id
INSERT INTO Review VALUES ('Bob Smith', 1390791191, 0, 4, 'Great movie!');

