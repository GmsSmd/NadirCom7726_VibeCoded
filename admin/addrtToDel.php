<?php
include_once('../session.php');
include_once('includes/variables.php');
include_once('includes/dbcon.php');
include_once('includes/globalvar.php');
	if (isset($_POST['addrt']))
	{
		$number=$_POST['txtNumber'];
		$nm=$_POST['txtName'];
		$do=$_POST['Tselect'];
		
		if($number=='')
			echo '<script type="text/javascript">alert("Please Enter Retailer Number.");</script>';
		else if($do=='---')
			echo '<script type="text/javascript">alert("Please Select a do from list.");</script>';
		else
		{
		$sq = mysqli_query($con,"INSErt INTO retailers(number, name, do) values('$number', '$nm', '$do') ")or die(mysqli_query());
		echo '<script type="text/javascript">alert("Successfully added");</script>';
		//echo $nm ." successfully added.";
		}
	}
?>
<head>
			<title>Retailer</title>
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
						<center> <caption> <h2>Add New Retailer</h2></caption> </center>
						
				<div  style="border: solid black 0px; ">
						
							<form name="f1" action="" method="POST">
									<table cellpadding="0" cellspacing="0" border="0" class="table" id="HeadTable" >
												<tr>
													<td style="text-align: right;" > 
														Retailer Number:
													</td>
													<td style="text-align: left;" >
													<input type="text" name="txtNumber" id="iBox">
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
														Retailer Name:
													</td>
													<td style="text-align: left;" >
													<input type="text" name="txtName" id="iBox">
													</td>
													<td style="text-align: right;"> DO: </td>
													
													<td style="text-align: left;" >
															<select name="Tselect" id="sBox">
																	<option >---</option>
																	<?php
																		$doQ=mysqli_query($con,"SELECT EmpName from empinfo WHERE EmpStatus='Active' AND empType='DO' ");
																		while($data=mysqli_fetch_array($doQ))
																			{
																				echo "<option>";
																				echo $data['EmpName'];
																				echo "</option>";
																			}
																	?>
															</select>
													</td>
												</tr>
												<tr>
													<td colspan="6" style="text-align: center;" > 
														<input type="submit"  value="Add New" name="addrt" id="Btn">
													</td>
												</tr>
									</table>
							</form>
<br>
								
									
									<table cellpadding="0" cellspacing="0" border="1" class="" id="dbResult">
													<tr style="background-color: #FFDAB9; font-weight: bold;" >
														<th>ID</th>
														<th>Name</th>
														<th>Number</th>
														<th>DO</th>
														<th>Action</th>
													</tr>
												<?php
																							
													$sql = mysqli_query($con,"SELECT * FROM retailers ORDER BY number ASC")or die(mysqli_query());
														WHILE($Data=mysqli_fetch_array($sql))
															{ 
														$id = $Data['ID'];
															?>
															<tr>
																<td><?php echo $Data['ID']; ?></td>
																<td><?php echo $Data['name']; ?></td>
																<td><?php echo $Data['number']; ?></td>
																<td><?php echo $Data['DO']; ?></td>
																
																<td><a href="edit/editrt.php?ID=<?php echo $id; ?>" id="LinkBtnEdit">Edit</a> &nbsp;&nbsp;&nbsp;&nbsp;
																<a href="delete/delrtinfo.php?ID=<?php echo $id; ?>" id="LinkBtnDel">Delete</a></td>
																
															</tr>
															<?php 
															}
													?>
									</table>
													
							</div>
			
	</div>
</html>
