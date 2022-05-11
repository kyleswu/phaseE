<head><title>Data Compared By Partisanship</title></head>
<body>
<?php

    include 'open.php';

    echo "<h2>Comparing Data by Partisanship</h2>";

    if ($stmt = $conn->prepare("SELECT compareCounts.party, FORMAT(compareCounts.numParty/totalCount.numTotal*100, 2) AS percentages
                                FROM 
                                (SELECT P.party, SUM(TS.highwayFatalities) AS numParty
                                FROM Partisanship AS P JOIN TrafficStatistics AS TS ON P.state = TS.state AND (P.year = TS.year OR P.year + 1 = TS.year)
                                GROUP BY party) AS compareCounts
                                JOIN
                                (SELECT SUM(TS.highwayFatalities) AS numTotal
                                FROM Partisanship AS P JOIN TrafficStatistics AS TS 
                                ON P.state = TS.state AND (P.year = TS.year OR P.year + 1 = TS.year)) AS totalCount;")) {
                                                                
        $compareHighwayFatalities = array();

        if ($stmt->execute()) {
            
            $result = $stmt->get_result();

            if (($result) && ($result->num_rows != 0)) {
                foreach($result as $row) {
                    
                    array_push($compareHighwayFatalities, array( "label"=> $row["party"], "y"=> $row["percentages"]));
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
    
    if ($stmt = $conn->prepare("SELECT compareCounts.party, FORMAT(compareCounts.numParty/totalCount.numTotal*100, 2) AS percentages
                                FROM 
                                (SELECT P.party, COUNT(S.stopID) AS numParty
                                FROM Partisanship AS P JOIN Stop AS S ON P.state = S.state AND (P.year = S.year OR P.year + 1 = S.year)
                                WHERE S.searchConducted = 'true'
                                GROUP BY party) AS compareCounts
                                JOIN
                                (SELECT COUNT(stopID) AS numTotal
                                FROM Partisanship AS P JOIN Stop AS S ON P.state = S.state AND (P.year = S.year OR P.year + 1 = S.year)
                                WHERE searchConducted = 'true') AS totalCount;")) {
                                    
        $compareSearchConducted = array();

        if ($stmt->execute()) {
            
            $result = $stmt->get_result();

            if (($result) && ($result->num_rows != 0)) {
                foreach($result as $row) {
                    
                    array_push($compareSearchConducted, array( "label"=> $row["party"], "y"=> $row["percentages"]));
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

    if ($stmt = $conn->prepare("SELECT compareCounts.party, FORMAT(compareCounts.numParty/totalCount.numTotal*100, 2) AS percentages
                                FROM 
                                (SELECT P.party, COUNT(S.stopID) AS numParty
                                FROM Partisanship AS P JOIN Stop AS S ON P.state = S.state AND (P.year = S.year OR P.year + 1 = S.year)
                                WHERE S.warningIssued = 'false' AND 
                                S.citationIssued = 'false' AND 
                                (S.contrabandFound = 'false' OR S.contrabandFound IS NULL)
                                GROUP BY party) AS compareCounts
                                JOIN
                                (SELECT COUNT(stopID) AS numTotal
                                FROM Partisanship AS P JOIN Stop AS S ON P.state = S.state AND (P.year = S.year OR P.year + 1 = S.year)
                                WHERE S.warningIssued = 'false' AND 
                                S.citationIssued = 'false' AND 
                                (S.contrabandFound = 'false' OR S.contrabandFound IS NULL)) AS totalCount;")) {
                                    
        $compareUnnecessaryStops = array();

        if ($stmt->execute()) {
            
            $result = $stmt->get_result();

            if (($result) && ($result->num_rows != 0)) {
                foreach($result as $row) {
                    
                    array_push($compareUnnecessaryStops, array( "label"=> $row["party"], "y"=> $row["percentages"]));
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
		text: "Percentage Composition of Highway Fatalities"
	},
	data: [{
		type: "pie",
		yValueFormatString: "#,##0.00\"%\"",
		indexLabel: "{label} ({y})",
		dataPoints: <?php echo json_encode($compareHighwayFatalities, JSON_NUMERIC_CHECK); ?>
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