<?php
include_once('../includes/dbcon.php');
include_once('../includes/globalvar.php');
$uid = $_GET['ID'];
$nm=$_GET['for'];

if($nm=='Otar')
	{
	$del = mysqli_query($con,"DELETE FROM tbl_mobile_load WHERE loadID = '$uid'") or die(mysqli_error());
	header("Location: ../salesummary.php?for=$nm");
	}
else if($nm=='MFS')
	{
	$del = mysqli_query($con,"DELETE FROM tbl_financial_service WHERE mfsID = '$uid'") or die(mysqli_error());
	header("Location: ../salesummary.php?for=$nm");
	}
else if($nm=='Card')
	{
	$del = mysqli_query($con,"DELETE FROM tbl_cards WHERE csID = '$uid'") or die(mysqli_error());
	header("Location: ../salesummary.php?for=$nm");
	}
else if($nm=='Mobile')
	{
	$del = mysqli_query($con,"DELETE FROM tbl_product_stock WHERE sID = '$uid'") or die(mysqli_error());
	header("Location: ../salesummary.php?for=$nm");
	}
else if($nm=='SIM')
	{
	$del = mysqli_query($con,"DELETE FROM tbl_product_stock WHERE sID = '$uid'") or die(mysqli_error());
	header("Location: ../salesummary.php?for=$nm");
	}
else 
	header("Location: ../salesummary.php?for=$nm");	
?>