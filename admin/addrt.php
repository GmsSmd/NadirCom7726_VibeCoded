<?php
include_once('../session.php');
include_once('includes/variables.php');
include_once('includes/dbcon.php');
include_once('includes/globalvar.php');
$queryrt="SELECT * FROM retailers ORDER BY number ASC";
	if (isset($_POST['addrt']))
	{
		$orgName=$_POST['txtOrgName'];
		$orgNum=$_POST['txtOrgNumber'];
		$doName=$_POST['doNameSelect'];
		$doNum=$_POST['doLineNum'];
		$retailerName=$_POST['txtRetailerName'];
		$retailerNumber=$_POST['txtRetailerNumber'];
		
		
		//$number=$_POST['txtNumber'];
		//$nm=$_POST['txtName'];
		//$do=$_POST['Tselect'];
		
		if($orgName=='')
			echo '<script type="text/javascript">alert("Please Enter Organization Name.");</script>';
		else if($orgNum=='')
			echo '<script type="text/javascript">alert("Please Enter Master Line Number.");</script>';
		else if($retailerName=='')
			echo '<script type="text/javascript">alert("Please Enter Retailer Name.");</script>';
		else if($retailerNumber=='')
			echo '<script type="text/javascript">alert("Please Enter Retailer Number.");</script>';
		else if($doName=='---')
			echo '<script type="text/javascript">alert("Please Select DO Name from list.");</script>';
		else if($doNum=='')
			echo '<script type="text/javascript">alert("Please Enter DO Line Number.");</script>';
		else
		{
		$sq = mysqli_query($con,"INSErt INTO retailers(org_name, ml_number, do_name, do_line_number, DO, retailer_shop_name, name, number) values('$orgName','$orgNum','$doName','$doNum','$doName','$retailerName','$retailerName','$retailerNumber') ")or die(mysqli_query());
		echo '<script type="text/javascript">alert("Successfully added");</script>';
		//echo $nm ." successfully added.";
		}
	}
	
	if (isset($_POST['viewRetailers']))
	{
		$olddo=$_POST['Tselectold'];
		$queryrt="SELECT * FROM retailers WHERE DO='$olddo' OR do_name='$olddo' ORDER BY number ASC";
	}
	if (isset($_POST['updateDO']))
	{
		
		$olddo=$_POST['Tselectold'];
		$newdo=$_POST['Tselectnew'];
		$sq23 = mysqli_query($con,"UPDATE retailers SET DO = '$newdo', do_name = '$newdo' WHERE DO = '$olddo'")or die(mysqli_query());
		echo '<script type="text/javascript">alert("Successfully Updated");</script>';
		$queryrt="SELECT * FROM retailers WHERE DO='$newdo' OR do_name='$newdo' ORDER BY number ASC";
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
													<td style="text-align: right;" >Organization:</td>
													<td style="text-align: left;" > 
													    <input type="text" name="txtOrgName" id="iBox" Value="<?php echo $orgnization_name; ?>">
													</td>
													<td style="text-align: right;" >Master Line #:</td>
													<td style="text-align: left;" > 
													    <input type="text" name="txtOrgNumber" id="iBox" Value="<?php echo $master_line_num; ?>">
													</td>
												</tr>
												
												<tr>
													<td style="text-align: right;"> DO Name: </td>
													
													<td style="text-align: left;" >
															<select name="doNameSelect" id="sBox">
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
													<td style="text-align: right;" >DO Line #:</td>
													<td style="text-align: left;" > 
													    <input type="text" name="doLineNum" id="iBox" Value="9230">
													</td>
												</tr>
												
												
												<tr>
													<td style="text-align: right;" >
														Retailer Name:
													</td>
													<td style="text-align: left;" >
													<input type="text" name="txtRetailerName" id="iBox">
													</td>
													
														<td style="text-align: right;" > 
														Retailer Number:
													</td>
													<td style="text-align: left;" >
													<input type="text" name="txtRetailerNumber" id="iBox" Value="9230">
													</td>
													
												</tr>
												<tr>
													<td colspan="6" style="text-align: center;" > 
														<input type="submit"  value="Add New" name="addrt" id="Btn">
													</td>
												</tr>
									</table>
							</form>
							
							<form name="f2" action="" method="POST">
									<table cellpadding="0" cellspacing="0" border="0" class="table" id="HeadTable" >
												<tr>
													<td style="text-align: right;">Current DO: </td>
													
													<td style="text-align: left;" >
															<select name="Tselectold" id="sBox">
																	<option >---</option>
																	<?php
																		$doQ=mysqli_query($con,"SELECT DISTINCT DO from retailers");
																		while($data=mysqli_fetch_array($doQ))
																			{
																				
																				if (isset($_POST['viewRetailers']) and $olddo==$data['DO'])
																					echo "<option selected>";
																				else
																					echo "<option>";
																				echo $data['DO'];
																				echo "</option>";
																			}
																	?>
															</select>
													<input type="submit"  value="View Retailer" name="viewRetailers" id="Btn">
													</td>
													
													
													<td style="text-align: right;">New DO: </td>
													
													<td style="text-align: left;" >
															<select name="Tselectnew" id="sBox">
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
													        <input type="submit"  value="Update DO" name="updateDO" id="Btn">
													</td>
													
													
												</tr>
									</table>
							</form>
<br>
								
									
									<table cellpadding="0" cellspacing="0" border="1" class="" id="dbResult">
													<tr style="background-color: #FFDAB9; font-weight: bold;" >
														<th>ID</th>
														<th>Organization</th>
														<th>Master Line #</th>
													    <th>DO Name</th>
														<th>DO Line #</th>
														<th>Reatiler /customer Name</th>
														<th>Retailer Line #</th>
														<th>Action</th>
													</tr>
												<?php
																							
													$sql = mysqli_query($con,$queryrt)or die(mysqli_query());
														WHILE($Data=mysqli_fetch_array($sql))
															{ 
														$id = $Data['ID'];
															?>
															<tr>
															    <td><?php echo $Data['ID']; ?></td>
															    <td><?php echo $Data['org_name']; ?></td>
															    <td><?php echo $Data['ml_number']; ?></td>
															    <td><?php echo $Data['DO']; ?></td>
															    <td><?php echo $Data['do_line_number']; ?></td>
																<td><?php echo $Data['name']; ?></td>
																<td><?php echo $Data['number']; ?></td>
																
																
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
