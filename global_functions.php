<?php
    function base_header($title='')
    {
      echo "<!DOCTYPE html>
            <html lang='en-US'>
            <head>
                <meta charset='utf-8'>
                <meta http-equiv='X-UA-Compatible' content='IE=edge'>
                <meta name='viewport' content='width=device-width, initial-scale=1'>
                <meta name='description' content=''>
                <meta name='author' content=''>

                <title> $title </title>

                <!-- Bootstrap Core CSS -->
                <link href='static/css/bootstrap.min.css' rel='stylesheet'>

                <!-- Custom CSS -->
                <link href='static/css/modern-business.css' rel='stylesheet'>
                <link href='static/css/w3.css' rel='stylesheet'>

                <!-- Custom Fonts -->
                <link href='static/font-awesome/css/font-awesome.min.css' rel='stylesheet' type='text/css'>
                <style>
                  a:hover, a:visited, a:link, a:active
                  {
                    text-decoration: none;
                  }
                </style>
            </head>
            <body>";
    }

    function search_bar($search_page, $place_holder)
    {
      echo "<form class='form-inline' action='$search_page' method='POST' id='bsearch' style='margin-top: 15px'>
                <div class='input-group margin-bottom-sm'>
                  <input class='form-control' type='text' id='search' name='search'
                      placeholder='{$place_holder}'>
                  <div class='input-group-btn input-group-lg'>
                      <button class='btn btn-primary' form='bsearch' type='submit' name='submit'>
                          <i class='fa fa-search w3-large'></i> </button>
                  </div>
                </div>
            </form>";
    }

    function create_header()
    {
      $up_2 = encrypt_data('2');
      $full_name = $_SESSION['full_name'];
      // $user_type = $_SESSION['user_type'];
      $user = encrypt_data($_SESSION['user_name']);

      echo "<!-- Navigation -->
        <nav class='navbar navbar-inverse navbar-fixed-top' role='navigation'>
            <div class='container'>
            <!-- Brand and toggle get grouped for better mobile display -->
            <div class='navbar-header'>
                <button type='button' class='navbar-toggle' data-toggle='collapse' data-target='#bs-example-navbar-collapse-1'>
                    <span class='sr-only'>Toggle navigation</span>
                    <span class='icon-bar'></span>
                    <span class='icon-bar'></span>
                    <span class='icon-bar'></span>
                </button>
                <a class='navbar-brand' href='index.php'> <i class='fa fa-home fa-fw'></i> CHURCH_NAME </a>
            </div>
            <!-- Collect the nav links, forms, and other content for toggling -->
            <div class='collapse navbar-collapse' id='bs-example-navbar-collapse-1'>
                <ul class='nav navbar-nav navbar-right'>
                    <li class='dropdown'>
                        <a href='#' class='dropdown-toggle' data-toggle='dropdown'><i class='fa fa-graduation-cap fa-fw'></i> Members <b class='glyphicon glyphicon-menu-down'></b></a>
                        <ul class='dropdown-menu'>";
                            if ($_SESSION['is_admin'] == 1 or $_SESSION['can_add_member'] == 1) {
                              echo "<li><a href='add_member.php'><i class='fa fa-fw fa-user-md'></i> Add New Member </a></li>";
                            }
                            if ($_SESSION['is_admin'] == 1 or $_SESSION['can_edit_member'] == 1) {
                              echo "<li><a href='display_members.php'><i class='fa fa-fw fa-edit'></i> View and Edit Members </a></li>";
                            }

                            if ($_SESSION['is_admin'] == 1 or $_SESSION['can_add_attendance'] == 1) {
                              echo "<li class='divider'></li>";
                              echo "<li><a href='#'><i class='fa fa-fw fa-user-md'></i> Add Attendance </a></li>";
                            }
                            if ($_SESSION['is_admin'] == 1 or $_SESSION['can_edit_attendance'] == 1) {
                              echo "<li><a href='#'><i class='fa fa-fw fa-edit'></i> View and Edit Attendance </a></li>";
                            }

                            if ($_SESSION['is_admin'] == 1 or $_SESSION['can_add_tithe'] == 1) {
                              echo "<li class='divider'></li>";
                              echo "<li><a href='pay_tithe.php'><i class='fa fa-fw fa-plus'></i> Add Tithe Payments </a></li>";
                            }
                            if ($_SESSION['is_admin'] == 1 or $_SESSION['can_edit_tithe'] == 1) {
                              echo "<li><a href='view_tithe.php'><i class='fa fa-fw fa-desktop'></i> View Tithe Payments </a></li>";
                            }
                  echo "</ul>
                    </li>
                    <li class='dropdown'>
                        <a href='#' class='dropdown-toggle' data-toggle='dropdown'><i class='fa fa-fw fa-gears'></i> Settings <b class='glyphicon glyphicon-menu-down'></b></a>
                        <ul class='dropdown-menu'>";
                            if ($_SESSION['is_admin'] or $_SESSION['can_create_user']) {
                                echo "<li><a href='add_user.php'><i class='fa fa-fw fa-user'></i> Add New User </a></li>";
                            }
                            if ($_SESSION['is_admin'] or $_SESSION['can_set_user_privelege']) {
                                echo "<li><a href='display_users.php'><i class='fa fa-fw fa-edit'></i> Set User Priveleges </a></li>";
                            }
                            if ($_SESSION['is_admin'] or $_SESSION['can_backup_data']) {
                                echo "<li><a href='down_page.php'><i class='fa fa-fw fa-database'></i> Back Up Database </a></li>";
                            }
                            if ($_SESSION['is_admin'] or $_SESSION['can_add_member'] or $_SESSION['can_edit_member']) {
                              echo "<li><a href='save_aux.php'><i class='fa fa-fw fa-plus-square'></i> Add New Member Status </a></li>";
                            }

                      echo  "<li><a href='change_password.php'><i class='fa fa-fw fa-key'></i> Change Password </a></li>
                        </ul>
                    </li>
                    <li>
                        <a href='users_page.php?u_id={$user}&up_user={$up_2}'><span class='glyphicon glyphicon-user'></span> $full_name </a>
                    </li>
                    <li>
                        <a href='logout.php'> Log Out <i class='fa fa-sign-out fa-fw'></i> </a>
                    </li>
                </ul>
                </div>
                <!-- /.navbar-collapse -->
            </div>
        </nav>";
    }

    function get_checked($value)
    {
      $checked = "";
      if ($value) {
        $checked = "checked";
        return $checked;
      } else {
        return $checked;
      }
    }

    function create_footer()
    {
      echo "    <script src='static/js/jquery.js'></script>
                <script src='static/js/jquery-3.1.1.min.js'></script>
                <script src='static/js/bootstrap.min.js'></script>
                <script src='static/js/church.js'></script>
            </body>
            </html>";
    }

    function select_data($data_array, $select_name, $select_value, $width=20, $id = '', $sorted = FALSE, $disabled = '')
    {
      echo "<select class='w3-select w3-border w3-round' name='{$select_name}' id='{$id}' style='width:{$width}%' $disabled>\n";

      // Sort the array
      if ($sorted) {
        sort($data_array);
      }

      foreach ($data_array as $key => $value) {
        echo "<option value='{$value}'";
        if ($select_value == $value) {
          echo " selected";
        }
        echo "> $value </option>";
      }
      echo "</select>\n";
    }

    function get_date_form($date_year, $date_month, $date_day, $date_to_use, $ywidth=20, $mwidth=30, $dwidth=15)
    {
        $monthName = array(1=> "January", "February", "March",
                            "April", "May", "June", "July",
                            "August", "September", "October",
                            "November", "December");

        $today = strtotime($date_to_use); #stores today's date

        /* Build selection list for month */
        $todayMO = date("m",$today); #get the month from $today
        echo "<select class='w3-select w3-border w3-round' name='{$date_month}' style='width:{$mwidth}%'>\n";
                  for ($n=1;$n<=12;$n++)
                  {
                    echo "<option value=$n";
                    if ($todayMO == $n) #adds selected attribute if today
                    {
                      echo " selected";
                    }
                    echo "> $monthName[$n] </option>\n";
                  }
                  echo "</select>\n";

                  /* build selection list for the day */
                  $todayDay= date("d",$today);
                  #get the day from $today
                  echo "<select class='w3-select w3-border w3-round' name='{$date_day}' style='width:{$dwidth}%'>\n";
                  for ($n=1;$n<=31;$n++)
                  {
                    echo " <option value=$n";
                    if ($todayDay == $n )
                    {
                      echo " selected";
                    }
                    echo "> $n </option>\n";
                  }
                  echo "</select>\n";

                  /* build selection list for the year */
                  $startYr = date("Y", $today);
                  #get the year from $today
                  echo "<select class='w3-select w3-border w3-round' name='{$date_year}' style='width:{$ywidth}%'>\n";
                  for ($n=1950;$n<=($startYr+50);$n++)
                  {
                    echo " <option value=$n";
                    if ($startYr == $n )
                    {
                      echo " selected";
                    }
                    echo "> $n </option>\n";
                  }
                  echo "</select>\n";
    }

    function encrypt_data($string)
    {
      $crypt_data = str_split($string);
      $encrypted = "";

      foreach ($crypt_data as $key => $value) {
        // Get the length of the ascii +10 code and convert to string
        $new_value = strval(strlen(intval(ord($value) + 10)));
        // Get the ascii code of the +10 string
        $new_value .= strval(intval(ord($value) + 10));
        // Concatenate to already existing string
        $encrypted .= $new_value;
      }
      // Return the reversed string. That will be your encrypt data
      return strrev($encrypted);
    }

    function encryption($string, $key)
    {
      $encrypted = "";
      $encrypt = "";
      $i = 0; $j = 0;

      $key_len = strlen($key);
      while ($i <= strlen($string)) {
        $new_value = strval(strlen(intval(ord(substr($string, $i, 1)) + $key_len)));
        $new_value .= strval(intval(ord(substr($string, $i, 1)) + $key_len));
        $encrypted .= $new_value;
        $i += 1;
      }

      return strrev($encrypted);
    }

    function decryption($string, $key)
    {
      // Start decryting reversing the given string
      $crypt_data = strrev($string);
      $key_len = strlen($key);
      $decrypted = "";
      $i = 0;
      // Use a loop to get the number of places it should go until you get the full string decrypted
      while ($i < strlen($crypt_data)) {
        $chr_count = intval(substr($crypt_data, $i, 1));
        $new_chr = intval(substr($crypt_data, $i+1, $chr_count)) - $key_len;
        $decrypted .= chr($new_chr);
        $i += $chr_count + 1;
      }

      return $decrypted;
    }

    function decrypt_data($string)
    {
      // Start decryting reversing the given string
      $crypt_data = strrev($string);
      $decrypted = "";
      $i = 0;
      // Use a loop to get the number of places it should go until you get the full string decrypted
      while ($i < strlen($crypt_data)) {
        $chr_count = intval(substr($crypt_data, $i, 1));
        $new_chr = intval(substr($crypt_data, $i+1, $chr_count)) - 10;
        $decrypted .= chr($new_chr);
        $i += $chr_count + 1;
      }

      return $decrypted;
    }

    function is_key($array, $key_value)
    {
      foreach ($array as $key => $value) {
        if ($key == $key_value) {
          return TRUE;
        }
      }
      return FALSE;
    }

    function is_element($array, $element_to_find)
    {
      foreach ($array as $key => $value) {
        if ($value == $element_to_find) {
          return TRUE;
        }
      }
      return FALSE;
    }

    function has_string($string, $string_to_find, $delim = "_")
    {
      $field_name = explode($delim, $string);

      foreach ($field_name as $key => $value) {
        if ($value == $string_to_find) {
          return TRUE;
        }
      }
      return FALSE;
    }

    function create_log_id($date)
    {
      $log_date = new DateTime($date);
      $log_date = date_format($log_date, "y-m-d");
      $log_num = substr(strrev(time()), 0, 4);

      $login_date = explode("-", $log_date);

      $log_id = "log_".$login_date[2].$login_date[1].$login_date[0]."_".$log_num;

      return $log_id;
    }

    function create_church_id($birth_date, $db_num)
    {
      # This function is basically used to create new students numbers for the students
      // The student number has the form DIA-Day-Month-Year-Number
      $m_date = new DateTime($birth_date);

      $new_date = date_format($m_date, "y-m-d");

      $date_given = explode("-", $new_date);

      // $str_length = str_repeat("0", (4 - strlen(strval($db_num + 1)))).strval($db_num + 1);
      $str_length = strval($db_num);

      $std_id = "CHN".$date_given[2].$date_given[1].$date_given[0].$str_length;

      return $std_id;
    }

    function get_column_name($value)
    {
      $field_name = explode("_", $value);
      $column_name = implode(" ", $field_name);

      $column_name = ucwords($column_name);
      return $column_name;
    }

    function get_date_name($value)
    {
      $date_array = explode("_", $value);
      $array_count = sizeof($date_array);

      return $date_array[$array_count - 1];
    }

    function filter_array($subject_array, $standard_array)
    {
      foreach ($subject_array as $key => $value) {
        if (!is_element($standard_array, $key)) {
          unset($subject_array[$key]);
        }
      }

      return $subject_array;
    }

    function str_date($strdate)
    {
      $new_date = new DateTime($strdate);
      return $new_date;
    }

    function login_check()
    {
      // When the user is not logged in
      if (@$_SESSION['auth'] != "yes") {
        header("Location: login.php");
        exit();
      }

      // When the session expires
      if ( (time() - $_SESSION['login_time']) > 1440 ) {
        include_once 'logout.php';
        exit();
      }
    }

    function get_month_from_value($int_month)
    {
      $month_array = array(1 => 'January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September',
                          'October', 'November', 'December');
      $int_month = intval($int_month);
      $month_name = '';
      if ($int_month > 12 and $int_month <= 0) {
        return $month_name;
      } else {
        foreach ($month_array as $key => $value) {
          if ($key == $int_month) {
            $month_name = $value;
          }
        }
        return $month_name;
      }
    }

    function update_password($old_password, $new_key)
    {
      return encryption('old_password', $new_key);
    }

?>
