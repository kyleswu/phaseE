<head><title>Insert/Update Tuples into Stop</title></head>

<body>

<?php


    //open a connection to dbase server

        //this will require an updated conf.php with appropriate credentials

        include 'open.php';


    // collect the posted value in a variable called $studentID
    $state = $_POST['st'];
    $id = $_POST['id'];
    $date = $_POST['d'];
    $time = $_POST['t'];
    $year = (int) date("Y", strtotime($date));
    $searchConducted = $_POST['sc'];
    $contrabandFound = $_POST['cf'];
    $citationIssued = $_POST['ci'];
    $warningIssued = $_POST['wi'];

    $entered_date = new DateTime($date);
    $today = new DateTime('now');
    if ($entered_date > $today) {
        echo "Error: Date: ".$date." cannot be in the future!";
    }


    // proceed with query only if supplied SID is non-empty

        else if (!empty($id) and is_numeric($id)) {
        //echo $id;


        // proceed with query only if supplied SID is valid
         
        $check = 'select Stop.stopID

                  from Stop

                  where Stop.stopID ="'.$id.'"';


        $check_result = $conn->query($check);

        if ($check_result -> num_rows < 1) {
            if ($result = $conn->query("CALL InsertTuplesStop('".$state."','".$id."','".$date."', '".$time."','".$year."','".$searchConducted."', '".$contrabandFound."','".$citationIssued."', '".$warningIssued."');")) {
               echo "Inserted stopID: ".$id." !";
            }


        } else {

            // call the stored procedure we already defined on dbase
            if ($result = $conn->query("CALL InsertTuplesStop('".$state."','".$id."','".$date."', '".$time."','".$year."','".$searchConducted."', '".$contrabandFound."','".$citationIssued."', '".$warningIssued."');")) {

            echo "Updated stopID ".$id." !";


            } else {
                echo "Call to insertTuplesStop failed<br>";
            }
        }
    } else if (!is_numeric($id)) {
        echo "stopID needs to be a whole number<br>";
     } 


    //close the connection opened by open.php since we no longer need access to dbase

    $conn->close();

?>

</body>
