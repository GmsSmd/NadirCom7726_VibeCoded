<?php
include_once('includes/variables.php');
include_once('globalvar.php');
if($Employee=="do" or $Employee=="DO" )
	echo '<script type="text/javascript">alert("Please First Select a DO then perform additional working.");</script>';
else
	{
				if (isset($_POST['AddLoad']) OR isset($_POST['Go1']))
						{
							$loadAmnt=$_POST['txtLoad'];
							if($loadAmnt=='')
								echo '<script type="text/javascript">alert("Please Enter Load Amount.");</script>';
							else
							{
							$dateNow=$_POST['txtDate'];
							if ($dateNow=="")
								$dateNow=date('Y-m-d');
							$loadEmp= $Employee;
							$status="Sent";
							$loadTransfer= $loadAmnt + ( $loadAmnt * $marginSent);
							$profitReceived = $loadAmnt * $franchiseProfitRate;
							$excessProfit = ($loadTransfer - $loadAmnt) * $marginReceived;
							$sq = mysqli_query($con,"INSErt INTO tbl_mobile_load(loadStatus,loadDate,loadEmp,loadAmnt, loadTransfer, loadProfit, loadExcessProfit,pRate,sRate,User) values('$status','$dateNow','$loadEmp', $loadAmnt, $loadTransfer, $profitReceived, $excessProfit,$marginReceived,$marginSent,'$currentUser')")or die(mysqli_query());
							echo '<script type="text/javascript">alert("Load Amounting Rs. '.$loadTransfer.' Successfully Transferred to '. $loadEmp.'. ");</script>';
							}
						}
						
				if (isset($_POST['Addmfs']) OR isset($_POST['Go2']))
						{
							$mfsAmnt=$_POST['txtmfsSend'];
							if($mfsAmnt=='')
								echo '<script type="text/javascript">alert("Please Enter mfs Amount.");</script>';
							else
							{
								if(isset($_POST['txtMfsSendCmnt']))
									$sendComments=$_POST['txtMfsSendCmnt'];
								else
									$sendComments="";
								
							
							$dateNow=$_POST['txtDate'];
							if ($dateNow=="")
								$dateNow=date('Y-m-d');
							$mfsEmp=$Employee;
							$mfsStatus="Sent";
							$sq = mysqli_query($con,"INSERT INTO tbl_financial_service(mfsStatus, mfsDate,mfsEmp, mfsAmnt,User,mfsComments) values('$mfsStatus','$dateNow','$mfsEmp', $mfsAmnt,'$currentUser','$sendComments')")or die(mysqli_query());
							echo '<script type="text/javascript">alert("mfs Amounting Rs. '.$mfsAmnt.' Successfully Transferred to '. $mfsEmp.'. ");</script>';
							}
						}
						
				if (isset($_POST['Recmfs']) OR isset($_POST['Go2']))
						{
							$mfsAmnt=$_POST['txtmfsReceive'];
							if($mfsAmnt=='')
								echo '<script type="text/javascript">alert("Please Enter mfs Receive Amount.");</script>';
							else
							{
								if(isset($_POST['txtMfsRecCmnt']))
									$recComments=$_POST['txtMfsRecCmnt'];
								else
									$recComments="";
							
							//$recComments=$_POST['txtMfsRecCmnt'];
							$dateNow=$_POST['txtDate'];
							if ($dateNow=="")
								$dateNow=date('Y-m-d');
							$mfsEmp=$Employee;
							
							$mfsStatus="Received";
							
							$sq = mysqli_query($con,"INSERT INTO tbl_financial_service(mfsStatus, mfsDate,mfsEmp, mfsAmnt,User,mfsComments) values('$mfsStatus','$dateNow','$mfsEmp', $mfsAmnt,'$currentUser','$recComments')")or die(mysqli_query());
							echo '<script type="text/javascript">alert("mfs Amounting Rs. '.$mfsAmnt.' Successfully Received From '. $mfsEmp.'. ");</script>';
							}
						}
					
				if (isset($_POST['AmntReceive']) OR isset($_POST['Go1']))
						{
							$Amnt=$_POST['txtAmnTaken'];
							$Mode=$_POST['modeSelect'];
							
							if($Amnt=='')
								echo '<script type="text/javascript">alert("Please Enter Taken Amount.");</script>';
							else if($Mode=='---')
								echo '<script type="text/javascript">alert("Please select Receive Mode.");</script>';
							else
							{
								$dateNow=$_POST['txtDate'];
								if ($dateNow=="")
									$dateNow=date('Y-m-d');
								$For='LMC';
								$Emp=$Employee;
								$Status="ReceivedFrom";
								
								$sq = mysqli_query($con,"INSErt INTO receiptpayment(rpFor,rpDate,rpStatus,rpFromTo,rpAmnt,rpmode,rpUser) values('$For','$dateNow','$Status','$Emp', $Amnt, '$Mode','$currentUser')")or die(mysqli_query());
								echo '<script type="text/javascript">alert("Amount Rs. '.$Amnt.' Successfully Taken From '. $Emp.'. ");</script>';
							}
						}
					
				if (isset($_POST['AddCQty']))
						{
							$csType=$_POST['SubCselect'];
							$cQty=$_POST['txtCQty'];
							$tbl_cardsRate=$_POST['txtCSaleRate'];
							
							if($csType=='---')
								echo '<script type="text/javascript">alert("Please Select Card Type.");</script>';
							else if ($cQty=="")
								echo '<script type="text/javascript">alert("Please Enter Card Quantity.");</script>';
							else if ($tbl_cardsRate=="")
								echo '<script type="text/javascript">alert("Please Enter Card Sale Rate.");</script>';
							else
							{
								$csStatus="Sent";
								$dateNow=$_POST['txtDate'];
								if ($dateNow=="")
									$dateNow=date('Y-m-d');
								$Emp=$Employee;
								
								$Amount=$cQty * $tbl_cardsRate;
								
								$cmnts=$_POST['txtCardCmnt'];
								
								//// get rate then save with rate
								
								$getRate = mysqli_query($con,"SELECT purchasePrice from rates WHERE spName= '$csType' ORDER BY rtID DESC LIMIT 1")or die(mysqli_query());
								$rt=mysqli_fetch_array($getRate);
								$cpp=$rt['purchasePrice'];
								
								if($cpp=='')
									{ echo '<script type="text/javascript">alert("Purchase Rate NOT FOUND.");</script>'; }
								else
									$oAmnt= $cQty * $cpp;
									$pLos= $Amount - $oAmnt;
									{
									$sq = mysqli_query($con,"INSErt INTO tbl_cards(csStatus, csDate,csEmp,csType, csQty, csOrgAmnt, csTotalAmnt, csRate, csProLoss,csComments,User) values('$csStatus','$dateNow','$Emp','$csType', $cQty, $oAmnt, $Amount, $tbl_cardsRate, $pLos,'$cmnts','$currentUser')")or die(mysqli_query());
									echo '<script type="text/javascript">alert("'.$cQty.' cards of '.$csType.' Successfully Sent to '. $Emp.'. ");</script>';
									}
							}
						}
			
				if (isset($_POST['AddPQty']))
						{
							$pType=$_POST['SubPselect'];
							$pQty=$_POST['txtPQty'];
							$pSaleRate=$_POST['txtPSaleRate'];
							
							if($pType=='---')
								echo '<script type="text/javascript">alert("Please Select Phone Type.");</script>';
							else if ($pQty=="")
								echo '<script type="text/javascript">alert("Please Enter Phone Quantity.");</script>';
							else if ($pSaleRate=="")
								echo '<script type="text/javascript">alert("Please Enter Phone Sale Rate.");</script>';
							else
							{
								$Status="Sent";
								$dateNow=$_POST['txtDate'];
								if ($dateNow=="")
									$dateNow=date('Y-m-d');
								$Emp=$Employee;
								$pName="Mobile";
								$cmnts=$_POST['txtPCmnt'];
									$sq = mysqli_query($con,"INSErt INTO tbl_product_stock(sDate,pName, pSubType, trtype, customer, qty, rate, sComments,User) values('$dateNow','$pName','$pType','$Status', '$Emp', $pQty, $pSaleRate, '$cmnts','$currentUser')")or die(mysqli_query());
									echo '<script type="text/javascript">alert("'.$pQty.' Phones '.$pType.' Successfully Sent to '. $Emp.'. ");</script>';
							}
						}
	
				if (isset($_POST['AddSQty']))
						{
							$sType=$_POST['SubSselect'];
							$sQty=$_POST['txtSQty'];
							$sSaleRate=$_POST['txtSSaleRate'];
							
							if($sType=='---')
								echo '<script type="text/javascript">alert("Please Select SIM Type.");</script>';
							else if ($sQty=="")
								echo '<script type="text/javascript">alert("Please Enter SIM Quantity.");</script>';
							else if ($sSaleRate=="")
								echo '<script type="text/javascript">alert("Please Enter SIM Sale Rate.");</script>';
							else
							{
								$Status="Sent";
								$dateNow=$_POST['txtDate'];
								if ($dateNow=="")
									$dateNow=date('Y-m-d');
								$Emp=$Employee;
								$pName="SIM";
								$cmnts=$_POST['txtSCmnt'];
									$sq = mysqli_query($con,"INSErt INTO tbl_product_stock(sDate,pName, pSubType, trtype, customer, qty, rate, sComments,User) values('$dateNow','$pName','$sType','$Status', '$Emp', $sQty, $sSaleRate, '$cmnts','$currentUser')")or die(mysqli_query());
									echo '<script type="text/javascript">alert("'.$sQty.' SIMs of type '.$sType.' Successfully Sent to '. $Emp.'. ");</script>';
							}
						}
	}
	
	//$move="do.php?name=".$Employee;
	//header("location: $move");
	//exit;
	//$_POST[]=array();
	
	
	
	
	//////****** CASH RECEIVING MODULE ******//////
	
	if (isset($_POST['RecCardAmnt']) OR isset($_POST['AddCQty']))
		{
					$tempEmpName=$Employee;
					$dateNow=$_POST['txtDate'];
								if ($dateNow=="")
									$dateNow=date('Y-m-d');
					$tmptxtAmntReceived=$_POST['txtCardAmntRec'];
					$tempFor="Card";
					$tempMode=$_POST['modeSelect1'];
					$tmptxtNotes=$_POST['txtCardAmntCmnt'];
					$status="ReceivedFrom";
					$user=$currentUser;
					
					// Check if all data fields have been filled or not
					
					if ($tempEmpName== "DO")
							{ echo '<script type="text/javascript">alert("Please Select a DO First.");</script>'; }
					else if ($tempFor== "---")
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
	
	
	if (isset($_POST['RecMobAmnt']) OR isset($_POST['AddPQty']))
		{
					$tempEmpName=$Employee;
					$dateNow=$_POST['txtDate'];
								if ($dateNow=="")
									$dateNow=date('Y-m-d');
					$tmptxtAmntReceived=$_POST['txtMobAmntRec'];
					$tempFor="Mobile";
					$tempMode=$_POST['modeSelect2'];
					$tmptxtNotes=$_POST['txtPhoneAmntCmnt'];
					$status="ReceivedFrom";
					$user=$currentUser;
					
					// Check if all data fields have been filled or not
					
					if ($tempEmpName== "DO")
							{ echo '<script type="text/javascript">alert("Please Select a DO First.");</script>'; }
					else if ($tempFor== "---")
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
	
	
	if (isset($_POST['RecSIMAmnt']) OR isset($_POST['AddSQty']))
		{
					$tempEmpName=$Employee;
					$dateNow=$_POST['txtDate'];
								if ($dateNow=="")
									$dateNow=date('Y-m-d');
					$tmptxtAmntReceived=$_POST['txtSIMAmntRec'];
					$tempFor="SIM";
					$tempMode=$_POST['modeSelect3'];
					$tmptxtNotes=$_POST['txtSimAmntCmnt'];
					$status="ReceivedFrom";
					$user=$currentUser;
					
					// Check if all data fields have been filled or not
					
					if ($tempEmpName== "DO")
							{ echo '<script type="text/javascript">alert("Please Select a DO First.");</script>'; }
					else if ($tempFor== "---")
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
	
	
	
?>