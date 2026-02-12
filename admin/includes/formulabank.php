<?php
include_once('includes/variables.php');
include_once('globalvar.php');

/*         <<<<<<<<<<<<  THIS IS RECEIPT MODULE   >>>>>>>>>>>>>>>      */

if (isset($_POST['SaveDueReceived']))
	{
	if($Employee=="do")
		echo '<script type="text/javascript">alert("Please First Select a do then perform additional working.");</script>';
	else
			{
				$tempEmpName=$Employee;
				$dateNow=$_POST['txtDate'];
							if ($dateNow=="")
								$dateNow=date('Y-m-d');
				$tmptxtAmntReceived=$_POST['txtAmntReceived'];
				//$tempFor=$_POST['rfSelect'];
				$tempMode=$_POST['modeSelect'];
				$tmptxtNotes=$_POST['txtNotesR'];
				$status="ReceivedFrom";
				$user=$currentUser;
				
				// Check if all data fields have been filled or not
				
				if ($tempMode== "---")
						{ echo '<script type="text/javascript">alert("Please Select Receive Mode from \"Mode\" box.");</script>'; }
				else if ($tmptxtAmntReceived== "")
						{ echo '<script type="text/javascript">alert("Please Enter any amount in \"Amount Received\" box.");</script>'; }
				else
				{
					$columnsToAdd="rpFor,rpDate, rpStatus, rpFromTo, rpAmnt, rpmode, rpUser, rpNotes";
					$valuesToAdd= "'DO Dues', '$dateNow','$status', '$tempEmpName',$tmptxtAmntReceived,'$tempMode','$user','$tmptxtNotes' ";
					//echo "$columnsToAdd". "<br>"."$valuesToAdd";
					
					$sq = mysqli_query($con,"INSErt INTO receiptpayment($columnsToAdd) values($valuesToAdd)")or die(mysqli_query());
					echo '<script type="text/javascript">alert("Successfully Entered");</script>';
				}
			}
	}
	

	if (isset($_POST['SaveDuePaid']))
	{
	if($Employee=="do")
		echo '<script type="text/javascript">alert("Please First Select a do then perform additional working.");</script>';
	else
			{
				$tempEmpName=$Employee;
				$dateNow=$_POST['txtDate'];
							if ($dateNow=="")
								$dateNow=date('Y-m-d');
				$tmptxtAmntReceived=$_POST['txtAmntPaid'];
				//$tempFor=$_POST['rfSelect'];
				$tempMode=$_POST['modeSelect'];
				$tmptxtNotes=$_POST['txtNotesP'];
				$status="PaidTo";
				$user=$currentUser;
				
				// Check if all data fields have been filled or not
				
				if ($tempMode== "---")
						{ echo '<script type="text/javascript">alert("Please Select Receive Mode from \"Mode\" box.");</script>'; }
				else if ($tmptxtAmntReceived== "")
						{ echo '<script type="text/javascript">alert("Please Enter any amount in \"Amount Paid\" box.");</script>'; }
				else
				{
					$columnsToAdd="rpFor,rpDate, rpStatus, rpFromTo, rpAmnt, rpmode, rpUser, rpNotes";
					$valuesToAdd= "'DO Dues', '$dateNow','$status', '$tempEmpName',$tmptxtAmntReceived,'$tempMode','$user','$tmptxtNotes' ";
					//echo "$columnsToAdd". "<br>"."$valuesToAdd";
					
					$sq = mysqli_query($con,"INSErt INTO receiptpayment($columnsToAdd) values($valuesToAdd)")or die(mysqli_query());
					echo '<script type="text/javascript">alert("Successfully Entered");</script>';
				}
			}
	}
	
	
	
?>