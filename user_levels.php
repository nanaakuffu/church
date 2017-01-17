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

?>
<br />
<div class='container'>
  <div class='w3-container w3-blue'>
  <h3> Set User Priveleges </h3>
  </div>
  <form class='w3-form w3-border' action='create_levels.php' method='POST'>
    <div class='row'>
      <div class='col-sm-3'>
        <div class='form-group'>
          <label> User Name </label>
          <input class='form-control' type='text' name='user_name' value='<?php echo $user; ?>' readonly>
        </div>
        <div class='checkbox'>
          <label> <input type='checkbox' name='is_admin' value='1' <?php echo get_checked($is_admin); ?> > Is Administrator </label>
        </div>
        <div class='checkbox'>
          <label> <input type='checkbox' name='can_backup_data' value='1' id='suser' <?php echo get_checked($can_backup_data); ?>> Can Backup Data </label>
        </div>
      </div>
      <div class='col-sm-3'>
        <div class='checkbox'>
          <label> <input type='checkbox' name='can_add_member' value='1' id='form' <?php echo get_checked($can_add_member); ?>> Can Add Member </label>
        </div>
        <div class='checkbox'>
          <label> <input type='checkbox' name='can_edit_member' value='1' <?php echo get_checked($can_edit_member); ?>> Can Edit Member </label>
        </div>
        <div class='checkbox'>
          <label> <input type='checkbox' name='can_delete_member' value='1' <?php echo get_checked($can_delete_member); ?>> Can Delete Member </label>
        </div>
        <div class='checkbox'>
          <label> <input type='checkbox' name='can_add_tithe' value='1' <?php echo get_checked($can_add_tithe); ?>> Can Add Tithe </label>
        </div>
      </div>
      <div class='col-sm-3'>
        <div class='checkbox'>
          <label> <input type='checkbox' name='can_edit_tithe' value='1' id='form' <?php echo get_checked($can_edit_tithe); ?>> Can Edit Tithe </label>
        </div>
        <div class='checkbox'>
          <label> <input type='checkbox' name='can_delete_tithe' value='1' <?php echo get_checked($can_delete_tithe); ?>> Can Delete Tithe </label>
        </div>
        <div class='checkbox'>
          <label> <input type='checkbox' name='can_add_attendance' value='1' <?php echo get_checked($can_add_attendance); ?>> Can Add Attendance </label>
        </div>
        <div class='checkbox'>
          <label> <input type='checkbox' name='can_edit_attendance' value='1' <?php echo get_checked($can_edit_attendance); ?>> Can Edit Attendance </label>
        </div>
      </div>
      <div class='col-sm-3'>
        <div class='checkbox'>
          <label> <input type='checkbox' name='can_delete_attendance' value='1' id='form' <?php echo get_checked($can_delete_attendance); ?>> Can Delete Attendance </label>
        </div>
        <div class='checkbox'>
          <label> <input type='checkbox' name='can_create_user' value='1' <?php echo get_checked($can_create_user); ?>> Can Create User </label>
        </div>
        <div class='checkbox'>
          <label> <input type='checkbox' name='can_delete_user' value='1' <?php echo get_checked($can_delete_user); ?>> Can Delete User </label>
        </div>
        <div class='checkbox'>
          <label> <input type='checkbox' name='can_set_user_privelege' value='1' <?php echo get_checked($can_set_user_privelege); ?>> Can Set User Priveleges </label>
        </div>
  <?php
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
  ?>
      </div>
    </div>
  </form>
</div>

<?php
  create_footer();
?>
