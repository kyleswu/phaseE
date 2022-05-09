<head><title>Delete tuples</title></head>

<body>

<?php


    //open a connection to dbase server

        //this will require an updated conf.php with appropriate credentials

        include 'open.php';


    // collect the posted value in a variable called $studentID
    $item = $_POST['id'];


    // proceed with query only if supplied SID is non-empty

        if (!empty($item) and is_numeric($item)) {
        //echo $item;


        // proceed with query only if supplied SID is valid
         
        $check = 'select Stop.stopID

                  from Stop

                  where Stop.stopID ="'.$item.'"';


        $check_result = $conn->query($check);

        if ($check_result -> num_rows < 1) {
               echo "ID ".$item." does not exist!";
        } else {
            if ($result = $conn->query("CALL deleteTuples('".$item."');")) {

            echo "Deleted stopID ".$item." !";


            } else {
               if (!is_numeric($item)) {
                  echo "ID needs to be a whole number<br>";
               } else {
                  echo "Call to deleteTuples failed<br>";
               }
            }
        }
    }


    //close the connection opened by open.php since we no longer need access to dbase

    $conn->close();

?>

</body>
