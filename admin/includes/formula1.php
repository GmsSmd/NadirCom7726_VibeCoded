<?php
include_once('includes/variables.php');
include_once('globalvar.php');



				/*/\/\/\/\/\/\/\/\/     Purchases summary Module       \/\/\/\/\/\/\/\/\*/

if (isset($_POST['ShowOtarPurchases']))
		{
			$StartDate=$_POST['txtDateFrom'];
			$EndDate=$_POST['txtDateTo'];
			$NewQuery=" SELECT * FROM tbl_mobile_load WHERE loadStatus='Received' AND loadEmp= '$parentCompany' AND loadDate BETWEEN '$StartDate' AND '$EndDate' ";
		}

if (isset($_POST['ShowmfsPurchases']))
		{
			$StartDate=$_POST['txtDateFrom'];
			$EndDate=$_POST['txtDateTo'];
			$NewQuery=" SELECT * FROM tbl_financial_service WHERE mfsStatus='Received' AND mfsEmp= '$parentCompany' AND mfsDate BETWEEN '$StartDate' AND '$EndDate' ";
		}

if (isset($_POST['ShowCardPurchases']))
		{
			$StartDate=$_POST['txtDateFrom'];
			$EndDate=$_POST['txtDateTo'];
			$stSelect=$_POST['SubPselect'];

			if($stSelect=='---')
				$NewQuery=" SELECT * FROM tbl_cards WHERE csStatus='Received' AND csDate BETWEEN '$StartDate' AND '$EndDate' ";
			else
				$NewQuery=" SELECT * FROM tbl_cards WHERE csStatus='Received' AND csType='$stSelect' AND csDate BETWEEN '$StartDate' AND '$EndDate' ";
		}


if (isset($_POST['ShowMobilePurchases']))
		{
			$StartDate=$_POST['txtDateFrom'];
			$EndDate=$_POST['txtDateTo'];
			$stSelect=$_POST['SubPselect'];

			if($stSelect=='---')
				$NewQuery=" SELECT * FROM tbl_product_stock WHERE trtype='Received' AND pName='Mobile' AND sDate BETWEEN '$StartDate' AND '$EndDate' ";
			else
				$NewQuery=" SELECT * FROM tbl_product_stock WHERE trtype='Received' AND pName='Mobile' AND pSubType='$stSelect' AND sDate BETWEEN '$StartDate' AND '$EndDate' ";
		}

if (isset($_POST['ShowsIMPurchases']))
		{
			$StartDate=$_POST['txtDateFrom'];
			$EndDate=$_POST['txtDateTo'];
			$stSelect=$_POST['SubPselect'];

			if($stSelect=='---')
				$NewQuery=" SELECT * FROM tbl_product_stock WHERE trtype='Received' AND pName='SIM' AND sDate BETWEEN '$StartDate' AND '$EndDate' ";
			else
				$NewQuery=" SELECT * FROM tbl_product_stock WHERE trtype='Received' AND pName='SIM' AND pSubType='$stSelect' AND sDate BETWEEN '$StartDate' AND '$EndDate' ";
		}

		
		
		
		
		
		
		
		
				/*/\/\/\/\/\/\/\/\/     Sale summary Module       \/\/\/\/\/\/\/\/\*/

if (isset($_POST['ShowOtarSales']))
		{
			$StartDate=$_POST['txtDateFrom'];
			$EndDate=$_POST['txtDateTo'];
			$empNow=$_POST['EmpSelect'];
				if($empNow=='---')
					
					$NewQuery=" SELECT * FROM tbl_mobile_load WHERE loadStatus='Sent' AND loadDate BETWEEN '$StartDate' AND '$EndDate' ORDER BY loadID ASC ";
					
				else
					
					$NewQuery=" SELECT * FROM tbl_mobile_load WHERE loadStatus='Sent' AND loadEmp= '$empNow' AND loadDate BETWEEN '$StartDate' AND '$EndDate' ORDER BY loadID ASC ";
					
		}

if (isset($_POST['ShowmfsSales']))
		{
			$StartDate=$_POST['txtDateFrom'];
			$EndDate=$_POST['txtDateTo'];
			$empNow=$_POST['EmpSelect'];
				if($empNow=='---')
					{
					$NewQuery=" SELECT * FROM tbl_financial_service WHERE mfsStatus='Sent' AND mfsDate BETWEEN '$StartDate' AND '$EndDate' ORDER BY mfsID ASC ";
					$NewQuery1=" SELECT * FROM tbl_financial_service WHERE mfsStatus='Received' AND mfsEmp!='$parentCompany' AND mfsDate BETWEEN '$StartDate' AND '$EndDate' ORDER BY mfsID ASC ";
					}
				else
					{
					$NewQuery=" SELECT * FROM tbl_financial_service WHERE mfsStatus='Sent' AND mfsEmp='$empNow' AND mfsDate BETWEEN '$StartDate' AND '$EndDate' ORDER BY mfsID ASC ";
					$NewQuery1=" SELECT * FROM tbl_financial_service WHERE mfsStatus='Received' AND mfsEmp='$empNow' AND mfsDate BETWEEN '$StartDate' AND '$EndDate' ORDER BY mfsID ASC ";
					}
		}

if (isset($_POST['Showtbl_cardss']))
		{
			$StartDate=$_POST['txtDateFrom'];
			$EndDate=$_POST['txtDateTo'];
			$empNow=$_POST['EmpSelect'];
			$stSelect=$_POST['SubPselect'];

				if($empNow!='---' AND $stSelect!='---')
					$NewQuery=" SELECT * FROM tbl_cards WHERE csStatus='Sent' AND csEmp='$empNow' AND csType='$stSelect' AND csDate BETWEEN '$StartDate' AND '$EndDate' ORDER BY csDate ASC ";
				else if ($empNow=='---' AND $stSelect!='---')
					$NewQuery=" SELECT * FROM tbl_cards WHERE csStatus='Sent' AND csType='$stSelect' AND csDate BETWEEN '$StartDate' AND '$EndDate' ORDER BY csDate ASC ";
				else if ($empNow!='---' AND $stSelect=='---')
					$NewQuery=" SELECT * FROM tbl_cards WHERE csStatus='Sent' AND csEmp='$empNow' AND csDate BETWEEN '$StartDate' AND '$EndDate' ORDER BY csDate ASC ";
				else
					$NewQuery=" SELECT * FROM tbl_cards WHERE csStatus='Sent' AND csDate BETWEEN '$StartDate' AND '$EndDate' ORDER BY csDate ASC ";
		}


if (isset($_POST['ShowMobileSales']))
		{
			$StartDate=$_POST['txtDateFrom'];
			$EndDate=$_POST['txtDateTo'];
			$empNow=$_POST['EmpSelect'];
			$stSelect=$_POST['SubPselect'];

				if($empNow!='---' AND $stSelect!='---')
					$NewQuery=" SELECT * FROM tbl_product_stock WHERE trtype='Sent' AND pName='Mobile' AND customer='$empNow' AND pSubType='$stSelect' AND sDate BETWEEN '$StartDate' AND '$EndDate' ORDER BY sDate ASC";
				else if ($empNow=='---' AND $stSelect!='---')
					$NewQuery=" SELECT * FROM tbl_product_stock WHERE trtype='Sent' AND pName='Mobile' AND pSubType='$stSelect' AND sDate BETWEEN '$StartDate' AND '$EndDate' ORDER BY sDate ASC";
				else if ($empNow!='---' AND $stSelect=='---')
					$NewQuery=" SELECT * FROM tbl_product_stock WHERE trtype='Sent' AND pName='Mobile' AND customer='$empNow' AND sDate BETWEEN '$StartDate' AND '$EndDate' ORDER BY sDate ASC";
				else
					$NewQuery=" SELECT * FROM tbl_product_stock WHERE trtype='Sent' AND pName='Mobile' AND sDate BETWEEN '$StartDate' AND '$EndDate' ORDER BY sDate ASC";
		}

if (isset($_POST['ShowsIMSales']))
		{
			$StartDate=$_POST['txtDateFrom'];
			$EndDate=$_POST['txtDateTo'];
			$empNow=$_POST['EmpSelect'];
			$stSelect=$_POST['SubPselect'];

				if($empNow!='---' AND $stSelect!='---')
					$NewQuery=" SELECT * FROM tbl_product_stock WHERE trtype='Sent' AND pName='SIM' AND customer='$empNow' AND pSubType='$stSelect' AND sDate BETWEEN '$StartDate' AND '$EndDate' ORDER BY sDate ASC";
				else if ($empNow=='---' AND $stSelect!='---')
					$NewQuery=" SELECT * FROM tbl_product_stock WHERE trtype='Sent' AND pName='SIM' AND pSubType='$stSelect' AND sDate BETWEEN '$StartDate' AND '$EndDate' ORDER BY sDate ASC";
				else if ($empNow!='---' AND $stSelect=='---')
					$NewQuery=" SELECT * FROM tbl_product_stock WHERE trtype='Sent' AND pName='SIM' AND customer='$empNow' AND sDate BETWEEN '$StartDate' AND '$EndDate' ORDER BY sDate ASC";
				else
					$NewQuery=" SELECT * FROM tbl_product_stock WHERE trtype='Sent' AND pName='SIM' AND sDate BETWEEN '$StartDate' AND '$EndDate' ORDER BY sDate ASC";
		}
		


		
		
if (isset($_POST['Showstock']))
		{
			$StartDate=$_POST['txtDateFrom'];
			$EndDate=$_POST['txtDateTo'];
		}
		
		
		
		
		
		
		
		

if(isset($_POST['Reset']))
	{
		$_POST = array();
	}
?>