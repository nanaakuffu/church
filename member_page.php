<?php

  if (isset($_GET['up_home'])) {
    session_start();
    $_SESSION['back_home'] = TRUE;
  }

  if (isset($_GET['up_disp'])) {
    session_start();
  }

  unset($_SESSION['update_member']);

  require_once 'global_functions.php';
  require_once 'db_functions.php';

  // login_check();

  base_header("Add Members");
  create_header();

  $db = new Database();
  $con = $db->connect_to_db();

  $status_array = $db->create_data_array($con, 'status', 'status_name');

  if (isset($_GET['c_id'])) {
    $ch_id = decrypt_data($_GET['c_id']);
    $_POST = $db->view_data($con, "members", "church_number", $ch_id);
    $_POST['submit'] = 'Update Details';
    $_SESSION['update_member'] = TRUE;
  }

  if (isset($_SESSION['id'])) {
    $ch_id = $_SESSION['id'];
    $_SESSION['update_member'] = TRUE;
  }

  // Get deafult values
  $church_number = (isset($_POST['submit'])) ? $_POST['church_number'] : "" ;
  $fname = (isset($_POST['submit'])) ? $_POST['first_name'] : "" ;
  $lname = (isset($_POST['submit'])) ? $_POST['last_name'] : "" ;
  $birthdate = (isset($_POST['submit'])) ? date($_POST['date_of_birth']) : date("l, j F, Y") ;
  $mobnum = (isset($_POST['submit'])) ? $_POST['mobile_number'] : "" ;
  $status_name = (isset($_POST['submit'])) ? $_POST['status'] : "Status" ;
  $button = (isset($_SESSION['update_member'])) ? "Update Details" : "Add Details" ;
  $title_bar = (isset($_SESSION['update_member'])) ? "Update Member Details" : "Add Member Details" ;
?>
<br/>
  <div class="container">
    <?php
      if (isset($_SESSION['message'])) {
       echo "<div class='panel panel-default'>
               <div class='panel-heading'>Input Error(s)</div>
               <div class='panel-body'><ul class='fa-ul'>", $_SESSION['message'], "</ul></div>
             </div>";
       unset($_SESSION['message']);
     }
    ?>
    <div class='w3-container w3-blue'>
        <h3> <?php echo $title_bar ?> </h3>
    </div>
    <form class='w3-form w3-border' action='add_member.php' method='POST'>
      <div class="row">
        <div class="col-sm-6">
          <input type='hidden' name='church_number' value="<?php echo $church_number ?>">
          <div class='form-group'>
              <label> First Name: </label>
              <input class='form-control' type='text' name='first_name' value='<?php echo $fname ?>'
                       id='fname' placeholder='Enter First Name' required>
          </div>
          <div class='form-group'>
              <label> Last Name: </label>
              <input class='form-control' type='text' name='last_name' value='<?php echo $lname ?>'
                       id='lname' placeholder='Enter Last Name' required>
          </div>
          <div class='form-group'>
            <label>Date of Birth: </label>
            <br /><?php get_date_form('birth_year','birth_month', 'birth_day', $birthdate )?>
            <input type='hidden' name='date_of_birth'>
          </div>
        </div>
        <div class="col-sm-6">
          <div class='form-group'>
              <label> Mobile Number: </label>
              <input class='form-control' type='text' name='mobile_number' value='<?php echo $mobnum ?>'
                       id='mobnum' placeholder='Enter Mobile Number' required>
          </div>
          <div class='form-group'>
              <label> Staus: </label>
              <br /><?php select_data($status_array, 'status', $status_name, 30)?>
          </div>
          <div class='form-group'>
            <input class='btn btn-primary btn-block w3-round w3-padding-medium' type='submit' name='submit'
                  value='<?php echo $button ?>'>
          </div>
        </div>
      </div>
    </form>
  </div>

<?php
      // $db->close_connection($con);
      unset($_SESSION['id']);
      create_footer();
?>
