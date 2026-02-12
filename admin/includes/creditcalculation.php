<?php
////////////////////////// THIS ONE IS ALL OK LETS USE IT ////////////////
include_once('globalvar.php');

/*
    
	$qrys0 = mysqli_query($con,"SELECT sum(loadAmnt*(1-pRate)) as loadCredit FROM tbl_mobile_load WHERE purchaseType='Credit';")or die(mysqli_query());
	$Datas0=mysqli_fetch_array($qrys0);
	$loadpending= $Datas0['loadCredit'];        // Otar

	$qrys3 = mysqli_query($con,"SELECT sum(mfsAmnt) FROM tbl_financial_service WHERE purchaseType='Credit';")or die(mysqli_query());
	$Datas3=mysqli_fetch_array($qrys3);
	$mfspending= $Datas3['sum(mfsAmnt)']; // MFS

	$qrys5 = mysqli_query($con,"SELECT sum(csOrgAmnt) FROM tbl_cards WHERE purchaseType='Credit' ")or die(mysqli_query());
	$Datas5=mysqli_fetch_array($qrys5);
	$cardpending= $Datas5['sum(csOrgAmnt)'];	//	Card
	
	$qrys7 = mysqli_query($con,"SELECT SUM(qty*rate) FROM tbl_product_stock WHERE pName='Mobile' AND purchaseType='Credit' ")or die(mysqli_query());
	$Datas7=mysqli_fetch_array($qrys7);
	$mobpending= $Datas7['SUM(qty*rate)'];// Mobile

	$qrys9 = mysqli_query($con,"SELECT SUM(qty*rate) FROM tbl_product_stock WHERE pName='SIM' AND purchaseType='Credit' ")or die(mysqli_query());
	$Datas9=mysqli_fetch_array($qrys9);
	$simpending= $Datas9['SUM(qty*rate)'];// SIM
	
	$companycreditnow=$loadpending+$mfspending+$cardpending+$mobpending+$simpending;

*/

		
		$loadpayables=0;
		$qr1="SELECT loadAmnt AS LoadPurchased, pRate As Rate, round((loadAmnt -(loadAmnt*pRate)),2) as Payable FROM tbl_mobile_load WHERE loadEmp='$parentCompany' AND loadStatus='Received'";
		//echo $qr1;
		$qrys1=mysqli_query($con,$qr1);

			while($datam=mysqli_fetch_array($qrys1))
			{
				$loadpayables=$loadpayables+$datam['Payable'];
			}

		
		$qrys2 = mysqli_query($con,"SELECT SUM(rpAmnt) FROM receiptpayment WHERE rpStatus='PaidTo' AND rpFromTo='$parentCompany' AND rpFor='Otar' AND rpmode='$defaultBankName'")or die(mysqli_query());
		$Datas2=mysqli_fetch_array($qrys2);
		$loadpaidamount= $Datas2['SUM(rpAmnt)'];
		
		$loadpending=$loadpayables-$loadpaidamount;				//	load
		
		
		$qrys3 = mysqli_query($con,"SELECT sum(mfsAmnt) FROM tbl_financial_service WHERE mfsStatus='Received' AND mfsEmp='$parentCompany' AND purchaseType='Credit';")or die(mysqli_query());
		$Datas3=mysqli_fetch_array($qrys3);
		$mfspayables= $Datas3['sum(mfsAmnt)'];
		$mfspending=$mfspayables;

		
		$qrys5 = mysqli_query($con,"SELECT sum(csOrgAmnt) FROM tbl_cards WHERE csStatus='Received' AND csEmp='$parentCompany'")or die(mysqli_query());
		$Datas5=mysqli_fetch_array($qrys5);
		$cardpayables= $Datas5['sum(csOrgAmnt)'];
		
		$qrys6 = mysqli_query($con,"SELECT SUM(rpAmnt) FROM receiptpayment WHERE rpStatus='PaidTo' AND rpFromTo='$parentCompany' AND rpmode='$defaultBankName' AND rpFor='Card'")or die(mysqli_query());
		$Datas6=mysqli_fetch_array($qrys6);
		$cardpaidamount= $Datas6['SUM(rpAmnt)'];
		
		$cardpending=$cardpayables-$cardpaidamount;				//	Card
		
		$qrys7 = mysqli_query($con,"SELECT SUM(qty*rate) FROM tbl_product_stock WHERE pName='Mobile' AND trType='Received' AND customer='$parentCompany'")or die(mysqli_query());
		$Datas7=mysqli_fetch_array($qrys7);
		$mobpayables= $Datas7['SUM(qty*rate)'];
		
		$qrys8 = mysqli_query($con,"SELECT SUM(rpAmnt) FROM receiptpayment WHERE rpStatus='PaidTo' AND rpFromTo='$parentCompany' AND rpmode='$defaultBankName' AND rpFor='Mobile'")or die(mysqli_query());
		$Datas8=mysqli_fetch_array($qrys8);
		$mobpaidamount= $Datas8['SUM(rpAmnt)'];
		
		$mobpending=$mobpayables-$mobpaidamount;				// Mobile
		//echo $mobpending;
		
		$qrys9 = mysqli_query($con,"SELECT SUM(qty*rate) FROM tbl_product_stock WHERE pName='SIM' AND trType='Received' AND customer='$parentCompany'")or die(mysqli_query());
		$Datas9=mysqli_fetch_array($qrys9);
		$simpayables= $Datas9['SUM(qty*rate)'];
		
		$qrys10 = mysqli_query($con,"SELECT SUM(rpAmnt) FROM receiptpayment WHERE rpStatus='PaidTo' AND rpFromTo='$parentCompany' AND rpmode='$defaultBankName' AND rpFor='SIM'")or die(mysqli_query());
		$Datas10=mysqli_fetch_array($qrys10);
		$simpaidamount= $Datas10['SUM(rpAmnt)'];
		
		$simpending=$simpayables-$simpaidamount;				// SIM
		
		
		$companycreditnow=$loadpending+$mfspending+$cardpending+$mobpending+$simpending;
?>