<?php
include_once('../session.php');
include_once('includes/globalvar.php');
?>

<head>
			<title>Closing</title>
			<style>
			<?php
			include_once('styles/navbarstyle.php');
			include_once('styles/tablestyle.php');
			include_once('includes/formula.php');
			?>
			</style>
	</head>
			
		<?php
			include_once('includes/navbar.php');
		?>

	<div class="container" align="center">
						<center> <caption> <h2>Opening & Closing</h2></caption> </center>
						
				<div  style="border: solid black 0px; ">
						
							<form name="f1" action="" method="POST">
									<table cellpadding="0" cellspacing="0" border="0" class="table" id="HeadTable" >
												<tr>
													<td style="text-align: right;">Closing Month</td>
													<td style="text-align: left;" >
																			<select name="cMonthSelect" id="sBox">
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
													<td style="text-align: right;">Opening Month</td>
													<td style="text-align: left;" >
																			<select name="oMonthSelect" id="sBox">
																				<?php
																				
																						$year  = date('Y');
																						$month = date('m');
																						$date = mktime( 0, 0, 0, $month, 1, $year );
																						echo "<option>". strftime( '%b-%Y', strtotime( '-2 month', $date ) ) ."</option>";
																						echo "<option>". strftime( '%b-%Y', strtotime( '-1 month', $date ) ) ."</option>";
																						echo "<option>". strftime( '%b-%Y', strtotime( '+0 month', $date ) ) ."</option>";
																						echo "<option selected>". strftime( '%b-%Y', strtotime( '+1 month', $date ) ) ."</option>";
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
																							echo "<option>";
																							echo $data['EmpName'];
																							//echo "<br>";
																							echo "</option>";
																						}
																				?>
																			</select>	
																	</td>
												</tr>
												
												<tr>
												<td style="text-align: right;" > 
														Otar target:
													</td>
													<td style="text-align: left;" >
													<input type="text" name="txtOtartgtAmnt" id="iBox">
													</td>
												<td style="text-align: right;" > 
														mfs target:
													</td>
													<td style="text-align: left;" >
													<input type="text" name="txtmfsTgtAmnt" id="iBox">
													</td>
												</tr>
												<tr>
												
												<td colspan="4" style="text-align: center;"> <h3> Other targets<h3></td>
												
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
																							echo "<option>";
																							echo $data['pName'];
																							echo "</option>";
																						}
																				?>
																			</select>	
																	</td>
													<td style="text-align: right;" > 
														target Amount:
													</td>
													<td style="text-align: left;" >
													<input type="text" name="txtOthertgtAmnt" id="iBox">
													</td>
													</tr>
													<tr>
													<td colspan="4" style="text-align: center;" > 
														<input type="submit"  value="Add target" name="addtarget" id="Btn">
													</td>
												</tr>
									</table>
							</form>
<br>
								
									
													<table cellpadding="0" cellspacing="0" border="1" class="" id="dbResult">
													<tr >
														<td colspan="6" > 
														<center>
														<h2> Employees Detail</h2>
														</center>
														</td>
													</tr>
													<tr style="background-color: #FFDAB9; font-weight: bold;" >
														<th>ID</th>
														<th>Month</th>
														<th>target Type</th>
														<th>Employee</th>
														<th>Amount</th>
														<th>Action</th>
													</tr>
												<?php
																							
													$sql = mysqli_query($con,"SELECT * FROM target")or die(mysqli_query());
														WHILE($Data=mysqli_fetch_array($sql))
															{ 
														$id = $Data['tgtID'];
															?>
															<tr>
																<td><?php echo $Data['tgtID']; ?></td>
																<td><?php echo $Data['tgtMonth']; ?></td>
																<td><?php echo $Data['tgtType']; ?></td>
																<td><?php echo $Data['tgtEmp']; ?></td>
																<td><?php echo $Data['tgtAmnt']; ?></td>
																
																<td>
																<a href="edit/edittarget.php?ID=<?php echo $id; ?>" id="LinkBtnEdit">Edit</a> &nbsp;&nbsp;&nbsp;&nbsp;
																<a href="delete/deltarget.php?ID=<?php echo $id; ?>" id="LinkBtnDel">Delete</a>
																</td>
															
															</tr>
															<?php 
															}
													?>
													</table>
													
							</div>
			
	</div>
</html>
