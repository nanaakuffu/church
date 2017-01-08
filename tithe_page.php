<?php
  if (isset($_GET['t_ref'])) {
    session_start();
  }

  unset($_SESSION['update_tithe']);

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

  if (isset($_GET['t_id'])) {
    $t_id = decrypt_data($_GET['t_id']);
    $_POST = $db->view_data($con, "tithes", "tithe_id", $t_id);
    $t_ref = decrypt_data($_GET['t_ref']);
    $_POST['submit'] = 'Update Tithe';
    $_SESSION['update'] = 1;
    $_SESSION['update_tithe'] = TRUE;
  }

  if (isset($_SESSION['t_id'])) {
    $t_id = $_SESSION['t_id'];
    $t_ref = $_SESSION['t_ref'];
    $_SESSION['update_tithe'] = TRUE;
  }

  // Get deafult values
  $tithe_id = (isset($_POST['submit']) or isset($_SESSION['t_id'])) ? $t_id : "" ;
  $full_name = (isset($_POST['submit']) or isset($_SESSION['t_id'])) ? $t_ref : "" ;
  $paid_date = (isset($_POST['submit'])) ? date($_POST['date_paid']) : date("l, j F, Y") ;
  $church_number = (isset($_POST['submit'])) ? $_POST['church_number'] : "" ;
  $paid_month = (isset($_POST['submit'])) ? $_POST['month_paid'] : 'January' ;
  $currency = (isset($_POST['submit'])) ? $_POST['currency'] : 'Ghana Cedis' ;
  $amount_paid = (isset($_POST['submit'])) ? $_POST['amount_paid'] : "" ;
  $button = (isset($_SESSION['update_tithe'])) ? "Update Tithe" : "Add Tithe" ;
  $buttton_attr = (isset($_SESSION['update_tithe'])) ? "readonly" : "required" ;
  $btn = (isset($_SESSION['update_tithe'])) ? "disabled" : "" ;
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
    <form class='w3-form w3-border' action='pay_tithe.php' method='POST' id='t_form'>
      <div class="row">
        <div class="col-sm-5">
          <input type="hidden" name="tithe_id" value="<?php echo $tithe_id ?>">
          <div class="form-group">
            <label> Church Number: </label>
            <div class='input-group margin-bottom-sm'>
              <input class='form-control' type='text' name='church_number' value='<?php echo $church_number; ?>'
                       id='chnumber' placeholder='Enter Church Number' onchange='get_fullname(this.value)' <?php echo $buttton_attr; ?> >
              <div class='input-group-btn input-group-lg'>
                  <button class='btn btn-primary' form='t_form' type='submit' name='submit' onchange="get_fullname(chnumber.value)" <?php echo $btn; ?> >
                      <i class='fa fa-search w3-large'></i> </button>
              </div>
            </div>
          </div>
          <!-- <div class='form-group'> -->
              <label> Full Name: </label>
              <input class='form-control' type='text' name='full_name' value='<?php echo $full_name; ?>'
                       id='fname' readonly>
          <!-- </div> -->
          <br />
          <!-- <div class='form-group'> -->
              <label> Amount Paid: </label>
              <input class='form-control' type='text' name='amount_paid' value='<?php echo $amount_paid; ?>'
                       id='amt' placeholder='Enter Amount' required>
          <!-- </div> -->
          <br />
        </div>
        <div class="col-sm-5">
          <div class='form-group'>
              <label> Currency: </label>
              <?php echo select_data($curr_array, 'currency', $currency, 100, '', TRUE); ?>
          </div>
          <div class='form-group'>
              <label> Month Paid: </label>
              <?php echo select_data($month_array, 'month_paid', $paid_month, 100); ?>
          </div>
          <div class='form-group'>
              <label> Date Paid: </label><br />
              <?php get_date_form('paid_year','paid_month', 'paid_day', $paid_date )?>
              <input type="hidden" name="date_paid" >
          </div>
        </div>
        <div class="col-sm-2">
          <div class='form-group'>
            <label> Control </label>
            <input class='btn btn-primary btn-block w3-round w3-padding-medium' type='submit' name='submit'
                  value='<?php echo $button; ?>' >
          </div>
        </div>
      </div>
    </form>
  </div>

<?php
  unset($_SESSION['t_id']);
  create_footer();
?>
