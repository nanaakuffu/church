<?php

  require_once 'global_functions.php';
  require_once 'db_functions.php';

  login_check();

  base_header('Tithe Payments');
  create_header();

  $db = new Database();
  $con = $db->connect_to_db();

  $curr_array = $db->create_data_array($con, 'currency', 'currency_name');
  $month_array = array(1 => 'January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September',
                      'October', 'November', 'December');
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
        <h3> Tithe Payment Form </h3>
    </div>
    <form class='w3-form w3-border' action='pay_tithe.php' method='POST'>
      <div class="row">
        <div class="col-sm-5">
          <div class="form-group">
            <label> Church Number: </label>
            <div class='input-group margin-bottom-sm'>
              <input class='form-control' type='text' name='church_number' value=''
                       id='chnumber' placeholder='Enter Church Number' onchange='get_fullname(this.value)' required>
              <div class='input-group-btn input-group-lg'>
                  <button class='btn btn-primary' form='bsearch' type='submit' name='submit' onchange="get_fullname(chnumber.value)">
                      <i class='fa fa-search w3-large'></i> </button>
              </div>
            </div>
          </div>
          <!-- <div class='form-group'> -->
              <label> Full Name: </label>
              <input class='form-control' type='text' name='full_name' value=''
                       id='fname' disabled>
          <!-- </div> -->
          <br />
          <!-- <div class='form-group'> -->
              <label> Amount Paid: </label>
              <input class='form-control' type='text' name='amoutn_paid' value=''
                       id='amt' placeholder='Enter Amount' required>
          <!-- </div> -->
          <br />
        </div>
        <div class="col-sm-5">
          <div class='form-group'>
              <label> Currency: </label>
              <?php echo select_data($curr_array, 'currency', 'Ghana Cedis', 100, '', TRUE); ?>
          </div>
          <div class='form-group'>
              <label> Month Paid: </label>
              <?php echo select_data($month_array, 'month_paid', 'January', 100); ?>
          </div>
          <div class='form-group'>
              <label> Date Paid: </label><br />
              <?php get_date_form('birth_year','birth_month', 'birth_day', date("m-d-y") )?>
          </div>
        </div>
        <div class="col-sm-2">
          <div class='form-group'>
            <label> Control </label>
            <input class='btn btn-primary btn-block w3-round w3-padding-medium' type='submit' name='submit'
                  value='Add Tithe'>
          </div>
        </div>
      </div>
    </form>
  </div>

<?php
      create_footer();
?>
