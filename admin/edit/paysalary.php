<?php
include_once('../../session.php');
include_once('../includes/globalvar.php');
include_once('../includes/variables.php');
if(isset ($_POST['PaySalary']))
{
	$uid = $_POST['txtID'];
	$name=$_POST['txtName'];
	$Amnt=$_POST['txtTotSal'];
	$rcptNum=$_POST['txtRcptNum'];
	$dt= date("d-m-Y",strtotime($_POST['txtDate']));
	$bnk=$defaultBankName;
	//$date1=date_format($_POST['txtDate'],"Y/m/d");
	$date1=date("Y-m-d", strtotime($dt));
	

$Cmnt='Salary Paid To '.$name;

$columnsToAdd="rpFor,rpDate, rpStatus,rpFromTo, rpAmnt, rpmode, rpNotes,rpUser,rpStatus2";
			
			$valuesToAdd2= " 'DO Dues', '$date1','PaidTo','DueSalary',$Amnt,'$bnk','$Cmnt','$currentUser','$rcptNum' ";
			$sq = mysqli_query($con,"INSERT INTO receiptpayment($columnsToAdd) values($valuesToAdd2)")or die(mysqli_query());

			$salUpdate = mysqli_query($con,"UPDATE salary SET status='Paid on $dt', rcptNo='$rcptNum' WHERE id = '$uid'") or die(mysqli_error());
//$pettyEntry= mysqli_query($con,"INSERT INTO petty(date, status, type, amnt, comments) values('$date1', 'Sub','Petty',$Amnt,'$Cmnt')")or die(mysqli_query());
}

header("Location: ../paysalary.php");

if(isset ($_POST['goBack']))
{
	header("Location: ../paysalary.php");
}
?>