<?php 
require_once('initialize.php'); 
if(isset($_SESSION['room'])) $room = $_SESSION['room'];  

$page_title = 'Type '.$room.'- Availability';  
include('header.php'); 
 
echo "<div class=\"availability\">"; 
 
$errors = $checkIn = $checkOut = []; 
$room = ''; 
 

//echo $room; 
if(isset($_SESSION['room'])) $room = $_SESSION['room'];  
echo "<button type=\"button\"><a href="; 
echo url_for('roomdetails.php?room='.$room); 
echo ">&laquo; Back to Type $room</a></button> "; 
 
echo "<h1>Availability of TYPE $room</h1>"; 


$query_str = "SELECT checkInDate, checkOutDate, roomNumber, roomType
              FROM reservation
              WHERE roomType= '".$room."'";

//echo $query_str;
$res= $db->query($query_str);

//echo $res->num_rows;
if ($res->num_rows > 0) {
  echo "Type ".$room." is not available on <br />";
  while($row = $res->fetch_assoc()) {
    $checkIn = $row['checkInDate'];
    $checkOut = $row['checkOutDate'];  
    echo $checkIn."<br />";
    echo $checkOut."<br />";
  }
} else {
  echo "<br />There's no reservation on Type ".$room;
}


?> 


<body>
    Date Range Disable<input id="datepicker" />   
  </div> 
</body>

    
<script> 

// Bookings
//Mr &amp; Mrs Smith 

$(document).ready(function() {
   $('#datepicker').datepicker({
        dateFormate: "yy-mm-dd",
        numberOfMonth: 1,
        minDate:0,
        beforeShowDay: function(date) {
            var day;
            if(day==<?php echo $checkIn; ?>) {
                return [false];
            }
            else 
                return [true];
        }
    });
});

</script>


 
<?php 
include('footer.php'); 
?>