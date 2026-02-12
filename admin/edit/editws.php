<?php
include_once('../includes/dbcon.php');
include_once('../includes/globalvar.php');
$eid = $_GET['ID'];
$edit = mysqli_query($con,"SELECT * FROM empinfo WHERE EmpID = '$eid'") or die(mysqli_error());
$emp = mysqli_fetch_array($edit);
$name1=$emp['EmpName'];
$date1=$emp['EmpJoinDate'];
$sal1=$emp['EmpFixedsalary'];
$type=$emp['empType'];
	
	if (isset($_POST['Update']))
	{
		$nm=$_POST['txtName'];
		$jnDate=$_POST['doJ'];
		$sal=$_POST['txtBsalary'];
		//$type=$_POST['Tselect'];
		$sq = mysqli_query($con,"UPDATE empinfo SET EmpName='$nm', EmpJoinDate= '$jnDate', EmpFixedsalary= '$sal' WHERE EmpID = '$eid' ")or die(mysqli_query());
		//echo $nm ." successfully added.";
		echo '<script type="text/javascript">alert("'. $name1 .' Successfully Updated");</script>';

		header("Location: ../addws.php");
		exit;
	}
?>
<head>
			<title>Edit ws</title>
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
						<center> <caption> <h2>Edit Whole Seller</h2></caption> </center>
						
				<div  style="border: solid black 0px; ">
						
							<form name="f1" action="" method="POST">
									<table cellpadding="0" cellspacing="0" border="0" class="table" id="HeadTable" >
												<tr>
												<td style="text-align: right;" >
														ID:
													</td>
													<td style="text-align: left;" >
													<input type="text" name="txtID" id="iBox" value="<?php echo $eid; ?>" disabled>
													</td>
												</tr>
												<!--
												<tr>
												
												<td style="text-align: right;"> Type: </td>
													<td style="text-align: left;" >
															<select name="Tselect" id="sBox">
																	<option >---</option>
																	<?php
																		$doQ=mysqli_query($con,"SELECT abbvr from abbvr WHERE type='Sk' ");
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
												-->
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
														<input type="submit"  value="Update" name="Update" id="Btn">  <a href="../addws.php"><< back</a>
													</td>
												</tr>
									</table>
							</form>	
			</div>
			
	</div>
</html>
