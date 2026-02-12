<?php
include_once('../session.php');
include_once('includes/variables.php');
include_once('includes/dbcon.php');
include_once('includes/globalvar.php');
	if (isset($_POST['addemp']))
	{
		//$jnDate=$_POST['doJ'];
		$jnDate=$CurrentDate;
		$nm=$_POST['txtName'];
		$fullname=$_POST['txtNameFull'];
		$contact=$_POST['txtContactNo'];
		$address=$_POST['txtAddress'];
		$cnic=$_POST['txtCNIC'];
		//$comment=$_POST['txtCmnts'];
		//	if ($comment=='')
				$comment=='';
		$dolinenum=$_POST['txtDoLine'];
		$sal=$_POST['txtBsalary'];
		$comRate=$_POST['txtComRate'];
		$ordr=$_POST['txtOrder'];
		$type=$_POST['Tselect'];
		$show=$_POST['ShowSelect'];
			if($show=='Both')
				$visib=3;
			else if ($show=='DO-Advance')
				$visib=2;
			else if ($show=='Sales')
				$visib=1;
			else
				$visib=0;
		$status=$_POST['StatusSelect'];
		
		if ($nm=='')
			echo '<script type="text/javascript">alert("Please Enter Name.");</script>';
		else if($sal=='')
			echo '<script type="text/javascript">alert("Please Enter salary.");</script>';
		else if($cnic=='')
			echo '<script type="text/javascript">alert("Please Enter CNIC Number.");</script>';
		else if($fullname=='')
			echo '<script type="text/javascript">alert("Please Enter Full Name.");</script>';
		else if($contact=='')
			echo '<script type="text/javascript">alert("Please Enter Contact Number.");</script>';
		else if($address=='')
			echo '<script type="text/javascript">alert("Please Enter Address.");</script>';
		else if ($comRate=='')
			echo '<script type="text/javascript">alert("Please Enter Commission Rate.");</script>';
		else if($ordr=='')
			echo '<script type="text/javascript">alert("Please Enter Employee Show Order.");</script>';
		else if($type=='---')
			echo '<script type="text/javascript">alert("Please Select a Type from list.");</script>';
		else if($type=='---')
			echo '<script type="text/javascript">alert("Please Select a Type from list.");</script>';
		else
		{
		//EmpName,EmpJoinDate,EmpFixedSalary,EmpStatus,empType,Comments,sort_order,showIn,otcomrate,completeName,contactNo,empAddress,doLine,cnic
		
		
		
		$sq = mysqli_query($con,"INSERT INTO empinfo(EmpJoinDate, EmpName, EmpFixedsalary, EmpStatus, empType, Comments, sort_order, showIn, otcomrate,completeName,contactNo,empAddress,doLine,cnic) 
		values('$jnDate', '$nm', $sal, '$status' , '$type', '$comment', '$ordr','$visib','$comRate','$fullname','$contact','$address','$dolinenum','$cnic')")or die(mysqli_query());
			echo '<script type="text/javascript">alert("Successfully Added.");</script>';
		//echo $nm ." successfully added.";
		}
	}
?>
<head>
			<title>Employees</title>
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
						<center> <caption> <h2>Add New Employee</h2></caption> </center>
						
				<div  style="border: solid black 0px; ">
						
							<form name="f1" action="addemp.php" method="POST">
									<table cellpadding="0" cellspacing="0" border="0" class="table" id="HeadTable" >
												<tr>
													<!-- <td style="text-align: right;" > 
														Join Date:
													</td>
													<td style="text-align: left;" >
																<?php
																	$strDate= date('Y-m-d');
																	echo "<input type=\"date\" value= \"$strDate\"  name=\"doJ\" id=\"tBox\">";
																?>
													</td> -->
													<td style="text-align: right;" >
														Emp Display Name:
													</td>
													<td style="text-align: left;" >
													    <input type="text" name="txtName" id="iBox">
													</td>
													<td style="text-align: right;" >
														CNIC:
													</td>
													<td style="text-align: left;" >
													<input type="text" name="txtCNIC" id="iBox">
													</td>
													<td style="text-align: right;" >
														DO Line:
													</td>
													<td style="text-align: left;" >
													<input type="text" name="txtDoLine" id="iBox">
													</td>
												</tr>
												<tr>
													<td style="text-align: right;" >
														Complete Name:
													</td>
													<td style="text-align: left;" >
													<input type="text" name="txtNameFull" id="iBox">
													</td>
													
													<td style="text-align: right;" >
														Contact No:
													</td>
													<td style="text-align: left;" >
													    <input type="text" name="txtContactNo" id="iBox">
													</td>
													<td style="text-align: right;" >
														Address:
													</td>
													<td style="text-align: left;" >
													    <input type="text" name="txtAddress" id="iBox">
													</td>
												</tr>
												<tr>
													<td style="text-align: right;" > 
														Basic Salary:
													</td>
													<td style="text-align: left;" >
													<input type="text" name="txtBsalary" id="iBox1">
													</td>
													<td style="text-align: right;" >
														Commission Rate:
													</td>
													<td style="text-align: left;" >
													<input type="text" name="txtComRate" id="iBox1"> i.e. 0.001
													</td>
													
													
													
													<td style="text-align: right;"> Show Order: </td>
													<td style="text-align: left;" >
														<input type="text" name="txtOrder" id="iBox1">	
													</td>
												</tr>
												<tr>
													<td style="text-align: right;"> Employee Type: </td>
													<td style="text-align: left;" >
															<select name="Tselect" id="sBox1">
																	<option >---</option>
																	<?php
																		$doQ=mysqli_query($con,"SELECT abbvr from abbvr WHERE type='Emp' ");
																		while($data=mysqli_fetch_array($doQ))
																			{
																				echo "<option>";
																				echo $data['abbvr'];
																				echo "</option>";
																			}
																	?>
															</select>
													</td>
													<td style="text-align: right;" > 
														Show Employee In:
													</td>
													<td style="text-align: left;" >
														<select name="ShowSelect" id="sBox1">
															<option>Both</option>
															<option>DO-Advance</option>
															<option>Sales</option>
															<option>Hide</option>
														</select>
													</td>
													<td style="text-align: right;" > 
														Current Status:
													</td>
													<td style="text-align: left;" >
														<select name="StatusSelect" id="sBox1">
															<option>Active</option>
															<option>Left</option>
														</select>
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
														<th>Type</th>
														<th>Display Name</th>
														<th>DO Line</th>
														<th>Full Name</th>
														<th>CNIC Number</th>
														<th>Contact</th>
														<th>Address</th>
														<th>Salary</th>
														<th>Com Rate</th>
														<th>Joining Date</th>
														<th>Action</th>
													</tr>
												<?php
																							
													$sql = mysqli_query($con,"SELECT * FROM empinfo WHERE EmpStatus='Active' AND (empType='do' OR empType='SP' OR empType='Other') Order by sort_order ASC")or die(mysqli_query());
														WHILE($Data=mysqli_fetch_array($sql))
															{ 
														$id = $Data['EmpID'];
															?>
															<tr>
																<td><?php echo $Data['EmpID']; ?></td>
																<td><?php echo $Data['empType']; ?></td>
																<td><?php echo $Data['EmpName']; ?></td>
																<td><?php echo $Data['doLine']; ?></td>
																<td><?php echo $Data['completeName']; ?></td>
																<td><?php echo $Data['cnic']; ?></td>
																<td><?php echo $Data['contactNo']; ?></td>
																<td><?php echo $Data['empAddress']; ?></td>
																<td><?php echo $Data['EmpFixedSalary']; ?></td>
																<td><?php echo $Data['otcomrate']; ?></td>
																<td><?php echo $Data['EmpJoinDate']; ?></td>
																
																<td><a href="edit/editemp.php?ID=<?php echo $id; ?>" id="LinkBtnEdit">Edit</a> &nbsp;&nbsp;&nbsp;&nbsp;
																<!-- <a href="delete/delemp.php?ID=<?php echo $id; ?>" id="LinkBtnDel">Resigned</a></td>
																-->
																<?php echo "<a onClick=\"javascript: return confirm('You are about to Resign this Employee');\" href=\"resign.php?Emp=".$Data['EmpName']."\" id=\"LinkBtnDel\">Resign</a></td>";
															?>
															</tr>
															<?php 
															}
													?>
									</table>
													
							</div>
			
	</div>
</html>
