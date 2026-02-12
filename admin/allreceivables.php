<?php
include_once('../session.php');
include_once('includes/variables.php');
include_once('includes/openclose.php');
include_once('includes/globalvar.php');

$closing=0;

?>
			<head>
				<title>All Receivables</title>
					<style>
						<?php
						
						include_once('styles/navbarstyle.php');
						include_once('styles/tablestyle.php');
						include_once('includes/navbar.php');
						?>
					</style>
			</head>
				<center>
					<caption> <h1>ALL RECEIVABLES</h1></caption>
				</center>
		<table cellpadding="0" cellspacing="0" border="1" align="center" id="dbResult">
				<tr >
					<td colspan="7" > 
						<center><h1> ALL RECEIVABLES </h1></center>
					</td>
				</tr>
				
			<!--
				<tr >
					<td colspan="22" > 
						<center><h4> Receivables </h4></center>
					</td>
				</tr>
				<tr >
					<th rowspan="2">Name</th>
					<th colspan="5">Opening</th>
					<th colspan="6">Receivables</th>
					<th colspan="5">Received</th>
					<th colspan="5">Closing</th>
					
				</tr>
				<tr >
					<th>LFS</th>
					<th>Card</th>
					<th>Mobile</th>
					<th>SIM</th>
					<th>DO-Advance</th>
					<th>Load</th>
					<th>mfs</th>
					<th>Card</th>
					<th>Mobile</th>
					<th>SIM</th>
					<th>DO-Advance</th>
					
					<th>LFS</th>
					<th>Card</th>
					<th>Mobile</th>
					<th>SIM</th>
					<th>DO-Advance</th>
					
					<th>LFS</th>
					<th>Card</th>
					<th>Mobile</th>
					<th>SIM</th>
					<th>DO-Advance</th>
					
				</tr> -->
							
				<?php
					/*-----<<<<<<<<<<<<<      do Receivables MODULE      >>>>>>>>>>>>-----*/

					
							$sumOpenCash=0;
							$sumOpenCard=0;
							$sumOpenMobile=0;
							$sumOpenSIM=0;
							$sumOpenDue=0;
							$sumLoad=0;
							$sumClose=0;
							$sumAmnt=0;
							$mobSum=0;
							$simSum=0;
							$sumGivendo=0;
							$sumLFSTaken=0;
							$sumCardTaken=0;
							$sumMblTaken=0;
							$sumTakenSIM=0;
							$sumTakendo=0;
							$sumCashClose=0;
							$sumCardClose=0;
							$sumMblClose=0;
							$sumSIMclose=0;
							$sumDueClose=0;
					
					
					
					
		$doQ=mysqli_query($con,"SELECT EmpName from empinfo WHERE (EmpStatus='Active' OR EmpStatus='Dfltr') Order by sort_order ASC");
			while($data00=mysqli_fetch_array($doQ))
				{	
			
					// OPENING MODULE start
					{
							
										$Employee=$data00['EmpName'];
								
										$EmpOpening=mysqli_query($con,"SELECT ocAmnt From openingclosing WHERE ocEmp='$Employee' AND oMonth='$CurrentMonth' AND ocType='Cash'  ");
										$Data0=mysqli_fetch_array($EmpOpening);
										$opening = $Data0['ocAmnt'];
										$openCash=$opening;
								
										$CardCashOpening=mysqli_query($con,"SELECT ocAmnt From openingclosing WHERE ocEmp='$Employee' AND oMonth='$CurrentMonth' AND ocType='Card'  ");
										$Data01=mysqli_fetch_array($CardCashOpening);
										$openCardCash = $Data01['ocAmnt'];
								
								
										$MobileCashOpening=mysqli_query($con,"SELECT ocAmnt From openingclosing WHERE ocEmp='$Employee' AND oMonth='$CurrentMonth' AND ocType='Mobile'  ");
										$Data02=mysqli_fetch_array($MobileCashOpening);
										$openMobileCash = $Data02['ocAmnt'];
								
								
										$SIMCashOpening=mysqli_query($con,"SELECT ocAmnt From openingclosing WHERE ocEmp='$Employee' AND oMonth='$CurrentMonth' AND ocType='SIM'  ");
										$Data03=mysqli_fetch_array($SIMCashOpening);
										$openSIMCash = $Data03['ocAmnt'];
								
								
															
								
										$DuesOpening=mysqli_query($con,"SELECT ocAmnt From openingclosing WHERE ocEmp='$Employee' AND oMonth='$CurrentMonth' AND ocType='DO Dues'  ");
										$Data1=mysqli_fetch_array($DuesOpening);
										$openingDue = $Data1['ocAmnt'];
								
					}
					// OPENING MODULE End		
										
										

					// RECEIVABLE MODULE start
					{
												$q2=mysqli_query($con,"SELECT sum(loadAmnt),sum(loadTransfer), sum(loadProfit), sum(loadExcessProfit) FROM tbl_mobile_load WHERE loadStatus='Sent' AND loadEmp='$Employee' AND loadDate BETWEEN '$QueryFD' AND '$QueryLD' ");
												$Data2=mysqli_fetch_array($q2);
										$load= $Data2['sum(loadAmnt)'];
								
										$transfer= $Data2['sum(loadTransfer)'];
										$Profit= $Data2['sum(loadProfit)'];
										$XsProfit=$Data2['sum(loadExcessProfit)'];
												
												
												$q3=mysqli_query($con,"SELECT sum(mfsAmnt) FROM tbl_financial_service WHERE mfsStatus='Sent' AND mfsEmp='$Employee' AND mfsDate BETWEEN '$QueryFD' AND '$QueryLD' ");
												$Data3=mysqli_fetch_array($q3);
										$mfsSend= $Data3['sum(mfsAmnt)'];
												
												
												$q4=mysqli_query($con,"SELECT sum(mfsAmnt) FROM tbl_financial_service WHERE mfsStatus='Received' AND mfsEmp='$Employee' AND mfsDate BETWEEN '$QueryFD' AND '$QueryLD' ");
												$Data4=mysqli_fetch_array($q4);
										$mfsReceive = $Data4['sum(mfsAmnt)'];
										$mfsClose = $mfsSend-$mfsReceive;
								
												
												$q5=mysqli_query($con,"SELECT sum(csQty), sum(csOrgAmnt), sum(csTotalAmnt), avg(csRate), sum(csProLoss) FROM tbl_cards WHERE csStatus='Sent' AND csEmp='$Employee' AND csDate BETWEEN '$QueryFD' AND '$QueryLD' ");
												$Data5=mysqli_fetch_array($q5);
										$cardQty = $Data5['sum(csQty)'];
										$orgAmnt= $Data5['sum(csOrgAmnt)'];
										$saleRate= $Data5['avg(csRate)'];
										$sAmountCard= $Data5['sum(csTotalAmnt)'];
								
										$pL= $Data5['sum(csProLoss)'];
										
										
										
										$receivable= $load+$mfsClose+$sAmountCard+$opening;		
										
										
									// calculating mobile sold to emp
										$sAmntSum0=0;
										$sq6 = mysqli_query($con,"SELECT typeName FROM types WHERE productName='Mobile'")or die(mysqli_query());
											WHILE($Data6=mysqli_fetch_array($sq6))
											{
												$subType=$Data6['typeName'];
												$slAmnt=0; $qt2=0; $rt2=0; $sumQt=0;
												$q7 = mysqli_query($con,"SELECT * from tbl_product_stock WHERE pSubType='$subType' AND trtype='Sent' AND customer='$Employee' AND sDate BETWEEN '$QueryFD' AND '$QueryLD'  ")or die(mysqli_query());	
												WHILE($d7=mysqli_fetch_array($q7))
												{
													$qt2=$d7['qty'];
													$rt2=$d7['rate'];
													$sumQt=$sumQt+$qt2;
													$slAmnt=$slAmnt+($qt2*$rt2);
												}
												$sAmntSum0=$sAmntSum0+$slAmnt;
											
											}
							
										// calculating Sim sold to emp
										$sAmntSum1=0;
										$sq8 = mysqli_query($con,"SELECT typeName FROM types WHERE productName='SIM'")or die(mysqli_query());
											WHILE($Data8=mysqli_fetch_array($sq8))
											{
												$subType=$Data8['typeName'];
												$slAmnt=0; $qt2=0; $rt2=0; $sumQt=0;
												$q9 = mysqli_query($con,"SELECT * from tbl_product_stock WHERE pSubType='$subType' AND trtype='Sent' AND customer='$Employee' AND sDate BETWEEN '$QueryFD' AND '$QueryLD'  ")or die(mysqli_query());	
												WHILE($d9=mysqli_fetch_array($q9))
												{
													$qt2=$d9['qty'];
													$rt2=$d9['rate'];
													$sumQt=$sumQt+$qt2;
													$slAmnt=$slAmnt+($qt2*$rt2);
												}
												$sAmntSum1=$sAmntSum1+$slAmnt;
											}
								
								
										$q10=mysqli_query($con,"SELECT sum(rpAmnt) FROM receiptpayment WHERE rpFor ='DO Dues' AND rpStatus='PaidTo' AND rpFromTo='$Employee' AND rpDate BETWEEN '$QueryFD' AND '$QueryLD' ");
												$Data10=mysqli_fetch_array($q10);
											$givendo= $Data10['sum(rpAmnt)'];
								
					}
					// RECEIVABLE MODULE End
					
					

					// RECEIVED MODULE Start
					{		
										$q11=mysqli_query($con,"SELECT sum(rpAmnt) FROM receiptpayment WHERE rpFor ='LMC' AND rpStatus='ReceivedFrom' AND rpFromTo='$Employee' AND rpDate BETWEEN '$QueryFD' AND '$QueryLD' ");
												$Data11=mysqli_fetch_array($q11);
											$takenLFS= $Data11['sum(rpAmnt)'];		
								
								
								$q101=mysqli_query($con,"SELECT sum(rpAmnt) FROM receiptpayment WHERE rpFor ='Card' AND rpStatus='ReceivedFrom' AND rpFromTo='$Employee' AND rpDate BETWEEN '$QueryFD' AND '$QueryLD' ");
												$Data101=mysqli_fetch_array($q101);
											$takenCard= $Data101['sum(rpAmnt)'];		
								
										$q12=mysqli_query($con,"SELECT sum(rpAmnt) FROM receiptpayment WHERE rpFor ='Mobile' AND rpStatus='ReceivedFrom' AND rpFromTo='$Employee' AND rpDate BETWEEN '$QueryFD' AND '$QueryLD' ");
												$Data12=mysqli_fetch_array($q12);
											$takenMbl= $Data12['sum(rpAmnt)'];		
								
								
										$q13=mysqli_query($con,"SELECT sum(rpAmnt) FROM receiptpayment WHERE rpFor ='SIM' AND rpStatus='ReceivedFrom' AND rpFromTo='$Employee' AND rpDate BETWEEN '$QueryFD' AND '$QueryLD' ");
												$Data13=mysqli_fetch_array($q13);
											$takenSIM= $Data13['sum(rpAmnt)'];		
								
									
										$q14=mysqli_query($con,"SELECT sum(rpAmnt) FROM receiptpayment WHERE rpFor ='DO Dues' AND rpStatus='ReceivedFrom' AND rpFromTo='$Employee' AND rpDate BETWEEN '$QueryFD' AND '$QueryLD' ");
												$Data14=mysqli_fetch_array($q14);
											$takendo= $Data14['sum(rpAmnt)'];		
								
												$q15=mysqli_query($con,"SELECT sum(rpAmnt) FROM receiptpayment WHERE rpFor !='DO Dues' AND rpStatus='ReceivedFrom' AND rpFromTo='$Employee' AND rpDate BETWEEN '$QueryFD' AND '$QueryLD' ");
												$Data15=mysqli_fetch_array($q15);
										$taken= $Data15['sum(rpAmnt)'];
					}
					// RECEIVED MODULE End			
						

					// CLOSING MODULE start
					{	
					
										$dues= $receivable-$taken;
					
										$CashClose1=($openCash+$load+$mfsClose) - $takenLFS;
								
								
										$cardClose1=($openCardCash+$sAmountCard)-$takenCard;
								


										$MobileClose1=($openMobileCash+$sAmntSum0) - $takenMbl;
								
								
										$SIMClose1=($openSIMCash+$sAmntSum1) - $takenSIM;
								
								
										$DueClose1=$openingDue + $givendo - $takendo;
								
							
								// Footer Sums
										$sumOpenCash=$sumOpenCash+$openCash;
										$sumOpenCard=$sumOpenCard+$openCardCash;
										$sumOpenMobile=$sumOpenMobile+$openMobileCash;
										$sumOpenSIM=$sumOpenSIM+$openSIMCash;
										$sumOpenDue=$sumOpenDue+$openingDue;
										$sumLoad=$sumLoad+$load;
										$sumClose=$sumClose+$mfsClose;
										$sumAmnt=$sumAmnt+$sAmountCard;
										$mobSum=$mobSum+$sAmntSum0;
										$simSum=$simSum+$sAmntSum1;
										$sumGivendo=$sumGivendo+$givendo;
										$sumLFSTaken=$sumLFSTaken+$takenLFS;
										$sumCardTaken=$sumCardTaken+$takenCard;
										$sumMblTaken=$sumMblTaken+$takenMbl;
										$sumTakenSIM=$sumTakenSIM+$takenSIM;
										$sumTakendo=$sumTakendo+$takendo;
										$sumCashClose=$sumCashClose+$CashClose1;
										$sumCardClose=$sumCardClose+$cardClose1;
										$sumMblClose=$sumMblClose+$MobileClose1;
										$sumSIMclose=$sumSIMclose+$SIMClose1;
										$sumDueClose=$sumDueClose+$DueClose1;
										
							
					}
					$gtSales=0;
					$gtAll=0;
					$gtAll=$CashClose1+$cardClose1+$MobileClose1+$SIMClose1+$DueClose1;
					$gtSales=$CashClose1+$cardClose1+$MobileClose1+$SIMClose1;

					if($gtAll!=0)
					{
					?>
				<tr style="text-align: center; color: white; background: grey;">
					<td rowspan="1">Name</td>
					<td rowspan="1">Head</td>
					<td colspan="1">Opening</td>
					<td colspan="1">Sales</td>
					<td colspan="1">Received</td>
					<td colspan="1">Closing</td>
					<td rowspan="1">Grand Total</td>
				</tr>
				
				
				<tr >
					<td rowspan="6"><?php echo $Employee; ?> </td>
					<td >LMC</td>
					<td ><?php echo $openCash; ?></td>
					<td ><?php echo $load+$mfsClose; ?></td>
					<td ><?php echo $takenLFS; ?></td>
					<td ><?php echo $CashClose1; ?></td>
					<td rowspan="6" style="text-align: center; font-weight: bold;" ><?php echo $CashClose1+$cardClose1+$MobileClose1+$SIMClose1+$DueClose1; ?> </td>
				</tr>
				<tr >
					<td >Card</td>
					<td ><?php echo $openCardCash; ?></td>
					<td ><?php echo $sAmountCard; ?></td>
					<td ><?php echo $takenCard; ?></td>
					<td ><?php echo $cardClose1; ?></td>
				</tr>
				<tr >
					<td >Mobile</td>
					<td ><?php echo $openMobileCash; ?></td>
					<td ><?php echo $sAmntSum0; ?></td>
					<td ><?php echo $takenMbl; ?></td>
					<td ><?php echo $MobileClose1; ?></td>
				</tr>
				<tr >
					<td >SIM</td>
					<td ><?php echo $openSIMCash; ?></td>
					<td ><?php echo $sAmntSum1; ?></td>
					<td ><?php echo $takenSIM; ?></td>
					<td ><?php echo $SIMClose1; ?></td>
				</tr>
				<tr >
					<td >DO-Advance</td>
					<td ><?php echo $openingDue; ?></td>
					<td ><?php echo $givendo; ?></td>
					<td ><?php echo $takendo; ?></td>
					<td ><?php echo $DueClose1; ?></td>
				</tr>
				<tr style="text-align:center; color: black; font-weight: bold; background:#9999ff;">
					<td>TOTAL:</td>
					<td style="text-align: center; " ><?php echo $openCash+$openCardCash+$openMobileCash+$openSIMCash+$openingDue; ?></td>
					<td style="text-align: center; " ><?php echo $load+$mfsClose+$sAmountCard+$sAmntSum0+$sAmntSum1+$givendo; ?></td>
					<td style="text-align: center; " ><?php echo $takenLFS+$takenCard+$takenMbl+$takenSIM+$takendo; ?></td>
					<td style="text-align: center; " ><?php echo $CashClose1+$cardClose1+$MobileClose1+$SIMClose1+$DueClose1; ?></td>
				</tr>
				
			
				<?php
					}
			}
		
				?>
				<tfoot >
					<tr style="border: solid black 2px;"  >
					</tr>
				</tfoot>

		</table>
		
		
		
	</div>