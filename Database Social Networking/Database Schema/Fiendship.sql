/* (2) Friendship: Write queries that users can use to add or accept someone as their friend,
to list all their current friends, or all their FOFs.*/

INSERT INTO friendship VALUES (1, 2, '2016-03-11 12:00:00', FALSE, 0);

UPDATE FRIENDSHIP SET successful=TRUE
WHERE request_id = 1 AND accept_id = 2;

/*LIST ALL FRIENDS OF USER WITH ID 1*/
(SELECT request_id as user_id
FROM friendship
WHERE accept_id=1)
UNION
(SELECT accept_id as user_id
FROM  friendship
WHERE request_id=1);

/*LIST ALL FOF*/
CREATE VIEW friend_of_2 AS
(SELECT request_id as user_id
FROM friendship
WHERE accept_id=2)
UNION
(SELECT accept_id as user_id
FROM  friendship
WHERE request_id=2);

(SELECT request_id as user_id
FROM friendship
WHERE accept_id IN (SELECT user_id FROM friend_of_2))
UNION (SELECT accept_id as user_id
    FROM friendship
    WHERE request_id IN (SELECT user_id FROM friend_of_2))
EXCEPT (SELECT user_id
    FROM users
    WHERE user_id=2);