/*(3) Browse/SearchQueries:Write a few different queries that a user could use when accessing content in your system.
 For example, a user might want to see all profiles or diary entries by his friends , or by his FOFs,
 or by anyone that contain certain keywords. A user may want a list of all diary entries by his friends
 during the last week. A user may want to add a greeting or comment to another user’s page,
 or search all greetings posted by her friends anywhere, or by others at her friends’ pages.*/

/*VIEW FOR ALL FRIENDS*/
CREATE VIEW friend_of_1 AS (
  SELECT accept_id as user_id
  FROM friendship
  WHERE request_id=1
  UNION (SELECT request_id as user_id
  FROM friendship
  WHERE accept_id=1)
);

/*ALL PROFILES OF FRIENDS*/
SELECT *
FROM profile
WHERE publicity_level < 3 AND user_id IN (
  SELECT user_id
  FROM friend_of_1
  );

/*ALL DIARIES OF FRIENDS*/
SELECT *
FROM diary
WHERE publicity_level < 3 AND user_id IN (
  SELECT user_id
  FROM friend_of_1
);

/*VIEW FOR FOF*/
CREATE VIEW fof_of_2 AS (
  (SELECT accept_id AS user_id
  FROM friendship
  WHERE request_id IN (SELECT user_id FROM friend_of_2))
  UNION
  (SELECT request_id AS user_id
  FROM friendship
  WHERE accept_id IN (SELECT user_id FROM friend_of_2))
  EXCEPT (SELECT user_id FROM users WHERE user_id=2)
);

/*ALL PROFILES OF FOF*/
SELECT *
FROM profile
WHERE publicity_level < 2 AND user_id IN (
  SELECT user_id
  FROM fof_of_2
);

/*ALL DIARIES OF FOF*/
SELECT *
FROM diary
WHERE publicity_level < 3 AND user_id IN (
  SELECT user_id
  FROM fof_of_2
);

/*ALL DIARIES WHOSE TITLE CONTAINING SOME KEY WORDS */
CREATE VIEW diary_id_search_keywords as (
  SELECT DISTINCT diary_id, title
  FROM diary
  WHERE title LIKE '%DB%' AND
        ((publicity_level <= 2
         AND user_id IN (SELECT user_id
                          FROM friend_of_2)
        ) OR
        (publicity_level <= 1
         AND user_id IN (SELECT user_id
                          FROM fof_of_2)
        ) OR
        publicity_level = 0)
);

/*a list of all diary entries by his friends during the last week*/
  SELECT diary_id, title
  FROM diary
  WHERE user_id IN (SELECT user_id FROM friend_of_1)
    AND (diary.create_timestamp > now()::TIMESTAMP - INTERVAL '7 day'
         OR diary.last_update_timestamp > now()::TIMESTAMP - INTERVAL '7 day');

/*ADD COMMENTS TO OTHER USERS PAGE*/
INSERT INTO greeting VALUES(1, 'Hello TOM! I am JACK', 0, 1, 2);
INSERT INTO greeting VALUES(2, 'Hello JACK! I am TOM', 0, 2, 1);
INSERT INTO greeting VALUES(3, 'Hello TOM! I am JACK', 0, 2, 4);
INSERT INTO greeting VALUES(4, 'Hello JACK! I am TOM', 0, 3, 2);
/*search all greetings posted by her friends anywhere, or by others at her friends’ pages*/

SELECT id, body
FROM greeting
WHERE (from_user_id IN (SELECT user_id FROM friend_of_1)) OR (to_user_id IN (SELECT user_id FROM friend_of_1));
