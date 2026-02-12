<?php
include_once('../includes/dbcon.php');
include_once('../includes/globalvar.php');
$uid = $_GET['ID'];
$del = mysqli_query($con,"DELETE FROM tbl_financial_service WHERE mfsID = '$uid'") or die(mysqli_error());
header("Location: ../rt.php");

?>