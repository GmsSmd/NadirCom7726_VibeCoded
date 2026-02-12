<?php
include_once('../includes/dbcon.php');
$refId = $_GET['refId'];
$doName=$_GET['doName'];
$salUpdate = mysqli_query($con,"UPDATE tbl_initiator_query SET do_name='$doName' WHERE ref_id = '$refId'") or die(mysqli_error());
?>