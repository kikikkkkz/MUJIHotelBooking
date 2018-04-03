<?php
require_once('initialize.php');

$page_title = 'Room Availability'; 
include('header.php');

echo "<div class=\"availability\">";

$errors = [];
$checkIn = $checkOut = $room = '';

if(isset($_SESSION['room'])) $room = $_SESSION['room']; 
//echo $room;

echo "<button type=\"button\"><a href=";
echo url_for('roomdetails.php?room='.$room);
echo ">&laquo; Back to Type $room</a></button> ";

echo "<h1>Availability of TYPE $room</h1>";

if(is_post_request()&&isset($_POST['search'])) {
	if(isset($_POST['checkIn'])) $checkIn = $_POST['checkIn'];
	if(isset($_POST['checkOut'])) $checkOut = $_POST['checkOut'];

	// Validations
  if(is_blank($checkIn)) {
    $errors[] = "Check-In date cannot be blank.";
  }
  if(is_blank($checkOut)) {
    $errors[] = "Check-Out date cannot be blank.";
  }

  if(empty($errors)) {

  	//$search_failure_msg = "Search was unsuccessful.";
	//save to session
	$_SESSION['check_in'] = $checkIn;
	$_SESSION['check_out'] = $checkOut;
	redirect_to(url_for('searchresult.php?checkIn='.$checkIn.'checkOut='.$checkOut));
	}
}

// $_SESSION['callback_url']=url_for('search.php');

echo "</div>";
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
        $("#checkIn").datepicker({
            dateFormat: "yy-mm-dd",   
            numberOfMonth: 1,
            minDate: 0,
            onSelect: function (date) {
                var date2 = $('#checkIn').datepicker('getDate');
                date2.setDate(date2.getDate() + 1);
                //$('#to').datepicker('setDate', date2);
                $('#checkOut').datepicker('option', 'minDate', date2);
            }
        });
        $('#checkOut').datepicker({
            dateFormat: "yy-mm-dd",
            numberOfMonth: 1,
            onClose: function (date) {                
                var from = $('#checkIn').datepicker('getDate');
                //console.log(from); //for debugging
                var to = $('#checkOut').datepicker('getDate');
                //to.setDate(to.getDate() -1);
                //$('#from').datepicker('setDate', to);
                //$('#checkIn').datepicker('option','maxDate',to);
                 if (to <= from) {
                    var minDate = $('#dt2').datepicker('option', 'minDate');
                    $('#checkIn').datepicker('setDate', minDate);
                    
                } 
            }
        });

		})
	</script>

</head>

<body>
    <div class="search">

	<?php echo display_errors($errors); ?>

    <div class="search1">
	<form action="availability.php" method="post">
		<table>
		<tr><th>Check-in </th>
		<th>Check-out </th></tr>
		
		<tr>
			<td><input type="text" name="checkIn" id="checkIn" placeholder="When to arrive" value="<?php if(isset($_POST['checkIn'])) echo $_POST['checkIn'] ?>"> </td>
			<td><input type="text" name="checkOut" id="checkOut" placeholder="When to leave" value="<?php if(isset($_POST['checkOut'])) echo $_POST['checkOut'] ?>"> </td>
			<td><input type="submit" name="search" id="search" value="Search"></td>
		</tr>
		
		</table>
	</form>
    </div>
    </div>
</body>

</html>

<?php
include('footer.php');
?>