<?php
include_once('../includes/dbcon.php');
include_once('../includes/globalvar.php');
$id = $_GET['ID'];
$nm=$_GET['name'];
$del = mysqli_query($con,"DELETE FROM target WHERE tgtid = $id") or die(mysqli_error());
header("Location: ../addtarget.php?name=$nm");
?>