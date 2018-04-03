<?php
require_once('initialize.php');
// $booking_id=trim($_GET['bookingNumber']);
$_SESSION['callback_url']=url_for('reservation.php');

$page_title = 'Reservation';
include('header.php');

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
      // redirect_to(url_for('reservation.php?bookingNumber='.$new_id)); //return to previous page
      echo "<h2>Thank you for your reservation!</h2>";
      echo "Your booking number is ".$_SESSION['booking_id'];
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
// echo "<h2>Thank you for your reservation!</h2>";
// echo "Your booking number is ".$booking_id;
// if(is_post_request()){ $_SESSION['submit']='true';}
// require_login();

//get session id
// $id=$_SESSION['admin_id'];

// 	if(isset($_SESSION['prod'])){
// 		if(isset($_SESSION['submit'])){
// 			$item = $_SESSION['prod'];
// 			$result = insert_watchlist($item);
// 			echo "Successfully added $item.";
// 		}
// 		unset($_SESSION['prod']);
// 		unset($_SESSION['submit']);
// 	}
echo "<br>";
echo "<form action=\"profile.php\" method=\"GET\">";
echo "<input type=\"submit\" value=\"Go to profile\">";
echo "</form>";

include('footer.php');
// $res->free_result();
// $db->close();

?>