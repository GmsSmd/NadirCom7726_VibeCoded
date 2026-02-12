<?php

include_once('includes/dbcon.php');
include_once('globalvar.php');
$doName="";
if (isset($_POST['getdo']))
	{
		$rtnumber=$_POST['txtrtnumber'];
		if($rtnumber=='')
			echo '<script type="text/javascript">alert("Please Enter retailer number.");</script>';
		else
			{
		$sq = mysqli_query($con,"SELECT do from retailers WHERE number='$rtnumber' ")or die(mysqli_query());
		$Data=mysqli_fetch_array($sq);
		$doName=$Data['do'];
			//echo '<script type="text/javascript">alert("do name is '.$doName.'.");</script>';
		}
	}

if (isset($_POST['SavertmfsSent']))
	{
		$dateNow=$_POST['txtDate'];
					if ($dateNow=="")
						$dateNow=date('Y-m-d');
		$rtnumber=$_POST['txtrtnumber'];
		$mfsEmp=$_POST['emp'];
		$mfsAmnt=$_POST['txtAmntSend'];
		$cmnts=$_POST['txtComments1'];
		$addCmnt=" (sent to ".$rtnumber.")";
		$cmnts=$cmnts.$addCmnt;
		if($rtnumber=='')
			echo '<script type="text/javascript">alert("Please enter retailer number.");</script>';
		else if($mfsEmp=='---')
			echo '<script type="text/javascript">alert("Please get do Name.");</script>';
		else if($mfsAmnt=='')
			echo '<script type="text/javascript">alert("Please Enter mfs Amount.");</script>';
		else
			{	
					
					$mfsStatus="Sent";
					$sq = mysqli_query($con,"INSERT INTO tbl_financial_service(mfsStatus, mfsDate, mfsEmp, mfsAmnt,mfsComments) values('$mfsStatus','$dateNow','$mfsEmp', $mfsAmnt,'$cmnts')")or die(mysqli_query());
					echo '<script type="text/javascript">alert("mfs Amounting Rs. '.$mfsAmnt.' Successfully Transferred to retailer '.$rtnumber.' on behalf of '. $mfsEmp.'. ");</script>';
					
					/*$brk="<br>";
					$datam=$dateNow.$brk.$rtnumber.$brk.$mfsEmp.$brk.$mfsAmnt.$brk.$cmnts;
					
					echo $datam;*/
			}
	}
	
	
if (isset($_POST['SavertmfsReceive']))
	{
		$dateNow=$_POST['txtDate'];
					if ($dateNow=="")
						$dateNow=date('Y-m-d');
		$rtnumber=$_POST['txtrtnumber'];
		$mfsEmp=$_POST['emp'];
		$mfsAmnt=$_POST['txtAmntReceived'];
		$cmnts=$_POST['txtComments2'];
		$addCmnt=" (Received From ".$rtnumber.")";
		$cmnts=$cmnts.$addCmnt;
		if($rtnumber=='')
			echo '<script type="text/javascript">alert("Please enter retailer number.");</script>';
		else if($mfsEmp=='---')
			echo '<script type="text/javascript">alert("Please get do Name.");</script>';
		else if($mfsAmnt=='')
			echo '<script type="text/javascript">alert("Please Enter mfs Amount.");</script>';
		else
			{	
					
					$mfsStatus="Received";
					$sq = mysqli_query($con,"INSERT INTO tbl_financial_service(mfsStatus, mfsDate, mfsEmp, mfsAmnt,mfsComments) values('$mfsStatus','$dateNow','$mfsEmp', $mfsAmnt,'$cmnts')")or die(mysqli_query());
					echo '<script type="text/javascript">alert("mfs Amounting Rs. '.$mfsAmnt.' Successfully Received from retailer '.$rtnumber.' on behalf of '. $mfsEmp.'. ");</script>';
					
					/*$brk="<br>";
					$datam=$dateNow.$brk.$rtnumber.$brk.$mfsEmp.$brk.$mfsAmnt.$brk.$cmnts;
					
					echo $datam;*/
			}
	}
?>