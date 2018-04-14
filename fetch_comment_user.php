<?php
require_once('initialize.php');

$query = "SELECT id, content, timePosted, roomType FROM comment WHERE memberNumber = ".$_SESSION['admin_id']."";

$res = $db->query($query);

// echo "<b>".$res->num_rows." Comments </b><br />";
$output = '';
if($res->num_rows > 0) {
	//$result = $statement->fetchAll();
	while($row=$res->fetch_assoc()) {
		// $output .= "<tr><td>".$row['timePosted']."</td> <td>|</td>" 
		// ."<td><b><a href=".url_for('roomdetails.php?room='.$row['roomType'])
		// .">Type ".$row['roomType']."</a></b></td></tr>"
		// ."<tr><td> <td>|</td> </td><td>".$row['content']."</td></tr>";
		
		$output .= '
	 	<div id="comment_id" value="'.$row["id"].'">'
	 	.'<div class="panel-heading">'.$row["timePosted"].' | <a href='.url_for('roomdetails.php?room='.$row['roomType']).'><b>Type '.$row["roomType"].'</b></a></i></div>
	  	<div class="panel-body">'.$row["content"]
	  	.'</div>'
	  	.'<button class="delete">Delete</button></div>';
	}
} else {
	$output .= "Haven't posted any comments yet.";
}

echo $output;
echo "<br>";

?>

<script>
	$(document).ready(function(){
		$(".delete").click(function(event) {
			event.preventDefault();
			var comment_id = $("#comment_id").serialize();
			alert(comment_id);
			$.ajax({
				url: "delete_comment_user.php",
				method: "POST",
				data: comment_id,
				dataType: "JSON",
				success: function(data) {
					
				}
			})
		})
	});
</script>