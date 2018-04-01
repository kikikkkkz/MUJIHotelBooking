<?php
require_once('initialize.php');
include('header.php');

if(isset($_SESSION['check_in'])) $checkIn = $_SESSION['check_in'];
if(isset($_SESSION['check_out'])) $checkOut = $_SESSION['check_out'];

// echo $_SESSION['check_in'];

echo "<br /><h1>Choose a room
	</h1>";

echo "Check In | $checkIn<br />"; 
echo "Check Out | $checkOut";


?>


<!DOCTYPE html>

<html>
<head>
	<title>Choose a room</title>
</head>

<body>
	<br />
	<button type="button"><a class="goback" href="<?php echo url_for('search.php'); ?>" style= "text-decoration:none;">Edit Search</a></button>
</body>



</html>

<?php
include('footer.php');
?>