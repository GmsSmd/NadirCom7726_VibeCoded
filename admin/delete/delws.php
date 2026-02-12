<?php
include_once('../includes/dbcon.php');
include_once('../includes/globalvar.php');
$uid = $_GET['ID'];
$del = mysqli_query($con,"DELETE FROM empinfo WHERE EmpID = '$uid'") or die(mysqli_error());
header("Location: ../addws.php");

?>