<?php
require_once('initialize.php');

$page_title = 'Room Choice';
include('header.php');

echo "<h2>Rooms</h2>";
//session the url address
$_SESSION['callback_url']=url_for('room.php');

//set sql query string and get the results from database
$query_str = "SELECT roomType FROM roomtype";
$res = $db->query($query_str);

//list all items as unorder list
echo "<ul>";
while($row = $res->fetch_row()){
	echo "<li>";
	format_name_as_link($row[0], $row[0], "roomdetails.php"); //each item links to specific model
	echo "</li>\n";
};
echo "</ul>";

//unset session product
if(isset($_SESSION['room'])){
	unset($_SESSION['room']);
}

include('footer.php');
//release object
$res->free_result();
$db->close();
?>