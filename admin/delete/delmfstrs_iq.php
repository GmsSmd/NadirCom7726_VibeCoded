<?php
include_once('../includes/dbcon.php');
include_once('../includes/globalvar.php');
$uid = $_GET['ID'];
$del = mysqli_query($con,"DELETE FROM tbl_initiator_query WHERE ref_id = '$uid'") or die(mysqli_error());
header("Location: ../mfstransactions_iq.php");
?>