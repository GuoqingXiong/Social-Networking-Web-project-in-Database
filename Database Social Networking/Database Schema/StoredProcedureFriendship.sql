/*add or accept someone as their friend*/
CREATE OR REPLACE FUNCTION request_friend(USER_ID INTEGER, FRIEND_USER_ID INTEGER)
  RETURNS VOID AS $$
BEGIN
  INSERT INTO friendship VALUES (USER_ID, FRIEND_USER_ID, NOW(), FALSE, 0);
END;
$$ LANGUAGE 'plpgsql' VOLATILE ;

CREATE OR REPLACE FUNCTION accept_friend(USER_ID INTEGER, FRIEND_USER_ID INTEGER)
  RETURNS VOID AS $$
BEGIN
  UPDATE friendship SET timestamp=NOW(), successful=TRUE  WHERE request_id=FRIEND_USER_ID AND accept_id=USER_ID;
END;
$$ LANGUAGE 'plpgsql' VOLATILE ;

CREATE OR REPLACE FUNCTION delete_friend(USER_ID INTEGER, FRIEND_USER_ID INTEGER)
  RETURNS VOID AS $$
BEGIN
  DELETE FROM friendship
  WHERE (request_id=FRIEND_USER_ID AND accept_id=USER_ID) OR (request_id=USER_ID AND accept_id=FRIEND_USER_ID);
END;
$$ LANGUAGE 'plpgsql' VOLATILE ;

SELECT request_friend(1, 4);
SELECT accept_friend(4, 1);
SELECT delete_friend(1, 4);
SELECT * FROM friendship;
/*LIST ALL FRIENDS OF USER WITH ID 1*/
CREATE OR REPLACE FUNCTION list_friends(IN_USER_ID BIGINT) RETURNS SETOF BIGINT AS
$$
BEGIN
  RETURN QUERY
  (SELECT request_id as FRIEND_ID
  FROM friendship
  WHERE accept_id=IN_USER_ID and SUCCESSFUL=TRUE )
  UNION
  (SELECT accept_id as FRIEND_ID
  FROM  friendship
  WHERE request_id=IN_USER_ID and SUCCESSFUL=TRUE);
END
$$
LANGUAGE 'plpgsql' STABLE;

SELECT list_friends(1) AS FRIEND_ID;

/*LIST ALL FOF*/
CREATE OR REPLACE FUNCTION list_fof(IN_USER_ID BIGINT) RETURNS SETOF BIGINT AS
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

SELECT list_fof(2);

