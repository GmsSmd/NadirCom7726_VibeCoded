<?php
include_once('../includes/dbcon.php');
include_once('../includes/globalvar.php');

$eid = $_GET['ID'];
$edit = mysqli_query($con,"SELECT * FROM empinfo WHERE EmpID = '$eid'") or die(mysqli_error());
$emp = mysqli_fetch_array($edit);
$naam=$emp['EmpName'];
$dat=$emp['EmpJoinDate'];
	
	if (isset($_POST['Return']))
	{
		header("Location: ../addemp.php");
		//exit;
	} 
	
	if (isset($_POST['Update']))
	{
		//$jnDate=$_POST['doJ'];
		$nm=$_POST['txtName'];
		$fullname=$_POST['txtNameFull'];
		$contact=$_POST['txtContactNo'];
		$address=$_POST['txtAddress'];
		$cnics=$_POST['txtCNIC'];
		//$comment=$_POST['txtCmnts'];
		//	if ($comment=='')
				$comment=='-';
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
		else if($cnics=='')
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
		else
		{
		$sq = mysqli_query($con,"UPDATE empinfo SET EmpName= '$nm', EmpFixedsalary= $sal, EmpStatus='$status', empType='$type', sort_order='$ordr', showIn='$visib', otcomrate='$comRate',completeName='$fullname',contactNo='$contact',empAddress='$address',doLine='$dolinenum',cnic='$cnics' WHERE EmpID = '$eid' ")or die(mysqli_query());
			//echo '<script type="text/javascript">alert("Successfully Updated.");</script>';
		//echo $nm ." successfully added.";
		//$eid = $_GET['ID'];
        //$edit = mysqli_query($con,"SELECT * FROM empinfo WHERE EmpID = '$eid'") or die(mysqli_error());
        //$emp = mysqli_fetch_array($edit);
		header("Location: ../addemp.php");
		//exit;
		}
	}
?>
<head>
			<title>Edit Employee</title>
			<style>
			<?php
			include_once('../styles/navbarstyle.php');
			include_once('../styles/tablestyle.php');
			?>
			</style>
	</head>
			
		<?php
			include_once('../includes/navbar.php');
		?>

	<div class="container" align="center">
						<center> <caption> <h2>Edit Employee</h2></caption> </center>
						
				<div  style="border: solid black 0px; ">
						
							<form name="f1" action="" method="POST">
									<table cellpadding="0" cellspacing="0" border="0" class="table" id="HeadTable" >
												<tr>
												    <input type="text" name="txtID" id="iBox" value="<?php echo $emp['EmpID']; ?>" hidden>
												    <!-- <td style="text-align: right;" >
														ID:
													</td>
													<td style="text-align: left;" >
													<input type="text" name="txtID" id="iBox" value="<?php echo $emp['EmpID']; ?>" disabled>
													</td> -->
													<td style="text-align: right;" >
														Display Name:
													</td>
													<td style="text-align: left;" >
													    <input type="text" name="txtName" value="<?php echo $emp['EmpName']; ?>" id="iBox">
													</td>
													<td style="text-align: right;" >
														CNIC:
													</td>
													<td style="text-align: left;" >
													<input type="text" name="txtCNIC" value="<?php echo $emp['cnic']; ?>" id="iBox">
													</td>
													<td style="text-align: right;" >
														DO Line:
													</td>
													<td style="text-align: left;" >
													<input type="text" name="txtDoLine" value="<?php echo $emp['doLine']; ?>" id="iBox">
													</td>
													
												</tr>
												<tr>
													<td style="text-align: right;" >
														Complete Name:
													</td>
													<td style="text-align: left;" >
													<input type="text" name="txtNameFull" value="<?php echo $emp['completeName']; ?>" id="iBox">
													</td>
													
													<td style="text-align: right;" >
														Contact No:
													</td>
													<td style="text-align: left;" >
													    <input type="text" name="txtContactNo" value="<?php echo $emp['contactNo']; ?>" id="iBox">
													</td>
													<td style="text-align: right;" >
														Address:
													</td>
													<td style="text-align: left;" >
													    <input type="text" name="txtAddress" value="<?php echo $emp['empAddress']; ?>" id="iBox">
													</td>
												</tr>
												<tr>
													<td style="text-align: right;" > 
														Basic Salary:
													</td>
													<td style="text-align: left;" >
													<input type="text" name="txtBsalary" value="<?php echo $emp['EmpFixedSalary']; ?>" id="iBox1">
													</td>
													<td style="text-align: right;" >
														Commission Rate:
													</td>
													<td style="text-align: left;" >
													<input type="text" name="txtComRate" value="<?php echo $emp['otcomrate']; ?>" id="iBox1"> i.e. 0.001
													</td>
													
													
													
													<td style="text-align: right;"> Show Order: </td>
													<td style="text-align: left;" >
														<input type="text" name="txtOrder" value="<?php echo $emp['sort_order']; ?>" id="iBox1">	
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
																				if($data['abbvr']==$emp['empType'])
																					echo "<option selected>";
																				else
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
															<?php 	if ($emp['showIn']==3) echo "<option selected>Both</option>"; else echo "<option>Both</option>";
																	if ($emp['showIn']==2) echo "<option selected>DO-Advance</option>"; else echo "<option>DO-Advance</option>";
																	if ($emp['showIn']==1) echo "<option selected>Sales</option>"; else echo "<option>Sales</option>";
																	if ($emp['showIn']==0) echo "<option selected>Hide</option>"; else echo "<option>Hide</option>";
															?>
														</select>
													</td>
													<td style="text-align: right;" > 
														Current Status:
													</td>
													<td style="text-align: left;" >
														<select name="StatusSelect" id="sBox1">
															<?php 	if ($emp['EmpStatus']=='Active') echo "<option selected>Active</option>"; else echo "<option>Active</option>";
																	if ($emp['EmpStatus']=='Left') echo "<option selected>Left</option>"; else echo "<option>Left</option>";
															?>
														</select>
													</td>
													
												</tr>
												<tr>
													<td colspan="6" style="text-align: center;" > 
														<input type="submit"  value="Update" name="Update" id="Btn">
														<input type="submit"  value="Return" name="Return" id="Btn">
													</td>
												</tr>
									</table>
									
									
									<!--
									<table cellpadding="0" cellspacing="0" border="0" class="table" id="HeadTable" >
												<tr>
												<td style="text-align: right;" >
														ID:
													</td>
													<td style="text-align: left;" >
													<input type="text" name="txtID" id="iBox" value="<?php echo $eid; ?>" disabled>
													</td>
												</tr>
												<tr>
												<td style="text-align: right;"> Type: </td>
													<td style="text-align: left;" >
															<select name="Tselect" id="sBox">
																	<option >---</option>
																	<?php
																		$doQ=mysqli_query($con,"SELECT abbvr from abbvr WHERE type='Emp' ");
																		while($data=mysqli_fetch_array($doQ))
																			{
																				if($data['abbvr']==$type)
																					echo "<option selected>";
																				else
																					echo "<option>";
																				
																				echo $data['abbvr'];
																				echo "</option>";
																			}
																	?>
															</select>
													</td>
												</tr>
												
												<tr>
													<td style="text-align: right;" >
														Name:
													</td>
													<td style="text-align: left;" >
													<input type="text" name="txtName" id="iBox" value="<?php echo $name1; ?>">
													</td>
												</tr>
												<tr>
													<td style="text-align: right;" > 
														Join Date:
													</td>
													<td style="text-align: left;" >
																<?php
																	echo "<input type=\"date\" value= \"$date1\"  name=\"doJ\" id=\"tBox\">";
																?>
													</td>
												</tr>
												
												<tr>
													<td style="text-align: right;" > 
														Basic salary:
													</td>
													<td style="text-align: left;" >
													<input type="text" name="txtBsalary" id="iBox" value="<?php echo $sal1; ?>">
													</td>
												</tr>
												<tr>
													<td colspan="2" style="text-align: center;" > 
														<input type="submit"  value="Update" name="Update" id="Btn">  <a href="../addemp.php"><< back</a>
													</td>
												</tr>
									</table> -->
							</form>	
			</div>
			
	</div>
</html>
