<?php
$page_title = 'Log in';
include('header.php');
require_once("initialize.php");
// require_SSL();

$errors = [];
$email = '';
$password = '';

//when form is submitted
if(is_post_request()) {

  //get value input
  $email = $_POST['email'] ?? '';
  $password = $_POST['password'] ?? '';

  // Validations
  if(is_blank($email)) {
    $errors[] = "Email cannot be blank.";
  }
  if(is_blank($password)) {
    $errors[] = "Password cannot be blank.";
  }

  // if there were no errors, try to login
  if(empty($errors)) {
    // Using one variable ensures that msg is the same
    $login_failure_msg = "Log in was unsuccessful.";

    $admin = find_admin_by_email($email);
    if($admin) {

      if(password_verify($password, $admin['hashed_password'])) {
        // password matches
        log_in_admin($admin);
        redirect_to($_SESSION['callback_url']); //return to previous page
      } else {
        // username found, but password does not match
        $errors[] = $login_failure_msg;
      }

    } else {
      // no username found
      $errors[] = $login_failure_msg;
    }
  }

}

?>

<div class="login">
  <h1>Log in</h1>

  <?php echo display_errors($errors); ?>

  <form action="login.php" method="post">
    <table cellspacing="10">
    <tr><td>Email</td></tr>
    <tr><td><input type="text" name="email" value="<?php echo $email; ?>" /></td></tr>
    <tr><td>Password</td></tr>
    <tr><td><input type="password" name="password" value="" /></td></tr>
    <tr><td><input type="submit" name="login" value="Login"  /></td></tr>
    </table>
  </form>

  Not registered yet? <button type="button"><a href="register.php"> Register here</a></button>

</div>

<?php
include('footer.php');
?>
