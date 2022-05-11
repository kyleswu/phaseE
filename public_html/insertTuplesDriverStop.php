<head><title>Insert/Update Tuples into Driver and Stop</title></head>

<body>

<?php


    //open a connection to dbase server

        //this will require an updated conf.php with appropriate credentials

        include 'open.php';


    // collect the posted value in a variables

    $id = $_POST['id'];
    $race = $_POST['race'];
    $sex = $_POST['sex'];


    // proceed with query only if id is whole number and nonempty

    if (!empty($id) and is_numeric($id)) {
        //echo $id;


        // proceed with query only if supplied SID is valid
         
        $check = 'select Driver.driverID

                  from Driver

                  where Driver.driverID ="'.$id.'"';


        $check_result = $conn->query($check);

        if ($check_result -> num_rows < 1) {
            if ($result = $conn->query("CALL InsertTuplesDriverStop('".$id."','".$race."', '".$sex."');")) {
               echo "Inserted driverID: ".$id." !";
            }


        } else {

            // call the stored procedure we already defined on dbase
            if ($result = $conn->query("CALL InsertTuplesDriverStop('".$id."','".$race."', '".$sex."');")) {


            echo "Updated driverID ".$id." !";


            } else {
                  echo "Call to insertTuplesDriverStop failed<br>";
            }
        }
    } else if (!is_numeric($id)) {
        echo "DriverID needs to be a whole number<br>";
  } 


    //close the connection opened by open.php since we no longer need access to dbase

    $conn->close();

?>

</body>
