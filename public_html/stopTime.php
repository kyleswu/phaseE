<head><title>Stop Data Given Time Range</title></head>
<body>
<?php

    include 'open.php';

    $startTime = $_POST['startTime'];
    $endTime = $_POST['endTime'];

    $notWrappingTime = false;

    if (!empty($startTime) && !empty($endTime)) {
        echo "<h2>Stop data for the time range: ";
        echo $startTime;
        echo " to ";
        echo $endTime;
        echo "</h2><br>";

        if ($stmt = $conn->prepare("SELECT COUNT(stopID) AS numStops
                                    FROM Stop
                                    WHERE time >= CAST(? AS TIME) AND time <= CAST(? AS TIME);")) {
            
            $stmt->bind_param("ss", $startTime, $endTime);

            if($stmt->execute()) {
                
                $result = $stmt->get_result();

                if(($result) && ($result->num_rows != 0)) {
                    if ($row = $result->fetch_row()) {
                        if (($row[0])) {
                            echo "Total Stops: ";
                            echo $row[0];
                            echo "<br>";
                            $notWrappingTime = true;
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

        if ($stmt = $conn->prepare("SELECT COUNT(stopID) AS numStops
                                    FROM Stop
                                    WHERE searchConducted = 'true' AND
                                    time >= CAST(? AS TIME) AND time <= CAST(? AS TIME);")) {
            
            $stmt->bind_param("ss", $startTime, $endTime);

            if($stmt->execute()) {
                
                $result = $stmt->get_result();

                if(($result) && ($result->num_rows != 0)) {
                    if ($row = $result->fetch_row()) {
                        if (($row[0])) {
                            echo "Total Searches Conducted: ";
                            echo $row[0];
                            echo "<br>";
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

        if ($stmt = $conn->prepare("SELECT COUNT(stopID) AS numStops
                                    FROM Stop
                                    WHERE contrabandFound = 'true' AND
                                    time >= CAST(? AS TIME) AND time <= CAST(? AS TIME);")) {
            
            $stmt->bind_param("ss", $startTime, $endTime);

            if($stmt->execute()) {
                
                $result = $stmt->get_result();

                if(($result) && ($result->num_rows != 0)) {
                    if ($row = $result->fetch_row()) {
                        if (($row[0])) {
                            echo "Total Contraband Found: ";
                            echo $row[0];
                            echo "<br>";
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

        if ($stmt = $conn->prepare("SELECT COUNT(stopID) AS numStops
                                    FROM Stop
                                    WHERE citationIssued = 'true' AND
                                    time >= CAST(? AS TIME) AND time <= CAST(? AS TIME);")) {
            
            $stmt->bind_param("ss", $startTime, $endTime);

            if($stmt->execute()) {
                
                $result = $stmt->get_result();

                if(($result) && ($result->num_rows != 0)) {
                    if ($row = $result->fetch_row()) {
                        if (($row[0])) {
                            echo "Total Citations Issued: ";
                            echo $row[0];
                            echo "<br>";
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

        if ($stmt = $conn->prepare("SELECT COUNT(stopID) AS numStops
                                    FROM Stop
                                    WHERE warningIssued = 'true' AND
                                    time >= CAST(? AS TIME) AND time <= CAST(? AS TIME);")) {
            
            $stmt->bind_param("ss", $startTime, $endTime);

            if($stmt->execute()) {
                
                $result = $stmt->get_result();

                if(($result) && ($result->num_rows != 0)) {
                    if ($row = $result->fetch_row()) {
                        if (($row[0])) {
                            echo "Total Warnings Issued: ";
                            echo $row[0];
                            echo "<br>";
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

        if ($stmt = $conn->prepare("SELECT COUNT(stopID) AS numStops
                                    FROM Stop
                                    WHERE warningIssued = 'false' AND 
                                    citationIssued = 'false' AND 
                                   (contrabandFound ='false' OR contrabandFound IS NULL) AND
                                    time >= CAST(? AS TIME) AND time <= CAST(? AS TIME);")) {
            
            $stmt->bind_param("ss", $startTime, $endTime);

            if($stmt->execute()) {
                
                $result = $stmt->get_result();

                if(($result) && ($result->num_rows != 0)) {
                    if ($row = $result->fetch_row()) {
                        if (($row[0])) {
                            echo "Total Unnecessary Stops: ";
                            echo $row[0];
                            echo "<br>";
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

        if ((!$notWrappingTime) && $stmt = $conn->prepare("SELECT COUNT(stopID) AS numStops
                                                FROM Stop
                                                WHERE (time >= CAST(? AS TIME) OR time <= CAST(? AS TIME));")) {

            $stmt->bind_param("ss", $startTime, $endTime);

            if($stmt->execute()) {

                $result = $stmt->get_result();

                if(($result) && ($result->num_rows != 0)) {
                    if ($row = $result->fetch_row()) {
                        if (($row[0])) {
                            echo "Total Stops: ";
                            echo $row[0];
                            echo "<br>";
                        }
                    }
                } 

            $result->free_result();

            } else {
                echo "<div style='color: red;'>Execute failed.<div><br>";
            }

            $stmt->close();

        } else if (!$notWrappingTime) {
            echo "<div style ='color: red;'>Prepare failed.<br></div><br>";
            $error = $conn->errno . ' ' . $conn->error;
            echo $error; 
        } 

        if ((!$notWrappingTime) && $stmt = $conn->prepare("SELECT COUNT(stopID) AS numStops
                                    FROM Stop
                                    WHERE searchConducted = 'true' AND
                                    (time >= CAST(? AS TIME) OR time <= CAST(? AS TIME));")) {
            
            $stmt->bind_param("ss", $startTime, $endTime);

            if($stmt->execute()) {
                
                $result = $stmt->get_result();

                if(($result) && ($result->num_rows != 0)) {
                    if ($row = $result->fetch_row()) {
                        if (($row[0])) {
                            echo "Total Searches Conducted: ";
                            echo $row[0];
                            echo "<br>";
                        }
                    }
                } 

                $result->free_result();

            } else {
                echo "<div style='color: red;'>Execute failed.<div><br>";
            }

            $stmt->close();

        } else if (!$notWrappingTime) {
            echo "<div style ='color: red;'>Prepare failed.<br></div><br>";
            $error = $conn->errno . ' ' . $conn->error;
            echo $error; 
        }

        if ((!$notWrappingTime) && $stmt = $conn->prepare("SELECT COUNT(stopID) AS numStops
                                    FROM Stop
                                    WHERE contrabandFound = 'true' AND
                                    (time >= CAST(? AS TIME) OR time <= CAST(? AS TIME));")) {
            
            $stmt->bind_param("ss", $startTime, $endTime);

            if($stmt->execute()) {
                
                $result = $stmt->get_result();

                if(($result) && ($result->num_rows != 0)) {
                    if ($row = $result->fetch_row()) {
                        if (($row[0])) {
                            echo "Total Contraband Found: ";
                            echo $row[0];
                            echo "<br>";
                        }
                    }
                } 

                $result->free_result();

            } else {
                echo "<div style='color: red;'>Execute failed.<div><br>";
            }

            $stmt->close();

        } else if (!$notWrappingTime) {
            echo "<div style ='color: red;'>Prepare failed.<br></div><br>";
            $error = $conn->errno . ' ' . $conn->error;
            echo $error; 
        }

        if ((!$notWrappingTime) && $stmt = $conn->prepare("SELECT COUNT(stopID) AS numStops
                                    FROM Stop
                                    WHERE citationIssued = 'true' AND
                                    (time >= CAST(? AS TIME) OR time <= CAST(? AS TIME));")) {
            
            $stmt->bind_param("ss", $startTime, $endTime);

            if($stmt->execute()) {
                
                $result = $stmt->get_result();

                if(($result) && ($result->num_rows != 0)) {
                    if ($row = $result->fetch_row()) {
                        if (($row[0])) {
                            echo "Total Citations Issued: ";
                            echo $row[0];
                            echo "<br>";
                        }
                    }
                } 

                $result->free_result();

            } else {
                echo "<div style='color: red;'>Execute failed.<div><br>";
            }

            $stmt->close();

        } else if (!$notWrappingTime) {
            echo "<div style ='color: red;'>Prepare failed.<br></div><br>";
            $error = $conn->errno . ' ' . $conn->error;
            echo $error; 
        }

        if ((!$notWrappingTime) && $stmt = $conn->prepare("SELECT COUNT(stopID) AS numStops
                                    FROM Stop
                                    WHERE warningIssued = 'true' AND
                                    (time >= CAST(? AS TIME) OR time <= CAST(? AS TIME));")) {
            
            $stmt->bind_param("ss", $startTime, $endTime);

            if($stmt->execute()) {
                
                $result = $stmt->get_result();

                if(($result) && ($result->num_rows != 0)) {
                    if ($row = $result->fetch_row()) {
                        if (($row[0])) {
                            echo "Total Warnings Issued: ";
                            echo $row[0];
                            echo "<br>";
                        }
                    }
                } 

                $result->free_result();

            } else {
                echo "<div style='color: red;'>Execute failed.<div><br>";
            }

            $stmt->close();

        } else if (!$notWrappingTime) {
            echo "<div style ='color: red;'>Prepare failed.<br></div><br>";
            $error = $conn->errno . ' ' . $conn->error;
            echo $error; 
        }

        if ((!$notWrappingTime) && $stmt = $conn->prepare("SELECT COUNT(stopID) AS numStops
                                    FROM Stop
                                    WHERE warningIssued = 'false' AND 
                                    citationIssued = 'false' AND 
                                   (contrabandFound ='false' OR contrabandFound IS NULL) AND
                                    (time >= CAST(? AS TIME) OR time <= CAST(? AS TIME));")) {
            
            $stmt->bind_param("ss", $startTime, $endTime);

            if($stmt->execute()) {
                
                $result = $stmt->get_result();

                if(($result) && ($result->num_rows != 0)) {
                    if ($row = $result->fetch_row()) {
                        if (($row[0])) {
                            echo "Total Unnecessary Stops: ";
                            echo $row[0];
                            echo "<br>";
                        }
                    }
                } 

                $result->free_result();

            } else {
                echo "<div style='color: red;'>Execute failed.<div><br>";
            }

            $stmt->close();

        } else if (!$notWrappingTime) {
            echo "<div style ='color: red;'>Prepare failed.<br></div><br>";
            $error = $conn->errno . ' ' . $conn->error;
            echo $error; 
        }

        
    } else {
        echo "<div style='color: red;'>Please enter a start and end time for the range.</div><br>";
    }



    $conn->close();
?>