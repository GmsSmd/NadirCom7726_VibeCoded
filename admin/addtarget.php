<?php
include_once('../session.php');
include_once('includes/globalvar.php');
	$Employee = $_GET['name'];	
	include_once('includes/formula.php');
?>

<head>
			<title>Add Target</title>
			<style>
				<?php
				include_once('styles/navbarstyle.php');
				include_once('styles/tablestyle.php');
				include_once('includes/navbar.php');
				?>
			</style>
</head>
		
		
		
	<div class="container" align="center">
						<center> <caption> <h2>Set Targets</h2></caption> </center>
				<div style="border: solid black 0px;" align="center" class="doBar">
						
					
					<?php
						$doQ=mysqli_query($con,"SELECT EmpName from empinfo WHERE EmpStatus='Active' AND (empType='DO' OR empType='SP' OR empType='ws') Order by sort_order ASC");
						while($data=mysqli_fetch_array($doQ))
							{
								$name=$data['EmpName'];
								if($name== $Employee)
									$nm='doLinkSelected';
								else
									$nm='doLink';
								?>
								<a href="addtarget.php?name=<?php echo $name;?>" id="<?php echo $nm;?>" class="button">
								<?php
								echo $data['EmpName']."</a>";
							}
						$doQ1=mysqli_query($con,"SELECT Name from company WHERE Name='Franchise' ");
						while($data=mysqli_fetch_array($doQ1))
							{
								$name=$data['Name'];
								if($name== $Employee)
									$nm='doLinkSelected';
								else
									$nm='doLink';
								?>
								<a href="addtarget.php?name=<?php echo $name;?>" id="<?php echo $nm;?>" class="button">
								<?php
								echo $data['Name']."</a>";
							}
					?>
							
							
				</div>


					
				<div  style="border: solid black 0px; ">
						
							<form name="f1" action="" method="POST">
									<table cellpadding="0" cellspacing="0" border="0" class="table" id="HeadTable" >
												<tr>
													<td style="text-align: right;">Target Month</td>
													<td style="text-align: left;" >
																			<select name="MonthSelect" id="sBox">
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
												
												<td style="text-align: right;" > 
														Otar Target:
													</td>
													<td style="text-align: left;" >
													<input type="text" name="txtOtartgtAmnt" id="iBox">
													</td>
												<td style="text-align: right;" > 
														MFS Target:
													</td>
													<td style="text-align: left;" >
													<input type="text" name="txtmfsTgtAmnt" id="iBox">
													</td>
												</tr>
												<tr>
												
												<td colspan="6" style="text-align: center;"> <h3> Other Targets<h3></td>
												
												</tr>
												
												<tr>
												<td></td>
																	<td style="text-align: right;"> Target Type: </td>
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
														Target Amount(Qty.):
													</td>
													<td style="text-align: left;" >
													<input type="text" name="txtOthertgtAmnt" id="iBox">
													</td>
													<td></td>
													</tr>
												<tr>
													<td colspan="6" style="text-align: center;" > 
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
														<th>Target Type</th>
														<th>Employee</th>
														<th>Amount</th>
														<th>Action</th>
													</tr>
												<?php
																							
													$sql = mysqli_query($con,"SELECT * FROM target WHERE tgtEmp='$Employee' AND tgtMonth='$CurrentMonth' ")or die(mysqli_query());
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
																<a href="edit/edittarget.php?ID=<?php echo $id;?>&name=<?php echo $Employee;?>" id="LinkBtnEdit">Edit</a> &nbsp;&nbsp;&nbsp;&nbsp;
																<a href="delete/deltarget.php?ID=<?php echo $id; ?>&name=<?php echo $Employee;?>" id="LinkBtnDel">Delete</a>
																</td>
															
															</tr>
															<?php 
															}
													?>
													</table>
													
							</div>
			
	</div>
</html>
