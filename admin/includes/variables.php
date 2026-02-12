<?php
//include_once('../../session.php');
session_start();

ini_set('max_execution_time', '300');
ini_set('error_reporting', '0');

include_once('dbcon.php');
include_once('globalvar.php');
		$dateNow=date('Y-m-d');
		$currentActiveUser=$_SESSION['login_user'];	
		$currentUser=$currentActiveUser;
		$currentUserType=$_SESSION['login_type'];
		$summaryFlag=2;
		
		$otarComissionEmp=0.001;
		//$tmptxttbl_cardsRate=97;
		//$tempsalary=316048;
		//$tempdodues=668068;
		//$receiptsummaryflag=0;
		//$paidsummaryFlag=0;
		//$SIMrate="32"
		//$tempDoDuesAdjustment=106390;

		
		
		/* <<<<<<<<<<<<<          GETTING DATE AND MONTH            >>>>>>>>>>>>>>*/
		$year  = date('Y');
		$month = date('m');
		$date = mktime( 0, 0, 0, $month, 1, $year );
		$PreviousMonth=strftime('%b-%Y',strtotime('-1 month',$date ));
		$NextMonth=strftime('%b-%Y',strtotime('+1 month',$date ));
		
		$query_date = date('d-m-Y');
		$FirstDay= date('01', strtotime($query_date));
		$FirstDate= date('01-m-Y', strtotime($query_date));
		$LastDay= date('t', strtotime($query_date));
		$CurrentDay=date('d');
		$CurrentDate=date('Y-m-d');
		$LastDate=date('t-m-Y', strtotime($query_date));
		$CurrentMonth=date('M-Y', strtotime($query_date));
		$RemainingDays=($LastDay - $CurrentDay);
		$ThisDay=$RemainingDays+1;
		
		$QueryFD= date('Y-m-01', strtotime($query_date));
		$QueryLD=date('Y-m-t', strtotime($query_date));
		
		$date_from = $FirstDate;
		$date_from = strtotime($date_from);
		$date_to = $CurrentDate;
		$date_to = strtotime($date_to);
		
		
		
		
		//$QueryFD='2017-05-01';
		//$QueryLD='2017-05-31';		
		
		
		
		/*
			echo "First day of Month is " . $FirstDay;
			echo "<br>";
			echo "First date of Month is " . $FirstDate;
			echo "<br>";
			echo "Current day of Month is " . $CurrentDay;
			echo "<br>";
			echo "Current date of Month is " . $CurrentDate;
			echo "<br>";
			echo "Last Day of month is " .$LastDay;
			echo "<br>";
			echo "Last date of Month is " . $LastDate;
			echo "<br>";
			echo "Current Month is ".$CurrentMonth;
			echo "<br>";
			echo "Remaining Days are ".$RemainingDays;
			echo "<br>";
		*/





		$qry1 = mysqli_query($con,"SELECT * FROM rates WHERE pName='Card' AND spName='Rs.100' ORDER BY rtID DESC LIMIT 1")or die(mysqli_query());
		$Data1=mysqli_fetch_array($qry1);
		$cardPurchaseRate= $Data1['purchasePrice'];
		
		$qry2 = mysqli_query($con,"SELECT * FROM rates WHERE pName='Otar' ORDER BY rtID DESC LIMIT 1")or die(mysqli_query());
		$Data2=mysqli_fetch_array($qry2);
		$marginReceived=$Data2['purchasePrice'];
		$marginSent=$Data2['salePrice'];
		$franchiseProfitRate= $marginReceived - $marginSent;
		

		//$qry3 = mysqli_query($con,"SELECT sum(amnt) FROM incomeexp WHERE type='profit' AND expDate BETWEEN '$QueryFD' AND '$QueryLD'")or die(mysqli_query());
		//$Data3=mysqli_fetch_array($qry3);
		//$profitSet= $Data3['sum(amnt)'];
		
		///$tempDoDuesAdjustment=$profitSet;
		
		
?>