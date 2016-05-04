/*(1) Content Posting: Write a few (4 to 5) queries that users need to sign up, to create or edit their profiles, to post an image,
or to add a new entry to their diaries.
*/
/*sign up*/
INSERT INTO USERS VALUES (1, 'JACK2016', '123456', 'http://Techies.com/jack2016/');
INSERT INTO USERS VALUES (2, 'TOM2016', '123456', 'http://Techies.com/tom2016/');
INSERT INTO USERS VALUES (3, 'Kate2016', '123456', 'http://Techies.com/kate2016/');
INSERT INTO USERS VALUES (4, 'Mike2016', '123456', 'http://Techies.com/mike2016/');


/*create or edit profiles*/
INSERT INTO profile VALUES (1, 'JACK', 'GREEN', 18, '1100', 'WEST6',
                            'BROOKLYN', 'NY', 12345, 'I AM JACK', 'DATABASE LEARNER', 0, 1);

UPDATE profile SET  AGE = 19 WHERE profile_id = 1;

INSERT INTO profile VALUES (2, 'TOM', 'WHITE', 20, '1101', 'WEST6',
                            'QUEEN', 'NY', 12346, 'I AM TOM', 'ANDROID LEARNER', 0, 2);

INSERT INTO profile VALUES (3, 'KATE', 'BLACK', 21, '1102', 'WEST6',
                            'BROOKLYN','NY', 12347, 'I AM KATE', 'CLOUD COMPUTING LEARNER', 0, 3);

INSERT INTO profile VALUES (4, 'MIKE', 'BLUE', 22, '1103', 'WEST6',
                            'BROOKLYN','NY', 12348, 'I AM MIKE', 'JAVA LEARNER', 0, 4);

/*add a new entry to their diaries*/
INSERT INTO diary VALUES (1, 'JACK, NOTE FOR DB',
                          '2016-03-05 11:00:00', '2016-03-05 11:00:00', 1, 1);

INSERT INTO diary VALUES (2, 'TOM, NOTE FOR ANDROID',
                          '2016-03-06 11:00:00', '2016-03-06 11:00:00', 1, 2);

INSERT INTO diary VALUES (3, 'KATE, NOTE FOR CLOUD COMPUTING',
                          '2016-03-07 11:00:00', '2016-03-07 11:00:00', 1, 3);

INSERT INTO diary VALUES (4, 'MIKE, NOTE FOR JAVA',
                          '2016-03-08 11:00:00', '2016-03-08 11:00:00', 1, 4);




/*CREATE TABLE image(
  NAME TEXT,
  RASTER OID
);
SELECT lo_create(110);
SELECT lo_creat(-1);

INSERT INTO image(NAME, RASTER) VALUES('beautiful image', lo_import('/home/SPRING2016/jm6413/6jen84.jpg'));



SELECT lo_create(conn, 'desktop/gg.png') AS inv_oid;*/
