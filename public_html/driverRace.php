<head><title>Stop Data Given Race</title></head>
<body>
<?php

    include 'open.php';

    $race = $_POST['race'];

    echo "<h2>Stop Data for ";
    echo $race;
    echo "s</h2>";

    if ($stmt = $conn->prepare("SELECT COUNT(driverID)
                                   FROM Driver
                                   WHERE race = ?;")) {
            
            $stmt->bind_param("s", $race);

            if ($stmt->execute()) {

                $result = $stmt->get_result();

                if (($result) && ($result->num_rows != 0)) {
                    
                    if ($row = $result->fetch_row()) {
                        echo "Total stops: ";
                        echo $row[0];  
                    } else {
                        echo "<div style='color:red;'>No stops data for this race</div><br>";
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

        if ($stmt = $conn->prepare("SELECT COUNT(D.driverID)
                                   FROM Driver AS D JOIN Stop AS S ON D.driverID = S.stopID
                                   WHERE S.searchConducted = 'true' AND D.race = ?;")) {
            
            $stmt->bind_param("s", $race);

            if ($stmt->execute()) {

                $result = $stmt->get_result();

                if (($result) && ($result->num_rows != 0)) {
                    if ($row = $result->fetch_row()) {
                        echo "Total searches conducted: ";
                        echo $row[0];
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

        if ($stmt = $conn->prepare("SELECT COUNT(D.driverID)
                                   FROM Driver AS D JOIN Stop AS S ON D.driverID = S.stopID
                                   WHERE S.contrabandFound = 'true' AND D.race = ?;")) {
            
            $stmt->bind_param("s", $race);

            if ($stmt->execute()) {

                $result = $stmt->get_result();

                if (($result) && ($result->num_rows != 0)) {
                    if ($row = $result->fetch_row()) {
                        echo "Number of searches resulting in contraband found: ";
                        echo $row[0];
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

        if ($stmt = $conn->prepare("SELECT COUNT(D.driverID)
                                   FROM Driver AS D JOIN Stop AS S ON D.driverID = S.stopID
                                   WHERE S.citationIssued = 'true' AND D.race = ?;")) {
            
            $stmt->bind_param("s", $race);

            if ($stmt->execute()) {

                $result = $stmt->get_result();

                if (($result) && ($result->num_rows != 0)) {
                    if ($row = $result->fetch_row()) {
                        echo "Total citations issued: ";
                        echo $row[0];
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

        if ($stmt = $conn->prepare("SELECT COUNT(D.driverID)
                                   FROM Driver AS D JOIN Stop AS S ON D.driverID = S.stopID
                                   WHERE S.warningIssued = 'true' AND D.race = ?;")) {
            
            $stmt->bind_param("s", $race);

            if ($stmt->execute()) {

                $result = $stmt->get_result();

                if (($result) && ($result->num_rows != 0)) {
                    if ($row = $result->fetch_row()) {
                        echo "Total warnings issued: ";
                        echo $row[0];
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

        if ($stmt = $conn->prepare("SELECT COUNT(D.driverID)
                                   FROM Driver AS D JOIN Stop AS S ON D.driverID = S.stopID
                                   WHERE S.warningIssued = 'false' AND 
                                   S.citationIssued = 'false' AND 
                                   (S.contrabandFound ='false' OR S.contrabandFound IS NULL) 
                                   AND D.race = ?;")) {
            
            $stmt->bind_param("s", $race);

            if ($stmt->execute()) {

                $result = $stmt->get_result();

                if (($result) && ($result->num_rows != 0)) {
                    if ($row = $result->fetch_row()) {
                        echo "Total unnecessary stops: ";
                        echo $row[0];
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

        if ($stmt = $conn->prepare("SELECT S.stopID, S.date, S.time, S.searchConducted, S.contrabandFound, S.citationIssued, S.warningIssued
                                    FROM Driver AS D JOIN Stop AS S ON D.driverID = S.stopID
                                    WHERE D.race = ?
                                    LIMIT 100000;")) {

            $stmt->bind_param("s", $race);

            if ($stmt->execute()) {

                $result = $stmt->get_result();

                if (($result) && ($result->num_rows != 0)) {

                    echo "<table border=\"1px solid black\">";
                    echo "<tr><th> Stop ID </th> <th> Date </th><th> Time </th><th> Search Conducted </th><th> Contraband Found </th><th> Citation Issued </th><th> Warning Issued </th></tr>";

                    while ($row = $result->fetch_row()) {
                        echo "<tr>";
                        echo "<td>".$row[0]."</td>";
                        echo "<td>".$row[1]."</td>";
                        echo "<td>".$row[2]."</td>";
                        echo "<td>".$row[3]."</td>";
                        echo "<td>".$row[4]."</td>";
                        echo "<td>".$row[5]."</td>";
                        echo "<td>".$row[6]."</td>";
                        echo "</tr>";
                    }
                }

                $result->free_result();

            } else {
            echo "<div style='color: red;'>Execute failed.</div><br>";
            }

            $stmt->close();

        } else {
        echo "<div style ='color: red;'>Prepare failed.<br></div><br>";
        $error = $conn->errno . ' ' . $conn->error;
        echo $error; 
        }

    $conn->close();

?>