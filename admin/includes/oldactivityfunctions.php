<?php
$strSales='';
$strReceipts='';
$strPurchases='';
$strPayments='';
$strCombined='';
$strPL_Stock='';
$tbl_mobile_loadString='';
$financialServiceString='';
$cardString='';
$devicesString='';
$totalPurchs=0;
$plTotal=0;
$cardStkAmnt=0;
$simStkAmnt=0;
$mobileStkAmnt=0;

function calcStock($product, $DateFrom,$DateTo,$Month)
{	
	$str='';
	global $con;
	//$str.='<table border="1">';
	if($product=='Card')
	{
		$pNameHere=$product;
		$StartDate=$DateFrom;
		$EndDate=$DateTo;
		$CurrentMonth=$Month;
			$opQtySum=0;
			$opAmntSum=0;
			$pQtySum=0;
			$pAmntSum=0;
			$sQtySum=0;
			$sAmntSum=0;
			$cQtySum=0;
			$cAmntSum=0;
			$colSum=0;
				$sql = mysqli_query($con,"SELECT typeName FROM types WHERE productName='$product' AND isActive=1")or die(mysqli_query());
				WHILE($Data=mysqli_fetch_array($sql))
				{
					$subType=$Data['typeName'];
							$q = mysqli_query($con,"SELECT * from openingclosing WHERE ocType= '$product' AND oMonth='$CurrentMonth' AND ocEmp='$subType' ORDER BY ocID DESC LIMIT 1 ")or die(mysqli_query());	
								$d=mysqli_fetch_array($q);
							$open=$d['ocAmnt'];
							$q = mysqli_query($con,"SELECT purchasePrice from rates WHERE pName= '$product' AND spName='$subType' ORDER BY rtID DESC LIMIT 1 ")or die(mysqli_query());	
								$r=mysqli_fetch_array($q);
								$rt1=$r['purchasePrice'];
								$opAmnt=$open * $rt1;
							$q = mysqli_query($con,"SELECT sum(csQty) from tbl_cards WHERE csType='$subType' AND csStatus='Received' AND csDate BETWEEN '$StartDate' AND '$EndDate'  ")or die(mysqli_query());	
								$d=mysqli_fetch_array($q);
							$purchz=$d['sum(csQty)'];
								$prAmnt=$purchz*$rt1;
								$slAmnt=0;
								$qt2=0;
								$rt2=0;
								$sumrt=0;
								$cnt=0;
								$avgrt=0;
								$q = mysqli_query($con," SELECT sum(csQty), avg(csRate) from tbl_cards WHERE csType='$subType' AND csStatus='Sent' AND csDate BETWEEN '$StartDate' AND '$EndDate' ")or die(mysqli_query());	
								WHILE($d=mysqli_fetch_array($q))
									{
									$qt2=$qt2+$d['sum(csQty)'];
									$rt2=$d['avg(csRate)'];
									$sumrt=$sumrt+$rt2;
									$cnt=$cnt+1;
									}
								if($cnt>0)
									$avgrt=$sumrt/$cnt;
							$slAmnt=$qt2*$avgrt;
							$cl=$open + $purchz - $qt2;
							$clAmnt=$cl*$rt1;
					if($cl!=0)
					{																
						$str.='Card: ';
						$str.=$subType.':  '.' Qty:';
						$str.=$cl.' Amount:<b>('.$clAmnt.')';
						$str.='</b><br>';
					
						//echo $subType.":  ";
						//echo "<b>".$cl."</b>";
						//echo "<br>";*/
						/*$str.='<tr>';
							$str.='<td>';
							$str.=$subType;
							$str.=' ( ';
							$str.=$cl;
							$str.=' ) </td>';
							$str.='<td>';
							$str.=$clAmnt;
							$str.='</td>';
						$str.='</tr>';*/
					}
					$opQtySum=$opQtySum + $open;
					$opAmntSum=$opAmntSum + $opAmnt;
					$pQtySum=$pQtySum + $purchz;
					$pAmntSum=$pAmntSum + $prAmnt;
					$sQtySum=$sQtySum + $qt2;
					$sAmntSum=$sAmntSum + $slAmnt;
					$cQtySum=$cQtySum + $cl;
					$cAmntSum=$cAmntSum + $clAmnt;
				global $cardStkAmnt;
				$cardStkAmnt=$cardStkAmnt+$clAmnt;
				}
		//$cardStkAmnt=0;
		//$cardStkAmnt=$clAmnt;
			$q = mysqli_query($con,"SELECT sum(rpAmnt) from receiptpayment WHERE rpFor='Card' AND rpStatus='ReceivedFrom' AND rpDate BETWEEN '$StartDate' AND '$EndDate'  ")or die(mysqli_query());	
			$d=mysqli_fetch_array($q);
			$colSum=$d['sum(rpAmnt)'];
	}
	else
	{	
	$pNameHere=$product;
	$StartDate=$DateFrom;
	$EndDate=$DateTo;
	$CurrentMonth=$Month;
		$opQtySum=0;
		$opAmntSum=0;
		$pQtySum=0;
		$pAmntSum=0;
		$sQtySum=0;
		$sAmntSum=0;
		$cQtySum=0;
		$cAmntSum=0;
		$colSum=0;
			$sql = mysqli_query($con,"SELECT typeName FROM types WHERE productName='$pNameHere' AND isActive=1")or die(mysqli_query());
			WHILE($Data=mysqli_fetch_array($sql))
			{
				$subType=$Data['typeName'];
												// getting opening stock
						$q = mysqli_query($con,"SELECT * from openingclosing WHERE ocType= '$pNameHere' AND oMonth='$CurrentMonth' AND ocEmp='$subType' ORDER BY ocID DESC LIMIT 1 ")or die(mysqli_query());	
							$d=mysqli_fetch_array($q);
						$open=$d['ocAmnt'];
												// getting purchase price
						$q = mysqli_query($con,"SELECT purchasePrice from rates WHERE pName= '$pNameHere' AND spName='$subType' ORDER BY rtID DESC LIMIT 1 ")or die(mysqli_query());	
							$r=mysqli_fetch_array($q);
							$rt1=$r['purchasePrice'];
						$opAmnt=$open * $rt1;
				
												// getting purchases during current month
						$q = mysqli_query($con,"SELECT sum(qty) from tbl_product_stock WHERE pSubType='$subType' AND trtype='Received' AND sDate BETWEEN '$StartDate' AND '$EndDate'  ")or die(mysqli_query());	
							$d=mysqli_fetch_array($q);
						$purchz=$d['sum(qty)'];
							$prAmnt=$purchz*$rt1;
							$slAmnt=0;
							$Sumqt2=0;
							$Sumrt2=0;
							$sumrt=0;
							$sum=0;
							$cnt=0;
							$avgrt=0;
											// getting sale quantity, sale rate and sale amount
							$q = mysqli_query($con,"SELECT * from tbl_product_stock WHERE pSubType='$subType' AND trtype='Sent' AND sDate BETWEEN '$StartDate' AND '$EndDate'  ")or die(mysqli_query());	
							WHILE($d=mysqli_fetch_array($q))
							{
								$qt2=0;
								$rt2=0;
								$qt2=$d['qty'];
								$rt2=$d['rate'];
								$sumrt=$sumrt+$rt2;
								$sum=$sum+($qt2*$rt2);
								
								$cnt=$cnt+1;
								$Sumqt2=$Sumqt2+$qt2;
								$rt2=0;
							}
							if($cnt>0)
								$avgrt=$sumrt/$cnt;
								$slAmnt=$sum;
						$cl=$open + $purchz - $Sumqt2;
						$clAmnt=$cl*$rt1;
				if($cl!=0)
				{
					$str.=$subType.':  '.'Qty:';
					$str.=$cl.' Amount:<b>('.$clAmnt.')';
					$str.='</b><br>';
					/*$str.='<tr>';
							$str.='<td>';
							$str.=$subType;
							$str.=' ( ';
							$str.=$cl;
							$str.=' ) </td>';
							$str.='<td>';
							$str.=$clAmnt;
							$str.='</td>';
						$str.='</tr>';*/
					
				}
				$opQtySum=$opQtySum + $open;
				$opAmntSum=$opAmntSum + $opAmnt;
				$pQtySum=$pQtySum + $purchz;
				$pAmntSum=$pAmntSum + $prAmnt;
				$sQtySum=$sQtySum + $Sumqt2;
				$sAmntSum=$sAmntSum + $slAmnt;
				$cQtySum=$cQtySum + $cl;
				$cAmntSum=$cAmntSum + $clAmnt;
			global $simStkAmnt;
			global $mobileStkAmnt;
			
			if($pNameHere=='SIM')
				$simStkAmnt=$simStkAmnt+$clAmnt;
			else
				$mobileStkAmnt=$mobileStkAmnt+$clAmnt;
			}
		$q = mysqli_query($con,"SELECT sum(rpAmnt) from receiptpayment WHERE rpFor='$pNameHere' AND rpStatus='ReceivedFrom' AND rpDate BETWEEN '$StartDate' AND '$EndDate'  ")or die(mysqli_query());	
		$d=mysqli_fetch_array($q);
		$colSum=$d['sum(rpAmnt)'];
	}
	//$str.='</table>';
	return $str;
}



if (isset($_POST['getActivity']))
	{
		$StartDate=$_POST['txtDateFrom'];
		$selectedMonth=date('M-Y', strtotime($StartDate));
		$dateCurrent=date('Y-m-d', strtotime($StartDate));
		$StartDate1=strtotime($StartDate);
		$dateFirst=date('Y-m-01', strtotime($StartDate));
		$StartDate=$dateFirst;
		$StartDate1=date('d-m-Y',$StartDate1);
		$EndDate=$_POST['txtDateFrom'];
		$dateFirstStamp=strtotime($dateFirst);
		$dateCurrentStamp=strtotime($dateCurrent);
		$StartDate2=$dateFirst;
		//echo '<br><br><br>'.strtotime($dateFirst);
		//echo '<br>'.strtotime($dateCurrent);
		//$EndDate=$_POST['txtDateTo'];
		
		$strPurchases.='<table cellpadding="0" cellspacing="0" border="1" class="table" id="headTable" >';
		$strPurchases.='<tr>';
		$strPurchases.='<td><b>';
		$strPurchases.='Product';
		$strPurchases.='</b></td>';
		$strPurchases.='<td><b>';
		$strPurchases.='Quantity';
		$strPurchases.='</b></td>';
		$strPurchases.='<td><b>';
		$strPurchases.='Amount';
		$strPurchases.='</b></td>';
		//$strPurchases.='<td><b>';
		//$strPurchases.='Comments';
		//$strPurchases.='</b></td>';
		$strPurchases.='</tr>';

	/*<<<<<<<<<<<<< GETTING MOBILE LOAD Purchases>>>>>>>>>>>>>>>>*/
		{	
			$LoadAmntSum=0;
			$sql = mysqli_query($con,"SELECT sum(loadAmnt) FROM tbl_mobile_load WHERE loadStatus='Received' AND loadEmp= '$parentCompany' AND loadDate BETWEEN '$StartDate' AND '$EndDate' ")or die(mysqli_query());
			WHILE($Data=mysqli_fetch_array($sql))
			{
				//$Dat=$Data['loadDate'];
				$Amnt= $Data['sum(loadAmnt)'];
				//$ptype= $Data['purchaseType'];
				//$Cmnts= $Data['loadComments'];
				$tbl_mobile_loadString.='<tr>';
				$tbl_mobile_loadString.='<td>';
				$tbl_mobile_loadString.='Mob-Load';
				$tbl_mobile_loadString.='</td>';
				$tbl_mobile_loadString.='<td>';
				$tbl_mobile_loadString.='';
				$tbl_mobile_loadString.='</td>';
				$tbl_mobile_loadString.='<td style="text-align: right;">';
				$tbl_mobile_loadString.=$Amnt;
				$tbl_mobile_loadString.='</td>';
				//$tbl_mobile_loadString.='<td>';
				//$tbl_mobile_loadString.=$ptype;
				//$tbl_mobile_loadString.='</td>';
				$tbl_mobile_loadString.='</tr>';
				$LoadAmntSum=$LoadAmntSum+$Amnt;
			}
			$strPurchases.=$tbl_mobile_loadString;
		}
	/*<<<<<<<<<<<<< GETTING FINANCIAL SERVICES Purchases>>>>>>>>>>>>>>>>*/
		{	
			$mfsAmntSum=0;
			$sql1 = mysqli_query($con,"SELECT sum(mfsAmnt) FROM tbl_financial_service WHERE mfsStatus='Received' AND mfsEmp= '$parentCompany' AND mfsDate BETWEEN '$StartDate' AND '$EndDate' ")or die(mysqli_query());
			WHILE($Data1=mysqli_fetch_array($sql1))
			{
				//$Dat1=$Data1['mfsDate'];
				$Amnt1= $Data1['sum(mfsAmnt)'];
				//$user1= $Data1['User'];
				//$Cmnts1= $Data1['mfsComments'];
				$financialServiceString.='<tr>';
				$financialServiceString.='<td>';
				$financialServiceString.='MFS';
				$financialServiceString.='</td>';
				$financialServiceString.='<td>';
				$financialServiceString.='';
				$financialServiceString.='</td>';
				$financialServiceString.='<td style="text-align: right;">';
				$financialServiceString.=$Amnt1;
				$financialServiceString.='</td>';
				//$financialServiceString.='<td>';
				//$financialServiceString.=$Cmnts1;
				//$financialServiceString.='</td>';
				$financialServiceString.='</tr>';
				$mfsAmntSum=$mfsAmntSum+$Amnt1;
			}
			$strPurchases.=$financialServiceString;
		}
	/*<<<<<<<<<<<<< GETTING CARD Purchases>>>>>>>>>>>>>>>>*/
		{
			$sumAmntCards=0;
			$sql2 = mysqli_query($con,"SELECT csType, sum(csQty),SUM(csOrgAmnt),sum(csProLoss),purchaseType FROM tbl_cards WHERE csStatus='Received' AND csDate BETWEEN '$StartDate' AND '$EndDate' GROUP BY csType;")or die(mysqli_query());
			WHILE($Data2=mysqli_fetch_array($sql2))
			{
				$Type2= $Data2['csType'];
				$Qty2= $Data2['sum(csQty)'];
				$Amnt2= $Data2['SUM(csOrgAmnt)'];
				$cmnt2=$Data2['purchaseType'];
				$cardString.='<tr>';
				$cardString.='<td>';
				$cardString.='Card: ';
				$cardString.=$Type2;
				$cardString.='</td>';
				$cardString.='<td style="text-align: center;">';
				$cardString.=$Qty2;
				$cardString.='</td>';
				$cardString.='<td style="text-align: right;">';
				$cardString.=round($Amnt2,2);
				$cardString.='</td>';
				//$cardString.='<td>';
				//$cardString.=$cmnt2;
				//$cardString.='</td>';
				$cardString.='</tr>';
				$sumAmntCards=$sumAmntCards+$Amnt2;
			}
			$strPurchases.=$cardString;
		}
	/*<<<<<<<<<<<<< GETTING DEVICE Purchases>>>>>>>>>>>>>>>>*/
		{
			$sumAmntDevices=0;
			$sql3 = mysqli_query($con,"SELECT pSubType,sum(qty), sum(qty*rate),sComments FROM tbl_product_stock WHERE trtype='Received' AND pName='Mobile' AND sDate BETWEEN '$StartDate' AND '$EndDate' GROUP BY pSubType;")or die(mysqli_query());
			WHILE($Data3=mysqli_fetch_array($sql3))
			{
				$Type3= $Data3['pSubType'];
				$Qty3= $Data3['sum(qty)'];
				$Amnt3= $Data3['sum(qty*rate)'];
				$Cmnts3= $Data3['sComments'];
				$devicesString.='<tr>';
				$devicesString.='<td>';
				$devicesString.=$Type3;
				$devicesString.='</td>';
				$devicesString.='<td style="text-align: center;">';
				$devicesString.=$Qty3;
				$devicesString.='</td>';
				$devicesString.='<td style="text-align: right;">';
				$devicesString.=$Amnt3;
				$devicesString.='</td>';
				//$devicesString.='<td>';
				//$devicesString.='';
				//$devicesString.='</td>';
				$devicesString.='</tr>';
				$sumAmntDevices=$sumAmntDevices+$Amnt3;
			}
			$strPurchases.=$devicesString;
		}
	/*<<<<<<<<<<<<< GETTING SIM Purchases>>>>>>>>>>>>>>>>*/
		{
			$sumAmntSIMs=0;
			$sql4 = mysqli_query($con,"SELECT pSubType,sum(qty), sum(qty*rate),sComments FROM tbl_product_stock WHERE trtype='Received' AND pName='SIM' AND sDate BETWEEN '$StartDate' AND '$EndDate' GROUP BY pSubType;")or die(mysqli_query());
			WHILE($Data4=mysqli_fetch_array($sql4))
			{
				$Type4= $Data4['pSubType'];
				$Qty4= $Data4['sum(qty)'];
				$Amnt4= $Data4['sum(qty*rate)'];
				$Cmnts4= $Data4['sComments'];
				$devicesString.='<tr>';
				$devicesString.='<td>';
				$devicesString.=$Type4;
				$devicesString.='</td>';
				$devicesString.='<td style="text-align: center;">';
				$devicesString.=$Qty4;
				$devicesString.='</td>';
				$devicesString.='<td style="text-align: right;">';
				$devicesString.=$Amnt4;
				$devicesString.='</td>';
				//$devicesString.='<td>';
				//$devicesString.='';
				//$devicesString.='</td>';
				$devicesString.='</tr>';
				$sumAmntSIMs=$sumAmntSIMs+$Amnt4;
			}
			$totalPurchs=$LoadAmntSum+$mfsAmntSum+$sumAmntCards+$sumAmntDevices+$sumAmntSIMs;
			$strPurchases.=$devicesString;
		}
		$strPurchases.='<tr>';
		$strPurchases.='<td colspan="2"><b>';
		$strPurchases.='TOTAL PURCHASES:';
		$strPurchases.='</b></td>';
		$strPurchases.='<td colspan="2" style="text-align: center;"><h3><b>';
		$strPurchases.=round($totalPurchs,2);
		$strPurchases.='</h3></b></td>';
		$strPurchases.='</tr>';
		$strPurchases.='</table>';
	
	
	/*<<<<<<<<<<<<< nnnnnnnnnnnnnnnnn >>>>>>>>>>>>>>>>*/
		$strSales.='<table cellpadding="0" cellspacing="0" border="1" class="table" id="headTable" >';
		$strSales.='<tr>';
		$strSales.='<td><b>';
		$strSales.='Product';
		$strSales.='</b></td>';
		$strSales.='<td><b>';
		$strSales.='Name / Quantity';
		$strSales.='</b></td>';
		$strSales.='<td><b>';
		$strSales.='Amount';
		$strSales.='</b></td>';
		//$strSales.='<td><b>';
		//$strSales.='Comments';
		//$strSales.='</b></td>';
		$strSales.='</tr>';

	/*<<<<<<<<<<<<< GETTING MOBILE LOAD SALES>>>>>>>>>>>>>>>>*/
		{	
			$LoadAmntSum=0;
			$sql = mysqli_query($con,"SELECT loadDate,sum(loadAmnt),sum(loadProfit+loadExcessProfit) as profit,loadEmp,purchaseType,loadComments FROM tbl_mobile_load WHERE loadStatus='Sent' AND loadEmp!= '$parentCompany' AND loadDate BETWEEN '$StartDate' AND '$EndDate' GROUP BY loadEmp")or die(mysqli_query());
			WHILE($Data=mysqli_fetch_array($sql))
			{
				$Dat=$Data['loadDate'];
				$Amnt= $Data['sum(loadAmnt)'];
				$emp=$Data['loadEmp'];
				$ptype= $Data['purchaseType'];
				$Cmnts= $Data['loadComments'];
				$loadProfit=$Data['profit'];
				$strSales.='<tr>';
				$strSales.='<td>';
				$strSales.='Mob-Load';
				$strSales.='</td>';
				$strSales.='<td>';
				$strSales.=$emp;
				$strSales.='</td>';
				$strSales.='<td style="text-align: right;">';
				$strSales.=$Amnt;
				$strSales.='</td>';
				//$strSales.='<td>';
				//$strSales.=$ptype;
				//$strSales.='</td>';
				$strSales.='</tr>';
				$LoadAmntSum=$LoadAmntSum+$Amnt;
			}
			//$strCombined.=$tbl_mobile_loadString;
			$plTotal=$plTotal+$loadProfit;
		}
	
	/*<<<<<<<<<<<<< GETTING FINANCIAL SERVICES SALES>>>>>>>>>>>>>>>>*/
		{	
			$mfsAmntSum=0;
			$sql1 = mysqli_query($con,"SELECT mfsEmp,mfsDate,sum(mfsAmnt),User,mfsComments FROM tbl_financial_service WHERE mfsStatus='Sent' AND mfsDate BETWEEN '$StartDate' AND '$EndDate' GROUP BY mfsEmp ")or die(mysqli_query());
			WHILE($Data1=mysqli_fetch_array($sql1))
			{
				$Dat1=$Data1['mfsDate'];
				$Amnt1= $Data1['sum(mfsAmnt)'];
				$emp1=$Data1['mfsEmp'];
				$user1= $Data1['User'];
				$Cmnts1= $Data1['mfsComments'];
				$strSales.='<tr>';
				$strSales.='<td>';
				$strSales.='MFS';
				$strSales.='</td>';
				$strSales.='<td>';
				$strSales.=$emp1;
				$strSales.='</td>';
				$strSales.='<td style="text-align: right;">';
				$strSales.=$Amnt1;
				$strSales.='</td>';
				//$strSales.='<td>';
				//$strSales.=$Cmnts1;
				//$strSales.='</td>';
				$strSales.='</tr>';
				$mfsAmntSum=$mfsAmntSum+$Amnt1;
			}
			//$strCombined.=$financialServiceString;
		}
	
	/*<<<<<<<<<<<<< GETTING CARD SALES>>>>>>>>>>>>>>>>*/
		{	
			$sumAmntCards=0;
			$cardProLoss2=0;
			$sql2 = mysqli_query($con,"SELECT csType, sum(csQty),SUM(csOrgAmnt),sum(csProLoss),purchaseType FROM tbl_cards WHERE csStatus='Sent' AND csDate BETWEEN '$StartDate' AND '$EndDate' GROUP BY csType;")or die(mysqli_query());
			WHILE($Data2=mysqli_fetch_array($sql2))
			{
				$Type2= $Data2['csType'];
				$Qty2= $Data2['sum(csQty)'];
				$Amnt2= $Data2['SUM(csOrgAmnt)'];
				$cmnt2=$Data2['purchaseType'];
				
				if ($Data2['sum(csProLoss)']=='')
					$cardProLoss2=0;
				else
					$cardProLoss2=$Data2['sum(csProLoss)'];
				$strSales.='<tr>';
				$strSales.='<td>';
				$strSales.='Card: ';
				$strSales.=$Type2;
				$strSales.='</td>';
				$strSales.='<td style="text-align: center;">';
				$strSales.=$Qty2;
				$strSales.='</td>';
				$strSales.='<td style="text-align: right;">';
				$strSales.=round($Amnt2,2);
				$strSales.='</td>';
				//$strSales.='<td>';
				//$strSales.=$cmnt2;
				//$strSales.='</td>';
				$strSales.='</tr>';
				$sumAmntCards=$sumAmntCards+$Amnt2;
				//$plTotal=$plTotal+$cardProLoss2;
			}
			//$strCombined.=$cardString;
			$plTotal=$plTotal+$cardProLoss2;
		}
	/*<<<<<<<<<<<<< GETTING DEVICE SALES>>>>>>>>>>>>>>>>*/
		{
			$sumAmntDevices=0;
			$sql3 = mysqli_query($con,"SELECT pSubType,sum(qty), sum(qty*rate),sComments FROM tbl_product_stock WHERE trtype='Sent' AND pName='Mobile' AND sDate BETWEEN '$StartDate' AND '$EndDate' GROUP BY pSubType;")or die(mysqli_query());
			WHILE($Data3=mysqli_fetch_array($sql3))
			{
				$Type3= $Data3['pSubType'];
				$Qty3= $Data3['sum(qty)'];
				$Amnt3= $Data3['sum(qty*rate)'];
				$Cmnts3= $Data3['sComments'];
	//$mobileProLoss2=$Data3['sum(qty*rate)'];
				$strSales.='<tr>';
				$strSales.='<td>';
				$strSales.=$Type3;
				$strSales.='</td>';
				$strSales.='<td style="text-align: center;">';
				$strSales.=$Qty3;
				$strSales.='</td>';
				$strSales.='<td style="text-align: right;">';
				$strSales.=$Amnt3;
				$strSales.='</td>';
				//$strSales.='<td>';
				//$strSales.='';
				//$strSales.='</td>';
				$strSales.='</tr>';
				$sumAmntDevices=$sumAmntDevices+$Amnt3;
			}
			//$strCombined.=$devicesString;
			//$plTotal=$plTotal+$mobileProLoss3;
		}
	
	/*<<<<<<<<<<<<< GETTING DEVICE SALES>>>>>>>>>>>>>>>>*/
		{
			$sumAmntSIMs=0;
			$sql4 = mysqli_query($con,"SELECT pSubType,sum(qty), sum(qty*rate),sComments FROM tbl_product_stock WHERE trtype='Sent' AND pName='SIM' AND sDate BETWEEN '$StartDate' AND '$EndDate' GROUP BY pSubType;")or die(mysqli_query());
			WHILE($Data4=mysqli_fetch_array($sql4))
			{
				$Type4= $Data4['pSubType'];
				$Qty4= $Data4['sum(qty)'];
				$Amnt4= $Data4['sum(qty*rate)'];
				$Cmnts4= $Data4['sComments'];
				$strSales.='<tr>';
				$strSales.='<td>';
				$strSales.=$Type4;
				$strSales.='</td>';
				$strSales.='<td style="text-align: center;">';
				$strSales.=$Qty4;
				$strSales.='</td>';
				$strSales.='<td style="text-align: right;">';
				$strSales.=$Amnt4;
				$strSales.='</td>';
				//$strSales.='<td>';
				//$strSales.='';
				//$strSales.='</td>';
				$strSales.='</tr>';
				$sumAmntSIMs=$sumAmntSIMs+$Amnt4;
			}
			$totalPurchs=$LoadAmntSum+$mfsAmntSum+$sumAmntCards+$sumAmntDevices+$sumAmntSIMs;
			//$strCombined.=$devicesString;
		}
		$strSales.='<tr>';
		$strSales.='<td colspan="2"><b>';
		$strSales.='TOTAL PURCHASES:';
		$strSales.='</b></td>';
		$strSales.='<td colspan="2" style="text-align: center;"><h3><b>';
		$strSales.=round($totalPurchs,2);
		$strSales.='</h3></b></td>';
		$strSales.='</tr>';
		$strSales.='</table>';



/*<<<<<<<<<<<<< RECEIPT SUMMARY >>>>>>>>>>>>>>>>*/
		$strReceipts.='<table cellpadding="0" cellspacing="0" border="1" class="table" id="headTable" >';
		$strReceipts.='<tr>';
		$strReceipts.='<td><b>';
		$strReceipts.='Product';
		$strReceipts.='</b></td>';
		$strReceipts.='<td><b>';
		$strReceipts.='Name / Quantity';
		$strReceipts.='</b></td>';
		$strReceipts.='<td><b>';
		$strReceipts.='Amount';
		$strReceipts.='</b></td>';
		//$strReceipts.='<td><b>';
		//$strReceipts.='Comments';
		//$strReceipts.='</b></td>';
		$strReceipts.='</tr>';



		$strTotalRecpt=0;
		$sql11 = mysqli_query($con,"SELECT rpFor,rpFromTo,sum(rpAmnt) FROM receiptpayment WHERE rpStatus='ReceivedFrom' AND rpDate BETWEEN '$StartDate' AND '$EndDate' GROUP BY rpFor,rpFromTO ORDER BY rpFor ASC")or die(mysqli_query());
		WHILE($Data11=mysqli_fetch_array($sql11))
		{
			//$rpID11 = $Data11['rpID'];
			//$Dat11=$Data11['rpDate'];
			$for11=$Data11['rpFor'];
			$fromTo11= $Data11['rpFromTo'];
			$Amnt11= $Data11['sum(rpAmnt)'];
			//$mode11= $Data11['rpMode'];
			//$User11= $Data11['rpUser'];
			//$notes11 = $Data11['rpNotes'];
			//$id11 = $Data11['rpID'];
			//$d11=strtotime($Dat11);
			//$dtNow11=date("d-M-Y", $d11);
			$strReceipts.='<tr>';
			$strReceipts.='<td>';
			$strReceipts.=$for11;
			$strReceipts.='</td>';
			$strReceipts.='<td>';
			$strReceipts.=$fromTo11;
			$strReceipts.='</td>';
			$strReceipts.='<td>';
			$strReceipts.=$Amnt11;
			$strReceipts.='</td>';
			$strReceipts.='</tr>';
			$strTotalRecpt=$strTotalRecpt+$Amnt11;
		}


		$strReceipts.='<tr>';
		$strReceipts.='<td colspan="2"><b>';
		$strReceipts.='TOTAL RECEIPTS:';
		$strReceipts.='</b></td>';
		$strReceipts.='<td colspan="2" style="text-align: center;"><h3><b>';
		$strReceipts.=round($strTotalRecpt,2);
		$strReceipts.='</h3></b></td>';
		$strReceipts.='</tr>';
		$strReceipts.='</table>';
	
/*<<<<<<<<<<<<< PAYMENT SUMMARY >>>>>>>>>>>>>>>>*/	

		$strPayments.='<table cellpadding="0" cellspacing="0" border="1" class="table" id="headTable" >';
		$strPayments.='<tr>';
		$strPayments.='<td><b>';
		$strPayments.='Product';
		$strPayments.='</b></td>';
		$strPayments.='<td><b>';
		$strPayments.='Name / Quantity';
		$strPayments.='</b></td>';
		$strPayments.='<td><b>';
		$strPayments.='Amount';
		$strPayments.='</b></td>';
		//$strPayments.='<td><b>';
		//$strPayments.='Comments';
		//$strPayments.='</b></td>';
		$strPayments.='</tr>';

		$strTotalPayment=0;
		$sql11 = mysqli_query($con,"SELECT rpFor,rpFromTo,sum(rpAmnt) FROM receiptpayment WHERE rpStatus='PaidTo' AND rpDate BETWEEN '$StartDate' AND '$EndDate' GROUP BY rpFor,rpFromTO ORDER BY rpFor ASC")or die(mysqli_query());
		WHILE($Data11=mysqli_fetch_array($sql11))
		{
			//$rpID11 = $Data11['rpID'];
			//$Dat11=$Data11['rpDate'];
			$for11=$Data11['rpFor'];
			$fromTo11= $Data11['rpFromTo'];
			$Amnt11= $Data11['sum(rpAmnt)'];
			//$mode11= $Data11['rpMode'];
			//$User11= $Data11['rpUser'];
			//$notes11 = $Data11['rpNotes'];
			//$id11 = $Data11['rpID'];
			//$d11=strtotime($Dat11);
			//$dtNow11=date("d-M-Y", $d11);
			$strPayments.='<tr>';
			$strPayments.='<td>';
			$strPayments.=$for11;
			$strPayments.='</td>';
			$strPayments.='<td>';
			$strPayments.=$fromTo11;
			$strPayments.='</td>';
			$strPayments.='<td>';
			$strPayments.=$Amnt11;
			$strPayments.='</td>';
			$strPayments.='</tr>';
			$strTotalPayment=$strTotalPayment+$Amnt11;
		}

		$strPayments.='<tr>';
		$strPayments.='<td colspan="2"><b>';
		$strPayments.='TOTAL RECEIPTS:';
		$strPayments.='</b></td>';
		$strPayments.='<td colspan="2" style="text-align: center;"><h3><b>';
		$strPayments.=round($strTotalPayment,2);
		$strPayments.='</h3></b></td>';
		$strPayments.='</tr>';
		$strPayments.='</table>';
	
	
	
		/***********  INVESTMENT/STOCK  *************/
		$qry22 = mysqli_query($con,"SELECT * FROM rates WHERE pName='Otar' ORDER BY rtID DESC LIMIT 1")or die(mysqli_query());
		$Data22=mysqli_fetch_array($qry22);
		$marginReceived22=$Data22['purchasePrice'];
		$marginSent22=$Data22['salePrice'];
		$franchiseProfitRate= $marginReceived22 - $marginSent22;
		$FrOpeningOtar=mysqli_query($con,"SELECT ocAmnt From openingclosing WHERE ocEmp='Franchise' AND oMonth='$selectedMonth' AND ocType='Otar'  ");
		$Data=mysqli_fetch_array($FrOpeningOtar);
		$FrOtarOpening = $Data['ocAmnt'];
		$qe=mysqli_query($con,"SELECT sum(loadAmnt) FROM tbl_mobile_load WHERE loadStatus='Received' AND loadEmp='$parentCompany' AND loadDate BETWEEN '$dateFirst' AND '$EndDate' ");
		$D1=mysqli_fetch_array($qe);
		$OtLift = $D1['sum(loadAmnt)'];
		$qf=mysqli_query($con,"SELECT sum(loadTransfer) FROM tbl_mobile_load WHERE loadStatus='Sent' AND loadDate BETWEEN '$dateFirst' AND '$EndDate' ");
		$D2=mysqli_fetch_array($qf);
		$OtSale = $D2['sum(loadTransfer)'];
		$Otarinvestment= $FrOtarOpening + $OtLift - $OtSale;
		$OtarInvestLessMargin=$Otarinvestment - ($Otarinvestment*$marginReceived22);
		
		$FrOpeningmfs23=mysqli_query($con,"SELECT ocAmnt From openingclosing WHERE ocEmp='Franchise' AND oMonth='$selectedMonth' AND ocType='mfs'  ");
		$Data23=mysqli_fetch_array($FrOpeningmfs23); 
		$FrmfsOpening23 = $Data23['ocAmnt'];
		$qm23=mysqli_query($con,"SELECT sum(mfsAmnt) FROM tbl_financial_service WHERE mfsStatus='Received' AND mfsDate BETWEEN '$dateFirst' AND '$EndDate' ");
			$Datam23=mysqli_fetch_array($qm23);
			$mfsReceived23 = $Datam23['sum(mfsAmnt)'];
		$qn23=mysqli_query($con,"SELECT sum(comAmnt) FROM comission WHERE comType='mfs comission' AND comEmp='$parentCompany' AND comDate BETWEEN '$dateFirst' AND '$EndDate' ");
			$Datan23=mysqli_fetch_array($qn23);
			$mfscomissionk23 = $Datan23['sum(comAmnt)'];
		$qk23=mysqli_query($con,"SELECT sum(mfsAmnt) FROM tbl_financial_service WHERE mfsStatus='Sent' AND mfsDate BETWEEN '$dateFirst' AND '$EndDate'  ");
			$Datak23=mysqli_fetch_array($qk23);
			$mfsSalek23 = $Datak23['sum(mfsAmnt)'];
		$mfsinvestment= ( $FrmfsOpening23 + $mfsReceived23 +  $mfscomissionk23 ) - $mfsSalek23;
		
		
		/*////////////////   STOCK CALCULATION      ////////////////////*/
			/*?????????????????
		Yahan Sy Har Aik head (i.e Do Dues, Cash, SIM, Mobile etc) k liay alag alag
		opening + given - taken k formula sy closing nikal k alag alag show karwain aur phr mila k net DO Dues likhain
		???????????*/
		{
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
		$totalMfsCloseHere=0;
		$doQ=mysqli_query($con,"SELECT EmpName from empinfo ");
		while($data00=mysqli_fetch_array($doQ))
			{	
					$Employee=$data00['EmpName'];
					$thisEmpDue=0;
					
						// openings
							$EmpOpening=mysqli_query($con,"SELECT ocAmnt From openingclosing WHERE ocEmp='$Employee' AND oMonth='$selectedMonth' AND ocType='Cash'  ");
							$Data0=mysqli_fetch_array($EmpOpening);
							$opening = $Data0['ocAmnt'];
							$openCash=$opening;
							
							$CardCashOpening=mysqli_query($con,"SELECT ocAmnt From openingclosing WHERE ocEmp='$Employee' AND oMonth='$selectedMonth' AND ocType='Card'  ");
							$Data01=mysqli_fetch_array($CardCashOpening);
							$openCardCash = $Data01['ocAmnt'];
					
					
							$MobileCashOpening=mysqli_query($con,"SELECT ocAmnt From openingclosing WHERE ocEmp='$Employee' AND oMonth='$selectedMonth' AND ocType='Mobile'  ");
							$Data02=mysqli_fetch_array($MobileCashOpening);
							$openMobileCash = $Data02['ocAmnt'];
					
					
							$SIMCashOpening=mysqli_query($con,"SELECT ocAmnt From openingclosing WHERE ocEmp='$Employee' AND oMonth='$selectedMonth' AND ocType='SIM'  ");
							$Data03=mysqli_fetch_array($SIMCashOpening);
							$openSIMCash = $Data03['ocAmnt'];
									
							$DuesOpening=mysqli_query($con,"SELECT ocAmnt From openingclosing WHERE ocEmp='$Employee' AND oMonth='$selectedMonth' AND ocType='DO Dues'  ");
							$Data1=mysqli_fetch_array($DuesOpening);
							$openingDue = $Data1['ocAmnt'];
							
							
												
						// Sales
							$sumLoad=0;	$sumTransfer=0;	$sumProfit=0; $sumSend=0; $sumReceive=0; $sumClose=0; $sumQty=0; $sumOrgAmnt=0; $sumSaleRate=0; $sumAmnt=0; $sumProLoss=0;
							$sumReceivable=0; $sumTaken=0;	

							
									$q2=mysqli_query($con,"SELECT sum(loadAmnt) FROM tbl_mobile_load WHERE loadStatus='Sent' AND loadEmp='$Employee' AND loadDate BETWEEN '$StartDate2' AND '$EndDate' ");
									$Data2=mysqli_fetch_array($q2);
							$load= $Data2['sum(loadAmnt)'];
														
									$q3=mysqli_query($con,"SELECT sum(mfsAmnt) FROM tbl_financial_service WHERE mfsStatus='Sent' AND mfsEmp='$Employee' AND mfsDate BETWEEN '$StartDate2' AND '$EndDate' ");
									$Data3=mysqli_fetch_array($q3);
							
							$mfsSend= $Data3['sum(mfsAmnt)'];
									
									
									$q4=mysqli_query($con,"SELECT sum(mfsAmnt) FROM tbl_financial_service WHERE mfsStatus='Received' AND mfsEmp='$Employee' AND mfsDate BETWEEN '$StartDate2' AND '$EndDate' ");
									$Data4=mysqli_fetch_array($q4);
							$mfsReceive = $Data4['sum(mfsAmnt)'];
							$mfsClose = $mfsSend-$mfsReceive;
					
									
									$q5=mysqli_query($con,"SELECT sum(csTotalAmnt) FROM tbl_cards WHERE csStatus='Sent' AND csEmp='$Employee' AND csDate BETWEEN '$StartDate2' AND '$EndDate' ");
									$Data5=mysqli_fetch_array($q5);
							$csamount= $Data5['sum(csTotalAmnt)'];
					
							
							
							$receivable= $load+$mfsClose+$csamount+$opening;		
						// calculating mobile sold to emp
							$sAmntSum0=0;
							$sq6 = mysqli_query($con,"SELECT typeName FROM types WHERE productName='Mobile'")or die(mysqli_query());
								WHILE($Data6=mysqli_fetch_array($sq6))
								{
									$subType=$Data6['typeName'];
									$slAmnt=0; $qt2=0; $rt2=0; $sumQt=0;
									$q7 = mysqli_query($con,"SELECT * from tbl_product_stock WHERE pSubType='$subType' AND trtype='Sent' AND customer='$Employee' AND sDate BETWEEN '$StartDate2' AND '$EndDate'  ")or die(mysqli_query());	
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
									$q9 = mysqli_query($con,"SELECT * from tbl_product_stock WHERE pSubType='$subType' AND trtype='Sent' AND customer='$Employee' AND sDate BETWEEN '$StartDate2' AND '$EndDate'  ")or die(mysqli_query());	
									WHILE($d9=mysqli_fetch_array($q9))
									{
										$qt2=$d9['qty'];
										$rt2=$d9['rate'];
										$sumQt=$sumQt+$qt2;
										$slAmnt=$slAmnt+($qt2*$rt2);
									}
									$sAmntSum1=$sAmntSum1+$slAmnt;
								}
				
							$q10=mysqli_query($con,"SELECT sum(rpAmnt) FROM receiptpayment WHERE rpFor ='DO Dues' AND rpStatus='PaidTo' AND rpFromTo='$Employee' AND rpDate BETWEEN '$StartDate2' AND '$EndDate' ");
									$Data10=mysqli_fetch_array($q10);
								$givendo= $Data10['sum(rpAmnt)'];
				
				
					// Received
								
							$q11=mysqli_query($con,"SELECT sum(rpAmnt) FROM receiptpayment WHERE rpFor ='LMC' AND rpStatus='ReceivedFrom' AND rpFromTo='$Employee' AND rpDate BETWEEN '$StartDate2' AND '$EndDate' ");
									$Data11=mysqli_fetch_array($q11);
								$takenlmc= $Data11['sum(rpAmnt)'];		
							
							$q111=mysqli_query($con,"SELECT sum(rpAmnt) FROM receiptpayment WHERE rpFor ='Card' AND rpStatus='ReceivedFrom' AND rpFromTo='$Employee' AND rpDate BETWEEN '$StartDate2' AND '$EndDate' ");
									$Data111=mysqli_fetch_array($q111);
								$takeCard= $Data111['sum(rpAmnt)'];
					
					
							$q12=mysqli_query($con,"SELECT sum(rpAmnt) FROM receiptpayment WHERE rpFor ='mobile' AND rpStatus='ReceivedFrom' AND rpFromTo='$Employee' AND rpDate BETWEEN '$StartDate2' AND '$EndDate' ");
									$Data12=mysqli_fetch_array($q12);
								$takenMbl= $Data12['sum(rpAmnt)'];		
					
					
							$q13=mysqli_query($con,"SELECT sum(rpAmnt) FROM receiptpayment WHERE rpFor ='SIM' AND rpStatus='ReceivedFrom' AND rpFromTo='$Employee' AND rpDate BETWEEN '$StartDate2' AND '$EndDate' ");
									$Data13=mysqli_fetch_array($q13);
								$takenSIM= $Data13['sum(rpAmnt)'];		
					
						
							$q14=mysqli_query($con,"SELECT sum(rpAmnt) FROM receiptpayment WHERE rpFor ='DO Dues' AND rpStatus='ReceivedFrom' AND rpFromTo='$Employee' AND rpDate BETWEEN '$StartDate2' AND '$EndDate' ");
									$Data14=mysqli_fetch_array($q14);
								$takendo= $Data14['sum(rpAmnt)'];		
					
									$q15=mysqli_query($con,"SELECT sum(rpAmnt) FROM receiptpayment WHERE rpFor !='DO Dues' AND rpStatus='ReceivedFrom' AND rpFromTo='$Employee' AND rpDate BETWEEN '$StartDate2' AND '$EndDate' ");
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
					
				$totalDue=$totalCash+$totalCard+$totalMobile+$totalSIM+$totalDoDues;					// total all above
				
				$totalAccntRP=$totalCash+$totalCard+$totalMobile+$totalSIM;					// total all above less DO Dues
				$DODue=$totalDoDues;                                                    //  separated DO Dues
				
				//$remainingDoDues=$totalDue-$DefaulterDueClosing;
				$LmcMblSim=$totalCash+$totalCard+$totalMobile+$totalSIM;
				$totalMfsCloseHere=$totalMfsCloseHere+$mfsClose;
			}
			
		}
	
	/*-----<<<<<<<<<<<<<      Bank Closing      >>>>>>>>>>>>-----*/
		$NameHere=$defaultBankName;
		//echo "<br /><br /><br />".$NameHere;
		$sq6 = mysqli_query($con,"SELECT ocAmnt FROM openingclosing where oMonth='$selectedMonth' AND ocType='Cash' AND ocEmp='$NameHere'  ")or die(mysqli_query());
			$Data6=mysqli_fetch_array($sq6);
			
			$Opening=$Data6['ocAmnt'];
			$depositSum=0; $wDrawsum=0; $paySum=0; $orgDepositSum=0;
			for($i=$dateFirstStamp; $i<=$dateCurrentStamp; $i+=86400)
			{
				$cd=date("Y-m-d", $i);
				$q=mysqli_query($con,"SELECT sum(rpAmnt) FROM receiptpayment WHERE rpDate ='$cd' AND rpStatus='ReceivedFrom' AND rpmode='$NameHere' ");
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
	/*-----<<<<<<<<<<<<<      GETTING ONLINE tax         >>>>>>>>>>>>-----*/
	
		$tax=mysqli_query($con,"SELECT sum(rpAmnt) From receiptpayment WHERE rpFor='tax' AND rpStatus='PaidTo' AND rpDate BETWEEN '$StartDate' AND '$EndDate' ");
		$Data=mysqli_fetch_array($tax); 
		$taxAmnt = $Data['sum(rpAmnt)'];
			
			
			
		/*-----<<<<<<<<<<<<<      GETTING OTAR VISIBILITY (LOAD PROFIT + LOAD EXCESS PROFIT)         >>>>>>>>>>>>-----*/
			
		$Profit=mysqli_query($con,"SELECT sum(loadProfit), sum(loadExcessProfit) From tbl_mobile_load WHERE (loadDate BETWEEN '$StartDate' AND '$EndDate' )");
		$Data=mysqli_fetch_array($Profit); 
		$gProfit = $Data['sum(loadProfit)'];
		$gProfitExcess = $Data['sum(loadExcessProfit)'];
		$netProfit=$gProfit+$gProfitExcess;
			
			
			
		/*-----<<<<<<<<<<<<<      GETTING mfs Comission PROFIT         >>>>>>>>>>>>-----*/
			
		$mfsProfit=mysqli_query($con,"SELECT sum(comAmnt) From comission WHERE rp='Received' AND comType='MFS Comission' AND comDate BETWEEN '$StartDate' AND '$EndDate' ");
		$Data=mysqli_fetch_array($mfsProfit); 
		$mfsProfits = $Data['sum(comAmnt)'];


		/*-----<<<<<<<<<<<<<      GETTING Other Comission PROFIT         >>>>>>>>>>>>-----*/
			
		$otherProfit=mysqli_query($con,"SELECT sum(comAmnt) From comission WHERE rp='Received' AND comType='Other Comission' AND comDate BETWEEN '$StartDate' AND '$EndDate' ");
		$Datas=mysqli_fetch_array($otherProfit); 
		$otherComissionReceived = $Datas['sum(comAmnt)'];	
	
		$Card=mysqli_query($con,"SELECT sum(csProLoss) From tbl_cards WHERE csStatus='Sent' AND (csDate BETWEEN '$StartDate' AND '$EndDate' )");
		$Data=mysqli_fetch_array($Card); 
		$cardPL = $Data['sum(csProLoss)'];
		
		function getMobSimProfit($prodName)
		{
			global $selectedMonth;
			global $StartDate;
			global $EndDate;
			global $con;
			$Prod=$prodName;
			$sumAllOpenCost=0;	$sumAllPrCost=0;	$sumOpPrCost=0;	$sumTotSale=0;	$sumSaleCost=0;	$totalRemInvestMob=0;	
			
			
			$sql = mysqli_query($con,"SELECT typeName FROM types WHERE productName='$Prod' ")or die(mysqli_query());
			WHILE($Data=mysqli_fetch_array($sql))
			{
				$open=0;
				
				$subType=$Data['typeName'];
			// getting purchase price
					$q = mysqli_query($con,"SELECT purchasePrice from rates WHERE pName= '$Prod' AND spName='$subType' ORDER BY rtID DESC LIMIT 1 ")or die(mysqli_query());	
					$r=mysqli_fetch_array($q);
				$rt1=$r['purchasePrice'];
			
			// getting opening stock
					$q = mysqli_query($con,"SELECT * from openingclosing WHERE ocType= '$Prod' AND oMonth='$selectedMonth' AND ocEmp='$subType' ORDER BY ocID DESC LIMIT 1 ")or die(mysqli_query());	
					$d=mysqli_fetch_array($q);
				$open=$d['ocAmnt'];
			
			// getting purchases during current month
					$q = mysqli_query($con,"SELECT sum(qty) from tbl_product_stock WHERE pSubType='$subType' AND trtype='Received' AND sDate BETWEEN '$StartDate' AND '$EndDate'  ")or die(mysqli_query());	
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
					$q = mysqli_query($con,"SELECT * from tbl_product_stock WHERE pSubType='$subType' AND trtype='Sent' AND sDate BETWEEN '$StartDate' AND '$EndDate'  ")or die(mysqli_query());	
					WHILE($d=mysqli_fetch_array($q))
					{
						$qw = mysqli_query($con,"SELECT purchasePrice from rates WHERE pName= '$Prod' AND spName='$subType' ORDER BY rtID DESC LIMIT 1 ")or die(mysqli_query());	
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
					$q = mysqli_query($con,"SELECT sum(rpAmnt) from receiptpayment WHERE rpFor='$Prod' AND rpStatus='ReceivedFrom' AND rpDate BETWEEN '$StartDate' AND '$EndDate'  ")or die(mysqli_query());	
					$d=mysqli_fetch_array($q);
					$colSum=$d['sum(rpAmnt)'];
				
			$totalRemInvestMob=$sumOpPrCost-$sumSaleCost;	
			$MobInvest=	$sumOpPrCost-$colSum;
			
			//$mobClosingstock=$MobInvest;
			$mobClosingstock=$totalRemInvestMob;
			$MobProLoss=$sumTotSale-$sumSaleCost;
			return $MobProLoss;
		}
		
		
		$sqlexp = mysqli_query($con,"SELECT sum(amnt) FROM regularexp WHERE  type='expense' AND expDate BETWEEN '$StartDate' AND '$EndDate'")or die(mysqli_query());
		$Dataexp=mysqli_fetch_array($sqlexp);
		$regularExpenses=$Dataexp['sum(amnt)'];
		
		
	
		$strPL_Stock.='<tr>';
		$strPL_Stock.='<td><b>';
		$strPL_Stock.='Stock Details';
		$strPL_Stock.='</b></td>';
		$strPL_Stock.='<td><b>';
		$strPL_Stock.='Profit/Loss';
		$strPL_Stock.='</b></td>';
		$strPL_Stock.='<td><b>';
		$strPL_Stock.='Amount';
		$strPL_Stock.='</b></td>';
		$strPL_Stock.='<td><b>';
		$strPL_Stock.='Investment';
		$strPL_Stock.='</b></td>';
		$strPL_Stock.='<td><b>';
		$strPL_Stock.='Amount';
		$strPL_Stock.='</b></td>';
	
		$strPL_Stock.='<tr>';		
		$strPL_Stock.='<td rowspan="12">';
		//$strPL_Stock.='MFS: '.$totalMfsCloseHere;
		$strPL_Stock.=calcStock('SIM', $dateFirst,$EndDate,$selectedMonth);
		$strPL_Stock.=calcStock('Mobile', $dateFirst,$EndDate,$selectedMonth);
		$strPL_Stock.=calcStock('Card', $dateFirst,$EndDate,$selectedMonth);
		//$str.='</table>';
		$strPL_Stock.='</td>';
		$strPL_Stock.='<td>';
		$strPL_Stock.='Load Profit';
		$strPL_Stock.='</td>';
		$strPL_Stock.='<td>';
		$strPL_Stock.=round($netProfit,2);
		$strPL_Stock.='</td>';
		$strPL_Stock.='<td>';
		$strPL_Stock.='Mob-Load:';
		$strPL_Stock.='</td>';
		$strPL_Stock.='<td>';
		$strPL_Stock.=round($OtarInvestLessMargin,0);
		$strPL_Stock.='</td>';
		$strPL_Stock.='</tr>';
		
		$strPL_Stock.='<tr>';
		$strPL_Stock.='<td>';
		$strPL_Stock.='MFS Profit';
		$strPL_Stock.='</td>';
		$strPL_Stock.='<td>';
		$strPL_Stock.=round($mfsProfits,2);
		$strPL_Stock.='</td>';
		$strPL_Stock.='<td>';
		$strPL_Stock.='MFS:';
		$strPL_Stock.='</td>';
		$strPL_Stock.='<td>';
		$strPL_Stock.=round($mfsinvestment,0);
		$strPL_Stock.='</td>';
		$strPL_Stock.='</tr>';

		$strPL_Stock.='<tr>';
		$strPL_Stock.='<td>';
		$strPL_Stock.='SIMs Profit';
		$strPL_Stock.='</td>';
		$strPL_Stock.='<td>';
				$simProfitToday=getMobSimProfit('SIM');
		$strPL_Stock.=$simProfitToday;
		//$strPL_Stock.=round(10,2);
		$strPL_Stock.='</td>';
		$strPL_Stock.='<td>';
		$strPL_Stock.='SIMs:';
		$strPL_Stock.='</td>';
		$strPL_Stock.='<td>';
		$strPL_Stock.=$simStkAmnt;
		$strPL_Stock.='</td>';
		
		$strPL_Stock.='</tr>';
				
		$strPL_Stock.='<tr>';
		$strPL_Stock.='<td>';
		$strPL_Stock.='Devices Profit';
		$strPL_Stock.='</td>';
		$strPL_Stock.='<td>';
				$mobProfitToday=getMobSimProfit('Mobile');
		$strPL_Stock.=$mobProfitToday;
		//$strPL_Stock.=round($MobProLoss,2);
		$strPL_Stock.='</td>';
		$strPL_Stock.='<td>';
		$strPL_Stock.='Devices:';
		$strPL_Stock.='</td>';
		$strPL_Stock.='<td>';
		$strPL_Stock.=$mobileStkAmnt;
		$strPL_Stock.='</td>';
		$strPL_Stock.='</tr>';
		
		$strPL_Stock.='<tr>';
		$strPL_Stock.='<td>';
		$strPL_Stock.='Card Profit';
		$strPL_Stock.='</td>';
		$strPL_Stock.='<td>';
		$strPL_Stock.=round($cardPL,2);
		$strPL_Stock.='</td>';
		$strPL_Stock.='<td>';
		$strPL_Stock.='Cards:';
		$strPL_Stock.='</td>';
		$strPL_Stock.='<td>';
		$strPL_Stock.=$cardStkAmnt;
		$strPL_Stock.='</td>';
		$strPL_Stock.='</tr>';

		$strPL_Stock.='<tr>';
		$strPL_Stock.='<td>';
		$strPL_Stock.='Other Comission';
		$strPL_Stock.='</td>';
		$strPL_Stock.='<td>';
		$strPL_Stock.=round($otherComissionReceived,2);
		$strPL_Stock.='</td>';
		$strPL_Stock.='<td>';
		$strPL_Stock.='LMC Dues:';
		$strPL_Stock.='</td>';
		$strPL_Stock.='<td>';
		$strPL_Stock.=$totalCash;
		$strPL_Stock.='</td>';
		$strPL_Stock.='</tr>';
		
				$totalProfit=round($netProfit,2)+round($mfsProfits,2)+$simProfitToday+$mobProfitToday+round($cardPL,2)+round($otherComissionReceived,2);
		$strPL_Stock.='<tr>';
		$strPL_Stock.='<td><b>';
		$strPL_Stock.='Gross Profit:';
		$strPL_Stock.='</b></td>';
		$strPL_Stock.='<td> <b>';
		$strPL_Stock.=round($totalProfit,2);
		$strPL_Stock.='<b></td>';
		$strPL_Stock.='<td>';
		$strPL_Stock.='Device Dues:';
		$strPL_Stock.='</td>';
		$strPL_Stock.='<td>';
		$strPL_Stock.=$totalMobile;
		$strPL_Stock.='</td>';
		$strPL_Stock.='</tr>';
		
		$strPL_Stock.='<tr>';
		$strPL_Stock.='<td>';
		$strPL_Stock.='Tax Paid';
		$strPL_Stock.='</td>';
		$strPL_Stock.='<td>';
		$strPL_Stock.=round($taxAmnt,2);
		$strPL_Stock.='</td>';
		$strPL_Stock.='<td>';
		$strPL_Stock.='SIM Dues:';
		$strPL_Stock.='</td>';
		$strPL_Stock.='<td>';
		$strPL_Stock.=$totalSIM;
		$strPL_Stock.='</td>';
		$strPL_Stock.='</tr>';
		
		$strPL_Stock.='<tr>';
		$strPL_Stock.='<td>';
		$strPL_Stock.='Exp Paid';
		$strPL_Stock.='</td>';
		$strPL_Stock.='<td>';
		$strPL_Stock.=round($regularExpenses,2);
		$strPL_Stock.='</td>';
		$strPL_Stock.='<td>';
		$strPL_Stock.='DO-Advance:';
		$strPL_Stock.='</td>';
		$strPL_Stock.='<td>';
		$strPL_Stock.=$totalDoDues;
		$strPL_Stock.='</td>';
		$strPL_Stock.='</tr>';
				
		$strPL_Stock.='<tr>';
		$strPL_Stock.='<td>';
		$strPL_Stock.='Salary Paid';
		$strPL_Stock.='</td>';
		$strPL_Stock.='<td>';
		$strPL_Stock.=0;
		$strPL_Stock.='</td>';
		$strPL_Stock.='<td>';
		$strPL_Stock.='Cards Dues:';
		$strPL_Stock.='</td>';
		$strPL_Stock.='<td>';
		$strPL_Stock.=$totalCard;
		$strPL_Stock.='</td>';
		$strPL_Stock.='</tr>';
				$totalExp=round($taxAmnt,2)+round($regularExpenses,2);
		$strPL_Stock.='<tr>';
		$strPL_Stock.='<td><b>';
		$strPL_Stock.='Total Exp:';
		$strPL_Stock.='</b></td>';
		$strPL_Stock.='<td><b>';
		$strPL_Stock.=$totalExp;
		$strPL_Stock.='</b></td>';
		$strPL_Stock.='<td>';
		$strPL_Stock.='Bank Closing';
		$strPL_Stock.='</td>';
		$strPL_Stock.='<td>';
		$strPL_Stock.=$BankClosing;
		$strPL_Stock.='</td>';
		$strPL_Stock.='</tr>';		
				$runningInvestment=round($OtarInvestLessMargin,0)+round($mfsinvestment,0)+$simStkAmnt+$mobileStkAmnt+$cardStkAmnt+$totalCash+$totalMobile+$totalSIM+$totalDoDues+$totalCard+$BankClosing;	
				$netProfit=$totalProfit-$totalExp;
		$strPL_Stock.='<tr>';
		$strPL_Stock.='<td><h3>';
		$strPL_Stock.='Net Profit';
		$strPL_Stock.='</h3></td>';
		$strPL_Stock.='<td><h3>';
		$strPL_Stock.=round($netProfit,2);
		$strPL_Stock.='</h3></td>';
		$strPL_Stock.='<td>';
		$strPL_Stock.='Current Investment';
		$strPL_Stock.='</td>';
		$strPL_Stock.='<td>';
		$strPL_Stock.=$runningInvestment;
		$strPL_Stock.='</td>';
		$strPL_Stock.='</tr>';
	
			//$strPL_Stock.='MFS: <b>'.round($mfsinvestment,0).'</b></br>';
			//$strPL_Stock.=calcStock('Card', $dateFirst,$EndDate,$selectedMonth);
			//$strPL_Stock.=calcStock('Mobile', $dateFirst,$EndDate,$selectedMonth);
			//$strPL_Stock.=calcStock('SIM', $dateFirst,$EndDate,$selectedMonth);
		
		$strPL_Stock.='</tr>';
		//$strPL_Stock.='<div></div>';
		
		
	
		
	}
?>