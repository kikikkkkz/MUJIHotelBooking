<?php
require_once('initialize.php');
$id=$_SESSION['admin_id'];

$page_title = 'Edit profile';
include('header.php');

$errors = [];
$email = '';
$password = '';

$query_str = "SELECT * FROM members WHERE memberNumber = " .$id. "";
			  
$res=$db->query($query_str);
if ($res->num_rows > 0) {
	$rows = $res->fetch_assoc();
}

//updating the profile 
if (isset($_POST['update'])) {


  $subject = [];
  $admin['id'] = $id;
  $admin['cur_password'] = $_POST['cur_password'] ?? '';
  $admin['new_password'] = $_POST['new_password'] ?? '';
  $admin['confirm_password'] = $_POST['confirm_password'] ?? '';

  $result = update_password($admin);
  // if($result === true) {
  //     $_SESSION['imagePath'] = $admin['avatar']; //set session image path
  //   	redirect_to($_SESSION['callback_url']); //return to 
  //   } else {
		//   $errors = $result; //error message
  //   }

}

?>

<div class="register">


    <h1>Change Password</h1>

    <?php echo display_errors($errors); ?>

    <button type="button"><a href="<?php echo url_for('profile.php'); ?>">&laquo;Back to profile</a></button>

    <form method="post">


      <table cellspacing="10">
      	<tr>
        <td >Email</td>
        <td><input type="text" name="email" id="email" value="<?php echo $rows['email']; ?>" readonly/><br /></td>
      </tr>

      <tr>
        <td>Current Password</td>
        <td><input type="password" name="cur_password" value="" /></td>
      </tr>

      <tr>
        <td>New Password</td>
        <td><input type="password" name="new_password" value="" /></td>
      </tr>

      <tr>
        <td>Confirm Password</td>
        <td><input type="password" name="confirm_password" value="" /></td>
      </tr>



      <br />
      <tr>
        <td></td>
        <td><input class="btn" type="submit" name="update" value="Update" /></td>
      </tr>
		   
</table>


</form>
</div>


<?php 
include('footer.php');

$db->close();
?>