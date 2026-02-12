<?php
include_once('globalvar.php');
if($Employee=="ws")
	echo '<script type="text/javascript">alert("Please First Select a ws then perform additional working.");</script>';
else
	{
				if (isset($_POST['AddLoad']))
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
							$sq = mysqli_query($con,"INSErt INTO tbl_mobile_load(loadStatus,loadDate,loadEmp,loadAmnt, loadTransfer, loadProfit, loadExcessProfit) values('$status','$dateNow','$loadEmp', $loadAmnt, $loadTransfer, $profitReceived, $excessProfit)")or die(mysqli_query());
							echo '<script type="text/javascript">alert("Load Amounting Rs. '.$loadTransfer.' Successfully Transferred to '. $loadEmp.'. ");</script>';
							}
						}
						
				if (isset($_POST['Addmfs']))
						{
							$mfsAmnt=$_POST['txtmfsSend'];
							if($mfsAmnt=='')
								echo '<script type="text/javascript">alert("Please Enter mfs Amount.");</script>';
							else
							{
							$dateNow=$_POST['txtDate'];
							if ($dateNow=="")
								$dateNow=date('Y-m-d');
							$mfsEmp=$Employee;
							$mfsStatus="Sent";
							$sq = mysqli_query($con,"INSERT INTO tbl_financial_service(mfsStatus, mfsDate,mfsEmp, mfsAmnt) values('$mfsStatus','$dateNow','$mfsEmp', $mfsAmnt)")or die(mysqli_query());
							echo '<script type="text/javascript">alert("mfs Amounting Rs. '.$mfsAmnt.' Successfully Transferred to '. $mfsEmp.'. ");</script>';
							}
						}
						
				if (isset($_POST['Recmfs']))
						{
							$mfsAmnt=$_POST['txtmfsReceive'];
							if($mfsAmnt=='')
								echo '<script type="text/javascript">alert("Please Enter mfs Receive Amount.");</script>';
							else
							{
							$dateNow=$_POST['txtDate'];
							if ($dateNow=="")
								$dateNow=date('Y-m-d');
							$mfsEmp=$Employee;
							
							$mfsStatus="Received";
							
							$sq = mysqli_query($con,"INSERT INTO tbl_financial_service(mfsStatus, mfsDate,mfsEmp, mfsAmnt) values('$mfsStatus','$dateNow','$mfsEmp', $mfsAmnt)")or die(mysqli_query());
							echo '<script type="text/javascript">alert("mfs Amounting Rs. '.$mfsAmnt.' Successfully Received From '. $mfsEmp.'. ");</script>';
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
								$oAmnt= $cQty * $cardPurchaseRate;
								$Amount=$cQty * $tbl_cardsRate;
								$pLos= $Amount - $oAmnt;
								$cmnts=$_POST['txtCardCmnt'];
									$sq = mysqli_query($con,"INSErt INTO tbl_cards(csStatus, csDate,csEmp,csType, csQty, csOrgAmnt, csTotalAmnt, csRate, csProLoss,csComments) values('$csStatus','$dateNow','$Emp','$csType', $cQty, $oAmnt, $Amount, $tbl_cardsRate, $pLos,'$cmnts')")or die(mysqli_query());
									echo '<script type="text/javascript">alert("'.$cQty.' cards of '.$csType.' Successfully Sent to '. $Emp.'. ");</script>';
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
									$sq = mysqli_query($con,"INSErt INTO tbl_product_stock(sDate,pName, pSubType, trtype, customer, qty, rate, sComments) values('$dateNow','$pName','$pType','$Status', '$Emp', $pQty, $pSaleRate, '$cmnts')")or die(mysqli_query());
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
									$sq = mysqli_query($con,"INSErt INTO tbl_product_stock(sDate,pName, pSubType, trtype, customer, qty, rate, sComments) values('$dateNow','$pName','$sType','$Status', '$Emp', $sQty, $sSaleRate, '$cmnts')")or die(mysqli_query());
									echo '<script type="text/javascript">alert("'.$sQty.' SIMs of type '.$sType.' Successfully Sent to '. $Emp.'. ");</script>';
							}
						}
	}

?>