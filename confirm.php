<?php
require_once('initialize.php');

$room=trim($_GET['room']);
$_SESSION['room']=$room;
$_SESSION['callback_url']=url_for('confirm.php?room='.$room);

$page_title = 'Confirm';
include('header.php');

echo "<div class=\"confirm\">";
// if(is_post_request()){ 
// 	$_SESSION['submit']='true'; 
// }
require_login();

//get session id
$id=$_SESSION['admin_id'];
$query_str = "SELECT lastName,firstName,email,phoneNumber FROM members WHERE memberNumber = ?";

$stmt = $db->prepare($query_str);
$stmt->bind_param('i',$id);
$stmt->execute();
$stmt->bind_result($last1,$first1,$email1,$phone1);;

if($stmt->fetch()) {
	echo "<h2>$first1,</h2>";
	echo "<h3>please confirm your booking</h3>\n";
	echo "<table cellspacing=5><p>";
	echo "<tr><td>Name</td> <td>|</td> <td>$first1 $last1</td></tr>
	<tr><td>Email</td> <td>|</td> <td>$email1</td></tr>
	<tr><td>Phone Number</td> <td>|</td> <td>$phone1</td></tr>";
	echo "</p></table><br />";
}
$stmt->free_result();

echo "<br>";

$checkIn = $_SESSION['check_in'];
$checkOut = $_SESSION['check_out'];
echo "Check-in | $checkIn 14:00<br>";
echo "Check-out | $checkOut 12:00<br>";

echo "<br>";

$query_str = "SELECT price FROM roomtype WHERE roomType = ?";

$stmt = $db->prepare($query_str);
$stmt->bind_param('s',$room);
$stmt->execute();
$stmt->bind_result($price1);;


echo "<h3>Room Information</h3>";
if($stmt->fetch()) {
	echo "<b>Room type</b> | Type $room<br>";
	echo "<b>Price</b> | RMB $price1 /night<br>";
}
$_SESSION['priceEach']=$price1;

$stmt->free_result();

echo "<b>Number of room</b> | 1<br>";
$occupants=$_POST['occupants'] ?? '';
$_SESSION['occupants']=$occupants;
echo "<b>Number of guests</b> | ".$occupants."<br>";
$bed=$_POST['bed'] ?? '';
$_SESSION['bed']=$bed;
echo "<b>Type of bed type</b> | ".$bed."<br>";

echo "<br>";
echo "<form action=\"reservation.php\" method=\"POST\">";
echo "<input type=\"submit\" value=\"Confirm\">";
// $_SESSION['submit']='true';
echo "</form>";

echo "</div>";

include('footer.php');
// $res->free_result();
$db->close();

?>