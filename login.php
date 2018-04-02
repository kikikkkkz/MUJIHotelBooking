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
    Email:<br />
    <input type="text" name="email" value="<?php echo $email; ?>" /><br />
    Password:<br />
    <input type="password" name="password" value="" /><br /><br />
    <input type="submit" name="login" value="Login"  />
  </form>

  Not registered yet? <a href="register.php">Register here.</a>

</div>

<?php
include('footer.php');
?>
