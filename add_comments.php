<?php
require_once('initialize.php');

$errors = '';
$comment_name = '';
if(isset($_SESSION['room'])) {
	$room = $_SESSION['room'];
}

// echo $room;
// echo $_SESSION['admin_id'];
// echo date("Y-m-d");

if (isset($_POST['comment_name'])) {
  if(is_blank($_POST['comment_name'])) {
    $errors = "Comment cannot be blank.";
  } elseif (!has_length($_POST['comment_name'], array('min' => 10, 'max' => 200))) {
    $errors = "Comment must be between 10 and 200 characters.";
  } else 
    $comment_name=$_POST['comment_name'];
}

if (!empty($errors)) {
  return $errors;
}


$sql = "INSERT INTO comment ";
$sql .= "(content, memberNumber, roomType, timePosted) ";
$sql .= "VALUES (";
$sql .= "'" . db_escape($db, $comment_name) . "',";
$sql .= "'" . db_escape($db, $_SESSION['admin_id']) . "',";
$sql .= "'" . db_escape($db, $room) . "',";
$sql .= "'" . db_escape($db, date("Y-m-d")) . "'";
$sql .= ")";

// $result = mysqli_query($db, $sql);

echo $sql;
//$stmt = $db->prepare($sql);

$errors = "Comment Added Successfully!";


$data = array(
	'errors' => $errors
);

echo json_encode($data);




?>