DROP PROCEDURE IF EXISTS InsertTuplesStop;

DELIMITER //


CREATE PROCEDURE InsertTuplesStop(IN st VARCHAR(20), id INT, d DATE, t TIME, y SMALLINT, sc VARCHAR(20), cf VARCHAR(20), ci VARCHAR(20), wi VARCHAR(20))
BEGIN
-- IF EXISTS(SELECT * FROM Passwords WHERE Passwords.CurPasswords = pass) THEN
    IF EXISTS (SELECT * FROM Stop WHERE stopID = id) THEN
        UPDATE Stop AS S
        SET S.state = st, S.date = d, S.time = t, S.year = y, S.searchconducted = sc, S.contrabandfound = cf, S.citationissued = ci, S.warningIssued = wi
        WHERE stopID = id;
    ELSE
        INSERT INTO Stop(
            state, stopID, date, time, year, searchconducted, contrabandfound, citationissued, warningIssued)
            VALUES(st, id, d, t, y, sc, cf, ci, wi);


-- IF EXISTS(SELECT * FROM HW4_Password WHERE HW4_Password.CurPasswords = pass) THEN
-- SELECT S.sid, S.lname, S.fname, S.sec, A.aname, R.score
-- FROM HW4_Student as S
-- NATURAL JOIN HW4_RawScore as R
-- NATURAL JOIN HW4_Assignment AS A
-- ORDER BY S.Sec ASC, S.lname ASC, S.fname ASC;

-- ELSE
-- SELECT 'Error: Invalid password' AS pass;
    END IF;
-- ELSE
-- SELECT 'Error: Invalid password' AS pass;
-- END IF;
END; //

DELIMITER ;
