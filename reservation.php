<?php
require_once('initialize.php');
// $booking_id=trim($_GET['bookingNumber']);
$_SESSION['callback_url']=url_for('reservation.php');

$page_title = 'Reservation';
include('header.php');

echo "<div class=\"reservation\">";

if(is_post_request()){

	$reserve['memberNumber']=$_SESSION['admin_id'];
	$reserve['bookingDate']=date("Y-m-d");
	$reserve['checkInDate']=$_SESSION['check_in'];
	$reserve['checkOutDate']=$_SESSION['check_out'];
	$reserve['numberOfGuests']=$_SESSION['occupants'];
	$reserve['numberOfRoomBooked']="1";
	$reserve['bedType']=$_SESSION['bed'];
	$reserve['roomType']=$_SESSION['room'];
	$reserve['priceEach']=$_SESSION['priceEach'];

	$result = insert_reserve($reserve);
    if($result === true) {
      $new_id = mysqli_insert_id($db); //insert id to database
      // $_SESSION['message'] = 'Reservation is confirmed.';
      $_SESSION['booking_id']=$new_id; //set session booking number
      
      echo "<h2>Thank you for your reservation!</h2>";
      echo "Your booking number is ".$_SESSION['booking_id'].".<br>";
      echo "Have a nice stay in MUJI!<br>";
      unset($_SESSION['check_in']);
      unset($_SESSION['check_out']);
      unset($_SESSION['occupants']);
      unset($_SESSION['bed']);
      unset($_SESSION['room']);
      unset($_SESSION['priceEach']);
    } else {
      $errors = $result; //error message
      echo $errors;
    }
}else{
	$reserve['memberNumber']='';
	$reserve['bookingDate']='';
	$reserve['checkInDate']='';
	$reserve['checkOutDate']='';
	$reserve['numberOfGuests']='';
	$reserve['numberOfRoomBooked']="1";
	$reserve['bedType']='';
	$reserve['roomType']='';
	$reserve['priceEach']='';
}

echo "<br>";

echo "<form action=\"profile.php\" method=\"POST\">";
echo "<input type=\"submit\" value=\"Go to profile\">";
echo "</form>";

echo "</div>";

include('footer.php');

?>