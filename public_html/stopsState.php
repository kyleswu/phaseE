<head><title>Aggregate and Individual Stops Data for a Given State</title></head>
<body>
<?php

    include 'open.php';

    $state = $_POST['state'];

    if (!empty($state)) {
        echo "<h2>Aggregate and Individual Stops Data for ";
        echo $state;
        echo "</h2>";

        if ($stmt = $conn->prepare("SELECT state, COUNT(stopID)
                                   FROM Stop
                                   WHERE state = ?;")) {
            
            $stmt->bind_param("s", $state);

            if ($stmt->execute()) {

                $result = $stmt->get_result();

                if (($result) && ($result->num_rows != 0)) {
                    if ($row = $result->fetch_row()) {
                        if ($row[0]) {
                            echo "Total stops: ";
                            echo $row[1];
                        } else {
                            echo "<div style='color:red;'>No stops data for this state</div><br>";
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


        if ($stmt = $conn->prepare("SELECT state, COUNT(stopID)
                                   FROM Stop
                                   WHERE searchConducted = 'true' AND state = ?;")) {
            
            $stmt->bind_param("s", $state);

            if ($stmt->execute()) {

                $result = $stmt->get_result();

                if (($result) && ($result->num_rows != 0)) {
                    if ($row = $result->fetch_row()) {
                        if ($row[0]) {
                            echo "Total searches conducted: ";
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

        if ($stmt = $conn->prepare("SELECT state, COUNT(stopID)
                                   FROM Stop
                                   WHERE contrabandFound = 'true' AND state = ?;")) {
            
            $stmt->bind_param("s", $state);

            if ($stmt->execute()) {

                $result = $stmt->get_result();

                if (($result) && ($result->num_rows != 0)) {
                    if ($row = $result->fetch_row()) {
                        if ($row[0]) {
                            echo "Number of searches resulting in contraband found: ";
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

        if ($stmt = $conn->prepare("SELECT state, COUNT(stopID)
                                   FROM Stop
                                   WHERE citationIssued = 'true' AND state = ?;")) {
            
            $stmt->bind_param("s", $state);

            if ($stmt->execute()) {

                $result = $stmt->get_result();

                if (($result) && ($result->num_rows != 0)) {
                    if ($row = $result->fetch_row()) {
                        if ($row[0]) {
                            echo "Total citations issued: ";
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

        if ($stmt = $conn->prepare("SELECT state, COUNT(stopID)
                                   FROM Stop
                                   WHERE warningIssued = 'true' AND state = ?;")) {
            
            $stmt->bind_param("s", $state);

            if ($stmt->execute()) {

                $result = $stmt->get_result();

                if (($result) && ($result->num_rows != 0)) {
                    if ($row = $result->fetch_row()) {
                        if ($row[0]) {
                            echo "Total warnings issued: ";
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

        if ($stmt = $conn->prepare("SELECT state, COUNT(stopID)
                                   FROM Stop
                                   WHERE warningIssued = 'false' AND 
                                   citationIssued = 'false' AND 
                                   (contrabandFound ='false' OR contrabandFound IS NULL) 
                                   AND state = ?;")) {
            
            $stmt->bind_param("s", $state);

            if ($stmt->execute()) {

                $result = $stmt->get_result();

                if (($result) && ($result->num_rows != 0)) {
                    if ($row = $result->fetch_row()) {
                        if ($row[0]) {
                            echo "Total unnecessary stops: ";
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

        if ($stmt = $conn->prepare("SELECT stopID, date, time, searchConducted, contrabandFound, citationIssued, warningIssued
                                    FROM Stop
                                    WHERE state = ?;")) {

            $stmt->bind_param("s", $state);

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

    } else {
        echo "<div style='color: red;'>Please enter a state.</div><br>";
    }

    $conn->close();
?>