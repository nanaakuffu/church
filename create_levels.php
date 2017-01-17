<?php
    session_start();

    require_once("db_functions.php");
    require_once("global_vars.php");
    require_once("global_functions.php");

    // We use this to activate any user for this system....
    if (isset($_POST['add_access'])) {
      // Open database connection
      $db = new Database();
      $con = $db->connect_to_db();

      $_POST['is_admin'] = (isset($_POST['is_admin'])) ? $_POST['is_admin'] : 0 ;
      $_POST['can_backup_data'] = (isset($_POST['can_backup_data'])) ? $_POST['can_backup_data'] : 0 ;
      $_POST['can_add_member'] = (isset($_POST['can_add_member'])) ? $_POST['can_add_member'] : 0 ;
      $_POST['can_edit_member'] = (isset($_POST['can_edit_member'])) ? $_POST['can_edit_member'] : 0 ;
      $_POST['can_delete_member'] = (isset($_POST['can_delete_member'])) ? $_POST['can_delete_member'] : 0 ;
      $_POST['can_add_tithe'] = (isset($_POST['can_add_tithe'])) ? $_POST['can_add_tithe'] : 0 ;
      $_POST['can_edit_tithe'] = (isset($_POST['can_edit_tithe'])) ? $_POST['can_edit_tithe'] : 0 ;
      $_POST['can_delete_tithe'] = (isset($_POST['can_delete_tithe'])) ? $_POST['can_delete_tithe'] : 0 ;
      $_POST['can_add_attendance'] = (isset($_POST['can_add_attendance'])) ? $_POST['can_add_attendance'] : 0 ;
      $_POST['can_edit_attendance'] = (isset($_POST['can_edit_attendance'])) ? $_POST['can_edit_attendance'] : 0 ;
      $_POST['can_delete_attendance'] = (isset($_POST['can_delete_attendance'])) ? $_POST['can_delete_attendance'] : 0 ;
      $_POST['can_create_user'] = (isset($_POST['can_create_user'])) ? $_POST['can_create_user'] : 0 ;
      $_POST['can_delete_user'] = (isset($_POST['can_delete_user'])) ? $_POST['can_delete_user'] : 0 ;
      $_POST['can_set_user_privelege'] = (isset($_POST['can_set_user_privelege'])) ? $_POST['can_set_user_privelege'] : 0 ;

      // This is an array that holds the keys of the wanted field names
      $field_names_array = $db->get_field_names($con, "priveleges");

      switch ($_POST['add_access']) {
        case 'Add Access':
          /* Removes unwanted field names that came from the form */
          $_POST = filter_array($_POST, $field_names_array);

          $save_data = $db->add_new($con, $_POST, "priveleges");

          if ($save_data) {
            header("Location: display_users.php");
          } else {
            echo SAVE_ERROR; // Saving was not possible
          }
          break;

        case 'Update':
          /* Removes unwanted field names that came from the form */
          $_POST = filter_array($_POST, $field_names_array);

          if (isset($_SESSION['update_access'])) {
            $save_data = $db->update_data($con, $_POST, "priveleges", "user_name", $_POST['user_name']);
          }

          if ($save_data) {
            if (isset($_SESSION['update_access'])) {
              unset($_SESSION['update_access']);
              unset($_SESSION['user_id']);
            }
            header("Location: display_users.php");
          } else {
            echo SAVE_ERROR; // Saving was not possible
          }

          break;

        case 'Delete':
          /* Removes unwanted field names that came from the form */
          $_POST = filter_array($_POST, $field_names_array);

          $delete_data = $db->delete_data($con, "priveleges", "user_name", $_POST['user_name']);
          if ($delete_data) {
            header("Location: display_users.php");
          } else {
            echo DELETE_ERROR;
          }
          break;

        default:
          # code...
          break;
      }

      // Close the database connection
      $db->close_connection($con);

      // Exit the system
      exit();

    } else {
      include_once 'user_levels.php';
      exit();
    }
?>
