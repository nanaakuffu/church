<?php
    require_once 'global_functions.php';
    base_header('Login Form');
?>

<div class='w3-container row' style='margin-top:-50px'>
  <div class='col-md-4'>
    <br />
  </div>
  <div class='col-md-4'>
    <div class='panel panel-default' style='margin-top:90px'>
      <div class='panel-heading w3-blue'>
        <b style='font-size:20px'> Please Login Here! </b>
      </div>
      <div class='panel-body'>
        <form action='login.php' id='login' method='POST'>
            <div class='form-group'>
              <label for='user_name'>Username:</label>
              <input type='text' class='form-control' id='user_name' name='user_name' placeholder='Enter username' required>
            </div>
            <div class='form-group'>
              <label for='user_pass_word'>Password:</label>
              <input type='password' class='form-control' id='user_pass_word' name='user_pass_word' placeholder='Enter password' required>
            </div>
            <div class="form-group">
              <button class='btn btn-primary w3-round w3-padding-medium w3-right' type='submit' name='login' form='login'>Login <span class='glyphicon glyphicon-log-in'></button>
            </div>
        </form>
      </div>
    </div>
<?php
  if (isset($_SESSION['message'])) {
    echo "<div class='panel panel-default'>
              <div class='panel-body'>", $_SESSION['message'], "</div>
          </div>";
    unset($_SESSION['message']);
  }
?>
  </div>
  <div class='col-md-4'>
    <br />
  </div>
</div>
<hr>

<?php
  create_footer();
?>
