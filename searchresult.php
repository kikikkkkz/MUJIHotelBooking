<?php
require_once('initialize.php');

$page_title = 'Search Results';
include('header.php');

if(isset($_SESSION['check_in'])) $checkIn = $_SESSION['check_in'];
if(isset($_SESSION['check_out'])) $checkOut = $_SESSION['check_out'];

//echo $_SESSION['check_in'];

echo "<div class=\"result\">";
echo "<div class=\"section\">";
echo "<br /><h1>Choose a room
	</h1>";

echo "Check-in | $checkIn<br />"; 
echo "Check-out | $checkOut<br />";
?>


<button type="button"><a href="<?php echo url_for('search.php'); ?>" style= "text-decoration:none;">Edit Search</a></button>

<?php

echo "<h2><strong>The Accomodations</strong></h2>";
echo "<p>All trips, whether for business, sightseeing or long-term stays, are supported first and foremost by quality sleep. We designed a space for exceptional relaxation, providing indirect lighting to release tension and guide guests to a comfortable slumber; coil mattresses with the best firmness for any sleeping position; gently enveloping bath towels, and so on. </p><br />";


//set sql query string and get the results from database
$query_str = "SELECT DISTINCT room.roomType, roomtype.roomTypeDescription, 
			  roomtype.bedType, roomtype.area, roomtype.numberOfOccupants, roomtype.price, roomtype.image 
			  FROM room
			  LEFT JOIN roomtype ON room.roomType = roomtype.roomType
			  WHERE room.roomNumber NOT IN
			  (	SELECT roomNumber 
				FROM reservation
				WHERE checkInDate <= '".$checkIn."' AND checkOutDate > '".$checkIn."'
			 	OR (checkInDate < '".$checkOut."' AND checkOutDate >= '".$checkOut."')
			 	OR (checkInDate >= '".$checkIn."' AND checkOutDate <= '".$checkOut."')
			  ) 
			  ORDER BY room.roomType;";




$res = $db->query($query_str);


//debugging
//echo "<br />$query_str";

//prinitng out the number of results
echo "<br /><b>".$res->num_rows."</b> types of rooms are available";
echo "</div>";

echo "<div class=\"roomtype\">";
if($res->num_rows > 0) {
	while ($row = $res->fetch_assoc()) {	
		$id=$row['roomType'];
		echo "<form action=\"confirm.php?room=$id\" method=\"POST\">";
		echo "<h3>TYPE ".$row['roomType']."</h3>\n";

		echo "<div class=\"box\">";
		$img=explode(";",$row['image']);
		echo "<div id=\"room-image\"><img src=".$img[0]." width=\"100%\" alt=\"\" /></div>";
		echo "<p></div>";

		echo "<div class=\"box\">";
		echo "Area ".$row['area']."m<sup>2</sup><br>
		Bed Type | ".$row['bedType']." <br>
		1-".$row['numberOfOccupants']. " Occupants<br>
		Check-in｜ 14:00<br>Check-out｜ 12:00<br>
		Room Rate <b>RMB ".$row['price']."</b> /night<br>
		<em>Breakfast, Tax & Service Charge Included</em><br>
		<strong>Standard complimentary items and fixtures</strong><br>".$row['roomTypeDescription']."<br>";
		// echo "$image1";
		echo "</p>";

		//booking information
		// echo "<form action=\"reservation.php\" method=\"POST\">";
		echo "No. of Room(s) | 1<br>";
		echo "Number of Guest(s) <select name=\"occupants\"><option value=\"1\">1</option><option value=\"2\">2</option></select>";
		echo "<br>";
		if($row['roomType']=='A'){
			echo "<input type=\"radio\" name=\"bed\" value=\"Double\" checked> Double<br>";
		}
		else if($row['roomType']=='E'){
			echo "<input type=\"radio\" name=\"bed\" value=\"Twin\" checked> Twin<br>";
		}else{
			echo "<input type=\"radio\" name=\"bed\" value=\"Double\" checked> Double 
			<input type=\"radio\" name=\"bed\" value=\"Twin\"> Twin<br>";
		}
		echo "<br>";
		echo "<input type=\"submit\" name=\"book\" value=\"Book\">";
		// if($_SESSION['callback_url']!=url_for('search.php')){
		// 	$_SESSION['room']=$row['roomType']; //room viewed on reservation will not be added again 
		// }
		echo "</form>";
		echo "</div>";
	} 
} else  {
	echo "There are currently no rooms available "; //show 0 result it there is nothing matched 
}
echo "</div>";

echo "</div>";

$res->free_result();
$db->close();

include('footer.php');
?>