<head><title>Stop Data Compared by Driver Race</title></head>
<body>
<?php

    include 'open.php';

    echo "<h2>Comparing Stop Data by Driver Race</h2>";

    if ($stmt = $conn->prepare("SELECT compareCounts.race, FORMAT(compareCounts.numRace/totalCount.numTotal*100, 2) AS percentages
                                FROM 
                                (SELECT race, COUNT(driverID) AS numRace
                                FROM Driver
                                WHERE !ISNULL(race)
                                GROUP BY race) AS compareCounts
                                JOIN 
                                (SELECT COUNT(driverID) AS numTotal
                                FROM Driver) AS totalCount;")) {
        
        $compareTotalData = array();

        if ($stmt->execute()) {
            
            $result = $stmt->get_result();

            if (($result) && ($result->num_rows != 0)) {
                foreach($result as $row) {
                    
                    array_push($compareTotalData, array( "label"=> $row["race"], "y"=> $row["percentages"]));
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

    if ($stmt = $conn->prepare("SELECT compareCounts.race, FORMAT(compareCounts.numRace/totalCount.numTotal*100, 2) AS percentages
                                FROM 
                                (SELECT D.race, COUNT(driverID) AS numRace
                                FROM Driver AS D JOIN Stop AS S ON D.driverID = S.stopID
                                WHERE !ISNULL(D.race) AND S.searchConducted='true'
                                GROUP BY race) AS compareCounts
                                JOIN 
                                (SELECT COUNT(driverID) AS numTotal
                                FROM Driver AS D JOIN Stop AS S ON D.driverID = S.stopID
                                WHERE S.searchConducted = 'true') AS totalCount;")) {
        
        $compareSearchConducted = array();

        if ($stmt->execute()) {
            
            $result = $stmt->get_result();

            if (($result) && ($result->num_rows != 0)) {
                foreach($result as $row) {
                    
                    array_push($compareSearchConducted, array( "label"=> $row["race"], "y"=> $row["percentages"]));
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

    if ($stmt = $conn->prepare("SELECT compareCounts.race, FORMAT(compareCounts.numRace/totalCount.numTotal*100, 2) AS percentages
                                FROM 
                                (SELECT D.race, COUNT(driverID) AS numRace
                                FROM Driver AS D JOIN Stop AS S ON D.driverID = S.stopID
                                WHERE !ISNULL(D.race) AND S.warningIssued = 'false' AND 
                                S.citationIssued = 'false' AND 
                                (S.contrabandFound = 'false' OR S.contrabandFound IS NULL)
                                GROUP BY race) AS compareCounts
                                JOIN 
                                (SELECT COUNT(driverID) AS numTotal
                                FROM Driver AS D JOIN Stop AS S ON D.driverID = S.stopID
                                WHERE S.warningIssued = 'false' AND 
                                S.citationIssued = 'false' AND 
                                (S.contrabandFound ='false' OR S.contrabandFound IS NULL)) AS totalCount;")) {

        $compareUnnecessaryStops = array();

        if ($stmt->execute()) {

            $result = $stmt->get_result();

            if (($result) && ($result->num_rows != 0)) {
                foreach($result as $row) {
                    array_push($compareUnnecessaryStops, array( "label"=> $row["race"], "y"=> $row["percentages"]));
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
<html>
<head>
<script>
window.onload = function() {
 
 
var chart1 = new CanvasJS.Chart("chartContainer1", {
	animationEnabled: true,
    theme: "light2",
	title: {
		text: "Percentage Composition of Total Stops"
	},
	data: [{
		type: "pie",
		yValueFormatString: "#,##0.00\"%\"",
		indexLabel: "{label} ({y})",
		dataPoints: <?php echo json_encode($compareTotalData, JSON_NUMERIC_CHECK); ?>
	}]
});
chart1.render();

var chart2 = new CanvasJS.Chart("chartContainer2", {
	animationEnabled: true,
    theme: "light2",
	title: {
		text: "Percentage Composition of Total Searches Conducted"
	},
	data: [{
		type: "pie",
		yValueFormatString: "#,##0.00\"%\"",
		indexLabel: "{label} ({y})",
		dataPoints: <?php echo json_encode($compareSearchConducted, JSON_NUMERIC_CHECK); ?>
	}]
});
chart2.render();

var chart3 = new CanvasJS.Chart("chartContainer3", {
	animationEnabled: true,
    theme: "light2",
	title: {
		text: "Percentage Composition of Total Unnecessary Stops"
	},
	data: [{
		type: "pie",
		yValueFormatString: "#,##0.00\"%\"",
		indexLabel: "{label} ({y})",
		dataPoints: <?php echo json_encode($compareUnnecessaryStops, JSON_NUMERIC_CHECK); ?>
	}]
});
chart3.render();
 
}
</script>
</head>
<body>
<div id="chartContainer1" style="height: 370px; width: 100%;"></div>
<div id="chartContainer2" style="height: 370px; width: 100%;"></div>
<div id="chartContainer3" style="height: 370px; width: 100%;"></div>
<script src="https://canvasjs.com/assets/script/canvasjs.min.js"></script>
</body>
</html>     