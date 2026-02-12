<?php
include_once('../includes/dbcon.php');
include_once('../includes/globalvar.php');
$uid = $_GET['ID'];
$del = mysqli_query($con,"DELETE FROM tbl_product_stock WHERE sID = '$uid'") or die(mysqli_error());
$del2 = mysqli_query($con,"DELETE FROM receiptpayment WHERE rpFor='Mobile' AND linkedKey = '$uid'") or die(mysqli_error());
header("Location: ../lifting.php");

?>