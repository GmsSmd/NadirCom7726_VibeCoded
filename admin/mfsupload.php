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
			<title>MFS Upload</title>
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
			<form action="includes/getmfsupload.php" method="post" name="upload_excel" enctype="multipart/form-data">
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
						<th>Tr Type</th>
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
						$getdata=mysqli_query($con,"SELECT * from mfstransactions WHERE addstatus='Pending' ");
						while($data=mysqli_fetch_array($getdata))
							{
								$id=$data['mfstrid'];
						?>
							<tr>
								<td><?php echo $data['mfstrid']; ?></td>
								<td><?php echo $data['trid']; ?></td>
								<td><?php echo $data['orgmsisdn']; ?></td>
								<td><?php echo $data['orgname']; ?></td>
								<td><?php echo $data['trtype']; ?></td>
								<td><?php echo $data['balbeforetr']; ?></td>
								<td><?php echo $data['tramnt']; ?></td>
								<td><?php echo $data['balaftertr']; ?></td>
								<td><?php echo $data['doname']; ?></td>
								<td><?php echo $data['trtime']; ?></td>
								<td><?php echo $data['addstatus']; ?></td>
								
								<td><a href="delete/delmfsupload.php?ID=<?php echo $id; ?>" id="LinkBtnDel">Delete</a></td>
								
							</tr>
						<?php
						}
					?>
			</table>
		<br>
			<form action="includes/recordmfsupload.php" method="post" name="upload_excel" enctype="multipart/form-data">
				<fieldset>
					<legend>After Checking data click "Add Now" button to record data in respective DO account.</legend>
					<?php
						$strDate= date('Y-m-d');
						//echo "<input type=\"date\" value= \"$strDate\"  name=\"trDate\" id=\"tBox\" >";
					
					if($currentUserType=='Admin'){
                        ?>
                            <input type="date" value="<?php echo $strDate; ?>"  name="trDate" id="tBox">
                        <?php
                    }else{
                        ?>
                            <input type="date" value="<?php echo $strDate; ?>"  name="trDate" id="tBox" min="<?php echo $strDate; ?>" max="<?php echo $strDate; ?>">
                        <?php
                    }
					
					?>
					
					
					
					
					<button type="submit" id="iBox1" name="recordMfsUpload" >Add Now</button>
				
				</fieldset>
			</form>
	</div>
	<div>
	
	<br><br>
	<h2><center> Today's Uploads </center></h2>
	<table cellpadding="0" cellspacing="0" border="0" class="table" id="HeadTable"  >
				<thead>
					<tr>
						<th>ID</th>
						<th>Tr ID</th>
						<th>MSISDN</th>
						<th>Name</th>
						<th>Tr Type</th>
						<th>Transaction</th>
						<th>DO Name</th>
						<th>Status</th>
						<th>Action</th>
					</tr>
				</thead>
					<?php
						$currentDate=date('Y-m-d');
						$getdata=mysqli_query($con,"SELECT * from mfstransactions WHERE recorddate='$currentDate' ");
						while($data=mysqli_fetch_array($getdata))
							{
								$id=$data['mfstrid'];
						?>
							<tr>
								<td><?php echo $data['mfstrid']; ?></td>
								<td><?php echo $data['trid']; ?></td>
								<td><?php echo $data['orgmsisdn']; ?></td>
								<td><?php echo $data['orgname']; ?></td>
								<td><?php echo $data['trtype']; ?></td>
								<td><?php echo $data['tramnt']; ?></td>
								<td><?php echo $data['doname']; ?></td>
								<td><?php echo $data['addstatus']; ?></td>
								
								<td><a href="delete/delmfsupload.php?ID=<?php echo $id; ?>" id="LinkBtnDel">Delete</a></td>
								
							</tr>
						<?php
						}
					?>
			</table>
	
	
	</div>
	</body>
</html>