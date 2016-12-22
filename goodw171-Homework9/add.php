<?php
include_once("database.php");

$con = mysqli_connect($db_servername, $db_name, $db_password, $db_username, $db_port);

mysqli_select_db($con, "tbl_accounts");

if (isset($_POST['send'])) {
  $name = mysqli_real_escape_string($con, $_POST['acc_name']);

  $username = mysqli_real_escape_string($con, $_POST['acc_login']);

  $password = mysqli_real_escape_string($con, $_POST['acc_password']);

  // $id = $_GET['acc_login'];

  $checkIfExists = "SELECT * FROM tbl_accounts WHERE acc_login = '$username'";

  $checker = mysqli_query($checkIfExists);

  // check if value already exists. If so, do not add value
   if (mysql_num_rows($checker) > 0) {
     $_SESSION['tableError'] = "Unable to add duplicate account name";
   } else {
    // Duplicate not found. Proceed accordingly
    $_SESSION['tableError'] = "User successfully updated";
    $addition = mysqli_query($con,"INSERT INTO tbl_accounts (acc_name, acc_login, acc_password) VALUES ('$name','$username','". sha1($password)."')");

      // Double check the query was successful
      if ($addition) {
        $_SESSION['tableError'] = "User successfully added to database";
        header("location: admin.php");
      }
      else {
        $_SESSION['tableError'] = "Error adding user to database";
        header("location: admin.php");
      }
    }
}
?>
