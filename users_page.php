<?php

  if (isset($_GET['up_user'])) {
    session_start();
  }

  unset($_SESSION['update_user']);

  require_once 'global_functions.php';
  require_once 'db_functions.php';

  login_check();

  base_header("Create Users");
  create_header();

  $db = new Database();
  $con = $db->connect_to_db();

  if (isset($_GET['u_id'])) {
    $user = decrypt_data($_GET['u_id']);
    $_POST = $db->view_data($con, "users", "user_name", $user);
    $_POST['submit'] = 'Update User Details';
    $_SESSION['update_user'] = TRUE;
  }

  if (isset($_SESSION['id'])) {
    $_SESSION['update_user'] = TRUE;
  }

  // Get deafult values
  $user_name = (isset($_POST['submit'])) ? $_POST['user_name'] : "" ;
  $user_password = (isset($_POST['submit'])) ? decryption($_POST['user_password'], $_POST['full_name']) : "" ;
  $full_name = (isset($_POST['submit'])) ? $_POST['full_name'] : "" ;

  // echo decryption($_POST['user_password'], $_POST['full_name']), "<br />";
  // echo decryption("02202134313131393135313531371132313", $_POST['full_name']), "<br>";
  // echo $_POST['full_name'], "<br>";
  // echo $user_password;

  $button = (isset($_SESSION['update_user'])) ? "Update User Details" : "Add New User" ;
  $title_bar = (isset($_SESSION['update_user'])) ? "Update User Details" : "Add User Details" ;
  $buttton_ctr = (isset($_SESSION['update_user'])) ? "readonly" : "required" ;
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
    <form class='w3-form w3-border' action='add_user.php' method='POST'>
      <div class="row">
        <div class="col-sm-4">
          <div class='form-group'>
              <label> User Name: </label>
              <input class='form-control' type='text' name='user_name' value='<?php echo $user_name; ?>'
                       id='uname' placeholder='Enter User Name' <?php echo $buttton_ctr; ?>>
          </div>
          <div class='form-group'>
              <label> User Password: </label>
              <input class='form-control' type='password' name='user_password' value='<?php echo trim($user_password); ?>'
                       id='upass' placeholder='Enter Password' <?php echo $buttton_ctr; ?>>
          </div>
        </div>
        <div class="col-sm-6">
          <div class='form-group'>
              <label> Full Name: </label>
              <input class='form-control' type='text' name='full_name' value='<?php echo $full_name ?>'
                       id='fname' placeholder='Enter Full Name' required>
          </div>
        </div>
        <div class="col-sm-2">
          <div class='form-group'>
            <label> Control </label>
            <input class='btn btn-primary btn-block w3-round w3-padding-medium' type='submit' name='submit'
                  value='<?php echo $button ?>'>
          </div>
        </div>
      </div>
    </form>
  </div>

<?php
      create_footer();
?>
