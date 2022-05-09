<?php

    include 'open.php';

    $state = $_POST['state'];

    echo "<h1>Statistics for States</h1>";
    echo "state: ";

    if (!empty($state)) {
        echo $state;
        echo "<br>";

        if ($stmt = $conn->prepare("SELECT year, licensedDrivers
                                    FROM TrafficStatistics
                                    WHERE state = ?;")) {
            
            $licensedDriverData = array();

            $stmt->bind_param("s", $state);
        
            if ($stmt->execute()) {
                
                $result = $stmt->get_result();

                if (($result) && ($result->num_rows != 0)) {
                    foreach($result as $row) {
                        array_push($licensedDriverData, array( "label"=> $row["year"], "y"=> $row["licensedDrivers"]));
                    }
                } else {
                    echo "<div style='color: red;'>No Licensed Driver Data found for the specified state</div><br>";
                }

                $result->free_result();
            } else {
                echo "<div style='color: red;'>Execute failed.</div><br>";
            }

            $stmt->close();
        } else {
            echo "<div style='color: red;'>Prepare failed.</div><br>";
            $error = $conn->errno . ' ' . $conn->error;
            echo $error;
        }

        if ($stmt = $conn->prepare("SELECT year, highwayFatalities
                                    FROM TrafficStatistics
                                    WHERE state = ?;")) {
            
            $highwayFatalitiesData = array();

            $stmt->bind_param("s", $state);
        
            if ($stmt->execute()) {
                $result = $stmt->get_result();

                if (($result) && ($result->num_rows != 0)) {
                    foreach($result as $row) {
                        array_push($highwayFatalitiesData, array( "label"=> $row["year"], "y"=> $row["highwayFatalities"]));
                    }
                } else {
                    echo "<div style='color: red;'>No Highway Fatalities Data found for the specified state</div><br>";
                }

                $result->free_result();
            } else {
                echo "<div style='color: red;'>Execute failed.</div><br>";
            }

            $stmt->close();
        } else {
            echo "<div style='color: red;'>Prepare failed.</div><br>";
            $error = $conn->errno . ' ' . $conn->error;
            echo $error;
        }


        if ($stmt = $conn->prepare("SELECT year, count(stopID) AS numStops
                                    FROM Stop
                                    WHERE state = ?
                                    GROUP BY year;")) {

            $stopsData = array();

            $stmt->bind_param("s", $state);

            if ($stmt->execute()) {
                $result = $stmt->get_result();

                if (($result) && ($result->num_rows != 0)) {
                    foreach($result as $row) {
                        array_push($stopsData, array( "label"=> $row["year"], "y"=> $row["numStops"]));
                    }
                } else {
                    echo "<div style='color: red;'>No Stops Data found for the specified state</div><br>";
                }

                $result->free_result();
            } else {
                echo "<div style='color: red;'>Execute failed.</div><br>";
            }

            $stmt->close();
        } else {
            echo "<div style='color: red;'>Prepare failed.</div><br>";
            $error = $conn->errno . ' ' . $conn->error;
            echo $error;
        }  

    } else {
        echo "<div style='color: red;'>No state was provided.</div><br>";
    }

    $conn->close();
?>

<html>
<head>  
<script>
window.onload = function () {
 
var chart1 = new CanvasJS.Chart("chartContainer1", {
	animationEnabled: true,
	exportEnabled: true,
	theme: "light2", // "light1", "light2", "dark1", "dark2"
	title:{
		text: "Number of Licensed Drivers by Year"
	},
	data: [{
		type: "line", //change type to bar, line, area, pie, etc  
		dataPoints: <?php echo json_encode($licensedDriverData, JSON_NUMERIC_CHECK); ?>
	}]
});
chart1.render();

var chart2 = new CanvasJS.Chart("chartContainer2", {
	animationEnabled: true,
	exportEnabled: true,
	theme: "light2", // "light1", "light2", "dark1", "dark2"
	title:{
		text: "Number of Highway Fatalities by Year"
	},
	data: [{
		type: "line", //change type to bar, line, area, pie, etc  
		dataPoints: <?php echo json_encode($highwayFatalitiesData, JSON_NUMERIC_CHECK); ?>
	}]
});
chart2.render();

var chart3 = new CanvasJS.Chart("chartContainer3", {
	animationEnabled: true,
	exportEnabled: true,
	theme: "light2", // "light1", "light2", "dark1", "dark2"
	title:{
		text: "Number of Police Stops by Year"
	},
	data: [{
		type: "line", //change type to bar, line, area, pie, etc  
		dataPoints: <?php echo json_encode($stopsData, JSON_NUMERIC_CHECK); ?>
	}]
});
chart3.render();
 
}
</script>
</head>
<body>
<br/><br/>
<div id="chartContainer1" style="height: 30%; width: 80%; padding: 10px; margin: auto;"></div>
<br/><br/>
<div id="chartContainer2" style="height: 30%; width: 80%; padding: 10px; margin: auto;"></div>
<br/><br/>
<div id="chartContainer3" style="height: 30%; width: 80%; padding: 10px; margin: auto;"></div>
<br/><br/>
<script src="https://canvasjs.com/assets/script/canvasjs.min.js"></script>
</body>
</html>   