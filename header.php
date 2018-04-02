<?php
	require_once('initialize.php');
	if(!isset($page_title)) { $page_title = 'Welcome'; }
?>

<html>
<head>
<title>MUJI Hotel | <?php echo h($page_title); ?></title>

<style>
* {font-family:Georgia;}
a.nav { color:white; text-decoration: none;}
a { color:34495e; text-decoration: none; font-family:verdana;}
</style>

</head>
<body>
<table style="width:100%;border-spacing:0px">
<tr style="height:100px;background-color:60a3bc">
<th style="font-family:verdana;font-size:54px;color:white;"><img src="images/logo.svg" width="180px" /></th>
</tr>
<tr height="30" bgcolor="#bdc3c7">
<td style="font-family:verdana;font-size:18px;color:white;">
<strong><a class="nav"  href="<?php echo url_for('search.php'); ?>">Home</a> | 
<strong><a class="nav"  href="<?php echo url_for('room.php'); ?>">Rooms</a> | 

<?php 
//if logged in, show username and logout, otherwise show login
if(isset($_SESSION['admin_id'])){
	if (isset($_SESSION['email'])) {
		$email=$_SESSION['email'];
		echo "<a class=\"nav\" href=\"profile.php\">$email</a>";
	}
	// echo $_SESSION['email'] ?? '';
	$url=url_for('logout.php');
	echo "<a class=\"nav\" href=\"$url\"> Logout</a>";
}else{
	$url=url_for('login.php');
	echo "<a class=\"nav\" href=\"$url\">Login</a>";
}
?>
</td>
<tr bgcolor="FFFFFF">
<td >
<!--header ends here-->