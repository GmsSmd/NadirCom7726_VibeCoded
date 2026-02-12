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
						<th colspan="3">MFS</th>
						<th colspan="3">Cards</th>
						<th rowspan="2">Opening</th>
						<th rowspan="2">Receivable</th>
						<th rowspan="2">Taken</th>
						<th rowspan="2">Dues</th>
						<th colspan="4">DO Advance</th>
					</tr>
					<tr>
						<th>Load</th>
						<th>Transfer</th>
						<th>Send</th>
						<th>Receive</th>
						<th>Close</th>
						<th>Quantity</th>
						<th>Sale Rate</th>
						<th>Amount</th>
						<th>Opening</th>
						<th>Given</th>
						<th>Taken</th>
						<th>Pending</th>
						</tr>
				</thead>
	
				<tbody>
					<?php 
					
					
					
					// OpeningAmount LMC
					$EmpOpening=mysqli_query($con,"SELECT sum(ocAmnt) From openingclosing WHERE ocEmp='$Employee' AND oMonth='$CurrentMonth' AND (ocType='Cash' OR ocType='Card') ");
					$Data=mysqli_fetch_array($EmpOpening);
					$opening = $Data['sum(ocAmnt)'];
					$open=$opening;
					
					
					
					// OpeningAmount DO Dues
					$EmpDueOpening=mysqli_query($con,"SELECT sum(ocAmnt) From openingclosing WHERE ocEmp='$Employee' AND oMonth='$CurrentMonth' AND ocType='DO Dues' ");
					$DataDue=mysqli_fetch_array($EmpDueOpening);
					$openingDue = $DataDue['sum(ocAmnt)'];
					$openDue=$openingDue;
					
					

					$count=0; $sumLoad=0;	$sumTransfer=0;	$sumProfit=0; $sumSend=0; $sumReceive=0; $sumClose=0;
					$sumQty=0; $sumOrgAmnt=0; $sumSaleRate=0; $sumAmnt=0; $sumProLoss=0; $sumReceivable=0;
					$sumTaken=0; $sumDoGiven=0; $sumDoTaken=0;
				
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
							
							$receivable= $opening+$load+$mfsClose+$amount;
							
							
							
							
							
							
							
							$q5=mysqli_query($con,"SELECT sum(rpAmnt) FROM receiptpayment WHERE rpStatus='ReceivedFrom' AND rpFromTo='$Employee' AND rpDate ='$Dat' AND (rpFor='LMC' OR rpFor='Card')");
							$Data5=mysqli_fetch_array($q5);
							$taken= $Data5['sum(rpAmnt)'];
							
							$dues= $receivable-$taken;
							
							
							// GivenAmount DO-Dues
							$qGvn=mysqli_query($con,"SELECT sum(rpAmnt) FROM receiptpayment WHERE rpStatus='PaidTo' AND rpFromTo='$Employee' AND rpDate ='$Dat' AND rpFor='DO Dues' ");
							$Gvn=mysqli_fetch_array($qGvn);
							$givenDoDue= $Gvn['sum(rpAmnt)'];
							
							// TakenAmount DO-Dues
							$qRec=mysqli_query($con,"SELECT sum(rpAmnt) FROM receiptpayment WHERE rpStatus='ReceivedFrom' AND rpFromTo='$Employee' AND rpDate ='$Dat' AND rpFor='DO Dues' ");
							$DataRec=mysqli_fetch_array($qRec);
							$takenDoDue= $DataRec['sum(rpAmnt)'];
					
							$DOadvance=$openingDue+($givenDoDue-$takenDoDue);
					
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
							$sumDoGiven=$sumDoGiven+$givenDoDue;
							$sumDoTaken=$sumDoTaken+$takenDoDue;
							
								?>
								
								<tr>
									<td><?php echo date("d-m-Y", $i); ?></td>
									<td><?php echo $load; ?></td>
									<td><?php echo $transfer; ?></td>
									<td><?php echo $mfsSend; ?></td>
									<td><?php echo $mfsReceive; ?></td>
									<td><?php echo $mfsClose; ?></td>
									<td><?php echo $cardQty; ?></td>
									<td><?php echo round($saleRate,2); ?></td>
									<td><?php echo $amount; ?></td>
									<td><?php echo $opening; ?></td>
									<td><?php echo $receivable; ?></td>
									<td><?php echo $taken; ?></td>
									<td><?php echo $dues; ?></td>
									<td><?php echo $openingDue; ?></td>
									<td><?php echo $givenDoDue; ?></td>
									<td><?php echo $takenDoDue; ?></td>
									<td><?php echo $DOadvance; ?></td>
								</tr>
							<?php
							$opening=$dues;
							$openingDue=$DOadvance;
							
						}
						$sumReceivable=$sumLoad+$sumClose+$sumAmnt+$open;
						$closing=$sumReceivable-$sumTaken;
						$avgRate=$sumSaleRate/$count;
						$closingDue=$openDue+($sumDoGiven-$sumDoTaken);
		?>
				
				</tbody>
					<tfoot >
						<tr style="border: solid black 2px;"  >
								<td> <b> TOTAL: </b></td>
								<td> <b><?php echo $sumLoad; ?></b></td>
								<td> <b><?php echo $sumTransfer; ?></b></td>
								<td> <b><?php echo $sumSend; ?></b></td>
								<td> <b><?php echo $sumReceive; ?></b></td>
								<td> <b><?php echo $sumClose; ?></b></td>
								<td> <b><?php echo $sumQty; ?></b></td>
								<td> <b><?php echo round($sumOrgAmnt,2); ?></b></td>
								<td> <b><?php echo $sumAmnt; ?></b></td>
								<td> <b><?php echo $open; ?></b></td>
								<td> <b><?php echo $sumReceivable; ?></b></td>
								<td> <b><?php echo $sumTaken; ?></b></td>
								<td style="color:red;"> <b><?php echo $closing; ?></b></td>
								<td> <b><?php echo $openDue; ?></b></td>
								<td> <b><?php echo $sumDoGiven; ?></b></td>
								<td> <b><?php echo $sumDoTaken; ?></b></td>
								<td style="color:blue;"> <b><?php echo $closingDue; ?></b></td>
						</tr>
					</tfoot>
			</table>
			
		</div>
		<br>
    </div>
</html>