<?php
include_once('../includes/dbcon.php');
include_once('../includes/globalvar.php');
$uid = $_GET['ID'];
$dt=$_GET['dt'];
$Amnt=$_GET['amnt'];
$mnth=$_GET['mn'];
$bnk=$defaultBankName;
$date1= date("Y-m-d", strtotime($dt));


$qry = mysqli_query($con,"SELECT description FROM dueexp WHERE id='$uid'") or die(mysqli_error());
$Data=mysqli_fetch_array($qry);
$name=$Data['description'];

$Cmnt='Exp Paid For '.$name;

			$columnsToAdd="rpFor,rpDate, rpStatus,rpFromTo, rpAmnt, rpmode, rpNotes";
			$valuesToAdd= " 'DO Dues', '$date1','PaidTo','DueSalary',$Amnt,'$bnk','$Cmnt' ";
			//echo "$columnsToAdd". "<br>"."$valuesToAdd";
			$sq = mysqli_query($con,"INSERT INTO receiptpayment($columnsToAdd) values($valuesToAdd)")or die(mysqli_query());
			//$valuesToAdd2= " 'Withdraw', '$date1','PaidTo','DueSalary',$Amnt,'$bnk','$Cmnt' ";
			//$sq = mysqli_query($con,"INSERT INTO receiptpayment($columnsToAdd) values($valuesToAdd2)")or die(mysqli_query());

			
			$salUpdate = mysqli_query($con,"UPDATE dueexp SET status='Paid on $dt' WHERE id = '$uid'") or die(mysqli_error());
//$pettyEntry= mysqli_query($con,"INSERT INTO petty(date, status, type, amnt, comments) values('$date1', 'Sub','Petty',$Amnt,'$Cmnt')")or die(mysqli_query());


header("Location: ../paysalary.php");

?>