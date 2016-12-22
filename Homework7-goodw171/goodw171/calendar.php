<?php
 ini_set('display_errors', 'On');
 error_reporting(E_ALL);


// create variables only if post method to avoid Undefined index error
if($_SERVER["REQUEST_METHOD"] === "POST"){

	$event_name = $_POST['event_name'];
	$start_time = $_POST['start_time'];
	$end_time = $_POST['end_time'];
	$location = $_POST['location'];
	$day = $_POST['day'];
	$submit = $_POST['submit'];
}

// can we append to calendar.txt due to no empty fields?
$no_empty_values = true;

// get contents and decode
$file = file_get_contents('calendar.txt');

$json = json_decode($file,true);

// $json2 = usort($json, jSort);

// If one or more form entry was blank, set a flag and redirect back to input.php
if( empty($event_name) or empty($start_time) or empty($end_time) or empty($location) ){
	$no_empty_values = false;
	
	// check to see if user failed to fill in all fields. If so, do not add entry.
	if(isset($submit)){
		echo "Not all fields filled in. Entry not added";
		echo '<script>window.location.href = "input.php";</script>';
	}
}

// Append to file because no fields were blank
if($no_empty_values){
	
	$input = array('eventname' => "$event_name", 'starttime' => "$start_time", 'endtime' => "$end_time", 'location' => "$location");

	// if key exists, append
	if(array_key_exists($day, $json)){
		array_push($json[$day], $input);
	}
	// else create key and add corresponding	
	else{
		$json["$day"] = array($input);
	}
	
	// sort array based on time
	foreach($json as $k=> $v){
		usort($json[$k], function($a, $b){
			return $a['starttime'] < $b['starttime'] ? -1 : 1;
		});
	}
	
	$ret = file_put_contents('calendar.txt', json_encode($json));
}

// get contents again to include appended material if necessary
$file = file_get_contents('calendar.txt');

?>

<!DOCTYPE html
PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
"http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">

<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en"
lang="en">

<head>

	<title>Derek's Calendar</title>
	<meta name = "viewport" content = "initial-scale=1.0">
	<meta charset = "UTF-8">
	<link href = "style.css" type = "text/css" rel = "stylesheet">
    <style>
      html, body {
        height: 100%;
        margin: 0;
        padding: 0;
      }
      #map {
        height: 50%;
	margin-left: 15px;
	margin-right: 15px;
	margin-bottom: 25px;

      }
    </style>

    <script>

function initMap() {

	var map;

	map = new google.maps.Map(document.getElementById('map'), {
        	center: {lat: 44.974, lng: -93.234},
		zoom: 15
	});

// make geocoder object
	var geocoder = new google.maps.Geocoder();

// geocoder Event Listener and function call
        document.getElementById('submit').addEventListener('click', function() {
		geocodeAddress(geocoder, map);
	});
	
// add markers to map based on entered location	
<?php
if(!empty($fileToParse)){
	foreach($fileToParse as $k=>$v){
		foreach($v as $v1){
			$markerEvent = $v1['eventname'];
			$markerLoc = $v1['location'];
			
			echo '<script>	var tempMarker = new google.maps.Marker({
		position: $markerLoc,
		map: map
		}); </script>';
			
		}
	}
}
?>


// end initMap()
}


// Google API used as a base via https://developers.google.com/maps/documentation/javascript/examples/geocoding-simple
function geocodeAddress(geocoder, resultsMap) {
	var address = document.getElementById('address').value;
        geocoder.geocode({'address': address}, function(results, status) {
	if (status === 'OK') {
		var marker = new google.maps.Marker({
		map: resultsMap,
		position: results[0].geometry.location,
		});
// change zoom and center after geocoding
		resultsMap.fitBounds(results[0].geometry.viewport);
		resultsMap.setCenter(results[0].geometry.location);
	}else {
		alert('Geocode was not successful: ' + status);
	}
        });
}

</script>

<script src= "http://maps.googleapis.com/maps/api/js?key=AIzaSyDTtpwUM1jnnVZZ3qoQ9y1GTcgLUIqGHKo&callback=initMap&libraries=places" async defer></script>

</head>

<body>

	<h1>My Calendar</h1>
	<p></p>

	<nav id = "navlinks1">
		<a href= "calendar.php">Calendar</a>
		<a href= "input.php">Input</a>
	</nav>
	<br>

<div id = "PHPTable">
<?php

// check to see if calendar.txt is empty (there is no data). If so echo a message
if($file === ""){
	echo '<p style="color:red">Calendar has no events. Please use the input page to enter some events.</p>';
}

// Decode file
$fileToParse = json_decode($file,true);      

// create table in PHP by accessing JSON keys and values. Check to make sure there is data first.
if(!empty($fileToParse)){
	print "<table>";
	
	
	foreach($fileToParse as $k=>$v){
		if($k === "Monday"){
		print "<tr><th>$k</th>";
		foreach($v as $v1){
			$event = $v1['eventname'];
			$s_time = $v1['starttime'];
			$e_time = $v1['endtime'];
			$loc = $v1['location'];
			print "<td><i>$s_time - $e_time</i><br><br> $loc - $event</td>";
		}
		print "</tr>";
		}
	}
	foreach($fileToParse as $k=>$v){
		if($k === "Tuesday"){
		print "<tr><th>$k</th>";
		foreach($v as $v1){
			$event = $v1['eventname'];
			$s_time = $v1['starttime'];
			$e_time = $v1['endtime'];
			$loc = $v1['location'];
			print "<td><i>$s_time - $e_time</i><br><br> $loc - $event</td>";
		}
		print "</tr>";
		}
	}
	foreach($fileToParse as $k=>$v){
		if($k === "Wednesday"){
		print "<tr><th>$k</th>";
		foreach($v as $v1){
			$event = $v1['eventname'];
			$s_time = $v1['starttime'];
			$e_time = $v1['endtime'];
			$loc = $v1['location'];
			print "<td><i>$s_time - $e_time</i><br><br> $loc - $event</td>";
		}
		print "</tr>";
		}
	}
	foreach($fileToParse as $k=>$v){
		if($k === "Thursday"){
		print "<tr><th>$k</th>";
		foreach($v as $v1){
			$event = $v1['eventname'];
			$s_time = $v1['starttime'];
			$e_time = $v1['endtime'];
			$loc = $v1['location'];
			print "<td><i>$s_time - $e_time</i><br><br> $loc - $event</td>";
		}
		print "</tr>";
		}
	}
	foreach($fileToParse as $k=>$v){
		if($k === "Friday"){
		print "<tr><th>$k</th>";
		foreach($v as $v1){
			$event = $v1['eventname'];
			$s_time = $v1['starttime'];
			$e_time = $v1['endtime'];
			$loc = $v1['location'];
			print "<td><i>$s_time - $e_time</i><br><br> $loc - $event</td>";
		}
		print "</tr>";
		}
	}
	
	
	print "</table>";
}

?>

</div>

<br>

<div id = "searchbar">
	<form>
		<input id = "address" type = "text">
		<input id = "submit" type = "button" value = "Search">
	</form>
<br>

</div>

<div id = "map"></div>

</body>

</html>
