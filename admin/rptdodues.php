<?php
include_once('../session.php');
include_once('includes/variables.php');
include_once('includes/openclose.php');
include_once('includes/globalvar.php');
$closing=0;
if (isset($_POST['getdoDue']))
	{
		$StartDate=$_POST['txtDateFrom'];
		
		
		/////////////////
		$QueryLD=$StartDate;
		/////////////////
		$selectedMonth=date('M-Y', strtotime($StartDate));
		$dateCurrent=date('Y-m-d', strtotime($StartDate));
		$StartDate1=strtotime($StartDate);
		$dateFirst=date('Y-m-01', strtotime($StartDate));
		
		/////////////////
		$QueryFD=$dateFirst;
		/////////////////
		
		$StartDate=$dateFirst;
		$StartDate1=date('d-m-Y',$StartDate1);
		$EndDate=$_POST['txtDateFrom'];
		$dateFirstStamp=strtotime($dateFirst);
		$dateCurrentStamp=strtotime($dateCurrent);
		$StartDate2=$dateFirst;
		
		
		/////////////////
        $CurrentMonth=$selectedMonth;
        /////////////////
	
		
		
		//$QueryFD=$StartDate;
		//$QueryLD=$EndDate;
		
	}
?>
			<head>
				<title>Do-Advance Receivables</title>
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
				<form  action="" method="POST">
		<table cellpadding="0" cellspacing="0" border="1" align="center" id="dbResult">
				<tr >
					<td colspan="5" > 
						<center><h2> Receivables Against DO Dues</h2></center>
					</td>
				</tr>
				<tr>
        					<td colspan="5" style="text-align: center;"> Date UpTo:
        						<?php
        						if (isset($_POST['getdoDue']))
        							$strDate1=$_POST['txtDateFrom'];
        						else
        							$strDate1= date('Y-m-d'); //$QueryFD date('Y-m-d');
        						echo "<input type=\"date\" value= \"$strDate1\"  name=\"txtDateFrom\" id=\"tBox\" >";
        						?>
        						<input type="submit"  value="Show" name="getdoDue" id="Btn">
        					</td>
        				</tr>
				<tr >
					<th rowspan="1">Name</th>
					<th colspan="1">Opening</th>
					<th colspan="1">Sending</th>
					<th colspan="1">Receiving</th>
					<th colspan="1">Closing</th>
					
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
					//echo "<td>";
					//echo $openCash;
					//echo "</td>";
					
							$CardCashOpening=mysqli_query($con,"SELECT ocAmnt From openingclosing WHERE ocEmp='$Employee' AND oMonth='$CurrentMonth' AND ocType='Card'  ");
							$Data01=mysqli_fetch_array($CardCashOpening);
							$openCardCash = $Data01['ocAmnt'];
					//echo "<td>";
					//echo $openCardCash;
					//echo "</td>";
					
							$MobileCashOpening=mysqli_query($con,"SELECT ocAmnt From openingclosing WHERE ocEmp='$Employee' AND oMonth='$CurrentMonth' AND ocType='Mobile'  ");
							$Data02=mysqli_fetch_array($MobileCashOpening);
							$openMobileCash = $Data02['ocAmnt'];
					//echo "<td>";
					//echo $openMobileCash;
					//echo "</td>";
					
							$SIMCashOpening=mysqli_query($con,"SELECT ocAmnt From openingclosing WHERE ocEmp='$Employee' AND oMonth='$CurrentMonth' AND ocType='SIM'  ");
							$Data03=mysqli_fetch_array($SIMCashOpening);
							$openSIMCash = $Data03['ocAmnt'];
					//echo "<td>";
					//echo $openSIMCash;
					//echo "</td>";
					
					
					//echo "<td></td>";
					//echo "<td></td>";
					//echo "<td></td>";
					
					
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
					//echo "<td>";
					//echo $load;
					//echo "</td>";
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
					//echo "<td>";
					//echo $mfsClose;
					//echo "</td>";
									
									$q5=mysqli_query($con,"SELECT sum(csQty), sum(csOrgAmnt), sum(csTotalAmnt), avg(csRate), sum(csProLoss) FROM tbl_cards WHERE csStatus='Sent' AND csEmp='$Employee' AND csDate BETWEEN '$QueryFD' AND '$QueryLD' ");
									$Data5=mysqli_fetch_array($q5);
							$cardQty = $Data5['sum(csQty)'];
							$orgAmnt= $Data5['sum(csOrgAmnt)'];
							$saleRate= $Data5['avg(csRate)'];
							$sAmountCard= $Data5['sum(csTotalAmnt)'];
					//echo "<td>";
					//echo $sAmountCard;
					//echo "</td>";
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
					//echo "<td>";
					//echo $sAmntSum0;
					//echo "</td>";
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
					//echo "<td>";
					//echo $sAmntSum1;
					//echo "</td>";
					
							$q10=mysqli_query($con,"SELECT sum(rpAmnt) FROM receiptpayment WHERE rpFor ='DO Dues' AND rpStatus='PaidTo' AND rpFromTo='$Employee' AND rpDate BETWEEN '$QueryFD' AND '$QueryLD' ");
									$Data10=mysqli_fetch_array($q10);
								$givendo= $Data10['sum(rpAmnt)'];
				 
		}
		// RECEIVABLE MODULE End
		
		

		// RECEIVED MODULE Start
		{		
							$q11=mysqli_query($con,"SELECT sum(rpAmnt) FROM receiptpayment WHERE rpFor ='LMC' AND rpStatus='ReceivedFrom' AND rpFromTo='$Employee' AND rpDate BETWEEN '$QueryFD' AND '$QueryLD' ");
									$Data11=mysqli_fetch_array($q11);
								$takenlmc= $Data11['sum(rpAmnt)'];		
					//echo "<td>";
					//echo $takenlmc;
					//echo "</td>";
					
					$q101=mysqli_query($con,"SELECT sum(rpAmnt) FROM receiptpayment WHERE rpFor ='Card' AND rpStatus='ReceivedFrom' AND rpFromTo='$Employee' AND rpDate BETWEEN '$QueryFD' AND '$QueryLD' ");
									$Data101=mysqli_fetch_array($q101);
								$takenCard= $Data101['sum(rpAmnt)'];		
					//echo "<td>";
					//echo $takenCard;
					//echo "</td>";
					
	//echo "<td></td>";			
							$q12=mysqli_query($con,"SELECT sum(rpAmnt) FROM receiptpayment WHERE rpFor ='mobile' AND rpStatus='ReceivedFrom' AND rpFromTo='$Employee' AND rpDate BETWEEN '$QueryFD' AND '$QueryLD' ");
									$Data12=mysqli_fetch_array($q12);
								$takenMbl= $Data12['sum(rpAmnt)'];		
					//echo "<td>";
					//echo $takenMbl;
					//echo "</td>";
					
							$q13=mysqli_query($con,"SELECT sum(rpAmnt) FROM receiptpayment WHERE rpFor ='SIM' AND rpStatus='ReceivedFrom' AND rpFromTo='$Employee' AND rpDate BETWEEN '$QueryFD' AND '$QueryLD' ");
									$Data13=mysqli_fetch_array($q13);
								$takenSIM= $Data13['sum(rpAmnt)'];		
					//echo "<td>";
					//echo $takenSIM;
					//echo "</td>";
						
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
		
							$CashClose=($openCash+$load+$mfsClose+$csamount) - $takenlmc;
					//echo "<td>";
					//echo $CashClose;
					//echo "</td>";
					
							$cardClose=($openCardCash+$sAmountCard)-$takenCard;
					//echo "<td>";
					//echo $cardClose;
					//echo "</td>";



							$MobileClose=($openMobileCash+$sAmntSum0) - $takenMbl;
					//echo "<td>";
					//echo $MobileClose;
					//echo "</td>";
					
							$SIMClose=($openSIMCash+$sAmntSum1) - $takenSIM;
					//echo "<td>";
					//echo $SIMClose;
					//echo "</td>";
					
							$DueClose=$openingDue + $givendo - $takendo;
			if($DueClose!=0)
			{
				echo "<tr>";			
					echo "<td>";
					echo $Employee;
					echo "</td>";
					
					echo "<td>";
					echo $openingDue;
					echo "</td>";
					
					echo "<td>";
					echo $givendo;
					echo "</td>";
					
					echo "<td>";
					echo $takendo;
					echo "</td>";
					
					echo "<td>";
					echo $DueClose;
					echo "</td>";
		    	echo "</tr>";
			}
					// Footer Sums
							$sumOpenCash=$sumOpenCash+$openCash;
							$sumOpenCard=$sumOpenCard+$openCardCash;
							$sumOpenMobile=$sumOpenMobile+$openMobileCash;
							$sumOpenSIM=$sumOpenSIM+$openSIMCash;
							$sumOpenDue=$sumOpenDue+$openingDue;
							$sumLoad=$sumLoad+$load;
							$sumClose=$sumClose+$mfsClose;
							$sumAmnt=$sumAmnt+$csamount;
							$mobSum=$mobSum+$sAmntSum0;
							$simSum=$simSum+$sAmntSum1;
							$sumGivendo=$sumGivendo+$givendo;
							$sumLMCTaken=$sumLMCTaken+$takenlmc;
							$sumCardTaken=$sumCardTaken+$takenCard;
							$sumMblTaken=$sumMblTaken+$takenMbl;
							$sumTakenSIM=$sumTakenSIM+$takenSIM;
							$sumTakendo=$sumTakendo+$takendo;
							$sumCashClose=$sumCashClose+$CashClose;
							$sumCardClose=$sumCardClose+$cardClose;
							$sumMblClose=$sumMblClose+$MobileClose;
							$sumSIMclose=$sumSIMclose+$SIMClose;
							$sumDueClose=$sumDueClose+$DueClose;
							
			
		}
				}
		
				?>
				<tfoot >
					<tr style="border: solid black 2px;"  >
						<td rowspan="1" style="text-align: right;"> <b> TOTAL: </b></td>
						<td> <b><?php //echo $sumOpenDue; ?></b></td>
						<td> <b><?php //echo $sumGivendo; ?></b></td>
						<td> <b><?php //echo $sumTakendo; ?></b></td>
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
		</form>
	</div>