<?php
include_once('../includes/dbcon.php');
include_once('../includes/globalvar.php');

$id = $_GET['ID'];
$nm=$_GET['name'];
$edit = mysqli_query($con,"SELECT * FROM target WHERE tgtid = $id") or die(mysqli_error());
$data= mysqli_fetch_array($edit);
$tgtID=$data['tgtID'];
$tgtMonth=$data['tgtMonth'];
$tgtType=$data['tgtType'];
$tgtEmp=$data['tgtEmp'];
$tgtAmnt=$data['tgtAmnt'];

if (isset($_POST['Updatetarget']))
	{
	$month=$_POST['MonthSelect'];
	$type=$_POST['OthertgtSelect'];
	$emp=$_POST['EmpSelect'];
	$amnt=$_POST['txtOthertgtAmnt'];
	
	
	if ($emp== "---")
			{ echo '<script type="text/javascript">alert("Please Select a Name from \"target For\".");</script>'; }
	else if ($type== "")
			{ echo '<script type="text/javascript">alert("Please Sellect a type from \"target Type\".");</script>'; }
	else if ($amnt=="")
			{ echo '<script type="text/javascript">alert("Please enter target Amount.");</script>'; }
	else
	{
		$sq = mysqli_query($con,"UPDATE target SET tgtMonth='$month', tgtType='$type', tgtEmp='$emp',tgtAmnt=$amnt WHERE tgtID= $id")or die(mysqli_query());
		echo '<script type="text/javascript">alert("target Successfully Updated");</script>';
		header("Location: ../addtarget.php?name=$nm");
	}
	}
if (isset($_POST['Cancel']))
	header("Location: ../addtarget.php?name=$nm");


?>














<head>
			<title>Edit target</title>
			<style>
			<?php
			include_once('../styles/navbarstyle.php');
			include_once('../styles/tablestyle.php');
			//include_once('../includes/formula.php');
			?>
			</style>
	</head>
			
		<?php
			include_once('../includes/navbar.php');
		?>

	<div class="container" align="center">
						<center> <caption> <h2>Edit targets</h2></caption> </center>
						
				<div  style="border: solid black 0px; ">
						
							<form name="f1" action="" method="POST">
									<table cellpadding="0" cellspacing="0" border="0" class="table" id="HeadTable" >
												<tr>
													<td style="text-align: right;">target Month</td>
													<td style="text-align: left;" >
																			<select name="MonthSelect" id="sBox" readonly>
																				<?php
																				
																						$year  = date('Y');
																						$month = date('m');
																						$date = mktime( 0, 0, 0, $month, 1, $year );
																						echo "<option>". strftime( '%b-%Y', strtotime( '-2 month', $date ) ) ."</option>";
																						echo "<option>". strftime( '%b-%Y', strtotime( '-1 month', $date ) ) ."</option>";
																						echo "<option selected>". strftime( '%b-%Y', strtotime( '+0 month', $date ) ) ."</option>";
																						echo "<option>". strftime( '%b-%Y', strtotime( '+1 month', $date ) ) ."</option>";
																						echo "<option>". strftime( '%b-%Y', strtotime( '+2 month', $date ) ) ."</option>";
																						?>
																			</select>	
													</td>
												</tr>
												<tr>
													<td style="text-align: right;"> target For: </td>
																	<td style="text-align: left;" >
																			<select name="EmpSelect" id="sBox">
																				<option >---</option>
																				<?php
																					$doQ=mysqli_query($con,"SELECT EmpName from empinfo ");
																						while($data=mysqli_fetch_array($doQ))
																						{
																							if($tgtEmp==$data['EmpName'])
																								echo "<option selected>";
																							else
																								echo "<option>";
																							echo $data['EmpName'];
																							echo "</option>";
																						}
																				?>
																			</select>	
																	</td>
												</tr>
												<tr>
												
													
													
													<td style="text-align: right;"> target Type: </td>
																	<td style="text-align: left;" >
																			<select name="OthertgtSelect" id="sBox">
																				<option >---</option>
																				<?php
																					$doQ=mysqli_query($con,"SELECT pName from products");
																						while($data=mysqli_fetch_array($doQ))
																						{
																							if($tgtType==$data['pName'])
																								echo "<option selected>";
																							else
																								echo "<option>";
																							echo $data['pName'];
																							echo "</option>";
																						}
																				?>
																			</select>	
																	</td>
												</tr>
												<tr>
													<td style="text-align: right;" > 
														target Amount:
													</td>
													<td style="text-align: left;" >
													<input type="text" name="txtOthertgtAmnt" id="iBox" value="<?php echo $tgtAmnt; ?>">
													</td>
												</tr>
													<tr>
													<td colspan="2" style="text-align: center;" > 
														<input type="submit"  value="Update" name="Updatetarget" id="Btn">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
														<input type="submit" value="Cancel" name="Cancel" id="Btn">
													</td>
												</tr>
									</table>
							</form>

				</div>
			
	</div>
</html>
