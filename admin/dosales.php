<?php
include_once('../session.php');
//include_once('includes/dbcon.php');
//global $con;
$Employee = mysqli_real_escape_string($con, $_GET['name']);
if(isset($_GET['num']))
    $lineNumber = mysqli_real_escape_string($con, $_GET['num']);
else
    $lineNumber='';
include_once('includes/doformula.php');
include_once('includes/globalvar.php');
//echo "<br><br><br>";
?>
	<head>
		<title>Sales Sheet</title>
			<style>
			<?php
				include_once('styles/navbarstyle.php');
				include_once('styles/tablestyle.php');
				include_once('includes/navbar.php');

				////////////////SALES Details////////////////
				$stringToPrint='';
				{
								$EmpOpening=mysqli_query($con,"SELECT sum(ocAmnt) From openingclosing WHERE ocEmp='$Employee' AND oMonth='$CurrentMonth' AND ocType='Cash' ");
								$Data=mysqli_fetch_array($EmpOpening);
								$opening = $Data['sum(ocAmnt)'];
								$open=$opening;
								
				// Card Opening		
								
								$EmpOpeningCard=mysqli_query($con,"SELECT sum(ocAmnt) From openingclosing WHERE ocEmp='$Employee' AND oMonth='$CurrentMonth' AND ocType='Card' ");
								$DataCard=mysqli_fetch_array($EmpOpeningCard);
								$openingCard = $DataCard['sum(ocAmnt)'];
								$openCard=$openingCard;
								//echo "<br><br><br>".$openCard;
								
						/*///////////////<<<<<<<<<<<   Mobile and SIM   >>>>>>>>>>>>>>>//////////////////*/
								$MobileCashOpening=mysqli_query($con,"SELECT ocAmnt From openingclosing WHERE ocEmp='$Employee' AND oMonth='$CurrentMonth' AND ocType='Mobile'  ");
								$Data02=mysqli_fetch_array($MobileCashOpening);
									$openMobileCash = $Data02['ocAmnt'];
								$SIMCashOpening=mysqli_query($con,"SELECT ocAmnt From openingclosing WHERE ocEmp='$Employee' AND oMonth='$CurrentMonth' AND ocType='SIM'  ");
								$Data03=mysqli_fetch_array($SIMCashOpening);
									$openSIMCash = $Data03['ocAmnt'];
						/*///////////////<<<<<<<<<<<   Mobile and SIM   >>>>>>>>>>>>>>>//////////////////*/
								
								

								$count=0; $sumLoad=0;	$sumTransfer=0;	$sumProfit=0; $sumSend=0; $sumReceive=0; $sumClose=0; $sumQty=0; $sumOrgAmnt=0; $sumSaleRate=0; $sumAmnt=0; $sumProLoss=0; $amount=0;
								$sumReceivable=0; $sumTaken=0;
							
								for($i=$date_from; $i<=$date_to; $i+=86400)
									{
									$count=$count+1;
									$takenCardsAmunt=0;
										$Dat=date("Y-m-d", $i);
                                        // Refactored to use LoadService
                                        if (!isset($loadService)) {
                                            $loadService = new \App\Services\LoadService();
                                        }
                                        $loadStats = $loadService->getLoadStats($Employee, $Dat);
                                        
										$load= $loadStats['total_load'] ?? 0;
									
										$transfer= $loadStats['total_transfer'] ?? 0;
										$Profit= $loadStats['total_profit'] ?? 0;
										$XsProfit= $loadStats['total_excess_profit'] ?? 0;
												$q2=mysqli_query($con,"SELECT sum(mfsAmnt) FROM tbl_financial_service WHERE mfsStatus='Sent' AND mfsEmp='$Employee' AND mfsDate ='$Dat' ");
												$Data2=mysqli_fetch_array($q2);
										$mfsSend= $Data2['sum(mfsAmnt)'];
												$q3=mysqli_query($con,"SELECT sum(mfsAmnt) FROM tbl_financial_service WHERE mfsStatus='Received' AND mfsEmp='$Employee' AND mfsDate ='$Dat' ");
												$Data3=mysqli_fetch_array($q3);
										$mfsReceive = $Data3['sum(mfsAmnt)'];
										$mfsClose = $mfsSend-$mfsReceive;
												$q4=mysqli_query($con,"SELECT sum(csQty), sum(csOrgAmnt), sum(csTotalAmnt), avg(csRate), sum(csProLoss) FROM tbl_cards WHERE csStatus='Sent' AND csEmp='$Employee' AND csDate ='$Dat' ");
												$Data4=mysqli_fetch_array($q4);
										$cardQty = $Data4['sum(csQty)'];
										$orgAmnt= $Data4['sum(csOrgAmnt)'];
										$saleRate= $Data4['avg(csRate)'];
										$amountCardsSale= $Data4['sum(csTotalAmnt)'];
										
										$pL= $Data4['sum(csProLoss)'];
										
										$receivable= $opening+$load+$mfsClose;
										$cardreceivables=$openingCard+$amountCardsSale;
										//echo "+".$amountCardsSale;
										//$receivable= $opening+$load+$mfsClose+$amount;
										$takenCardsAmunt=0;
												$q5=mysqli_query($con,"SELECT sum(rpAmnt) FROM receiptpayment WHERE rpStatus='ReceivedFrom' AND rpFromTo='$Employee' AND rpDate ='$Dat' AND rpFor='LMC' ");
												$Data5=mysqli_fetch_array($q5);
												$taken= $Data5['sum(rpAmnt)'];
												$dues= $receivable-$taken;
												$q555=mysqli_query($con,"SELECT sum(rpAmnt) FROM receiptpayment WHERE rpStatus='ReceivedFrom' AND rpFromTo='$Employee' AND rpDate ='$Dat' AND rpFor='Card' ");
												$Data555=mysqli_fetch_array($q555);
												$takenCardsAmunt= $Data555['sum(rpAmnt)'];
										//echo "<br>".$takenCardsAmunt;
									
										$cardreceivables=$cardreceivables-$takenCardsAmunt;
										
										//echo "<br><br><br>".$cardreceivables;
					/*///////////////<<<<<<<<<<<   Mobile and SIM Sales   >>>>>>>>>>>>>>>//////////////////*/
								$sAmntSum0=0;
									$sq6 = mysqli_query($con,"SELECT typeName FROM types WHERE productName='Mobile'")or die(mysqli_query());
									WHILE($Data6=mysqli_fetch_array($sq6))
									{
										$subType=$Data6['typeName'];
										$slAmnt=0; $qt2=0; $rt2=0; $sumQt=0;
										$q7 = mysqli_query($con,"SELECT * from tbl_product_stock WHERE pSubType='$subType' AND trtype='Sent' AND customer='$Employee' AND sDate BETWEEN '$QueryFD' AND '$Dat'  ")or die(mysqli_query());	
										WHILE($d7=mysqli_fetch_array($q7))
										{
										$qt2=$d7['qty'];
										$rt2=$d7['rate'];
										$sumQt=$sumQt+$qt2;
										$slAmnt=$slAmnt+($qt2*$rt2);
										}
										$sAmntSum0=$sAmntSum0+$slAmnt;
									}
									$sAmntSum1=0;
									$sAmntSum2=0;
									$sq8 = mysqli_query($con,"SELECT typeName FROM types WHERE productName='SIM'")or die(mysqli_query());
									WHILE($Data8=mysqli_fetch_array($sq8))
									{
										$subType=$Data8['typeName'];
										$slAmnt=0; $qt2=0; $rt2=0; $sumQt=0;
										$q9 = mysqli_query($con,"SELECT * from tbl_product_stock WHERE pSubType='$subType' AND trtype='Sent' AND customer='$Employee' AND sDate BETWEEN '$QueryFD' AND '$Dat'  ")or die(mysqli_query());	
										WHILE($d9=mysqli_fetch_array($q9))
										{
											$qt2=$d9['qty'];
											$rt2=$d9['rate'];
											$sumQt=$sumQt+$qt2;
											$slAmnt=$slAmnt+($qt2*$rt2);
										}
										$sAmntSum1=$sAmntSum1+$slAmnt;
									}
									$sAmntSum11=0;
									$sq81 = mysqli_query($con,"SELECT typeName FROM types WHERE productName='Card'")or die(mysqli_query());
									WHILE($Data81=mysqli_fetch_array($sq81))
									{
										$subType=$Data81['typeName'];
										$slAmnt21=0; $qt21=0; $rt21=0; $sumQt21=0;
										$q91 = mysqli_query($con,"SELECT * from tbl_product_stock WHERE pSubType='$subType' AND trtype='Sent' AND customer='$Employee' AND sDate BETWEEN '$QueryFD' AND '$Dat'  ")or die(mysqli_query());	
										WHILE($d91=mysqli_fetch_array($q91))
										{
											$qt21=$d91['qty'];
											$rt21=$d91['rate'];
											$sumQt21=$sumQt21+$qt21;
											$slAmnt21=$slAmnt21+($qt2*$rt2);
										}
										$sAmntSum2=$sAmntSum2+$slAmnt;
									}
									$q12=mysqli_query($con,"SELECT sum(rpAmnt) FROM receiptpayment WHERE rpFor ='mobile' AND rpStatus='ReceivedFrom' AND rpFromTo='$Employee' AND rpDate BETWEEN '$QueryFD' AND '$Dat' ");
									$Data12=mysqli_fetch_array($q12);
										$takenMbl= $Data12['sum(rpAmnt)'];		
									$q13=mysqli_query($con,"SELECT sum(rpAmnt) FROM receiptpayment WHERE rpFor ='SIM' AND rpStatus='ReceivedFrom' AND rpFromTo='$Employee' AND rpDate BETWEEN '$QueryFD' AND '$Dat' ");
										$Data13=mysqli_fetch_array($q13);
										$takenSIM= $Data13['sum(rpAmnt)'];		
									$MobileClose=($openMobileCash+$sAmntSum0) - $takenMbl;
									$SIMClose=($openSIMCash+$sAmntSum1) - $takenSIM;
									
									$cardclosenew=($openCard+$sAmntSum2)-$takenCardsAmunt;
					/*///////////////<<<<<<<<<<<   Mobile and SIM Sales   >>>>>>>>>>>>>>>//////////////////*/
								// Footer Sums
										$sumLoad=$sumLoad+$load;
										$sumTransfer=$sumTransfer+$transfer;
										$sumProfit=$sumProfit+($Profit+$XsProfit);
										$sumSend=$sumSend+$mfsSend;
										$sumReceive=$sumReceive+$mfsReceive;
										$sumClose=$sumClose+$mfsClose;
										$sumQty=$sumQty+$cardQty;
										$sumOrgAmnt=$sumOrgAmnt+$orgAmnt;
										$sumSaleRate=$sumSaleRate+$saleRate;
										$sumAmnt=$sumAmnt+$amount;
										$sumProLoss=$sumProLoss+$pL;
										$sumTaken=$sumTaken+$taken;
							$newDate=date("d-m-Y", $i);
										$stringToPrint=$stringToPrint.'<tr>';
												$stringToPrint=$stringToPrint.'<td>'.$newDate.'</td>';
												$stringToPrint=$stringToPrint.'<td><b>'.$load.'</b></td>';
												$stringToPrint=$stringToPrint.'<td>'.$transfer.'</td>';
												//$stringToPrint=$stringToPrint.'<!-- <td>'.round($Profit+$XsProfit,2).'</td> -->';
												$stringToPrint=$stringToPrint.'<td><b>'.$mfsSend.'</b></td>';
												$stringToPrint=$stringToPrint.'<td><b>'.$mfsReceive.'</b></td>';
												//$stringToPrint=$stringToPrint.'<!-- <td>'.$mfsClose.'</td> -->';
												//$stringToPrint=$stringToPrint.'<td>'.$cardQty.'</td>';
												//$stringToPrint=$stringToPrint.'<!-- <td>'.round($orgAmnt,2).'</td> -->';
												//$stringToPrint=$stringToPrint.'<td>'.round($saleRate,2).'</td>';
												//$stringToPrint=$stringToPrint.'<td>'.$amount.'</td>';
												//$stringToPrint=$stringToPrint.'<!-- <td>'.round($pL,2).'</td> -->';
												$stringToPrint=$stringToPrint.'<td>'.$opening.'</td>';
												$stringToPrint=$stringToPrint.'<td>'.$receivable.'</td>';
												$stringToPrint=$stringToPrint.'<td><b>'.$taken.'</b></td>';
												if($dues>0)
														$stringToPrint=$stringToPrint.'<td style=\"color: Red;\"><b>'.$dues.'</b></td>';
												else if($dues<0)
														$stringToPrint=$stringToPrint.'<td style=\"color: black;\"><b>'.$dues.'</b></td>';
												else
														$stringToPrint=$stringToPrint.'<td style=\"color: black;\"><b>'.$dues.'</b></td>';
												
												$stringToPrint=$stringToPrint.'<td style="text-align: right;">'.$cardreceivables.'</td>';
												$stringToPrint=$stringToPrint.'<td style="text-align: right;">'.$MobileClose.'</td>';
												$stringToPrint=$stringToPrint.'<td style="text-align: right;">'.$SIMClose.'</td>';
										$stringToPrint=$stringToPrint.'</tr>';
										
										$opening=$dues;
										$openingCard=$cardreceivables;
									}
									$stringLast='';
									$stringLast=$stringLast.'<tr>';
												$stringLast=$stringLast.'<td style="background: brown; color: white;">'.$newDate.'</td>';
												$stringLast=$stringLast.'<td style="background: brown; color: white;"><b>'.$load.'</b></td>';
												$stringLast=$stringLast.'<td style="background: brown; color: white;">'.$transfer.'</td>';
												//$stringLast=$stringLast.'<!-- <td>'.round($Profit+$XsProfit,2).'</td> -->';
												$stringLast=$stringLast.'<td style="background: brown; color: white;"><b>'.$mfsSend.'</b></td>';
												$stringLast=$stringLast.'<td style="background: brown; color: white;"><b>'.$mfsReceive.'</b></td>';
												//$stringLast=$stringLast.'<!-- <td>'.$mfsClose.'</td> -->';
												//$stringLast=$stringLast.'<!-- <td>'.$cardQty.'</td> -->';
												//$stringLast=$stringLast.'<!-- <td>'.round($orgAmnt,2).'</td> -->';
												//$stringLast=$stringLast.'<!-- <td>'.round($saleRate,2).'</td> -->';
												//$stringLast=$stringLast.'<!-- <td>'.$amount.'</td> -->';
												//$stringLast=$stringLast.'<!-- <td>'.round($pL,2).'</td> -->';
												$stringLast=$stringLast.'<td style="background: brown; color: white;">'.$opening.'</td>';
												$stringLast=$stringLast.'<td style="background: brown; color: white;">'.$receivable.'</td>';
												$stringLast=$stringLast.'<td style="background: brown; color: white;"><b>'.$taken.'</b></td>';
												if($dues>0)
														$stringLast=$stringLast.'<td style="background: brown; color: white;"><b>'.$dues.'</b></td>';
												else if($dues<0)
														$stringLast=$stringLast.'<td style="background: brown; color: white;"><b>'.$dues.'</b></td>';
												else
														$stringLast=$stringLast.'<td style="background: brown; color: white;"><b>'.$dues.'</b></td>';
												
												//$stringLast=$stringLast.'<td>'.$amount.'</td>';
												$stringLast=$stringLast.'<td style="background: green; color: white; text-align: right;">'.$cardreceivables.'</td>';
												$stringLast=$stringLast.'<td style="background: green; color: white; text-align: right;">'.$MobileClose.'</td>';
												$stringLast=$stringLast.'<td style="background: green; color: white; text-align: right;">'.$SIMClose.'</td>';
									$stringLast=$stringLast.'</tr>';
									$sumReceivable=$sumLoad+$sumClose+$open;
									$closing=$sumReceivable-$sumTaken;
									$avgRate=$sumSaleRate/$count;
				
				}
				
				/////////////Mobile SIM Pro/Loss Calculation///////////////
				
				function getPl($empnamehere,$pnamehere)
				{
					global $QueryFD;
					global $Dat;
					global $con;
					$forEmp=$empnamehere;
					$pName=$pnamehere;
					$AmntSum=0;
					$QtySum=0;
					$plSum=0;
					$sql = mysqli_query($con,"SELECT * FROM tbl_product_stock WHERE trtype='Sent' AND customer='$forEmp' AND pName='$pName' AND sDate BETWEEN '$QueryFD' AND '$Dat' ORDER BY sDate ASC")or die(mysqli_query());
							WHILE($Data=mysqli_fetch_array($sql))
							{
								$Type= $Data['pSubType'];
								$Qty= $Data['qty'];
								$rat= $Data['rate'];
								$Amnt= $Qty*$rat;
									
								//getting purchase rate
								$qry110 = mysqli_query($con,"SELECT purchasePrice FROM rates WHERE pName='$pName' AND spName='$Type' ORDER BY rtID DESC LIMIT 1")or die(mysqli_query());
                                $Data110=mysqli_fetch_array($qry110);
                                $PurchaseRate= $Data110['purchasePrice'];
									
								$cost=$Qty*$PurchaseRate;
								$pl=$Amnt-$cost;
									
								$AmntSum=$AmntSum + $Amnt;
								$QtySum=$QtySum+$Qty;
								
								$plSum=$plSum+$pl;
							}
							return $plSum;
				}
				
				
			?>
			
			</style>
	</head>
			<div class="container" align="center" style="border: solid black 0px;" >
							<center>
								<caption> <h2>
								<?php
								echo htmlspecialchars($Employee, ENT_QUOTES, 'UTF-8')."'s ";
								?>
								Sales Sheet</h2></caption>
							</center>
						
							<div style="border: solid black 0px;" align="center" class="doBar">
								<?php
									//$doQ=mysqli_query($con,"SELECT EmpName from empinfo WHERE EmpStatus='Active' AND (empType='DO' OR empType='SP' OR empType='ws') Order by sort_order ASC");
									$doQ=mysqli_query($con,"SELECT * from empinfo WHERE EmpStatus='Active' AND (showIn=1 OR showIn=3) Order by sort_order ASC");
									while($data=mysqli_fetch_array($doQ))
										{
											$name=$data['EmpName'];
											$lineNum=$data['doLine'];
											if($name== $Employee)
												$nm='doLinkSelected';
											else
												$nm='doLink';
											?>
											<!-- <a href="do.php?name=<?php echo $name;?>" id="<?php echo $nm;?>" class="button"> -->
											<a href="dosales.php?name=<?php echo htmlspecialchars($name, ENT_QUOTES, 'UTF-8');?>&num=<?php echo htmlspecialchars($lineNum, ENT_QUOTES, 'UTF-8');?>" id="<?php echo $nm;?>" class="button">
											<?php
											echo htmlspecialchars($data['EmpName'], ENT_QUOTES, 'UTF-8')."</a>";
										}
										
								?>
							<!--<button onclick="ShowHideMFS()">MFS</button> -->
							<button onclick="ShowHideCard()">Card</button>
							<button onclick="ShowHidePhone()">Phone</button>
							<button onclick="ShowHideSim()">SIM</button>
							</div>
					<div>
								<form name="f1" action="" method="POST">
										<table cellpadding="0" cellspacing="0" border="0" class="table" id="" >
										<tr>
											<td>
											<div>
												<table cellpadding="0" cellspacing="0" border="0" class="table" id="HeadTable" >
															<tr>
																<td colspan="3"style="text-align: center;"> <h2>Load + Payment</h2></td>
															</tr>
															<tr>
																<td style="text-align: right;"> Date:</td>
																<td style="text-align: left;">
																		<?php
																			$Coma='"';
																			$strDate= date('Y-m-d');
																			if ($currentUserType=="Admin")
																				echo "<input type=\"date\" value= \"$strDate\"  name=\"txtDate\" id=\"tBox\">";
																			else
																				echo "<input type=\"date\" value= \"$strDate\"  name=\"txtDate\" id=\"tBox\" readonly>";
																		echo $lineNumber;
																		?>
																</td>
																<td></td>
															</tr>
															<tr><td></td></tr>
															<tr>
																<td style="text-align: right" >Load Amount:
																</td>
																<td style="text-align: left;" >
																	<input type="text" name="txtLoad" id="tBox" autofocus> 
																	<input type="submit"  value="Send Load" name="AddLoad" id="Btn">
																</td>				
																<!-- <td rowspan="2" style="text-align: left;" >
																<input type="submit"  value="Save" name="Go1" id="BtnBig" accesskey="g">
																</td> -->
															</tr>
															<tr><td><br><br></td></tr>
															<tr>
																<td style="text-align: right;" >Cash Amount:  
																</td>
																<td style="text-align: left;" >
																	<input type="text" name="txtAmnTaken" id="tBoxSpecial">
																	into
																	<select name="modeSelect" id="sBoxSpecial"/>
																		<option >---</option>
																		<?php
																		$doQ=mysqli_query($con,"SELECT modeName from rpmode");
																		while($data=mysqli_fetch_array($doQ))
																		{
																			//if ( $_POST['modeSelect'] == $data['modeName'])
																			if ($data['modeName'] == $defaultBankName)
																				echo "<option selected>";
																			else
																				echo "<option>";
																			echo $data['modeName'];
																			echo "<br>";
																			echo "</option>";
																		}
																		?>
																	</select>
																	<input type="submit"  value="Receive" name="AmntReceive" id="Btn">
																</td>

																
															</tr>
												</table>
											</div>
											</td>
											<td>
												<div id="MfsDiv" style="display:none;">
													<table cellpadding="0" cellspacing="0" border="0" class="table" id="HeadTable" >
														<tr>
															<td colspan="2"style="text-align: center;"> <h2>MFS</h2></td>
														</tr>
														<tr>	
															<td style="text-align: center;"><h3>Sending</h3></td>
															<td style="text-align: center;"><h3>Receiving</h3></td>
														</tr>
														<tr>	
															<td style="text-align: right;">
																MFS Sent:  <input type="text" name="txtmfsSend" id="tBox1">
															</td>
														
															<td style="text-align: right;">
																MFS Receive:<input type="text" name="txtmfsReceive" id="tBox1">
															</td>
														</tr>
														<tr>	
															<td style="text-align: right;">
															<!--	Comments: --> <input type="text" name="txtMfsSendCmnt" id="tBox1" hidden>
															</td>
														
															<td style="text-align: right;">
															<!--	Comments: --> <input type="text" name="txtMfsRecCmnt" id="tBox1" hidden>
															</td>
														</tr>
														<tr>
														<td style="text-align: right;">
																<input type="submit"  value="Send MFS" name="Addmfs" id="Btn">
														</td>														
														<td style="text-align: right;">
																<input type="submit"  value="Get MFS" name="Recmfs" id="Btn">
														</td>
														</tr>
														<!-- <tr>
															<td colspan="2" style="text-align: center;">
															<input type="submit"  value="Save MFS" name="Go2" id="Btn" accesskey="h">
															</td>
														</tr> -->
													</table>
												</div>
												<div  id="CardDiv" style="display:none;">
														<table cellpadding="0" cellspacing="0" border="0" class="table" id="HeadTable" >
																	<tr>
																		<td colspan="3"style="text-align: center;"> <h2>Cards</h2></td>
																	</tr>
																	<tr>
																		<td style="text-align: right;">Card Type:</td>
																		<td style="text-align: left;" >
																			<select name="SubCselect" id="sBox">
																					<!-- <option >---</option> -->
																					<?php
																						$doQ=mysqli_query($con,"SELECT typeName from types WHERE productName='Card' AND isActive=1  ");
																						while($data=mysqli_fetch_array($doQ))
																							{
																								echo "<option>";
																								echo $data['typeName'];
																								echo "</option>";
																							}
																					?>
																			</select>	
																		</td>
																		<td rowspan="5" style="text-align: left;" >
																			<input type="submit"  value="Send Card" name="AddCQty" id="BtnBig">
																		</td>
																	</tr>
																	<tr>
																		<td style="text-align: right;" >Sale Quantity:</td>
																		<td style="text-align: left;" >
																		<input type="text" name="txtCQty" id="tBoxSpecial"> 
																		Rate<input type="text" name="txtCSaleRate" id="tBoxSpecial"> 
																		</td>
																	</tr>
																<!--	<tr>
																		<td style="text-align: right;" >Card Comments:</td>
																		<td style="text-align: left;">
																-->
																			<input type="text" name="txtCardCmnt" id="tBox" hidden> 
																<!--	</td>
																	</tr>
																 -->
																	<tr>
																		<td style="text-align: Right;" >Amount Received:</td>
																		<td>
																			<input type="text" name="txtCardAmntRec" id="tBoxSpecial">into
																				<select name="modeSelect1" id="sBoxSpecial">
																					<option >---</option>
																					<?php
																					$doQ=mysqli_query($con,"SELECT modeName from rpmode");
																					while($data=mysqli_fetch_array($doQ))
																					{
																						//if ( $_POST['modeSelect'] == $data['modeName'])
																						if ($data['modeName'] == $defaultBankName)
																							echo "<option selected>";
																						else
																							echo "<option>";
																						echo $data['modeName'];
																						echo "</option>";
																					}
																					?>
																				</select>
																		</td>
																		<!-- <td rowspan="2" style="text-align: left;" >
																			<input type="submit"  value="Receive" name="RecCardAmnt" id="Btn">
																		</td> -->
																	</tr>
															<!-- 	<tr>
																		<td style="text-align: right;" >Amount Comments:</td>
																		<td style="text-align: left;">
															-->
																			<input type="text" name="txtCardAmntCmnt" id="tBox" hidden> 
															<!-- 	</td>
																	
																	</tr>
															-->
														</table>
											
												</div>
											
												<div  id="PhoneDiv" style="display:none;">
																<table cellpadding="0" cellspacing="0" border="0" class="table" id="HeadTable" >
																	<tr>
																		<td colspan="3"style="text-align: center;"> <h2>Phone & Devices</h2></td>
																	</tr>
																	<tr>
																		<td style="text-align: right;">Phone/Device Type:</td>
																		<td style="text-align: left;">
																			<select name="SubPselect" id="sBox">
																				<option >---</option>
																				<?php
																					$doQ=mysqli_query($con,"SELECT typeName from types WHERE productName='Mobile' AND isActive=1 ");
																					while($data=mysqli_fetch_array($doQ))
																						{
																							echo "<option>";
																							echo $data['typeName'];
																							echo "</option>";
																						}
																				?>
																			</select>
																		</td>
																		<td rowspan="5" style="text-align: left;" >
																			<input type="submit"  value="Send Phone" name="AddPQty" id="BtnBig">
																		</td>
																	</tr>
																	<tr>
																		<td style="text-align: right;" >Sale Quantity:</td>
																		<td style="text-align: left;" >
																		<input type="text" name="txtPQty" id="tBoxSpecial">
																		Rate <input type="text" name="txtPSaleRate" id="tBoxSpecial"> 
																		</td>
																	</tr>
															<!--	<tr>
																		<td style="text-align: right;" >Phone/Device Comments:</td>
																		<td style="text-align: left;">
															-->
																			<input type="text" name="txtPCmnt" id="tBox" hidden> 
															<!--    	</td>
																	
																	</tr>
															-->
																	<tr>
																		<td style="text-align: Right;" >Amount Received:</td>
																		<td>
																			<input type="text" name="txtMobAmntRec" id="tBoxSpecial">into
																				<select name="modeSelect2" id="sBoxSpecial">
																					<option >---</option>
																					<?php
																					$doQ=mysqli_query($con,"SELECT modeName from rpmode");
																					while($data=mysqli_fetch_array($doQ))
																					{
																						//if ( $_POST['modeSelect'] == $data['modeName'])
																						if ($data['modeName'] == $defaultBankName)
																							echo "<option selected>";
																						else
																							echo "<option>";
																						echo $data['modeName'];
																						echo "</option>";
																					}
																					?>
																				</select>
																		</td>
																		<!-- <td rowspan="2" style="text-align: left;" >
																			<input type="submit"  value="Receive" name="RecMobAmnt" id="Btn">
																		</td> -->
																	</tr>
															<!-- 	<tr>
																		<td style="text-align: right;" >Amount Comments:</td>
																		<td style="text-align: left;">
															-->
																			<input type="text" name="txtPhoneAmntCmnt" id="tBox" hidden> 
															<!-- 		</td>
																	</tr>
															-->
														</table>
												</div>
												
												<div  id="SimDiv" style="display: block;">
														<table cellpadding="0" cellspacing="0" border="0" class="table" id="HeadTable" >
																	<tr>
																		<td colspan="3"style="text-align: center;"> <h2>SIMs</h2></td>
																	</tr>
																	<tr>
																		<td style="text-align: right;">SIM Type:</td>
																		<td style="text-align: left;" >
																			<select name="SubSselect" id="sBox">
																				<option >---</option>
																					<?php
																					$doQ=mysqli_query($con,"SELECT typeName from types WHERE productName='SIM' AND isActive=1 ");
																					while($data=mysqli_fetch_array($doQ))
																					{
																						echo "<option>";
																						echo $data['typeName'];
																						echo "</option>";
																					}
																					?>
																			</select>
																		</td>
																		<td rowspan="5" style="text-align: left;" >
																			<input type="submit"  value="Send SIM" name="AddSQty" id="BtnBig">
																		</td>
																	</tr>
																	<tr>
																		<td style="text-align: right;" >Sale Quantity:</td>
																		<td style="text-align: left;" >
																		<input type="text" name="txtSQty" id="tBoxSpecial">
																		Rate<input type="text" name="txtSSaleRate" id="tBoxSpecial">
																		</td>
																	</tr>
															<!-- 	<tr>
																		<td style="text-align: right;" >SIM Comments:</td>
																		<td style="text-align: left;">
															-->
																			<input type="text" name="txtSCmnt" id="tBox" hidden> 
															<!-- 		</td>
																	
																	</tr>
															-->
																	
																	<tr>
																		<td style="text-align: Right;" >Amount Received:</td>
																		<td>
																			<input type="text" name="txtSIMAmntRec" id="tBoxSpecial">into
																				<select name="modeSelect3" id="sBoxSpecial">
																					<option >---</option>
																					<?php
																					$doQ=mysqli_query($con,"SELECT modeName from rpmode");
																					while($data=mysqli_fetch_array($doQ))
																					{
																						//if ( $_POST['modeSelect'] == $data['modeName'])
																						if ($data['modeName'] == $defaultBankName)
																							echo "<option selected>";
																						else
																							echo "<option>";
																						echo $data['modeName'];
																						echo "</option>";
																					}
																					?>
																				</select>
																		</td>
																		<!-- <td rowspan="2" style="text-align: left;" >
																			<input type="submit"  value="Receive" name="RecSIMAmnt" id="Btn">
																		</td> -->
														<!-- 			</tr>
																	<tr>
																		<td style="text-align: right;" >Amount Comments:</td>
																		<td style="text-align: left;">
														-->
																			<input type="text" name="txtSimAmntCmnt" id="tBox" hidden>
														<!-- 				</td>
																	
																	</tr>
														-->
														</table>
												</div>
											</td>
											<?php if ($currentUserType=="Admin")
											{
												?>
											<td bgcolor="">
											<div>
												<table cellpadding="0" cellspacing="0" border="0" class="table" id="HeadTable" >
													<tr>
														<td colspan="2" style="text-align: center;"><h2>Profitability</h2></td>
													</tr>
													<tr>
														<td style="text-align: right;">Load:</td>
														<td style="text-align: left;"><?php echo round($sumProfit,2);?></td>														
													</tr>
													<tr>
														<td style="text-align: right;">Card:</td>
														<td style="text-align: left;"><?php echo round($sumProLoss,2);?></td>														
													</tr>
													<tr>
														<td style="text-align: right;">Devices:</td>
														<td style="text-align: left;"><?php $proMob=getPl($Employee,'Mobile'); echo round($proMob,2);?></td>												
													</tr>
													<tr>
														<td style="text-align: right;">SIMs:</td>
														<td style="text-align: left;"><?php $proSim=getPl($Employee,'SIM'); echo round($proSim,2);?></td>												
													</tr>
													<tr>
														<td colspan="2" style="text-align: center;">
														==========
														<br>
														<strong>Net:<?php echo round($sumProfit,2) + round($sumProLoss,2) + round($proMob,2) + round($proSim,2);?></strong></td>												
													</tr>
												</table>
											</div>
											</td>
											<?php
											}
												?>
											</tr>
										</table>
								</form>
					</div>
					<div id="center" class="SubDiv0" style=" border: 0px solid Blue;">
						<table cellpadding="0" cellspacing="0" border="1" class="" id="dbResult">
							<thead>
								<tr>
									<th rowspan="2">Date</th>
									<th colspan="2">Load</th>
									<th colspan="2">MFS</th>
									<th rowspan="2">Opening</th>
									<th rowspan="2">Receivable</th>
									<th rowspan="2">Taken</th>
									<th rowspan="2">LMC Dues</th>
									<th rowspan="2">Cards</th>
									<th rowspan="2">Devices</th>
									<th rowspan="2">SIMs</th>

								</tr>
								<tr>
									<th>Load</th>
									<th>Transfer</th>
									<th>Send</th>
									<th>Receive</th>
								</tr>
							</thead>
				
							<tbody>
							
									<?php
									echo $stringLast;
									echo $stringToPrint;
									?>
							</tbody>
								<tfoot >
									<tr style="border: solid black 2px;"  >
											<td> <b> TOTAL: </b></td>
											<td> <b><?php echo $sumLoad; ?></b></td>
											<td> <b><?php echo $sumTransfer; ?></b></td>
											<!-- <td> <b><?php echo round($sumProfit,2); ?></b></td> -->
											<td> <b><?php echo $sumSend; ?></b></td>
											<td> <b><?php echo $sumReceive; ?></b></td>
											<!-- <td> <b><?php echo $sumClose; ?></b></td> -->
											<!-- <td> <b><?php echo $sumQty; ?></b></td> -->
											<!-- <td> <b><?php echo round($sumOrgAmnt,2); ?></b></td> -->
											<!--  <td> <b><?php //echo $avgRate; ?></b></td> -->
											<!-- <td> <b><?php echo $sumAmnt; ?></b></td> -->
											<!-- <td> <b><?php echo round($sumProLoss,2); ?></b></td> -->
											<td> <b><?php echo $open; ?></b></td>
											<td> <b><?php echo $sumReceivable; ?></b></td>
											<td> <b><?php echo $sumTaken; ?></b></td>
											<td> <b><?php echo $closing; ?></b></td>
											<td style="text-align:center; background: green; color: white; text-align: right;"> <b><?php echo $cardreceivables; ?></b></td>
											<td style="text-align:center; background: green; color: white; text-align: right;"> <b><?php echo $MobileClose; ?></b></td>
											<td style="text-align:center; background: green; color: white; text-align: right;"> <b><?php echo $SIMClose; ?></b></td>
										
									</tr>
									
								</tfoot>
						</table>
						
					</div>
					<br>
			</div>
	<script>
	function ShowHideMFS() {
		var x01 = document.getElementById('CardDiv');
		var x02 = document.getElementById('PhoneDiv');
		var x03 = document.getElementById('SimDiv');
		var x04 = document.getElementById('MfsDiv');
		if (x04.style.display === 'none') {
			x01.style.display = 'none';
			x02.style.display = 'none';
			x03.style.display = 'none';
			x04.style.display = 'block';
		}
	}
	function ShowHideCard() {
		var x1 = document.getElementById('CardDiv');
		var x2 = document.getElementById('PhoneDiv');
		var x3 = document.getElementById('SimDiv');
		var x4 = document.getElementById('MfsDiv');
		if (x1.style.display === 'none') {
			x1.style.display = 'block';
			x2.style.display = 'none';
			x3.style.display = 'none';
			x4.style.display = 'none';
		}
	}
	function ShowHidePhone() {
		var x10 = document.getElementById('CardDiv');
		var x11 = document.getElementById('PhoneDiv');
		var x12 = document.getElementById('SimDiv');
		var x13 = document.getElementById('MfsDiv');
		if (x11.style.display === 'none') {
			x10.style.display = 'none';
			x11.style.display = 'block';
			x12.style.display = 'none';
			x13.style.display = 'none';			
		}
	}
	function ShowHideSim() {
		var x20 = document.getElementById('CardDiv');
		var x21 = document.getElementById('PhoneDiv');
		var x22 = document.getElementById('SimDiv');
		var x23 = document.getElementById('MfsDiv');
		if (x22.style.display === 'none') {
			x20.style.display = 'none';
			x21.style.display = 'none';
			x22.style.display = 'block';
			x23.style.display = 'none';
		}
	}
	
	
	
	/*
	function ShowHideSim() {
		var x20 = document.getElementById('CardDiv');
		var x21 = document.getElementById('PhoneDiv');
		var x22 = document.getElementById('SimDiv');
		if (x22.style.display === 'block') {
			x22.style.display = 'none';
		} else {
			x20.style.display = 'none';
			x21.style.display = 'none';
			x22.style.display = 'block';
		}
	}*/
</script>
</html>