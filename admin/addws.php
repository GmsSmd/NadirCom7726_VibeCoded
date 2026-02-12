<?php
include_once('../session.php');
include_once('includes/variables.php');
include_once('includes/dbcon.php');
include_once('includes/globalvar.php');
	if (isset($_POST['addemp']))
	{
	
		$nm=$_POST['txtName'];
		$jnDate=$_POST['doJ'];
		$sal=$_POST['txtBsalary'];
		//$type=$_POST['Tselect'];
		$type='ws';
		
		
		if($type=='---')
			echo '<script type="text/javascript">alert("Please Select a Type from list.");</script>';
		else if($nm=='')
			echo '<script type="text/javascript">alert("Please Enter Name.");</script>';
		else if($sal=='')
			echo '<script type="text/javascript">alert("Please Enter salary.");</script>';
		else
		{
		$sq = mysqli_query($con,"INSErt INTO empinfo(EmpName, EmpJoinDate, EmpFixedsalary, EmpStatus, empType) values('$nm', '$jnDate', $sal, 'Active' , '$type')")or die(mysqli_query());
		//echo $nm ." successfully added.";
		}
	}
?>
<head>
			<title>Whole Seller</title>
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
						<center> <caption> <h2>Add New Whole Seller</h2></caption> </center>
						
				<div  style="border: solid black 0px; ">
						
							<form name="f1" action="" method="POST">
									<table cellpadding="0" cellspacing="0" border="0" class="table" id="HeadTable" >
												<tr>
													<td style="text-align: right;" > 
														Join Date:
													</td>
													<td style="text-align: left;" >
																<?php
																	$strDate= date('Y-m-d');
																	echo "<input type=\"date\" value= \"$strDate\"  name=\"doJ\" id=\"tBox\">";
																?>
													</td>
													
													<!--
													<td style="text-align: right;"> Type: </td>
													
													<td style="text-align: left;" >
															<select name="Tselect" id="sBox">
																	<option >---</option>
																	<?php
																		$doQ=mysqli_query($con,"SELECT abbvr from abbvr WHERE type='Sk' ");
																		while($data=mysqli_fetch_array($doQ))
																			{
																				echo "<option>";
																				echo $data['abbvr'];
																				echo "</option>";
																			}
																	?>
															</select>
													</td>
													-->
												
													<td style="text-align: right;" >
														Whole Seller Name:
													</td>
													<td style="text-align: left;" >
													<input type="text" name="txtName" id="iBox">
													</td>
													<td style="text-align: right;" > 
														Salary (if any):
													</td>
													<td style="text-align: left;" >
													<input type="text" value="0" name="txtBsalary" id="iBox">
													</td>
												</tr>
												<tr>
													<td colspan="6" style="text-align: center;" > 
														<input type="submit"  value="Add New" name="addemp" id="Btn">
													</td>
												</tr>
									</table>
							</form>
<br>
								
									
									<table cellpadding="0" cellspacing="0" border="1" class="" id="dbResult">
													<tr style="background-color: #FFDAB9; font-weight: bold;" >
														<th>ID</th>
														<th>Name</th>
														<th>Joining Date</th>
														<th>Salary</th>
														<th>Type</th>
														<th>Action</th>
													</tr>
												<?php
																							
													$sql = mysqli_query($con,"SELECT * FROM empinfo WHERE empType='ws' OR empType='rt'")or die(mysqli_query());
														WHILE($Data=mysqli_fetch_array($sql))
															{ 
														$id = $Data['EmpID'];
															?>
															<tr>
																<td><?php echo $Data['EmpID']; ?></td>
																<td><?php echo $Data['EmpName']; ?></td>
																<td><?php echo $Data['EmpJoinDate']; ?></td>
																<td><?php echo $Data['EmpFixedSalary']; ?></td>
																<td><?php echo $Data['empType']; ?></td>
																
																<td><a href="edit/editws.php?ID=<?php echo $id; ?>" id="LinkBtnEdit">Edit</a> &nbsp;&nbsp;&nbsp;&nbsp;
																<a href="delete/delws.php?ID=<?php echo $id; ?>" id="LinkBtnDel">Delete</a></td>
																
															</tr>
															<?php 
															}
													?>
									</table>
													
							</div>
			
	</div>
</html>
