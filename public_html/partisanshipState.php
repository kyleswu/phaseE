<head><title>Partisanship Data (State)</title></head>
<body>
<?php

    include 'open.php';

    $state = $_POST['state'];

    if (!empty($state)) {
        echo "<h2>Partisanship Data for ";
        echo $state;
        echo "</h2><br>";
        if ($stmt = $conn->prepare("SELECT year, party
                                    FROM Partisanship
                                    WHERE state = ?;")) {
            
            $stmt->bind_param("s", $state);

            if ($stmt->execute()) {
                
                $result = $stmt->get_result();

                if (($result) && ($result->num_rows != 0)) {
                    
                    echo "<table border=\"1px solid black\">";
                    echo "<tr><th> Year </th> <th> Party </th></tr>";

                    while ($row = $result->fetch_row()) {
                        echo "<tr>";
                        echo "<td>".$row[0]."</td>";
                        echo "<td>".$row[1]."</td>";
                        echo "</tr>";
                    }

                } else {
                    echo "<div style='color:red;'>No partisanship data for this state</div><br>";
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