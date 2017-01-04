<?php

    require_once "db_functions.php";

    $db = new Database();
    $con = $db->connect_to_db();

    $choice = mysqli_real_escape_string($con, $_GET['choice']);
    $query = "SELECT first_name, last_name FROM members WHERE church_number='$choice'";

    // echo $query;

    $result = mysqli_query($con, $query);
    $record_count = mysqli_num_rows($result);

    if ($record_count > 0 ){
        while ($row = mysqli_fetch_array($result)) {

            echo $row['first_name']." ".$row['last_name'];
        }
    } else {
      echo "";
    }

    $db->close_connection($con);

?>
