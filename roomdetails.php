<?php
require_once('initialize.php');
$room = trim($_GET['room']);

//select all properties from roomtype 
$query_str = "SELECT roomType, roomTypeDescription, bedType, area, numberOfOccupants, price, image FROM roomtype WHERE roomType = ?";
			  
$stmt = $db->prepare($query_str);
$stmt->bind_param('s',$room);
$stmt->execute();
$stmt->bind_result($room1,$descroption1,$bedtype1,$area1,$occupant1,$price1,$image1);

$page_title = 'Room Details';
include('header.php');

echo "<a href=";
echo url_for('room.php');
echo ">Back to room list</a> ";

//display results
if($stmt->fetch()) {
	echo "<h3>Type $room</h3>\n";
	echo "<div id=\"room-image\"><img src=$image1 width=\"300\" height=\"200\" alt=\"\" /></div>";
	echo "<p>";
	echo "Area $area1 m<sup>2</sup><br>
	Bed Type | $bedtype1 <br>
	1-$occupant1 Occupants<br>
	Check-in｜ 14:00<br>Check-out｜ 12:00<br>
	Room Rate RMB $price1 /night<br>
	<em>Breakfast, Tax & Service Charge Included</em><br>
	<strong>Standard complimentary items and fixtures</strong><br>$descroption1<br>";
	// echo "$image1";
	echo "</p>";
}

//booking information
echo "<form action=\"reservation.php\" method=\"POST\">";
echo "No. of Room(s) | 1<br>";
echo "Number of Guest(s) <select name=\"occupants\"><option value=\"1\">1</option><option value=\"2\">2</option></select>";
echo "<br>";
echo "<input type=\"radio\" name=\"bed\" value=\"double\" checked> Double 
  <input type=\"radio\" name=\"bed\" value=\"twin\"> Twin<br>";
echo "<br>";
echo "<input type=\"submit\" value=\"Book\">";
if($_SESSION['callback_url']!=url_for('reservation.php')){
	$_SESSION['room']=$room; //room viewed on reservation will not be added again 
}
echo "</form>";

include('footer.php');

$stmt->free_result();
$db->close();
?>

