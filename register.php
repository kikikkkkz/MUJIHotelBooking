<?php
require_once("initialize.php");
// require_SSL();

//when form is submitted
if(is_post_request()) {
  $subject = [];
  $admin['first_name'] = $_POST['first_name'] ?? '';
  $admin['last_name'] = $_POST['last_name'] ?? '';
  $admin['email'] = $_POST['email'] ?? '';
  $admin['phone_number'] = $_POST['phone_number'] ?? '';
  $admin['country'] = $_POST['country'] ?? '';
  $admin['password'] = $_POST['password'] ?? '';
  $admin['confirm_password'] = $_POST['confirm_password'] ?? '';

  $result = insert_admin($admin);
  if($result === true) {
    $new_id = mysqli_insert_id($db); //insert id to database
    $_SESSION['message'] = 'Account created.';
    $_SESSION['admin_id']=$new_id; //login new account
    $_SESSION['email'] = $admin['email']; //set session email
    redirect_to($_SESSION['callback_url']); //return to previous page
  } else {
    $errors = $result; //error message
  }

} else {
  // display the blank form
  $admin = [];
  $admin["first_name"] = '';
  $admin["last_name"] = '';
  $admin["email"] = '';
  $admin["phone_number"] = '';
  $admin["country"] = '';
  $admin['password'] = '';
  $admin['confirm_password'] = '';
}

?>

<?php $page_title = 'Register'; ?>
<?php include('header.php'); ?>

<div class="register">

    <h1>Create Account</h1>

    <?php echo display_errors($errors); ?>

    <form action="<?php echo url_for('register.php'); ?>" method="post">
      <table cellspacing="10">
      <tr>
        <td>First name</td>
        <td><input type="text" name="first_name" value="<?php echo h($admin['first_name']); ?>" /></td>
      </tr>

      <tr>
        <td>Last name</td>
        <td><input type="text" name="last_name" value="<?php echo h($admin['last_name']); ?>" /></td>
      </tr>

      <tr>
        <td>Email</td>
        <td><input type="text" name="email" value="<?php echo h($admin['email']); ?>" /><br /></td>
      </tr>

      <tr>
        <td>Phone Number</td>
        <td><input type="text" name="phone_number" value="<?php echo h($admin['phone_number']); ?>" /><br /></td>
      </tr>

      <tr>
        <td>Country</td>
        <td><input type="text" name="country" value="<?php echo h($admin['country']); ?>" /><br /></td>
      </tr>

      <tr>
        <td>Password</td>
        <td><input type="password" name="password" value="" /></td>
      </tr>

      <tr>
        <td>Confirm Password</td>
        <td><input type="password" name="confirm_password" value="" /></td>
      </tr>
      
      <br />
      <tr>
        <td></td>
        <td><input type="submit" value="Create Account" /></td>
      </tr>

    </table>
    <br />

      Already a member? <button type="button"><a class="back-link" href="<?php echo url_for('login.php'); ?>">Login here</a></button>  

    </form>

</div>

<?php include('footer.php'); ?>
