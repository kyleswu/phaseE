-- setup.sql

-- cleanup
DROP TABLE IF EXISTS Partisanship;
DROP TABLE IF EXISTS TrafficStatistics;
DROP TABLE IF EXISTS Driver;
DROP TABLE IF EXISTS Stop;
DROP TABLE IF EXISTS Passwords;

-- Describe schema for relation Partisanship
CREATE TABLE Partisanship (
        state VARCHAR(20),
        year SMALLINT,
        party VARCHAR(10),
        PRIMARY KEY(state, year),
        CHECK(year>=1776)
);

-- Loading data from partisanship.txt into Partisanship
LOAD DATA LOCAL INFILE './input-text-files/partisanship.txt'
INTO TABLE Partisanship
FIELDS TERMINATED BY ','
LINES TERMINATED BY '\n';

-- Describe schema for relation TrafficStatistics
CREATE TABLE TrafficStatistics (
        state VARCHAR(20),
        year SMALLINT,
        highwayFatalities INT,
        licensedDrivers INT,
        PRIMARY KEY(state, year),
        CHECK (highwayfatalities >= 0 AND licenseddrivers >= 0)
);

-- Loading data from trafficstatistics.txt into TrafficStatistics
LOAD DATA LOCAL INFILE './input-text-files/trafficstatistics.txt'
INTO TABLE TrafficStatistics
FIELDS TERMINATED BY ','
LINES TERMINATED BY '\n';

-- Describe schema for relation Stop
CREATE TABLE Stop (
        state VARCHAR(20),
        stopID INT,
        date DATE,
        time TIME,
        searchConducted VARCHAR(20),
        contrabandFound VARCHAR(20),
        citationIssued VARCHAR(20),
        warningIssued VARCHAR(20),
        PRIMARY KEY(stopID)
);

-- Loading data from stop.txt into Stop
LOAD DATA LOCAL INFILE './input-text-files/stop.csv'
INTO TABLE Stop
FIELDS TERMINATED BY ','
LINES TERMINATED BY '\n';

ALTER TABLE Stop
ADD year SMALLINT;

UPDATE Stop
SET year = YEAR(date);

-- Describe schema for relation Driver
CREATE TABLE Driver (
        driverID INT,
        race VARCHAR(20),
        sex VARCHAR(20),
        PRIMARY KEY(driverID),
        FOREIGN KEY(driverID) REFERENCES Stop(stopID)
        ON DELETE CASCADE ON UPDATE CASCADE
);

-- Loading data from driver-small.txt into Driver
LOAD DATA LOCAL INFILE './input-text-files/driver.csv'
INTO TABLE Driver
FIELDS TERMINATED BY ','
LINES TERMINATED BY '\n';

DROP PROCEDURE IF EXISTS InsertTuplesDriverStop;

DELIMITER //


CREATE PROCEDURE InsertTuplesDriverStop(IN id INT, r VARCHAR(20), s VARCHAR(20))
BEGIN
    IF EXISTS (SELECT * FROM Driver WHERE driverID = id) THEN
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
    END IF;
END; //

DELIMITER ;

DROP PROCEDURE IF EXISTS InsertTuplesStop;

DELIMITER //


CREATE PROCEDURE InsertTuplesStop(IN st VARCHAR(20), id INT, d DATE, t TIME, y SMALLINT, sc VARCHAR(20), cf VARCHAR(20), ci VARCHAR(20), wi VARCHAR(20))
BEGIN
    IF EXISTS (SELECT * FROM Stop WHERE stopID = id) THEN
        UPDATE Stop AS S
        SET S.state = st, S.date = d, S.time = t, S.year = y, S.searchconducted = sc, S.contrabandfound = cf, S.citationissued = ci, S.warningIssued = wi
        WHERE stopID = id;
    ELSE
        INSERT INTO Stop(
            state, stopID, date, time, year, searchconducted, contrabandfound, citationissued, warningIssued)
            VALUES(st, id, d, t, y, sc, cf, ci, wi);
    END IF;
END; //

DELIMITER ;

DROP PROCEDURE IF EXISTS deleteTuples;

DELIMITER //


CREATE PROCEDURE deleteTuples(IN id INT)
BEGIN
    DELETE FROM Stop WHERE stopID = id;  
END; //

DELIMITER ;
