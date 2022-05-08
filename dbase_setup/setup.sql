-- setup.sql

-- cleanup
DROP TABLE IF EXISTS Partisanship;
DROP TABLE IF EXISTS TrafficStatistics;
DROP TABLE IF EXISTS Driver;
DROP TABLE IF EXISTS Stop;

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