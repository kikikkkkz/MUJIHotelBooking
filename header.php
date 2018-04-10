<?php
	require_once('initialize.php');
	if(!isset($page_title)) { $page_title = 'Welcome'; }
?>

<html>
<head>
<title>MUJI Hotel | <?php echo h($page_title); ?></title>


<!-- adding css -->
<meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no"/>
<link rel="stylesheet" type="text/css" href="https://fonts.googleapis.com/css?family=Roboto:400,700" />
<link rel="stylesheet" type="text/css" href="style.css"/>
<!-- <link rel="icon" href="/image/muji_icon.ico" type="image/x-icon"> -->


<!-- jquery -->
<script src="https://code.jquery.com/jquery-2.2.4.js"></script>
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
<link href="https://code.jquery.com/ui/1.11.3/themes/smoothness/jquery-ui.css" rel="stylesheet">


</head>

<body>

<div class="header">
<!-- 	<img src="images/title.jpg" class="cover" /> -->
	<a href="<?php echo url_for('search.php'); ?>" class="logo">
	<img src="images/logo.svg" width="180px" alt="MUJI Hotel" /></a>
	

	<ul class="main-nav topBotomBordersOut">
		<li><a href="<?php echo url_for('search.php'); ?>">Home</a></li> 
		<li><a href="<?php echo url_for('room.php'); ?>">Rooms</a></li>  

		<?php 
		//if logged in, show username and logout, otherwise show login
		if(isset($_SESSION['admin_id'])){
			if (isset($_SESSION['email'])) {
				$email=$_SESSION['email'];
				echo "<li><a href=\"profile.php\">$email</a></li>";
			}
			// echo $_SESSION['email'] ?? '';
			$url=url_for('logout.php');
			echo "<li><a href=\"$url\"> Logout</a></li>";
		}else{
			$url=url_for('login.php');
			echo "<li><a href=\"$url\">Login</a></li>";
		}
		?>
	</ul>

</div>





<!--header ends here-->