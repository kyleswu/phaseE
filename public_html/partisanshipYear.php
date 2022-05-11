<head><title>Partisanship Data (Year)</title></head>
<body>
<?php

    include 'open.php';

    $year = $_POST['year'];

    if (!empty($year)) {
        echo "<h2>Partisanship Data for ";
        echo $year;
        echo "<br>";

        if (($year % 2) !== 0) {
            $year -= 1;
        }
        
        if ($stmt = $conn->prepare("SELECT state, party
                                    FROM Partisanship
                                    WHERE year = ?;")) {
            
            $stmt->bind_param("i", $year);

            if($stmt->execute()) {
                
                $result = $stmt->get_result();

                if(($result) && ($result->num_rows != 0)) {
                    
                    echo "<table border=\"1px solid black\">";
                    echo "<tr><th> State </th> <th> Party </th></tr>";

                    while ($row = $result->fetch_row()) {
                        echo "<tr>";
                        echo "<td>".$row[0]."</td>";
                        echo "<td>".$row[1]."</td>";
                        echo "</tr>";
                    }

                } else {
                    echo "<div style='color:red;'>No partisanship data for this year<div><br>";
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

        echo "<br><br>";

        if ($stmt = $conn->prepare("SELECT party, COUNT(state) AS numStates
                                    FROM Partisanship
                                    WHERE year = ?
                                    GROUP BY party;")) {

            $countData = array();

            $stmt->bind_param("i", $year);

            if ($stmt->execute()) {

                $result = $stmt->get_result();

                if (($result) && ($result->num_rows != 0)) {
                    foreach($result as $row) {
                        array_push($countData, array( "label"=> $row["party"], "y"=> $row["numStates"]));
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
        echo "<div style='color: red;'>Please enter a year.</div><br>";
    }

    $conn->close();
?>
<html>
<head>
<script>
window.onload = function() {
 
 
var chart = new CanvasJS.Chart("chartContainer", {
	animationEnabled: true,
	title: {
		text: "Number of States for each Party"
	},
	data: [{
		type: "pie",
		indexLabel: "{label} ({y})",
		dataPoints: <?php echo json_encode($countData, JSON_NUMERIC_CHECK); ?>
	}]
});
chart.render();
 
}
</script>
</head>
<body>
<div id="chartContainer" style="height: 370px; width: 100%;"></div>
<script src="https://canvasjs.com/assets/script/canvasjs.min.js"></script>
</body>
</html>   