<?php
require_once('initialize.php');
$id=$_SESSION['admin_id'];

//select all properties from roomtype 
$query_str = "SELECT lastName,firstName,email,phoneNumber,country FROM members WHERE memberNumber = ?";
			  
$stmt = $db->prepare($query_str);
$stmt->bind_param('i',$id);
$stmt->execute();
$stmt->bind_result($last1,$first1,$email1,$phone1,$country1);;

include('header.php');

//display results
if($stmt->fetch()) {
	echo "<h4>Hello, $first1 $last1!</h4>\n";
	echo "<p>";
	echo "Email: $email1<br>
	Phone Number: $phone1 <br>
	Country: $country1<br><br>";
	echo "</p>";
}

$query_str = "SELECT bookingNumber FROM reservation WHERE memberNumber = ?";
			  
$stmt = $db->prepare($query_str);
$stmt->bind_param('i',$id);
$stmt->execute();
$stmt->bind_result($booking1);;

if($stmt->fetch()) {
	echo "<p>";
	echo "Your Reservation: $booking1";
	echo "</p>";
}

include('footer.php');

$stmt->free_result();
$db->close();
?>

