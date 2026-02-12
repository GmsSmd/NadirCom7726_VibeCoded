<?php
//session_start();
include_once('variables.php');
include_once('globalvar.php');
//if($Employee=="do")
	//echo '<script type="text/javascript">alert("Please First Select a do then perform additional working.");</script>';

/*         <<<<<<<<<<<<  THIS IS target MODULE   >>>>>>>>>>>>>>>      */

if (isset($_POST['addtarget']))
{
	$tgtMonth=$_POST['MonthSelect'];
	$EmpName=$_POST['EmpSelect'];
	$OtartgtAmnt=$_POST['txtOtartgtAmnt'];
	$mfsTgtAmnt=$_POST['txtmfsTgtAmnt'];
	$othergtType=$_POST['OthertgtSelect'];
	$othergtAmnt=$_POST['txtOthertgtAmnt'];
	
	
		
	// Check if all data fields have been filled or not
	
	if ($EmpName== "---")
			{ echo '<script type="text/javascript">alert("Please Select an option from \"target For:\" drop down.");</script>'; }
	else
	{
		if($OtartgtAmnt > 0 && $mfsTgtAmnt > 0)
			{
				if ($othergtType!="---")
					{
					$columnsToAdd="tgtMonth, tgtType, tgtEmp, tgtAmnt";
					$valuesToAdd= " '$tgtMonth','$othergtType', '$EmpName',$othergtAmnt";
					$sq = mysqli_query($con,"INSErt INTO target($columnsToAdd) values($valuesToAdd)")or die(mysqli_query());
					echo '<script type="text/javascript">alert("'.$othergtType.' target Amounting Rs. '.$othergtAmnt.' Sucessfully entered.");</script>';
					
					$columnsToAdd="tgtMonth, tgtType, tgtEmp, tgtAmnt";
					$valuesToAdd= " '$tgtMonth','Otar', '$EmpName',$OtartgtAmnt";
					$sq = mysqli_query($con,"INSErt INTO target($columnsToAdd) values($valuesToAdd)")or die(mysqli_query());
					
					$columnsToAdd="tgtMonth, tgtType, tgtEmp, tgtAmnt";
					$valuesToAdd= " '$tgtMonth','mfs', '$EmpName',$mfsTgtAmnt";
					$sq = mysqli_query($con,"INSErt INTO target($columnsToAdd) values($valuesToAdd)")or die(mysqli_query());
					
					echo '<script type="text/javascript">alert("Otar target '.$OtartgtAmnt.' and mfs target '.$mfsTgtAmnt.' Successfully Entered");</script>';
					}
				else
				{
					$columnsToAdd="tgtMonth, tgtType, tgtEmp, tgtAmnt";
					$valuesToAdd= " '$tgtMonth','Otar', '$EmpName',$OtartgtAmnt";
					$sq = mysqli_query($con,"INSErt INTO target($columnsToAdd) values($valuesToAdd)")or die(mysqli_query());
					
					$columnsToAdd="tgtMonth, tgtType, tgtEmp, tgtAmnt";
					$valuesToAdd= " '$tgtMonth','mfs', '$EmpName',$mfsTgtAmnt";
					$sq = mysqli_query($con,"INSErt INTO target($columnsToAdd) values($valuesToAdd)")or die(mysqli_query());
					
					echo '<script type="text/javascript">alert("Otar target '.$OtartgtAmnt.' and mfs target '.$mfsTgtAmnt.' Successfully Entered");</script>';
				}
			
			}
		else if($OtartgtAmnt > 0 && $mfsTgtAmnt == "")
			{
				if ($othergtType!="---")
					{
					$columnsToAdd="tgtMonth, tgtType, tgtEmp, tgtAmnt";
					$valuesToAdd= " '$tgtMonth','$othergtType', '$EmpName',$othergtAmnt";
					$sq = mysqli_query($con,"INSErt INTO target($columnsToAdd) values($valuesToAdd)")or die(mysqli_query());
					echo '<script type="text/javascript">alert("'.$othergtType.' target Amounting Rs. '.$othergtAmnt.' Sucessfully entered.");</script>';
					
					$columnsToAdd="tgtMonth, tgtType, tgtEmp, tgtAmnt";
					$valuesToAdd= " '$tgtMonth','Otar', '$EmpName',$OtartgtAmnt";
					$sq = mysqli_query($con,"INSErt INTO target($columnsToAdd) values($valuesToAdd)")or die(mysqli_query());
					
					echo '<script type="text/javascript">alert("Otar target '.$OtartgtAmnt.' and mfs target '.$mfsTgtAmnt.' Successfully Entered");</script>';
					}
				else
				{
					$columnsToAdd="tgtMonth, tgtType, tgtEmp, tgtAmnt";
					$valuesToAdd= " '$tgtMonth','Otar', '$EmpName',$OtartgtAmnt";
					$sq = mysqli_query($con,"INSErt INTO target($columnsToAdd) values($valuesToAdd)")or die(mysqli_query());
					echo '<script type="text/javascript">alert("Otar target '.$OtartgtAmnt.' Successfully Entered");</script>';
				}
				
				
			}
		else if($OtartgtAmnt == "" && $mfsTgtAmnt > 0)
			{
				if ($othergtType!="---")
					{
					$columnsToAdd="tgtMonth, tgtType, tgtEmp, tgtAmnt";
					$valuesToAdd= " '$tgtMonth','$othergtType', '$EmpName',$othergtAmnt";
					$sq = mysqli_query($con,"INSErt INTO target($columnsToAdd) values($valuesToAdd)")or die(mysqli_query());
					echo '<script type="text/javascript">alert("'.$othergtType.' target Amounting Rs. '.$othergtAmnt.' Sucessfully entered.");</script>';
					
					$columnsToAdd="tgtMonth, tgtType, tgtEmp, tgtAmnt";
					$valuesToAdd= " '$tgtMonth','mfs', '$EmpName',$mfsTgtAmnt";
					$sq = mysqli_query($con,"INSErt INTO target($columnsToAdd) values($valuesToAdd)")or die(mysqli_query());
					
					echo '<script type="text/javascript">alert("mfs target '.$mfsTgtAmnt.' Successfully Entered");</script>';
					}
				else
				{
					$columnsToAdd="tgtMonth, tgtType, tgtEmp, tgtAmnt";
					$valuesToAdd= " '$tgtMonth','mfs', '$EmpName',$mfsTgtAmnt";
					$sq = mysqli_query($con,"INSErt INTO target($columnsToAdd) values($valuesToAdd)")or die(mysqli_query());
					
					echo '<script type="text/javascript">alert("mfs target '.$mfsTgtAmnt.' Successfully Entered");</script>';
				}
			}	
			
		else
		{
			if ($othergtType != "---")
			{
			$columnsToAdd="tgtMonth, tgtType, tgtEmp, tgtAmnt";
			$valuesToAdd= " '$tgtMonth','$othergtType', '$EmpName',$othergtAmnt" ;
			$sq = mysqli_query($con,"INSErt INTO target($columnsToAdd) values($valuesToAdd)")or die(mysqli_query());
			echo '<script type="text/javascript">alert("'.$othergtType.' target Amounting Rs. '.$othergtAmnt.' Sucessfully entered.");</script>';
			}
			else
			{
				echo '<script type="text/javascript">alert("No Option Selected.");</script>';
			}
			
		}
		
		
	}
	
}








/*         <<<<<<<<<<<<  THIS IS RECEIPT MODULE   >>>>>>>>>>>>>>>      */

if (isset($_POST['SaveReceipt']))
{
	$tempEmpName=$Employee;
	$dateNow=$_POST['txtDate'];
				if ($dateNow=="")
					$dateNow=date('Y-m-d');
	$tmptxtAmntReceived=$_POST['txtAmntReceived'];
	$tempFor=$_POST['rfSelect'];
	$tempMode=$_POST['modeSelect'];
	$tmptxtNotes=$_POST['txtNotes'];
	$status="ReceivedFrom";
	$user=$currentUser;
	
	// Check if all data fields have been filled or not
	
	if ($tempFor== "---")
			{ echo '<script type="text/javascript">alert("Please Select an option from \"Received For\" drop down.");</script>'; }
	else if ($tempMode== "---")
			{ echo '<script type="text/javascript">alert("Please Select Receive Mode from \"Receive Mode\" box.");</script>'; }
	else if ($tmptxtAmntReceived== "")
			{ echo '<script type="text/javascript">alert("Please Enter any amount in \"Amount Received\" box.");</script>'; }
	else
	{
		$columnsToAdd="rpFor,rpDate, rpStatus, rpFromTo, rpAmnt, rpmode, rpUser, rpNotes";
		$valuesToAdd= "'$tempFor', '$dateNow','$status', '$tempEmpName',$tmptxtAmntReceived,'$tempMode','$user','$tmptxtNotes' ";
		//echo "$columnsToAdd". "<br>"."$valuesToAdd";
		
		$sq = mysqli_query($con,"INSErt INTO receiptpayment($columnsToAdd) values($valuesToAdd)")or die(mysqli_query());
		echo '<script type="text/javascript">alert("Successfully Entered");</script>';
	}
}
if(isset($_POST['ResetReceipt']))
{
	$_POST = array();
}


if (isset($_POST['Showreceipts']))
{
	$tempEmpName=$_POST['empSelect'];
	$dateFrom=$_POST['txtDateFrom'];
	$dateTo=$_POST['txtDateTo'];
	$order=$_POST['orderBySelect'];
	if($order=="Date")
		$orderBy="rpDate";
	else if($order=="Received From")
		$orderBy="rpFromTo";
	else if($order=="Amount")
		$orderBy="rpAmnt";
	
	if	($tempEmpName=="---")
	{	$receiptsummaryflag=1;
		$receiptsummary ="SELECT * FROM receiptpayment WHERE rpStatus=\"ReceivedFrom\" AND rpDate BETWEEN \"$dateFrom\" AND \"$dateTo\" ORDER BY $orderBy";
	}
	else
	{
		$receiptsummaryflag=1;
		$receiptsummary = "SELECT * FROM receiptpayment WHERE rpStatus=\"ReceivedFrom\" AND rpFromTo=\"$tempEmpName\" AND rpDate BETWEEN \"$dateFrom\" AND \"$dateTo\" ORDER BY $orderBy";
	}
}



/*         <<<<<<<<<<<<  THIS IS PAYMENT MODULE   >>>>>>>>>>>>>>>      */


if (isset($_POST['SavePayment']))
{
	$tempEmpName=$_POST['empSelect'];
	$dateNow=$_POST['txtDate'];
				if ($dateNow=="")
					$dateNow=date('Y-m-d');
	$tmptxtAmntPaid=$_POST['txtAmntPaid'];
	$tempMode=$_POST['modeSelect'];
	$tmptxtNotes=$_POST['txtNotes'];
		if ($tmptxtNotes== "")
			{ $tmptxtNotes="Empty"; }
	$status="PaidTo";
	$user=$currentUser;
	
	// Check if all data fields have been filled or not
	
	if ($tempEmpName== "---")
			{ echo '<script type="text/javascript">alert("Please Select an option from \"Paid To\" drop down.");</script>'; }
	else if ($tempMode== "---")
			{ echo '<script type="text/javascript">alert("Please Select an option from \"Payment Mode\" box.");</script>'; }
	else if ($tmptxtAmntPaid== "")
			{ echo '<script type="text/javascript">alert("Please Enter any amount in \"Amount Paid\" box.");</script>'; }
	else
	{
		$columnsToAdd="rpDate, rpStatus, rpFromTo, rpAmnt, rpmode, rpUser, rpNotes";
		$valuesToAdd= " '$dateNow','$status', '$tempEmpName',$tmptxtAmntPaid,'$tempMode','$user','$tmptxtNotes' ";
		//echo "$columnsToAdd". "<br>"."$valuesToAdd";
		
		$sq = mysqli_query($con,"INSErt INTO receiptpayment($columnsToAdd) values($valuesToAdd)")or die(mysqli_query());
		echo '<script type="text/javascript">alert("Successfully Entered");</script>';
	}
}
if(isset($_POST['ResetPayment']))
{
	$_POST = array();
}	


if (isset($_POST['Showpayments']))
{
	$tempEmpName=$_POST['empSelect'];
	$dateFrom=$_POST['txtDateFrom'];
	$dateTo=$_POST['txtDateTo'];
	$order=$_POST['orderBySelect'];
	if($order=="Date")
		$orderBy="rpDate";
	else if($order=="Paid To")
		$orderBy="rpFromTo";
	else if($order=="Amount")
		$orderBy="rpAmnt";
	
	if	($tempEmpName=="---")
	{	$paidsummaryflag=1;
		$paidsummary ="SELECT * FROM receiptpayment WHERE rpStatus=\"PaidTo\" AND rpDate BETWEEN \"$dateFrom\" AND \"$dateTo\" ORDER BY $orderBy";
	}
	else
	{
		$paidsummaryflag=1;
		$paidsummary = "SELECT * FROM receiptpayment WHERE rpStatus=\"PaidTo\" AND rpFromTo=\"$tempEmpName\" AND rpDate BETWEEN \"$dateFrom\" AND \"$dateTo\" ORDER BY $orderBy";
	}
}

	
/*   this module is linked with AddWorkDetails.php and is now obsolete */	

if(isset($_POST['SaveData']))
{
	// global variables
	
//	global $marginSent;
	
	
	
			$tempEmpName=$_POST['doSelect'];
			
			$dateNow=$_POST['txtDate'];
				if ($dateNow=="")
					$dateNow=date('Y-m-d');
			$tmptxtLoad=$_POST['txtLoad'];
			
			$loadTransfer= $tmptxtLoad + ( $tmptxtLoad * $marginSent);
			$franchiseProfitRate= $marginReceived - $marginSent;
			$franchiseProfitAmnt= $tmptxtLoad * $franchiseProfitRate;
			$excessProfitAmnt= ($loadTransfer - $tmptxtLoad) * $marginReceived;
			$tmptxtmfsSend=$_POST['txtmfsSend'];
			$tmptxtmfsReceive=$_POST['txtmfsReceive'];
			$mfsClosing= $tmptxtmfsSend - $tmptxtmfsReceive;
			$tmptxtCardQty=$_POST['txtCardQty'];
			$cardorgAmnt= $tmptxtCardQty * $cardPurchaseRate;
			$tmptxttbl_cardsRate=$_POST['txttbl_cardsRate'];
			$cardAmnt= $tmptxtCardQty* $tmptxttbl_cardsRate;
			$cardProLoss= $cardAmnt - $cardorgAmnt;
			
			$q1=mysqli_query($con,"SELECT dueInitial FROM due WHERE dueEmp=\"$tempEmpName\"") or die(mysqli_query());
			WHILE($Data1=mysqli_fetch_array($q1))
			{	$empOpeningBalance =$Data1['dueInitial'];		}
			
			$receivable= $tmptxtLoad+$mfsClosing+$empOpeningBalance;
			
			/*
			$q2=mysqli_query($con,"SELECT takenAmnt FROM taken WHERE takenEmp=\"$tempEmpName\" ") or die(mysqli_query());;
			WHILE($Data2=mysqli_fetch_array($q2))
			{	$taken=$Data2['takenAmnt'];		}
			
			$dues= $receivable-$taken;
*/
	
		$columnsToAdd="trDate, empName, mLoad, mLoadTransfer, mLoadProfit, mLoadExcessProfit, mfsSend, mfsReceive, mfsClosing, cardQty, cardorgAmnt, tbl_cardsRate, cardAmnt, cardProLoss, empOpeningBalance, empReceivable";
		$valuesToAdd=" '$dateNow','$tempEmpName', $tmptxtLoad, $loadTransfer, $franchiseProfitAmnt, $excessProfitAmnt, $tmptxtmfsSend, $tmptxtmfsReceive, $mfsClosing, $tmptxtCardQty, $cardorgAmnt, $tmptxttbl_cardsRate, $cardAmnt, $cardProLoss, $empOpeningBalance, $receivable";
		//echo "$columnsToAdd" ." $valuesToAdd";
		
		
		$sq = mysqli_query($con,"INSErt INTO workDetail($columnsToAdd) values($valuesToAdd)")or die(mysqli_query());
		
		$upDateDue= mysqli_query( " UPDATE due SET dueInitial = $dues WHERE due.dueEmp = \"$tempEmpName\" ")or die(mysqli_query());
		
		
		//echo " UPDATE due SET dueInitial = $dues WHERE due.dueEmp = \"$tempEmpName\"";
		echo "successfully added.";
	}

if(isset($_POST['SaveData']))
{
			$tempEmpName=$_POST['doSelect'];
			
			$dateNow=$_POST['txtDate'];
				if ($dateNow=="")
					$dateNow=date('Y-m-d');
			$tmptxtLoad=$_POST['txtLoad'];
			
			$loadTransfer= $tmptxtLoad + ( $tmptxtLoad * $marginSent);
			$franchiseProfitRate= $marginReceived - $marginSent;
			$franchiseProfitAmnt= $tmptxtLoad * $franchiseProfitRate;
			$excessProfitAmnt= ($loadTransfer - $tmptxtLoad) * $marginReceived;
			$tmptxtmfsSend=$_POST['txtmfsSend'];
			$tmptxtmfsReceive=$_POST['txtmfsReceive'];
			$mfsClosing= $tmptxtmfsSend - $tmptxtmfsReceive;
			$tmptxtCardQty=$_POST['txtCardQty'];
			$cardorgAmnt= $tmptxtCardQty * $cardPurchaseRate;
			$tmptxttbl_cardsRate=$_POST['txttbl_cardsRate'];
			$cardAmnt= $tmptxtCardQty* $tmptxttbl_cardsRate;
			$cardProLoss= $cardAmnt - $cardorgAmnt;
			
			$q1=mysqli_query($con,"SELECT dueInitial FROM due WHERE dueEmp=\"$tempEmpName\"") or die(mysqli_query());
			WHILE($Data1=mysqli_fetch_array($q1))
			{	$empOpeningBalance =$Data1['dueInitial'];		}
			
			$receivable= $tmptxtLoad+$mfsClosing+$empOpeningBalance;
			
			/*
			$q2=mysqli_query($con,"SELECT takenAmnt FROM taken WHERE takenEmp=\"$tempEmpName\" ") or die(mysqli_query());;
			WHILE($Data2=mysqli_fetch_array($q2))
			{	$taken=$Data2['takenAmnt'];		}
			
			$dues= $receivable-$taken;
*/
	
		$columnsToAdd="trDate, empName, mLoad, mLoadTransfer, mLoadProfit, mLoadExcessProfit, mfsSend, mfsReceive, mfsClosing, cardQty, cardorgAmnt, tbl_cardsRate, cardAmnt, cardProLoss, empOpeningBalance, empReceivable";
		$valuesToAdd=" '$dateNow','$tempEmpName', $tmptxtLoad, $loadTransfer, $franchiseProfitAmnt, $excessProfitAmnt, $tmptxtmfsSend, $tmptxtmfsReceive, $mfsClosing, $tmptxtCardQty, $cardorgAmnt, $tmptxttbl_cardsRate, $cardAmnt, $cardProLoss, $empOpeningBalance, $receivable";
		//echo "$columnsToAdd" ." $valuesToAdd";
		
		
		$sq = mysqli_query($con,"INSErt INTO workDetail($columnsToAdd) values($valuesToAdd)")or die(mysqli_query());
		
		$upDateDue= mysqli_query( " UPDATE due SET dueInitial = $dues WHERE due.dueEmp = \"$tempEmpName\" ")or die(mysqli_query());
		
		
		//echo " UPDATE due SET dueInitial = $dues WHERE due.dueEmp = \"$tempEmpName\"";
		echo "successfully added.";
	}

	
	
	
	
	
	
	
	
	
	
/*         <<<<<<<<<<<<  THIS Is lifting MODULE   >>>>>>>>>>>>>>>      */	
	
if (isset($_POST['SaveSendliftingLoad']))
	{
	$tempEmpName=$parentCompany;
	$dateNow=$_POST['txtDate'];
				if ($dateNow=="")
					$dateNow=date('Y-m-d');
	$tmptxtAmntReceived=$_POST['txtAmntReceived'];
	$tempStatus="Received";
	$tmptxtNotes=$_POST['txtNotes'];
		//if ($tmptxtNotes== "")
		//	{ $tmptxtNotes="Empty"; }

	// Check if all data fields have been filled or not
	
	if ($tmptxtAmntReceived== "")
			{ echo '<script type="text/javascript">alert("Please Enter any amount in \"Load Amount:\" box.");</script>'; }
	else
	{
		//$columnsToAdd="loadStatus, loadDate, loadEmp, loadAmnt, loadComments, pRate, sRate,purchaseType,User";
		//$valuesToAdd= " '$tempStatus','$dateNow', '$tempEmpName',$tmptxtAmntReceived,'$tmptxtNotes', $marginReceived,$marginSent,'Cash','$currentUser'";
		//echo "<br/><br/><br/> $columnsToAdd". "<br>"."$valuesToAdd";
		
		$sq = mysqli_query($con,"INSErt INTO tbl_mobile_load(loadStatus, loadDate, loadEmp, loadAmnt, loadComments, pRate, sRate,purchaseType,User) values('$tempStatus','$dateNow', '$tempEmpName',$tmptxtAmntReceived,'$tmptxtNotes', $marginReceived,$marginSent,'Cash','$currentUser')")or die(mysqli_query());

		
		
		
		//$q1="INSErt INTO tbl_mobile_load($columnsToAdd) values($valuesToAdd)";
		
		//$qres=mysqli_query($con,$q1)or die(mysqli_query());
		$newID=mysqli_insert_id($con);
		//echo "<br/><br/><br/>".$newID;
		echo '<script type="text/javascript">alert("Load Successfully Entered");</script>';
		
		
		///////////    deduction from bank
		
		
		$tmptxtAmntPaid=$tmptxtAmntReceived-($tmptxtAmntReceived * $marginReceived);
		$for="Otar";
		$tempMode=$defaultBankName;
		$status="PaidTo";
		$user=$currentUser;

		$columnsToAdd="rpFor,rpDate, rpStatus, rpFromTo, rpAmnt, rpmode, rpUser, rpNotes,rpStatus2,linkedKey";
		$valuesToAdd= " '$for','$dateNow','$status', '$tempEmpName',$tmptxtAmntPaid,'$tempMode','$user','$tmptxtNotes','Cash',$newID";
		//echo "$columnsToAdd". "<br>"."$valuesToAdd";
		
		$sq = mysqli_query($con,"INSErt INTO receiptpayment($columnsToAdd) values($valuesToAdd)")or die(mysqli_query());
		
		
		
		$_POST = array();
	}
	}
	
	
	
	
if (isset($_POST['LoadFromMfs']))
	{
	$tempEmpName=$parentCompany;
	$dateNow=$_POST['txtDate'];
				if ($dateNow=="")
					$dateNow=date('Y-m-d');
	$tmptxtAmntReceived=$_POST['txtAmntReceived'];
	$tempStatus="Received";
	$tmptxtNotes=$_POST['txtNotes'];
		//if ($tmptxtNotes== "")
		//	{ $tmptxtNotes="Empty"; }

	// Check if all data fields have been filled or not
	
	if ($tmptxtAmntReceived== "")
			{ echo '<script type="text/javascript">alert("Please Enter any amount in \"Load Amount:\" box.");</script>'; }
	else
	{
		$columnsToAdd1="loadStatus, loadDate, loadEmp, loadAmnt, loadComments, pRate, sRate,purchaseType,User";
		$valuesToAdd1= " '$tempStatus','$dateNow', '$tempEmpName',$tmptxtAmntReceived,'$tmptxtNotes', $marginReceived,$marginSent,'Debit MFS','$currentUser'";
		//echo "$columnsToAdd". "<br>"."$valuesToAdd";
		
		mysqli_query($con,"INSErt INTO tbl_mobile_load($columnsToAdd1) values($valuesToAdd1)")or die(mysqli_query());
		$newID=mysqli_insert_id($con);
		//echo "<br/><br/><br/>".$newID;
		
		/// deduction from bank
		
		$tmptxtAmntPaid=$tmptxtAmntReceived-($tmptxtAmntReceived * $marginReceived);
		
		$columnsToAdd2="rpFor,rpDate, rpStatus, rpFromTo, rpAmnt, rpmode, rpUser, rpNotes,rpStatus2,linkedKey";
		$valuesToAdd2= " 'Otar','$dateNow','PaidTo', '$tempEmpName',$tmptxtAmntPaid,'$defaultBankName','$currentUser','Purchased From Financial Service','Cash',$newID";
		//echo "$columnsToAdd". "<br>"."$valuesToAdd";
		
		$sq = mysqli_query($con,"INSErt INTO receiptpayment($columnsToAdd2) values($valuesToAdd2)")or die(mysqli_query());
		
		
		
		///////////    adding in mfs
		
		
		$columnsToAdd3="mfsStatus, mfsDate, mfsEmp, mfsAmnt, mfsComments,purchaseType,User";
		$valuesToAdd3= " 'Sent','$dateNow', '$parentCompany',$tmptxtAmntPaid,'Load Purchased From Financial Service','Debit MFS for load','$currentUser' ";
			//echo "$columnsToAdd". "<br>"."$valuesToAdd";
		
		$sq = mysqli_query($con,"INSERT INTO tbl_financial_service($columnsToAdd3) values($valuesToAdd3)")or die(mysqli_query());
		
			$columnsToAdd4="rpFor,rpDate, rpStatus, rpFromTo, rpAmnt, rpmode, rpUser, rpNotes";
			$valuesToAdd4= " 'MFS','$dateNow','ReceivedFrom', '$tempEmpName',$tmptxtAmntPaid,'$defaultBankName','$currentUser','Debited MFS for Load' ";
			//echo "$columnsToAdd". "<br>"."$valuesToAdd";
			$sq = mysqli_query($con,"INSErt INTO receiptpayment($columnsToAdd4) values($valuesToAdd4)")or die(mysqli_query());
			
		
		
		
		
		echo '<script type="text/javascript">alert("Load Successfully Entered");</script>';

		
		$_POST = array();
	}
	}
	
if (isset($_POST['SaveliftingLoad']))
	{
		$tempEmpName=$parentCompany;
		$dateNow=$_POST['txtDate'];
				if ($dateNow=="")
					$dateNow=date('Y-m-d');
		$tmptxtAmntReceived=$_POST['txtAmntReceived'];
		$tempStatus="Received";
		$tmptxtNotes=$_POST['txtNotes'];
		//if ($tmptxtNotes== "")
		//	{ $tmptxtNotes="Empty"; }

		// Check if all data fields have been filled or not
	
		if ($tmptxtAmntReceived== "")
			{ echo '<script type="text/javascript">alert("Please Enter any amount in \"Load Amount:\" box.");</script>'; }
		else
		{
			$columnsToAdd="loadStatus, loadDate, loadEmp, loadAmnt, loadComments, pRate, sRate,purchaseType,User";
			$valuesToAdd= " '$tempStatus','$dateNow', '$tempEmpName',$tmptxtAmntReceived,'$tmptxtNotes',$marginReceived,$marginSent,'Credit','$currentUser' ";
			//echo "$columnsToAdd". "<br>"."$valuesToAdd";
		
			$sq = mysqli_query($con,"INSErt INTO tbl_mobile_load($columnsToAdd) values($valuesToAdd)")or die(mysqli_query());
			echo '<script type="text/javascript">alert("Load Successfully Entered");</script>';
			$_POST = array();
		}
	}
	

if(isset($_POST['SaveSendliftingmfs']))
	{
		$tempEmpName=$parentCompany;
		$dateNow=$_POST['txtDate'];
				if ($dateNow=="")
					$dateNow=date('Y-m-d');
		$tmptxtAmntReceived=$_POST['txtAmntReceived'];
		$tempStatus="Received";
		$tmptxtNotes=$_POST['txtNotes'];
			//if ($tmptxtNotes== "")
			//	{ $tmptxtNotes="Empty"; }

		// Check if all data fields have been filled or not
	
		if ($tmptxtAmntReceived== "")
			{ echo '<script type="text/javascript">alert("Please Enter any amount in \"mfs Amount:\" box.");</script>'; }
		else
		{
			$columnsToAdd="mfsStatus, mfsDate, mfsEmp, mfsAmnt, mfsComments,purchaseType,User";
			$valuesToAdd= " '$tempStatus','$dateNow', '$tempEmpName',$tmptxtAmntReceived,'$tmptxtNotes','Cash','$currentUser' ";
			//echo "$columnsToAdd". "<br>"."$valuesToAdd";
		
			mysqli_query($con,"INSERT INTO tbl_financial_service($columnsToAdd) values($valuesToAdd)")or die(mysqli_query());
			$newID=mysqli_insert_id($con);
			echo '<script type="text/javascript">alert("mfs Successfully Entered");</script>';
		
		
		///////////    deduction from bank
			$tmptxtAmntPaid=$tmptxtAmntReceived;
			$for="MFS";
			$tempMode=$defaultBankName;
			$status="PaidTo";
			$user=$currentUser;
			$columnsToAdd="rpFor,rpDate, rpStatus, rpFromTo, rpAmnt, rpmode, rpUser, rpNotes,rpStatus2,linkedKey";
			$valuesToAdd= " '$for','$dateNow','$status', '$tempEmpName',$tmptxtAmntPaid,'$tempMode','$user','$tmptxtNotes','Cash',$newID";
			//echo "$columnsToAdd". "<br>"."$valuesToAdd";
			$sq = mysqli_query($con,"INSErt INTO receiptpayment($columnsToAdd) values($valuesToAdd)")or die(mysqli_query());
			$_POST = array();
		}
	}
	
if(isset($_POST['Saveliftingmfs']))
	{
		$tempEmpName=$parentCompany;
		$dateNow=$_POST['txtDate'];
				if ($dateNow=="")
					$dateNow=date('Y-m-d');
		$tmptxtAmntReceived=$_POST['txtAmntReceived'];
		$tempStatus="Received";
		$tmptxtNotes=$_POST['txtNotes'];
			//if ($tmptxtNotes== "")
			//	{ $tmptxtNotes="Empty"; }

		// Check if all data fields have been filled or not
	
		if ($tmptxtAmntReceived== "")
			{ echo '<script type="text/javascript">alert("Please Enter any amount in \"mfs Amount:\" box.");</script>'; }
		else
		{
			$columnsToAdd="mfsStatus, mfsDate, mfsEmp, mfsAmnt, mfsComments,purchaseType,User";
			$valuesToAdd= " '$tempStatus','$dateNow', '$tempEmpName',$tmptxtAmntReceived,'$tmptxtNotes','Credit','$currentUser' ";
			//echo "$columnsToAdd". "<br>"."$valuesToAdd";
		
			$sq = mysqli_query($con,"INSERT INTO tbl_financial_service($columnsToAdd) values($valuesToAdd)")or die(mysqli_query());
			echo '<script type="text/javascript">alert("mfs Successfully Entered");</script>';
		}
	}
	
	////////////////// MFS DEBIT




if(isset($_POST['DebitMFS']))
	{
		$tempEmpName=$parentCompany;
		$dateNow=$_POST['txtDate'];
				if ($dateNow=="")
					$dateNow=date('Y-m-d');
		$tmptxtAmntReceived=$_POST['txtAmntReceived'];
		$tempStatus="Sent";
		$tmptxtNotes=$_POST['txtNotes'];
			//if ($tmptxtNotes== "")
			//	{ $tmptxtNotes="Empty"; }

		// Check if all data fields have been filled or not
	
		if ($tmptxtAmntReceived== "")
			{ echo '<script type="text/javascript">alert("Please Enter any amount in \"MFS Amount:\" box.");</script>'; }
		else
		{
			$columnsToAdd="mfsStatus, mfsDate, mfsEmp, mfsAmnt, mfsComments,purchaseType,User";
			$valuesToAdd= " '$tempStatus','$dateNow', '$tempEmpName',$tmptxtAmntReceived,'$tmptxtNotes','Debit MFS','$currentUser' ";
			//echo "$columnsToAdd". "<br>"."$valuesToAdd";
		
			$sq = mysqli_query($con,"INSERT INTO tbl_financial_service($columnsToAdd) values($valuesToAdd)")or die(mysqli_query());
			echo '<script type="text/javascript">alert("mfs Successfully Entered");</script>';
		
		
		///////////    Adding to bank
			
			$for="MFS";
			$tempMode=$defaultBankName;
			$status="ReceivedFrom";
			$user=$currentUser;
			$columnsToAdd="rpFor,rpDate, rpStatus, rpFromTo, rpAmnt, rpmode, rpUser, rpNotes";
			$valuesToAdd= " '$for','$dateNow','$status', '$tempEmpName',$tmptxtAmntReceived,'$tempMode','$user','$tmptxtNotes' ";
			//echo "$columnsToAdd". "<br>"."$valuesToAdd";
			$sq = mysqli_query($con,"INSErt INTO receiptpayment($columnsToAdd) values($valuesToAdd)")or die(mysqli_query());
			$_POST = array();
		}
	}	
	
	
	
	
	
	
	
	
	
	
	
if (isset($_POST['SaveSendliftingCard']))
	{
		$tempEmpName=$parentCompany;
		$dateNow=$_POST['txtDate'];
					if ($dateNow=="")
						$dateNow=date('Y-m-d');
		$tmptxtAmntReceived=$_POST['txtAmntReceived'];
		$tempStatus="Received";
		$cType=$_POST['SubPselect'];
		$tmptxtNotes=$_POST['txtNotes'];
			//if ($tmptxtNotes== "")
			//	{ $tmptxtNotes="Empty"; }
		$qry0 = mysqli_query($con,"SELECT * FROM rates WHERE pName='Card' AND spName='$cType' ORDER BY rtID DESC LIMIT 1")or die(mysqli_query());
		$Data0=mysqli_fetch_array($qry0);
		$PurchaseRate= $Data0['purchasePrice'];
		// Check if all data fields have been filled or not
		
	if ($cType== "---")
			{ echo '<script type="text/javascript">alert("Please Select Card Type from \"Card Type:\" box.");</script>'; }
	
	else if ($tmptxtAmntReceived== "")
			{ echo '<script type="text/javascript">alert("Please Enter any Quantity in \"Card Quantity:\" box.");</script>'; }
	else if ($PurchaseRate="")
			{ echo '<script type="text/javascript">alert("Purshase rate not set. Please first set rate.");</script>'; }
	else
		{
			$PurchaseRate= $Data0['purchasePrice'];
			$orgAmnt=$tmptxtAmntReceived * $PurchaseRate;
			$columnsToAdd="   csStatus,    csDate,     csEmp,    csType,     csQty,             csOrgAmnt, csRate, csComments,User,purchaseType";
			$valuesToAdd= " '$tempStatus','$dateNow', '$tempEmpName', '$cType'       ,$tmptxtAmntReceived,$orgAmnt,$PurchaseRate,    '$tmptxtNotes' ,'$currentUser','Cash'";
			//echo "$columnsToAdd". "<br>"."$valuesToAdd";
			
			mysqli_query($con,"INSErt INTO tbl_cards($columnsToAdd) values($valuesToAdd)")or die(mysqli_query());
			$newID=mysqli_insert_id($con);
			echo '<script type="text/javascript">alert("Cards Successfully Entered");</script>';
		
		///////////    deduction from bank
			$tmptxtAmntPaid=$tmptxtAmntReceived * $PurchaseRate;
			$for="Card";
			$tempMode=$defaultBankName;
			$status="PaidTo";
			$user=$currentUser;
			$columnsToAdd="rpFor,rpDate, rpStatus, rpFromTo, rpAmnt, rpmode, rpUser, rpNotes,rpStatus2,linkedKey";
			$valuesToAdd= " '$for','$dateNow','$status', '$tempEmpName',$tmptxtAmntPaid,'$tempMode','$user','$tmptxtNotes','Cash',$newID ";
			//echo "$columnsToAdd". "<br>"."$valuesToAdd";
			$sq = mysqli_query($con,"INSErt INTO receiptpayment($columnsToAdd) values($valuesToAdd)")or die(mysqli_query());
			$_POST = array();
		}
	}
	
	
if (isset($_POST['SaveliftingCard']))
	{
		$tempEmpName=$parentCompany;
		$dateNow=$_POST['txtDate'];
					if ($dateNow=="")
						$dateNow=date('Y-m-d');
		$tmptxtAmntReceived=$_POST['txtAmntReceived'];
		$tempStatus="Received";
		$cType=$_POST['SubPselect'];
		$tmptxtNotes=$_POST['txtNotes'];
			//if ($tmptxtNotes== "")
			//	{ $tmptxtNotes="Empty"; }
		$qry0 = mysqli_query($con,"SELECT * FROM rates WHERE pName='Card' AND spName='$cType' ORDER BY rtID DESC LIMIT 1")or die(mysqli_query());
		$Data0=mysqli_fetch_array($qry0);
		$PurchaseRate= $Data0['purchasePrice'];
		// Check if all data fields have been filled or not
		
	if ($cType== "---")
			{ echo '<script type="text/javascript">alert("Please Select Card Type from \"Card Type:\" box.");</script>'; }
	
	else if ($tmptxtAmntReceived== "")
			{ echo '<script type="text/javascript">alert("Please Enter any Quantity in \"Card Quantity:\" box.");</script>'; }
	else if ($PurchaseRate="")
			{ echo '<script type="text/javascript">alert("Purshase rate not set. Please first set rate.");</script>'; }
	else
		{
			$PurchaseRate= $Data0['purchasePrice'];
			$orgAmnt=$tmptxtAmntReceived * $PurchaseRate;
			$columnsToAdd="   csStatus,    csDate,     csEmp,    csType,     csQty,             csOrgAmnt, csRate, csComments,User,purchaseType";
			$valuesToAdd= " '$tempStatus','$dateNow', '$tempEmpName', '$cType'       ,$tmptxtAmntReceived,$orgAmnt,$PurchaseRate,    '$tmptxtNotes','$currentUser','Credit' ";
			//echo "$columnsToAdd". "<br>"."$valuesToAdd";
			
			$sq = mysqli_query($con,"INSErt INTO tbl_cards($columnsToAdd) values($valuesToAdd)")or die(mysqli_query());
			echo '<script type="text/javascript">alert("Cards Successfully Entered");</script>';
		}
	}


	
if (isset($_POST['SaveSendliftingPhone']))
	{
	$tempEmpName=$parentCompany;
	$dateNow=$_POST['txtDate'];
				if ($dateNow=="")
					$dateNow=date('Y-m-d');
	$tmptxtAmntReceived=$_POST['txtAmntReceived'];
	$tempStatus="Received";
	$cType=$_POST['SubPselect'];
	$pName="Mobile";
	$tmptxtNotes=$_POST['txtNotes'];
		//if ($tmptxtNotes== "")
			//{ $tmptxtNotes="Empty"; }

	// Check if all data fields have been filled or not
		$qry0 = mysqli_query($con,"SELECT * FROM rates WHERE pName='Mobile' AND spName='$cType' ORDER BY rtID DESC LIMIT 1")or die(mysqli_query());
		$Data0=mysqli_fetch_array($qry0);
		$PurchaseRate= $Data0['purchasePrice'];
	
	
	
	if ($cType== "---")
			{ echo '<script type="text/javascript">alert("Please Select Phone Type from \"Phone Type:\" box.");</script>'; }
	else if ($tmptxtAmntReceived=="")
			{ echo '<script type="text/javascript">alert("Please Enter any Quantity in \"Phone Quantity:\" box.");</script>'; }
	else if ($PurchaseRate="")
			{ echo '<script type="text/javascript">alert("Purshase rate not set. Please first set rate.");</script>'; }
	else
	{
		$PurchaseRate= $Data0['purchasePrice'];
		$orgAmnt=$tmptxtAmntReceived * $PurchaseRate;
		//echo "<br><br><br>".$PurchaseRate."<br>OK";
		$columnsToAdd="sDate,pName,pSubType,trtype,customer,qty,rate,sComments,User,purchaseType";
		$valuesToAdd= "'$dateNow', '$pName', '$cType', '$tempStatus' ,  '$tempEmpName'  ,$tmptxtAmntReceived, $PurchaseRate,    '$tmptxtNotes','$currentUser','Cash' ";
		//echo "$columnsToAdd". "<br>"."$valuesToAdd";
		mysqli_query($con,"INSErt INTO tbl_product_stock($columnsToAdd) values($valuesToAdd)")or die(mysqli_query());
		$newID=mysqli_insert_id($con);
		echo '<script type="text/javascript">alert("Phones Successfully Entered");</script>';
	
	
	///////////    deduction from bank
			$tmptxtAmntPaid=$tmptxtAmntReceived * $PurchaseRate;
			$for="Mobile";
			$tempMode=$defaultBankName;
			$status="PaidTo";
			$user=$currentUser;
			$columnsToAdd="rpFor,rpDate, rpStatus, rpFromTo, rpAmnt, rpmode, rpUser, rpNotes,rpStatus2,linkedKey";
			$valuesToAdd= " '$for','$dateNow','$status', '$tempEmpName',$tmptxtAmntPaid,'$tempMode','$user','$tmptxtNotes','Cash',$newID ";
			//echo "$columnsToAdd". "<br>"."$valuesToAdd";
			$sq = mysqli_query($con,"INSErt INTO receiptpayment($columnsToAdd) values($valuesToAdd)")or die(mysqli_query());
			$_POST = array();
	}
	}
	
	
if (isset($_POST['SaveliftingPhone']))
	{
	$tempEmpName=$parentCompany;
	$dateNow=$_POST['txtDate'];
				if ($dateNow=="")
					$dateNow=date('Y-m-d');
	$tmptxtAmntReceived=$_POST['txtAmntReceived'];
	$tempStatus="Received";
	$cType=$_POST['SubPselect'];
	$pName="Mobile";
	$tmptxtNotes=$_POST['txtNotes'];
		//if ($tmptxtNotes== "")
			//{ $tmptxtNotes="Empty"; }

	// Check if all data fields have been filled or not
	$qry110 = mysqli_query($con,"SELECT * FROM rates WHERE pName='Mobile' AND spName='$cType' ORDER BY rtID DESC LIMIT 1")or die(mysqli_query());
		$Data110=mysqli_fetch_array($qry110);
		$PurchaseRate= $Data110['purchasePrice'];
	
	
	if ($cType== "---")
			{ echo '<script type="text/javascript">alert("Please Select Phone Type from \"Phone Type:\" box.");</script>'; }
	
	else if ($tmptxtAmntReceived== "")
			{ echo '<script type="text/javascript">alert("Please Enter any Quantity in \"Phone Quantity:\" box.");</script>'; }
	else if ($PurchaseRate="")
			{ echo '<script type="text/javascript">alert("Purshase rate not set. Please first set rate.");</script>'; }
	else
	{
		$PurchaseRate= $Data110['purchasePrice'];
		$orgAmnt=$tmptxtAmntReceived * $cardPurchaseRate;
		$columnsToAdd="sDate,pName,pSubType,trtype,customer,qty,rate,sComments,User,purchaseType";
		$valuesToAdd= "'$dateNow', '$pName', '$cType', '$tempStatus' ,  '$tempEmpName'  ,$tmptxtAmntReceived, $PurchaseRate ,    '$tmptxtNotes','$currentUser','Credit' ";
		//echo "$columnsToAdd". "<br>"."$valuesToAdd";
		
		$sq = mysqli_query($con,"INSErt INTO tbl_product_stock($columnsToAdd) values($valuesToAdd)")or die(mysqli_query());
		echo '<script type="text/javascript">alert("Phones Successfully Entered");</script>';
	}
	}

if (isset($_POST['SaveSendliftingSIM']))
	{
	$tempEmpName=$parentCompany;
	$dateNow=$_POST['txtDate'];
				if ($dateNow=="")
					$dateNow=date('Y-m-d');
	$tmptxtAmntReceived=$_POST['txtAmntReceived'];
	
	$tempStatus="Received";
	$cType=$_POST['SubPselect'];
	$pName="SIM";
	$tmptxtNotes=$_POST['txtNotes'];
		//if ($tmptxtNotes== "")
			//{ $tmptxtNotes="Empty"; }
		$qry0 = mysqli_query($con,"SELECT * FROM rates WHERE pName='SIM' AND spName='$cType' ORDER BY rtID DESC LIMIT 1")or die(mysqli_query());
		$Data0=mysqli_fetch_array($qry0);
		$PurchaseRate= $Data0['purchasePrice'];
	
	// Check if all data fields have been filled or not
	
	if ($cType== "---")
			{ echo '<script type="text/javascript">alert("Please Select SIM Type from \"SIM Type:\" box.");</script>'; }
	
	else if ($tmptxtAmntReceived== "")
			{ echo '<script type="text/javascript">alert("Please Enter any Quantity in \"SIM Quantity:\" box.");</script>'; }
	else if ($PurchaseRate="")
			{ echo '<script type="text/javascript">alert("Purshase rate not set. Please first set rate.");</script>'; }
	else
	{
		$PurchaseRate= $Data0['purchasePrice'];
		$orgAmnt=$tmptxtAmntReceived * $PurchaseRate;
		$columnsToAdd="sDate,pName,pSubType,trtype,customer,qty,rate,sComments,User,purchaseType";
		$valuesToAdd= "'$dateNow', '$pName', '$cType', '$tempStatus' ,  '$tempEmpName'  ,$tmptxtAmntReceived, $PurchaseRate,    '$tmptxtNotes' ,'$currentUser','Cash'";
		//echo "$columnsToAdd". "<br>"."$valuesToAdd";
		
		mysqli_query($con,"INSErt INTO tbl_product_stock($columnsToAdd) values($valuesToAdd)")or die(mysqli_query());
		$newID=mysqli_insert_id($con);
		echo '<script type="text/javascript">alert("SIM Successfully Entered");</script>';
	
	
	///////////    deduction from bank
			$tmptxtAmntPaid=$tmptxtAmntReceived * $PurchaseRate;
			$for="SIM";
			$tempMode=$defaultBankName;
			$status="PaidTo";
			$user=$currentUser;
			$columnsToAdd="rpFor,rpDate, rpStatus, rpFromTo, rpAmnt, rpmode, rpUser, rpNotes,rpStatus2,linkedKey";
			$valuesToAdd= " '$for','$dateNow','$status', '$tempEmpName',$tmptxtAmntPaid,'$tempMode','$user','$tmptxtNotes','Cash',$newID";
			//echo "$columnsToAdd". "<br>"."$valuesToAdd";
			$sq = mysqli_query($con,"INSErt INTO receiptpayment($columnsToAdd) values($valuesToAdd)")or die(mysqli_query());
			$_POST = array();
	}
	}
	
	
	
if (isset($_POST['SaveliftingSIM']))
	{
	$tempEmpName=$parentCompany;
	$dateNow=$_POST['txtDate'];
				if ($dateNow=="")
					$dateNow=date('Y-m-d');
	$tmptxtAmntReceived=$_POST['txtAmntReceived'];
	
	$tempStatus="Received";
	$cType=$_POST['SubPselect'];
	$pName="SIM";
	$tmptxtNotes=$_POST['txtNotes'];
		//if ($tmptxtNotes== "")
			//{ $tmptxtNotes="Empty"; }
		$qry0 = mysqli_query($con,"SELECT * FROM rates WHERE pName='SIM' AND spName='$cType' ORDER BY rtID DESC LIMIT 1")or die(mysqli_query());
		$Data0=mysqli_fetch_array($qry0);
		$PurchaseRate= $Data0['purchasePrice'];
	
	// Check if all data fields have been filled or not
	
	if ($cType== "---")
			{ echo '<script type="text/javascript">alert("Please Select SIM Type from \"SIM Type:\" box.");</script>'; }
	
	else if ($tmptxtAmntReceived== "")
			{ echo '<script type="text/javascript">alert("Please Enter any Quantity in \"SIM Quantity:\" box.");</script>'; }
	else if ($PurchaseRate="")
			{ echo '<script type="text/javascript">alert("Purshase rate not set. Please first set rate.");</script>'; }
	else
	{
		$PurchaseRate= $Data0['purchasePrice'];
		$orgAmnt=$tmptxtAmntReceived * $PurchaseRate;
		$columnsToAdd="sDate,pName,pSubType,trtype,customer,qty,rate,sComments,User,purchaseType";
		$valuesToAdd= "'$dateNow', '$pName', '$cType', '$tempStatus' ,  '$tempEmpName'  ,$tmptxtAmntReceived, $PurchaseRate,    '$tmptxtNotes','$currentUser','Credit' ";
		//echo "$columnsToAdd". "<br>"."$valuesToAdd";
		
		$sq = mysqli_query($con,"INSErt INTO tbl_product_stock($columnsToAdd) values($valuesToAdd)")or die(mysqli_query());
		echo '<script type="text/javascript">alert("SIM Successfully Entered");</script>';
	}
	}
	
	
	

/*         <<<<<<<<<<<<  THIS IS SENDING MODULE   >>>>>>>>>>>>>>>      */


if (isset($_POST['SaveSendingLoad']))
	{
	$tmpEmpName=$_POST['SentTo'];
	$dateNow=$_POST['txtDate'];
				if ($dateNow=="")
					$dateNow=date('Y-m-d');
				$amntToSend=$_POST['txtAmntSent'];
	//$tmptxtAmntSent=$_POST['txtAmntSent'];
	$tempStatus="Sent";
	$tmptxtNotes=$_POST['txtNotes'];
		//if ($tmptxtNotes== "")
			//{ $tmptxtNotes="Empty"; }
		
			$loadTransfer= $amntToSend + ( $amntToSend * $marginSent);
			$franchiseProfitAmnt= $amntToSend * $franchiseProfitRate;
			$excessProfitAmnt= ($loadTransfer - $amntToSend) * $marginReceived;

	// Check if all data fields have been filled or not
	if ($tmpEmpName== "---")
			{ echo '<script type="text/javascript">alert("Please Select Employee Name from \"Sent To:\" box.");</script>'; }
	
	else if ($tmptxtAmntSent= "")
			{ echo '<script type="text/javascript">alert("Please Enter Amount in \"Sending Amount:\" box.");</script>'; }
	else
	{
		
		$columnsToAdd="loadStatus, loadDate, loadEmp, loadAmnt, loadTransfer, loadProfit, loadExcessProfit,loadComments ,User";
		$valuesToAdd= " '$tempStatus','$dateNow','$tmpEmpName',$amntToSend,$loadTransfer,$franchiseProfitAmnt,$excessProfitAmnt, '$tmptxtNotes' ,'$currentUser'";
		
		//echo "$columnsToAdd". "<br>"."$valuesToAdd";
	
		$sq = mysqli_query($con,"INSErt INTO tbl_mobile_load($columnsToAdd) values($valuesToAdd)")or die(mysqli_query());
		
		echo '<script type="text/javascript">alert("Load Amounting Rs.' . $loadTransfer .   ' Successfully Transferred to: '.$tmpEmpName .'.");</script>';
	}
	}

if (isset($_POST['SaveSendingmfs']))
	{
	$tmpEmpName=$_POST['SentTo'];
	$dateNow=$_POST['txtDate'];
				if ($dateNow=="")
					$dateNow=date('Y-m-d');
	$amntToSend=$_POST['txtAmntSent'];
	//$tmptxtAmntSent=$_POST['txtAmntSent'];
	$tempStatus="Sent";
	$tmptxtNotes=$_POST['txtNotes'];
		/*if ($tmptxtNotes== "")
		{ $tmptxtNotes="Empty"; }
		
			$loadTransfer= $amntToSend + ( $amntToSend * $marginSent);
			$franchiseProfitAmnt= $amntToSend * $franchiseProfitRate;
			$excessProfitAmnt= ($loadTransfer - $amntToSend) * $marginReceived;

	 Check if all data fields have been filled or not*/
	if ($tmpEmpName== "---")
			{ echo '<script type="text/javascript">alert("Please Select Employee Name from \"Sent To:\" box.");</script>'; }
	
	else if ($tmptxtAmntSent= "")
			{ echo '<script type="text/javascript">alert("Please Enter Amount in \"Sending Amount:\" box.");</script>'; }
	else
	{
		
		$columnsToAdd="mfsStatus, mfsDate, mfsEmp, mfsSend, mfsComments ";
		$valuesToAdd= " '$tempStatus','$dateNow','$tmpEmpName',$amntToSend,'$tmptxtNotes' ";
		
		//echo "$columnsToAdd". "<br>"."$valuesToAdd";
	
		$sq = mysqli_query($con,"INSERT INTO tbl_financial_service($columnsToAdd) values($valuesToAdd)")or die(mysqli_query());
		
		echo '<script type="text/javascript">alert("mfs Amounting Rs.' . $amntToSend .   ' Successfully Transferred to: '.$tmpEmpName .'.");</script>';
	}
	}


if (isset($_POST['SaveSendingCard']))
	{
	$tmpEmpName=$_POST['SentTo'];
	$type=$_POST['SubPselect'];
	$dateNow=$_POST['txtDate'];
				if ($dateNow=="")
					$dateNow=date('Y-m-d');
	$amntToSend=$_POST['txtAmntSent'];
	$tempStatus="Sent";
	$tmptxtNotes=$_POST['txtNotes'];
		

	 //Check if all data fields have been filled or not*/
	
	if ($type== "---")
			{ echo '<script type="text/javascript">alert("Please Select Card Type from \"Card Type:\" box.");</script>'; }
	else if ($tmpEmpName== "---")
			{ echo '<script type="text/javascript">alert("Please Select Employee Name from \"Sent To:\" box.");</script>'; }
	else if ($tmptxtAmntSent= "")
			{ echo '<script type="text/javascript">alert("Please Enter Amount in \"Sending Amount:\" box.");</script>'; }
	else
	{
		
		$columnsToAdd="csStatus, csDate, csEmp, csType, csQty, csComments ,User";
		$valuesToAdd= " '$tempStatus','$dateNow','$tmpEmpName', '$type', $amntToSend,'$tmptxtNotes','$currentUser' ";
		
		//echo "$columnsToAdd". "<br>"."$valuesToAdd";
	
		$sq = mysqli_query($con,"INSErt INTO tbl_cards($columnsToAdd) values($valuesToAdd)")or die(mysqli_query());
		
		echo '<script type="text/javascript">alert("' . $amntToSend . 'Cards of ' . $type .   ' Successfully Transferred to: '.$tmpEmpName .'.");</script>';
	}
	}

	
	
	
if (isset($_POST['SaveSendingSIM']))
	{
	$tmpEmpName=$_POST['SentTo'];
	$type=$_POST['SubPselect'];
	$dateNow=$_POST['txtDate'];
				if ($dateNow=="")
					$dateNow=date('Y-m-d');
	$amntToSend=$_POST['txtAmntSent'];
	$tempStatus="Sent";
	$tmptxtNotes=$_POST['txtNotes'];
		

	 //Check if all data fields have been filled or not*/
	
	if ($type== "---")
			{ echo '<script type="text/javascript">alert("Please Select Card Type from \"Card Type:\" box.");</script>'; }
	else if ($tmpEmpName== "---")
			{ echo '<script type="text/javascript">alert("Please Select Employee Name from \"Sent To:\" box.");</script>'; }
	else if ($tmptxtAmntSent= "")
			{ echo '<script type="text/javascript">alert("Please Enter Amount in \"Sending Amount:\" box.");</script>'; }
	else
	{
		
		$columnsToAdd=" trtype, sDate, customer, pSubType, qty, sComments,User ";
		$valuesToAdd= " '$tempStatus','$dateNow','$tmpEmpName', '$type', $amntToSend,'$tmptxtNotes','$currentUser' ";
		
		//echo "$columnsToAdd". "<br>"."$valuesToAdd";
	
		$sq = mysqli_query($con,"INSErt INTO tbl_product_stock($columnsToAdd) values($valuesToAdd)")or die(mysqli_query());
		
		echo '<script type="text/javascript">alert("' . $amntToSend . ' SIM\'s of  Type ' . $type .   ' Successfully Transferred to: '.$tmpEmpName .'.");</script>';
	}
	}


	
	
	
	





	
	
	
/*         <<<<<<<<<<<<  THIS IS products/SUB_products MODULE   >>>>>>>>>>>>>>>      */
	
if (isset($_POST['SaveSubType']))
	{
	$pName=$_POST['pSelect'];
	$subType=$_POST['txtSubType'];
	$cmnts=$_POST['txtComments'];
	if ($pName== "---")
			{ echo '<script type="text/javascript">alert("Please Select a Product from \"Product List\".");</script>'; }
	else if ($subType== "")
			{ echo '<script type="text/javascript">alert("Please Enter Sub-Type i.e. \"Card Rs. 100\"   or  \"xCite J-100\".");</script>'; }
	else
	{
		$columnsToAdd="productName,typeName,typeComments";
		$valuesToAdd= " '$pName','$subType','$cmnts' ";
		//echo "$columnsToAdd". "<br>"."$valuesToAdd";
		
		$sq = mysqli_query($con,"INSErt INTO types($columnsToAdd) values($valuesToAdd)")or die(mysqli_query());
		echo '<script type="text/javascript">alert("Sub-Type Successfully Entered");</script>';
	}
	}
	

	
	
	/*         <<<<<<<<<<<<  THIS IS RECEIVE BACK mfs MODULE   >>>>>>>>>>>>>>>      */
	
	
	if (isset($_POST['SaveReceivemfs']))
	{
	$tempEmpName=$_POST['empSelect'];
	$dateNow=$_POST['txtDate'];
				if ($dateNow=="")
					$dateNow=date('Y-m-d');
	$tmptxtAmntReceived=$_POST['txtAmntReceived'];
	$tempStatus="Received";
	$tmptxtNotes=$_POST['txtNotes'];
		//if ($tmptxtNotes== "")
		//	{ $tmptxtNotes="Empty"; }

	// Check if all data fields have been filled or not
	
	if ($tempEmpName== "---")
			{ echo '<script type="text/javascript">alert("Please Select Employee From \"Receiving From:\" box.");</script>'; }
	
	else if ($tmptxtAmntReceived== "")
			{ echo '<script type="text/javascript">alert("Please Enter any amount in \"mfs Amount:\" box.");</script>'; }
	else
	{
		$columnsToAdd="mfsStatus, mfsDate, mfsEmp, mfsReceive, mfsComments,User";
		$valuesToAdd= " '$tempStatus','$dateNow', '$tempEmpName',$tmptxtAmntReceived,'$tmptxtNotes','$currentUser' ";
		//echo "$columnsToAdd". "<br>"."$valuesToAdd";
		
		$sq = mysqli_query($con,"INSERT INTO tbl_financial_service($columnsToAdd) values($valuesToAdd)")or die(mysqli_query());
		echo '<script type="text/javascript">alert("mfs Successfully Entered");</script>';
	}
	}
	
	
	
	
	
	
	
	
	//////////////////* PAYMENT TO COMPANY *//////////////////////
	
	
	
	
	
if(isset($_POST['Reset']))
	{
		$_POST = array();
	}
	

	if (isset($_POST['SaveCompanyPayment']))
{
	$tempEmpName=$Employee;
	$dateNow=$_POST['txtDate'];
				if ($dateNow=="")
					$dateNow=date('Y-m-d');
	$tmptxtAmntPaid=$_POST['txtAmntPaid'];
	$for=$_POST['pfSelect'];
	$tempMode=$_POST['modeSelect'];
	$tmptxtNotes=$_POST['txtNotes'];
		if ($tmptxtNotes== "")
			{ $tmptxtNotes="Empty"; }
	$status="PaidTo";
	$user=$currentUser;
	
	// Check if all data fields have been filled or not
	
	if ($tempEmpName== "---")
			{ echo '<script type="text/javascript">alert("Please Select an option from \"Paid To\" drop down.");</script>'; }
	else if ($tempMode== "---")
			{ echo '<script type="text/javascript">alert("Please Select an option from \"Payment Mode\" box.");</script>'; }
	else if ($tmptxtAmntPaid== "")
			{ echo '<script type="text/javascript">alert("Please Enter any amount in \"Amount Paid\" box.");</script>'; }
	else
	{
		$columnsToAdd="rpFor,rpDate, rpStatus, rpFromTo, rpAmnt, rpmode, rpUser, rpNotes";
		$valuesToAdd= " '$for','$dateNow','$status', '$tempEmpName',$tmptxtAmntPaid,'$tempMode','$user','$tmptxtNotes' ";
		//echo "$columnsToAdd". "<br>"."$valuesToAdd";
		
		$sq = mysqli_query($con,"INSErt INTO receiptpayment($columnsToAdd) values($valuesToAdd)")or die(mysqli_query());
		echo '<script type="text/javascript">alert("Successfully Entered");</script>';
	}
}
	
	
	
	
	
	
	
	
?>