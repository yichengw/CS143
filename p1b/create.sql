CREATE TABLE Movie (
id int NOT NULL,
title varchar(100) NOT NULL,
year int,
rating varchar(10),
company varchar(50),
PRIMARY KEY(id),	#A movie must have a unique id
CHECK(LENGTH(title) > 0)	#every movie must have a title
)ENGINE=INNODB;

CREATE TABLE Actor (
id int NOT NULL,
last varchar(20),
first varchar(20),
sex varchar(6),
dob date,
dod date,
PRIMARY KEY(id),	#An actor must have a unique id
CHECK(dob IS NOT NULL),	#every actor must have a dob
CHECK(dod IS NULL OR dob < dod),	#every actor must either not have a dod or have a dod later than dob
CHECK((last IS NOT NULL AND LENGTH(last) > 0) or (first IS NOT NULL AND LENGTH(first) > 0)) #every actor must have a last/first name
)ENGINE=INNODB;

CREATE TABLE Director (
id int NOT NULL,
last varchar(20),
first varchar(20),
sex varchar(6),
dob date NOT NULL,
dod date,
PRIMARY KEY(id),	#A director must have a unique id
CHECK(dob IS NOT NULL),	#every director must have a dob
CHECK(dod IS NULL OR dob < dod),	#every director must either not have a dod or have a dod later than dob
CHECK((last IS NOT NULL AND LENGTH(last) > 0) or (first IS NOT NULL AND LENGTH(first) > 0))	#every director must have a last/first name
)ENGINE=INNODB;

CREATE TABLE MovieGenre (
mid int NOT NULL,
genre varchar(20),
FOREIGN KEY (mid) references Movie(id)	#A mid must reference a valid movie id
)ENGINE=INNODB;

CREATE TABLE MovieDirector (
mid int NOT NULL,
did int NOT NULL,
FOREIGN KEY (mid) references Movie(id),	#A mid must reference a valid movie id
FOREIGN KEY (did) references Director(id)	#A aid must reference a valid actor id
)ENGINE=INNODB;

CREATE TABLE MovieActor (
mid int NOT NULL,
aid int NOT NULL,
role varchar(50),
UNIQUE(mid, aid),	#mid and aid must be unique. No actor can have two roles in the same movie
FOREIGN KEY (mid) references Movie(id),	#A mid must reference a valid movie id
FOREIGN KEY (aid) references Actor(id)	#A aid must reference a valid actor id
)ENGINE=INNODB;

CREATE TABLE Review (
name varchar(20),
time timestamp,
mid int NOT NULL,
rating int,
comment varchar(500),
UNIQUE(name, time , mid),	#A review must have unique reviewer name, time and mid
FOREIGN KEY (mid) references Movie(id),	#A mid must reference a valid movie id
CHECK(rating >= 0 and rating <= 5)	#A rating's range is b/w 0 and 5
)ENGINE=INNODB;

CREATE TABLE MaxPersonID (
id int NOT NULL
)ENGINE=INNODB;

CREATE TABLE MaxMovieID (
id int NOT NULL
)ENGINE=INNODB;