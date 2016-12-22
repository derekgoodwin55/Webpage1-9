<?php
ini_set( 'display_errors','1');
error_reporting(E_ALL);

session_start();

include("database.php");

$error = "";

// Check that there are values entered for both username and password. Then check validity
if(isset($_POST["submit"])){
	if(empty($_POST["username"]) && empty($_POST["password"])){
		$error = "Please enter a valid value for both the Username and Password fields.";
	}

	else if(empty($_POST["username"])) {
		$error = "Please enter a valid value for User Login Field.";
	}

	else if(empty($_POST["password"])) {
		$error = "Please enter a valid value for the Password field.";
	}

	else {
		$username = trim($_POST['username']);
		$password = trim($_POST['password']);
		$password = sha1($password);
		$error = "";

		$db = new mysqli($db_servername, $db_username, $db_password, $db_name, $db_port);

		if($db->connect_error){
			die("Could not connect: " . mysql_error());
		}

		$sql_query = "SELECT acc_id FROM tbl_accounts WHERE acc_login='$username' AND acc_password='$password'";
		$result = $db->query($sql_query);

		if(mysqli_num_rows($result) == 1) {
			$_SESSION['username'] = $username;
			header("Location: Calendar.php");
		}

		else {
			$error = "Incorrect username or password.";
		}
	}
}
?>

<!DOCTYPE html>
<html>

<head>
	<meta charset="UTF-8">
	<title>goodw171-HW8</title>
	<link rel="stylesheet" type="text/css" href="style.css">
</head>

<body>

<div style = "border: 2px solid black;padding-left:15px;background-color:lightgray;">
    <h1 id = "loginH">Login Page</h1>
		    <div class="error" style = "color:red"><?php echo $error;?></div>
        <div class="error2" style = "color:black"><?php echo "Please enter your user's login name and password. Both values are case sensitive";?></div>
    <br><br>
    <form id = "inputlogin" method="post" action="">
        <label>Login:</label><br>
        <input type="text" name="username" /><br><br>
        <label>Password:</label><br>
        <input type="password" name="password" /><br><br>
        <input type="submit" name="submit" value="Submit" />
    </form>
		<br>
</div>
</body>

</html>
