<?php
require_once('initialize.php');
$room = trim($_GET['room']);
$content = '';

$page_title = 'Room Details';
include('header.php');

//select all properties from roomtype 
$query_str = "SELECT roomType, roomTypeDescription, bedType, area, numberOfOccupants, price, image FROM roomtype WHERE roomType = ?";
			  
$stmt = $db->prepare($query_str);
$stmt->bind_param('s',$room);
$stmt->execute();
$stmt->bind_result($room1,$descroption1,$bedtype1,$area1,$occupant1,$price1,$image1);

echo "<div class=\"details\">";
echo "<button type=\"button\"><a href=";
echo url_for('room.php');
echo ">&laquo; Back to room list</a></button> ";

//display results
if($stmt->fetch()) {
	echo "<h3>TYPE $room</h3>\n";
	echo "<div id=\"room-image\"><img src=$image1 width=\"500\" height=\"333\" alt=\"\" /></div>";
	echo "<p>";
	echo "Area $area1 m<sup>2</sup><br>
	Bed Type | $bedtype1 <br>
	1-$occupant1 Occupants<br>
	Check-in｜ 14:00<br>Check-out｜ 12:00<br><br>
	Room Rate <b>RMB $price1</b> /night<br>
	<em>Breakfast, Tax & Service Charge Included</em><br>
	<strong>Standard complimentary items and fixtures</strong><br>$descroption1<br>";
	// echo "$image1";
	echo "</p>";
}
$stmt->free_result();

//print out comments for the room type
$query_str = "SELECT members.firstName, comment.content, comment.timePosted
			  FROM comment 
			  JOIN members ON members.memberNumber = comment.memberNumber
			  WHERE comment.roomType = '".$room."'";
			  
//echo $query_str;

$res = $db->query($query_str);


echo "<p>";

echo "<strong>".$res->num_rows." Comments</strong>";

//only members can see the option of writing comments
if(isset($_SESSION['admin_id'])) {
	echo "\t<button tyep=\"button\">Write Comments</button>";
	echo "<br>";
	if(is_post_request() && isset($_POST['submit'])){
		$comment['content']=$_POST['content'] ?? '';
		$comment['room']=$room;
		$result = insert_comment($comment);
		if($result === true) {
	      echo "<p>Comment successful.</p>";
	      unset($_POST['submit']);
	      $comment='';
	    } else {
	      $errors = $result; //error message
	      echo $errors;
	    }
	}
	echo "<form action=\"roomdetails.php?room=$room\" method=\"POST\">";
	echo "<textarea rows=\"4\" cols=\"50\" name=\"content\"></textarea>
";
	echo "<button name=\"submit\">Submit</button>";
	echo "</form>";

} 
echo "<br>";

if($res->num_rows > 0) {
	while ($row = $res->fetch_assoc()) {
		echo $row['firstName']." | ".$row['timePosted']."<br />";
		echo $row['content']."<br />";
	}
}else{
	echo "No one has visited yet."; //show 0 result it there is nothing matched 
}

echo "</p>";
$res->free_result();




//check availability
echo "<form action=\"availability.php\" method=\"POST\">";
echo "<input type=\"submit\" value=\"Check Availability\">";
if($_SESSION['callback_url']!=url_for('reservation.php')){
	$_SESSION['room']=$room; //room viewed on reservation will not be added again 
}
echo "</form>";


echo "</div>";



include('footer.php');

$db->close();
?>

