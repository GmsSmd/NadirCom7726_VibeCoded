<?php
include_once('../includes/dbcon.php');
include_once('../includes/globalvar.php');
$uid = $_GET['ID'];
$edit = mysqli_query($con,"SELECT * FROM users WHERE user_id = '$uid'") or die(mysqli_error());
$emp = mysqli_fetch_array($edit);
$uName=$emp['username'];
if($uName=="Admin" or $uName=="admin")
	{
	echo '<script type="text/javascript">alert("Admin User can not be deleted.");</script>'; 
	header("Location: ../addusers.php");
	}
else
	{
	$del = mysqli_query($con,"DELETE FROM users WHERE user_id = '$uid'") or die(mysqli_error());
	header("Location: ../addusers.php");
	}
?>