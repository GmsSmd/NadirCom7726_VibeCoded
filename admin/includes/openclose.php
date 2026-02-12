<?php
include_once('includes/dbcon.php');
include_once('includes/getsummary.php');
include_once('globalvar.php');

// GETTING OTAR OPENING BALANCE
		$FrOpeningOtar=mysqli_query($con,"SELECT ocAmnt From openingclosing WHERE ocEmp='Franchise' AND oMonth='$CurrentMonth' AND ocType='Otar'  ");
		$Data=mysqli_fetch_array($FrOpeningOtar);
		$FrOtarOpening = $Data['ocAmnt'];

// GETTING OTAR lifting
		$Frtarget=mysqli_query($con,"SELECT sum(loadAmnt) FROM tbl_mobile_load WHERE loadStatus='Received' AND loadEmp='$parentCompany' AND (loadDate Between '$QueryFD' AND '$QueryLD') ");
		$Data=mysqli_fetch_array($Frtarget);
		$FrOtarLift = $Data['sum(loadAmnt)'];
			$inHand=$FrOtarOpening+$FrOtarLift;

// GETTING OTAR CLOSING
		$q=mysqli_query($con,"SELECT sum(loadTransfer) FROM tbl_mobile_load WHERE loadStatus='Sent' AND (loadDate Between '$QueryFD' AND '$QueryLD')  ");
		$Data=mysqli_fetch_array($q);
		$FrOtarSale = $Data['sum(loadTransfer)'];
			$FrOtarClosing=$inHand-$FrOtarSale;

// GETTING MFS OPENING BALANCE
		$FrOpeningmfs=mysqli_query($con,"SELECT ocAmnt From openingclosing WHERE ocEmp='Franchise' AND oMonth='$CurrentMonth' AND ocType='mfs'  ");
		$Data=mysqli_fetch_array($FrOpeningmfs); 
		$FrmfsOpening = $Data['ocAmnt'];		
			
// GETTING MFS lifting
		$mfs=mysqli_query($con,"SELECT sum(mfsAmnt) FROM tbl_financial_service WHERE mfsEmp='$parentCompany' AND mfsStatus='Received' AND mfsDate BETWEEN '$QueryFD' AND '$QueryLD' ");
		$Data=mysqli_fetch_array($mfs); 
		$mfsLiftng = $Data['sum(mfsAmnt)'];

// GETTING MFS Sending
		$mfs1=mysqli_query($con,"SELECT sum(mfsAmnt) FROM tbl_financial_service WHERE mfsStatus='Sent' AND mfsDate BETWEEN '$QueryFD' AND '$QueryLD' ");
		$Data=mysqli_fetch_array($mfs1); 
		$mfsSent = $Data['sum(mfsAmnt)'];
		
// GETTING MFS Receiving
		$mfs2=mysqli_query($con,"SELECT sum(mfsAmnt) FROM tbl_financial_service WHERE mfsEmp!='$parentCompany' AND mfsStatus='Received' AND mfsDate BETWEEN '$QueryFD' AND '$QueryLD' ");
		$Data=mysqli_fetch_array($mfs2); 
		$mfsReceive = $Data['sum(mfsAmnt)'];

// GETTING MFS Cmission
		$mfsProfit=mysqli_query($con,"SELECT sum(comAmnt) From comission WHERE rp='Received' AND comType='MFS Comission' AND comDate BETWEEN '$QueryFD' AND '$QueryLD' ");
		$Data=mysqli_fetch_array($mfsProfit); 
		$mfsComission = $Data['sum(comAmnt)'];

		$mfsClose=($FrmfsOpening+$mfsLiftng+$mfsReceive+$mfsComission)-$mfsSent;

		
		
/*-----<<<<<<<<<<<<<      investment MODULE      >>>>>>>>>>>>-----*/			
			
	// Opening investment for the month	
			$sqi = mysqli_query($con,"SELECT ocAmnt FROM openingclosing WHERE oMonth='$CurrentMonth' AND ocType='investment' ")or die(mysqli_query());
				$Datai=mysqli_fetch_array($sqi);
				$initialInvest=$Datai['ocAmnt'];
				
	// This Month investment
			$sqc = mysqli_query($con,"SELECT sum(amnt) FROM investment WHERE type='Invest' AND date BETWEEN '$QueryFD' AND '$QueryLD' ")or die(mysqli_query());
				$Datac=mysqli_fetch_array($sqc);
				$currentInvest=$Datac['sum(amnt)'];
				
	// This Month Withdraw
			$sqw = mysqli_query($con,"SELECT sum(amnt) FROM investment WHERE type='Withdraw' AND date BETWEEN '$QueryFD' AND '$QueryLD' ")or die(mysqli_query());
				$Dataw=mysqli_fetch_array($sqw);
				$currentWithdraw=$Dataw['sum(amnt)'];
				
	// Curent investment
				$currentinvestment=($initialInvest+$currentInvest) - $currentWithdraw;
				
				
				
	// Total investment
			$totalinvestment=$OtarInvestLessMargin+$mfsinvestment+$cardClosingInvest+$mobClosingstock+$CDClosingstock+$BankClosing+$netdodues;
	// Current Active investment
			$currentActiveInvest=$totalinvestment;
	// Org Invest
			$orgInvest=$currentActiveInvest-$totalVisibil;
			
	// Closing Difference
			$closingDiff=$orgInvest-$currentinvestment;
			
			
			
if (isset($_POST['SaveClosing']))
		{
		    ini_set('max_execution_time', '600');
			$closingMonth=$_POST['cMonthSelect'];
			$openingMonth=$_POST['oMonthSelect'];
		
//investment		Inserting investment
				$sq = mysqli_query($con," INSErt INTO openingclosing (cMonth, oMonth, ocType, ocEmp, ocAmnt, savedBy, savingDateTime) VALUES('$closingMonth','$openingMonth','Investment','Franchise',$currentinvestment,'$currentUser','$dateNow') ")or die(mysqli_query());
		
//Otar				Inserting Otar Closing
				$sq = mysqli_query($con," INSErt INTO openingclosing (cMonth, oMonth, ocType, ocEmp, ocAmnt, savedBy, savingDateTime) VALUES('$closingMonth','$openingMonth','Otar','Franchise',$FrOtarClosing,'$currentUser','$dateNow') ")or die(mysqli_query());
				
//MFSInserting 		MFS Closing
				$sq = mysqli_query($con," INSErt INTO openingclosing (cMonth, oMonth, ocType, ocEmp, ocAmnt, savedBy, savingDateTime) VALUES('$closingMonth','$openingMonth','MFS','Franchise',$mfsClose,'$currentUser','$dateNow') ")or die(mysqli_query());	
		
			
			
			// Inserting Card Closing
					$opQtySum=0; $opAmntSum=0; $pQtySum=0; $pAmntSum=0; $sQtySum=0;
					$sAmntSum=0; $cQtySum=0; $cAmntSum=0; $colSum=0;
					$sql = mysqli_query($con,"SELECT typeName FROM types WHERE productName='Card'")or die(mysqli_query());
					WHILE($Data=mysqli_fetch_array($sql))
					{
						$subType=$Data['typeName'];
					
						$q = mysqli_query($con,"SELECT * from openingclosing WHERE ocType= 'Card' AND oMonth='$CurrentMonth' AND ocEmp='$subType' ORDER BY ocID DESC LIMIT 1 ")or die(mysqli_query());	
							$d=mysqli_fetch_array($q);
								$open=$d['ocAmnt'];				// opening quantity
						
						$q = mysqli_query($con,"SELECT purchasePrice from rates WHERE pName= 'Card' AND spName='$subType' ORDER BY rtID DESC LIMIT 1 ")or die(mysqli_query());	
							$r=mysqli_fetch_array($q);
								$rt1=$r['purchasePrice'];		// Rate
								$opAmnt= $open * $rt1;			// Opening Amount
						$q = mysqli_query($con,"SELECT sum(csQty) from tbl_cards WHERE csType='$subType' AND csStatus='Received' AND csDate BETWEEN '$QueryFD' AND '$QueryLD'  ")or die(mysqli_query());	
							$d=mysqli_fetch_array($q);
								$purchz=$d['sum(csQty)'];		// Purchase
						
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
						
							$cl=$open + $purchz - $sumQt;
					
//Card
					if($cl!=0 OR $cl!="")
					
						$sq = mysqli_query($con," INSErt INTO openingclosing (cMonth, oMonth, ocType, ocEmp, ocAmnt, savedBy, savingDateTime) VALUES('$closingMonth','$openingMonth','Card','$subType',$cl,'$currentUser','$dateNow') ")or die(mysqli_query());
					}
		
			// Inserting Mobile Closing
					$opQtySum=0; $opAmntSum=0; $pQtySum=0; $pAmntSum=0; $sQtySum=0;
					$sAmntSum=0; $cQtySum=0; $cAmntSum=0; $colSum=0;
					$sql = mysqli_query($con,"SELECT typeName FROM types WHERE productName='Mobile'")or die(mysqli_query());
					WHILE($Data=mysqli_fetch_array($sql))
					{
						$subType=$Data['typeName'];
						
						$q1 = mysqli_query($con,"SELECT * from openingclosing WHERE ocType= 'Mobile' AND oMonth='$CurrentMonth' AND ocEmp='$subType' ORDER BY ocID DESC LIMIT 1 ")or die(mysqli_query());	
							$d=mysqli_fetch_array($q1);
								$open=$d['ocAmnt'];				// opening quantity
						
						$q2 = mysqli_query($con,"SELECT purchasePrice from rates WHERE pName= 'Mobile' AND spName='$subType' ORDER BY rtID DESC LIMIT 1 ")or die(mysqli_query());	
							$r=mysqli_fetch_array($q2);
								$rt1=$r['purchasePrice'];		// Rate
								$opAmnt= $open * $rt1;			// Opening Amount
						$q3 = mysqli_query($con,"SELECT sum(qty) from tbl_product_stock WHERE pSubType='$subType' AND trtype='Received' AND sDate BETWEEN '$QueryFD' AND '$QueryLD'  ")or die(mysqli_query());	
							$d=mysqli_fetch_array($q3);
							$purchz=$d['sum(qty)'];				// Purchase
						
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
						
							$cl=$open + $purchz - $sumQt;
							$clAmnt=$cl * $rt1;
//Mobile
					if($cl!=0 OR $cl!="")
						$sq = mysqli_query($con," INSErt INTO openingclosing (cMonth, oMonth, ocType, ocEmp, ocAmnt, savedBy, savingDateTime) VALUES('$closingMonth','$openingMonth','Mobile','$subType',$cl,'$currentUser','$dateNow') ")or die(mysqli_query());
					}
	
			// Inserting SIM Closing
					$opQtySum=0; $opAmntSum=0; $pQtySum=0; $pAmntSum=0; $sQtySum=0;
					$sAmntSum=0; $cQtySum=0; $cAmntSum=0; $colSum=0;
					$sql = mysqli_query($con,"SELECT typeName FROM types WHERE productName='SIM'")or die(mysqli_query());
					WHILE($Data=mysqli_fetch_array($sql))
					{
						$subType=$Data['typeName'];
						
						$q1 = mysqli_query($con,"SELECT * from openingclosing WHERE ocType= 'SIM' AND oMonth='$CurrentMonth' AND ocEmp='$subType' ORDER BY ocID DESC LIMIT 1 ")or die(mysqli_query());	
							$d=mysqli_fetch_array($q1);
								$open=$d['ocAmnt'];				// opening quantity
						
						$q2 = mysqli_query($con,"SELECT purchasePrice from rates WHERE pName= 'SIM' AND spName='$subType' ORDER BY rtID DESC LIMIT 1 ")or die(mysqli_query());	
							$r=mysqli_fetch_array($q2);
								$rt1=$r['purchasePrice'];		// Rate
								$opAmnt= $open * $rt1;			// Opening Amount
						
						$q3 = mysqli_query($con,"SELECT sum(qty) from tbl_product_stock WHERE pSubType='$subType' AND trtype='Received' AND sDate BETWEEN '$QueryFD' AND '$QueryLD'  ")or die(mysqli_query());	
							$d=mysqli_fetch_array($q3);
							$purchz=$d['sum(qty)'];				// Purchase
						
								$prAmnt=$purchz*$rt1;			// Purchase Amount
						
						$slAmnt=0; $qt2=0; $rt2=0; $sumQt=0; $cnt=0; $avgrt=0;
						$q5 = mysqli_query($con,"SELECT * from tbl_product_stock WHERE pSubType='$subType' AND trtype='Sent' AND sDate BETWEEN '$QueryFD' AND '$QueryLD'  ")or die(mysqli_query());	
							WHILE($d5=mysqli_fetch_array($q5))
							{
								$qt2=$d5['qty'];
								$rt2=$d5['rate'];
								$sumQt=$sumQt+$qt2;
								$slAmnt=$slAmnt+($qt2*$rt2);
							}
						
							$cl=$open + $purchz - $sumQt;
							$clAmnt=$cl * $rt1;
//SIM
					if($cl!=0 OR $cl!="")
						$sq = mysqli_query($con," INSErt INTO openingclosing (cMonth, oMonth, ocType, ocEmp, ocAmnt, savedBy, savingDateTime) VALUES('$closingMonth','$openingMonth','SIM','$subType',$cl,'$currentUser','$dateNow') ")or die(mysqli_query());
					}


		
		//-----<<<<<<<<<<<<<      DO RECEIVABLES MODULE      >>>>>>>>>>>>-----

					
							$sumOpenCash=0; $sumOpenCard=0; $sumOpenMobile=0; $sumOpenSIM=0; $sumOpenDue=0; $sumLoad=0; $sumClose=0; $sumAmnt=0; $mobSum=0;
							$simSum=0; $sumGivendo=0;  $sumLMCTaken=0;	$sumCardTaken=0; $sumMblTaken=0; $sumTakenSIM=0;	$sumTakendo=0;
							$sumCashClose=0; $sumCardClose=0; $sumMblClose=0; $sumSIMclose=0; $sumDueClose=0;
										
		$doQ=mysqli_query($con,"SELECT EmpName from empinfo WHERE EmpStatus='Active' OR EmpStatus='Dfltr';");
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
												
												

							// RECEIVABLE MODULE start										??????????? yahan par abi SIM , Mobile etc ki b sale activity shamil honi chahye
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
													$takenlmc= $Data11['sum(rpAmnt)'];		
										
										
										$q101=mysqli_query($con,"SELECT sum(rpAmnt) FROM receiptpayment WHERE rpFor ='Card' AND rpStatus='ReceivedFrom' AND rpFromTo='$Employee' AND rpDate BETWEEN '$QueryFD' AND '$QueryLD' ");
														$Data101=mysqli_fetch_array($q101);
													$takenCard= $Data101['sum(rpAmnt)'];		
										
										
												
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
							}
							// RECEIVED MODULE End			
								

							// CLOSING MODULE start
							{	
												$dues= $receivable-$taken;
							
												$CashClose=($openCash+$load+$mfsClose) - $takenlmc;
															
												$cardClose=($openCardCash+$sAmountCard)-$takenCard;
										
												$MobileClose=($openMobileCash+$sAmntSum0) - $takenMbl;
															
												$SIMClose=($openSIMCash+$sAmntSum1) - $takenSIM;
															
												$DueClose=$openingDue + $givendo - $takendo;
	//echo $Employee."-->>Card<<--".$openCardCash." + ".$sAmountCard." - ".$takenCard." = ".$cardClose."<br>";							
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
												$sumCashClose=$sumCashClose+$CashClose;
												$sumCardClose=$sumCardClose+$cardClose;
												$sumMblClose=$sumMblClose+$MobileClose;
												$sumSIMclose=$sumSIMclose+$SIMClose;
												$sumDueClose=$sumDueClose+$DueClose;
												
							}
									
								
					//Cash LMC
											if($CashClose!=0)
												$sq = mysqli_query($con," INSERT INTO openingclosing (cMonth, oMonth, ocType, ocEmp, ocAmnt, savedBy, savingDateTime) VALUES('$closingMonth','$openingMonth','Cash','$Employee',$CashClose,'$currentUser','$dateNow') ")or die(mysqli_query());
					//Card
											if($cardClose!=0)
												$sq = mysqli_query($con," INSERT INTO openingclosing (cMonth, oMonth, ocType, ocEmp, ocAmnt, savedBy, savingDateTime) VALUES('$closingMonth','$openingMonth','Card','$Employee',$cardClose,'$currentUser','$dateNow') ")or die(mysqli_query());				
					//Mobile
											if($MobileClose!=0)
												$sq = mysqli_query($con," INSERT INTO openingclosing (cMonth, oMonth, ocType, ocEmp, ocAmnt, savedBy, savingDateTime) VALUES('$closingMonth','$openingMonth','Mobile','$Employee',$MobileClose,'$currentUser','$dateNow') ")or die(mysqli_query());
					//SIM					
											if($SIMClose!=0)
												$sq = mysqli_query($con," INSERT INTO openingclosing (cMonth, oMonth, ocType, ocEmp, ocAmnt, savedBy, savingDateTime) VALUES('$closingMonth','$openingMonth','SIM','$Employee',$SIMClose,'$currentUser','$dateNow') ")or die(mysqli_query());
					//Dues					
											if($DueClose!=0 || $Employee=='DueSalary' || $Employee=='DueProfit')
												$sq = mysqli_query($con," INSERT INTO openingclosing (cMonth, oMonth, ocType, ocEmp, ocAmnt, savedBy, savingDateTime) VALUES('$closingMonth','$openingMonth','DO Dues','$Employee',$DueClose,'$currentUser','$dateNow') ")or die(mysqli_query());
									
				}
/// SALARY CALCULATION


		$sumBasic=0; $sumOtar=0; $sumMfs=0; $sumOther=0; $sumGrossSal=0; $sumActivity=0; $sumDevSet=0; $sumMarket=0; $sumPostPaid=0;$sumDeductions=0; $sumNetSalary;
				
				$doQ=mysqli_query($con,"SELECT EmpName from empinfo WHERE EmpStatus='Active' Order by sort_order ASC");
				while($data=mysqli_fetch_array($doQ))
				{	
							$Employee=$data['EmpName'];
							
							$bSal=mysqli_query($con,"SELECT EmpFixedsalary, otcomrate From empinfo WHERE EmpName='$Employee'");
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
									$q45=mysqli_query($con,"SELECT sum(comAmnt) FROM comission WHERE rp='$closingMonth' AND comType='Salary Deduction' AND comEmp='$Employee'");
									$Data45=mysqli_fetch_array($q45);
									$deduction=$Data45['sum(comAmnt)'];
									if(is_null($deduction))
									$deduction=0;
							
									$grossSal=$basicSal+$otarComission+$MFSComission+$marketSimComission+$activitySimComission+$deviceHandsetComission+$postPaidComission+$otherComission;
                                    $netSalary=$grossSal-$deduction;
// INSErtING salary 				
									$sq = mysqli_query($con,"INSErt INTO salary (createDate, salMonth, empName, bSal, otarCom, mfsCom, marketSimCom, activitySimCom, deviceHandsetCom, postpaidCom, otherCom, grossSal, advance, cutting, netSal, status) VALUES('$dateNow','$closingMonth','$Employee',$basicSal,$otarComission, $MFSComission, $marketSimComission, $activitySimComission, $deviceHandsetComission, $postPaidComission, $otherComission, $grossSal,0,$deduction,$netSalary, 'Pending') ")or die(mysqli_query());
									
					}
				}
				//$sal=$ThisMonthsalary + $fixedExpenses;
									//$sq = mysqli_query($con," INSErt INTO openingclosing (cMonth, oMonth, ocType, ocEmp, ocAmnt, savedBy, savingDateTime) VALUES('$closingMonth','$openingMonth','DO Dues','DueSalary',$sal,'$currentUser','$dateNow') ")or die(mysqli_query());
// Expenses Due
				$doQ1=mysqli_query($con,"SELECT * from fixedexp ");
					while($data001=mysqli_fetch_array($doQ1))
						{				
						$desc=$data001['description'];
						$amounts=$data001['amnt'];
						$sq01 = mysqli_query($con," INSERT INTO dueexp (expMonth, expDate, type, description, amnt, status) VALUES('$closingMonth','$dateNow','expense','$desc',$amounts,'Pending') ")or die(mysqli_query());
						}
										
									
									
									
									//Petty Cash / (salaries + exp)
									//$sq = mysqli_query($con," INSErt INTO openingclosing (cMonth, oMonth, ocType, ocAmnt, savedBy, savingDateTime) VALUES('$closingMonth','$openingMonth','Petty Cash',$pettyClosing,'$currentUser','$dateNow') ")or die(mysqli_query());

// Bank Closing									

									$sq = mysqli_query($con," INSErt INTO openingclosing (cMonth, oMonth, ocType, ocEmp, ocAmnt, savedBy, savingDateTime) VALUES('$closingMonth','$openingMonth','Cash','$defaultBankName',$BankClosing,'$currentUser','$dateNow') ")or die(mysqli_query());
		


						$qq1 = mysqli_query($con,"SELECT ocID,ocAmnt FROM openingclosing where cMonth='$CurrentMonth' AND ocType='DO Dues' AND ocEmp='DueProfit' ")or die(mysqli_query());
						$dot1=mysqli_fetch_array($qq1);
						$cid=$dot1['ocID'];
						$preProfit=$dot1['ocAmnt'];
						$newval1=$preProfit+($netVisibil*(-1));
						$q1 = mysqli_query($con,"UPDATE openingclosing SET ocAmnt=$newval1 WHERE ocID=$cid ")or die(mysqli_query());

						$qq2 = mysqli_query($con,"SELECT ocID,ocAmnt FROM openingclosing where cMonth='$CurrentMonth' AND ocType='DO Dues' AND ocEmp='DueSalary' ")or die(mysqli_query());
						$dot2=mysqli_fetch_array($qq2);
						$cid2=$dot2['ocID'];
						$preSal=$dot2['ocAmnt'];
						$newval2=$preSal+(($ThisMonthsalary+$fixedExpenses)*(-1));
						$q2 = mysqli_query($con,"UPDATE openingclosing SET ocAmnt=$newval2 WHERE ocID=$cid2 ")or die(mysqli_query());

		
		echo '<script type="text/javascript">alert("All Entries Successfully Saved.");</script>';
		}
	
?>