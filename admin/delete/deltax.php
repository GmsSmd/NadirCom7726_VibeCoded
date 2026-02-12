<?php
include_once('../includes/dbcon.php');
include_once('../includes/globalvar.php');
$uid = $_GET['ID'];
$del = mysqli_query($con,"DELETE FROM receiptpayment WHERE rpID = '$uid'") or die(mysqli_error());
header("Location: ../addtax.php");

?>