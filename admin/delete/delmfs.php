<?php
include_once('../includes/dbcon.php');
include_once('../includes/globalvar.php');
$uid = $_GET['ID'];
$del = mysqli_query($con,"DELETE FROM tbl_financial_service WHERE mfsID = '$uid'") or die(mysqli_error());
$del2 = mysqli_query($con,"DELETE FROM receiptpayment WHERE rpFor='MFS' AND linkedKey = '$uid'") or die(mysqli_error());
header("Location: ../lifting.php");

?>