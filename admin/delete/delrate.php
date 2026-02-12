<?php
include_once('../includes/dbcon.php');
include_once('../includes/globalvar.php');
$uid = $_GET['ID'];
$nm=$_GET['name'];
$del = mysqli_query($con,"DELETE FROM rates WHERE rtID = '$uid'") or die(mysqli_error());
header("Location: ../setrate.php?name=$nm");

?>