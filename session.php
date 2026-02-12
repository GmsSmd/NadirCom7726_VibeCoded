<?php
include_once('admin/includes/dbcon.php');
session_start();
$user_check=$_SESSION['login_user'];
$ses_sql=mysqli_query($con,"select username from users where username='$user_check'")or die(mysqli_query());
$row = mysqli_fetch_assoc($ses_sql);
$login_session =$row['username'];
if(!isset($login_session)){
header('Location: ../index.php');
}
?>