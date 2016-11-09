#Give me the names of all the actors in the movie 'Die Another Day'.
SELECT CONCAT(first,' ',last)
FROM Movie M, MovieActor MA, Actor A
WHERE M.id = mid AND aid = A.id AND title = 'Die Another Day';

#Give me the count of all the actors who acted in multiple movies.
SELECT COUNT(DISTINCT MA1.aid)
FROM MovieActor MA1, MovieActor MA2
WHERE MA1.aid = MA2.aid AND MA1.mid > MA2.mid;

#Give me the count of all the directors who acted in multiple movies.
SELECT COUNT(DISTINCT MD1.did)
FROM MovieDirector MD1, MovieDirector MD2
WHERE MD1.did = MD2.did AND MD1.mid > MD2.mid;

