<?php
require_once('initialize.php');

$room=trim($_GET['room']);
$_SESSION['room']=$room;
$_SESSION['callback_url']=url_for('confirm.php?room='.$room);

$page_title = 'Confirm';
include('header.php');
echo "<h2>Confirm your booking</h2>";
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
	echo "Name: $first1 $last1<br>Email: $email1<br>Phone number: $phone1<br>";
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

if($stmt->fetch()) {
	echo "Room type: $room<br>Price: RMB $price1/night<br>";
}
$_SESSION['priceEach']=$price1;

$stmt->free_result();

echo "Number of room: 1<br>";
$occupants=$_POST['occupants'] ?? '';
$_SESSION['occupants']=$occupants;
echo "Number of guests: ".$occupants."<br>";
$bed=$_POST['bed'] ?? '';
$_SESSION['bed']=$bed;
echo "Type of bed type: ".$bed."<br>";

echo "<br>";
echo "<form action=\"reservation.php\" method=\"POST\">";
echo "<input type=\"submit\" value=\"Confirm\">";
// $_SESSION['submit']='true';
echo "</form>";

include('footer.php');
// $res->free_result();
$db->close();

?>