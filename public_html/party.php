<head><title>Data Given State Partisanship</title></head>
<body>
<?php

    include 'open.php';

    $party = $_POST['party'];
    $year = $_POST['year'];

    if (!empty($year)) {
        echo "<h2>Data for ";
        echo $party;
        echo " majority in ";
        echo $year;
        echo "</h2>";

        if ($stmt = $conn->prepare("SELECT SUM(TS.highwayFatalities) AS totalHighwayFatalities, SUM(TS.licensedDrivers) AS totalLicensedDrivers
                                    FROM Partisanship AS P JOIN TrafficStatistics AS TS ON P.state = TS.state AND (P.year = TS.year OR P.year + 1 = TS.year)
                                    WHERE P.party = ? AND TS.year = ?;")) {
            
            $stmt->bind_param("si", $party, $year);

            if($stmt->execute()) {
                
                $result = $stmt->get_result();

                if(($result) && ($result->num_rows != 0)) {
                    if ($row = $result->fetch_row()) {
                        if (($row[0]) && ($row[1])) {
                            echo "Total Highway Fatalities: ";
                            echo $row[0];
                            echo "<br>";

                            echo "Total Licensed Drivers: ";
                            echo $row[1];
                            echo "<br>";
                        } else {
                            echo "<div style='color:red;'>No traffic statistics data for this year</div><br>";
                        }
                    }
                } 

                $result->free_result();

            } else {
                echo "<div style='color: red;'>Execute failed.<div><br>";
            }

            $stmt->close();

        } else {
            echo "<div style ='color: red;'>Prepare failed.<br></div><br>";
            $error = $conn->errno . ' ' . $conn->error;
            echo $error; 
        }

        if ($stmt = $conn->prepare("SELECT P.party, COUNT(S.stopID)
                                    FROM Partisanship AS P JOIN Stop AS S ON P.state = S.state AND (P.year = S.year OR P.year + 1 = S.year)
                                    WHERE P.party = ? AND S.year = ?;")) {
            
            $stmt->bind_param("si", $party, $year);

            if($stmt->execute()) {
                
                $result = $stmt->get_result();

                if(($result) && ($result->num_rows != 0)) {
                    if ($row = $result->fetch_row()) {
                        if (($row[0])) {
                            echo "Total Stops: ";
                            echo $row[1];
                        } else {
                            echo "<div style='color:red;'>No stops data for this year</div><br>";
                        }
                    }
                } 

                $result->free_result();

            } else {
                echo "<div style='color: red;'>Execute failed.<div><br>";
            }

            $stmt->close();

        } else {
            echo "<div style ='color: red;'>Prepare failed.<br></div><br>";
            $error = $conn->errno . ' ' . $conn->error;
            echo $error; 
        }

        echo "<br>";

        if ($stmt = $conn->prepare("SELECT P.party, COUNT(S.stopID)
                                    FROM Partisanship AS P JOIN Stop AS S ON P.state = S.state AND (P.year = S.year OR P.year + 1 = S.year)
                                    WHERE S.searchConducted = 'true' AND P.party = ? AND S.year = ?;")) {
            
            $stmt->bind_param("si", $party, $year);

            if($stmt->execute()) {
                
                $result = $stmt->get_result();

                if(($result) && ($result->num_rows != 0)) {
                    if ($row = $result->fetch_row()) {
                        if (($row[0])) {
                            echo "Total Searches Conducted: ";
                            echo $row[1];
                        }
                    }
                } 

                $result->free_result();

            } else {
                echo "<div style='color: red;'>Execute failed.<div><br>";
            }

            $stmt->close();

        } else {
            echo "<div style ='color: red;'>Prepare failed.<br></div><br>";
            $error = $conn->errno . ' ' . $conn->error;
            echo $error; 
        }

        echo "<br>";

        if ($stmt = $conn->prepare("SELECT P.party, COUNT(S.stopID)
                                    FROM Partisanship AS P JOIN Stop AS S ON P.state = S.state AND (P.year = S.year OR P.year + 1 = S.year)
                                    WHERE S.contrabandFound = 'true' AND P.party = ? AND S.year = ?;")) {
            
            $stmt->bind_param("si", $party, $year);

            if($stmt->execute()) {
                
                $result = $stmt->get_result();

                if(($result) && ($result->num_rows != 0)) {
                    if ($row = $result->fetch_row()) {
                        if (($row[0])) {
                            echo "Total Contraband Found: ";
                            echo $row[1];
                        }
                    }
                } 

                $result->free_result();

            } else {
                echo "<div style='color: red;'>Execute failed.<div><br>";
            }

            $stmt->close();

        } else {
            echo "<div style ='color: red;'>Prepare failed.<br></div><br>";
            $error = $conn->errno . ' ' . $conn->error;
            echo $error; 
        }

        echo "<br>";

        if ($stmt = $conn->prepare("SELECT P.party, COUNT(S.stopID)
                                    FROM Partisanship AS P JOIN Stop AS S ON P.state = S.state AND (P.year = S.year OR P.year + 1 = S.year)
                                    WHERE S.citationIssued = 'true' AND P.party = ? AND S.year = ?;")) {
            
            $stmt->bind_param("si", $party, $year);

            if($stmt->execute()) {
                
                $result = $stmt->get_result();

                if(($result) && ($result->num_rows != 0)) {
                    if ($row = $result->fetch_row()) {
                        if (($row[0])) {
                            echo "Total Citations Issued: ";
                            echo $row[1];
                        }
                    }
                } 

                $result->free_result();

            } else {
                echo "<div style='color: red;'>Execute failed.<div><br>";
            }

            $stmt->close();

        } else {
            echo "<div style ='color: red;'>Prepare failed.<br></div><br>";
            $error = $conn->errno . ' ' . $conn->error;
            echo $error; 
        }

        echo "<br>";

        if ($stmt = $conn->prepare("SELECT P.party, COUNT(S.stopID)
                                    FROM Partisanship AS P JOIN Stop AS S ON P.state = S.state AND (P.year = S.year OR P.year + 1 = S.year)
                                    WHERE S.warningIssued = 'true' AND P.party = ? AND S.year = ?;")) {
            
            $stmt->bind_param("si", $party, $year);

            if($stmt->execute()) {
                
                $result = $stmt->get_result();

                if(($result) && ($result->num_rows != 0)) {
                    if ($row = $result->fetch_row()) {
                        if (($row[0])) {
                            echo "Total Warnings Issued: ";
                            echo $row[1];
                        }
                    }
                } 

                $result->free_result();

            } else {
                echo "<div style='color: red;'>Execute failed.<div><br>";
            }

            $stmt->close();

        } else {
            echo "<div style ='color: red;'>Prepare failed.<br></div><br>";
            $error = $conn->errno . ' ' . $conn->error;
            echo $error; 
        }

        echo "<br>";

        if ($stmt = $conn->prepare("SELECT P.party, COUNT(S.stopID)
                                    FROM Partisanship AS P JOIN Stop AS S ON P.state = S.state AND (P.year = S.year OR P.year + 1 = S.year)
                                    WHERE S.warningIssued = 'false' AND 
                                    S.citationIssued = 'false' AND 
                                   (S.contrabandFound ='false' OR S.contrabandFound IS NULL) AND 
                                    P.party = ? AND S.year = ?;")) {
            
            $stmt->bind_param("si", $party, $year);

            if($stmt->execute()) {
                
                $result = $stmt->get_result();

                if(($result) && ($result->num_rows != 0)) {
                    if ($row = $result->fetch_row()) {
                        if (($row[0])) {
                            echo "Total Unnecessary Stops ";
                            echo $row[1];
                        }
                    }
                } 

                $result->free_result();

            } else {
                echo "<div style='color: red;'>Execute failed.<div><br>";
            }

            $stmt->close();

        } else {
            echo "<div style ='color: red;'>Prepare failed.<br></div><br>";
            $error = $conn->errno . ' ' . $conn->error;
            echo $error; 
        }

        echo "<br>";

    } else {
        echo "<div style='color: red;'>Please enter a year.</div><br>";
    }
    

    $conn->close();
?>