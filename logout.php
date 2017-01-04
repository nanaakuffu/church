<?php
  session_start();

  // $user_name = $_SESSION['user_name'];
  $log_id = $_SESSION['log_id'];

  include_once 'db_functions.php';

  $db = new Database();
  $con = $db->connect_to_db();

  $today_time = date('h:i:s');
  $today_date = date('y-m-d');

  $log_sql = "UPDATE login_details SET logout_date='$today_date', logout_time='$today_time' WHERE login_id ="."'".$log_id."'";
  echo $log_sql;
  $log_result = mysqli_query($con, $log_sql) or die("Couldn't execute query.");

  // $user_sql = "UPDATE users SET status='0' WHERE user_name ="."'".$user_name."'";
  // $result = mysqli_query($con, $user_sql) or die("Couldn't execute query.");
  if ($log_result) {
    session_unset();
    session_destroy();
    $db->close_connection($con);
    header("Location: login_page.php");
    exit();
  }

?>
