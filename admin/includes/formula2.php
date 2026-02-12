<?php
include_once('variables.php');
include_once('globalvar.php');

/*         <<<<<<<<<<<<  THIS IS RECEIPT/PAYMENT MODULE   >>>>>>>>>>>>>>>      */

if($Employee=="do" or $Employee=="DO")
		echo '<script type="text/javascript">alert("Please First Select a DO then perform additional working.");</script>';
else
	{
		if (isset($_POST['SaveDueReceived']))
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
		if (isset($_POST['SaveDuePaid']))
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
	
	
	
	
if (isset($_POST['SaveOCinitial']))
	{
	if($Employee=="do")
		echo '<script type="text/javascript">alert("Please First Select a do then perform additional working.");</script>';
	else
			{
				$cloMonth=$_POST['cMonthSelect'];
				$opnMonth=$_POST['oMonthSelect'];
				$typ=$_POST['ocSelect'];
				$tempEmpName=$Employee;
				$tmptxtAmnt=$_POST['txtAmnt'];
				$by=$currentUser;
				$dateNow=date('Y-m-d');

				
				// Check if all data fields have been filled or not
				
				if ($typ== "---")
						{ echo '<script type="text/javascript">alert("Please Select an option from \"Type\" box.");</script>'; }
				else if ($tmptxtAmnt== "")
						{ echo '<script type="text/javascript">alert("Please Enter any amount in \"Amount\" field.");</script>'; }
				else
				{
					$columnsToAdd="cMonth, oMonth, ocType, ocEmp, ocAmnt, savedBy, savingDateTime";
					$valuesToAdd= "'$cloMonth', '$opnMonth','$typ', '$tempEmpName',$tmptxtAmnt,'$by','$dateNow' ";
					//echo "$columnsToAdd". "<br>"."$valuesToAdd";
					
					$sq = mysqli_query($con,"INSErt INTO openingclosing($columnsToAdd) values($valuesToAdd)")or die(mysqli_query());
					echo '<script type="text/javascript">alert("Successfully Entered");</script>';
				}
			}
	}
	
	
	
?>