<?php
include_once('../includes/dbcon.php');
include_once('../includes/globalvar.php');
$uid = $_GET['ID'];
$nm=$_GET['name'];
$del = mysqli_query($con,"DELETE FROM openingclosing WHERE ocID = '$uid'") or die(mysqli_error());
header("Location: ../initialoc.php?name=$nm");
?>