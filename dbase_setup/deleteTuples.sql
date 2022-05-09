DROP PROCEDURE IF EXISTS deleteTuples;

DELIMITER //


CREATE PROCEDURE deleteTuples(IN id INT)
BEGIN
-- IF EXISTS(SELECT * FROM Passwords WHERE Passwords.CurPasswords = pass) THEN
    DELETE FROM Stop WHERE stopID = id;  
-- ELSE
-- SELECT 'Error: Invalid password' AS pass;
-- END IF;
END; //

DELIMITER ;
