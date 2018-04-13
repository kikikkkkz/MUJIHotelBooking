<?php
require_once('initialize.php');
date_default_timezone_set('America/Los_Angeles');

//$connect = new PDO('mysql:host=localhost;dbname=hotel', 'root', '');

$query = "
SELECT members.firstName, comment.content, comment.memberNumber, comment.timePosted FROM members LEFT JOIN comment ON members.memberNumber = comment.memberNumber  
WHERE comment.roomType = '".$_SESSION['room']."'";

//$statement = $connect->prepare($query);
$res = $db->query($query);

//echo $statement->num_rows;
//$statement->execute();

echo "<b>".$res->num_rows." Comments </b><br />";
$output = '';
if($res->num_rows > 0) {
	//$result = $statement->fetchAll();
	while($row=$res->fetch_assoc()) {
		$output .= '
	 <div class="panel panel-default">
	  <div class="panel-heading">'.$row["firstName"].' | '.$row["timePosted"].'</i></div>
	  <div class="panel-body">'.$row["content"].'</div>
	 ';
	}
	// $output = '';
	// foreach($result as $row)
	// {
	//  $output .= '
	//  <div class="panel panel-default">
	//   <div class="panel-heading">'.$row["firstName"].' | '.$row["timePosted"].'</i></div>
	//   <div class="panel-body">'.$row["content"].'</div>
	//  ';
	// }
} else {
	$output .= "No one has visited yet.";
}

echo $output;
echo "<br>";

?>