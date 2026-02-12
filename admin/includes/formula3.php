<?php
include_once('includes/variables.php');
include_once('globalvar.php');

/*         <<<<<<<<<<<<  THIS IS RECEIPT MODULE   >>>>>>>>>>>>>>>      */
if($Employee=="do" or $Employee=="DO")
		echo '<script type="text/javascript">alert("Please First Select a DO then perform additional working.");</script>';
else
	{
		if (isset($_POST['SaveReceipt']))
		{
					$tempEmpName=$Employee;
					$dateNow=$_POST['txtDate'];
								if ($dateNow=="")
									$dateNow=date('Y-m-d');
					$tmptxtAmntReceived=$_POST['txtAmntReceived'];
					$tempFor=$_POST['rfSelect'];
					$tempMode=$_POST['modeSelect'];
					$tmptxtNotes=$_POST['txtNotes'];
					$status="ReceivedFrom";
					$user=$currentUser;
					
					// Check if all data fields have been filled or not
					
					if ($tempFor== "---")
							{ echo '<script type="text/javascript">alert("Please Select an option from \"Received For\" drop down.");</script>'; }
					else if ($tempMode== "---")
							{ echo '<script type="text/javascript">alert("Please Select Receive Mode from \"Receive Mode\" box.");</script>'; }
					else if ($tmptxtAmntReceived== "")
							{ echo '<script type="text/javascript">alert("Please Enter any amount in \"Amount Received\" box.");</script>'; }
					else
					{
						$columnsToAdd="rpFor,rpDate, rpStatus, rpFromTo, rpAmnt, rpmode, rpUser, rpNotes";
						$valuesToAdd= "'$tempFor', '$dateNow','$status', '$tempEmpName',$tmptxtAmntReceived,'$tempMode','$user','$tmptxtNotes' ";
						//echo "$columnsToAdd". "<br>"."$valuesToAdd";
						
						$sq = mysqli_query($con,"INSErt INTO receiptpayment($columnsToAdd) values($valuesToAdd)")or die(mysqli_query());
						echo '<script type="text/javascript">alert("Successfully Entered");</script>';
					}
		}


		if(isset($_POST['ResetReceipt']))
		{
			$_POST = array();
		}


		if (isset($_POST['Showreceipts']))
		{
			$tempEmpName=$_POST['empSelect'];
			$for=$_POST['ocSelect'];
			$dateFrom=$_POST['txtDateFrom'];
			$dateTo=$_POST['txtDateTo'];
			
						
			if	($tempEmpName=="---" AND $for=="---")
			{	$receiptsummaryflag=1;
				$receiptsummary ="SELECT * FROM receiptpayment WHERE rpStatus=\"ReceivedFrom\" AND rpDate BETWEEN \"$dateFrom\" AND \"$dateTo\" ORDER BY rpDate ASC ";
			}
			else if($tempEmpName=="---" AND $for!="---")
			{
				$receiptsummaryflag=1;
				$receiptsummary ="SELECT * FROM receiptpayment WHERE rpStatus=\"ReceivedFrom\"  AND rpFor='$for' AND rpDate BETWEEN \"$dateFrom\" AND \"$dateTo\" ORDER BY rpDate ASC ";
			}
			else if($tempEmpName!="---" AND $for=="---")
			{
			$receiptsummaryflag=1;
				$receiptsummary ="SELECT * FROM receiptpayment WHERE rpStatus=\"ReceivedFrom\"  AND rpFromTo=\"$tempEmpName\" AND rpDate BETWEEN \"$dateFrom\" AND \"$dateTo\" ORDER BY rpDate ASC ";
			}
			else
			{
				$receiptsummaryflag=1;
				$receiptsummary = "SELECT * FROM receiptpayment WHERE rpStatus=\"ReceivedFrom\" AND rpFromTo=\"$tempEmpName\" AND rpFor='$for' AND rpDate BETWEEN \"$dateFrom\" AND \"$dateTo\" ORDER BY rpDate ASC";
			}
		}



/*         <<<<<<<<<<<<  THIS IS PAYMENT MODULE   >>>>>>>>>>>>>>>      */

		if (isset($_POST['SavePayment']))
		{

					$tempEmpName=$Employee;
					$dateNow=$_POST['txtDate'];
								if ($dateNow=="")
									$dateNow=date('Y-m-d');
					$tmptxtAmntPaid=$_POST['txtAmntPaid'];
					$For=$_POST['pfSelect'];
					$tempMode=$_POST['modeSelect'];
					$tmptxtNotes=$_POST['txtNotes'];
					$status="PaidTo";
					$user=$currentUser;
					
					// Check if all data fields have been filled or not
					
					if ($For == "---")
							{ echo '<script type="text/javascript">alert("Please Select an option from \"Payment For\" drop down.");</script>'; }
					else if ($tempMode== "---")
							{ echo '<script type="text/javascript">alert("Please Select an option from \"Payment Mode\" box.");</script>'; }
					else if ($tmptxtAmntPaid== "")
							{ echo '<script type="text/javascript">alert("Please Enter any amount in \"Amount Paid\" box.");</script>'; }
					else
					{
						$columnsToAdd="rpFor,rpDate, rpStatus, rpFromTo, rpAmnt, rpmode, rpUser, rpNotes";
						$valuesToAdd= " '$For', '$dateNow','$status', '$tempEmpName',$tmptxtAmntPaid,'$tempMode','$user','$tmptxtNotes' ";
						//echo "$columnsToAdd". "<br>"."$valuesToAdd";
						
						$sq = mysqli_query($con,"INSErt INTO receiptpayment($columnsToAdd) values($valuesToAdd)")or die(mysqli_query());
						echo '<script type="text/javascript">alert("Successfully Entered");</script>';
					}
		}

		if(isset($_POST['ResetPayment']))
		{
			$_POST = array();
		}	


		if (isset($_POST['Showpayments']))
		{
			$tempEmpName=$_POST['empSelect'];
			$for=$_POST['ocSelect'];
			$dateFrom=$_POST['txtDateFrom'];
			$dateTo=$_POST['txtDateTo'];
			
			/*
			$order=$_POST['orderBySelect'];
			
			if($order=="Date")
				$orderBy="rpDate";
			else if($order=="Paid To")
				$orderBy="rpFromTo";
			else if($order=="Amount")
				$orderBy="rpAmnt";
			*/
			if	($tempEmpName=="---" AND $for=="---")
			{	$paidsummaryflag=1;
				$paidsummary ="SELECT * FROM receiptpayment WHERE rpStatus=\"PaidTo\" AND rpDate BETWEEN \"$dateFrom\" AND \"$dateTo\" ORDER BY rpDate ASC";
			}
			else if($tempEmpName=="---" AND $for!="---")
			{
				$paidsummaryflag=1;
				$paidsummary = "SELECT * FROM receiptpayment WHERE rpStatus=\"PaidTo\" AND rpFor='$for' AND rpDate BETWEEN \"$dateFrom\" AND \"$dateTo\" ORDER BY rpDate ASC ";
			}
			else if($tempEmpName!="---" AND $for=="---")
			{
				$paidsummaryflag=1;
				$paidsummary = "SELECT * FROM receiptpayment WHERE rpStatus=\"PaidTo\" AND rpFromTo=\"$tempEmpName\" AND rpDate BETWEEN \"$dateFrom\" AND \"$dateTo\" ORDER BY rpDate ASC ";
			}
			else
			{
				$paidsummaryflag=1;
				$paidsummary = "SELECT * FROM receiptpayment WHERE rpStatus=\"PaidTo\" AND rpFromTo=\"$tempEmpName\" AND rpFor='$for' AND rpDate BETWEEN \"$dateFrom\" AND \"$dateTo\" ORDER BY rpDate ASC ";
			}
		}
	}
	
?>