<?php
require_once('initialize.php');
$_SESSION['callback_url']=url_for('reservation.php');

include('header.php');
echo "<h2>Your Reservation</h2>";
if(is_post_request()){ $_SESSION['submit']='true';}
require_login();

//get session id
$id=$_SESSION['admin_id'];

// 	if(isset($_SESSION['prod'])){
// 		if(isset($_SESSION['submit'])){
// 			$item = $_SESSION['prod'];
// 			$result = insert_watchlist($item);
// 			echo "Successfully added $item.";
// 		}
// 		unset($_SESSION['prod']);
// 		unset($_SESSION['submit']);
// 	}

// 	//query string
// 	$query_str = "SELECT DISTINCT product_name FROM watchlist WHERE id = ".$id;
// 	$res = $db->query($query_str);

// 	if ($res->num_rows > 0) {
// 		echo "<ul>";
// 		while($row = $res->fetch_row()){
// 			echo "<li>";
// 			format_name_as_link($row[0], $row[0], "modeldetails.php");
// 			echo "</li>\n";
// 		};
// 		echo "</ul>";
// 	}else{
// 		echo "No items in watchlist."; //empty list
// 	}


include('footer.php');
// $res->free_result();
// $db->close();

?>