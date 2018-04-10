<html>
<head>
        <!-- jquery -->
    <script src="https://code.jquery.com/jquery-2.2.4.js"></script>
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
    <link href="https://code.jquery.com/ui/1.11.3/themes/smoothness/jquery-ui.css" rel="stylesheet">
</head>



<body>
    Date Range Disable<input id="datepicker" />
    </body>

    
<script> 

// Bookings
//Mr &amp; Mrs Smith 
var cbs1 = new Date('April 18, 2018');
var cbe1 = new Date('April 24, 2018');

$(document).ready(function() {
   $('#datepicker').datepicker({
        beforeShowDay: function(date) {
            var day = date.getDay();
            if(day==0 || day==6) {
                return [false];

            }
            else 
                return [true];
        }
    });
});

</script>

</html>

