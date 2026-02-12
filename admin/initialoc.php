<?php
include_once('../session.php');
$Employee = $_GET['name'];
include_once('includes/formula2.php');
include_once('includes/globalvar.php');
?>
	<head>
			<title>OC Initial</title>
			<style>
			<?php
			include_once('styles/navbarstyle.php');
			include_once('styles/tablestyle.php');
			include_once('includes/navbar.php');

			?>
			</style>
	</head>

	<div class="container" align="center" style="border: solid black 0px;" >
							<center>
								<caption> <h2>Initial Opening Closing</h2></caption>
							</center>
				<div style="border: solid black 0px;" align="center" class="doBar">
					<?php
						$name=array();
						$count=0;
					
						$doQ=mysqli_query($con,"SELECT EmpName from empinfo WHERE EmpStatus='Active' AND (empType='DO' OR empType='SP' OR empType='ws') Order by sort_order ASC");
						while($data=mysqli_fetch_array($doQ))
							{
								$name[$count]=$data['EmpName'];
								$count=$count+1;
							}
					
						$doQ=mysqli_query($con,"SELECT Name from company");
						while($data=mysqli_fetch_array($doQ))
							{
								$name[$count]=$data['Name'];
								$count=$count+1;
							}
					
							
							
						foreach ($name AS $nam)
							{
								if($nam== $Employee)
									$nm='doLinkSelected';
								else
									$nm='doLink';
								?>
								<a href="initialoc.php?name=<?php echo $nam;?>" id="<?php echo $nm;?>" class="button">
								<?php
								echo $nam."</a>";
							}
					?>
				</div>
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
												<td style="text-align: right;">Type: </td>
																	<td style="text-align: left;" >
																			<select name="ocSelect" id="sBox">
																				<option >---</option>
																				<option selected>Cash</option>
																				<option >DO Dues</option>
																				<?php
																					$doQ=mysqli_query($con,"SELECT pName from products");
																						while($data=mysqli_fetch_array($doQ))
																						{
																							//if ( $data['pName'] == 'Cash' )
																								//echo "<option selected>";
																							//else
																								echo "<option>";
																							echo $data['pName'];
																							echo "</option>";
																						}
																				?>
																			</select>	
																	</td>
													<td style="text-align: right;" > 
														Amount:
													</td>
													<td style="text-align: left;" >
													<input type="text" name="txtAmnt" id="iBox">
													</td>
													</tr>
													<tr>
													<td colspan="4" style="text-align: center;" > 
														<input type="submit"  value="Save" name="SaveOCinitial" id="Btn">
													</td>
												</tr>
									</table>
							</form>
<br>
								
									
													<table cellpadding="0" cellspacing="0" border="1" class="" id="dbResult">
													<tr >
														<td colspan="9" > 
														<center>
														<h2> Details </h2>
														</center>
														</td>
													</tr>
													<tr style="background-color: #FFDAB9; font-weight: bold;" >
														<th>ID</th>
														<th>Date</th>
														<th>Closing Month</th>
														<th>Opening Month</th>
														<th>Type</th>
														<th>Employee</th>
														<th>Amount</th>
														<th>Saved By</th>
														<th>Action</th>
													</tr>
												<?php
													$sql = mysqli_query($con,"SELECT * FROM openingclosing Where ocEmp='$Employee' ")or die(mysqli_query());
														WHILE($Data=mysqli_fetch_array($sql))
															{ 
														$id = $Data['ocID'];
															?>
															<tr>
																<td><?php echo $Data['ocID']; ?></td>
																<td><?php echo $Data['savingDateTime']; ?></td>
																<td><?php echo $Data['cMonth']; ?></td>
																<td><?php echo $Data['oMonth']; ?></td>
																<td><?php echo $Data['ocType']; ?></td>
																<td><?php echo $Data['ocEmp']; ?></td>
																<td><?php echo $Data['ocAmnt']; ?></td>
																<td><?php echo $Data['savedBy']; ?></td>
																<td><a href="delete/delocinitial.php?ID=<?php echo $id; ?>&name=<?php echo $Employee; ?>" id="LinkBtnDel">Delete</a></td>
																</td>
															
															</tr>
															<?php 
															}
													?>
													</table>
													
				</div>
	</div>
</html>