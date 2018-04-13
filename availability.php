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

echo $query_str."<br />";
$res= $db->query($query_str);

//echo $res->num_rows;
if ($res->num_rows > 0) {
  echo "Type ".$room." is not available on <br />";
  while($row = $res->fetch_assoc()) {
    // array_push($checkIn, $row['checkInDate']);
    // array_push($checkOut, $row['checkOutDate']);
    $roomNumber = $row['roomNumber'];
    $checkIn = $row['checkInDate']; 
    $checkOut = $row['checkOutDate'];
    echo $roomNumber."<br />";
    echo $checkIn."<br />";
    echo $checkOut."<br />";

  }
  // echo "<br />";
  //print_r($checkIn);
  // echo "<br />";
  //print_r($checkOut);
} else {
  echo "<br />There's no reservation on Type ".$room;
}

echo "<br>";
?> 

<body>
    <br />Room of Type <?php echo $room;?><input id="datepicker" />  
    <br />Room of Type <?php echo $room;?><input id="dateFilter" /> 

  </div> 
</body>

    
<script> 

// $(document).ready(function() {
//    $('#datepicker').datepicker({
//         dateFormate: "yy-mm-dd",
//         numberOfMonth: 1,
//         minDate:0,
//         beforeShowDay: function(date) {
//             var day;
//             if(day==<?php echo $checkIn; ?>) {
//                 return [false];
//             }
//             else 
//                 return [true];
//         }
//     });
// });

//disable specific dates
var unavailableDates = ["2018-4-9", "2018-4-14", "2018-4-22", "2018-4-28", "2018-4-30"];
//var unavailableDates = <?php echo json_encode($checkIn); ?>;

function unavailable(date) {
    dateFormat: "yy-mm-dd",
    dmy = date.getFullYear() + "-" + (date.getMonth() + 1) + "-" + date.getDate();
    if ($.inArray(dmy, unavailableDates) == -1) {
        return [true, ""];
    } else {
        return [false, "", "Unavailable"];
    } 
       }
       
   $(function() {
    $("#datepicker").datepicker({
        dateFormat: "yy-mm-dd",
        beforeShowDay: unavailable
    });
   
   });

   //disable a date range
  //var startDate = <?php echo json_encode($checkIn) ?>;
  var startDate = "2018-04-11";
  var endDate = "2018-04-22";
  var dateRange = [];

  for (var d = new Date(startDate);
              d <= new Date(endDate);
              d.setDate(d.getDate() + 1)) {
                  dateRange.push($.datepicker.formatDate('yy-mm-dd', d));
          }

  $('#dateFilter'+'#room').datepicker({
      beforeShowDay: function (date) {
          var dateString = jQuery.datepicker.formatDate('yy-mm-dd', date);
          //console.log(dateString);
          return [dateRange.indexOf(dateString) == -1];
      }
  });
</script>


 
<?php 
include('footer.php'); 
?>