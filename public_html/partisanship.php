<head><title>Partisanship Data</title></head>
<body>
<?php

    include 'open.php';

    $year = $_POST['year'];

    echo "<h2>Partisanship Data for ";
    echo $year;
    echo "<br>";

    $conn->close();
?>