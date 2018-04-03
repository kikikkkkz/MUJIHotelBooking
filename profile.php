<?php
require_once('initialize.php');
$id=$_SESSION['admin_id'];

$page_title = 'Profile';
include('header.php');

//select all properties from roomtype 
$query_str = "SELECT lastName,firstName,email,phoneNumber,country FROM members WHERE memberNumber = ?";
			  
$stmt = $db->prepare($query_str);
$stmt->bind_param('i',$id);
$stmt->execute();
$stmt->bind_result($last1,$first1,$email1,$phone1,$country1);;

//display results
if($stmt->fetch()) {
	echo "<h4>Hello, $first1 $last1!</h4>\n";
	echo "<p>";
	echo "<strong>Your Profile</strong><br>";
	echo "Email: $email1<br>
	Phone Number: $phone1 <br>
	Country: $country1<br><br>";
	echo "</p>";
}
$stmt->free_result();

$query_str = "SELECT bookingNumber, checkInDate, checkOutDate, priceEach, roomType FROM reservation WHERE memberNumber=".$id."";
			  
$res = $db->query($query_str);

echo "<p>";
echo "<strong>Your Reservation</strong><br>";
if($res->num_rows > 0) {
	while ($row = $res->fetch_assoc()) {
		echo "Booking Number ".$row['bookingNumber']." | ".$row['checkInDate']." ~ ".$row['checkOutDate']."<br>";
		echo "Type ".$row['roomType']." RMB ".$row['priceEach']."/night<br>";
	}
}else{
	echo "Haven't made any reservations yet."; //show 0 result it there is nothing matched 
}
echo "</p>";
$res->free_result();

echo "<br>";

//print out comments posted by the member
$query_str = "SELECT content, timePosted, roomType FROM comment WHERE memberNumber = ".$id."";
			  
$res = $db->query($query_str);

echo "<p>";
echo "<strong>Your Comment</strong><br>";
if($res->num_rows > 0) {
	while ($row = $res->fetch_assoc()) {
		echo $row['timePosted']." | Type ".$row['roomType']." - ".$row['content']."<br>";
	}
}else{
	echo "Haven't posted any comments yet."; //show 0 result it there is nothing matched 
}
echo "</p>";
$res->free_result();

include('footer.php');

$db->close();
?>

