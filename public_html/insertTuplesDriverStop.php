<head><title>Insert/Update Tuples into Driver and Stop</title></head>

<body>

<?php


    //open a connection to dbase server

        //this will require an updated conf.php with appropriate credentials

        include 'open.php';


    // collect the posted value in a variable called $studentID

    $item = $_POST['id'];
    $item2 = $_POST['race'];
    $item3 = $_POST['sex'];


    // proceed with query only if supplied SID is non-empty

        if (!empty($item) and is_numeric($item)) {
        //echo $item;


        // proceed with query only if supplied SID is valid
         
        $check = 'select Driver.driverID

                  from Driver

                  where Driver.driverID ="'.$item.'"';


        $check_result = $conn->query($check);

        if ($check_result -> num_rows < 1) {
            if ($result = $conn->query("CALL InsertTuplesDriverStop('".$item."','".$item2."', '".$item3."');")) {
               echo "Inserted driverID: ".$item." !";
            }


        } else {

            // call the stored procedure we already defined on dbase
            if ($result = $conn->query("CALL InsertTuplesDriverStop('".$item."','".$item2."', '".$item3."');")) {


            echo "Updated driverID ".$item." !";


            } else {
               if (!is_numeric($item)) {
                  echo "DriverID needs to be a whole number<br>";
               } else {
                  echo "Call to insertTuplesDriverStop failed<br>";
               }
            }
        }
    }


    //close the connection opened by open.php since we no longer need access to dbase

    $conn->close();

?>

</body>
