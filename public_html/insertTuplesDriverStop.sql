DROP PROCEDURE IF EXISTS InsertTuplesDriverStop;

DELIMITER //


CREATE PROCEDURE InsertTuplesDriver(IN id INT, r VARCHAR(20), s VARCHAR(20))

BEGIN
IF EXISTS (SELECT * FROM Driver WHERE driverID = @driverID) THEN
    UPDATE Driver
    SET race = r, sex = s
    WHERE driverID = id;
ELSE
    SET FOREIGN_KEY_CHECKS = 0;
        INSERT INTO Driver(
            driverID, race, sex)
            VALUES(id, r, s);

        INSERT INTO Stop (stopID)
        SELECT Driver.driverID FROM Driver
        LEFT JOIN Stop
          ON Driver.driverID = Stop.stopID
        WHERE Stop.stopID IS NULL;

        SET FOREIGN_KEY_CHECKS = 1;

        UPDATE Stop
        SET state = NULL, date = NULL, time = NULL, searchconducted = NULL,
            contrabandfound = NULL, citationissued = NULL, warningIssued = NULL, year = NULL
        WHERE stopID = id AND state IS null AND date IS null AND time IS null AND searchconducted IS null AND contrabandfound IS NULL
            AND citationissued IS NULL AND warningIssued IS NULL AND year IS NULL;


-- IF EXISTS(SELECT * FROM HW4_Password WHERE HW4_Password.CurPasswords = pass) THEN
-- SELECT S.sid, S.lname, S.fname, S.sec, A.aname, R.score
-- FROM HW4_Student as S
-- NATURAL JOIN HW4_RawScore as R
-- NATURAL JOIN HW4_Assignment AS A
-- ORDER BY S.Sec ASC, S.lname ASC, S.fname ASC;

-- ELSE
-- SELECT 'Error: Invalid password' AS pass;
END IF;
END; //

DELIMITER ;
