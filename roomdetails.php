<?php
require_once('initialize.php');
$room = trim($_GET['room']);
$_SESSION['room']=$room;
$content = '';
$result = '';

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

//display comments for the room type
echo "<div id=\"display_comment\"></div>";

//only members can see the option of writing comments
if(isset($_SESSION['admin_id'])) {
?>
<html>
<body>
<a href=# class="comment_link"><b>Write Comments</b></a>
<form method="POST" id="comment_form" class="dno">
    <div class="form-group">
     <input type="hidden" name="comment_type" id="comment_type" value="<?php echo $room;?>" />
     <textarea rows="4" cols="50" id="comment_name" name="comment_name"></textarea>
    </div>
    <div class="form-group">
     <input type="submit" name="submit" id="submit" class="btn btn-info" value="Submit" />
    </div>
   </form>
   <span id="comment_message"></span>
   <br />
</body>
</html>
<?php
	// echo "<br>";
	// if(is_post_request() && isset($_POST['submit'])){
	// 	$comment['content']=$_POST['content'] ?? '';
	// 	$comment['room']=$room;
	// 	$result = insert_comment($comment);
	// 	if($result === true) {
	//       echo "<p>Comment successful.</p>";
	//       unset($_POST['submit']);
	//       $comment='';
	//     } else {
	//       $errors = $result; //error message
	//       echo $errors;
	//     }
	// }
	// echo "<a href=# class=\"comment_link\">Write Comments</a>";
	// echo "<div class=\"comment_form dno\">";
	// echo "<form method=\"POST\">";
	// echo "<textarea rows=\"4\" cols=\"50\" id=\"comment_name\" name=\"comment_name\"></textarea>";
	// echo "<br /><button name=\"submit\" id=\"submit\">Post Comments</button>";
	// echo "</form></div>";
	// echo "<span id=\"comment_message\"></span>";
} 


?>

<style>
.dno {
	display: none;
}
</style>
<script>
$(document).ready(function(){
	$(".comment_link").on("click",function(event) {
		event.preventDefault();
		$(this).hide();
		$("#comment_form").show();
	});

	$("#comment_form").on("submit", function(event) {
		event.preventDefault();
		var form_data = $(this).serialize();
		// alert(form_data);
		$.ajax({
			url: "add_comment.php",
			method: "POST",
			data: form_data,
			dataType: "JSON",
			success: function(data) {
				if(data.errors != '') {
					$('#comment_form')[0].reset();
					$('#comment_message').fadeIn().html(data.errors);
					setTimeout(function(){
						$('#comment_message').fadeOut("slow");
					},2000);
					load_comment();
				}
			}
		})
		// $(this).hide();
		// $(".comment_link").show();
	});

	load_comment();

	function load_comment()
	{
	  $.ajax({
	   url:"fetch_comment.php",
	   method:"POST",
	   success:function(data)
	   {
	    $('#display_comment').html(data);
	   }
	  })
	}

});

</script>

<?php

//check availability
// echo "<form action=\"availability.php\" method=\"POST\">";
// echo "<input type=\"submit\" value=\"Check Availability\">";
// if($_SESSION['callback_url']!=url_for('reservation.php')){
// 	$_SESSION['room']=$room; //room viewed on reservation will not be added again 
// }
// echo "</form>";


echo "</div>";



include('footer.php');

$db->close();
?>

