<?php
    session_start();

    require_once("db_functions.php");
    require_once("global_vars.php");
    require_once("global_functions.php");

    if (isset($_POST['submit_aux']) ) {
        $error = "";
        foreach ($_POST as $key => $value) {
          /* Check for wrong data */
          $value = trim($value);
          if (preg_match("/type/i", $key) ) {
            if (!ereg("^[A-Za-z1-9].*", $value)) {
              $error .= "Some characters in $value does not seem to be valid.,";
            }
          }
        }

        /* Extract the various errors collected */
        if (strlen($error) > 0) {
          $errors = explode(",", $error);
          $message = "";
          foreach ($errors as $key => $value) {
            $message .= $value." Please try again.<br>";
          }
          $_SESSION['message'] = $message;
          // extract($_POST);
          include_once 'auxilliaries.php';
          exit();
        } else {
          $db = new Database();
          $con = $db->connect_to_db();



          switch ($_POST['submit_aux']) {
            case 'Add Currency':
              unset($_POST['submit_aux']);
              $save_data = $db->add_new($con, $_POST, 'currency');
              break;

            case 'Add Status':
              unset($_POST['submit_aux']);
              $save_data = $db->add_new($con, $_POST, 'status');
              break;

            default:
              # code...
              break;
          }

          if ($save_data) {
            include_once "auxilliaries.php";
          }
          $db->close_connection($con);
        }
      } else {
        include_once "auxilliaries.php";
        exit();
      }
?>
