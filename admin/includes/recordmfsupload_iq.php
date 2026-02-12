<?php
include_once('../../session.php');
include_once('globalvar.php');
$currentUser=$_SESSION['login_user'];
$currentUserType=$_SESSION['login_type'];
include_once('../includes/dbcon.php');
if(isset($_POST["recordMfsUpload_iq"]))
	{	$totSent=0; $totReceived=0;
		$doQs=mysqli_query($con,"SELECT count(*) from tbl_initiator_query WHERE addstatus='Pending' ");
		if ($da=mysqli_fetch_array($doQs) !=0)
		{	
			$doQ=mysqli_query($con,"SELECT DISTINCT do_name from tbl_initiator_query WHERE do_name !='' AND addstatus='Pending' ");
			while($datam=mysqli_fetch_array($doQ))
				{
					$do=$datam['do_name'];
					
					$qr1=mysqli_query($con,"SELECT sum(tx_amount) FROM tbl_initiator_query WHERE do_name='$do' AND tx_effect='Sent' AND addstatus='Pending' ")or die(mysqli_query());
					$da1=mysqli_fetch_array($qr1);
					$sentAmnt=$da1['sum(tx_amount)'];
									
					$qr2=mysqli_query($con,"SELECT sum(tx_amount) FROM tbl_initiator_query WHERE do_name='$do' AND tx_effect='Received' AND addstatus='Pending' ")or die(mysqli_query());
					$da2=mysqli_fetch_array($qr2);
					$receivedAmnt=$da2['sum(tx_amount)'];
									
					$dateNow=$_POST['trDate'];
					
					if($sentAmnt!='')
						$sq1 = mysqli_query($con,"INSERT INTO tbl_financial_service(mfsStatus, mfsDate, mfsEmp, mfsAmnt,User) values('Sent','$dateNow','$do', $sentAmnt,'$currentUser')")or die(mysqli_query());
					if($receivedAmnt!='')
						$sq2 = mysqli_query($con,"INSERT INTO tbl_financial_service(mfsStatus, mfsDate, mfsEmp, mfsAmnt,User) values('Received','$dateNow','$do', $receivedAmnt,'$currentUser')")or die(mysqli_query());
				
					$qr3=mysqli_query($con,"UPDATE tbl_initiator_query SET addstatus='Recorded', recorddate='$dateNow', addedby='$currentUser' WHERE do_name='$do' AND addstatus='Pending' AND recorddate='Not Recorded' ")or die(mysqli_query());
				}
			echo "<script type=\"text/javascript\"> alert(\"Data has been successfully added.\"); window.location = \"../mfsupload_iq.php\"</script>";
		}
		else
			echo "<script type=\"text/javascript\"> alert(\"No Data to be added.\"); window.location = \"../mfsupload_iq.php\"</script>";
	}	 
?>		 


	 