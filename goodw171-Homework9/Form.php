<?php
ini_set('display_errors', 'On');
error_reporting(E_ALL);

session_start();

if(!isset($_SESSION['username'])) {
  header("Location: login.php");
}

// clear button variable
if(isset($_REQUEST['clear'])){
$setClear = $_REQUEST['clear'];
} else{
  // avoid undefined index
  $setClear = "";
}
// if set by clear button onclick, overwrite calendar.txt
if($setClear){
	file_put_contents('calendar.txt',"");
}
?>

<!DOCTYPE html
PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
"http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">

<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en"
lang="en">

<head>
	<title>Calendar Form</title>
	<meta charset = "UTF-8">
	<link href = "style.css" type = "text/css" rel = "stylesheet">
</head>

<body>

<div id = "logoutAndWelcome2">
  <br>
<?php
  // Display Username here
  echo "Welcome ";
  echo $_SESSION['username'];
?>
  <br>
  <button><a href= "logout.php">Logout</a></button>
</div>

<br><br>

<h1 id = "header2">Form Input</h1>

<br>

<nav id = "navlinks2">
  <br>
  <a href= "Calendar.php">Calendar</a>
  <a href= "Form.php" style = "margin-left: 20px;">Input</a>
  <a href= "admin.php" style = "margin-left: 20px;">Admin</a>
  <br><br>
</nav>

<br>

<script>
  function deleteFile(){
	  var req = new XMLHttpRequest();
	  req.onreadystatechange = function(){
	  window.location.href = "Calendar.php";
    }

	  req.open("GET", "Form.php?clear="+"true", true);
	  req.send();
  }
</script>

<?php
if(empty($event_name)){
	echo '<p style="color:red">Please provide a value for Event Name.</p>';
}
if(empty($start_time)){
	echo '<p style="color:red">Please select a value for Start Time.</p>';
}
if(empty($end_time)){
	echo '<p style="color:red">Please enter a value for Event End Time.</p>';
}
if(empty($location)){
	echo '<p style="color:red">Please enter a value for Event Location.</p>';
}
?>

<br>

<div>
	<form id = "theForm" action="http://www-users.cselabs.umn.edu/~goodw171/Calendar.php" method = "POST">
		<table class = "form">
		Event Name:
		<input type = "text" name = "event_name">
		<br><br>
		Start Time:
		<input type = "time" name = "start_time">
		<br><br>
		End Time:
		<input type = "time" name = "end_time">
		<br><br>
		Location:
		<input type = "text" name = "location">
		<br><br>
		Day of the Week:
		<select name = "day">
		<option value = "Monday">Monday</option>
		<option value = "Tuesday">Tuesday</option>
		<option value = "Wednesday">Wednesday</option>
		<option value = "Thursday">Thursday</option>
		<option value = "Friday">Friday</option>
		</select>
		<br>
		<br>
		<input type = "button" value = "Clear" name = "clear" onclick = "deleteFile()">
		<input type = "submit" value = "Submit" name = "submit">
	</table>
</div>

</body>

</html>
