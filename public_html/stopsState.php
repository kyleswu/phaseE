<head><title>Aggregate and Individual Stops Data for a Given State</title></head>
<body>
<?php

    include 'open.php';

    $state = $_POST['state'];

    if (!empty($state)) {
        echo "<h2>Aggregate and Individual Stops Data for ";
        echo $state;
        echo "</h2><br>";

        if ($stmt = $conn->prepare("SELECT COUNT(stopID) AS numStops
                                   FROM Stop
                                   WHERE state = ?;")) {
            
            $stmt->bind_param("s", $state);

            if ($stmt->execute()) {

                $result = $stmt->get_result();

                if (($result) && ($result->num_rows != 0)) {
                    if ($row = $result->fetch_row()) {
                        echo "Total stops: ";
                        echo $row[0];
                    }

                } else {
                    echo "<div style='color:red;'>No Stops data for this state<div><br>";
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
        echo "<div style='color: red;'>Please enter a state.</div><br>";
    }

    $conn->close();
?>