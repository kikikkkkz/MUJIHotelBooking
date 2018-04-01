<?php
require_once('initialize.php');
include('header.php');

if(isset($_SESSION['check_in'])) $checkIn = $_SESSION['check_in'];
if(isset($_SESSION['check_out'])) $checkOut = $_SESSION['check_out'];


echo "<br /><h1>Choose a room
	</h1>";

echo "<p>Check In | $checkIn"; 
echo "Check Out | $checkOut</p>";


?>

<!DOCTYPE html>

<html>
<head>
	<title>Datepicker Testing</title>
</head>

<body>
</body>



</html>

<?php
include('footer.php');
?>