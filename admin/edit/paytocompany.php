<?php
include_once('../../session.php');
include_once('../includes/globalvar.php');
include_once('../includes/variables.php');

	$id=$_GET['ID'];
	$for=$_GET['For'];
	$amnt=$_GET['Amnt'];
	$paidDate=date('Y-m-d');
	$status="PaidTo";
	$tmptxtNotes="Credit Cleared";
		$columnsToAdd="rpFor,rpDate, rpStatus, rpFromTo, rpAmnt, rpmode, rpUser, rpNotes";
		$valuesToAdd= " '$for','$paidDate','$status', '$parentCompany',$amnt,'$defaultBankName','$currentUser','$tmptxtNotes' ";
		//echo "$columnsToAdd". "<br>"."$valuesToAdd";
	
	$updateStatus="Cleared ".date('d-m-Y', strtotime($paidDate));	
		
		if($for=='Otar'){
			$updateQury = mysqli_query($con,"Update tbl_mobile_load SET purchaseType='$updateStatus' WHERE loadID = '$id'") or die(mysqli_error());
		    $sq = mysqli_query($con,"INSErt INTO receiptpayment($columnsToAdd) values($valuesToAdd)")or die(mysqli_query());
		    
		}	
		if($for=='MFS'){
			$updateQury = mysqli_query($con,"Update tbl_financial_service SET purchaseType='$updateStatus' WHERE mfsID = '$id'") or die(mysqli_error());
		    //$sq = mysqli_query($con,"INSErt INTO receiptpayment($columnsToAdd) values($valuesToAdd)")or die(mysqli_query());
		    $qr=mysqli_query($con,"INSERT INTO tbl_financial_service(mfsDate, mfsEmp, mfsAmnt) SELECT mfsDate, mfsEmp, mfsAmnt FROM tbl_financial_service WHERE mfsID = '$id';");
		    $last_id = mysqli_insert_id($con);
		    $qr2=mysqli_query($con,"UPDATE tbl_financial_service SET mfsDate='$paidDate', mfsStatus='Sent', mfsComments='Credit Cleared From MFS', User='$currentUser'  WHERE mfsID = '$last_id';");
		    //mfsStatus, mfsDate, mfsEmp, mfsAmnt, mfsComments,purchaseType,User
		}
		
		if($for=='Card'){
			$updateQury = mysqli_query($con,"Update tbl_cards SET purchaseType='$updateStatus' WHERE csID = '$id'") or die(mysqli_error());
			$sq = mysqli_query($con,"INSErt INTO receiptpayment($columnsToAdd) values($valuesToAdd)")or die(mysqli_query());
			
		}
		if($for=='Mobile' OR $for=='SIM'){
			$updateQury = mysqli_query($con,"Update tbl_product_stock SET purchaseType='$updateStatus' WHERE sID = '$id'") or die(mysqli_error());
			$sq = mysqli_query($con,"INSErt INTO receiptpayment($columnsToAdd) values($valuesToAdd)")or die(mysqli_query());
		}
		//echo $columnsToAdd;
		//echo "<br>";
		//echo $valuesToAdd;
		
		//$sq = mysqli_query($con,"INSErt INTO receiptpayment($columnsToAdd) values($valuesToAdd)")or die(mysqli_query());
		
		
		$moveTo='Location:../companypayment.php?name='.$parentCompany;
header($moveTo);
?>