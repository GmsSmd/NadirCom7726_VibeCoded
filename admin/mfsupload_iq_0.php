<!DOCTYPE html>
<?php
	include_once('../session.php');
	include_once('includes/dbcon.php');
	include_once('includes/globalvar.php');
		$currentActiveUser=$_SESSION['login_user'];	
		$currentUser=$currentActiveUser;
		$currentUserType=$_SESSION['login_type'];
	//include_once('includes/variables.php');
	//include_once('includes/recordmfsupload.php');
?>	
<html lang="en">
	<head>
			<title>Upload Initiator Query</title>
			<style>
			<?php
			include_once('styles/navbarstyle.php');
			include_once('styles/tablestyle.php');
			include_once('includes/navbar.php');
			?>
			</style>
	</head>
	
	<body>    
	<div class="container" align="center">
			<form action="includes/getmfsupload_iq.php" method="post" name="upload_excel" enctype="multipart/form-data">
				<fieldset>
				<legend>Import CSV/Excel File</legend>
					<input type="file" name="file" id="file" class="input-large">
					<button type="submit" id="submit" name="Import" >Upload</button>
				</fieldset>
			</form>
		<br>
			<table cellpadding="0" cellspacing="0" border="0" class="table" id="HeadTable"  >
				<thead>
					<tr>
						<th>ID</th>
						<th>Tr ID</th>
						<th>MSISDN</th>
						<th>Name</th>
						<th>Benificiary Name</th>
						<th>Benificiary Number</th>
						<th>Tr Type</th>
						<th>Tr Effect</th>
						<th>Opening Bal</th>
						<th>Transaction</th>
						<th>Closing Bal</th>
						<th>DO Name</th>
						<th>Tr Time</th>
						<th>Status</th>
						<th>Action</th>
					</tr>
				</thead>
					<?php
						$getdata=mysqli_query($con,"SELECT * from tbl_initiator_query WHERE addstatus='Pending'; ");
						while($data=mysqli_fetch_array($getdata))
							{
								$id=$data['ref_id'];
						?>
							<tr>
								<td><?php echo $data['ref_id']; ?></td>
								<td><?php echo $data['tx_id']; ?></td>
								<td><?php echo $data['initiator_msisdn']; ?></td>
								<td><?php echo $data['initiator_organization']; ?></td>
								<td><?php echo $data['beneficiary_name']; ?></td>
								    <?php
								    
								    $nm=$data['beneficiary_name'];
								    $ddddoooo=$data['do_name'];
    								    $qury2=mysqli_query($con,"SELECT * FROM retailers WHERE do_name='$ddddoooo' AND retailer_shop_name='$nm';")or die(mysqli_query());
        								$data2=mysqli_fetch_array($qury2);
        								$numbr=$data2['number'];
        								if($numbr!='' and $data['beneficiary_name']!="$orgnization_name")
        								    echo "<td>".$numbr."</td>";
        								else if($numbr=='' and $data['beneficiary_name']=="$orgnization_name")
        								    echo "<td>".$data['initiator_msisdn']."</td>";
        								else
        								    echo "<td>Walking Customer</td>";
							        
        								    
								    ?>
								<td><?php echo $data['tx_type']; ?></td>
								<td><?php echo $data['tx_effect']; ?></td>
								<td><?php echo $data['balance_before_tx']; ?></td>
								<td><?php echo $data['tx_amount']; ?></td>
								<td><?php echo $data['balance_after_tx']; ?></td>
								<td><?php echo $data['do_name']; ?></td>
								<td><?php echo $data['tx_date']." ".$data['tx_time']; ?></td>
								<td><?php echo $data['addstatus']; ?></td>
								
								<td><a href="delete/delmfsupload_iq.php?ID=<?php echo $id; ?>" id="LinkBtnDel">Delete</a></td>
								
							</tr>
						<?php
						}
					?>
			</table>
		<br>
			<form action="includes/recordmfsupload_iq.php" method="post" name="upload_excel" enctype="multipart/form-data">
				<fieldset>
					<legend>After Checking data click "Add Now" button to record data in respective DO account.</legend>
					<?php
						$strDate= date('Y-m-d');
						echo "<input type=\"date\" value= \"$strDate\"  name=\"trDate\" id=\"tBox\" >";
					?>
					<button type="submit" id="iBox1" name="recordMfsUpload_iq" >Add Now</button>
				</fieldset>
			</form>
	</div>
	<div>
	
	<br><br>
	<h2><center> Today's Uploads </center></h2>
	<table cellpadding="0" cellspacing="0" border="0" class="table" id="HeadTable"  >
				<thead>
					<tr>
						<th>Tr ID</th>
						<th>MSISDN</th>
						<th>Name</th>
						<th>Benificiary Name</th>
						<th>Benificiary Number</th>
						<th>Tr Type</th>
						<th>Tr Effect</th>
						<th>Transaction</th>
						<th>DO Name</th>
						<th>Tr Time</th>
					</tr>
				</thead>
					<?php
						$currentDate=date('Y-m-d');
						$getdata=mysqli_query($con,"SELECT * from tbl_initiator_query WHERE recorddate='$currentDate' "); //recorddate='$currentDate'
						while($data=mysqli_fetch_array($getdata))
							{
								$id=$data['mfstrid'];
					?>
						    <tr>
								<td><?php echo $data['tx_id']; ?></td>
								<td><?php echo $data['initiator_msisdn']; ?></td>
								<td><?php echo $data['initiator_organization']; ?></td>
								<td><?php echo $data['beneficiary_name']; ?></td>
								
								<?php
								$nm=$data['beneficiary_name'];
								    $ddddoooo=$data['do_name'];
    								    $qury=mysqli_query($con,"SELECT * FROM retailers WHERE do_name='$ddddoooo' AND retailer_shop_name='$nm';")or die(mysqli_query());
        								$data2=mysqli_fetch_array($qury);
        								$numbr=$data2['number'];
        								if($numbr!='' and $data['beneficiary_name']!="$orgnization_name")
        								    echo "<td>".$numbr."</td>";
        								else if($numbr=='' and $data['beneficiary_name']=="$orgnization_name")
        								    echo "<td>".$data['initiator_msisdn']."</td>";
        								else
        								    echo "<td>Walking Customer</td>";
								?>
								<td><?php echo $data['tx_type']; ?></td>
								<td><?php echo $data['tx_effect']; ?></td>
								<td><?php echo $data['tx_amount']; ?></td>
								<td><?php echo $data['do_name']; ?></td>
								<td><?php echo $data['tx_date']." ".$data['tx_time']; ?></td>
							</tr>
					<?php
						}
					?>
			</table>
	
	
	</div>
	</body>
</html>