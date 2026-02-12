<?php
include_once('../includes/dbcon.php');
include_once('../includes/globalvar.php');
$uid = $_GET['ID'];
//$del = mysqli_query($con,"DELETE FROM empinfo WHERE EmpID = '$uid'") or die(mysqli_error());

$Update = mysqli_query($con,"UPDATE empinfo SET EmpStatus='Left', EmpFixedSalary=0 WHERE EmpID = '$uid'") or die(mysqli_error());
header("Location: ../addemp.php");

?>