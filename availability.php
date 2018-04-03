<?php
require_once('initialize.php');

$page_title = 'Room Availability'; 
include('header.php');

echo "<div class=\"availability\">";

$errors = [];
$typeCheckIn = $typeCheckOut = $room = '';

if(isset($_SESSION['room'])) $room = $_SESSION['room']; 
//echo $room;

echo "<button type=\"button\"><a href=";
echo url_for('roomdetails.php?room='.$room);
echo ">&laquo; Back to Type $room</a></button> ";

echo "<h1>Availability of TYPE $room</h1>";


if(is_post_request()) {
	if(isset($_POST['typeCheckIn'])) $typeCheckIn = $_POST['typeCheckIn'];
	if(isset($_POST['typeCheckOut'])) $typeCheckOut = $_POST['typeCheckOut'];


	// Validations
  if(is_blank($typeCheckIn)) {
    $errors[] = "Check-In date cannot be blank.";
  }
  if(is_blank($typeCheckOut)) {
    $errors[] = "Check-Out date cannot be blank.";
  }

  if(empty($errors)) {

  	//$search_failure_msg = "Search was unsuccessful.";
	//save to session
	$_SESSION['check_in'] = $typeCheckIn;
	$_SESSION['check_out'] = $typeCheckOut;
     // echo $_SESSION['check_in'];
     // echo $_SESSION['check_out'];
	//redirect_to(url_for('searchresult.php?checkIn='.$typeCheckIn.'checkOut='.$typeCheckOut));
	}
}

// $_SESSION['callback_url']=url_for('search.php');

//set sql query string and get the results from database
$query_str = "SELECT DISTINCT room.roomType, room.roomNumber, reservation.checkInDate, reservation.checkOutDate
              FROM room 
              LEFT JOIN reservation ON reservation.roomNumber = room.roomNumber
              WHERE room.roomType = '".$room."' 
              ORDER BY room.roomNumber;";


$res = $db->query($query_str);

//prinitng out the number of results
echo "<br /><b>".$res->num_rows."</b> booked timeslots for Type $room";

if($res->num_rows > 0) {
    while ($row = $res->fetch_assoc()) {    
        echo "<br />Room : ".$row['roomNumber']." of Type ".$row['roomType']." is unavailable from ".$row['checkInDate']." to ".$row['checkOutDate']."<br />";
    } 
} else  {
    echo "There are currently no rooms available "; //show 0 result it there is nothing matched 
}


echo "</div>";

//testing
$query_str = "SELECT DISTINCT reservation.checkInDate, reservation.checkOutDate
              FROM room 
              LEFT JOIN reservation ON reservation.roomNumber = room.roomNumber
              WHERE room.roomType = '".$room."' 
              ORDER BY room.roomNumber;";

$res = $db->query($query_str);

//debugging
//echo "<br />$query_str";

while ($row = $res->fetch_assoc()) {
    $fromDate = $row['checkInDate'];
    $toDate = $row['checkOutDate'];
    echo $fromDate.$toDate;
}


?>

<!DOCTYPE html>


<html>
<head>
	<!-- jquery -->
	<script src="https://code.jquery.com/jquery-2.2.4.js"></script>
	<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
	<link href="https://code.jquery.com/ui/1.11.3/themes/smoothness/jquery-ui.css" rel="stylesheet">

	<script>
		$(document).ready(function () {
            var startDate, endDate, dateRange = [];

            $("#typeCheckIn").datepicker({
                dateFormat : 'yy-mm-dd',
                onSelect: function (date) {
                    startDate = $(this).datepicker("getDate");
                }
            });
            $("#typeCheckOut").datepicker({
                dateFormat : 'yy-mm-dd',
                onSelect: function (date) {
                    endDate = $(this).datepicker("getDate");
                    for (var d = new Date(startDate);
                        d <= new Date(endDate);
                        d.setDate(d.getDate() + 1)) {
                            dateRange.push($.datepicker.formatDate('yy-mm-dd', d));
                    }
                }
            });

            $("#typeCheckIn, #typeCheckOut").datepicker("setDate", new Date());

            $('#dt').datepicker({
                beforeShowDay: function (date) {
                    var dateString = jQuery.datepicker.formatDate('yy-mm-dd', date);
                    console.log(dateString);
                    return [dateRange.indexOf(dateString) == -1];
                }
            });

		})
	</script>

</head>

<body>
    <!-- <div class="search">

	<?php echo display_errors($errors); ?>

    <div class="search1">
	<form action="availability.php" method="post">
		<table>
		<tr><th>Check-in </th>
		<th>Check-out </th></tr>
		
		<tr>
			<td><input type="text" name="typeCheckIn" id="typeCheckIn" placeholder="When to arrive" value="<?php if(isset($_POST['typeCheckIn'])) echo $_POST['typeCheckIn'] ?>"> </td>
			<td><input type="text" name="typeCheckOut" id="typeCheckOut" placeholder="When to leave" value="<?php if(isset($_POST['typeCheckOut'])) echo $_POST['typeCheckOut'] ?>"> </td>
			<td><input type="submit" id="search" value="Search"></td>
		</tr>
		
		</table>
	</form>
    </div>
    </div> -->


    Start:
    <input id="typeCheckIn" value="<?php echo $fromDate;?>" />
    End:
    <input id="typeCheckOut" value="<?php echo $toDate;?>" />
    <hr />Result:
    <input id="dt" />

    
</body>

</html>

<?php
include('footer.php');
?>