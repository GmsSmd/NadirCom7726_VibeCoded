<?php
include_once('includes/dbcon.php');
include_once('includes/variables.php');
include_once('globalvar.php');

	/*-----<<<<<<<<<<<<<      GETTING OPENING BALANCE OTAR         >>>>>>>>>>>>-----*/

$FrOpeningOtar=mysqli_query($con,"SELECT ocAmnt From openingclosing WHERE ocEmp='Franchise' AND oMonth='$CurrentMonth' AND ocType='Otar'  ");
$Data=mysqli_fetch_array($FrOpeningOtar);
$FrOtarOpening = $Data['ocAmnt'];

	
	
	/*-----<<<<<<<<<<<<<      GETTING OPENING BALANCE mfs         >>>>>>>>>>>>-----*/

$FrOpeningmfs=mysqli_query($con,"SELECT ocAmnt From openingclosing WHERE ocEmp='Franchise' AND oMonth='$CurrentMonth' AND ocType='mfs'  ");
$Data=mysqli_fetch_array($FrOpeningmfs); 
$FrmfsOpening = $Data['ocAmnt'];



//-----<<<<<<<<<<<<<      GETTING OPENING BALANCE CARD         >>>>>>>>>>>>-----
$FrOpeningCard=mysqli_query($con,"SELECT sum(ocAmnt) From openingclosing WHERE (ocEmp='Rs.100' OR ocEmp='Rs.300' OR ocEmp='Rs.500' OR ocEmp='Rs.600' OR ocEmp='Rs.1000' OR ocEmp='Card Super Duper' OR ocEmp='SC-600') AND oMonth='$CurrentMonth' AND ocType='Card'  ");
$Data=mysqli_fetch_array($FrOpeningCard); 
$FrCardopening = $Data['sum(ocAmnt)'];

//echo "<br><br><br>".$FrCardopening;

//-----<<<<<<<<<<<<<      GETTING OPENING BALANCE SIM         >>>>>>>>>>>>-----
$FrOpeningSIM=mysqli_query($con,"SELECT ocAmnt From openingclosing WHERE ocEmp='Franchise' AND oMonth='$CurrentMonth' AND ocType='SIM'  ");
$Data=mysqli_fetch_array($FrOpeningSIM); 
$FrSIMOpening = $Data['ocAmnt'];




//-----<<<<<<<<<<<<<      GETTING OPENING BALANCE MOBILE         >>>>>>>>>>>>-----
$FrOpeningMobile=mysqli_query($con,"SELECT ocAmnt From openingclosing WHERE ocEmp='Franchise' AND oMonth='$CurrentMonth' AND ocType='Mobile'  ");
$Data=mysqli_fetch_array($FrOpeningMobile); 
$FrMobileOpening = $Data['ocAmnt'];




/*-----<<<<<<<<<<<<<      GETTING OTAR target         >>>>>>>>>>>>-----*/

$Frtarget=mysqli_query($con,"SELECT tgtAmnt From target WHERE tgtEmp='Franchise' AND tgtMonth='$CurrentMonth' AND tgtType='Otar' ");
$Data=mysqli_fetch_array($Frtarget);
$FrMobLoadTarget = $Data['tgtAmnt'];


/*-----<<<<<<<<<<<<<      GETTING OTAR target ACHIEVED         >>>>>>>>>>>>-----*/

$Frtarget=mysqli_query($con,"SELECT sum(loadAmnt) FROM tbl_mobile_load WHERE loadStatus='Received' AND loadEmp='$parentCompany' AND (loadDate Between '$QueryFD' AND '$QueryLD') ");
$Data=mysqli_fetch_array($Frtarget);
$FrMobLoadAchieved = $Data['sum(loadAmnt)'];

if($FrMobLoadTarget > 0)
	$FrOtarAchievedPercent=($FrMobLoadAchieved/$FrMobLoadTarget)*100;
else
	$FrOtarAchievedPercent="emp";
	
	
/*-----<<<<<<<<<<<<<      GETTING OTAR target REMAIN         >>>>>>>>>>>>-----*/
$FrMobLoadTargetRemain=$FrMobLoadTarget-$FrMobLoadAchieved ;

if($FrMobLoadTarget > 0)
	$FrOtarRemainPercent=($FrMobLoadTargetRemain/$FrMobLoadTarget)*100;
else
	$FrOtarRemainPercent="emp";
	

	
	
	
/*-----<<<<<<<<<<<<<      GETTING CARD target         >>>>>>>>>>>>-----*/

$Frtarget=mysqli_query($con,"SELECT tgtAmnt From target WHERE tgtEmp='Franchise' AND tgtMonth='$CurrentMonth' AND tgtType='Card'  ");
$Data=mysqli_fetch_array($Frtarget);
$FrCardtarget = $Data['tgtAmnt'];
	
/*-----<<<<<<<<<<<<<      GETTING CARD target ACHIEVED         >>>>>>>>>>>>-----*/

$Frtarget=mysqli_query($con,"SELECT sum(csQty) FROM tbl_cards WHERE csStatus='Received' AND csEmp='$parentCompany' AND (csDate Between '$QueryFD' AND '$QueryLD') ");
$Data=mysqli_fetch_array($Frtarget);
$FrCardAchieved = $Data['sum(csQty)'];


if($FrCardtarget > 0)
	$FrCardAchievedPercent=($FrCardAchieved/$FrCardtarget)*100;
else
	$FrCardAchievedPercent="emp";


/*-----<<<<<<<<<<<<<      GETTING CARD target REMAIN         >>>>>>>>>>>>-----*/

	$FrCardtargetRemain=$FrCardtarget-$FrCardAchieved;
	
	if($FrCardtarget>0)
		$FrCardRemainPercent=($FrCardtargetRemain/$FrCardtarget)*100;
	else
		$FrCardRemainPercent="emp";
	
/*-----<<<<<<<<<<<<<      GETTING CARD CLOSING         >>>>>>>>>>>>-----*/	

$sold=mysqli_query($con,"SELECT sum(csQty) FROM tbl_cards WHERE csStatus='Sent' AND csDate Between '$QueryFD' AND '$QueryLD' ");
$d3=mysqli_fetch_array($sold);
$sell = $d3['sum(csQty)'];


$getRate = mysqli_query($con,"SELECT purchasePrice from rates WHERE spName= 'Rs.100' ORDER BY rtID DESC LIMIT 1")or die(mysqli_error($con));
$rt=mysqli_fetch_array($getRate);
$cpp=$rt['purchasePrice'];
		$cardClosing=($FrCardopening + $FrCardAchieved) - $sell;
		$cardClosingInvest=$cardClosing * $cpp;
	

/*-----<<<<<<<<<<<<<      GETTING SIM target         >>>>>>>>>>>>-----*/

$smtarget=mysqli_query($con,"SELECT tgtAmnt From target WHERE tgtEmp='Franchise' AND tgtMonth='$CurrentMonth' AND tgtType='SIM'  ");
$Datasm=mysqli_fetch_array($smtarget);
$SIMtarget = $Datasm['tgtAmnt'];

/*-----<<<<<<<<<<<<<      GETTING SIM target ACHIEVED         >>>>>>>>>>>>-----*/

$smAch=mysqli_query($con,"SELECT sum(qty) FROM tbl_product_stock WHERE trType='Received' AND customer='$parentCompany' AND pName='SIM' AND (sDate Between '$QueryFD' AND '$QueryLD') ");
$DatasmAch=mysqli_fetch_array($smAch);
$smAchAchieved = $DatasmAch['sum(qty)'];



/*-----<<<<<<<<<<<<<      GETTING DEVICE / MOBILE target         >>>>>>>>>>>>-----*/

$dmtarget=mysqli_query($con,"SELECT tgtAmnt From target WHERE tgtEmp='Franchise' AND tgtMonth='$CurrentMonth' AND tgtType='Mobile'  ");
$Datadm=mysqli_fetch_array($dmtarget);
$dmtarget = $Datadm['tgtAmnt'];

/*-----<<<<<<<<<<<<<      GETTING DEVICE / MOBILE target ACHIEVED         >>>>>>>>>>>>-----*/

$dmAch=mysqli_query($con,"SELECT sum(qty) FROM tbl_product_stock WHERE trType='Received' AND customer='$parentCompany' AND pName='Mobile' AND (sDate Between '$QueryFD' AND '$QueryLD') ");
$DatadmAch=mysqli_fetch_array($dmAch);
$dmAchAchieved = $DatadmAch['sum(qty)'];





/*-----<<<<<<<<<<<<<      GETTING MOBILE target         >>>>>>>>>>>>-----*/

$mobitarget=mysqli_query($con,"SELECT tgtAmnt From target WHERE tgtEmp='Franchise' AND tgtMonth='$CurrentMonth' AND tgtType='Mobile'  ");
$Datamobi=mysqli_fetch_array($mobitarget);
$mobitarget = $Datamobi['tgtAmnt'];


	
/*-----<<<<<<<<<<<<<      PER DAY AVERAGE OTAR         >>>>>>>>>>>>-----*/	
$FrPerDayAvgOtar=$FrMobLoadTargetRemain/$ThisDay;
	
	
/*-----<<<<<<<<<<<<<      PER DAY AVERAGE CARD         >>>>>>>>>>>>-----*/	
$FrPerDayAvgCard=$FrCardtargetRemain/$ThisDay;	
	

	

/*-----<<<<<<<<<<<<<      GETTING ONLINE tax         >>>>>>>>>>>>-----*/
	
$tax=mysqli_query($con,"SELECT sum(rpAmnt) From receiptpayment WHERE rpFor='tax' AND rpStatus='PaidTo' AND rpDate BETWEEN '$QueryFD' AND '$QueryLD' ");
$Data=mysqli_fetch_array($tax); 
$taxAmnt = $Data['sum(rpAmnt)'];
	
	
	
/*-----<<<<<<<<<<<<<      GETTING OTAR VISIBILITY (LOAD PROFIT + LOAD EXCESS PROFIT)         >>>>>>>>>>>>-----*/
	
$Profit=mysqli_query($con,"SELECT sum(loadProfit), sum(loadExcessProfit) From tbl_mobile_load WHERE (loadDate BETWEEN '$QueryFD' AND '$QueryLD' )");
$Data=mysqli_fetch_array($Profit); 
$gProfit = $Data['sum(loadProfit)'];
$gProfitExcess = $Data['sum(loadExcessProfit)'];
$netProfit=$gProfit+$gProfitExcess;
	
	
	
/*-----<<<<<<<<<<<<<      GETTING mfs Comission PROFIT         >>>>>>>>>>>>-----*/
	
$mfsProfit=mysqli_query($con,"SELECT sum(comAmnt) From comission WHERE rp='Received' AND comType='MFS Comission' AND comDate BETWEEN '$QueryFD' AND '$QueryLD' ");
$Data=mysqli_fetch_array($mfsProfit); 
$mfsProfits = $Data['sum(comAmnt)'];


/*-----<<<<<<<<<<<<<      GETTING Other Comission PROFIT         >>>>>>>>>>>>-----*/
	
$otherProfit=mysqli_query($con,"SELECT sum(comAmnt) From comission WHERE rp='Received' AND comType='Other Comission' AND comDate BETWEEN '$QueryFD' AND '$QueryLD' ");
$Datas=mysqli_fetch_array($otherProfit); 
$otherComissionReceived = $Datas['sum(comAmnt)'];


/*-----<<<<<<<<<<<<<      GETTING CARD PROFIT/LOSS         >>>>>>>>>>>>-----*/
	
$Card=mysqli_query($con,"SELECT sum(csProLoss) From tbl_cards WHERE csStatus='Sent' AND (csDate BETWEEN '$QueryFD' AND '$QueryLD' )");
$Data=mysqli_fetch_array($Card); 
$cardPL = $Data['sum(csProLoss)'];
	
/*-----<<<<<<<<<<<<<      GETTING OTAR CLOSING FOR investment         >>>>>>>>>>>>-----*/	

		$qe=mysqli_query($con,"SELECT sum(loadAmnt) FROM tbl_mobile_load WHERE loadStatus='Received' AND loadEmp='$parentCompany' AND loadDate BETWEEN '$QueryFD' AND '$QueryLD' ");
			$D1=mysqli_fetch_array($qe);
			$OtLift = $D1['sum(loadAmnt)'];
		$qf=mysqli_query($con,"SELECT sum(loadTransfer) FROM tbl_mobile_load WHERE loadStatus='Sent' AND loadDate BETWEEN '$QueryFD' AND '$QueryLD' ");
			$D2=mysqli_fetch_array($qf);
			$OtSale = $D2['sum(loadTransfer)'];
	
	
	$Otarinvestment= $FrOtarOpening + $OtLift - $OtSale;
	$OtarInvestLessMargin=$Otarinvestment - ($Otarinvestment*$marginReceived);
	
	
	
/*-----<<<<<<<<<<<<<      GETTING mfs CLOSING FOR investment         >>>>>>>>>>>>-----*/

		$qm=mysqli_query($con,"SELECT sum(mfsAmnt) FROM tbl_financial_service WHERE mfsStatus='Received' AND mfsDate BETWEEN '$QueryFD' AND '$QueryLD' ");
						$Datam=mysqli_fetch_array($qm);
						$mfsReceived = $Datam['sum(mfsAmnt)'];
		$qn=mysqli_query($con,"SELECT sum(comAmnt) FROM comission WHERE comType='mfs comission' AND comEmp='$parentCompany' AND comDate BETWEEN '$QueryFD' AND '$QueryLD' ");
						$Datan=mysqli_fetch_array($qn);
						$mfscomissionk = $Datan['sum(comAmnt)'];
		$qk=mysqli_query($con,"SELECT sum(mfsAmnt) FROM tbl_financial_service WHERE mfsStatus='Sent' AND mfsDate BETWEEN '$QueryFD' AND '$QueryLD'  ");
						$Datak=mysqli_fetch_array($qk);
						$mfsSalek = $Datak['sum(mfsAmnt)'];
		
	
	$mfsinvestment= ( $FrmfsOpening + $mfsReceived +  $mfscomissionk ) - $mfsSalek;
	
/*-----<<<<<<<<<<<<<      GETTING MOBILE VISIBILITY      >>>>>>>>>>>>-----*/	

					$Prod='Mobile';
					$sumAllOpenCost=0;	$sumAllPrCost=0;	$sumOpPrCost=0;	$sumTotSale=0;	$sumSaleCost=0;	$totalRemInvestMob=0;	
					
					
					$sql = mysqli_query($con,"SELECT typeName FROM types WHERE productName='$Prod' ")or die(mysqli_error($con));
					WHILE($Data=mysqli_fetch_array($sql))
					{
						$open=0;
						
						$subType=$Data['typeName'];
					// getting purchase price
							$q = mysqli_query($con,"SELECT purchasePrice from rates WHERE pName= '$Prod' AND spName='$subType' ORDER BY rtID DESC LIMIT 1 ")or die(mysqli_error($con));	
							$r=mysqli_fetch_array($q);
						$rt1=$r['purchasePrice'];
					
					// getting opening stock
							$q = mysqli_query($con,"SELECT * from openingclosing WHERE ocType= '$Prod' AND oMonth='$CurrentMonth' AND ocEmp='$subType' ORDER BY ocID DESC LIMIT 1 ")or die(mysqli_error($con));	
							$d=mysqli_fetch_array($q);
						$open=$d['ocAmnt'];
					
					// getting purchases during current month
							$q = mysqli_query($con,"SELECT sum(qty) from tbl_product_stock WHERE pSubType='$subType' AND trtype='Received' AND sDate BETWEEN '$QueryFD' AND '$QueryLD'  ")or die(mysqli_error($con));	
							$d=mysqli_fetch_array($q);
						$purchz=$d['sum(qty)'];
						
					// Opening Cost
						$opCost=$open * $rt1;
					// Purchases Cost
						$prCost=$purchz * $rt1;
					// Total Cost
						$totCost=$opCost + $prCost;
					
					// getting sale quantity, sale rate and sale amount
							
							$slAmnt=0; $Sumqt2=0; $Sumrt2=0; $totSale=0; $cnt=0; $avgrt=0; $saleCost=0;
							$q = mysqli_query($con,"SELECT * from tbl_product_stock WHERE pSubType='$subType' AND trtype='Sent' AND sDate BETWEEN '$QueryFD' AND '$QueryLD'  ")or die(mysqli_error($con));	
							WHILE($d=mysqli_fetch_array($q))
							{
								$qw = mysqli_query($con,"SELECT purchasePrice from rates WHERE pName= '$Prod' AND spName='$subType' ORDER BY rtID DESC LIMIT 1 ")or die(mysqli_error($con));	
								$rtw=mysqli_fetch_array($qw);
								$rtw=$r['purchasePrice'];
									$qt2=0;		$rt2=0;
									$qt2=$d['qty'];
									$rt2=$d['rate'];
									$totSale=$totSale+($qt2*$rt2);
									$saleCost=$saleCost+($qt2*$rtw);
							}
					$sumAllOpenCost=$sumAllOpenCost + $opCost;
					$sumAllPrCost=$sumAllPrCost + $prCost;
					$sumOpPrCost=$sumOpPrCost + $totCost;					// it is named as "Total Invest" in excel sheet
					
					$sumTotSale=$sumTotSale + $totSale;
					$sumSaleCost=$sumSaleCost + $saleCost;					// it is named as "Invest Sale" in excel sheet
					
					}
// Getting Collection Amount
							$q = mysqli_query($con,"SELECT sum(rpAmnt) from receiptpayment WHERE rpFor='$Prod' AND rpStatus='ReceivedFrom' AND rpDate BETWEEN '$QueryFD' AND '$QueryLD'  ")or die(mysqli_error($con));	
							$d=mysqli_fetch_array($q);
							$colSum=$d['sum(rpAmnt)'];
						
					$totalRemInvestMob=$sumOpPrCost-$sumSaleCost;	
					$MobInvest=	$sumOpPrCost-$colSum;
					
					//$mobClosingstock=$MobInvest;
					$mobClosingstock=$totalRemInvestMob;
					$MobProLoss=$sumTotSale-$sumSaleCost;

					
					// Diagnostic Part
				/*
				echo 'All Open Cost: '.$sumAllOpenCost;
				echo "<br>";
				echo 'All Purchases Cost: '.$sumAllPrCost;
				echo "<br>";
				echo 'All Open Purchz Cost: '.$sumOpPrCost;
				echo "<br>";
				echo 'Sum Total Sale: '.$sumTotSale;
				echo "<br>";
				echo 'Sum Sale Cost: '.$sumSaleCost;
				echo "<br>";
				echo 'Collection: '.$colSum;
				echo "<br>";
				echo 'Total Rem Invest: '.$totalRemInvest;
				echo "<br>";
				*/


 //$cAmntSum=0;
/*






												$opQtySum=0;	$opAmntSum=0;	$pQtySum=0;	$pAmntSum=0; $sQtySum=0; $sAmntSum=0;	$cQtySum=0;	$cAmntSum=0;	$colSum=0;
													$opTotAmnt=0; $proLoss=0;
													$sql = mysqli_query($con,"SELECT typeName FROM types WHERE productName='Mobile'")or die(mysqli_error($con));
													WHILE($Data=mysqli_fetch_array($sql))
														{
															$subType=$Data['typeName'];
														// getting opening stock
																$q = mysqli_query($con,"SELECT * from openingclosing WHERE ocType= 'Mobile' AND oMonth='$CurrentMonth' AND ocEmp='$subType' ORDER BY ocID DESC LIMIT 1 ")or die(mysqli_error($con));	
																$d=mysqli_fetch_array($q);
									/* OPENING Qty 			$open=$d['ocAmnt'];
									
														// getting purchase price
																$q = mysqli_query($con,"SELECT purchasePrice from rates WHERE pName= 'Mobile' AND spName='$subType' ORDER BY rtID DESC LIMIT 1 ")or die(mysqli_error($con));	
																$r=mysqli_fetch_array($q);
																$rt1=$r['purchasePrice'];
																
									/*1 OPENING AMNT 		$opAmnt=$open * $rt1;
																$opTotAmnt=$opTotAmnt+$opAmnt;

																
									
														// getting purchases during current month
																$q = mysqli_query($con,"SELECT sum(qty) from tbl_product_stock WHERE pSubType='$subType' AND trtype='Received' AND sDate BETWEEN '$QueryFD' AND '$QueryLD'  ")or die(mysqli_error($con));	
																$d=mysqli_fetch_array($q);
																$purchz=$d['sum(qty)'];
									/*2 PURCHASES AMNT 		$prAmnt=$purchz*$rt1;
																$pAmntSum=$pAmntSum + $prAmnt;
									
														// getting sale quantity, sale rate and sale amount		
																		
																		$total=0;																		
																$q = mysqli_query($con,"SELECT * from tbl_product_stock WHERE pSubType='$subType' AND trtype='Sent' AND sDate BETWEEN '$QueryFD' AND '$QueryLD'  ")or die(mysqli_error($con));	
																	WHILE($d=mysqli_fetch_array($q))
																	{
																		$sum=0;
																		$qt2=0;
																		$rt2=0;
																		$qt2=$d['qty'];
																		$rt2=$d['rate'];
																		
																		$sum=$qt2*$rt2;
																		$total=$total+$sum;
																	}
									3 Sale AMNT 			$sAmntSum=$sAmntSum + $total;			/*sale amnt
																//$cloAmnt=$opAmnt+$prAmnt-$sum;
																
																//$cl=$open + $purchz - $Sumqt2;
																//$clAmnt=$cl*$rt1;
																//$opQtySum=$opQtySum + $open;
																//$opAmntSum=$opTotAmnt;
																//$pQtySum=$pQtySum + $purchz;
																
																//$sQtySum=$sQtySum + $Sumqt2;
																
																//$cQtySum=$cQtySum + $cl;
																//$cAmntSum=$cAmntSum + $cloAmnt;
														
														}
														

								// Getting Cost of Sales-stock
																	$saleCost=0; $counter=0;
																	$q = mysqli_query($con,"SELECT pSubType, sum(qty) from tbl_product_stock WHERE pName='Mobile' AND trtype='Sent' AND sDate BETWEEN '$QueryFD' AND '$QueryLD' GROUP BY pSubType ")or die(mysqli_error($con));	
																	WHILE($d=mysqli_fetch_array($q))
																	{
																		$sTp=$d['pSubType'];
																		$slQty=$d['sum(qty)'];
																		$q2 = mysqli_query($con,"SELECT purchasePrice from rates WHERE pName= 'Mobile' AND spName='$sTp' ORDER BY rtID DESC LIMIT 1 ")or die(mysqli_error($con));	
																		$r=mysqli_fetch_array($q2);
																		$rt1=$r['purchasePrice'];
									/* SALES COST 					$saleCost=$saleCost+($slQty * $rt1);
																		
																		//echo $saleCost;
																	}

														$inHand=$opTotAmnt+$pAmntSum;
						/* MOBILE PROFIT/LOSS 		$MobProLoss=$sAmntSum - $saleCost;
						/* MOBILE CLOSING stock 		$mobClosingstock=$inHand-$saleCost;
						
	*/



	
/*-----<<<<<<<<<<<<<      GETTING SIM (CD) CLOSING AND VISIBILITY      >>>>>>>>>>>>-----*/
													
					$Prod='SIM';
					$sumAllOpenCost=0;	$sumAllPrCost=0;	$sumOpPrCost=0;	$sumTotSale=0;	$sumSaleCost=0;	$totalRemInvestSim=0;	
					
					
					$sql = mysqli_query($con,"SELECT typeName FROM types WHERE productName='$Prod' ")or die(mysqli_error($con));
					WHILE($Data=mysqli_fetch_array($sql))
					{
						$open=0;
						
						$subType=$Data['typeName'];
					// getting purchase price
							$q = mysqli_query($con,"SELECT purchasePrice from rates WHERE pName= '$Prod' AND spName='$subType' ORDER BY rtID DESC LIMIT 1 ")or die(mysqli_error($con));	
							$r=mysqli_fetch_array($q);
						$rt1=$r['purchasePrice'];
					
					// getting opening stock
							$q = mysqli_query($con,"SELECT * from openingclosing WHERE ocType= '$Prod' AND oMonth='$CurrentMonth' AND ocEmp='$subType' ORDER BY ocID DESC LIMIT 1 ")or die(mysqli_error($con));	
							$d=mysqli_fetch_array($q);
						$open=$d['ocAmnt'];
					
					// getting purchases during current month
							$q = mysqli_query($con,"SELECT sum(qty) from tbl_product_stock WHERE pSubType='$subType' AND trtype='Received' AND sDate BETWEEN '$QueryFD' AND '$QueryLD'  ")or die(mysqli_error($con));	
							$d=mysqli_fetch_array($q);
						$purchz=$d['sum(qty)'];
						
					// Opening Cost
						$opCost=$open * $rt1;
					// Purchases Cost
						$prCost=$purchz * $rt1;
					// Total Cost
						$totCost=$opCost + $prCost;
					
					// getting sale quantity, sale rate and sale amount
							
							$slAmnt=0; $Sumqt2=0; $Sumrt2=0; $totSale=0; $cnt=0; $avgrt=0; $saleCost=0;
							$q = mysqli_query($con,"SELECT * from tbl_product_stock WHERE pSubType='$subType' AND trtype='Sent' AND sDate BETWEEN '$QueryFD' AND '$QueryLD'  ")or die(mysqli_error($con));	
							WHILE($d=mysqli_fetch_array($q))
							{
								$qw = mysqli_query($con,"SELECT purchasePrice from rates WHERE pName= '$Prod' AND spName='$subType' ORDER BY rtID DESC LIMIT 1 ")or die(mysqli_error($con));	
								$rtw=mysqli_fetch_array($qw);
								$rtw=$r['purchasePrice'];
									$qt2=0;		$rt2=0;
									$qt2=$d['qty'];
									$rt2=$d['rate'];
									$totSale=$totSale+($qt2*$rt2);
									$saleCost=$saleCost+($qt2*$rtw);
									
							}
					$sumAllOpenCost=$sumAllOpenCost + $opCost;
					$sumAllPrCost=$sumAllPrCost + $prCost;
					$sumOpPrCost=$sumOpPrCost + $totCost;					// it is named as "Total Invest" in excel sheet
					
					$sumTotSale=$sumTotSale + $totSale;
					$sumSaleCost=$sumSaleCost + $saleCost;					// it is named as "Invest Sale" in excel sheet
					
					}
// Getting Collection Amount
							$q = mysqli_query($con,"SELECT sum(rpAmnt) from receiptpayment WHERE rpFor='$Prod' AND rpStatus='ReceivedFrom' AND rpDate BETWEEN '$QueryFD' AND '$QueryLD'  ")or die(mysqli_error($con));	
							$d=mysqli_fetch_array($q);
							$colSum=$d['sum(rpAmnt)'];
						
					$totalRemInvestSim=$sumOpPrCost-$sumSaleCost;	
					$CDinvest=	$sumOpPrCost-$colSum;
					
					$CDClosingstock=$totalRemInvestSim;
					$CDProLoss=$sumTotSale-$sumSaleCost;
//echo "<br><br><br>";
//echo $totalRemInvestSim;
					
					
					
					
					
					// Diagnostic Part
/*
				echo 'All Open Cost: '.$sumAllOpenCost;
				echo "<br>";
				echo 'All Purchases Cost: '.$sumAllPrCost;
				echo "<br>";
				echo 'All Open Purchz Cost: '.$sumOpPrCost;
				echo "<br>";
				echo 'Sum Total Sale: '.$sumTotSale;
				echo "<br>";
				echo 'Sum Sale Cost: '.$sumSaleCost;
				echo "<br>";
				echo 'Collection: '.$colSum;
				echo "<br>";
				echo 'Total Rem Invest: '.$totalRemInvest;
				echo "<br>";
				
*/

/*-----<<<<<<<<<<<<<      GETTING EXPENSES      >>>>>>>>>>>>-----*/

			$qury=mysqli_query($con,"SELECT sum(amnt) From fixedexp");
				$Data1=mysqli_fetch_array($qury);
				$fixedExpenses = $Data1['sum(amnt)'];
			
			$sqlexp = mysqli_query($con,"SELECT sum(amnt) FROM regularexp WHERE  type='expense' AND expDate BETWEEN '$QueryFD' AND '$QueryLD'")or die(mysqli_error($con));
				$Dataexp=mysqli_fetch_array($sqlexp);
				$regularExpenses=$Dataexp['sum(amnt)'];







/*-----<<<<<<<<<<<<<      GETTING salary      >>>>>>>>>>>>-----*/


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
									$q1=mysqli_query($con,"SELECT sum(loadAmnt) FROM tbl_mobile_load WHERE loadStatus='Sent' AND loadEmp='$Employee' AND loadDate BETWEEN '$QueryFD' AND '$QueryLD' ");
									$Data1=mysqli_fetch_array($q1);
									$load= $Data1['sum(loadAmnt)'];
									$otarComission=round(($load*$otarComissionRateEmp),0);
									//$otarComission=$load*$otarComissionEmp;
										if($otarComission=='')
											$otarComission=0;
														
									$q2=mysqli_query($con,"SELECT sum(comAmnt) FROM comission WHERE rp='Paid' AND comType='mfs Comission' AND comEmp='$Employee' AND comDate BETWEEN '$QueryFD' AND '$QueryLD' ");
									$Data2=mysqli_fetch_array($q2);
									$MFSComission=$Data2['sum(comAmnt)'];
										if($MFSComission=='')
											$MFSComission=0;
									
									$q2222=mysqli_query($con,"SELECT sum(comAmnt) FROM comission WHERE rp='Paid' AND comType='Market SIM Comission' AND comEmp='$Employee' AND comDate BETWEEN '$QueryFD' AND '$QueryLD' ");
									$Data2222=mysqli_fetch_array($q2222);
										$marketSimComission=$Data2222['sum(comAmnt)'];
										if($marketSimComission=='')
											$marketSimComission=0;
									
									$q2333=mysqli_query($con,"SELECT sum(comAmnt) FROM comission WHERE rp='Paid' AND comType='Activity SIM Comission' AND comEmp='$Employee' AND comDate BETWEEN '$QueryFD' AND '$QueryLD' ");
									$Data2333=mysqli_fetch_array($q2333);
										$activitySimComission=$Data2333['sum(comAmnt)'];
										if($activitySimComission=='')
											$activitySimComission=0;
									
									$q2444=mysqli_query($con,"SELECT sum(comAmnt) FROM comission WHERE rp='Paid' AND comType='Device+Handset Comission' AND comEmp='$Employee' AND comDate BETWEEN '$QueryFD' AND '$QueryLD' ");
									$Data2444=mysqli_fetch_array($q2444);
										$deviceHandsetComission=$Data2444['sum(comAmnt)'];
										if($deviceHandsetComission=='')
											$deviceHandsetComission=0;
									
									$q2555=mysqli_query($con,"SELECT sum(comAmnt) FROM comission WHERE rp='Paid' AND comType='PostPaid Comission' AND comEmp='$Employee' AND comDate BETWEEN '$QueryFD' AND '$QueryLD' ");
									$Data2555=mysqli_fetch_array($q2555);
										$postPaidComission=$Data2555['sum(comAmnt)'];
										if($postPaidComission=='')
											$postPaidComission=0;
									
									$q3=mysqli_query($con,"SELECT sum(comAmnt) FROM comission WHERE rp='Paid' AND comType='Other Comission' AND comEmp='$Employee' AND comDate BETWEEN '$QueryFD' AND '$QueryLD' ");
									$Data3=mysqli_fetch_array($q3);
										$otherComission=$Data3['sum(comAmnt)'];
										if($otherComission=='')
											$otherComission=0;
									$q45=mysqli_query($con,"SELECT sum(comAmnt) FROM comission WHERE rp='$CurrentMonth' AND comType='Salary Deduction' AND comEmp='$Employee'");
									$Data45=mysqli_fetch_array($q45);
									$deduction=$Data45['sum(comAmnt)'];
							
									$grossSal=($basicSal+$otarComission+$MFSComission+$marketSimComission+$activitySimComission+$deviceHandsetComission+$postPaidComission+$otherComission)-$deduction;

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
$ThisMonthsalary=$sumGrossSal;
	
	//$qu = mysqli_query($con,"SELECT sum(amnt) from incomeexp WHERE type='expense' AND status='Paid' AND expDate BETWEEN '$QueryFD' AND '$QueryLD'  ")or die(mysqli_error($con));	
	//	$d=mysqli_fetch_array($qu);
//$ThisMonthExp=$d['sum(amnt)'];	

//$salExp=$ThisMonthsalary+$ThisMonthExp;
$salExp=$ThisMonthsalary+$fixedExpenses;

$accountPayable=$salExp;
	
	/*
	
	$qu1 = mysqli_query($con,"SELECT sum(amnt) from incomeexp WHERE type='expense' AND expDate BETWEEN '$QueryFD' AND '$QueryLD'  ")or die(mysqli_error($con));	
		$d1=mysqli_fetch_array($qu1);
	$ThisMonthExp=$d1['sum(amnt)'];	

	$salExp=$ThisMonthsalary+$ThisMonthExp;

*/
	
	
	
	
	
	
	
	
	
	$totalVisibil=$otherComissionReceived+$netProfit+$mfsProfits+$cardPL+$MobProLoss+$CDProLoss-$taxAmnt;						
	$netVisibil= $totalVisibil-$salExp-$regularExpenses;					

	
	
	
	/*-----<<<<<<<<<<<<<      Bank Closing      >>>>>>>>>>>>-----*/
	$NameHere=$defaultBankName;
	//echo "<br /><br /><br />".$NameHere;
			$sq6 = mysqli_query($con,"SELECT ocAmnt FROM openingclosing where oMonth='$CurrentMonth' AND ocType='Cash' AND ocEmp='$NameHere'  ")or die(mysqli_error($con));
													$Data6=mysqli_fetch_array($sq6);
													
													$Opening=$Data6['ocAmnt'];
													$depositSum=0; $wDrawsum=0; $paySum=0; $orgDepositSum=0;
													for($i=$date_from; $i<=$date_to; $i+=86400)
													{
													$cd=date("Y-m-d", $i);$q=mysqli_query($con,"SELECT sum(rpAmnt) FROM receiptpayment WHERE rpDate ='$cd' AND rpStatus='ReceivedFrom' AND rpmode='$NameHere' ");
														$Data=mysqli_fetch_array($q);
														$amntDeposit=$Data['sum(rpAmnt)'];
													$q=mysqli_query($con,"SELECT sum(rpAmnt) FROM receiptpayment WHERE rpDate ='$cd' AND rpStatus='PaidTo' AND rpmode='$NameHere' AND (rpFor='Withdraw' OR rpFor='DO Dues') ");
														$Data=mysqli_fetch_array($q);
														$amntWDraw=$Data['sum(rpAmnt)'];
														$orgDeposit=$amntDeposit-$amntWDraw;
													$q=mysqli_query($con,"SELECT sum(rpAmnt) FROM receiptpayment WHERE rpDate ='$cd' AND rpStatus='PaidTo' AND rpmode='$NameHere' AND rpFor!='Withdraw' AND rpFor!='DO Dues'");
														$Data=mysqli_fetch_array($q);
														$amntPay=$Data['sum(rpAmnt)'];
														$closing= ($Opening+$amntDeposit)-($amntWDraw+$amntPay);
														$Opening=$closing;
													$depositSum=$depositSum+$amntDeposit;
													$orgDepositSum=$orgDepositSum+$orgDeposit;
													$wDrawsum=$wDrawsum+$amntWDraw;
													$paySum= $paySum+$amntPay;
													}
			$BankClosing=$Opening;
			//echo $BankClosing;
/*-----<<<<<<<<<<<<<      DO Dues      >>>>>>>>>>>>-----*/


///////// Only Defaulter's Due

$check="Defaulter";

$Q1=mysqli_query($con,"SELECT ocAmnt From openingclosing WHERE ocEmp='$check' AND oMonth='$CurrentMonth' AND ocType='DO Dues'  ");
$Data1=mysqli_fetch_array($Q1);
$DefaulterDueOpening = $Data1['ocAmnt'];


$Q2=mysqli_query($con,"SELECT sum(rpAmnt) FROM receiptpayment WHERE rpFor ='DO Dues' AND rpStatus='PaidTo' AND rpFromTo='$check' AND rpDate BETWEEN '$QueryFD' AND '$QueryLD' ");
$Data2=mysqli_fetch_array($Q2);
$DefaulterDueGiven= $Data2['sum(rpAmnt)'];


$Q3=mysqli_query($con,"SELECT sum(rpAmnt) FROM receiptpayment WHERE rpFor ='DO Dues' AND rpStatus='ReceivedFrom' AND rpFromTo='$check' AND rpDate BETWEEN '$QueryFD' AND '$QueryLD' ");
$Data3=mysqli_fetch_array($Q3);
$DefaulterDueTaken= $Data3['sum(rpAmnt)'];

$DefaulterDueClosing=$DefaulterDueOpening+$DefaulterDueGiven-$DefaulterDueTaken;
	
	
	/*?????????????????
	Yahan Sy Har Aik head (i.e Do Dues, Cash, SIM, Mobile etc) k liay alag alag
	opening + given - taken k formula sy closing nikal k alag alag show karwain aur phr mila k net DO Dues likhain
	???????????*/
	
	$totalCash=0;
	$totalCard=0;
	$totalMobile=0;
	$totalSIM=0;
	$totalDoDues=0;
	$totalDue=0;
	$totalOpen=0;
	$totalSale=0;
	$totalTaken=0;
	$totalClose=0;
	$SalDueAmnt=0;
	$ProfitDueAmnt=0;
	
	$doQ=mysqli_query($con,"SELECT EmpName from empinfo ");
				while($data00=mysqli_fetch_array($doQ))
				{	
							$Employee=$data00['EmpName'];
					$thisEmpDue=0;
					
					// openings
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
												
					// Sales
							$sumLoad=0;	$sumTransfer=0;	$sumProfit=0; $sumSend=0; $sumReceive=0; $sumClose=0; $sumQty=0; $sumOrgAmnt=0; $sumSaleRate=0; $sumAmnt=0; $sumProLoss=0;
							$sumReceivable=0; $sumTaken=0;	

							
									$q2=mysqli_query($con,"SELECT sum(loadAmnt) FROM tbl_mobile_load WHERE loadStatus='Sent' AND loadEmp='$Employee' AND loadDate BETWEEN '$QueryFD' AND '$QueryLD' ");
									$Data2=mysqli_fetch_array($q2);
							$load= $Data2['sum(loadAmnt)'];
														
									$q3=mysqli_query($con,"SELECT sum(mfsAmnt) FROM tbl_financial_service WHERE mfsStatus='Sent' AND mfsEmp='$Employee' AND mfsDate BETWEEN '$QueryFD' AND '$QueryLD' ");
									$Data3=mysqli_fetch_array($q3);
							
							$mfsSend= $Data3['sum(mfsAmnt)'];
									
									
									$q4=mysqli_query($con,"SELECT sum(mfsAmnt) FROM tbl_financial_service WHERE mfsStatus='Received' AND mfsEmp='$Employee' AND mfsDate BETWEEN '$QueryFD' AND '$QueryLD' ");
									$Data4=mysqli_fetch_array($q4);
							$mfsReceive = $Data4['sum(mfsAmnt)'];
							$mfsClose = $mfsSend-$mfsReceive;
					
									
									$q5=mysqli_query($con,"SELECT sum(csTotalAmnt) FROM tbl_cards WHERE csStatus='Sent' AND csEmp='$Employee' AND csDate BETWEEN '$QueryFD' AND '$QueryLD' ");
									$Data5=mysqli_fetch_array($q5);
							$csamount= $Data5['sum(csTotalAmnt)'];
					
							
							
							$receivable= $load+$mfsClose+$csamount+$opening;		
					// calculating mobile sold to emp
							$sAmntSum0=0;
							$sq6 = mysqli_query($con,"SELECT typeName FROM types WHERE productName='Mobile'")or die(mysqli_error($con));
								WHILE($Data6=mysqli_fetch_array($sq6))
								{
									$subType=$Data6['typeName'];
									$slAmnt=0; $qt2=0; $rt2=0; $sumQt=0;
									$q7 = mysqli_query($con,"SELECT * from tbl_product_stock WHERE pSubType='$subType' AND trtype='Sent' AND customer='$Employee' AND sDate BETWEEN '$QueryFD' AND '$QueryLD'  ")or die(mysqli_error($con));	
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
							$sq8 = mysqli_query($con,"SELECT typeName FROM types WHERE productName='SIM'")or die(mysqli_error($con));
								WHILE($Data8=mysqli_fetch_array($sq8))
								{
									$subType=$Data8['typeName'];
									$slAmnt=0; $qt2=0; $rt2=0; $sumQt=0;
									$q9 = mysqli_query($con,"SELECT * from tbl_product_stock WHERE pSubType='$subType' AND trtype='Sent' AND customer='$Employee' AND sDate BETWEEN '$QueryFD' AND '$QueryLD'  ")or die(mysqli_error($con));	
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
				
				
				// Received
								
							$q11=mysqli_query($con,"SELECT sum(rpAmnt) FROM receiptpayment WHERE rpFor ='LMC' AND rpStatus='ReceivedFrom' AND rpFromTo='$Employee' AND rpDate BETWEEN '$QueryFD' AND '$QueryLD' ");
									$Data11=mysqli_fetch_array($q11);
								$takenlmc= $Data11['sum(rpAmnt)'];		
							
							$q111=mysqli_query($con,"SELECT sum(rpAmnt) FROM receiptpayment WHERE rpFor ='Card' AND rpStatus='ReceivedFrom' AND rpFromTo='$Employee' AND rpDate BETWEEN '$QueryFD' AND '$QueryLD' ");
									$Data111=mysqli_fetch_array($q111);
								$takeCard= $Data111['sum(rpAmnt)'];
					
					
							$q12=mysqli_query($con,"SELECT sum(rpAmnt) FROM receiptpayment WHERE rpFor ='mobile' AND rpStatus='ReceivedFrom' AND rpFromTo='$Employee' AND rpDate BETWEEN '$QueryFD' AND '$QueryLD' ");
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
					
					$totalOpen=0;
					$totalSale=0;
					$totalTaken=0;
					$totalClose=0;		
					
					
					
					$dues= $receivable-$taken;
					$CashClose=($openCash+$load+$mfsClose+$csamount) - $takenlmc;
					$DueClose=($openingDue + $givendo) - $takendo;
					$thisEmpDue=$CashClose+$DueClose;
					
					
					if($Employee=='DueSalary')					/// here DueSalary DO Dues account and DueProfit DO Dues accnt will be captured for further processing
						//$SalDueAmnt=$takendo;
						$SalDueAmnt=$thisEmpDue;
					if($Employee=='DueProfit')
						$ProfitDueAmnt=$thisEmpDue*(-1);
					
					//$totalDue=$totalDue +$thisEmpDue;
					
					
				$totalCash=$totalCash+($openCash+$load+$mfsClose-$takenlmc);							// total cash transactions
				$totalCard=$totalCard+($openCardCash+$csamount-$takeCard);								// total cards
				$totalMobile=$totalMobile+($openMobileCash+$sAmntSum0-$takenMbl);						// total mobile
				$totalSIM=$totalSIM+($openSIMCash+$sAmntSum1-$takenSIM);								// total sim
				$totalDoDues=$totalDoDues+(($openingDue+$givendo)-$takendo);							// total do
				
				/*
					echo $Employee;
					echo " ** ";
					echo $openingDue;
					echo " ** ";
					echo $givendo;
					echo " ** ";
					echo $takendo;
					echo " ** ";
					echo $totalDoDues;
					echo "<br>";
					
					echo " + ";
					echo $DueClose;
					echo " = ";
					echo $thisEmpDue;
					echo "--";
					echo $totalDue;
					echo "<br>";
					*/
				}
				
				$totalDue=$totalCash+$totalCard+$totalMobile+$totalSIM+$totalDoDues;					// total all above
				
				
				$totalAccntRP=$totalCash+$totalCard+$totalMobile+$totalSIM;					// total all above less DO Dues
				$DODue=$totalDoDues;                                                    //  separated DO Dues
				
				
				$remainingDoDues=$totalDue-$DefaulterDueClosing;
				$LmcMblSim=$totalCash+$totalCard+$totalMobile+$totalSIM;
				
//Petty Cash
			//petty Opening    means required amount for previous month salary and expenses
				$qe1=mysqli_query($con,"SELECT ocAmnt From openingclosing WHERE ocType='Petty Cash' AND oMonth='$CurrentMonth' ");
					$Date1=mysqli_fetch_array($qe1);
						$pettyOpen=$Date1['ocAmnt'];

			//petty Added  means now alloted amount from bank to petty for payment of last month salary an expenses
				$qe2=mysqli_query($con,"SELECT sum(amnt) From petty WHERE status='Add' AND type='Petty' AND date BETWEEN '$QueryFD' AND '$QueryLD' ");
					$Date2=mysqli_fetch_array($qe2);
						$pettyAdd=$Date2['sum(amnt)'];
			//petty Subtracted means utilized amount for payment of salary and expenses
				$qe3=mysqli_query($con,"SELECT sum(amnt) From petty WHERE status='Sub' AND type='Petty' AND date BETWEEN '$QueryFD' AND '$QueryLD' ");
					$Date3=mysqli_fetch_array($qe3);
						$pettySub=$Date3['sum(amnt)'];		// means utilized amount
			
			$pettyRemain=$pettyAdd-$pettySub;
			
			// petty Gross
				$pettyGross=($pettyOpen-$pettyAdd);

			// New Salary + New Exp + Remaining Petty
								
				$pettyClosing=$pettyGross+$salExp;
				
//original		$netdodues=$totalDue - $Data['ocAmnt'];
				//$netdodues=$totalDue - $pettyGross;
				//$netdodues=$totalDue - $pettyGross-$tempDoDuesAdjustment;
				$netdodues=$totalDue - $pettyGross;

			//echo "<br><br><br><br>ok<br>". $pettyRemain;			// Test Output
				
/*-----<<<<<<<<<<<<<      investment MODULE      >>>>>>>>>>>>-----*/			
			
	// Opening investment for the month	
			$sqi = mysqli_query($con,"SELECT ocAmnt FROM openingclosing WHERE oMonth='$CurrentMonth' AND ocType='investment' ")or die(mysqli_error($con));
				$Datai=mysqli_fetch_array($sqi);
				$initialInvest=$Datai['ocAmnt'];
				
	// This Month investment
			$sqc = mysqli_query($con,"SELECT sum(amnt) FROM investment WHERE type='Invest' AND date BETWEEN '$QueryFD' AND '$QueryLD' ")or die(mysqli_error($con));
				$Datac=mysqli_fetch_array($sqc);
				$currentInvest=$Datac['sum(amnt)'];
	// This Month Withdraw
			$sqw = mysqli_query($con,"SELECT sum(amnt) FROM investment WHERE type='Withdraw' AND date BETWEEN '$QueryFD' AND '$QueryLD' ")or die(mysqli_error($con));
				$Dataw=mysqli_fetch_array($sqw);
				$currentWithdraw=$Dataw['sum(amnt)'];
	// Curent investment
				$currentinvestment=($initialInvest+$currentInvest) - $currentWithdraw;
				
				
				
	// Total investment
			//$totalinvestment=($OtarInvestLessMargin+$mfsinvestment+$cardClosingInvest+$mobClosingstock+$CDClosingstock+$BankClosing+$netdodues)-$accountPayable;
			//$totalinvestment=($OtarInvestLessMargin+$mfsinvestment+$cardClosingInvest+$mobClosingstock+$CDClosingstock+$BankClosing+$netdodues);
			$totalinvestment=($OtarInvestLessMargin+$mfsinvestment+$cAmntSum+$mobClosingstock+$CDClosingstock+$BankClosing+$netdodues); // temp adjust 569505
	// Current Active investment
			//$currentActiveInvest=$totalinvestment;
	// Org Invest
			
			$orgInvest=$totalinvestment-$totalVisibil;
	// Closing Difference
			//$closingDiff=$orgInvest-$currentinvestment;
			$closingDiff=$orgInvest-$currentinvestment;
			
/*-----<<<<<<<<<<<<<      PENDING SALARIES      >>>>>>>>>>>>-----*/
									$year  = date('Y');
									$month = date('m');
									$date = mktime( 0, 0, 0, $month, 1, $year );
									$preMonth=strftime( '%b-%Y', strtotime( '-1 month', $date ));
			$sq = mysqli_query($con,"SELECT sum(netSal) FROM salary WHERE empName!='Profit' AND status='Pending' AND salMonth='$preMonth' ")or die(mysqli_error($con));
				$Datac=mysqli_fetch_array($sq);
				$pendingSalaries=$Datac['sum(netSal)'];
			/*$sq2 = mysqli_query($con,"SELECT sum(netSal) FROM salary WHERE empName='Profit' AND status='Pending' AND salMonth='$preMonth' ")or die(mysqli_error($con));
				$Da=mysqli_fetch_array($sq2);
				$pendingProfit=$Da['sum(netSal)'];*/
			$sq22 = mysqli_query($con,"SELECT sum(amnt) FROM dueexp WHERE expMonth='$preMonth' AND status='Pending' ")or die(mysqli_error($con));
				$Datac22=mysqli_fetch_array($sq22);
				$pendingExpenses=$Datac22['sum(amnt)'];
				
				
				$pendSalExp=$pendingSalaries+$pendingExpenses;
				
												$sq5 = mysqli_query($con,"SELECT ocAmnt FROM openingclosing where oMonth='$CurrentMonth' AND ocType='Profit' AND ocEmp='Franchise'  ")or die(mysqli_error($con));
													$Data5=mysqli_fetch_array($sq5);
													$OpeningProfit=$Data5['ocAmnt'];
												$q=mysqli_query($con,"SELECT sum(rpAmnt) FROM receiptpayment WHERE rpFor='ProfitAdd' AND rpStatus='ReceivedFrom' AND rpFromTo='ProfitAdd' AND rpDate BETWEEN $QueryFD AND $QueryLD");
															$Data=mysqli_fetch_array($q);
															$amntAdded=$Data['sum(rpAmnt)'];
												$q2=mysqli_query($con,"SELECT sum(rpAmnt) FROM receiptpayment WHERE rpFor='Withdraw' AND rpStatus='PaidTo' AND rpFromTo='ProfitSub' AND rpDate BETWEEN $QueryFD AND $QueryLD ");
															$Data2=mysqli_fetch_array($q2);
															$amntSub=$Data2['sum(rpAmnt)'];
														
															$closingprofit= ($OpeningProfit+$amntAdded)-$amntSub;
																		
				$pendingProfit=$ProfitDueAmnt;
				
?>