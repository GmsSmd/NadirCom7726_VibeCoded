<?php
include_once('../session.php');
include_once('includes/variables.php');
include_once('includes/dbcon.php');
include_once('includes/globalvar.php');
	if (isset($_POST['changeOrder']))
	{
		foreach ($_POST['emID'] as $idx => $stuff)
		{
			if($_POST['newOrd'][$idx]!="")
			{
				$srt=$_POST['newOrd'][$idx];
				$sq = mysqli_query($con,"UPDATE empinfo SET sort_order=$srt WHERE EmpID = $stuff ")or die(mysqli_query());
			}
		}
	echo '<script type="text/javascript">alert("Successfully Updated");</script>';
	}
?>
<head>
			<title>Employees Order</title>
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
						<center> <caption> <h2>Change Employee Order</h2></caption> </center>
						
				<div  style="border: solid black 0px; ">
							<form method="POST">
									<table cellpadding="0" cellspacing="0" border="1" class="" id="dbResult">
													<tr style="background-color: #FFDAB9; font-weight: bold;" >
														<th>Order</th>
														<th>Name</th>
														<th>Joining Date</th>
														<th>Salary</th>
														<th>Type</th>
														<th>New Order</th>
													</tr>
												<?php
																							
													$sql = mysqli_query($con,"SELECT * FROM empinfo WHERE EmpStatus='Active' Order by sort_order ASC")or die(mysqli_query());
														WHILE($Data=mysqli_fetch_array($sql))
															{ 
															$id = $Data['EmpID'];
															?>
															<tr>
																<td><input style="border: none; background: transparent;" type="text" name="emID[]" id="iBox3" value="<?php echo $id; ?>" hidden><?php echo $Data['sort_order']; ?></td>
																<td><?php echo $Data['EmpName']; ?></td>
																<td><?php echo $Data['EmpJoinDate']; ?></td>
																<td><?php echo $Data['EmpFixedSalary']; ?></td>
																<td><?php echo $Data['empType']; ?></td>
																
																
																<td>
																	<input type="text" name="newOrd[]" id="iBox2" value="">
																</td>
																
															</tr>
															<?php 
															}
															
													?>
									</table>
									<input type="submit"  value="Change Order" name="changeOrder" id="Btn">
							</form>	
				</div>
			
	</div>
</html>
