<head><title>Stop Data Given Time Range</title></head>
<body>
<?php

    include 'open.php';

    $startTime = $_POST['startTime'];
    $endTIme = $_POST['endTime'];

    echo "<h2>Stop data for the time range ";
    echo $startTime;
    echo " to ";
    echo $endTime;

    $conn->close();
?>