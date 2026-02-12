<?php
include_once('../session.php');
$Employee = $_GET['name'];
include_once('includes/variables.php');
include_once('includes/wsformula.php');
include_once('includes/globalvar.php');
?>

<!doCTYPE html>
<html>
	<head>
		<title>WorkSheet</title>
			<style>
			<?php
				include_once('styles/navbarstyle.php');
				include_once('styles/tablestyle.php');
				include_once('includes/navbar.php');
			?>
			</style>
	</head>



<div class="container" align="center" style="border: solid black 0px;" >
			    <center>
					<caption> <h2>
					<?php
					echo $Employee."'s ";
					?>
					Work Sheet</h2></caption>
				</center>
			
				<div style="border: solid black 0px;" align="center" class="doBar">
					<?php
						$doQ=mysqli_query($con,"SELECT EmpName from empinfo WHERE empType='ws' ORDER BY EmpName ASC");
						while($data=mysqli_fetch_array($doQ))
							{
								$name=$data['EmpName'];
								if($name== $Employee)
									$nm='doLinkSelected';
								else
									$nm='doLink';
								?>
								<a href="ws.php?name=<?php echo $name;?>" id="<?php echo $nm;?>" class="button">
								<?php
								echo $data['EmpName']."</a>";
							}
					?>
				</div>
		<div>
							<form name="f1" action="" method="POST">
					
					
					<!--
					
					<table cellpadding="0" cellspacing="0" border="0" class="table" id="HeadTable" >
												<tr>
													<td style="text-align: right;"> Date:</td>
													<td style="text-align: left;">
															<?php
																$Coma='"';
																$strDate= date('Y-m-d');												
																$strHTML ='<input type=' . $Coma .'date' . $Coma . ' ' . 'value=' . $Coma . $strDate . $Coma . ' name=' . $Coma . 'txtDate" id="tBox"'. $Coma . '>' ;
																echo $strHTML;
															?>
													</td>
													<td style="text-align: right;" >mfs Receive:  
													</td>
													<td style="text-align: left;" >
														<input type="text" name="txtmfsReceive" id="tBox"> 
													
														<input type="submit"  value="Get mfs" name="Recmfs" id="Btn">
													</td>
												</tr>
												<tr>
													<td style="text-align: right" >Load Amount:
													</td>
													<td style="text-align: left;" >
														<input type="text" name="txtLoad" id="tBox"> 
														<input type="submit"  value="Send Load" name="AddLoad" id="Btn">
													</td>
													<td style="text-align: right;" >Taken Amount:  
													</td>
													<td style="text-align: left;" >
														<input type="text" name="txtAmnTaken" id="tBox">
													</td>
													
												</tr>
												<tr>
													<td style="text-align: right;" >mfs Amount: 
													</td>
													<td style="text-align: left;" >
														<input type="text" name="txtmfsSend" id="tBox"> 
														<input type="submit"  value="Send mfs" name="Addmfs" id="Btn">
													</td>
													<td style="text-align: right;"> Receive Mode:  </td>
													<td style="text-align: left;" >
														<select name="modeSelect" id="sBox"/>
															<option >---</option>
															<?php
															$doQ=mysqli_query($con,"SELECT modeName from rpmode");
															while($data=mysqli_fetch_array($doQ))
															{
																if ( $_POST['modeSelect'] == $data['modeName'])
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
					-->
									
									<table cellpadding="0" cellspacing="0" border="0" class="table" id="HeadTable" >
												<tr>
													<td></td><td></td>
													<td style="text-align: right;"> Date:</td>
													<td style="text-align: left;">
															<?php
																$Coma='"';
																$strDate= date('Y-m-d');												
																$strHTML ='<input type=' . $Coma .'date' . $Coma . ' ' . 'value=' . $Coma . $strDate . $Coma . ' name=' . $Coma . 'txtDate" id="tBox"'. $Coma . '>' ;
																echo $strHTML;
															?>
													</td>
													<td></td><td></td>
												</tr>
												<tr>
													<td colspan="2"style="text-align: center;"> <h2>Card Section</h2></td>
													<td colspan="2"style="text-align: center;"> <h2>Phone Section</h2></td>
													<td colspan="2"style="text-align: center;"> <h2>SIM Section</h2></td>
												</tr>
												
												<tr>
													<td style="text-align: right;"> Card Type: </td>
													<td style="text-align: left;" >
															<select name="SubCselect" id="sBox">
																	<option >---</option>
																	<?php
																		$doQ=mysqli_query($con,"SELECT typeName from types WHERE productName='Card' ");
																		while($data=mysqli_fetch_array($doQ))
																			{
																				echo "<option>";
																				echo $data['typeName'];
																				echo "</option>";
																			}
																	?>
															</select>	
													</td>
													
													<td style="text-align: right;"> Phone Type: </td>
													<td style="text-align: left;" >
															<select name="SubPselect" id="sBox">
																	<option >---</option>
																	<?php
																		$doQ=mysqli_query($con,"SELECT typeName from types WHERE productName='Mobile' ");
																		while($data=mysqli_fetch_array($doQ))
																			{
																				echo "<option>";
																				echo $data['typeName'];
																				echo "</option>";
																			}
																	?>
															</select>	
													</td>
													
													<td style="text-align: right;"> SIM Type: </td>
													<td style="text-align: left;" >
															<select name="SubSselect" id="sBox">
																	<option >---</option>
																	<?php
																		$doQ=mysqli_query($con,"SELECT typeName from types WHERE productName='SIM' ");
																		while($data=mysqli_fetch_array($doQ))
																			{
																				echo "<option>";
																				echo $data['typeName'];
																				echo "</option>";
																			}
																	?>
															</select>	
													</td>
													
												</tr>
												<tr>
													<td style="text-align: right;" >Card Quantity: 
													</td>
													
													<td style="text-align: left;" >
														 <input type="text" name="txtCQty" id="tBox"> 
													</td>
													<td style="text-align: right;" >Phone Quantity: 
													</td>
													
													<td style="text-align: left;" >
														 <input type="text" name="txtPQty" id="tBox"> 
													</td>
													
													</td>
													<td style="text-align: right;" >SIM Quantity: 
													</td>
													
													<td style="text-align: left;" >
														 <input type="text" name="txtSQty" id="tBox"> 
													</td>
													
												</tr>
												<tr>
													<td style="text-align: right;" >Card Sale Rate: 
													</td>
													
													<td style="text-align: left;" >
														 <input type="text" name="txtCSaleRate" id="tBox"> 
													</td>
													<td style="text-align: right;" >Phone Sale Rate: 
													</td>
													
													<td style="text-align: left;" >
														 <input type="text" name="txtPSaleRate" id="tBox"> 
													</td>
													
													<td style="text-align: right;" >SIM Sale Rate: 
													</td>
													
													<td style="text-align: left;" >
														 <input type="text" name="txtSSaleRate" id="tBox"> 
													</td>
												
												</tr>
												<tr>
													<td style="text-align: right;" >Card Comments: 
													</td>
													
													<td style="text-align: left;" >
														 <input type="text" name="txtCardCmnt" id="tBox"> 
													</td>
													<td style="text-align: right;" >Phone Comments: 
													</td>
													<td style="text-align: left;" >
														 <input type="text" name="txtPCmnt" id="tBox"> 
													</td>
													
													<td style="text-align: right;" >SIM Comments: 
													</td>
													<td style="text-align: left;" >
														 <input type="text" name="txtSCmnt" id="tBox"> 
													</td>
													
												</tr>
												<tr>
													<td colspan="2" style="text-align: center;" >
														<input type="submit"  value="Send Card" name="AddCQty" id="Btn">
													</td>
													<td colspan="2" style="text-align: center;" >
														<input type="submit"  value="Send Phone" name="AddPQty" id="Btn">
													</td>
													
													<td colspan="2" style="text-align: center;" >
														<input type="submit"  value="Send SIM" name="AddSQty" id="Btn">
													</td>
													
												</tr>
												
									</table>
							</form>
		</div>
		
		<div class="SubDiv" align="center" style="border: solid black 0px;" >
				<div class="right" style="border: solid blue 0px;">
						<table cellpadding="0" cellspacing="0" border="1" class="" id="dbResult">
								<thead>
									<tr>
										<th>Customer</th>
										<th>SIM Type</th>
										<th>Qty</th>
										<th>Action</th>
									</tr>
								</thead>
								<tbody>
								
								<?php
								$sm=0;
								$q1=mysqli_query($con,"SELECT * FROM tbl_product_stock WHERE trtype='Sent' AND pName='SIM' AND customer='$Employee' AND sDate ='$dateNow' ");
									while($Data1=mysqli_fetch_array($q1))
									{
										$Eid=$Data1['sID'];
										$Ename=$Data1['customer'];
								?>		<tr>
											<td><?php echo $Data1['customer']; ?></td>
											<td><?php echo $Data1['pSubType']; ?></td>
											<td><?php echo $Data1['qty']; ?></td>
											<td><a href="delete/delmobws.php?ID=<?php echo $Eid;?>&name=<?php echo $Ename;?>" id="LinkBtnDel">Delete</a></td>
										</tr>
								<?php
								$sm=$sm+$Data1['qty'];
									}
								?>
								
								
								</tbody>
								<tfoot >
										<tr style="border: solid black 1px;"  >
										<td colspan="2" > <b> TOTAL QUANTITY: </b></td>
										<td colspan="2" > <b><?php echo $sm; ?></b></td>
										</tr>
								</tfoot>
											
						</table>
				</div>
				
				
				
				
				<div class="left" style="border: solid black 0px;">
						<table cellpadding="0" cellspacing="0" border="1" class="" id="dbResult">
								<thead>
									<tr>
										<th>Customer</th>
										<th>Card Type</th>
										<th>Qty</th>
										<th>Action</th>
									</tr>
								</thead>
								<tbody>
								
								<?php
								$sm=0;
								$q1=mysqli_query($con,"SELECT * FROM tbl_cards WHERE csStatus='Sent' AND csEmp='$Employee' AND csDate ='$dateNow' ");
									while($Data1=mysqli_fetch_array($q1))
									{
										$id=$Data1['csID'];
										$Ename=$Data1['csEmp'];
								?>		<tr>
											<td><?php echo $Data1['csEmp']; ?></td>
											<td><?php echo $Data1['csType']; ?></td>
											<td><?php echo $Data1['csQty']; ?></td>
											<td><a href="delete/delcardws.php?ID=<?php echo $id; ?>&name=<?php echo $Ename;?>" id="LinkBtnDel">Delete</a></td>
										</tr>
								<?php
								$sm=$sm+$Data1['csQty'];
									}
								?>
								
								
								</tbody>
								<tfoot >
										<tr style="border: solid black 1px;"  >
										<td colspan="2" > <b> TOTAL QUANTITY: </b></td>
										<td colspan="2" > <b><?php echo $sm; ?></b></td>
										</tr>
								</tfoot>
											
						</table>
				</div >
				<div class="center" style="border: solid Green 0px;">
						<table cellpadding="0" cellspacing="0" border="1" class="" id="dbResult">
								<thead>
									<tr>
										<th>Customer</th>
										<th>Phone Type</th>
										<th>Qty</th>
										<th>Action</th>
									</tr>
								</thead>
								<tbody>
								
								<?php
								$sm=0;
								$q1=mysqli_query($con,"SELECT * FROM tbl_product_stock WHERE trtype='Sent' AND pName='Mobile' AND customer='$Employee' AND sDate ='$dateNow' ");
									while($Data1=mysqli_fetch_array($q1))
									{
										$id=$Data1['sID'];
										$Ename=$Data1['customer'];
								?>		<tr>
											<td><?php echo $Data1['customer']; ?></td>
											<td><?php echo $Data1['pSubType']; ?></td>
											<td><?php echo $Data1['qty']; ?></td>
											<td><a href="delete/delmobws.php?ID=<?php echo $id; ?>&name=<?php echo $Ename;?>" id="LinkBtnDel">Delete</a></td>
										</tr>
								<?php
								$sm=$sm+$Data1['qty'];
									}
								?>
								
								
								</tbody>
								<tfoot >
										<tr style="border: solid black 1px;"  >
										<td colspan="2" > <b> TOTAL QUANTITY: </b></td>
										<td colspan="2" > <b><?php echo $sm; ?></b></td>
										</tr>
								</tfoot>
											
						</table>
				</div >
		</div>
	
	<!--
	
		<div >
		
		
			<table cellpadding="0" cellspacing="0" border="1" class="" id="dbResult">
				<thead>
					<tr>
						<th rowspan="2">Date</th>
						<th colspan="3">Load</th>
						<th colspan="3">mfs</th>
						<th colspan="5">Cards</th>
						<th rowspan="2">Opening</th>
						<th rowspan="2">Receivable</th>
						<th rowspan="2">Taken</th>
						<th rowspan="2">Dues</th>
					</tr>
					<tr>
						<th>Load</th>
						<th>Transfer</th>
						<th>Profit</th>
						<th>Send</th>
						<th>Receive</th>
						<th>Close</th>
						<th>Quantity</th>
						<th>Org Amnt</th>
						<th>Sale Rate</th>
						<th>Amount</th>
						<th>Pro/Loss</th>
						</tr>
				</thead>
				<tbody>
					<?php 

					$EmpOpening=mysqli_query($con,"SELECT ocAmnt From openingclosing WHERE ocEmp='$Employee' AND oMonth='$CurrentMonth' AND ocType='Cash'  ");
					$Data=mysqli_fetch_array($EmpOpening);
					$opening = $Data['ocAmnt'];
					$open=$opening;
					
					
			// Footer Sums
					$count=0; $sumLoad=0;	$sumTransfer=0;	$sumProfit=0; $sumSend=0; $sumReceive=0; $sumClose=0; $sumQty=0; $sumOrgAmnt=0; $sumSaleRate=0; $sumAmnt=0; $sumProLoss=0;
					$sumReceivable=0; $sumTaken=0;
				
					for($i=$date_from; $i<=$date_to; $i+=86400)
						{
						$count=$count+1;
							$Dat=date("Y-m-d", $i);
									$q1=mysqli_query($con,"SELECT sum(loadAmnt),sum(loadTransfer), sum(loadProfit), sum(loadExcessProfit) FROM tbl_mobile_load WHERE loadStatus='Sent' AND loadEmp='$Employee' AND loadDate ='$Dat' ");
									$Data1=mysqli_fetch_array($q1);
							$load= $Data1['sum(loadAmnt)'];
						
							$transfer= $Data1['sum(loadTransfer)'];
							$Profit= $Data1['sum(loadProfit)'];
							$XsProfit=$Data1['sum(loadExcessProfit)'];
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
							$amount= $Data4['sum(csTotalAmnt)'];
							$pL= $Data4['sum(csProLoss)'];
							$receivable= $load+$mfsClose+$amount+$opening;		
									$q5=mysqli_query($con,"SELECT sum(rpAmnt) FROM receiptpayment WHERE rpStatus='ReceivedFrom' AND rpFromTo='$Employee' AND rpDate ='$Dat' ");
									$Data5=mysqli_fetch_array($q5);
							$taken= $Data5['sum(rpAmnt)'];
							$dues= $receivable-$taken;
					
					
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
							
							
								?>
								
								<tr>
									<td><?php echo date("d-m-Y", $i); ?></td>
									<td><?php echo $load; ?></td>
									<td><?php echo $transfer; ?></td>
									<td><?php echo round($Profit+$XsProfit,2); ?></td>
									<td><?php echo $mfsSend; ?></td>
									<td><?php echo $mfsReceive; ?></td>
									<td><?php echo $mfsClose; ?></td>
									<td><?php echo $cardQty; ?></td>
									<td><?php echo $orgAmnt; ?></td>
									<td><?php echo round($saleRate,2); ?></td>
									<td><?php echo $amount; ?></td>
									<td><?php echo $pL; ?></td>
									<td><?php echo $opening; ?></td>
									<td><?php echo $receivable; ?></td>
									<td><?php echo $taken; ?></td>
									<td><?php echo $dues; ?></td>
								</tr>
							<?php
							$opening=$dues;
						}
						$sumReceivable=$sumLoad+$sumClose+$sumAmnt+$open;
						$closing=$sumReceivable-$sumTaken;
						$avgRate=$sumSaleRate/$count;
		?>
				
				</tbody>
					<tfoot >
						<tr style="border: solid black 2px;"  >
								<td> <b> TOTAL: </b></td>
								<td> <b><?php echo $sumLoad; ?></b></td>
								<td> <b><?php echo $sumTransfer; ?></b></td>
								<td> <b><?php echo round($sumProfit,2); ?></b></td>
								<td> <b><?php echo $sumSend; ?></b></td>
								<td> <b><?php echo $sumReceive; ?></b></td>
								<td> <b><?php echo $sumClose; ?></b></td>
								<td> <b><?php echo $sumQty; ?></b></td>
								<td> <b><?php echo $sumOrgAmnt; ?></b></td>
								<td> <b><?php //echo $avgRate; ?></b></td>
								<td> <b><?php echo $sumAmnt; ?></b></td>
								<td> <b><?php echo $sumProLoss; ?></b></td>
								<td> <b><?php echo $open; ?></b></td>
								<td> <b><?php echo $sumReceivable; ?></b></td>
								<td> <b><?php echo $sumTaken; ?></b></td>
								<td> <b><?php echo $closing; ?></b></td>
							
						</tr>
					</tfoot>
			</table>
			
		</div>
		<br>
		<!--
		<div style="border: solid black 0px; " >
			<table cellpadding="0" cellspacing="0" border="1" class="" id="dbResult">
					<thead>
						<tr style="text-align: center;" >
							<th rowspan="">Type</th><th colspan="">target</th><th colspan="">Achieved</th><th colspan="">Remain</th><th rowspan="">% Complete</th><th rowspan="">% Remain</th><th rowspan="">Per Day Avg</th><th rowspan="">Profitability</th>
						</tr>
						<tr>
							
					</thead>
					<tbody>
		
					<?php
					///	Otar Portion
							$q=mysqli_query($con,"SELECT tgtAmnt FROM target WHERE tgtType='Otar' AND tgtEmp='$Employee' AND tgtMonth='$CurrentMonth' ");
									$Data=mysqli_fetch_array($q);
							$q=mysqli_query($con,"SELECT sum(loadTransfer) FROM tbl_mobile_load WHERE loadStatus='Sent' AND loadEmp='$Employee' AND (loadDate BETWEEN '$QueryFD' AND '$QueryLD') ");
									$Data1=mysqli_fetch_array($q);
							$q=mysqli_query($con,"SELECT sum(loadProfit), sum(loadExcessProfit) FROM tbl_mobile_load WHERE loadStatus='Sent' AND loadEmp='$Employee' AND (loadDate BETWEEN '$QueryFD' AND '$QueryLD') ");
									$Data2=mysqli_fetch_array($q);
							
					/// mfs Portion
							$q=mysqli_query($con,"SELECT tgtAmnt FROM target WHERE tgtType='mfs' AND tgtEmp='$Employee' AND tgtMonth='$CurrentMonth' ");
									$Data3=mysqli_fetch_array($q);
							$q=mysqli_query($con,"SELECT sum(mfsAmnt) FROM tbl_financial_service WHERE mfsStatus='Sent' AND mfsEmp='$Employee' AND (mfsDate BETWEEN '$QueryFD' AND '$QueryLD') ");
									$Data4=mysqli_fetch_array($q);
							$q=mysqli_query($con,"SELECT sum(mfsAmnt) FROM tbl_financial_service WHERE mfsStatus='Received' AND mfsEmp='$Employee' AND (mfsDate BETWEEN '$QueryFD' AND '$QueryLD') ");
									$Data5=mysqli_fetch_array($q);
							$mfsClosing=$Data4['sum(mfsAmnt)']-$Data5['sum(mfsAmnt)'];
					
					/// Card Portion  
							$q=mysqli_query($con,"SELECT tgtAmnt FROM target WHERE tgtType='Card' AND tgtEmp='$Employee' AND tgtMonth='$CurrentMonth' ");
									$Data6=mysqli_fetch_array($q);
					
					
					
					?>
			
			
						<tr><td>Load</td>	<td> <?php echo $Data['tgtAmnt'];?> </td>
											<td> <?php echo $Data1['sum(loadTransfer)'];?> </td>
											<td> <?php echo $Data['tgtAmnt']-$Data1['sum(loadTransfer)'];?> </td>
											<td> <?php echo round( (($Data1['sum(loadTransfer)']/$Data['tgtAmnt'])*100),2). " %" ;?> </td>
											<td> <?php echo round( ((($Data['tgtAmnt']-$Data1['sum(loadTransfer)'])/$Data['tgtAmnt'])*100),2). " %" ;?> </td>
											<td> <?php echo round(($Data['tgtAmnt']-$Data1['sum(loadTransfer)'])/$RemainingDays);?> </td>
											<td> <?php echo round(($Data2['sum(loadProfit)']+$Data2['sum(loadExcessProfit)']),2);?> </td>
						</tr>
						<tr><td>mfs</td>	<td> <?php echo $Data3['tgtAmnt'];?> </td>
											<td> <?php echo $mfsClosing;?> </td>
											<td> <?php echo $Data3['tgtAmnt']-$mfsClosing;?> </td>
											<td> <?php echo round( (($mfsClosing/$Data3['tgtAmnt'])*100),2). " %" ;?> </td>
											<td> <?php echo round( ((($Data3['tgtAmnt']-$mfsClosing)/$Data3['tgtAmnt'])*100),2). " %" ;?> </td>
											<td> <?php echo round(($Data3['tgtAmnt']-$mfsClosing)/$RemainingDays);?> </td>
											<td> </td>
						</tr>
						
						 
						<tr><td>Card</td>	<td> <?php echo $Data6['tgtAmnt'];?> </td>
											<td> <?php echo $mfsClosing;?> </td>
											<td> <?php echo $Data3['tgtAmnt']-$mfsClosing;?> </td>
											<td> <?php echo round( (($mfsClosing/$Data3['tgtAmnt'])*100),2). " %" ;?> </td>
											<td> <?php echo round( ((($Data3['tgtAmnt']-$mfsClosing)/$Data3['tgtAmnt'])*100),2). " %" ;?> </td>
											<td> <?php echo round(($Data3['tgtAmnt']-$mfsClosing)/$RemainingDays);?> </td>
											<td> </td>
						</tr>
						<tr><td>SIM</td>	</tr>
						<tr><td>Phone</td>	</tr>
						
					</tbody>
			</table>
		</div> 
	</div>
	
	-->
</html>