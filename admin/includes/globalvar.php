<?php
include_once('dbcon.php');

$orgnization_name="JS Communication";
$master_line_num="923027105678";

//$qry = mysqli_query($con,"SELECT * FROM config") or die(mysqli_error());
//$Data=mysqli_fetch_assoc($qry);

//$parentCompany=$Data['company'];
//$childOrganization=$Data['organization'];
//$defaultBankName=$Data['defaultbank'];

$qry = mysqli_query($con,"SELECT customName FROM config WHERE name='company';") or die(mysqli_error());
$Data=mysqli_fetch_assoc($qry);
$parentCompany=$Data['customName'];

$qry = mysqli_query($con,"SELECT customName FROM config WHERE name='organization';") or die(mysqli_error());
$Data=mysqli_fetch_assoc($qry);
$childOrganization=$Data['customName'];

$qry = mysqli_query($con,"SELECT customName FROM config WHERE name='defaultBank';") or die(mysqli_error());
$Data=mysqli_fetch_assoc($qry);
$defaultBankName=$Data['customName'];

$qry = mysqli_query($con,"SELECT customName FROM config WHERE name='mobLoad';") or die(mysqli_error());
$Data=mysqli_fetch_assoc($qry);
$mobLoadName=$Data['customName'];				/* <?php echo $mobLoadName; ?> */

$qry = mysqli_query($con,"SELECT customName FROM config WHERE name='finalcialService';") or die(mysqli_error());
$Data=mysqli_fetch_assoc($qry);
$finanCialServiceName=$Data['customName'];		/* <?php echo $finanCialServiceName; ?> */

$qry = mysqli_query($con,"SELECT customName FROM config WHERE name='scratchCard';") or die(mysqli_error());
$Data=mysqli_fetch_assoc($qry);
$scratchCardName=$Data['customName'];			/* <?php echo $scratchCardName; ?> */

$qry = mysqli_query($con,"SELECT customName FROM config WHERE name='mobileDevices';") or die(mysqli_error());
$Data=mysqli_fetch_assoc($qry);
$mobileDevicesName=$Data['customName'];			/* <?php echo $mobileDevicesName; ?> */

$qry = mysqli_query($con,"SELECT customName FROM config WHERE name='sim';") or die(mysqli_error());
$Data=mysqli_fetch_assoc($qry);
$simsName=$Data['customName'];	



function calcStocks($product, $DateFrom,$DateTo,$Month)
{
	global $con;
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
			{													
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
				echo $subType.":  ";
				echo "<b>".$cl."</b>";
				echo "<br>";
				}
				$opQtySum=$opQtySum + $open;
				$opAmntSum=$opAmntSum + $opAmnt;
				$pQtySum=$pQtySum + $purchz;
				$pAmntSum=$pAmntSum + $prAmnt;
				$sQtySum=$sQtySum + $qt2;
				$sAmntSum=$sAmntSum + $slAmnt;
				$cQtySum=$cQtySum + $cl;
				$cAmntSum=$cAmntSum + $clAmnt;
				}
			}
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
		{													
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
				echo $subType.":  ";
				echo "<b>".$cl."</b>";
				echo "<br>";
				}
				$opQtySum=$opQtySum + $open;
				$opAmntSum=$opAmntSum + $opAmnt;
				$pQtySum=$pQtySum + $purchz;
				$pAmntSum=$pAmntSum + $prAmnt;
				$sQtySum=$sQtySum + $Sumqt2;
				$sAmntSum=$sAmntSum + $slAmnt;
				$cQtySum=$cQtySum + $cl;
				$cAmntSum=$cAmntSum + $clAmnt;
			}
		}
		$q = mysqli_query($con,"SELECT sum(rpAmnt) from receiptpayment WHERE rpFor='$pNameHere' AND rpStatus='ReceivedFrom' AND rpDate BETWEEN '$StartDate' AND '$EndDate'  ")or die(mysqli_query());	
		$d=mysqli_fetch_array($q);
		$colSum=$d['sum(rpAmnt)'];
	}
}









?>