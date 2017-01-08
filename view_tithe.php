<?php
    session_start();

    require_once("db_functions.php");
    require_once("global_vars.php");
    require_once("global_functions.php");

    login_check();

    $db = new Database();

    $con = $db->connect_to_db();

    $fields = array('tithe_id', 'date_paid', 'month_paid', 'amount_paid', 'currency');
    $new_fields = implode(",", $fields);

    base_header('Display Members');
    create_header();

    $names = array();
    $records = array();
    $full_name = "";

    if (isset($_POST['submit'])) {

      $name_sql = "SELECT first_name, last_name FROM members WHERE church_number="."'".$_POST['search']."'";
      $sql = "SELECT $new_fields FROM tithes WHERE church_number="."'".$_POST['search']."'";
      
      $name_result = mysqli_query($con, $name_sql);
      $names_number = mysqli_num_rows($name_result);

      $result = mysqli_query($con, $sql);
      $res_num = mysqli_num_rows($result);

      if ($names_number > 0) {
        while ($name = mysqli_fetch_assoc($name_result)) {
          $names[] = $name;
        }
        $full_name = $names[0]['first_name']." ". $names[0]['last_name'];
      }

      while ($record = mysqli_fetch_assoc($result)) {
        $records[] = $record;
      }
    }

    $db->close_connection($con);

    echo "<div class='container'>",
            search_bar('view_tithe.php', 'Search Members ...'), "<br />
            <div class='panel panel-default'>
              <div class='panel-heading w3-blue'>
                Tithe payment records of <b> $full_name </b>
              </div>
              <div class='panel-body'>
                <div class='table-responsive'>
                  <table class='w3-table w3-striped w3-hoverable' align='center' cellspacing='5'>
                    <tr class='w3-blue'>";
                      $headers = "";
                      foreach ($fields as $key => $value) {
                          if ($value != 'tithe_id') {
                            $headers .= "<th>".get_column_name($value)."</th>";
                          }
                      }
                      echo $headers;
              echo "</tr>";

    if (sizeof($records) != 0) {
        foreach ($records as $key => $record) {
          echo "<tr>";
          foreach ($record as $rkey => $value) {
            if ($rkey  != 'tithe_id') {
              $new_id = encrypt_data($record['tithe_id']);
              $t_name = encrypt_data($full_name);
              if ($rkey == 'date_paid') {
                $value = date_format(str_date($value), 'F j, Y');
                echo "<td ><a href=tithe_page.php?t_id={$new_id}&t_ref={$t_name}>", $value, "</a></td>";
              } else {
                echo "<td ><a href=tithe_page.php?t_id={$new_id}&t_ref={$t_name}>", $value, "</a></td>";
              }
            }
          }
            echo "</tr>";
        }
        echo "</table>";
    } else {
      echo "</table><br />
            <div class='panel panel-default w3-pale-yellow'>
              <div class='panel-body> No record found for this search. </div>
            </div>";
    }

    echo "</div>
          </div>
        </div>
      </div>";

    create_footer();
?>
