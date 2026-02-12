<?php
include_once('../../session.php');
include_once('../includes/globalvar.php');
include_once('../includes/variables.php');
echo "<br/><br/><br/>";
$uid = $_GET['ID'];
$sqls = mysqli_query($con,"SELECT * FROM salary WHERE id=$uid")or die(mysqli_query());
$collection=mysqli_fetch_assoc($sqls);
$nameToUse=$collection['empName'];
$netSalToPay=$collection['netSal'];
?>
		<head>
			<title>Receipt Number</title>
			<style>
			<?php
			include_once('../styles/navbarstyle.php');
			include_once('../styles/tablestyle.php');
			include_once('../includes/navbar.php');
			?>
			</style>
		</head>

		<div class="container" align="center">
						<center> <caption> <h1>Salary Details</h1></caption> </center>
				<div  style="border: solid black 0px; ">
						
							<form name="f1" action="paysalary.php" method="POST">
									<table cellpadding="0" cellspacing="0" border="0" class="table" id="HeadTable" >
												<tr>
													<td style="text-align: right;" >ID:
													</td>
													<td style="text-align: left;" >
													<input type="text" name="txtID" id="iBox" value="<?php echo $uid?>" style="background-color: #f0f0f0; color:red; " readonly>
													</td>
												</tr>
												<tr>
													<td style="text-align: right;" >Employee Name:
													</td>
													<td style="text-align: left;" >
													<input type="text" name="txtName" id="iBox" value="<?php echo $nameToUse?>" style="background-color: #f0f0f0; color:red; " readonly>
													</td>
												</tr>
												<tr>
													<td style="text-align: right;" >Total Salary:
													</td>
													<td style="text-align: left;" >
													<input type="text" name="txtTotSal" id="iBox" value="<?php echo $netSalToPay?>" style="background-color: #f0f0f0; color: red " readonly>
													</td>
												</tr>
												<tr>
													<td style="text-align: right;" >Receipt Number:
													</td>
													<td style="text-align: left;" >
													<input type="text" name="txtRcptNum" id="iBox" required>
													</td>
												</tr>
												<tr>
												<td style="text-align: right;"> Payment Date:</td>
													<td style="text-align: left;">
															<?php
																$Coma='"';
																$strDate= date('Y-m-d');
																echo "<input type=\"date\" value= \"$strDate\"  name=\"txtDate\" id=\"tBox\" >";
															?>
													</td>
												</tr>
												<tr>
												<td></td>
													<td colspan="" style="text-align: Left;" > 
														<input type="submit"  value="Pay Now" name="PaySalary" id="Btn">
														<a href='../paysalary.php' id="LinkBtnDel">Cancel</a>												</td>
												</tr>
									</table>
							</form>
					<br>
				</div>
				<div>
				<table cellpadding="0" cellspacing="0" border="1" class="" id="dbResult">
								<thead>
									
									<tr>
										<th rowspan="2">ID</th>
										<th rowspan="2">Month</th>
										<th rowspan="2">Employee</th>
										<th rowspan="2">Basic Salary</th>
										<th colspan="7" style="text-align: Center;" > <h2> Comission</h2> </th>
										<th rowspan="2">Gross Salary</th>
										<th rowspan="2">Advance</th>
										<th rowspan="2">Cutting</th>
										<th rowspan="2">Net Sal</th>
										<th rowspan="2">Status</th>
									</tr>
									<tr>
										<th>Otar</th>
										<th>MFS</th>
										<th>Market SIM</th>
										<th>Activity SIM</th>
										<th>Dev+Set</th>
										<th>PostPaid</th>
										<th>Other</th>
									</tr>
								</thead>
											<tbody>
													<?php 
															$sql = mysqli_query($con,"SELECT * FROM salary WHERE id=$uid")or die(mysqli_query());
															WHILE($Data=mysqli_fetch_array($sql))
															{
																		$id = $Data['id'];
																?>
																	
																	<tr>
																		<td><?php echo $Data['id']; ?></td>
																		<td><?php echo $Data['salMonth']; ?></td>
																		<td><?php echo $Data['empName']; ?></td>
																		<td><?php echo $Data['bSal']; ?></td>
																		<td><?php echo $Data['otarCom']; ?></td>
																		<td><?php echo $Data['mfsCom']; ?></td>
																		<td><?php echo $Data['marketSimCom']; ?></td>
																		<td><?php echo $Data['activitySimCom']; ?></td>
																		<td><?php echo $Data['deviceHandsetCom']; ?></td>
																		<td><?php echo $Data['postpaidCom']; ?></td>
																		<td><?php echo $Data['otherCom']; ?></td>
																		<td><?php echo $Data['grossSal']; ?></td>
																		<td><?php echo $Data['advance']; ?></td>
																		<td><?php echo $Data['cutting']; ?></td>
																		<td><?php echo $Data['netSal']; ?></td>
																		<td><?php echo $Data['status']; ?></td>
																		</tr>
																<?php
															}
																?>
													
											</tbody>
											
							</table>
				</div>
			
	</div>