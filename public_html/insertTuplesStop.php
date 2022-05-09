<head><title>Insert/Update Tuples into Stop</title></head>

<body>

<?php


    //open a connection to dbase server

        //this will require an updated conf.php with appropriate credentials

        include 'open.php';


    // collect the posted value in a variable called $studentID
    $item0 = $_POST['state'];
    $item = $_POST['id'];
    $item2 = $_POST['date'];
    $item3 = $_POST['time'];
    $item4 = $_POST['year'];
    $item5 = $_POST['searchConducted'];
    $item6 = $_POST['contrabandFound'];
    $item7 = $_POST['citationIssued'];
    $item8 = $_POST['warningIssued'];


    // proceed with query only if supplied SID is non-empty

        if (!empty($item) and is_numeric($item)) {
        //echo $item;


        // proceed with query only if supplied SID is valid
         
        $check = 'select Stop.stopID

                  from Stop

                  where Stop.stopID ="'.$item.'"';


        $check_result = $conn->query($check);

        if ($check_result -> num_rows < 1) {
            if ($result = $conn->query("CALL InsertTuplesrStop('".$item0."','".$item."','".$item2."', '".$item3."','".$item4."','".$item5."', '".$item6."','".$item7."', '".$item8."');")) {
               echo "Inserted stopID: ".$item." !";
            }


        } else {

            // call the stored procedure we already defined on dbase
            echo "test";
            if ($result = $conn->query("CALL InsertTuplesrStop('".$item0."','".$item."','".$item2."', '".$item3."','".$item4."','".$item5."', '".$item6."','".$item7."', '".$item8."');")) {

            echo "Updated stopID ".$item." !";


            } else {
               if (!is_numeric($item)) {
                  echo "stopID needs to be a whole number<br>";
               } else {
                  echo "Call to insertTuplesStop failed<br>";
               }
            }
        }
    }


    //close the connection opened by open.php since we no longer need access to dbase

    $conn->close();

?>

</body>
