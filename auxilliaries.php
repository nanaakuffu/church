<?php
  // session_start();

  require_once 'global_functions.php';
  require_once 'db_functions.php';

  login_check();

  base_header('Add Auxilliaries');

  create_header();

?>
<br />
<div class='container'>
  <div class='row'>
    <div class='col-sm-4'>
      <div class='panel panel-default'>
        <div class='panel-heading w3-blue'>
          <b style='font-size:16px'> Add New Currency </b>
        </div>
        <div class='panel-body'>
          <form action='save_aux.php' method='POST'>
            <div class='form-group'>
                <label for='currency_name'> Currency Name: </label><br />
                <input class='form-control' type='text' id='c_name' name='currency_name'
                      placeholder='Currency Name...' required>
            </div>
            <div class='form-group'>
              <input class='btn btn-primary btn-block w3-round w3-padding-medium' type='submit' name='submit_aux'
                      value='Add Currency'>
            </div>
          </form>
        </div>
      </div>
    </div>
    <div class='col-sm-4'>
        <div class='panel panel-default'>
          <div class='panel-heading w3-blue'>
            <b style='font-size:16px'> Add New Member Status </b>
          </div>
          <div class='panel-body'>
            <form action='save_aux.php' method='POST'>
              <div class='form-group'>
                  <label for='status_name'> Status Name: </label><br />
                  <input class='form-control' type='text' id='s_name' name='status_name'
                        placeholder='Status Name...' required>
              </div>
              <div class='form-group'>
                <input class='btn btn-primary btn-block w3-round w3-padding-medium' type='submit' name='submit_aux'
                        value='Add Status'>
              </div>
            </form>
          </div>
        </div>
    </div>
    <div class='col-sm-4'>
      <br />
    </div>
  </div>
</div>

<?php
  create_footer();
?>
