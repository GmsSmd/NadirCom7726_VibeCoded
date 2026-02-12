<?php
include_once('../session.php');
$Employee = $_GET['name'];

include_once('includes/formula.php');
include_once('includes/globalvar.php');
?>


<head>
			<title>summary</title>
				<style>
				<?php
				include_once('styles/navbarstyle.php');
				include_once('styles/tablestyle.php');
				include_once('includes/navbar.php');
				?>
				</style>
			</head>
			
	<div class="container" align="center">
			
							<center>
								<caption> <h2>receipts & payments summary</h2></caption>
							</center>
			<div style="border: solid black 0px;" align="center" class="doBar">
					<?php
						$doQ=mysqli_query($con,"SELECT EmpName from empinfo ");
						while($data=mysqli_fetch_array($doQ))
							{
								$name=$data['EmpName'];
								if($name== $Employee)
									$nm='doLinkSelected';
								else
									$nm='doLink';
								?>
								<a href="rpsummary.php?name=<?php echo $name;?>" id="<?php echo $nm;?>" class="button">
								<?php
								echo $data['EmpName']."</a>";
							}
					?>
			</div>
							
							
							
							
							
							
							<div  style="border: dashed blue 0px; ">
											<form id="AddReceiptForm" name="AddReceiptForm" action="" method="POST">
													
													
													
													<table cellpadding="0" cellspacing="0" border="0" class="table" id="headTable" >
																<tr>
																	<td style="text-align: right;"> Date From:</td>
																	<td style="text-align: left;">
																			<?php
																				$strDate=$QueryFD;
																				
																				//$strDate= date('Y-m-d');
																				echo "<input type=\"date\" value= \"$strDate\"  name=\"txtDateFrom\" id=\"tBox\">";
																			?>
																	</td>
																	<td style="text-align: right;"> Date To:</td>
																	<td style="text-align: left;">
																			<?php
																				$strDate= date('Y-m-d');
																				echo "<input type=\"date\" value= \"$strDate\"  name=\"txtDateTo\" id=\"tBox\">";
																			?>
																	</td>
																</tr>
																
																<tr>
																	<td style="text-align: right;"> Received From:  </td>
																		
																	<td style="text-align: left;" >
																			<select name="empSelect" id="sBox"/>
																				<option >---</option>
																				<?php
																					$doQ=mysqli_query($con,"SELECT EmpName from empinfo");
																						while($data=mysqli_fetch_array($doQ))
																						{
																							if ( $_POST['empSelect'] == $data['EmpName'])
																								echo "<option selected>";
																							else
																								echo "<option>";
																							echo $data['EmpName'];
																							echo "<br>";
																							echo "</option>";
																						}
																				?>
																			</select>	
																	</td>
																	<td style="text-align: Right;"> Sorted By:</td>
																	<td>
																		<select name="orderBySelect" id="sBox"/>
																				<option select>Date</option>
																				<option >Received From</option>
																				<option >Amount</option>
																		</select>	
																	</td>
																</tr>
																<tr>
																
																	<td colspan="4" style="text-align: center;" >
										 								<input type="submit"  value="Show" name="ShowRP" id="Btn">
																	</td>
																	
																</tr>
																
													</table>
											</form>
													
							</div>
							
			<table cellpadding="0" cellspacing="0" border="1" class="" id="dbResult">
				<tr>
					<td style="text-align: Center;">	
							<table cellpadding="0" cellspacing="0" border="1" class="" id="dbResult">
							<h2> receipts</h2>
								<thead>
									<tr>
										<th>ID</th>
										<th>Date</th>
										<th>Received From</th>
										<th>Amount</th>
										<th>Transaction Mode</th>
										<th>Received By</th>
										<th>Notes</th>
										<th>Action</th>
									</tr>
								</thead>
											<tbody>
													<?php 
												
													if($summaryFlag==0)
													$receiptsummary ="SELECT * FROM receiptpayment WHERE rpStatus= \"ReceivedFrom\" AND rpDate=\"$dateNow\" ";
													
													global $receiptsummary;
													$sum=0;
													$sql = mysqli_query($con,"$receiptsummary")or die(mysqli_query());
														WHILE($Data=mysqli_fetch_array($sql))
													{ 
												
															$rpID = $Data['rpID'];
															$Dat=$Data['rpDate'];
															$fromTo= $Data['rpFromTo'];
															$Amnt= $Data['rpAmnt'];
															$mode= $Data['rpmode'];
															$User= $Data['rpUser'];
															$notes = $Data['rpNotes'];
															
															$sum=$sum + $Amnt;
															
														$id = $Data['rpID'];
													?>
														
														<tr>
														
															<td><?php echo $rpID; ?></td>
															<td><?php echo $Dat; ?></td>
															<td><?php echo $fromTo; ?></td>
															<td><?php echo $Amnt; ?></td>
															<td><?php echo $mode; ?></td>
															<td><?php echo $User; ?></td>
															<td><?php echo $notes; ?></td>
														
															<td><a href="delete/delreceiptsummary.php?ID=<?php echo $id; ?>" id="LinkBtnDel">Delete</a></td>
															
															
														</tr>
													<?php 
													}
																?>
													
											</tbody>
								<tfoot >
								<tr style="border: solid black 2px;"  >
								<td colspan="3" > <b> TOTAL AMOUNT: </b></td>
								<td colspan="5" > <b><?php echo $sum; ?></b></td>
								</tr>
								</tfoot>
							</table>
					</td>	
					<td style="text-align: center;">
						
						
							<table cellpadding="0" cellspacing="0" border="1" class="" id="dbResult">
								<h2> payments</h2>
									<thead>
										<tr>
											<th>ID</th>
											<th>Date</th>
											<th>Received From</th>
											<th>Amount</th>
											<th>Transaction Mode</th>
											<th>Received By</th>
											<th>Notes</th>
											<th>Action</th>
										</tr>
									</thead>
												<tbody>
														<?php 
													
													
														if($summaryFlag==0)
															
														$paidsummary ="SELECT * FROM receiptpayment WHERE rpStatus= \"PaidTO\" AND rpDate=\"$dateNow\" ";
														
														global $paidsummary;
														$sum=0;
														$sq = mysqli_query($con,"$paidsummary")or die(mysqli_query());
															WHILE($Dat=mysqli_fetch_array($sq))
														{ 
													
																$rpID = $Dat['rpID'];
																$Dat1=$Dat['rpDate'];
																$fromTo= $Dat['rpFromTo'];
																$Amnt= $Dat['rpAmnt'];
																$mode= $Dat['rpmode'];
																$User= $Dat['rpUser'];
																$notes = $Dat['rpNotes'];
																
																$sum=$sum + $Amnt;
																
															$id1 = $Dat['rpID'];
														?>
															
															<tr>
															
																<td><?php echo $rpID; ?></td>
																<td><?php echo $Dat1; ?></td>
																<td><?php echo $fromTo; ?></td>
																<td><?php echo $Amnt; ?></td>
																<td><?php echo $mode; ?></td>
																<td><?php echo $User; ?></td>
																<td><?php echo $notes; ?></td>
															
																<td><a href="delete/delreceiptsummary.php?ID=<?php echo $id1; ?>" id="LinkBtnDel">Delete</a></td>
																
																
															</tr>
														<?php 
														}
																	?>
														
												</tbody>
									<tfoot >
									<tr style="border: solid black 2px;"  >
									<td colspan="3" > <b> TOTAL AMOUNT: </b></td>
									<td colspan="5" > <b><?php echo $sum; ?></b></td>
									</tr>
									</tfoot>
								</table>
					</td>
				</tr>
			</table>
			
	</div>
</html>