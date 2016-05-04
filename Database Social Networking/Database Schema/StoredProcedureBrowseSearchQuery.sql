/*(3) Browse/SearchQueries:Write a few different queries that a user could use when accessing content in your system.
 For example, a user might want to see all profiles or diary entries by his friends , or by his FOFs,
 or by anyone that contain certain keywords. A user may want a list of all diary entries by his friends
 during the last week. A user may want to add a greeting or comment to another user’s page,
 or search all greetings posted by her friends anywhere, or by others at her friends’ pages.*/

/*ALL PROFILES OF FRIENDS*/
CREATE OR REPLACE FUNCTION list_friends(IN_USER_ID INTEGER) RETURNS SETOF INTEGER AS
$$
BEGIN
  RETURN QUERY
  (SELECT request_id as FRIEND_ID
  FROM friendship
  WHERE accept_id=IN_USER_ID)
  UNION
  (SELECT accept_id as FRIEND_ID
  FROM  friendship
  WHERE request_id=IN_USER_ID);
END
$$
LANGUAGE 'plpgsql' STABLE;

CREATE OR REPLACE FUNCTION list_friend_profile(IN_USER_ID INTEGER)
  RETURNS SETOF profile AS $$
BEGIN
  RETURN QUERY
  (SELECT * FROM profile
  WHERE publicity_level <= 2 AND user_id IN ( SELECT * FROM list_friends(IN_USER_ID)));
END;
$$ LANGUAGE 'plpgsql' STABLE ;

/*ALL DIARIES OF FRIENDS*/
CREATE OR REPLACE FUNCTION list_friend_diary(IN_USER_ID INTEGER)
  RETURNS SETOF diary AS $$
BEGIN
  RETURN QUERY
  (SELECT * FROM diary
  WHERE publicity_level <= 2 AND user_id IN ( SELECT * FROM list_friends(IN_USER_ID)));
END;
$$ LANGUAGE 'plpgsql' STABLE ;

/*ALL PROFILES OF FOF*/
CREATE OR REPLACE FUNCTION list_fof(IN_USER_ID INTEGER) RETURNS SETOF INTEGER AS
$$
BEGIN
RETURN QUERY
(SELECT request_id as FOF_ID FROM friendship
WHERE accept_id IN (SELECT * FROM list_friends(IN_USER_ID)))
UNION
(SELECT accept_id as FOF_ID FROM friendship
WHERE request_id IN (SELECT * FROM list_friends(IN_USER_ID)))
EXCEPT
(SELECT user_id FROM users WHERE user_id=IN_USER_ID);
END
$$
LANGUAGE 'plpgsql' STABLE;

CREATE OR REPLACE FUNCTION list_fof_profile(IN_USER_ID INTEGER)
  RETURNS SETOF profile AS $$
BEGIN
  RETURN QUERY
  (SELECT * FROM profile
  WHERE publicity_level <= 1 AND user_id IN ( SELECT * FROM list_fof(IN_USER_ID)));
END;
$$ LANGUAGE 'plpgsql' STABLE ;

/*ALL DIARIES OF FOF*/
CREATE OR REPLACE FUNCTION list_fof_diary(IN_USER_ID INTEGER)
  RETURNS SETOF diary AS $$
BEGIN
  RETURN QUERY
  (SELECT * FROM diary
  WHERE publicity_level <= 1 AND user_id IN ( SELECT * FROM list_fof(IN_USER_ID)));
END;
$$ LANGUAGE 'plpgsql' STABLE ;


/*ALL DIARIES WHOSE TITLE CONTAINING SOME KEY WORDS */
CREATE OR REPLACE FUNCTION search_diary_with_keyword(IN_USER_ID INTEGER, kewword TEXT)
  RETURNS SETOF diary AS $$
BEGIN
  RETURN QUERY
  SELECT DISTINCT *
  FROM diary
  WHERE title LIKE '%' || kewword || '%' AND
        (
          user_id = IN_USER_ID OR
          diary_id IN (SELECT diary_id
                       FROM list_friend_diary(IN_USER_ID))
          OR diary_id IN (SELECT diary_id
                          FROM list_fof_diary(IN_USER_ID))
          OR publicity_level = 0
        );
END;
$$ LANGUAGE 'plpgsql';

/*a list of all diary entries by his friends during the last week*/
CREATE OR REPLACE FUNCTION list_friend_diary_last_week(IN_USER_ID INTEGER)
  RETURNS SETOF diary AS $$
BEGIN
  RETURN QUERY
  SELECT DISTINCT * FROM list_friend_diary(IN_USER_ID)
  WHERE last_update_timestamp > NOW() :: TIMESTAMP - INTERVAL '7 day';
END;
$$ LANGUAGE 'plpgsql';

/*ADD COMMENTS TO OTHER USERS PAGE*/
CREATE OR REPLACE FUNCTION add_comment_to_other_page(IN_BODY TEXT, IN_PUBLICITY_LEVEL INTEGER, IN_FROM_USER_ID INTEGER, IN_TO_USER_ID INTEGER)
  RETURNS VOID AS $$
BEGIN
  INSERT INTO greeting VALUES (DEFAULT , IN_BODY, IN_PUBLICITY_LEVEL, IN_FROM_USER_ID, IN_TO_USER_ID);
END;
$$ LANGUAGE 'plpgsql';

/*search all greetings posted by her friends anywhere, or by others at her friends’ pages*/
CREATE OR REPLACE FUNCTION list_all_greetings_from_friend_or_to_friend(IN_USER_ID INTEGER)
  RETURNS SETOF greeting AS $$
BEGIN
  RETURN QUERY
  SELECT * FROM greeting
  WHERE (from_user_id IN (SELECT * FROM list_friends(IN_USER_ID))) OR (to_user_id IN (SELECT * FROM list_friends(IN_USER_ID)));
END;
$$ LANGUAGE 'plpgsql';

