<?php
  /* Script name: users_page */
  session_start();

  require_once "db_functions.php";
  require_once "global_vars.php";
  require_once "global_functions.php";

  if(!isset($_POST['submit'])) {
    include_once "users_page.php";
    exit();
  } else {
      $errors = [];

      foreach($_POST as $field => $value) {
         /* Checking for invalid and empty data */
         $value = trim($value);
         if (preg_match("/user_name/i", $field)) {
           if (!ereg("^[A-Za-z0-9].*", $value)) {
             $errors[] = "<b>$value</b> is not a valid user name.,";
           }
         }
         if ( preg_match("/full_name/i", $field)) {
           if (!ereg("^[A-Za-z\-].*", $value )) {
             $errors[] = "$value is not a valid name.";
           }
         }
         if (preg_match("/password/i", $field)) {
           if (strlen($value) < 8 ) {
             $errors[] = "Password must be 8 characters or more.,";
           }
         }
       }
      //  Extracting and sisplaying all the errors collected
       if ( @sizeof($errors) > 0) {
          $error_message = "";
          foreach($errors as $field => $value) {
            $error_message .= "<li><i class='fa-li fa fa-check-square'></i>".$value." Please try again </li>";
          }
          $_SESSION['message'] = $error_message;

          if (isset($_SESSION['update_user'])) {
            $_SESSION['id'] = $_POST['user_name'];
          }

          include_once "users_page.php";
          exit();
        } else {

          /* If the code gets here, it means the data is really clean */
          $db = new Database();
          $con = $db->connect_to_db();

          // This is an array that holds the keys of the wanted field names
          $field_names_array = $db->get_field_names($con, "users");

          switch ($_POST['submit']) {

            case "Add New User":

              $_POST['user_password'] = encryption($_POST['user_password'], $_POST['full_name']);
              $_POST['added_by'] = $_SESSION['full_name'];

              /* Removes unwanted field names that came from the form */
              $_POST = filter_array($_POST, $field_names_array);

              if (!$db->data_exists($con, "users", "user_name", $_POST['user_name'])) {
                // Actually save the data
                $save_data = $db->add_new($con, $_POST, "users");

                if ($save_data) {
                  include_once "users_page.php";  // If saving was possible open the student page for another entry
                } else {
                  $_SESSION['message'] = "<li><i class='fa-li fa fa-check-square'></i> ".SAVE_ERROR."</li>"; // Saving was not possible
                  include_once "users_page.php";
                }
              } else {
                $_SESSION['message'] = "<li><i class='fa-li fa fa-check-square'></i> User Name already exists </li>";
                include_once "users_page.php";
              }
              break;

            case 'Update User Details':
              // Encyprt the password being sent to the databse
              $_POST['user_password'] = encryption($_POST['user_password'], $_SESSION['full_name']);
              $_POST['edited_by'] = $_SESSION['full_name'];

              /* Removes unwanted field names that came from the form */
              $_POST = filter_array($_POST, $field_names_array);

              // Update the data
              $save_data = $db->update_data($con, $_POST, "users", "user_name", $_POST['user_name']);

              $_SESSION['full_name'] = $_POST['full_name'];
              unset($_SESSION['update_user']);
              // unset($_SESSION['id']);

              header("Location: index.php");
              break;

            default:
              # code...
              break;
          }

          // CLosing the database
          $db->close_connection($con);
        }
  }

?>
