<?php
include_once('../session.php');
include_once('includes/variables.php');
include_once('includes/openclose.php');
include_once('includes/globalvar.php');
$Employee=$_GET['Emp'];
$EmpIDs=mysqli_query($con,"SELECT * From empinfo WHERE EmpName='$Employee' AND EmpStatus='Active'");
$Da=mysqli_fetch_array($EmpIDs);
$eid=$Da['EmpID'];
if(isset($_POST['adjustAccounts']))
	{
		$cash=$_POST['cashClose'];
		$card=$_POST['cardClose'];
		$mobile=$_POST['mobileClose'];
		$sim=$_POST['simClose'];
		$due=$_POST['dueClose'];
		$all=$cash+$card+$mobile+$sim;
		
		if($cash!=0)
		$sq = mysqli_query($con,"INSERT INTO receiptpayment(rpFor,rpDate,rpStatus,rpFromTo,rpAmnt,rpmode,rpUser,rpNotes) values('LMC','$dateNow','ReceivedFrom','$Employee', $cash, '$defaultBankName','$currentUser','Adjusted on Resign')")or die(mysqli_query());
		
		if($card!=0)
		$sq = mysqli_query($con,"INSERT INTO receiptpayment(rpFor,rpDate,rpStatus,rpFromTo,rpAmnt,rpmode,rpUser,rpNotes) values('Card','$dateNow','ReceivedFrom','$Employee', $card, '$defaultBankName','$currentUser','Adjusted on Resign')")or die(mysqli_query());
		
		if($mobile!=0)
		$sq = mysqli_query($con,"INSERT INTO receiptpayment(rpFor,rpDate,rpStatus,rpFromTo,rpAmnt,rpmode,rpUser,rpNotes) values('Mobile','$dateNow','ReceivedFrom','$Employee', $mobile, '$defaultBankName','$currentUser','Adjusted on Resign')")or die(mysqli_query());
		
		if($sim!=0)
		$sq = mysqli_query($con,"INSERT INTO receiptpayment(rpFor,rpDate,rpStatus,rpFromTo,rpAmnt,rpmode,rpUser,rpNotes) values('SIM','$dateNow','ReceivedFrom','$Employee', $sim, '$defaultBankName','$currentUser','Adjusted on Resign')")or die(mysqli_query());
		
		if($all!=0)
		$sq = mysqli_query($con,"INSERT INTO receiptpayment(rpFor,rpDate,rpStatus,rpFromTo,rpAmnt,rpmode,rpUser,rpNotes) values('DO Dues','$dateNow','PaidTo','$Employee', $all, '$defaultBankName','$currentUser','Adjusted on Resign')")or die(mysqli_query());
		
		$Update = mysqli_query($con,"UPDATE empinfo SET EmpFixedSalary=-1 WHERE EmpID = '$eid'") or die(mysqli_error());
			//echo $cash."<br>".$card."<br>".$mobile."<br>".$sim."<br>".$due;
	}
if(isset($_POST['Resign']))
	{
		$dfltAmnt=$_POST['dueClose'];
		$EmpSal=mysqli_query($con,"SELECT * From empinfo WHERE EmpName='$Employee' AND EmpStatus='Active'");
		$Das=mysqli_fetch_array($EmpSal);
		$eSal=$Das['EmpFixedSalary'];
	if($eSal==-1 AND $dfltAmnt==0)
		{
		$Update = mysqli_query($con,"UPDATE empinfo SET Comments='Resigned on $CurrentDate',EmpStatus='Left', EmpFixedSalary=0 WHERE EmpID = '$eid'") or die(mysqli_error());
		header("Location:addemp.php");
		}
	else if($eSal==-1 AND $dfltAmnt!=0)
		{
		$Update = mysqli_query($con,"UPDATE empinfo SET Comments='Resigned on $CurrentDate',EmpStatus='Dfltr', EmpFixedSalary=0 WHERE EmpID = '$eid'") or die(mysqli_error());
		header("Location:addemp.php");
		}
	else
		{
		}
		
	}
if(isset($_POST['Cancel']))
	{
	header("Location:addemp.php");
	}
$closing=0;

?>
			<head>
				<title>Resign</title>
					<style>
						<?php
						
						include_once('styles/navbarstyle.php');
						include_once('styles/tablestyle.php');
						include_once('includes/navbar.php');
						?>
					</style>
			</head>
			<br>
			<br>
			
	
						<center><h1>DO Resign Sheet</h1></center>
					
				
			
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
					
	
			
					// OPENING MODULE start
					{
							
										
								
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
					?>
					<div>
						<form method="post" >
						<table cellpadding="0" cellspacing="0" border="1" class="" id="dbResult">
							<tr>
							<td colspan="3" style="text-align: center;"><strong><h2><?php echo $Employee;?> </strong></h2></td>
							</tr>
							<tr>
							<td >LMC</td><td > <input type="text" name="cashClose" value="<?php echo $CashClose1; ?>" readonly></td><td rowspan="5"><?php echo $CashClose1+$cardClose1+$MobileClose1+$SIMClose1+$DueClose1; ?></td>
							</tr>
							<tr>
							<td >Card</td><td > <input type="text" name="cardClose" value="<?php echo $cardClose1; ?>" readonly></td>
							</tr>
							<tr>
							<td >Mobile</td><td > <input type="text" name="mobileClose" value="<?php echo $MobileClose1; ?>" readonly> </td>
							</tr>
							<tr>
							<td >SIM</td><td > <input type="text" name="simClose" value="<?php echo $SIMClose1; ?>" readonly> </td>
							</tr>
							<tr>
							<td >DO-Advance</td><td ><input type="text" name="dueClose" value="<?php echo $DueClose1;?>" readonly> </td>
							</tr>
							<tr>
							<td colspan="3" style="text-align: center;">
							<input type="submit" name="adjustAccounts" value="Adjust Accnt" id="Btn">
							<input type="submit" name="Resign" value="Resign Now"id="Btn">
							<input type="submit" name="Cancel" value="Cancel"id="Btn">
							</td>
							</tr>
						</table>
						</form>
					</div>
				<!-- <tr style="text-align: center; color: white; background: grey;">
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

				<tfoot >
					<tr style="border: solid black 2px;"  >
					</tr>
				</tfoot>

		</table>
		
		-->
		
	</div>