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
			<title>Paid Salary</title>
			<style>
			<?php
			include_once('../styles/navbarstyle.php');
			include_once('../styles/tablestyle.php');
			include_once('../includes/navbar.php');
			?>
			</style>
		</head>

		<div class="container" align="center">
						<center> <caption> <h1>Paid Salary</h1></caption> </center>
				
				<div>
				<table style="width:400px" cellpadding="0" cellspacing="0" border="1" class="" id="dbResult">
								<thead>
									<tr>
										<th style="text-align:center">Payment Head</th>
										<th  style="text-align:center">Amount</th>
									</tr>
								</thead>
											<tbody>
													<?php 
															$sql = mysqli_query($con,"SELECT * FROM salary WHERE id=$uid")or die(mysqli_query());
															WHILE($Data=mysqli_fetch_array($sql))
															{
																		$id = $Data['id'];
																?>
																	
																	<tr><td>Employee Name:</td><td><?php echo $Data['empName']; ?></td></tr>
																	<tr><td>Salary Month</td><td><?php echo $Data['salMonth']; ?></td></tr>
																	<tr><td>Basic Salary</td><td><?php echo $Data['bSal']; ?></td></tr>
																	<tr><td>Otar Comission</td><td><?php echo $Data['otarCom']; ?></td></tr>
																	<tr><td>MFS Comission</td><td><?php echo $Data['mfsCom']; ?></td></tr>
																	<tr><td>Market SIM Comission</td><td><?php echo $Data['marketSimCom']; ?></td></tr>
																	<tr><td>Activity SIM Comission</td><td><?php echo $Data['activitySimCom']; ?></td></tr>
																	<tr><td>Dev.Set Comission</td><td><?php echo $Data['deviceHandsetCom']; ?></td></tr>
																	<tr><td>Postpaid Comission</td><td><?php echo $Data['postpaidCom']; ?></td></tr>
																	<tr><td>Other Comission</td><td><?php echo $Data['otherCom']; ?></td></tr>
																	<tr><td>Deduction</td><td style="color: red;"><strong><?php echo $Data['cutting']; ?></strong></td></tr>
																	<tr><td>Net Salary</td><td><?php echo $Data['netSal']; ?></td></tr>
																	<tr><td>Status</td><td><?php echo $Data['status']; ?></td></tr>
																	<tr><td colspan="2" style="text-align:center"><a href='../paysalary.php' id="LinkBtnEdit">Go Back</a></td></tr>
																<?php
															}
																?>
													
											</tbody>
											
							</table>
				</div>
			
	</div>