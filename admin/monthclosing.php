<?php
include_once('../session.php');
include_once('includes/variables.php');
include_once('includes/openclose.php');
include_once('includes/globalvar.php');

$closing=0;

?>
			<head>
				<title>Closing</title>
					<style>
						<?php
						
						include_once('styles/navbarstyle.php');
						include_once('styles/tablestyle.php');
						include_once('includes/navbar.php');
						?>
					</style>
			</head>
				<center>
					<caption> <h1>Opening & Closing</h1></caption>
				</center>
			
		<table cellpadding="0" cellspacing="0" border="1" align="center" id="dbResult">
				<tr >
					<td colspan="6" > 
						<center><h4> Investment </h4></center>
					</td>
				</tr>
				<tr >
					<th>Opening</th>
					<th>Added</th>
					<th>Withdraw</th>
					
					<th>Closing (Amount)</th>
				</tr>
				<?php
					echo "<td>" . $initialInvest . "</td>";
					echo "<td>" . $currentInvest . "</td>";
					echo "<td>" . $currentWithdraw . "</td>";
					//echo "<td>" . round($totalVisibil,0) . "</td>";
					echo "<td>" . round($currentinvestment,0) . "</td>";
				?>
				</tr>
		</table>
		<br><br>
		
		<table cellpadding="0" cellspacing="0" border="1" align="center" id="dbResult">
				<tr >
					<td colspan="6" > 
						<center><h4> Otar </h4></center>
					</td>
				</tr>
				<tr >
					<th>Opening</th>
					<th>Lifting</th>
					<th>Sale</th>
					<th>Closing (Amount)</th>
				</tr>
				<?php
					echo "<td>" . $FrOtarOpening . "</td>";
					echo "<td>" . $FrOtarLift . "</td>";
					echo "<td>" . $FrOtarSale . "</td>";
					echo "<td>" . $FrOtarClosing . "</td>";
				?>
				</tr>
		</table>
		<br><br>
		<table cellpadding="0" cellspacing="0" border="1" align="center" id="dbResult">
				<tr >
					<td colspan="6" > 
						<center><h4> MFS </h4></center>
					</td>
				</tr>
				<tr >
					<th>Opening</th>
					<th>Lifting</th>
					<th>Comission</th>
					<th>Sending</th>
					<th>Receiving</th>
					<th>Closing (Amount)</th>
				</tr>
				<?php
					echo "<td>" . $FrmfsOpening . "</td>";
					echo "<td>" . $mfsLiftng . "</td>";
					echo "<td>" . $mfsComission . "</td>";
					echo "<td>" . $mfsSent . "</td>";
					echo "<td>" . $mfsReceive . "</td>";
					echo "<td>" . $mfsClose . "</td>";
					
				?>
				</tr>
		</table>
		<br><br>
		<table cellpadding="0" cellspacing="0" border="1" align="center" id="dbResult">
				<tr >
					<td colspan="6" > 
						<center><h4> Card </h4></center>
					</td>
				</tr>
				<tr >
					<th>Type</th>
					<th>Opening</th>
					<th>Lifting</th>
					<th>Sale</th>
					<th>Closing (Qty)</th>
				</tr>
				<?php
					$opQtySum=0; $opAmntSum=0; $pQtySum=0; $pAmntSum=0; $sQtySum=0;
					$sAmntSum=0; $cQtySum=0; $cAmntSum=0; $colSum=0;
					$sql = mysqli_query($con,"SELECT typeName FROM types WHERE productName='Card' AND isActive=1 ")or die(mysqli_query());
					WHILE($Data=mysqli_fetch_array($sql))
					{
						$subType=$Data['typeName'];
					echo "<tr>";
						echo "<td>";
						echo $subType;
						echo "</td>";
						$q = mysqli_query($con,"SELECT * from openingclosing WHERE ocType= 'Card' AND oMonth='$CurrentMonth' AND ocEmp='$subType' ORDER BY ocID DESC LIMIT 1 ")or die(mysqli_query());	
							$d=mysqli_fetch_array($q);
								$open=$d['ocAmnt'];				// opening quantity
						echo "<td>";
						echo $open;
						echo "</td>";
						$q = mysqli_query($con,"SELECT purchasePrice from rates WHERE pName= 'Card' AND spName='$subType' ORDER BY rtID DESC LIMIT 1 ")or die(mysqli_query());	
							$r=mysqli_fetch_array($q);
								$rt1=$r['purchasePrice'];		// Rate
								$opAmnt= $open * $rt1;			// Opening Amount
						$q = mysqli_query($con,"SELECT sum(csQty) from tbl_cards WHERE csType='$subType' AND csStatus='Received' AND csDate BETWEEN '$QueryFD' AND '$QueryLD'  ")or die(mysqli_query());	
							$d=mysqli_fetch_array($q);
								$purchz=$d['sum(csQty)'];		// Purchase
						echo "<td>";
						echo $purchz;
						echo "</td>";
								$prAmnt=$purchz*$rt1;			// Purchase Amount
						$slAmnt=0; $qt2=0; $rt2=0; $sumQt=0; $cnt=0; $avgrt=0;
						$q = mysqli_query($con," SELECT * from tbl_cards WHERE csType='$subType' AND csStatus='Sent' AND csDate BETWEEN '$QueryFD' AND '$QueryLD' ")or die(mysqli_query());	
							WHILE($d=mysqli_fetch_array($q))
							{
								$qt2=$d['csQty'];
								$rt2=$d['csRate'];
								$sumQt=$sumQt+$qt2;
								$slAmnt=$slAmnt+($qt2*$rt2);
							}
						echo "<td>";
						echo $sumQt;
						echo "</td>";
							$cl=$open + $purchz - $sumQt;
						echo "<td>";
						echo $cl;
						echo "</td>";
					echo "</tr>";
					}
				?>
		</table>
		<br><br>
		<table cellpadding="0" cellspacing="0" border="1" align="center" id="dbResult">
				<tr >
					<td colspan="6" > 
						<center><h4> Mobile </h4></center>
					</td>
				</tr>
				<tr >
					<th>Type</th>
					<th>Opening</th>
					<th>Lifting</th>
					<th>Sale</th>
					<th>Closing (Qty)</th>
				</tr>
				<?php
					$opQtySum=0; $opAmntSum=0; $pQtySum=0; $pAmntSum=0; $sQtySum=0;
					$sAmntSum=0; $cQtySum=0; $cAmntSum=0; $colSum=0;
					$sql = mysqli_query($con,"SELECT typeName FROM types WHERE productName='Mobile' AND isActive=1 ")or die(mysqli_query());
					WHILE($Data=mysqli_fetch_array($sql))
					{
					echo "<tr>";
						$subType=$Data['typeName'];
						echo "<td>";
						echo $subType;
						echo "</td>";
						$q1 = mysqli_query($con,"SELECT * from openingclosing WHERE ocType= 'Mobile' AND oMonth='$CurrentMonth' AND ocEmp='$subType' ORDER BY ocID DESC LIMIT 1 ")or die(mysqli_query());	
							$d=mysqli_fetch_array($q1);
								$open=$d['ocAmnt'];				// opening quantity
						echo "<td>";
						echo $open;
						echo "</td>";
						$q2 = mysqli_query($con,"SELECT purchasePrice from rates WHERE pName= 'Mobile' AND spName='$subType' ORDER BY rtID DESC LIMIT 1 ")or die(mysqli_query());	
							$r=mysqli_fetch_array($q2);
								$rt1=$r['purchasePrice'];		// Rate
								$opAmnt= $open * $rt1;			// Opening Amount
						$q3 = mysqli_query($con,"SELECT sum(qty) from tbl_product_stock WHERE pSubType='$subType' AND trtype='Received' AND sDate BETWEEN '$QueryFD' AND '$QueryLD'  ")or die(mysqli_query());	
							$d=mysqli_fetch_array($q3);
							$purchz=$d['sum(qty)'];				// Purchase
						echo "<td>";
						echo $purchz;
						echo "</td>";
								$prAmnt=$purchz*$rt1;			// Purchase Amount
						
						$slAmnt=0; $qt2=0; $rt2=0; $sumQt=0; $cnt=0; $avgrt=0;
						$q4 = mysqli_query($con,"SELECT * from tbl_product_stock WHERE pSubType='$subType' AND trtype='Sent' AND sDate BETWEEN '$QueryFD' AND '$QueryLD'  ")or die(mysqli_query());	
							WHILE($d=mysqli_fetch_array($q4))
							{
								$qt2=$d['qty'];
								$rt2=$d['rate'];
								$sumQt=$sumQt+$qt2;
								$slAmnt=$slAmnt+($qt2*$rt2);
							}
						echo "<td>";
						echo $sumQt;
						echo "</td>";
							$cl=$open + $purchz - $sumQt;
							$clAmnt=$cl * $rt1;
						echo "<td>";
						echo $cl;
						echo "</td>";
					echo "</tr>";
					}
				?>

		</table>
		<br><br>
		<table cellpadding="0" cellspacing="0" border="1" align="center" id="dbResult">
				<tr >
					<td colspan="6" > 
						<center><h4> SIM </h4></center>
					</td>
				</tr>
				<tr >
					<th>Type</th>
					<th>Opening</th>
					<th>Lifting</th>
					<th>Sale</th>
					<th>Closing (Qty)</th>
				</tr>
				<?php
					$opQtySum=0; $opAmntSum=0; $pQtySum=0; $pAmntSum=0; $sQtySum=0;
					$sAmntSum=0; $cQtySum=0; $cAmntSum=0; $colSum=0;
					$sql = mysqli_query($con,"SELECT typeName FROM types WHERE productName='SIM' AND isActive=1 ")or die(mysqli_query());
					WHILE($Data=mysqli_fetch_array($sql))
					{
					echo "<tr>";
						$subType=$Data['typeName'];
						echo "<td>";
						echo $subType;
						echo "</td>";
						$q1 = mysqli_query($con,"SELECT * from openingclosing WHERE ocType= 'SIM' AND oMonth='$CurrentMonth' AND ocEmp='$subType' ORDER BY ocID DESC LIMIT 1 ")or die(mysqli_query());	
							$d=mysqli_fetch_array($q1);
								$open=$d['ocAmnt'];				// opening quantity
						
						$q2 = mysqli_query($con,"SELECT purchasePrice from rates WHERE pName= 'SIM' AND spName='$subType' ORDER BY rtID DESC LIMIT 1 ")or die(mysqli_query());	
							$r=mysqli_fetch_array($q2);
								$rt1=$r['purchasePrice'];		// Rate
								$opAmnt= $open * $rt1;			// Opening Amount
							echo "<td>";
						echo $open;
						echo "</td>";	
								
						$q3 = mysqli_query($con,"SELECT sum(qty) from tbl_product_stock WHERE pSubType='$subType' AND trtype='Received' AND sDate BETWEEN '$QueryFD' AND '$QueryLD'  ")or die(mysqli_query());	
							$d=mysqli_fetch_array($q3);
							$purchz=$d['sum(qty)'];				// Purchase
						
								$prAmnt=$purchz*$rt1;			// Purchase Amount
						echo "<td>";
						echo $purchz;
						echo "</td>";
						$slAmnt=0; $qt2=0; $rt2=0; $sumQt=0; $cnt=0; $avgrt=0;
						$q5 = mysqli_query($con,"SELECT * from tbl_product_stock WHERE pSubType='$subType' AND trtype='Sent' AND sDate BETWEEN '$QueryFD' AND '$QueryLD'  ")or die(mysqli_query());	
							WHILE($d5=mysqli_fetch_array($q5))
							{
								$qt2=$d5['qty'];
								$rt2=$d5['rate'];
								$sumQt=$sumQt+$qt2;
								$slAmnt=$slAmnt+($qt2*$rt2);
							}
						echo "<td>";
						echo $sumQt;
						echo "</td>";
							$cl=$open + $purchz - $sumQt;
							$clAmnt=$cl * $rt1;
						echo "<td>";
						echo $cl;
						echo "</td>";
					echo "</tr>";
					}
				?>

		</table>
		
		<br>
		<br>
		<table cellpadding="0" cellspacing="0" border="1" align="center" id="dbResult">
				<tr ><td colspan="6"><center><h4> Bank Closing </h4></center></td></tr>
				<tr >
					<th>Bank Name</th>
					<th>Opening Amount</th>
					<th>Closing Amount</th>
				</tr>
				<tr style="border: solid black 2px;"  >
				<?php
				$Name=$defaultBankName;
				$sq6 = mysqli_query($con,"SELECT ocAmnt FROM openingclosing where oMonth='$CurrentMonth' AND ocType='Cash' AND ocEmp='$Name'  ")or die(mysqli_query());
				$Data6=mysqli_fetch_array($sq6);
				$Opening=$Data6['ocAmnt'];
				?>
						<td> <b><?php echo $NameHere; ?></b></td>
						<td> <b><?php echo $Opening; ?></b></td>
						<td> <b><?php echo $BankClosing; ?></b></td>
				</tr>
		</table>
		<!--
		<br>
		<br>
		<table cellpadding="0" cellspacing="0" border="1" align="center" id="dbResult">
				<tr ><td colspan="7"><center><h4> Petty Cash </h4></center></td></tr>
				<tr >
					<th>Required</th>
					<th>Alloted</th>
					<th>Due</th>
					<th>Used</th>
					<th>Remaining</th>
					<th>Salary + Expenses</th>
					<th>Closing</th>
				</tr>
				<tr style="border: solid black 2px;"  >
				
						<td> <b><?php echo $pettyOpen; ?></b></td>
						<td> <b><?php echo $pettyAdd; ?></b></td>
						<td> <b><?php echo $pettyGross; ?></b></td>
						<td> <b><?php echo $pettySub; ?></b></td>
						<td> <b><?php echo $pettyRemain; ?></b></td>
						<td> <b><?php echo $salExp ; ?></b></td>
						<td> <b><?php echo $pettyClosing; ?></b></td>
				</tr>
		</table>-->
		<br>
		<br>
		
		<table cellpadding="0" cellspacing="0" border="1" align="center" id="dbResult">
				<tr ><td colspan="10"><center><h4> Salaries </h4></center></td></tr>
				<tr >
					<th>Employee</th>
					<th>Basic Salary</th>
					<th>Otar Comission</th>
					<th>MFS Comission</th>
					<th>Market SIM Comission</th>
					<th>Activity SIM Comission</th>
					<th>Device+Handset Comission</th>
					<th>PostPaid Comission</th>
					<th>Other Comission</th>
					<th>Total Salary</th>
				</tr>
				<?php
				$sumBasic=0; $sumOtar=0; $sumMfs=0; $sumOther=0; $sumGrossSal=0; $sumActivity=0; $sumDevSet=0; $sumMarket=0; $sumPostPaid=0;
				
				$doQ=mysqli_query($con,"SELECT EmpName from empinfo WHERE EmpStatus='Active' Order by sort_order ASC");
				while($data=mysqli_fetch_array($doQ))
				{	
				
							$Employee=$data['EmpName'];
							
							$bSal=mysqli_query($con,"SELECT EmpFixedsalary, otcomrate From empinfo WHERE EmpName='$Employee' ");
							$Data0=mysqli_fetch_array($bSal);
							$basicSal = $Data0['EmpFixedsalary'];
							$otarComissionRateEmp=$Data0['otcomrate'];
					if($basicSal>0)
					{
							echo "<tr>";			
							echo "<td>";
							echo $Employee;
							echo "</td>";
									
							echo "<td>";
							echo $basicSal;
							echo "</td>";
									$q1=mysqli_query($con,"SELECT sum(loadAmnt) FROM tbl_mobile_load WHERE loadStatus='Sent' AND loadEmp='$Employee' AND loadDate BETWEEN '$QueryFD' AND '$QueryLD' ");
									$Data1=mysqli_fetch_array($q1);
									$load= $Data1['sum(loadAmnt)'];
									$otarComission=round(($load*$otarComissionRateEmp),0);
							echo "<td>";
							echo $otarComission;
							echo "</td>";
							
									$q2=mysqli_query($con,"SELECT sum(comAmnt) FROM comission WHERE rp='Paid' AND comType='mfs Comission' AND comEmp='$Employee' AND comDate BETWEEN '$QueryFD' AND '$QueryLD' ");
									$Data2=mysqli_fetch_array($q2);
									$MFSComission=$Data2['sum(comAmnt)'];
							echo "<td>";
							echo $MFSComission;
							echo "</td>";
									$q2222=mysqli_query($con,"SELECT sum(comAmnt) FROM comission WHERE rp='Paid' AND comType='Market SIM Comission' AND comEmp='$Employee' AND comDate BETWEEN '$QueryFD' AND '$QueryLD' ");
									$Data2222=mysqli_fetch_array($q2222);
									$marketSimComission=$Data2222['sum(comAmnt)'];
							echo "<td>";
							echo $marketSimComission;
							echo "</td>";
									$q2333=mysqli_query($con,"SELECT sum(comAmnt) FROM comission WHERE rp='Paid' AND comType='Activity SIM Comission' AND comEmp='$Employee' AND comDate BETWEEN '$QueryFD' AND '$QueryLD' ");
									$Data2333=mysqli_fetch_array($q2333);
									$activitySimComission=$Data2333['sum(comAmnt)'];
							echo "<td>";
							echo $activitySimComission;
							echo "</td>";
									$q2444=mysqli_query($con,"SELECT sum(comAmnt) FROM comission WHERE rp='Paid' AND comType='Device+Handset Comission' AND comEmp='$Employee' AND comDate BETWEEN '$QueryFD' AND '$QueryLD' ");
									$Data2444=mysqli_fetch_array($q2444);
									$deviceHandsetComission=$Data2444['sum(comAmnt)'];
							echo "<td>";
							echo $deviceHandsetComission;
							echo "</td>";
									$q2555=mysqli_query($con,"SELECT sum(comAmnt) FROM comission WHERE rp='Paid' AND comType='PostPaid Comission' AND comEmp='$Employee' AND comDate BETWEEN '$QueryFD' AND '$QueryLD' ");
									$Data2555=mysqli_fetch_array($q2555);
									$postPaidComission=$Data2555['sum(comAmnt)'];
							echo "<td>";
							echo $postPaidComission;
							echo "</td>";
									$q3=mysqli_query($con,"SELECT sum(comAmnt) FROM comission WHERE rp='Paid' AND comType='Other Comission' AND comEmp='$Employee' AND comDate BETWEEN '$QueryFD' AND '$QueryLD' ");
									$Data3=mysqli_fetch_array($q3);
									$otherComission=$Data3['sum(comAmnt)'];
							echo "<td>";
							echo $otherComission;
							echo "</td>";
							
									$grossSal=$basicSal+$otarComission+$MFSComission+$marketSimComission+$activitySimComission+$deviceHandsetComission+$postPaidComission+$otherComission;
							echo "<td>";
							echo $grossSal;
							echo "</td>";
							
						echo "</tr>";
					$sumBasic=$sumBasic+ $basicSal;
					$sumOtar=$sumOtar+$otarComission;
					$sumMfs=$sumMfs+$MFSComission;
					$sumMarket=$sumMarket+$marketSimComission;
					$sumActivity=$sumActivity+$activitySimComission;
					$sumDevSet=$sumDevSet+$deviceHandsetComission;
					$sumPostPaid=$sumPostPaid+$postPaidComission;
					$sumOther=$sumOther+$otherComission;
					$sumGrossSal=$sumGrossSal+$grossSal;
					
					}
				}
				?>

				<tfoot >
					<tr style="border: solid black 2px;"  >
						<td colspan="1" style="text-align: right;"> <b> TOTAL AMOUNT: </b></td>
						<td> <b><?php echo $sumBasic; ?></b></td>
						<td> <b><?php echo $sumOtar; ?></b></td>
						<td> <b><?php echo $sumMfs; ?></b></td>
						<td> <b><?php echo $sumMarket; ?></b></td>
						<td> <b><?php echo $sumActivity; ?></b></td>
						<td> <b><?php echo $sumDevSet; ?></b></td>
						<td> <b><?php echo $sumPostPaid; ?></b></td>
						<td> <b><?php echo $sumOther; ?></b></td>
						<td> <b><?php echo $sumGrossSal; ?></b></td>
					</tr>
				</tfoot>

		</table>
		<br>
		<br>
		
		
		
		<table cellpadding="0" cellspacing="0" border="1" align="center" id="dbResult">
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
					<th>LMC</th>
					<th>Card</th>
					<th>Mobile</th>
					<th>SIM</th>
					<th>DO Dues</th>
					<th>Load</th>
					<th>MFS</th>
					<th>Card</th>
					<th>Mobile</th>
					<th>SIM</th>
					<th>DO Dues</th>
					
					<th>LMC</th>
					<th>Card</th>
					<th>Mobile</th>
					<th>SIM</th>
					<th>DO Dues</th>
					
					<th>LMC</th>
					<th>Card</th>
					<th>Mobile</th>
					<th>SIM</th>
					<th>DO Dues</th>
					
				</tr>
							
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
							$sumLMCTaken=0;
							$sumCardTaken=0;
							$sumMblTaken=0;
							$sumTakenSIM=0;
							$sumTakendo=0;
							$sumCashClose=0;
							$sumCardClose=0;
							$sumMblClose=0;
							$sumSIMclose=0;
							$sumDueClose=0;
					
					
					
					
		$doQ=mysqli_query($con,"SELECT EmpName from empinfo WHERE EmpStatus='Active' ");
			while($data00=mysqli_fetch_array($doQ))
				{	
			
		// OPENING MODULE start
		{
				echo "<tr>";
							$Employee=$data00['EmpName'];
					echo "<td>";
					echo $Employee;
					echo "</td>";
					
							$EmpOpening=mysqli_query($con,"SELECT ocAmnt From openingclosing WHERE ocEmp='$Employee' AND oMonth='$CurrentMonth' AND ocType='Cash'  ");
							$Data0=mysqli_fetch_array($EmpOpening);
							$opening = $Data0['ocAmnt'];
							$openCash=$opening;
					echo "<td>";
					echo $openCash;
					echo "</td>";
					
							$CardCashOpening=mysqli_query($con,"SELECT ocAmnt From openingclosing WHERE ocEmp='$Employee' AND oMonth='$CurrentMonth' AND ocType='Card'  ");
							$Data01=mysqli_fetch_array($CardCashOpening);
							$openCardCash = $Data01['ocAmnt'];
					echo "<td>";
					echo $openCardCash;
					echo "</td>";
					
							$MobileCashOpening=mysqli_query($con,"SELECT ocAmnt From openingclosing WHERE ocEmp='$Employee' AND oMonth='$CurrentMonth' AND ocType='Mobile'  ");
							$Data02=mysqli_fetch_array($MobileCashOpening);
							$openMobileCash = $Data02['ocAmnt'];
					echo "<td>";
					echo $openMobileCash;
					echo "</td>";
					
							$SIMCashOpening=mysqli_query($con,"SELECT ocAmnt From openingclosing WHERE ocEmp='$Employee' AND oMonth='$CurrentMonth' AND ocType='SIM'  ");
							$Data03=mysqli_fetch_array($SIMCashOpening);
							$openSIMCash = $Data03['ocAmnt'];
					echo "<td>";
					echo $openSIMCash;
					echo "</td>";
					
					
					//echo "<td></td>";
					//echo "<td></td>";
					//echo "<td></td>";
					
					
							$DuesOpening=mysqli_query($con,"SELECT ocAmnt From openingclosing WHERE ocEmp='$Employee' AND oMonth='$CurrentMonth' AND ocType='DO Dues'  ");
							$Data1=mysqli_fetch_array($DuesOpening);
							$openingDue = $Data1['ocAmnt'];
					echo "<td>";
					echo $openingDue;
					echo "</td>";
		}
		// OPENING MODULE End		
							
							

		// RECEIVABLE MODULE start
		{
									$q2=mysqli_query($con,"SELECT sum(loadAmnt),sum(loadTransfer), sum(loadProfit), sum(loadExcessProfit) FROM tbl_mobile_load WHERE loadStatus='Sent' AND loadEmp='$Employee' AND loadDate BETWEEN '$QueryFD' AND '$QueryLD' ");
									$Data2=mysqli_fetch_array($q2);
							$load= $Data2['sum(loadAmnt)'];
					echo "<td>";
					echo $load;
					echo "</td>";
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
					echo "<td>";
					echo $mfsClose;
					echo "</td>";
									
									$q5=mysqli_query($con,"SELECT sum(csQty), sum(csOrgAmnt), sum(csTotalAmnt), avg(csRate), sum(csProLoss) FROM tbl_cards WHERE csStatus='Sent' AND csEmp='$Employee' AND csDate BETWEEN '$QueryFD' AND '$QueryLD' ");
									$Data5=mysqli_fetch_array($q5);
							$cardQty = $Data5['sum(csQty)'];
							$orgAmnt= $Data5['sum(csOrgAmnt)'];
							$saleRate= $Data5['avg(csRate)'];
							$sAmountCard= $Data5['sum(csTotalAmnt)'];
					echo "<td>";
					echo $sAmountCard;
					echo "</td>";
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
					echo "<td>";
					echo $sAmntSum0;
					echo "</td>";
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
					echo "<td>";
					echo $sAmntSum1;
					echo "</td>";
					
							$q10=mysqli_query($con,"SELECT sum(rpAmnt) FROM receiptpayment WHERE rpFor ='DO Dues' AND rpStatus='PaidTo' AND rpFromTo='$Employee' AND rpDate BETWEEN '$QueryFD' AND '$QueryLD' ");
									$Data10=mysqli_fetch_array($q10);
								$givendo= $Data10['sum(rpAmnt)'];
					echo "<td>";
					echo $givendo;
					echo "</td>";
		}
		// RECEIVABLE MODULE End
		
		

		// RECEIVED MODULE Start
		{		
							$q11=mysqli_query($con,"SELECT sum(rpAmnt) FROM receiptpayment WHERE rpFor ='LMC' AND rpStatus='ReceivedFrom' AND rpFromTo='$Employee' AND rpDate BETWEEN '$QueryFD' AND '$QueryLD' ");
									$Data11=mysqli_fetch_array($q11);
								$takenlmc= $Data11['sum(rpAmnt)'];		
					echo "<td>";
					echo $takenlmc;
					echo "</td>";
					
					$q101=mysqli_query($con,"SELECT sum(rpAmnt) FROM receiptpayment WHERE rpFor ='Card' AND rpStatus='ReceivedFrom' AND rpFromTo='$Employee' AND rpDate BETWEEN '$QueryFD' AND '$QueryLD' ");
									$Data101=mysqli_fetch_array($q101);
								$takenCard= $Data101['sum(rpAmnt)'];		
					echo "<td>";
					echo $takenCard;
					echo "</td>";
					
	//echo "<td></td>";			
							$q12=mysqli_query($con,"SELECT sum(rpAmnt) FROM receiptpayment WHERE rpFor ='mobile' AND rpStatus='ReceivedFrom' AND rpFromTo='$Employee' AND rpDate BETWEEN '$QueryFD' AND '$QueryLD' ");
									$Data12=mysqli_fetch_array($q12);
								$takenMbl= $Data12['sum(rpAmnt)'];		
					echo "<td>";
					echo $takenMbl;
					echo "</td>";
					
							$q13=mysqli_query($con,"SELECT sum(rpAmnt) FROM receiptpayment WHERE rpFor ='SIM' AND rpStatus='ReceivedFrom' AND rpFromTo='$Employee' AND rpDate BETWEEN '$QueryFD' AND '$QueryLD' ");
									$Data13=mysqli_fetch_array($q13);
								$takenSIM= $Data13['sum(rpAmnt)'];		
					echo "<td>";
					echo $takenSIM;
					echo "</td>";
						
							$q14=mysqli_query($con,"SELECT sum(rpAmnt) FROM receiptpayment WHERE rpFor ='DO Dues' AND rpStatus='ReceivedFrom' AND rpFromTo='$Employee' AND rpDate BETWEEN '$QueryFD' AND '$QueryLD' ");
									$Data14=mysqli_fetch_array($q14);
								$takendo= $Data14['sum(rpAmnt)'];		
					echo "<td>";
					echo $takendo;
					echo "</td>";
									$q15=mysqli_query($con,"SELECT sum(rpAmnt) FROM receiptpayment WHERE rpFor !='DO Dues' AND rpStatus='ReceivedFrom' AND rpFromTo='$Employee' AND rpDate BETWEEN '$QueryFD' AND '$QueryLD' ");
									$Data15=mysqli_fetch_array($q15);
							$taken= $Data15['sum(rpAmnt)'];
		}
		// RECEIVED MODULE End			
			

		// CLOSING MODULE start
		{	
		
							$dues= $receivable-$taken;
		
							$CashClose1=($openCash+$load+$mfsClose) - $takenlmc;
					echo "<td>";
					echo $CashClose1;
					echo "</td>";
					
							$cardClose1=($openCardCash+$sAmountCard)-$takenCard;
					echo "<td>";
					echo $cardClose1;
					echo "</td>";



							$MobileClose1=($openMobileCash+$sAmntSum0) - $takenMbl;
					echo "<td>";
					echo $MobileClose1;
					echo "</td>";
					
							$SIMClose1=($openSIMCash+$sAmntSum1) - $takenSIM;
					echo "<td>";
					echo $SIMClose1;
					echo "</td>";
					
							$DueClose1=$openingDue + $givendo - $takendo;
					echo "<td>";
					echo $DueClose1;
					echo "</td>";
				
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
							$sumLMCTaken=$sumLMCTaken+$takenlmc;
							$sumCardTaken=$sumCardTaken+$takenCard;
							$sumMblTaken=$sumMblTaken+$takenMbl;
							$sumTakenSIM=$sumTakenSIM+$takenSIM;
							$sumTakendo=$sumTakendo+$takendo;
							$sumCashClose=$sumCashClose+$CashClose1;
							$sumCardClose=$sumCardClose+$cardClose1;
							$sumMblClose=$sumMblClose+$MobileClose1;
							$sumSIMclose=$sumSIMclose+$SIMClose1;
							$sumDueClose=$sumDueClose+$DueClose1;
							
				echo "</tr>";
		}
				}
		
				?>
				<tfoot >
					<tr style="border: solid black 2px;"  >
						<td rowspan="1" style="text-align: right;"> <b> TOTAL: </b></td>
						<td> <b><?php echo $sumOpenCash; ?></b></td>
						<td> <b><?php echo $sumOpenCard; ?></b></td>
						<td> <b><?php echo $sumOpenMobile; ?></b></td>
						<td> <b><?php echo $sumOpenSIM; ?></b></td>
						<td> <b><?php echo $sumOpenDue; ?></b></td>
						
						<td> <b><?php echo $sumLoad; ?></b></td>
						<td> <b><?php echo $sumClose; ?></b></td>
						<td> <b><?php echo $sumAmnt; ?></b></td>
						<td> <b><?php echo $mobSum; ?></b></td>
						<td> <b><?php echo $simSum; ?></b></td>
						<td> <b><?php echo $sumGivendo; ?></b></td>
						
						<td> <b><?php echo $sumLMCTaken; ?></b></td>
						<td> <b><?php echo $sumCardTaken; ?></b></td>
						<td> <b><?php echo $sumMblTaken; ?></b></td>
						<td> <b><?php echo $sumTakenSIM; ?></b></td>
						<td> <b><?php echo $sumTakendo; ?></b></td>
						
						<td> <b><?php echo $sumCashClose; ?></b></td>
						<td> <b><?php echo $sumCardClose; ?></b></td>
						<td> <b><?php echo $sumMblClose; ?></b></td>
						<td> <b><?php echo $sumSIMclose; ?></b></td>
						<td> <b><?php echo $sumDueClose; ?></b></td>
					</tr>
					<!--
					<tr style="border: solid black 2px;"  >
						<td colspan='5' style="text-align: center;" > <b><?php echo $sumOpenCash+$sumOpenCard+$sumOpenMobile+$sumOpenSIM+$sumOpenDue; ?></b></td>
						<td colspan='6' style="text-align: center;"> <b><?php echo $sumLoad+$sumClose+$sumAmnt+$mobSum+$simSum+$sumGivendo; ?></b></td>
						<td colspan='5' style="text-align: center;"> <b><?php echo $sumLMCTaken+$sumCardTaken+$sumMblTaken+$sumTakenSIM+$sumTakendo; ?></b></td>
						<td colspan='5' style="text-align: center;"> <b><?php echo $sumCashClose+$sumCardClose+$sumMblClose+$sumSIMclose+$sumDueClose; ?></b></td>
					</tr>
					-->
				</tfoot>

		</table>
		
		<br>
		<br>
		<form name="f1" action="" method="POST">
				<table cellpadding="0" cellspacing="0" border="0" class="table" id="HeadTable" >
					<tr>
						<td style="text-align: right;">Closing Month</td>
						<td style="text-align: left;" >
							<select name="cMonthSelect" id="sBox">
								<?php
									$year  = date('Y');
									$month = date('m');
									$date = mktime( 0, 0, 0, $month, 1, $year );
									echo "<option>". strftime( '%b-%Y', strtotime( '-2 month', $date ) ) ."</option>";
									echo "<option>". strftime( '%b-%Y', strtotime( '-1 month', $date ) ) ."</option>";
									echo "<option selected>". strftime( '%b-%Y', strtotime( '+0 month', $date ) ) ."</option>";
									echo "<option>". strftime( '%b-%Y', strtotime( '+1 month', $date ) ) ."</option>";
									echo "<option>". strftime( '%b-%Y', strtotime( '+2 month', $date ) ) ."</option>";
								?>
							</select>	
						</td>
						<td style="text-align: right;">Opening Month</td>
						<td style="text-align: left;" >
							<select name="oMonthSelect" id="sBox">
								<?php	
									$year  = date('Y');
									$month = date('m');
									$date = mktime( 0, 0, 0, $month, 1, $year );
									echo "<option>". strftime( '%b-%Y', strtotime( '-2 month', $date ) ) ."</option>";
									echo "<option>". strftime( '%b-%Y', strtotime( '-1 month', $date ) ) ."</option>";
									echo "<option>". strftime( '%b-%Y', strtotime( '+0 month', $date ) ) ."</option>";
									echo "<option selected>". strftime( '%b-%Y', strtotime( '+1 month', $date ) ) ."</option>";
									echo "<option>". strftime( '%b-%Y', strtotime( '+2 month', $date ) ) ."</option>";
								?>
							</select>	
						</td>
					<td>
						<input type="submit"  value="Save" name="SaveClosing" id="Btn" >
					</td>
					</tr>
				</table>
			</form>
		
		
	</div>