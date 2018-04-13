<?php
require_once('initialize.php');
date_default_timezone_set('America/Los_Angeles');

// $errors = '';
// $comment_name = '';
// if(isset($_SESSION['room'])) {
// 	$room = $_SESSION['room'];
// }

// // echo $room;
// // echo $_SESSION['admin_id'];
// // echo date("Y-m-d");

// if (isset($_POST['comment_name'])) {
//   if(is_blank($_POST['comment_name'])) {
//     $errors = "Comment cannot be blank.";
//   } elseif (!has_length($_POST['comment_name'], array('min' => 10, 'max' => 200))) {
//     $errors = "Comment must be between 10 and 200 characters.";
//   } else 
//     $comment_name=$_POST['comment_name'];
// }

// if (!empty($errors)) {
//   return $errors;
// }


// $sql = "INSERT INTO comment ";
// $sql .= "(content, memberNumber, roomType, timePosted) ";
// $sql .= "VALUES (";
// $sql .= "'" . db_escape($db, $comment_name) . "',";
// $sql .= "'" . db_escape($db, $_SESSION['admin_id']) . "',";
// $sql .= "'" . db_escape($db, $room) . "',";
// $sql .= "'" . db_escape($db, date("Y-m-d")) . "'";
// $sql .= ")";

// // $result = mysqli_query($db, $sql);

// echo $sql;
// // $stmt = $db->prepare($sql);

// $errors = "Comment Added Successfully!";


// $data = array(
// 	'errors' => $errors
// );

// echo json_encode($data);
$connect = new PDO('mysql:host=localhost;dbname=hotel', 'root', '');
$errors = '';
$comment_name = '';

// if(empty($_POST["comment_name"]))
// {
//  $errors .= '<p class="text-danger">Comment is required</p>';
// }
// else
// {
//  $comment_name = $_POST["comment_name"];
// }
if (isset($_POST['comment_name'])) {
  if(is_blank($_POST['comment_name'])) {
    $errors = "<p>Comment cannot be blank.</p>";
  } elseif (!has_length($_POST['comment_name'], array('min' => 10, 'max' => 200))) {
    $errors = "<p>Comment must be between 10 and 200 characters.</p>";
  } else 
    $comment_name=$_POST['comment_name'];
}

if($errors == '')
{
 $query = "
 INSERT INTO comment 
 (content, memberNumber, roomType, timePosted) 
 VALUES (:content, :id, :roomtype, :timeposted)
 ";
 $statement = $connect->prepare($query);
 $statement->execute(
  array(
   ':content' => $comment_name,
   ':id' => $_SESSION['admin_id'],
   ':roomtype' => $_POST['comment_type'],
   ':timeposted' => date('Y-m-d')
  )
 );
 $errors = '<label class="text-success">Comment Added</label>';
}

$data = array(
 'errors'  => $errors
);

echo json_encode($data);

?>