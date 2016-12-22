<?php

include_once("database.php");
$con = mysqli_connect($db_servername, $db_name, $db_password, $db_username, $db_port);
mysqli_select_db($con,"tbl_accounts");

if($con->connect_error){
  die("Connection failed: " . $con->connect_error);
}

if (isset($_GET['id'])) {
  $id = $_GET['id'];

  if (isset($_POST['submit'])) {
    $acc_name = $_POST['acc_name'];

    $username = $_POST['acc_login'];

    $password = $_POST['acc_password'];

    $change = mysqli_query($con, "UPDATE tbl_accounts SET acc_name = '$acc_name', acc_login = '$username', acc_password = '$password' WHERE acc_id = '$id'");

    if ($change) {
      $_SESSION['tableError'] = "Change Successful";
      header('Location: admin.php');
    }
  }

  $id = $_GET['id'];

  $get = mysqli_query($con, "SELECT * FROM tbl_accounts WHERE acc_id ='$id'");

  $profile = mysqli_fetch_array($con, $get);
}
?>

<!DOCTYPE html>
<html>

<head>
  <meta charset = "UTF-8">
  <title>Edit Page</title>
</head>

<body style = "background-color: #D3D3D3">

  <h1 style = "text-align: center;">Edit Form</h1>

    <form method = "POST">
    New Name:
    <input type = "text" name = "acc_name" required value = "<?php echo $profile['acc_name']; ?>" />
    <br><br>
    New Login:
    <input type = "text" name = "acc_login" required value = "<?php echo $profile['acc_login']; ?>" />
    <br><br>
    New Password:
    <input type = "password" name = "acc_password" required value = "<?php echo $profile['acc_password']; ?>" />
    <br><br><br>
    <input type = "submit" name = "submit" value = "Update" />
    <input type = "submit" name = "cancel" value = "Cancel" onclick = "location.href = 'admin.php';" />
    </form>

</body>

</html>
