<head><title>Stop Data Given Date Range</title></head>
<body>
<?php

    include 'open.php';

    $startDate = $_POST['startDate'];
    $endDate = $_POST['endDate'];

    if (!empty($startDate) && !empty($endDate)) {
        echo "<h2>Stop data for the date range: ";
        echo $startDate;
        echo " to ";
        echo $endDate;
        echo "</h2><br>";

        if ($stmt = $conn->prepare("SELECT COUNT(stopID) AS numStops
                                    FROM Stop
                                    WHERE date >= CAST(? AS DATE) AND date <= CAST(? AS DATE);")) {
            
            $stmt->bind_param("ss", $startDate, $endDate);

            if($stmt->execute()) {
                
                $result = $stmt->get_result();

                if(($result) && ($result->num_rows != 0)) {
                    if ($row = $result->fetch_row()) {
                        if (($row[0])) {
                            echo "Total Stops: ";
                            echo $row[0];
                            echo "<br>";
                        } else {
                            echo "<div style='color: red;'>No data found for this range (please make sure the start date occurs before the end date)<div><br>";
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
                                    date >= CAST(? AS DATE) AND date <= CAST(? AS DATE);")) {
            
            $stmt->bind_param("ss", $startDate, $endDate);

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
                                    date >= CAST(? AS DATE) AND date <= CAST(? AS DATE);")) {
            
            $stmt->bind_param("ss", $startDate, $endDate);

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
                                    date >= CAST(? AS DATE) AND date <= CAST(? AS DATE);")) {
            
            $stmt->bind_param("ss", $startDate, $endDate);

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
                                    date >= CAST(? AS DATE) AND date <= CAST(? AS DATE);")) {
            
            $stmt->bind_param("ss", $startDate, $endDate);

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
                                    date >= CAST(? AS DATE) AND date <= CAST(? AS DATE);")) {
            
            $stmt->bind_param("ss", $startDate, $endDate);

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


    } else {
        echo "<div style='color: red;'>Please enter a start and end date for the range.</div><br>";
    }

    $conn->close();
?>