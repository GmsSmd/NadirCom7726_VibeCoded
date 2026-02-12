<?php
include_once('../session.php');
include_once('includes/variables.php');
include_once('includes/dbcon.php');
include_once('includes/globalvar.php');
	if (isset($_POST['changeEmpVisibility']))
	{
		foreach ($_POST['emID'] as $idx => $stuff)
		{
			if($_POST['choice'][$stuff]=="Hide")
			{
				//echo $_POST['emID'][$idx]."-- 0 <br>";
				$changeit=$_POST['emID'][$idx];
				$sq = mysqli_query($con,"UPDATE empinfo SET showIn=0 WHERE EmpID = $changeit ")or die(mysqli_query());
			}
			else if($_POST['choice'][$stuff]=="Sales")
			{
				//echo $_POST['emID'][$idx]."-- 1 <br>";
				$changeit=$_POST['emID'][$idx];
				$sq = mysqli_query($con,"UPDATE empinfo SET showIn=1 WHERE EmpID = $changeit ")or die(mysqli_query());
			}
			else if($_POST['choice'][$stuff]=="DO-Dues")
			{
				//echo $_POST['emID'][$idx]."-- 2 <br>";
				$changeit=$_POST['emID'][$idx];
				$sq = mysqli_query($con,"UPDATE empinfo SET showIn=2 WHERE EmpID = $changeit ")or die(mysqli_query());
			}
			else
			{
				//echo $_POST['emID'][$idx]."-- 3 <br>";
				$changeit=$_POST['emID'][$idx];
				$sq = mysqli_query($con,"UPDATE empinfo SET showIn=3 WHERE EmpID = $changeit ")or die(mysqli_query());
			}
		}
	echo '<script type="text/javascript">alert("Successfully Updated");</script>';
	}
?>
<head>
			<title>Employee Visibility</title>
			<style>
			<?php
			include_once('styles/navbarstyle.php');
			include_once('styles/tablestyle.php');
			?>
			</style>
	</head>
			
		<?php
			include_once('includes/navbar.php');
		?>

	<div class="container" align="center">
						<center> <caption> <h2>Change Employee Visibility</h2></caption> </center>
						
				<div  style="border: solid black 0px; ">
							<form method="POST">
									<table cellpadding="0" cellspacing="0" border="1" class="" id="dbResult">
													<tr style="background-color: #FFDAB9; font-weight: bold;" >
														<th>Order</th>
														<th>Name</th>
														<th>Joining Date</th>
														<th>Salary</th>
														<th>Type</th>
														<th>Show In</th>
													</tr>
												<?php
																							
													$sql = mysqli_query($con,"SELECT * FROM empinfo WHERE EmpStatus='Active' ")or die(mysqli_query());
														WHILE($Data=mysqli_fetch_array($sql))
															{ 
															$id = $Data['EmpID'];
															?>
															<tr>
																<td><input style="border: none; background: transparent;" type="text" name="emID[]" id="iBox3" value="<?php echo $id; ?>" hidden><?php echo $Data['sort_order'];?></td>
																<td><?php echo $Data['EmpName']; ?></td>
																<td><?php echo $Data['EmpJoinDate']; ?></td>
																<td><?php echo $Data['EmpFixedSalary']; ?></td>
																<td><?php echo $Data['empType']; ?></td>
																<td>
																	<?php
																	if($Data['showIn']==0)
																		{	
																			echo "<input type=\"radio\" name=\"choice[$id]\" id=\"choice\" value=\"Hide\"  checked>Hide";
																			echo "<input type=\"radio\" name=\"choice[$id]\" id=\"choice\" value=\"Sales\">Sales";
																			echo "<input type=\"radio\" name=\"choice[$id]\" id=\"choice\" value=\"DO-Dues\">DO-Dues";
																			echo "<input type=\"radio\" name=\"choice[$id]\" id=\"choice\" value=\"Both\">Both";
																		}
																	else if ($Data['showIn']==1)
																		{
																			echo "<input type=\"radio\" name=\"choice[$id]\" id=\"choice\" value=\"Hide\">Hide";
																			echo "<input type=\"radio\" name=\"choice[$id]\" id=\"choice\" value=\"Sales\" checked>Sales";
																			echo "<input type=\"radio\" name=\"choice[$id]\" id=\"choice\" value=\"DO-Dues\">DO-Dues";
																			echo "<input type=\"radio\" name=\"choice[$id]\" id=\"choice\" value=\"Both\">Both";
																		}
																	else if ($Data['showIn']==2)
																		{	
																			echo "<input type=\"radio\" name=\"choice[$id]\" id=\"choice\" value=\"Hide\">Hide";
																			echo "<input type=\"radio\" name=\"choice[$id]\" id=\"choice\" value=\"Sales\">Sales";
																			echo "<input type=\"radio\" name=\"choice[$id]\" id=\"choice\" value=\"DO-Dues\" checked>DO-Dues";
																			echo "<input type=\"radio\" name=\"choice[$id]\" id=\"choice\" value=\"Both\">Both";
																		}
																	else
																		{	
																			echo "<input type=\"radio\" name=\"choice[$id]\" id=\"choice\" value=\"Hide\">Hide";
																			echo "<input type=\"radio\" name=\"choice[$id]\" id=\"choice\" value=\"Sales\">Sales";
																			echo "<input type=\"radio\" name=\"choice[$id]\" id=\"choice\" value=\"DO-Dues\">DO-Dues";
																			echo "<input type=\"radio\" name=\"choice[$id]\" id=\"choice\" value=\"Both\" checked>Both";
																		}
																	?>
																</td>
																
															</tr>
															<?php 
															}
															
													?>
									</table>
									<input type="submit"  value="Change" name="changeEmpVisibility" id="Btn">
							</form>	
				</div>
			
	</div>
</html>
