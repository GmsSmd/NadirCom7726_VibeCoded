<?php
include_once('../session.php');
$product=$_GET['name'];
include_once('includes/globalvar.php');
include_once('includes/variables.php');

if (isset ($_POST['SaveRate']))
{
	$dateNow=date('Y-m-d');
	$subProduct=$_POST['spselect'];
	$rate=$_POST['txtRate'];
	$cmnt=$_POST['txtCmnt'];
	
	if ($subProduct== "---")
		echo '<script type="text/javascript">alert("Please Select a Type.");</script>';
	else if ($rate== "")
		echo '<script type="text/javascript">alert("Please enter Purchase Rate.");</script>';
	else
	{
		$columnsToAdd="pName, spName, purchasePrice, saveDate,rtComments ";
		$valuesToAdd= " '$product','$subProduct', $rate,'$dateNow','$cmnt' ";
		//echo "$columnsToAdd". "<br>"."$valuesToAdd";
		
		$sq = mysqli_query($con,"INSErt INTO rates($columnsToAdd) values($valuesToAdd)")or die(mysqli_query());
		echo '<script type="text/javascript">alert("Rate Successfully Entered");</script>';
	}
}
if (isset ($_POST['SaveRate1']))
{
	$dateNow=date('Y-m-d');
	$Prate=$_POST['txtPRate'];
	$Srate=$_POST['txtSRate'];
	$cmnt=$_POST['txtCmnt'];
	
	if ($Prate== "")
		echo '<script type="text/javascript">alert("Please enter purchase rate.");</script>';
	else if ($Srate== "")
		echo '<script type="text/javascript">alert("Please enter sale Rate.");</script>';
	else
	{
		$columnsToAdd="pName, purchasePrice,salePrice, saveDate,rtComments ";
		$valuesToAdd= " '$product',$Prate,$Srate,'$dateNow','$cmnt' ";
		//echo "$columnsToAdd". "<br>"."$valuesToAdd";
		
		$sq = mysqli_query($con,"INSErt INTO rates($columnsToAdd) values($valuesToAdd)")or die(mysqli_query());
		echo '<script type="text/javascript">alert("Rate Successfully Entered");</script>';
	}
}
?>

<!doCTYPE html>
<html>

<head>
		<title>Set rates</title>
			<style>
			<?php
				include_once('styles/navbarstyle.php');
				include_once('styles/tablestyle.php');
				include_once('includes/navbar.php');
			?>
			</style>
	</head>


<div class="container" align="center" style="border: solid black 0px;" >
			    <center>
					<caption> <h2>
					<?php
					echo $product."'s ";
					?>
					Rate</h2></caption>
					<br> <br>
				</center>
				
				
				<div style="border: solid black 0px;" align="center" class="doBar">
					<?php
						$doQ=mysqli_query($con,"SELECT pName from products WHERE pName!='mfs' ");
						while($data=mysqli_fetch_array($doQ))
							{
								$name=$data['pName'];
								if($name== $product)
									$nm='doLinkSelected';
								else
									$nm='doLink';
								?>
								<a href="setrate.php?name=<?php echo $name;?>" id="<?php echo $nm;?>" class="button">
								<?php
								echo $data['pName']."</a>";
							}
					?>
				</div>
		<div  style="border: solid black 0px; " >
		
		
		<?php
			if ($product=='Otar')
			{
			?>
				<form name="f2" action="" method="POST">
									<table cellpadding="0" cellspacing="0" border="0" class="table" id="HeadTable" >
												<tr>
													<td style="text-align: right;">Margin Received: </td>
													<td style="text-align: left;" >
														<input type="text" name="txtPRate" id="tBox"> 

													</td>
												
													<td style="text-align: right;" >Margin Sent: 
													</td>
													
													<td style="text-align: left;" >
														 <input type="text" name="txtSRate" id="tBox"> 
													</td>
												
													<td style="text-align: right;" >Comments: 
													</td>
													
													<td style="text-align: left;" >
														 <input type="text" name="txtCmnt" id="tBox"> 
													</td>
												</tr>
												<tr>
													<td colspan="6" style="text-align: center;" >
														<input type="submit"  value="Save" name="SaveRate1" id="Btn">
													</td>
												</tr>
												
									</table>
							</form>
			<table cellpadding="0" cellspacing="0" border="1" class="" id="dbResult">
				<thead>
					<tr>
						<th>ID</th>
						<th>Margin Received</th>
						<th>Margin Sent</th>
						<th>Date</th>
						<th>Comments</th>
						<th>Action</th>
					</tr>
				</thead>
				<tbody>
				
				<?php
																							
													$sql = mysqli_query($con,"SELECT * FROM rates WHERE pName='$product' ORDER BY rtID DESC ")or die(mysqli_query());
														WHILE($Data=mysqli_fetch_array($sql))
															{ 
														$id = $Data['rtID'];
															?>
															<tr>
																<td><?php echo $Data['rtID']; ?></td>
																<td><?php echo $Data['purchasePrice']; ?></td>
																<td><?php echo $Data['salePrice']; ?></td>
																<td><?php echo $Data['saveDate']; ?></td>
																<td><?php echo $Data['rtComments']; ?></td>
																<td><a href="delete/delrate.php?ID=<?php echo $id; ?>&name=<?php echo $product;?>" id="LinkBtnDel">Delete</a></td>
															</tr>
															<?php 
															}
													?>
				
				
				
				
				
				
				
				
				
				
				
				
				</tbody>
			</table>
			
			
			<?php
			
			}
			else
			{
			?>
							<form name="f1" action="" method="POST">
									<table cellpadding="0" cellspacing="0" border="0" class="table" id="HeadTable" >
												<tr>
													<td style="text-align: right;">Type: </td>
													<td style="text-align: left;" >
															<select name="spselect" id="sBox">
																	<option >---</option>
																	<?php
																
																		$doQ=mysqli_query($con,"SELECT typeName from types WHERE productName='$product' AND isActive=1");
																		while($data=mysqli_fetch_array($doQ))
																			{
																				echo "<option>";
																				echo $data['typeName'];
																				echo "</option>";
																			}
																	?>
															</select>	
													</td>
												
													<td style="text-align: right;" >Purchase Rate: 
													</td>
													
													<td style="text-align: left;" >
														 <input type="text" name="txtRate" id="tBox"> 
													</td>
												
													<td style="text-align: right;" >Comments: 
													</td>
													
													<td style="text-align: left;" >
														 <input type="text" name="txtCmnt" id="tBox"> 
													</td>
												</tr>
												<tr>
													<td colspan="6" style="text-align: center;" >
														<input type="submit"  value="Save" name="SaveRate" id="Btn">
													</td>
												</tr>
												
									</table>
							</form>
									
		</div>
		<br>
		<div>
		
			<table cellpadding="0" cellspacing="0" border="1" class="" id="dbResult">
				<thead>
					<tr>
						<th>ID</th>
						<th>Name</th>
						<th>Price</th>
						<th>Date</th>
						<th>Comments</th>
						<th>Action</th>
					</tr>
				</thead>
				<tbody>
				
				<?php
																							
													$sql = mysqli_query($con,"SELECT * FROM rates WHERE pName='$product' ORDER BY rtID DESC ")or die(mysqli_query());
														WHILE($Data=mysqli_fetch_array($sql))
															{ 
														$id = $Data['rtID'];
															?>
															<tr>
																<td><?php echo $Data['rtID']; ?></td>
																<td><?php echo $Data['spName']; ?></td>
																<td><?php echo $Data['purchasePrice']; ?></td>
																<td><?php echo $Data['saveDate']; ?></td>
																<td><?php echo $Data['rtComments']; ?></td>
																<td><a href="delete/delrate.php?ID=<?php echo $id; ?>&name=<?php echo $product;?>" id="LinkBtnDel">Delete</a></td>
															</tr>
															<?php 
															}
													?>
				
				
				
				
				
				
				
				
				
				
				
				
				</tbody>
			</table>
			<?php
			}
			?>
		</div>
		<br>
    </div>
</html>