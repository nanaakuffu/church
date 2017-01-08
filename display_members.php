<?php
    session_start();

    require_once("db_functions.php");
    require_once("global_vars.php");
    require_once("global_functions.php");

    login_check();

    $db = new Database();

    $con = $db->connect_to_db();

    $fields = array('church_number','first_name', 'last_name', 'status', 'date_of_birth');

    base_header('Display Members');
    create_header();

    // $form_name = $_SESSION['form_name'];

    if (isset($_POST['submit'])) {
      $records = $db->search_data($con, "members", $fields, "first_name", $_POST['search'], 'first_name');
    } else {
      $records = $db->display_data($con, "members", $fields, "first_name");
    }
    $db->close_connection($con);

    echo "<div class='container'>",
            search_bar('display_members.php', 'Search Members ...'),
           "<br /><div class='table-responsive'>
              <table class='w3-table w3-striped w3-hoverable' align='center' cellspacing='5'>
                <tr class='w3-blue'>";
                  $headers = "";
                  foreach ($fields as $key => $value) {
                      if ($value != 'church_number') {
                        $headers .= "<th>".get_column_name($value)."</th>";
                      }
                  }
                  echo $headers;
          echo "</tr>";

    if (sizeof($records) != 0) {
        foreach ($records as $key => $record) {
          echo "<tr>";
          foreach ($record as $rkey => $value) {
            if ($rkey != 'church_number') {
              $new_id = encrypt_data($record['church_number']);
              $up_1 = encrypt_data('1');
              if ($rkey == 'date_of_birth') {
                $value = date_format(str_date($value), 'F j, Y');
                echo "<td ><a href=member_page.php?c_id={$new_id}&up_disp={$up_1}>", $value, "</a></td>";
              } else {
                echo "<td ><a href=member_page.php?c_id={$new_id}&up_disp={$up_1}>", $value, "</a></td>";
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
      </div>";

    create_footer();
?>
