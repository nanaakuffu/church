<?php
    session_start();

    require_once("db_functions.php");
    require_once("global_vars.php");
    require_once("global_functions.php");

    if (isset($_POST['login'])) {
        // Connect to database and get user access levels as he/she logs in
        $db = new Database();
        $con = $db->connect_to_db();
        // $user_array = $db->get_user_priveleges($con, $_POST['user_name']);

        $user_sql = "SELECT user_name, full_name FROM users WHERE user_name = "."'".$_POST['user_name']."'";

        $result = mysqli_query($con, $user_sql) or die("Couldn't execute query.");
        $num = mysqli_num_rows($result);

        while($full_record = mysqli_fetch_assoc($result)){
          $full_rows[] = $full_record;
        }

        if ($num > 0) {   // user name was found
          $key = $full_rows[0]['full_name'];
          $password = encryption($_POST['user_pass_word'], $key);
          $pass_sql = "SELECT user_name, full_name FROM users WHERE user_name="."'".$_POST['user_name']."'". " AND user_password=". "'".$password."'";
          $pass_result = mysqli_query($con, $pass_sql) or die("Couldn't execute query 2.");
          $num_available = mysqli_num_rows($pass_result);

          while($record = mysqli_fetch_assoc($pass_result)){
            $rows[] = $record;
          }

          if ($num_available > 0) { // Password did match
                $full_name = $rows[0]['full_name'];

                // $_SESSION = $user_array;
                $user_name = $_POST['user_name'];
                $_SESSION['user_name'] = $user_name;
                $_SESSION['full_name'] = $full_name;
                $_SESSION['auth'] = 'yes';
                // $_SESSION['initials'] = $rows[0]['user_initials'];

                $today_date = date('y-m-d');
                $today_time = date('h:i:s');
                $log_id = create_log_id($today_date);
                $_SESSION['log_id'] = $log_id;
                $_SESSION['login_time'] = time();

                $log_sql = "INSERT INTO login_details (login_id, user_name, login_date, login_time, logout_date, logout_time)";
                $log_sql .= " VALUES ('$log_id','$user_name', '$today_date', '$today_time', ' ', ' ')";
                $result = mysqli_query($con, $log_sql) or die("Can't execute insert query.");

                // // Put the user online or login
                // $status_sql = "UPDATE users SET status='1' WHERE user_name="."'".$user_name."'";
                // $status_result = mysqli_query($con, $status_sql);

                $db->close_connection($con);
                header("Location: index.php");
            } else {
            $db->close_connection($con);
            $message = "<i class='fa fa-fw fa-close'></i> Password does not match your user name!";
            $_SESSION['message'] = $message;
            include_once 'login_page.php';
            exit();
          }
        } else {
          $db->close_connection($con);
          $message = "<i class='fa fa-fw fa-close'></i> Password does not match your user name!";
          $_SESSION['message'] = $message;
          include_once 'login_page.php';
          exit();
        }
    } else {
      include 'login_page.php';
      exit();
    }

?>
