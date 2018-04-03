<?php
require_once('initialize.php');
$id=$_SESSION['admin_id'];

//select all properties from roomtype 
$query_str = "SELECT lastName,firstName,email,phoneNumber,country FROM members WHERE memberNumber = ?";
			  
$stmt = $db->prepare($query_str);
$stmt->bind_param('i',$id);
$stmt->execute();
$stmt->bind_result($last1,$first1,$email1,$phone1,$country1);;

$page_title = 'Profile';
include('header.php');

echo "<div class=\"login\">";

//display results
if($stmt->fetch()) {
	echo "<h4>Hello, $first1 $last1!</h4>\n";
	echo "<table cellspacing=5><p>";
	echo "<tr><td>Email</td> <td>|</td> <td>$email1</td></tr>
	<tr><td>Phone Number</td> <td>|</td> <td>$phone1</td></tr> 
	<tr><td>Country</td> <td>|</td> <td>$country1</td></tr>";
	echo "</p></table><br />";
}
$stmt->free_result();

echo "<p>";
echo "<b>Your Reservation</b><br>";

$query_str = "SELECT bookingNumber, checkInDate, checkOutDate, priceEach, roomType FROM reservation WHERE memberNumber=?";

$stmt = $db->prepare($query_str);
$stmt->bind_param('i',$id);
$stmt->execute();
$stmt->bind_result($booking1,$checkin1,$checkout1,$price1,$room1);;

echo "<table cellspacing=5>";
if($stmt->fetch()) {
	echo "<tr><td>Booking Number <b>$booking1</b></td> <td>|</td> <td>$checkin1 ~ $checkout1</td></tr>";
	echo "<tr><td></td> <td>|</td> <td>Type $room1</td></tr>";
	echo "<tr><td></td> <td>|</td> <td>RMB $price1 /night</td></tr>";
}
echo "</p></table>";


$stmt->free_result();

echo "<br>";

//print out comments posted by the member
$query_str = "SELECT content, timePosted, roomType FROM comment WHERE memberNumber = ".$id."";
			  
$res = $db->query($query_str);

echo "<p>";
echo "<b>Your Comments</b><br>";
echo "<table cellspacing=5>";
if($res->num_rows > 0) {
	while ($row = $res->fetch_assoc()) {
		echo "<tr><td>".$row['timePosted']."</td> <td>|</td>"; 
		echo "<td><b><a href=";
		echo url_for('roomdetails.php?room='.$row['roomType']);
		echo ">Type ".$row['roomType']."</a></b></td></tr>";
		echo "<tr><td> <td>|</td> </td><td>".$row['content']."</td></tr>";
	}
}else{
	echo "Haven't posted any comments yet."; //show 0 result it there is nothing matched 
}
echo "</p></table>";
echo "</div>";


$res->free_result();

include('footer.php');

$db->close();
?>

