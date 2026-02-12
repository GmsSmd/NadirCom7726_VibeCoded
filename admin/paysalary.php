<?php
include_once('../session.php');
$StartDate='';
$EndDate='';
include_once('includes/dbcon.php');
include_once('includes/variables.php');
include_once('includes/globalvar.php');

	//$salMonth=$_POST['salMonthSelect'];
	
	if (isset($_POST['Showsalary']))
		$salMonth=$_POST['salMonthSelect'];
	else
		$salMonth=$PreviousMonth;

		$Qury="SELECT * FROM salary WHERE salMonth='$salMonth'";
		//$Qury1="SELECT * FROM dueexp WHERE expMonth='$salMonth'";
		$Qury1="SELECT * FROM dueexp WHERE status='Pending'";
?>
<head>
			<title>Pay Sal+Exp</title>
			<style>
			<?php
			include_once('styles/navbarstyle.php');
			include_once('styles/tablestyle.php');
			include_once('includes/navbar.php');
			?>
			</style>
			</head>

			
	<div class="container" align="center" style="border: solid Red 0px;">	
							<center>
								<caption> <h2>Salary + Expenses Payment</h2></caption>
							</center>
			
							<div  style="border: solid black 0px; ">
											<form  action="" method="POST">
													<table cellpadding="0" cellspacing="0" border="0" class="table" id="headTable" >
														<tr>
																	<td style="text-align: Center;">
																		Salary Month:
																			<select name="salMonthSelect" id="sBox">
																					<?php
																						$year  = date('Y');
																						$month = date('m');
																						$date = mktime( 0, 0, 0, $month, 1, $year );
																						echo "<option>". strftime( '%b-%Y', strtotime( '-12 month', $date ) ) ."</option>";
																						echo "<option>". strftime( '%b-%Y', strtotime( '-11 month', $date ) ) ."</option>";
																						echo "<option>". strftime( '%b-%Y', strtotime( '-10 month', $date ) ) ."</option>";
																						echo "<option>". strftime( '%b-%Y', strtotime( '-9 month', $date ) ) ."</option>";
																						echo "<option>". strftime( '%b-%Y', strtotime( '-8 month', $date ) ) ."</option>";
																						echo "<option>". strftime( '%b-%Y', strtotime( '-7 month', $date ) ) ."</option>";
																						echo "<option>". strftime( '%b-%Y', strtotime( '-6 month', $date ) ) ."</option>";
																						echo "<option>". strftime( '%b-%Y', strtotime( '-5 month', $date ) ) ."</option>";
																						echo "<option>". strftime( '%b-%Y', strtotime( '-4 month', $date ) ) ."</option>";
																						echo "<option>". strftime( '%b-%Y', strtotime( '-3 month', $date ) ) ."</option>";
																						echo "<option>". strftime( '%b-%Y', strtotime( '-2 month', $date ) ) ."</option>";
																						echo "<option selected>". strftime( '%b-%Y', strtotime( '-1 month', $date ) ) ."</option>";
																						//echo "<option>". strftime( '%b-%Y', strtotime( '+0 month', $date ) ) ."</option>";
																						
																					?>
																			</select>	
																		Payment Date:
																			<?php
																			if (isset($_POST['Showsalary']))
																				$strDate1=$_POST['txtDate'];
																			else
																				$strDate1= date('Y-m-d');
																			
																			echo "<input type=\"date\" value= \"$strDate1\"  name=\"txtDate\" id=\"tBox\" >";
																			?>
										 								<input type="submit"  value="Show" name="Showsalary" id="Btn">
																	</td>
																</tr>
																
													</table>
											</form>
													
							</div>
							<table cellpadding="0" cellspacing="0" border="1" class="" id="dbResult">
								<thead>
									<tr style="border: solid black 2px;"  >
									<td colspan="17" style="text-align: Center;" > <h1> SALARY DETAILS </h1> </td>
									</tr>
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
										<th rowspan="2">Action</th>
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
													$AmntSum=0; $AmntPaid=0;
															$sql = mysqli_query($con,"$Qury")or die(mysqli_query());
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
																		
																<?php
																echo "<td>";
																if ($Data['status']=="Pending")
																	{
																		$dt1= date("d-m-Y", strtotime($strDate1));
																		$sal=$Data['netSal'];
																	echo "<a onClick=\"javascript: return confirm('Please confirm Payment');\" href='edit/getsalarybnkrcpt.php?ID=".$id."' id=\"LinkBtnEdit\">Pay Salary</a>"; //use double quotes for js inside php!
																	//echo "<td><a onClick=\"javascript: return confirm('Please confirm Payment');\" href='edit/getsalarybnkrcpt.php?ID=".$id."&dt=".$dt1."&sl=".$sal."' id=\"LinkBtnEdit\">Pay Now</a></td></tr>"; //use double quotes for js inside php!
																	}
																else
																{
																	//echo "</tr>";
																	$AmntPaid=$AmntPaid+$Data['netSal'];
																}
																$AmntSum=$AmntSum+$Data['netSal'];
																echo "<a href='edit/viewsalary.php?ID=".$id."'>View Salary</a></td></tr>"; //use double quotes for js inside php!	
															}
													?>
											</tbody>
											
											<tfoot >
								<tr style="border: solid black 2px;"  >
								<td colspan="3" style="text-align: Right;" > <b> TOTAL: </b></td>
								<td colspan="2" style="text-align: Left;" > <b><?php echo $AmntSum;?></b></td>
								<td colspan="3" style="text-align: Right;" > <b> PAID: </b></td>
								<td colspan="3" style="text-align: Left;" > <b><?php echo $AmntPaid;?></b></td>
								<td colspan="3" style="text-align: Right;" > <b> PENDING: </b></td>
								<td colspan="3" style="text-align: Left;" > <b><?php echo $AmntSum-$AmntPaid;?></b></td>
								</tr>
								</tfoot>
							
							</table>
					<br>
							<table cellpadding="0" cellspacing="0" border="1" class="" id="dbResult">
								<thead>
									<tr style="border: solid black 2px;"  >
									<td colspan="6" style="text-align: Center;" > <h2> EXPENSES DETAILS </h2> </td>
									</tr>
									<tr>
										<th>ID</th>
										<th>Month</th>
										<th>Description</th>
										<th>Amount</th>
										<th>Status</th>
										<th>Action</th>
									</tr>
								</thead>
											<tbody>
													<?php 
													$AmntSum2=0; $AmntPaid2=0;
															$sql2 = mysqli_query($con,"$Qury1")or die(mysqli_query());
															WHILE($Data2=mysqli_fetch_array($sql2))
															{
																		$id2 = $Data2['id'];
																?>
																	
																	<tr>
																		<td><?php echo $Data2['id']; ?></td>
																		<td><?php echo $Data2['expMonth']; ?></td>
																		<td><?php echo $Data2['description']; ?></td>
																		<td><?php echo $Data2['amnt']; ?></td>
																		<td><?php echo $Data2['status']; ?></td>
																		
																<?php
																if ($Data2['status']=="Pending")
																	{
																		$dt2= date("d-m-Y", strtotime($strDate1));
																		$amnt2=$Data2['amnt'];
																
																//echo '<td><a href=\"edit/payexp.php?ID='.$id2.'&dt='.$dt2.'&amnt='.$amnt2.'" id="LinkBtnEdit">Pay Now</a></td>';
																echo "<td><a onClick=\"javascript: return confirm('Please confirm Payment');\" href=\"edit/payexp.php?ID=".$id2."&dt=".$dt2."&amnt=".$amnt2."\" id=\"LinkBtnEdit\">Pay Now</a></td>";
																echo "</tr>";
																	}
																else
																{
																	echo "</tr>";
																	$AmntPaid2=$AmntPaid2+$Data2['amnt'];
																}
																$AmntSum2=$AmntSum2+$Data2['amnt'];
															}
													?>
											</tbody>
											
											<tfoot >
								<tr style="border: solid black 2px;"  >
								<td colspan="1" style="text-align: Right;" > <b> TOTAL: </b></td>
								<td colspan="1" style="text-align: Left;" > <b><?php echo $AmntSum2;?></b></td>
								<td colspan="1" style="text-align: Right;" > <b> PAID: </b></td>
								<td colspan="1" style="text-align: Left;" > <b><?php echo $AmntPaid2;?></b></td>
								<td colspan="1" style="text-align: Right;" > <b> PENDING: </b></td>
								<td colspan="1" style="text-align: Left;" > <b><?php echo $AmntSum2-$AmntPaid2;?></b></td>
								</tr>
								</tfoot>
							
							</table>
	</div>