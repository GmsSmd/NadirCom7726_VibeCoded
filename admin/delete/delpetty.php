<?php
include_once('../includes/dbcon.php');
include_once('../includes/globalvar.php');
$uid = $_GET['ID'];
$del = mysqli_query($con,"DELETE FROM petty WHERE id = '$uid'") or die(mysqli_error());
header("Location: ../petty.php");

?>