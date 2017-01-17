<?php
  if (isset($_GET['upd'])) {
    session_start();
  }

  unset($_SESSION['update_access']);

  require_once 'global_functions.php';
  require_once 'db_functions.php';

  login_check();

  base_header('Access Levels');
  create_header();

  $db = new Database();
  $con = $db->connect_to_db();

  if (isset($_GET['level'])) {
    $user_name = decrypt_data($_GET['level']);
    $sql = "SELECT * FROM priveleges WHERE user_name="."'".$user_name."'";
    $result = mysqli_query($con, $sql);
    $num = mysqli_num_rows($result);
    if ($num > 0) {
      $_POST = $db->view_data($con, "priveleges", "user_name", $user_name);
      $_POST['add_access'] = 'Update';
      $_SESSION['update_access'] = TRUE;
    }
  }

  $user = $user_name;
  $is_admin = (isset($_POST['add_access'])) ? $_POST['is_admin'] : 0 ;
  $can_backup_data = (isset($_POST['add_access'])) ? $_POST['can_backup_data'] : 0 ;
  $can_add_member = (isset($_POST['add_access'])) ? $_POST['can_add_member'] : 0 ;
  $can_edit_member = (isset($_POST['add_access'])) ? $_POST['can_edit_member'] : 0 ;
  $can_delete_member = (isset($_POST['add_access'])) ? $_POST['can_delete_member'] : 0 ;
  $can_add_tithe = (isset($_POST['add_access'])) ? $_POST['can_add_tithe'] : 0 ;
  $can_edit_tithe = (isset($_POST['add_access'])) ? $_POST['can_edit_tithe'] : 0 ;
  $can_delete_tithe = (isset($_POST['add_access'])) ? $_POST['can_delete_tithe'] : 0 ;
  $can_add_attendance = (isset($_POST['add_access'])) ? $_POST['can_add_attendance'] : 0 ;
  $can_edit_attendance = (isset($_POST['add_access'])) ? $_POST['can_edit_attendance'] : 0 ;
  $can_delete_attendance = (isset($_POST['add_access'])) ? $_POST['can_delete_attendance'] : 0 ;
  $can_create_user = (isset($_POST['add_access'])) ? $_POST['can_create_user'] : 0 ;
  $can_delete_user = (isset($_POST['add_access'])) ? $_POST['can_delete_user'] : 0 ;
  $can_set_user_privelege = (isset($_POST['add_access'])) ? $_POST['can_set_user_privelege'] : 0 ;

  
  echo "<br />
        <div class='container'>
          <div class='w3-container w3-blue'>
            <h3> Set User Priveleges </h3>
          </div>
          <form class='w3-form w3-border' action='create_levels.php' method='POST'>
          <div class='row'>
            <div class='col-sm-3'>
              <div class='form-group'>
                <label> User Name </label>
                <input class='form-control' type='text' name='user_name' value='{$user}' readonly>
              </div>
              <div class='checkbox'>";
              if ($is_admin == 1) {
                echo "<label> <input type='checkbox' name='is_admin' value='1' checked> Is Administrator </label>";
              } else {
                echo "<label> <input type='checkbox' name='is_admin' value='1'> Is Administrator </label>";
              }
  echo "      </div>
              <div class='checkbox'>";
              if ($can_backup_data == 1) {
                echo "<label> <input type='checkbox' name='can_backup_data' value='1' id='suser' checked> Can Backup Data </label>";
              } else {
                echo "<label> <input type='checkbox' name='can_backup_data' value='1' id='suser'> Can Backup Data </label>";
              }
  echo "      </div>
            </div>
            <div class='col-sm-3'>
              <div class='checkbox'>";
              if ($can_add_member == 1) {
                echo "<label> <input type='checkbox' name='can_add_member' value='1' id='form' checked> Can Add Member </label>";
              } else {
                echo "<label> <input type='checkbox' name='can_add_member' value='1' id='form' > Can Add Member </label>";
              }
  echo "      </div>
              <div class='checkbox'>";
              if ($can_edit_member == 1) {
                echo "<label> <input type='checkbox' name='can_edit_member' value='1' checked> Can Edit Member </label>";
              } else {
                echo "<label> <input type='checkbox' name='can_edit_member' value='1'> Can Edit Member </label>";
              }
  echo "      </div>
              <div class='checkbox'>";
              if ($can_delete_member == 1) {
                echo "<label> <input type='checkbox' name='can_delete_member' value='1' checked> Can Delete Member </label>";
              } else {
                echo "<label> <input type='checkbox' name='can_delete_member' value='1'> Can Delete Member </label>";
              }
  echo "      </div>
              <div class='checkbox'>";
              if ($can_add_tithe == 1) {
                echo "<label> <input type='checkbox' name='can_add_tithe' value='1' checked> Can Add Tithe </label>";
              } else {
                echo "<label> <input type='checkbox' name='can_add_tithe' value='1'> Can Add Tithe </label>";
              }
  echo "      </div>
            </div>
            <div class='col-sm-3'>
              <div class='checkbox'>";
              if ($can_edit_tithe == 1) {
                echo "<label> <input type='checkbox' name='can_edit_tithe' value='1' id='form' checked> Can Edit Tithe </label>";
              } else {
                echo "<label> <input type='checkbox' name='can_edit_tithe' value='1' id='form' > Can Edit Tithe </label>";
              }
  echo "      </div>
              <div class='checkbox'>";
              if ($can_delete_tithe == 1) {
                echo "<label> <input type='checkbox' name='can_delete_tithe' value='1' checked> Can Delete Tithe </label>";
              } else {
                echo "<label> <input type='checkbox' name='can_delete_tithe' value='1'> Can Delete Tithe </label>";
              }
  echo "      </div>
              <div class='checkbox'>";
              if ($can_add_attendance == 1) {
                echo "<label> <input type='checkbox' name='can_add_attendance' value='1' checked> Can Add Attendance </label>";
              } else {
                echo "<label> <input type='checkbox' name='can_add_attendance' value='1'> Can Add Attendance </label>";
              }
  echo "      </div>
              <div class='checkbox'>";
              if ($can_edit_attendance == 1) {
                echo "<label> <input type='checkbox' name='can_edit_attendance' value='1' checked> Can Edit Attendance </label>";
              } else {
                echo "<label> <input type='checkbox' name='can_edit_attendance' value='1'> Can Edit Attendance </label>";
              }
  echo "      </div>
            </div>
            <div class='col-sm-3'>
              <div class='checkbox'>";
              if ($can_delete_attendance == 1) {
                echo "<label> <input type='checkbox' name='can_delete_attendance' value='1' id='form' checked> Can Delete Attendance </label>";
              } else {
                echo "<label> <input type='checkbox' name='can_delete_attendance' value='1' id='form' > Can Delete Attendance </label>";
              }
  echo "      </div>
              <div class='checkbox'>";
              if ($can_create_user == 1) {
                echo "<label> <input type='checkbox' name='can_create_user' value='1' checked> Can Create User </label>";
              } else {
                echo "<label> <input type='checkbox' name='can_create_user' value='1'> Can Create User </label>";
              }
  echo "      </div>
              <div class='checkbox'>";
              if ($can_delete_user == 1) {
                echo "<label> <input type='checkbox' name='can_delete_user' value='1' checked> Can Delete User </label>";
              } else {
                echo "<label> <input type='checkbox' name='can_delete_user' value='1'> Can Delete User </label>";
              }
  echo "      </div>
              <div class='checkbox'>";
              if ($can_set_user_privelege == 1) {
                echo "<label> <input type='checkbox' name='can_set_user_privelege' value='1' checked> Can Set User Priveleges </label>";
              } else {
                echo "<label> <input type='checkbox' name='can_set_user_privelege' value='1'> Can Set User Priveleges </label>";
              }
  echo "      </div>";
              if (!isset($_SESSION['update_access'])) {
                echo "<div class='form-group'>
                        <div class='btn-group'>
                          <input class='btn btn-primary' type='submit' name='add_access'
                          value='Add Access'>
                          <a class='btn btn-primary' href='display_users.php'>Back</a>
                        </div>
                      </div>";
              } else {
                echo "<input type='hidden' name='level_up' value='up_lev'>
                      <div class='form-group'>
                        <div class='btn-group'>
                          <input class='btn btn-primary' type='submit' name='add_access'
                          value='Update'>
                          <input class='btn btn-primary' type='submit' name='add_access'
                          value='Delete'>
                          <a class='btn btn-primary' href='display_users.php'>Back</a>
                        </div>
                      </div>";
              }
  echo "      </div>
          </div>
          </form>";
  echo "</div>";

  create_footer();
?>
