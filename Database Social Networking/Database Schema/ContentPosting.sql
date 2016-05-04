/*(1) Content Posting: Write a few (4 to 5) queries that users need to sign up, to create or edit their profiles, to post an image,
or to add a new entry to their diaries.
*/
/*sign up*/
INSERT INTO USERS VALUES (12, 'gx267', '123456', 'http://Techies.com/jack2016/');


/*create or edit profiles*/
INSERT INTO profile VALUES (1, 'JACK', 'GREEN', 18, '1100', 'WEST6',
                            'BROOKLYN', 'NY', 12345, 'I AM JACK', 'DATABASE LEARNER', 0, 1);

UPDATE profile SET  AGE = 19 WHERE profile_id = 1;


/*add a new entry to their diaries*/
INSERT INTO diary VALUES (1, 'JACK, NOTE FOR DB',
                          '2016-03-05 11:00:00', '2016-03-05 11:00:00', 1, 1);
