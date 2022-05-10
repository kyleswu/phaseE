<head><title>Stop Data Given Sex</title></head>
<body>
<?php

    include 'open.php';

    $sex = $_POST['sex'];

    echo "<h2>Stop Data for ";
    echo $sex;
    echo "s</h2>";

    if ($stmt = $conn->prepare("SELECT COUNT(driverID)
                                   FROM Driver
                                   WHERE sex = ?;")) {
            
            $stmt->bind_param("s", $sex);

            if ($stmt->execute()) {

                $result = $stmt->get_result();

                if (($result) && ($result->num_rows != 0)) {
                    
                    if ($row = $result->fetch_row()) {
                        echo "Total stops: ";
                        echo $row[0];  
                    } else {
                        echo "<div style='color:red;'>No stops data for this sex</div><br>";
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
                                   WHERE S.searchConducted = 'true' AND D.sex = ?;")) {
            
            $stmt->bind_param("s", $sex);

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
                                   WHERE S.contrabandFound = 'true' AND D.sex = ?;")) {
            
            $stmt->bind_param("s", $sex);

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
                                   WHERE S.warningIssued = 'true' AND D.sex = ?;")) {
            
            $stmt->bind_param("s", $sex);

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
                                   WHERE S.citationIssued = 'true' AND D.sex = ?;")) {
            
            $stmt->bind_param("s", $sex);

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
                                   WHERE S.warningIssued = 'false' AND 
                                   S.citationIssued = 'false' AND 
                                   (S.contrabandFound ='false' OR S.contrabandFound IS NULL) 
                                   AND D.sex = ?;")) {
            
            $stmt->bind_param("s", $sex);

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

    $conn->close();

?>