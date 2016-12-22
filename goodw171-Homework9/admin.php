<?php
session_start();

?>

<!DOCTYPE	html>
<html>

<head>
	<meta charset="UTF-8">
	<title>Admin Page</title>
	<link href = "style.css" type = "text/css" rel = "stylesheet">
</head>

<body>

<div id = "adminPage">

<div id = "AlogoutButton" style = "border: 2px solid black;">
	<br>

	<button style = "background-color:gray;padding:10px;"><a href= "logout.php">Logout</a></button>

  <h2>Welcome <?php echo ($_SESSION['username']);?></h2>

  <button style = "background-color:gray;padding:10px;"><a href= "Calendar.php">Calendar</a></button>
  <button style = "background-color:gray;padding:10px;margin-left:5px;"><a href= "Form.php">Input</a></button>
  <button style = "background-color:gray;padding:10px;margin-left:5px;"><a href= "admin.php">Admin</a></button>

	<br><br>

<?php echo 'This page is protected from the public, and you can see a list of all users defined in the database.';?>

  <br><br>
</div>

<div style = "background-color: white;">
  <br>
</div>

<div style = "border: 2px solid black;">
	<h1 style = "padding-left:15px;">List of Users</h1>

<?php
	include_once("database.php");

	$con = mysqli_connect($db_servername, $db_name, $db_password, $db_username, $db_port);

	$selection = "SELECT * FROM tbl_accounts";

	$result = $con->query($selection);

  // Print table action
  echo "<div style = 'color:red;padding-left:30px;'>";
  echo htmlentities($_SESSION['tableError']);
  echo "<br><br>";
  echo "</div>";

  echo "<div style = 'padding-left:30px;'>";
  echo "<table border='1' cellpadding='20'> ";
  echo "<tr>
	  <th>ID</th>
		  <th>Name</th>
		  <th>Login</th>
		  <th>Go to Edit Page</th>
		  <th>Delete</th>
	  </tr>";

  while($row = $result->fetch_assoc()){
	  echo "<tr>";
	  echo '<td>' . $row['acc_id'] . '</td>';
	  echo '<td>' . $row['acc_name'] . '</td>';
	  echo '<td>' . $row['acc_login'] . '</td>';
	  echo '<td><a href = "edit.php?id=' . $row['acc_id'] . '">Edit</a></td>';
	  echo '<td><a href = "delete.php?id=' . $row['acc_id'] . '">Delete</a></td>';
	  echo "</tr>";
  }
  echo "</table>";
	echo "<br><br>";
  echo "</div>";
?>
</div>

<div style = "background-color: white;">
  <br>
</div>

<div style = "border: 2px solid black;padding-left:15px;">

	<h1>Add New User</h1>

	<form action = "add.php" method = "POST" style = "font-weight:bold;">
	  Name:
	  <input type = "text" name = "acc_name" required placeholder = "Enter your name" style = "margin-left:2px;" />
    <br><br>
	  Login:
	  <input type = "text" name = "acc_login" required placeholder = "Enter your Login" style = "margin-left:2px;" />
    <br><br>
	  Password:
	  <input type = "password" name = "acc_password" required placeholder = "Enter your Password" style = "margin-left:2px;" />
    <br><br>
	  <input type = "submit" name = "send" value = "Submit" />
  </form>
  <br><br>
</div>

</div>

</body>

</html>
