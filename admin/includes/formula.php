<?php
include_once('includes/variables.php');
include_once('globalvar.php');


/*         <<<<<<<<<<<<  THIS IS target MODULE   >>>>>>>>>>>>>>>      */

if (isset($_POST['addtarget']))
{
	$tgtMonth=$_POST['MonthSelect'];
	$EmpName=$Employee;
	$OtartgtAmnt=$_POST['txtOtartgtAmnt'];
	$mfsTgtAmnt=$_POST['txtmfsTgtAmnt'];
	$othergtType=$_POST['OthertgtSelect'];
	$othergtAmnt=$_POST['txtOthertgtAmnt'];
	
	
		
	// Check if all data fields have been filled or not
	
	if ($EmpName== "---")
			{ echo '<script type="text/javascript">alert("Please Select an option from \"target For:\" drop down.");</script>'; }
	else
	{
		if($OtartgtAmnt > 0 && $mfsTgtAmnt > 0)
			{
				if ($othergtType!="---")
					{
					$columnsToAdd="tgtMonth, tgtType, tgtEmp, tgtAmnt";
					$valuesToAdd= " '$tgtMonth','$othergtType', '$EmpName',$othergtAmnt";
					$sq = mysqli_query($con,"INSErt INTO target($columnsToAdd) values($valuesToAdd)")or die(mysqli_query());
					echo '<script type="text/javascript">alert("'.$othergtType.' target Amounting Rs. '.$othergtAmnt.' Sucessfully entered.");</script>';
					
					$columnsToAdd="tgtMonth, tgtType, tgtEmp, tgtAmnt";
					$valuesToAdd= " '$tgtMonth','Otar', '$EmpName',$OtartgtAmnt";
					$sq = mysqli_query($con,"INSErt INTO target($columnsToAdd) values($valuesToAdd)")or die(mysqli_query());
					
					$columnsToAdd="tgtMonth, tgtType, tgtEmp, tgtAmnt";
					$valuesToAdd= " '$tgtMonth','mfs', '$EmpName',$mfsTgtAmnt";
					$sq = mysqli_query($con,"INSErt INTO target($columnsToAdd) values($valuesToAdd)")or die(mysqli_query());
					
					echo '<script type="text/javascript">alert("Otar target '.$OtartgtAmnt.' and mfs target '.$mfsTgtAmnt.' Successfully Entered");</script>';
					}
				else
				{
					$columnsToAdd="tgtMonth, tgtType, tgtEmp, tgtAmnt";
					$valuesToAdd= " '$tgtMonth','Otar', '$EmpName',$OtartgtAmnt";
					$sq = mysqli_query($con,"INSErt INTO target($columnsToAdd) values($valuesToAdd)")or die(mysqli_query());
					
					$columnsToAdd="tgtMonth, tgtType, tgtEmp, tgtAmnt";
					$valuesToAdd= " '$tgtMonth','mfs', '$EmpName',$mfsTgtAmnt";
					$sq = mysqli_query($con,"INSErt INTO target($columnsToAdd) values($valuesToAdd)")or die(mysqli_query());
					
					echo '<script type="text/javascript">alert("Otar target '.$OtartgtAmnt.' and mfs target '.$mfsTgtAmnt.' Successfully Entered");</script>';
				}
			
			}
		else if($OtartgtAmnt > 0 && $mfsTgtAmnt == "")
			{
				if ($othergtType!="---")
					{
					$columnsToAdd="tgtMonth, tgtType, tgtEmp, tgtAmnt";
					$valuesToAdd= " '$tgtMonth','$othergtType', '$EmpName',$othergtAmnt";
					$sq = mysqli_query($con,"INSErt INTO target($columnsToAdd) values($valuesToAdd)")or die(mysqli_query());
					echo '<script type="text/javascript">alert("'.$othergtType.' target Amounting Rs. '.$othergtAmnt.' Sucessfully entered.");</script>';
					
					$columnsToAdd="tgtMonth, tgtType, tgtEmp, tgtAmnt";
					$valuesToAdd= " '$tgtMonth','Otar', '$EmpName',$OtartgtAmnt";
					$sq = mysqli_query($con,"INSErt INTO target($columnsToAdd) values($valuesToAdd)")or die(mysqli_query());
					
					echo '<script type="text/javascript">alert("Otar target '.$OtartgtAmnt.' and mfs target '.$mfsTgtAmnt.' Successfully Entered");</script>';
					}
				else
				{
					$columnsToAdd="tgtMonth, tgtType, tgtEmp, tgtAmnt";
					$valuesToAdd= " '$tgtMonth','Otar', '$EmpName',$OtartgtAmnt";
					$sq = mysqli_query($con,"INSErt INTO target($columnsToAdd) values($valuesToAdd)")or die(mysqli_query());
					echo '<script type="text/javascript">alert("Otar target '.$OtartgtAmnt.' Successfully Entered");</script>';
				}
			}
		else if($OtartgtAmnt == "" && $mfsTgtAmnt > 0)
			{
				if ($othergtType!="---")
					{
					$columnsToAdd="tgtMonth, tgtType, tgtEmp, tgtAmnt";
					$valuesToAdd= " '$tgtMonth','$othergtType', '$EmpName',$othergtAmnt";
					$sq = mysqli_query($con,"INSErt INTO target($columnsToAdd) values($valuesToAdd)")or die(mysqli_query());
					echo '<script type="text/javascript">alert("'.$othergtType.' target Amounting Rs. '.$othergtAmnt.' Sucessfully entered.");</script>';
					
					$columnsToAdd="tgtMonth, tgtType, tgtEmp, tgtAmnt";
					$valuesToAdd= " '$tgtMonth','mfs', '$EmpName',$mfsTgtAmnt";
					$sq = mysqli_query($con,"INSErt INTO target($columnsToAdd) values($valuesToAdd)")or die(mysqli_query());
					
					echo '<script type="text/javascript">alert("mfs target '.$mfsTgtAmnt.' Successfully Entered");</script>';
					}
				else
				{
					$columnsToAdd="tgtMonth, tgtType, tgtEmp, tgtAmnt";
					$valuesToAdd= " '$tgtMonth','mfs', '$EmpName',$mfsTgtAmnt";
					$sq = mysqli_query($con,"INSErt INTO target($columnsToAdd) values($valuesToAdd)")or die(mysqli_query());
					
					echo '<script type="text/javascript">alert("mfs target '.$mfsTgtAmnt.' Successfully Entered");</script>';
				}
			}
		else
		{
			if ($othergtType != "---")
			{
			$columnsToAdd="tgtMonth, tgtType, tgtEmp, tgtAmnt";
			$valuesToAdd= " '$tgtMonth','$othergtType', '$EmpName',$othergtAmnt" ;
			$sq = mysqli_query($con,"INSErt INTO target($columnsToAdd) values($valuesToAdd)")or die(mysqli_query());
			echo '<script type="text/javascript">alert("'.$othergtType.' target Amounting Rs. '.$othergtAmnt.' Sucessfully entered.");</script>';
			}
			else
			{
				echo '<script type="text/javascript">alert("No Option Selected.");</script>';
			}	
		}	
	}
}


	
/*         <<<<<<<<<<<<  THIS IS products/SUB_products MODULE   >>>>>>>>>>>>>>>      */
	
if (isset($_POST['SaveSubType']))
	{
	$pName=$_POST['pSelect'];
	$subType=$_POST['txtSubType'];
	$cmnts=$_POST['txtComments'];
	if ($pName== "---")
			{ echo '<script type="text/javascript">alert("Please Select a Product from \"Product List\".");</script>'; }
	else if ($subType== "")
			{ echo '<script type="text/javascript">alert("Please Enter Sub-Type i.e. \"Card Rs. 100\"   or  \"xCite J-100\".");</script>'; }
	else
	{
		$columnsToAdd="productName,typeName,typeComments,isActive";
		$valuesToAdd= " '$pName','$subType','$cmnts',1";
		//echo "$columnsToAdd". "<br>"."$valuesToAdd";
		
		$sq = mysqli_query($con,"INSErt INTO types($columnsToAdd) values($valuesToAdd)")or die(mysqli_query());
		echo '<script type="text/javascript">alert("Sub-Type Successfully Entered");</script>';
	}
	}
	

	
	
	/*         <<<<<<<<<<<<  THIS IS RECEIVE BACK mfs MODULE   >>>>>>>>>>>>>>>      */
	
	
	if (isset($_POST['SaveReceivemfs']))
	{
	$tempEmpName=$_POST['empSelect'];
	$dateNow=$_POST['txtDate'];
				if ($dateNow=="")
					$dateNow=date('Y-m-d');
	$tmptxtAmntReceived=$_POST['txtAmntReceived'];
	$tempStatus="Received";
	$tmptxtNotes=$_POST['txtNotes'];
		//if ($tmptxtNotes== "")
		//	{ $tmptxtNotes="Empty"; }

	// Check if all data fields have been filled or not
	
	if ($tempEmpName== "---")
			{ echo '<script type="text/javascript">alert("Please Select Employee From \"Receiving From:\" box.");</script>'; }
	
	else if ($tmptxtAmntReceived== "")
			{ echo '<script type="text/javascript">alert("Please Enter any amount in \"mfs Amount:\" box.");</script>'; }
	else
	{
		$columnsToAdd="mfsStatus, mfsDate, mfsEmp, mfsReceive, mfsComments";
		$valuesToAdd= " '$tempStatus','$dateNow', '$tempEmpName',$tmptxtAmntReceived,'$tmptxtNotes' ";
		//echo "$columnsToAdd". "<br>"."$valuesToAdd";
		
		$sq = mysqli_query($con,"INSERT INTO tbl_financial_service($columnsToAdd) values($valuesToAdd)")or die(mysqli_query());
		echo '<script type="text/javascript">alert("mfs Successfully Entered");</script>';
	}
	}
	
	
	
	
	
	
	
	
	
	
	
	
	
	
if(isset($_POST['Reset']))
	{
		$_POST = array();
	}
	

	
	
	
	
if (isset($_POST['ShowRP']))
{
	$tempEmpName=$Employee;
	$dateFrom=$_POST['txtDateFrom'];
	$dateTo=$_POST['txtDateTo'];
	$order=$_POST['orderBySelect'];
	if($order=="Date")
		$orderBy="rpDate";
	else if($order=="Paid To")
		$orderBy="rpFromTo";
	else if($order=="Amount")
		$orderBy="rpAmnt";
	
	if	($tempEmpName=="---")
	{	$summaryFlag=1;
		$paidsummary ="SELECT * FROM receiptpayment WHERE rpStatus=\"PaidTo\" AND rpDate BETWEEN \"$dateFrom\" AND \"$dateTo\" ORDER BY $orderBy";
		$receiptsummary ="SELECT * FROM receiptpayment WHERE rpStatus=\"ReceivedFrom\" AND rpDate BETWEEN \"$dateFrom\" AND \"$dateTo\" ORDER BY $orderBy";
	}
	else
	{
		$summaryFlag=1;
		$paidsummary = "SELECT * FROM receiptpayment WHERE rpStatus=\"PaidTo\" AND rpFromTo=\"$tempEmpName\" AND rpDate BETWEEN \"$dateFrom\" AND \"$dateTo\" ORDER BY $orderBy";
		$receiptsummary = "SELECT * FROM receiptpayment WHERE rpStatus=\"ReceivedFrom\" AND rpFromTo=\"$tempEmpName\" AND rpDate BETWEEN \"$dateFrom\" AND \"$dateTo\" ORDER BY $orderBy";
	}
}	
	
?>