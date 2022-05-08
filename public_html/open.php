<?php
	include 'conf.php';
$conn = new mysqli($dbhost, $dbuser, $dbpass, $dbname);
	if ($conn->connect_errno) {
   	echo("Connect failed: \n".$conn->connect_error);
    	exit();
	}
?>
