<?php
include_once("database.php");

$con = mysqli_connect($db_servername, $db_name, $db_password, $db_username, $db_port);

mysqli_select_db($con,"tbl_accounts");

if(isset($_GET['id'])){
  $id = $_GET['id'];

  $deletion = "DELETE FROM tbl_accounts WHERE acc_id = '$id'";

  $delete_query = mysqli_query($con, $deletion);

// The query exists
     if($delete_query){
       header('location: admin.php');
     }
  }
  else{
    echo "Error deleting from database";
  }
?>
