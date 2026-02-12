<?php
include_once('../session.php');
		$currentActiveUser=$_SESSION['login_user'];	
		$currentUser=$currentActiveUser;
		$currentUserType=$_SESSION['login_type'];
include_once('includes/dbcon.php');
include_once('includes/globalvar.php');
$Employee = $_GET['name'];
$selDate= date('d-m-Y');
if(isset($_POST['getPreRecord']))
{
	$selDate=$_POST['txtDateOld'];
}
	$QueryFD= date('Y-m-01', strtotime($selDate));
	$QueryLD=date('Y-m-t', strtotime($selDate));
	$FirstDate= date('01-m-Y', strtotime($selDate));
	$date_from = strtotime($FirstDate);
	$LastDate=date('t-m-Y', strtotime($selDate));
	$date_to = strtotime($LastDate);
	$CurrentMonth=date('M-Y', strtotime($selDate));
?>
	<head>
		<title>DO Record</title>
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
										
										
										//\/\/\/\/\/\/\/\ DO DUES START \/\/\/\/\/\/\/\/\/\\
										$EmpDueOpening=mysqli_query($con,"SELECT sum(ocAmnt) From openingclosing WHERE ocEmp='$Employee' AND oMonth='$CurrentMonth' AND ocType='DO Dues' ");
										$DataDue=mysqli_fetch_array($EmpDueOpening);
										$openingDue = $DataDue['sum(ocAmnt)'];
										$openDue=$openingDue;
										
										// GivenAmount DO-Dues
										$qGvn=mysqli_query($con,"SELECT sum(rpAmnt) FROM receiptpayment WHERE rpStatus='PaidTo' AND rpFromTo='$Employee' AND rpDate ='$Dat' AND rpFor='DO Dues' ");
										$Gvn=mysqli_fetch_array($qGvn);
										$givenDoDue= $Gvn['sum(rpAmnt)'];
										
										// TakenAmount DO-Dues
										$qRec=mysqli_query($con,"SELECT sum(rpAmnt) FROM receiptpayment WHERE rpStatus='ReceivedFrom' AND rpFromTo='$Employee' AND rpDate ='$Dat' AND rpFor='DO Dues' ");
										$DataRec=mysqli_fetch_array($qRec);
										$takenDoDue= $DataRec['sum(rpAmnt)'];
								
										$DOadvance=$openingDue+($givenDoDue-$takenDoDue);
										
										//\/\/\/\/\/\/\/\ DO DUES END \/\/\/\/\/\/\/\/\/\\
										
										
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
										$closingDue=$DOadvance;
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
												$stringToPrint=$stringToPrint.'<td style="text-align: right;">'.$DOadvance.'</td>';
										
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
												$stringLast=$stringLast.'<td style="background: green; color: white; text-align: right;">'.$DOadvance.'</td>';
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
					echo $Employee."'s ";
					?>
					Previous Record</h2></caption>
				</center>
						
				<div style="border: solid black 0px;" align="center" class="doBar">
					<?php
						//$doQ=mysqli_query($con,"SELECT EmpName from empinfo WHERE EmpStatus='Active' AND (showIn=1 OR showIn=3) Order by sort_order ASC");
						$doQ=mysqli_query($con,"SELECT EmpName from empinfo WHERE EmpStatus='Active' Order by sort_order ASC");
						while($data=mysqli_fetch_array($doQ))
							{
								$name=$data['EmpName'];
								if($name== $Employee)
									$nm='doLinkSelected';
								else
									$nm='doLink';
								?>
								<a href="dorecord.php?name=<?php echo $name;?>" id="<?php echo $nm;?>" class="button">
								<?php
								echo $data['EmpName']."</a>";
							}
					?>
				</div>
				<div>
					<form name="f1" action="" method="POST">
						<table cellpadding="0" cellspacing="0" border="0" class="table" id="HeadTable" >
							<tr>
								<td style="text-align: center;"> Date:
									<?php
									if (isset($_POST['getPreRecord']))
										$strDate=$_POST['txtDateOld'];
									else
										$strDate= date('Y-m-d');
									
										echo "<input type=\"date\" value= \"$strDate\"  name=\"txtDateOld\" id=\"tBox\" >";
									?>
									<input type="submit"  value="Get Data" name="getPreRecord" id="Btn" accesskey="g">
								</td>
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
								<th rowspan="2">DO Dues</th>

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
									<td style="text-align:center; background: green; color: white; text-align: right;"> <b><?php echo $closingDue; ?></b></td>
							</tr>
						</tfoot>
					</table>
				</div>
			</div>
</html>