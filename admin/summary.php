<?php
include_once('../session.php');
//echo "<br><br><br>";
include_once('includes/variables.php');
include_once('includes/creditcalculation.php');
include_once('includes/stockcalculation.php');
include_once('includes/getsummary.php');
include_once('includes/globalvar.php');

$closing=0;
?>



			<head>
				<title>Summary</title>
					<style>
						<?php
						include_once('styles/navbarstyle.php');
						include_once('styles/tablestyle.php');
						include_once('includes/navbar.php');
						//<script	src="styles/tablefixedheader.js">
						?>
					</style>
					<script type="text/javascript">
					        document.getElementById('scrollBottom').scrollTop = 9999999;
					
					        //var scrollDiv = document.getElementById("scrollBottom");
                            //scrollDiv.scrollTop = scrollDiv.scrollHeight;
					
					            //var objDiv = document.getElementById("center1");
                                //objDiv.scrollTop = objDiv.scrollHeight;
					
					
					
						/* var tableOffset = $("#header-fixed").offset().top;
						var $header = $("#header-fixed > thead").clone();
						var $fixedHeader = $("#header-fixed").append($header);

						$(window).bind("scroll", function() {
							var offset = $(this).scrollTop();

							if (offset >= tableOffset && $fixedHeader.is(":hidden")) {
								$fixedHeader.show();
							}
							else if (offset < tableOffset) {
								$fixedHeader.hide();
							}
						});
						*/
					</script>
			</head>
<?php
if($currentUserType=='Admin')
{
?>	
	<div class="container" id="cntnr" style="border: solid blue 0px">	
		<div id="center" class="SubDiv1" style=" border: 0px solid Red;">	
			<table cellpadding="0" cellspacing="0" border="0" align="center" id="tb102">
				<tr>
					<td> 
						<table cellpadding="0" cellspacing="0" border="1" id="example">
							<tr style="background-color: #ADBEE0;">
								<th colspan="6" >
									<center>
										<h4> Target Summary</h4>
									</center>
								</th>
							</tr>
							<tr>
								<td>Target Details:</td>
								<td>Benchmark:</td>
								<td>Remain WDs:</td>
								<td colspan="3" style="text-align: center;">Datailed Stock</td>
							</tr>
							<tr>
								<td><?php echo $mobLoadName; ?> Target:</td>
								<td><?php echo $FrMobLoadTarget; ?></td>
								<td bgcolor="#00bfff" style="text-align: center; font: 16px arial Black; color: Black"><?php echo $ThisDay ?></td>
								<td rowspan="9" colspan="3"><?php echo calcStocks($scratchCardName, $QueryFD,$QueryLD,$CurrentMonth) ; echo calcStocks($simsName, $QueryFD,$QueryLD,$CurrentMonth) ; echo calcStocks($mobileDevicesName, $QueryFD,$QueryLD,$CurrentMonth) ;?></td>
							</tr>
							<tr>
								<td><?php echo $mobLoadName; ?> Achieved:</td>
								<td><?php echo $FrMobLoadAchieved ?></td>
								<td rowspan="2" bgcolor="#FFFF00" style="text-align: center; font: 30px arial Black;"><?php echo $CurrentDay ?></td>
							</tr>
							<tr>
								<td><?php echo $mobLoadName; ?> Remain:</td>
								<td><?php echo $FrMobLoadTargetRemain ?></td>
							</tr>
							<tr>
								<td><?php echo $scratchCardName; ?> Target:</td>
								<td> <?php echo $FrCardtarget ?></td>
								<td rowspan="3" bgcolor="#0099cc" style="text-align: center; font: 48px arial Black;"><?php echo $LastDay ?></td>
							</tr>
							<tr>
								<td><?php echo $scratchCardName; ?> Achieved:</td>
								<td> <?php echo $FrCardAchieved ?></td>
							</tr>
							<tr>
								<td><?php echo $scratchCardName; ?> Remain:</td>
								<td> <?php echo $FrCardtargetRemain ?></td>
							</tr>
							<tr>
								<td><?php echo $mobileDevicesName; ?> Target</td>
								<td> <?php echo $mobitarget ?></td>
								<td>Total %</td>
							</tr>
							<tr>
								<td> <?php echo $mobileDevicesName; ?> Achieved</td>
								<td><?php echo $dmAchAchieved ?></td>
								<td> Dev. Ach. %</td>
							</tr>
							<tr>
								<td> <?php echo $mobileDevicesName; ?> Remain</td>
								<td> <?php echo $mobitarget-$dmAchAchieved ?></td>
								<td>Dev. Remain %</td>
							</tr>
						</table>
					</td>
					<td colspan="2"> 
													<table cellpadding="0" cellspacing="0" border="1" id="">
																		<tr>
																			<td>Otar Visibility:</td>
																			<td><?php echo round($netProfit,0) ?></td>
																			<td>Otar Invest:</td>
																			<td><?php echo round($OtarInvestLessMargin,0) ?></td>
																			<td>Opening Investment:</td>
																			<td><?php echo round($initialInvest,2) ?></td>
																		</tr>
																		<tr>
																			<td>MFS Visibility:</td>
																			<td><?php echo round($mfsProfits,0) ?></td>
																			<td>MFS Invest:</td>
																			<td><?php echo $mfsinvestment; ?></td>
																			<td>New Investment:</td>
																			<td><?php echo round($currentInvest,2) ?></td>
																		</tr>	
																			
																		<tr>
																			<td>SIM Visibility:</td>
																			<td><?php echo round($CDProLoss ,0) ?></td>
																			<td>SIM Invest:</td>
																			<td><?php echo round($CDClosingstock,0) ?></td>
																			<td>New Withdraw:</td>
																			<td><?php echo round($currentWithdraw,2) ?></td>
																		</tr>
																		<tr>
																		    
																			<td>Set Visibility:</td>
																			<td><?php echo round($MobProLoss ,0) ?></td>
																			<td>Set Invest:</td>
																			<td><?php echo round($mobClosingstock,0) ?></td>
																			<td><b>Total Investment:</b></td>
																			<td> <?php echo "<b>". round($currentinvestment,0)."</b>"; ?></td>
																		</tr>
																		
																		<tr>
																			
																			<td>Card Visibility:</td>
																			<td> <?php echo round($cardPL ,0) ?></td>
																			<td>Card Invest:</td>
																			<td><?php echo round($cAmntSum,0) ?></td>
																			<!-- <td><?php echo round($cardClosingInvest,0) ?></td> -->
																			<td>Visibility:</td>
																			<td><?php echo round($totalVisibil-$regularExpenses ,0) ?></td>
																		</tr>
																		
																		<tr>
																			<td>Other Comission:</td>
																			<td><?php echo round($otherComissionReceived,0); ?></td>
																			<td><b>LMC Dues:</b></td>
																			<td><b><?php echo round($totalCash,0)?></b></td>
																			<td>Salary, Expenses Due</td>
																			<td><?php echo round($pendSalExp,0) ?></td>
																		</tr>
																		
																		<tr>
																			<td>Online Tax:</td>
																			<td><?php echo round(-$taxAmnt,2) ?></td>
																			<td>Mobile Dues:</td>
																			<td><?php echo round($totalMobile,0) ?></td>
																			<td> Pending Profit:</td>
																			<td><?php echo round($ProfitDueAmnt,2) ?></td>
																		</tr>
																		
																		<tr>
																		    <td>Reg Expenses:</td>
																			<td><?php echo $regularExpenses?></td>
																			<td>SIM Dues:</td>
																			<td><?php echo round($totalSIM,0) ?></td>
																			<td>Company Credit:</td>
																			<td><?php echo round($companycreditnow,0) ?></td>
																		</tr>
																		
																		<tr>
																		    <td> <strong> Total Visibility: </strong></td>
																			<td><strong>  <?php echo round($totalVisibil-$regularExpenses ,0) ?> </strong> </td>
																			<td>DO-Advance</td>
																			<td><?php echo round($DODue,0) ?></td>
																			<td><strong>Current Investment:</strong></td>
																			<td><strong><?php echo round($totalinvestment,0) ?></strong></td>
																		</tr>
																		
																		<tr>
																			<td>Salary, Expenses:</td>
																			<td><?php echo round($ThisMonthsalary + $fixedExpenses,0) ?></td>
																			
																			<td><b>Bank Invest:</b></td>
																			<td><b><?php echo round($BankClosing ,0) ?></b></td>
																			
																			<td>Original Investment:</td>
																			<td> <?php echo round($currentinvestment,0); ?></td>
																		</tr>
																
																		<tr>
																			<td><strong> Net Visibility:</strong> </td>
																			<td><strong> <?php echo round($netVisibil ,0) ?></strong> </td>
																			<td>Total Invest:</td>
																			<td><?php echo round($totalinvestment ,0) ?></td>
																			<td>Closing Difference:</td>
																			<?php
																			if (round($closingDiff- $companycreditnow+$regularExpenses,0) != 0)
																				echo "<td style=\"color:red\"><strong>";
																			else
																				echo "<td><strong>";
																			echo round($closingDiff- $companycreditnow+$regularExpenses,0); 
																			echo "</strong></td>";
																			?>
																		</tr>
																		
													</table>
					</td>
				</tr>
			</table>
		</div>
		
		<div id="center" class="SubDiv2" style=" border: 0px solid Blue;">	
			<table cellpadding="0" cellspacing="0" border="1" align="center" id="header-fixed0">
					<tr style="background-color: #ADBEE0;">
							<td colspan="6" ><center><h4> Otar Details</h4></center></td>
							<td colspan="6" ><center><h4> JazzCash Details</h4></center></td>
							<td colspan="5" ><center><h4> Card Details</h4></center></td>
					</tr>		
					<tr style="background-color: #ADBEE0;">	
							<!-- <td //style="width:95px">Date</td> -->
							<th style="width:90px">Date</th>
							<th style="width:70px">Opening</th>
							<th style="width:70px">Lifting</th>
							<th style="width:70px">InHand</th>
							<th style="width:70px">Sale</th>
							<th style="width:70px">Closing</th>
							
							<th style="width:70px">Opening</th>
							<th style="width:70px">Lifting</th>
							<th style="width:70px">Comission</th>
							<th style="width:70px">Sending</th>
							<th style="width:70px">Receiving</th>
							<th style="width:70px">Closing</th>
							
							<th style="width:70px">Opening</th>
							<th style="width:70px">Lifting</th>
							<th style="width:70px">InHand</th>
							<th style="width:70px">Sale</th>
							<th style="width:70px">Closing</th>
					</tr>
			</table>
		</div>
		<div id="scrollBottom" class="SubDiv3" style=" border: 0px solid Blue;">	
			<table cellpadding="0" cellspacing="0" border="1" align="center" id="header-fixed0">
													<?php
														$Opening1=$FrOtarOpening;
														$Opening2=$FrmfsOpening;
														$Opening3=$FrCardopening;
														
														for($i=$date_from; $i<=$date_to; $i+=86400)
														{
															echo "<tr>";
															$cd=date("Y-m-d", $i);
															
														//	1st Table
															$q=mysqli_query($con,"SELECT sum(loadAmnt) FROM tbl_mobile_load WHERE loadStatus='Received' AND loadEmp='$parentCompany' AND loadDate ='$cd' ");
															WHILE($Data=mysqli_fetch_array($q))
																{ $OtarLift = $Data['sum(loadAmnt)']; }
															$inHand=$Opening1+$OtarLift;
															$q=mysqli_query($con,"SELECT sum(loadTransfer) FROM tbl_mobile_load WHERE loadStatus='Sent' AND loadDate ='$cd' ");
															WHILE($Data=mysqli_fetch_array($q))
																{ $OtarSale = $Data['sum(loadTransfer)']; }
															$closing1=$inHand-$OtarSale;
															echo '<td style="width:90px">' . date("d-m-Y", $i)."</td>";
															echo '<td style="width:70px">' . $Opening1 . "</td>";
															echo '<td style="width:70px">' . $OtarLift . "</td>";
															echo '<td style="width:70px">' . $inHand . "</td>";
															echo '<td style="width:70px">' . $OtarSale . "</td>";
															echo '<td style="width:70px"><b>' . $closing1 . "</b></td>";
															$Opening1=$closing1;
														
														//  2nd Table
															$q=mysqli_query($con,"SELECT sum(mfsAmnt) FROM tbl_financial_service WHERE mfsStatus='Received' AND mfsEmp='$parentCompany' AND mfsDate ='$cd' ");
															$Data=mysqli_fetch_array($q);
															$mfsLift = $Data['sum(mfsAmnt)'];
															$q=mysqli_query($con,"SELECT sum(comAmnt) FROM comission WHERE comType='mfs comission' AND comEmp='$parentCompany' AND comDate ='$cd' ");
															$Data=mysqli_fetch_array($q);
															$mfscomission = $Data['sum(comAmnt)'];
															$q1=mysqli_query($con,"SELECT sum(mfsAmnt) FROM tbl_financial_service WHERE mfsStatus='Sent' AND mfsDate ='$cd'  ");
															$Data1=mysqli_fetch_array($q1);
															$mfsSale = $Data1['sum(mfsAmnt)'];
															$q2=mysqli_query($con,"SELECT sum(mfsAmnt) FROM tbl_financial_service WHERE mfsStatus='Received' AND mfsDate ='$cd' AND mfsEmp != '$parentCompany' ");
															$Data2=mysqli_fetch_array($q2);
															$mfsReceive = $Data2['sum(mfsAmnt)'];
															$closing2=($Opening2+$mfsLift+$mfscomission+$mfsReceive)-$mfsSale;
															echo '<td style="width:70px">' . $Opening2 . "</td>";
															echo '<td style="width:70px">' . $mfsLift . "</td>";
															echo '<td style="width:70px">' . $mfscomission . "</td>";
															echo '<td style="width:70px">' . $mfsSale . "</td>";
															echo '<td style="width:70px">' . $mfsReceive  . "</td>";
															echo '<td style="width:70px"><b>' . $closing2 . "</b></td>";
															 
															$Opening2=$closing2;
														
														//	3rd Table
															$q=mysqli_query($con,"SELECT sum(csQty) FROM tbl_cards WHERE csStatus='Received' AND csEmp='$parentCompany' AND csDate ='$cd' ");
															$Data=mysqli_fetch_array($q);
															$CardLift = $Data['sum(csQty)'];
															$CardInHand=$Opening3+$CardLift;
															$q=mysqli_query($con,"SELECT sum(csQty) FROM tbl_cards WHERE csStatus='Sent' AND csDate ='$cd' ");
															$Data=mysqli_fetch_array($q);
															$tbl_cards = $Data['sum(csQty)'];
															$closing3=$CardInHand-$tbl_cards;
															echo '<td style="width:70px">' . $Opening3 . "</td>";
															echo '<td style="width:70px">' . $CardLift . "</td>";
															echo '<td style="width:70px">' . $CardInHand . "</td>";
															echo '<td style="width:70px">' . $tbl_cards . "</td>";
															echo '<td style="width:70px"><b>' . $closing3 . "</b></td>";
															echo "</tr>";
															$Opening3=$closing3;
														}
													?>
				
			</table>
		</div >
	</div>
<?php
}
else if($currentUserType=='Manager')
{
?>
<div class="container" id="cntnr" style="border: solid blue 0px">	
		<div id="center" class="SubDiv1" style=" border: 0px solid Red;">	
			<table cellpadding="0" cellspacing="0" border="0" align="center" id="tb102">
				<tr>
					<td> 
						<table cellpadding="0" cellspacing="0" border="1" id="example">
							<tr style="background-color: #ADBEE0;">
								<th colspan="6" >
									<center>
										<h4> Target Summary</h4>
									</center>
								</th>
							</tr>
							<tr>
								<td>Target Details:</td>
								<td>Benchmark:</td>
								<td>Remain WDs:</td>
								<td colspan="3" style="text-align: center;">Datailed Stock</td>
							</tr>
							<tr>
								<td><?php echo $mobLoadName; ?> Target:</td>
								<td><?php echo $FrMobLoadTarget; ?></td>
								<td bgcolor="#00bfff" style="text-align: center; font: 16px arial Black; color: Black"><?php echo $ThisDay ?></td>
								<td rowspan="9" colspan="3"><?php echo calcStocks($scratchCardName, $QueryFD,$QueryLD,$CurrentMonth) ; echo calcStocks($simsName, $QueryFD,$QueryLD,$CurrentMonth) ; echo calcStocks($mobileDevicesName, $QueryFD,$QueryLD,$CurrentMonth) ;?></td>
							</tr>
							<tr>
								<td><?php echo $mobLoadName; ?> Achieved:</td>
								<td><?php echo $FrMobLoadAchieved ?></td>
								<td rowspan="2" bgcolor="#FFFF00" style="text-align: center; font: 30px arial Black;"><?php echo $CurrentDay ?></td>
							</tr>
							<tr>
								<td><?php echo $mobLoadName; ?> Remain:</td>
								<td><?php echo $FrMobLoadTargetRemain ?></td>
							</tr>
							<tr>
								<td><?php echo $scratchCardName; ?> Target:</td>
								<td> <?php echo $FrCardtarget ?></td>
								<td rowspan="3" bgcolor="#0099cc" style="text-align: center; font: 48px arial Black;"><?php echo $LastDay ?></td>
							</tr>
							<tr>
								<td><?php echo $scratchCardName; ?> Achieved:</td>
								<td> <?php echo $FrCardAchieved ?></td>
							</tr>
							<tr>
								<td><?php echo $scratchCardName; ?> Remain:</td>
								<td> <?php echo $FrCardtargetRemain ?></td>
							</tr>
							<tr>
								<td><?php echo $mobileDevicesName; ?> Target</td>
								<td> <?php echo $mobitarget ?></td>
								<td>Total %</td>
							</tr>
							<tr>
								<td> <?php echo $mobileDevicesName; ?> Achieved</td>
								<td><?php echo $dmAchAchieved ?></td>
								<td> Dev. Ach. %</td>
							</tr>
							<tr>
								<td> <?php echo $mobileDevicesName; ?> Remain</td>
								<td> <?php echo $mobitarget-$dmAchAchieved ?></td>
								<td>Dev. Remain %</td>
							</tr>
						</table>
					</td>
					<td colspan="2"> 
													<table cellpadding="0" cellspacing="0" border="1" id="">
																		<tr>
																			<td>Otar Visibility:</td>
																			<td><?php echo round($netProfit,0) ?></td>
																			<td>Otar Invest:</td>
																			<td><?php echo round($OtarInvestLessMargin,0) ?></td>
																			<td>Opening Investment:</td>
																			<td><?php echo round($initialInvest,2) ?></td>
																		</tr>
																		<tr>
																			<td>MFS Visibility:</td>
																			<td><?php echo round($mfsProfits,0) ?></td>
																			<td>MFS Invest:</td>
																			<td><?php echo $mfsinvestment; ?></td>
																			<td>New Investment:</td>
																			<td><?php echo round($currentInvest,2) ?></td>
																		</tr>	
																			
																		<tr>
																			<td>SIM Visibility:</td>
																			<td><?php echo round($CDProLoss ,0) ?></td>
																			<td>SIM Invest:</td>
																			<td><?php echo round($CDClosingstock,0) ?></td>
																			<td>New Withdraw:</td>
																			<td><?php echo round($currentWithdraw,2) ?></td>
																		</tr>
																		<tr>
																		    
																			<td>Set Visibility:</td>
																			<td><?php echo round($MobProLoss ,0) ?></td>
																			<td>Set Invest:</td>
																			<td><?php echo round($mobClosingstock,0) ?></td>
																			<td><b>Total Investment:</b></td>
																			<td> <?php echo "<b>". round($currentinvestment,0)."</b>"; ?></td>
																		</tr>
																		
																		<tr>
																			
																			<td>Card Visibility:</td>
																			<td> <?php echo round($cardPL ,0) ?></td>
																			<td>Card Invest:</td>
																			<td><?php echo round($cAmntSum,0) ?></td>
																			<!-- <td><?php echo round($cardClosingInvest,0) ?></td> -->
																			<td>Visibility:</td>
																			<td><?php echo round($totalVisibil-$regularExpenses ,0) ?></td>
																		</tr>
																		
																		<tr>
																			<td>Other Comission:</td>
																			<td><?php echo round($otherComissionReceived,0); ?></td>
																			<td><b>LMC Dues:</b></td>
																			<td><b><?php echo round($totalCash,0)?></b></td>
																			<td>Salary, Expenses Due</td>
																			<td><?php echo round($pendSalExp,0) ?></td>
																		</tr>
																		
																		<tr>
																			<td>Online Tax:</td>
																			<td><?php echo round(-$taxAmnt,2) ?></td>
																			<td>Mobile Dues:</td>
																			<td><?php echo round($totalMobile,0) ?></td>
																			<td> Pending Profit:</td>
																			<td><?php echo round($ProfitDueAmnt,2) ?></td>
																		</tr>
																		
																		<tr>
																		    <td>Reg Expenses:</td>
																			<td><?php echo $regularExpenses?></td>
																			<td>SIM Dues:</td>
																			<td><?php echo round($totalSIM,0) ?></td>
																			<td>Company Credit:</td>
																			<td><?php echo round($companycreditnow,0) ?></td>
																		</tr>
																		
																		<tr>
																		    <td> <strong> Total Visibility: </strong></td>
																			<td><strong>  <?php echo round($totalVisibil-$regularExpenses ,0) ?> </strong> </td>
																			<td>DO-Advance</td>
																			<td><?php echo round($DODue,0) ?></td>
																			<td><strong>Current Investment:</strong></td>
																			<td><strong><?php echo round($totalinvestment,0) ?></strong></td>
																		</tr>
																		
																		<tr>
																			<td>Salary, Expenses:</td>
																			<td><?php echo round($ThisMonthsalary + $fixedExpenses,0) ?></td>
																			
																			<td><b>Bank Invest:</b></td>
																			<td><b><?php echo round($BankClosing ,0) ?></b></td>
																			
																			<td>Original Investment:</td>
																			<td> <?php echo round($currentinvestment,0); ?></td>
																		</tr>
																
																		<tr>
																			<td><strong> Net Visibility:</strong> </td>
																			<td><strong> <?php echo round($netVisibil ,0) ?></strong> </td>
																			<td>Total Invest:</td>
																			<td><?php echo round($totalinvestment ,0) ?></td>
																			<td>Closing Difference:</td>
																			<?php
																			if (round($closingDiff- $companycreditnow+$regularExpenses,0) != 0)
																				echo "<td style=\"color:red\"><strong>";
																			else
																				echo "<td><strong>";
																			echo round($closingDiff- $companycreditnow+$regularExpenses,0); 
																			echo "</strong></td>";
																			?>
																		</tr>
																		
													</table>
					</td>
				</tr>
			</table>
		</div>
		
		<div id="center" class="SubDiv2" style=" border: 0px solid Blue;">	
			<table cellpadding="0" cellspacing="0" border="1" align="center" id="header-fixed0">
					<tr style="background-color: #ADBEE0;">
							<td colspan="6" ><center><h4> Otar Details</h4></center></td>
							<td colspan="6" ><center><h4> JazzCash Details</h4></center></td>
							<td colspan="5" ><center><h4> Card Details</h4></center></td>
					</tr>		
					<tr style="background-color: #ADBEE0;">	
							<!-- <td //style="width:95px">Date</td> -->
							<th style="width:90px">Date</th>
							<th style="width:70px">Opening</th>
							<th style="width:70px">Lifting</th>
							<th style="width:70px">InHand</th>
							<th style="width:70px">Sale</th>
							<th style="width:70px">Closing</th>
							
							<th style="width:70px">Opening</th>
							<th style="width:70px">Lifting</th>
							<th style="width:70px">Comission</th>
							<th style="width:70px">Sending</th>
							<th style="width:70px">Receiving</th>
							<th style="width:70px">Closing</th>
							
							<th style="width:70px">Opening</th>
							<th style="width:70px">Lifting</th>
							<th style="width:70px">InHand</th>
							<th style="width:70px">Sale</th>
							<th style="width:70px">Closing</th>
					</tr>
			</table>
		</div>
		<div id="scrollBottom" class="SubDiv3" style=" border: 0px solid Blue;">	
			<table cellpadding="0" cellspacing="0" border="1" align="center" id="header-fixed0">
													<?php
														$Opening1=$FrOtarOpening;
														$Opening2=$FrmfsOpening;
														$Opening3=$FrCardopening;
														
														for($i=$date_from; $i<=$date_to; $i+=86400)
														{
															echo "<tr>";
															$cd=date("Y-m-d", $i);
															
														//	1st Table
															$q=mysqli_query($con,"SELECT sum(loadAmnt) FROM tbl_mobile_load WHERE loadStatus='Received' AND loadEmp='$parentCompany' AND loadDate ='$cd' ");
															WHILE($Data=mysqli_fetch_array($q))
																{ $OtarLift = $Data['sum(loadAmnt)']; }
															$inHand=$Opening1+$OtarLift;
															$q=mysqli_query($con,"SELECT sum(loadTransfer) FROM tbl_mobile_load WHERE loadStatus='Sent' AND loadDate ='$cd' ");
															WHILE($Data=mysqli_fetch_array($q))
																{ $OtarSale = $Data['sum(loadTransfer)']; }
															$closing1=$inHand-$OtarSale;
															echo '<td style="width:90px">' . date("d-m-Y", $i)."</td>";
															echo '<td style="width:70px">' . $Opening1 . "</td>";
															echo '<td style="width:70px">' . $OtarLift . "</td>";
															echo '<td style="width:70px">' . $inHand . "</td>";
															echo '<td style="width:70px">' . $OtarSale . "</td>";
															echo '<td style="width:70px"><b>' . $closing1 . "</b></td>";
															$Opening1=$closing1;
														
														//  2nd Table
															$q=mysqli_query($con,"SELECT sum(mfsAmnt) FROM tbl_financial_service WHERE mfsStatus='Received' AND mfsEmp='$parentCompany' AND mfsDate ='$cd' ");
															$Data=mysqli_fetch_array($q);
															$mfsLift = $Data['sum(mfsAmnt)'];
															$q=mysqli_query($con,"SELECT sum(comAmnt) FROM comission WHERE comType='mfs comission' AND comEmp='$parentCompany' AND comDate ='$cd' ");
															$Data=mysqli_fetch_array($q);
															$mfscomission = $Data['sum(comAmnt)'];
															$q1=mysqli_query($con,"SELECT sum(mfsAmnt) FROM tbl_financial_service WHERE mfsStatus='Sent' AND mfsDate ='$cd'  ");
															$Data1=mysqli_fetch_array($q1);
															$mfsSale = $Data1['sum(mfsAmnt)'];
															$q2=mysqli_query($con,"SELECT sum(mfsAmnt) FROM tbl_financial_service WHERE mfsStatus='Received' AND mfsDate ='$cd' AND mfsEmp != '$parentCompany' ");
															$Data2=mysqli_fetch_array($q2);
															$mfsReceive = $Data2['sum(mfsAmnt)'];
															$closing2=($Opening2+$mfsLift+$mfscomission+$mfsReceive)-$mfsSale;
															echo '<td style="width:70px">' . $Opening2 . "</td>";
															echo '<td style="width:70px">' . $mfsLift . "</td>";
															echo '<td style="width:70px">' . $mfscomission . "</td>";
															echo '<td style="width:70px">' . $mfsSale . "</td>";
															echo '<td style="width:70px">' . $mfsReceive  . "</td>";
															echo '<td style="width:70px"><b>' . $closing2 . "</b></td>";
															 
															$Opening2=$closing2;
														
														//	3rd Table
															$q=mysqli_query($con,"SELECT sum(csQty) FROM tbl_cards WHERE csStatus='Received' AND csEmp='$parentCompany' AND csDate ='$cd' ");
															$Data=mysqli_fetch_array($q);
															$CardLift = $Data['sum(csQty)'];
															$CardInHand=$Opening3+$CardLift;
															$q=mysqli_query($con,"SELECT sum(csQty) FROM tbl_cards WHERE csStatus='Sent' AND csDate ='$cd' ");
															$Data=mysqli_fetch_array($q);
															$tbl_cards = $Data['sum(csQty)'];
															$closing3=$CardInHand-$tbl_cards;
															echo '<td style="width:70px">' . $Opening3 . "</td>";
															echo '<td style="width:70px">' . $CardLift . "</td>";
															echo '<td style="width:70px">' . $CardInHand . "</td>";
															echo '<td style="width:70px">' . $tbl_cards . "</td>";
															echo '<td style="width:70px"><b>' . $closing3 . "</b></td>";
															echo "</tr>";
															$Opening3=$closing3;
														}
													?>
				
			</table>
		</div >
	</div>
<?php
}
else if($currentUserType=='Clerk')
{
?>
<div class="container" id="cntnr" style="border: solid blue 0px">	
		<div id="center" class="SubDiv1" style=" border: 0px solid Red;">	
			<table cellpadding="0" cellspacing="0" border="0" align="center" id="tb102">
				<tr>
					<td> 
						<table cellpadding="0" cellspacing="0" border="1" id="example">
							<tr style="background-color: #ADBEE0;">
								<td colspan="6" >
									<center>
										<h4> Target Summary</h4>
									</center>
								</td>
							</tr>
							<tr>
								<td>Target Details:</td>
								<td>Benchmark:</td>
								<td>Remain WDs:</td>
								<td>Status:</td>
								<td>%Age Complete:</td>
								<td>Per Day Avg:</td>
							</tr>
							<tr>
								<td>Otar Target:</td>
								<td><?php echo $FrOtartarget; ?></td>
								<td bgcolor="#0099cc" style="text-align: center; font: 16px arial Black; color: Black"><?php echo $ThisDay ?></td>
								<td>Total %:</td>
								<td> 100 % </td>
								<td><?php echo round($FrPerDayAvgOtar,2) ?> </td>
							</tr>
																		<tr>
																			<td>Otar Achieved:</td>
																			<td><?php echo $FrOtarAchieved ?></td>
																			<td rowspan="2" bgcolor="#00bfff" style="text-align: center; font: 30px arial Black;"><?php echo $CurrentDay ?></td>
																			<td>Achieved %:</td>
																			<td><?php if($FrOtarAchievedPercent=='emp') echo "Target NA"; else echo round($FrOtarAchievedPercent,2) ?></td>
																			<td>
																			</td>
																		</tr>
																		<tr>
																			<td>Otar Remain:</td>
																			<td><?php echo $FrOtartargetRemain ?></td>
																			<td>Remain %:</td>
																			<td> <?php if($FrOtarRemainPercent=='emp') echo "Target NA"; else echo round($FrOtarRemainPercent,2) ?></td>
																			<td>
																			</td>
																		</tr>
																		<tr>
																			<td>Card Target:</td>
																			<td> <?php echo $FrCardtarget ?></td>
																			<td rowspan="3" bgcolor="#0099cc" style="text-align: center; font: 48px arial Black;"><?php echo $LastDay ?></td>
																			<td>Total %:</td>
																			<td> 100 % </td>
																			<td> <?php echo round($FrPerDayAvgCard,2) ?></td>
																		</tr>
																		<tr>
																			<td>Card Achieved:</td>
																			<td> <?php echo $FrCardAchieved ?></td>
																			
																			<td>Achieved %:</td>
																			<td>  <?php if($FrCardAchievedPercent=='emp') echo "Target NA"; else echo round($FrCardAchievedPercent,2) ?></td>
																			<td>
																			</td>
																		</tr>
																		<tr>
																			<td>Card Remain:</td>
																			<td> <?php echo $FrCardtargetRemain ?></td>
																			
																			<td>Remain:</td>
																			<td><?php if($FrCardRemainPercent=='emp') echo "Target NA"; else echo round($FrCardRemainPercent,2) ?></td> 
																			<td>
																			</td>
																		</tr>
																		<tr>
																			
																			<td>Device Target</td>
																			<td> <?php echo $mobitarget ?></td>
																			<td>Total %</td>
																			<td> 100 %</td>
																			<td>SIM Target</td>
																			<td> <?php echo $SIMtarget ?></td>
																		</tr>
																		<tr>
																			
																			<td> Device Achieved</td>
																			<td><?php echo $dmAchAchieved ?></td>
																			<td> Dev. Ach. %</td>
																			<td> <?php if ($mobitarget!='' or $mobitarget!=0) echo round ((($dmAchAchieved/$mobitarget)*100),2); else echo "Target NA"; ?> %</td>
																			<td>SIM Achieved</td>
																			<td> <?php echo $smAchAchieved ?></td>
							                                            </tr>
							                                            <tr>
																			
																			<td> Device Remain</td>
																			<td> <?php echo $mobitarget-$dmAchAchieved ?></td>
																			
																			<td>Dev. Remain %</td>
																			<td> <?php if ($mobitarget!='' or $mobitarget!=0) echo round ( ((($mobitarget-$dmAchAchieved)/$mobitarget)*100),2); else echo "Target NA"; ?>%</td>
																			<td> SIM Remain</td>
																			<td> <?php echo $SIMtarget-$smAchAchieved ?></td>
							                                            </tr>
								</table>
					</td>
					<td colspan="2"> 
													<table cellpadding="0" cellspacing="0" border="1" id="">
																		<tr>
																			<td>Otar Invest:</td>
																			<td><?php echo round($OtarInvestLessMargin,0) ?></td>
																			<td>Opening Investment:</td>
																			<td><?php echo round($initialInvest,2) ?></td>
																		</tr>
																		<tr>
																			<td>MFS Invest:</td>
																			<td><?php echo $mfsinvestment; ?></td>
																			<td>New Investment:</td>
																			<td><?php echo round($currentInvest,2) ?></td>
																		</tr>	
																			
																		<tr>
																			<td>SIM Invest:</td>
																			<td><?php echo round($CDClosingstock,0) ?></td>
																			<td>New Withdraw:</td>
																			<td><?php echo round($currentWithdraw,2) ?></td>
																		</tr>
																		<tr>
																		    
																			<td>Set Invest:</td>
																			<td><?php echo round($mobClosingstock,0) ?></td>
																			<td><b>Total Investment:</b></td>
																			<td> <?php echo "<b>". round($currentinvestment,0)."</b>"; ?></td>
																		</tr>
																		
																		<tr>
																			
																			<td>Card Invest:</td>
																			<td><?php echo round($cardClosingInvest,0) ?></td>
																			<td>Sabiqa:</td>
																			<td><?php //echo round($totalVisibil-$regularExpenses ,0) ?></td>
																		</tr>
																		
																		<tr>
																			<td><b>LMC Dues:</b></td>
																			<td><b><?php echo round($totalCash,0)?></b></td>
																			<td>Salary, Expenses Due:</td>
																			<td><?php echo round($pendSalExp,0) ?></td>
																		</tr>
																		<tr>
																			<td>Mobile Dues:</td>
																			<td><?php echo round($totalMobile,0) ?></td>
																			<td> Pending Profit</td>
																			<td><?php echo round($ProfitDueAmnt,2) ?></td>
																		</tr>
																		<tr>
																		    <td>SIM Dues:</td>
																			<td><?php echo round($totalSIM,0) ?></td>
																			<td>Company Credit:</td>
																			<td><?php echo round($companycreditnow,0) ?></td>
																		</tr>
																		<tr>
																			<td>DO-Advance</td>
																			<td><?php echo round($DODue,0) ?></td>
																		    <td><strong>Current Investment:</strong></td>
																			<td><strong><?php echo round($totalinvestment,0) ?></strong></td>
																		</tr>
																		<tr>
																		<tr>
																			<td>Total Invest:</td>
																			<td><?php echo round($totalinvestment ,0) ?></td>
																			<td>Closing Difference:</td>
																			<?php
																			if (round($closingDiff- $companycreditnow+$regularExpenses,0) != 0)
																				echo "<td style=\"color:red\"><strong>";
																			else
																				echo "<td><strong>";
																			echo round($closingDiff- $companycreditnow+$regularExpenses,0); 
																			echo "</strong></td>";
																			?>
																		</tr>
																		
													</table>
					</td>
				</tr>
			</table>
		</div>
		
		<div id="center" class="SubDiv2" style=" border: 0px solid Blue;">	
			<table cellpadding="0" cellspacing="0" border="1" align="center" id="header-fixed0">
					<tr style="background-color: #ADBEE0;">
							<td colspan="6" ><center><h4> Otar Details</h4></center></td>
							<td colspan="6" ><center><h4> JazzCash Details</h4></center></td>
							<td colspan="5" ><center><h4> Card Details</h4></center></td>
					</tr>		
					<tr style="background-color: #ADBEE0;">	
							<!-- <td //style="width:95px">Date</td> -->
							<th style="width:90px">Date</th>
							<th style="width:70px">Opening</th>
							<th style="width:70px">Lifting</th>
							<th style="width:70px">InHand</th>
							<th style="width:70px">Sale</th>
							<th style="width:70px">Closing</th>
							
							<th style="width:70px">Opening</th>
							<th style="width:70px">Lifting</th>
							<th style="width:70px">Comission</th>
							<th style="width:70px">Sending</th>
							<th style="width:70px">Receiving</th>
							<th style="width:70px">Closing</th>
							
							<th style="width:70px">Opening</th>
							<th style="width:70px">Lifting</th>
							<th style="width:70px">InHand</th>
							<th style="width:70px">Sale</th>
							<th style="width:70px">Closing</th>
					</tr>
			</table>
		</div>
		<div id="scrollBottom" class="SubDiv3" style=" border: 0px solid Blue;">	
			<table cellpadding="0" cellspacing="0" border="1" align="center" id="header-fixed0">
													<?php
														$Opening1=$FrOtarOpening;
														$Opening2=$FrmfsOpening;
														$Opening3=$FrCardopening;
														
														for($i=$date_from; $i<=$date_to; $i+=86400)
														{
															echo "<tr>";
															$cd=date("Y-m-d", $i);
															
														//	1st Table
															$q=mysqli_query($con,"SELECT sum(loadAmnt) FROM tbl_mobile_load WHERE loadStatus='Received' AND loadEmp='$parentCompany' AND loadDate ='$cd' ");
															WHILE($Data=mysqli_fetch_array($q))
																{ $OtarLift = $Data['sum(loadAmnt)']; }
															$inHand=$Opening1+$OtarLift;
															$q=mysqli_query($con,"SELECT sum(loadTransfer) FROM tbl_mobile_load WHERE loadStatus='Sent' AND loadDate ='$cd' ");
															WHILE($Data=mysqli_fetch_array($q))
																{ $OtarSale = $Data['sum(loadTransfer)']; }
															$closing1=$inHand-$OtarSale;
															echo '<td style="width:90px">' . date("d-m-Y", $i)."</td>";
															echo '<td style="width:70px">' . $Opening1 . "</td>";
															echo '<td style="width:70px">' . $OtarLift . "</td>";
															echo '<td style="width:70px">' . $inHand . "</td>";
															echo '<td style="width:70px">' . $OtarSale . "</td>";
															echo '<td style="width:70px"><b>' . $closing1 . "</b></td>";
															$Opening1=$closing1;
														
														//  2nd Table
															$q=mysqli_query($con,"SELECT sum(mfsAmnt) FROM tbl_financial_service WHERE mfsStatus='Received' AND mfsEmp='$parentCompany' AND mfsDate ='$cd' ");
															$Data=mysqli_fetch_array($q);
															$mfsLift = $Data['sum(mfsAmnt)'];
															$q=mysqli_query($con,"SELECT sum(comAmnt) FROM comission WHERE comType='mfs comission' AND comEmp='$parentCompany' AND comDate ='$cd' ");
															$Data=mysqli_fetch_array($q);
															$mfscomission = $Data['sum(comAmnt)'];
															$q1=mysqli_query($con,"SELECT sum(mfsAmnt) FROM tbl_financial_service WHERE mfsStatus='Sent' AND mfsDate ='$cd'  ");
															$Data1=mysqli_fetch_array($q1);
															$mfsSale = $Data1['sum(mfsAmnt)'];
															$q2=mysqli_query($con,"SELECT sum(mfsAmnt) FROM tbl_financial_service WHERE mfsStatus='Received' AND mfsDate ='$cd' AND mfsEmp != '$parentCompany' ");
															$Data2=mysqli_fetch_array($q2);
															$mfsReceive = $Data2['sum(mfsAmnt)'];
															$closing2=($Opening2+$mfsLift+$mfscomission+$mfsReceive)-$mfsSale;
															echo '<td style="width:70px">' . $Opening2 . "</td>";
															echo '<td style="width:70px">' . $mfsLift . "</td>";
															echo '<td style="width:70px">' . $mfscomission . "</td>";
															echo '<td style="width:70px">' . $mfsSale . "</td>";
															echo '<td style="width:70px">' . $mfsReceive  . "</td>";
															echo '<td style="width:70px"><b>' . $closing2 . "</b></td>";
															 
															$Opening2=$closing2;
														
														//	3rd Table
															$q=mysqli_query($con,"SELECT sum(csQty) FROM tbl_cards WHERE csStatus='Received' AND csEmp='$parentCompany' AND csDate ='$cd' ");
															$Data=mysqli_fetch_array($q);
															$CardLift = $Data['sum(csQty)'];
															$CardInHand=$Opening3+$CardLift;
															$q=mysqli_query($con,"SELECT sum(csQty) FROM tbl_cards WHERE csStatus='Sent' AND csDate ='$cd' ");
															$Data=mysqli_fetch_array($q);
															$tbl_cards = $Data['sum(csQty)'];
															$closing3=$CardInHand-$tbl_cards;
															echo '<td style="width:70px">' . $Opening3 . "</td>";
															echo '<td style="width:70px">' . $CardLift . "</td>";
															echo '<td style="width:70px">' . $CardInHand . "</td>";
															echo '<td style="width:70px">' . $tbl_cards . "</td>";
															echo '<td style="width:70px"><b>' . $closing3 . "</b></td>";
															echo "</tr>";
															$Opening3=$closing3;
														}
													?>
				
			</table>
		</div >
	</div>

<?php
}
else
	echo "<br><br><br> Welcome ".$currentActiveUser;
?>