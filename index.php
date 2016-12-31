<?php
    session_start();

    require_once 'global_functions.php';
    require_once 'db_functions.php';

    // login_check();

    base_header('Home | Welcome to ...');
    create_header();

    $db = new Database();
    $con = $db->connect_to_db();
    $total = 0;

    echo "<br /><div class='container'>
          <div class='row'>
          <div class='col-sm-4'>
            <div class='panel panel-default'>
              <div class='panel-heading'>
                <b style='font-size:16px'>Church Members</b>
              </div>
              <div class='panel-body'>
                <table class='table-responsive w3-table w3-striped w3-hoverable' cellpadding='8' cellspacing='10'>
                  <tr class='w3-blue'>
                    <th> Status </th>
                    <th> Members </th>
                  </tr>";
                  $sum_records = $db->members_summary($con, "members", "Status");
                  if (sizeof($sum_records) > 0 ) {
                    foreach ($sum_records as $key => $value) {
                      echo "<tr>";
                      foreach ($value as $vkey => $kvalue) {
                        if ($vkey == 'Members') {
                          echo "<td style='text-indent:20px'>", $kvalue , "</td>";
                          $total += strval($kvalue);
                        } else {
                          echo "<td>", $kvalue , "</td>";
                        }
                      }
                      echo "</tr>";
                    }
                    echo "<tr>
                            <td style='font-weight:bold'> Total </td>
                            <td style='font-weight:bold; text-indent:20px'>", $total , "</td>
                          </tr>
                    </table>";
                  } else {
                    echo "</table>
                          <div class='panel panel-default w3-pale-yellow'>
                            <div class='panel-body'> No birthdays this month </div>
                          </div>";
                  }
        echo  "</div>
            </div>
          </div>
          <div class='col-sm-4'>
            <div class='panel panel-default'>
              <div class='panel-heading'>
                <i class='fa fa-fw fa-birthday-cake'></i> <b style='font-size:16px'>", date('F', time()), " Borns</b>
              </div>
              <div class='panel-body'>
                <table class='table-responsive w3-table w3-striped w3-hoverable' cellpadding='8' cellspacing='10'>
                  <tr class='w3-blue'>
                    <th> First Name </th>
                    <th> Last Name </th>
                    <th> Status </th>
                    <th> Day </th>
                  </tr>";
                  $birthdays = $db->get_monthly_birthdays($con);
                  if (sizeof($birthdays) > 0 ) {
                    foreach ($birthdays as $key => $value) {
                      echo "<tr>";
                        foreach ($value as $vkey => $kvalue) {
                          if ($vkey == 'date_of_birth') {
                            $kvalue = date_format(str_date($kvalue), 'j');
                            echo "<td>", $kvalue, "</td>";
                          } else {
                            echo "<td>", $kvalue, "</td>";
                          }
                        }
                        echo "</tr>";
                      }
                    echo "</table>";
                  } else {
                    echo "</table>
                          <div class='panel panel-default w3-pale-yellow'>
                            <div class='panel-body'> No birthdays this month </div>
                          </div>";
                  }
    echo "</div>
        </div>
    </div>
    <div class='col-sm-4'>
      <br />
    </div>
    </div>
    </div>";

    $db->close_connection($con);
    create_footer();
?>
