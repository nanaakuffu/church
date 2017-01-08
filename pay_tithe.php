<?php
  /* Script name: pay_tithe */
  session_start();

  require_once "db_functions.php";
  require_once "global_vars.php";
  require_once "global_functions.php";

  if(!isset($_POST['submit'])) {
    include_once "tithe_page.php";
    exit();
  } else {
    $month_days = array("4", "6", "9", "11");         // An array to hold the 30-day months
    $errors = [];
    $current_date = date("l, j F, Y");
    $current_month = date("n", strtotime($current_date));
    $current_year = date("Y", strtotime($current_date));
    $new_time_stamp = strtotime($_POST['paid_year']."/".$_POST['paid_month']."/".$_POST['paid_day']);

    // var_dump($_POST);
    // echo date("Y-m-d", $new_time_stamp);

    foreach($_POST as $field => $value) {
       /* Checking for invalid and empty data */
      $value = trim($value);
      if ( $field == 'amount_paid' ) {
       if (!ereg("^[0-9\.].*", $value )) {
         $errors[] = "$value is not a valid amount.";
       }
      }

      //  if ($field == 'month_paid') {
      //    $current_month = date("n", time());
      //    $month_given = date("n", $new_time_stamp);
       //
      //    if ($month_given > $current_month) {
      //      $errors[] = "Payment month cannot be in the future.";
      //    }
      //  }

      if ($field == "paid_year") {
       if ($value > $current_year) {
         $errors[] = "Year cannot be in the future.";
       }
       if ($new_time_stamp > time()) {
         $errors[] = "Payment date cannot be in the future.";
       }
      }

      if ($field == "paid_day") {
       if ( is_element($month_days, $_POST['paid_month']) and (int)$value > 30) {
         $errors[] = "Month and day selected is not possible";
       } elseif ((int)$_POST['paid_year']%4 != 0 and $_POST['paid_month'] == "2" and (int)$value > 28) {
         $errors[] = "Month and day selected is not possible";
       } elseif ((int)$_POST['paid_year']%4 == 0 and $_POST['paid_month'] == "2" and (int)$value > 29) {
         $errors[] = "Month and day selected is not possible";
       }
      }
     }
    //  Extracting and sisplaying all the errors collected
     if ( @sizeof($errors) > 0) {
        $error_message = "";
        foreach($errors as $field => $value) {
          $error_message .= "<li><i class='fa-li fa fa-check-square'></i>".$value." Please try again </li>";
        }

        if (isset($_SESSION['update_tithe'])) {
          $_SESSION['t_id'] = $_POST['tithe_id'];
          $_SESSION['t_ref'] = $_POST['full_name'];
        }

        $_POST['date_paid'] = date("Y-m-d", $new_time_stamp);

        $_SESSION['message'] = $error_message;
        include_once "tithe_page.php";
        exit();
      } else {
        /* If the code gets here, it means the data is really clean */
        $db = new Database();

        $con = $db->connect_to_db();

        $SQL = "SELECT * FROM members";

        $result = mysqli_query($con, $SQL);

        $num_of_records = mysqli_num_rows($result);

        /* Assign values to fields like data_of_birth, student_number and full_name */
        $date_from_data = strtotime($_POST['paid_year']."/".$_POST['paid_month']."/".$_POST['paid_day']);
        $_POST['date_paid'] = date("Y-m-d", $date_from_data);

        // This is an array that holds the keys of the wanted field names
        $field_names_array = $db->get_field_names($con, "tithes");

        switch ($_POST['submit']) {
          case 'Add Tithe':

            /* Removes unwanted field names that came from the form */
            $_POST = filter_array($_POST, $field_names_array);

            // Actually save the data
            $save_data = $db->add_new($con, $_POST, "tithes");

            if ($save_data) {
              include_once "tithe_page.php";  // If saving was possible open the tithe page for another entry
            } else {
              echo SAVE_ERROR; // Saving was not possible
            }
            break;

          case 'Update Tithe':
            /* Removes unwanted field names that came from the form */
            $_POST = filter_array($_POST, $field_names_array);

            // Update the data
            $save_data = $db->update_data($con, $_POST, "tithes", "tithe_id", $_POST['tithe_id']);

            unset($_SESSION['update_tithe']);
            unset($_SESSION['update']);
            unset($_SESSION['t_id']);
            if (isset($_SESSION['back_home'])) {
              header("Location: index.php");
              unset($_SESSION['back_home']);
            } else {
              header("Location: view_tithe.php");
            }
            break;

          default:
            # code...
            break;
        }

        // Closing the database
        $db->close_connection($con);
      }
  }

?>
