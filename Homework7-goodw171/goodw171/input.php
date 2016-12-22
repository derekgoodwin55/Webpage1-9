<?php

//ini_set('display_errors', 'On');
//error_reporting(E_ALL);


// clear button variable
$setClear = $_REQUEST['clear'];

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

	<h1>Calendar Input</h1>

	<nav id = "navlinks2">
		<a href= "calendar.php">Calendar</a>
		<a href= "input.php">Input</a>
	</nav>
	
	<script>

	function deleteFile(){
		var req = new XMLHttpRequest();
		
		req.onreadystatechange = function(){
			window.location.href = "calendar.php";
		}
		
		req.open("GET", "input.php?clear="+"true", true);
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
	<form id = "theForm" action="http://www-users.cselabs.umn.edu/~goodw171/calendar.php" method = "POST">
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
