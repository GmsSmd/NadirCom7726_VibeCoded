<?php
include_once('../session.php');
$Employee = $_GET['name'];
include_once('includes/formula.php');
include_once('includes/globalvar.php');
?>

<head>
			<title>payments</title>
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
								<caption> <h2>Today's payments</h2></caption>
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
								<a href="payments.php?name=<?php echo $name;?>" id="<?php echo $nm;?>" class="button">
								<?php
								echo $data['EmpName']."</a>";
							}
					?>
				</div>
	
	
	
							<div  style="border: solid black 0px; ">
											<form id="AddReceiptForm" name="AddReceiptForm" action="" method="POST">
													<table cellpadding="0" cellspacing="0" border="0" class="table" id="Headtable" >
																<tr>
																	<td style="text-align: right;"> Payment Date:</td>
																	<td style="text-align: left;">
																			<?php
																				$strDate= date('Y-m-d');
																				echo "<input type=\"date\" value= \"$strDate\"  name=\"txtDate\" id=\"tBox\">";
																			?>
																	</td>
																	<td style="text-align: right;"> Payment For:  </td>
																	<td style="text-align: left;" >
																			<select name="pfSelect" id="sBox"/>
																				<option >---</option>
																				<?php
																					$doQ=mysqli_query($con,"SELECT abbvr from abbvr WHERE type='Mix' OR type='Pro' ");
																						while($data=mysqli_fetch_array($doQ))
																						{
																							
																							if ($data['abbvr']==$_POST['rfSelect'] )
																								echo "<option selected>";
																							else
																								echo "<option>";
																							echo $data['abbvr'];
																							echo "</option>";
																						}
																				?>
																				<option selected>DO Dues</option>
																				<option >Withdraw</option>
																			</select>	
																	</td>
																	
																</tr>
																
																<tr>
																	<td style="text-align: right;"> Payment Mode:  </td>
																	<td style="text-align: left;" >
																			<select name="modeSelect" id="sBox"/>
																				<option >---</option>
																				<option >Cash</option>
																				<?php
																					$doQ=mysqli_query($con,"SELECT Name from company WHERE Type='BNK' ");
																						while($data=mysqli_fetch_array($doQ))
																						{
																							//if ($data['Name']==$_POST['modeSelect'] )
																							if ($data['Name']==$defaultBankName )
																								echo "<option selected>";
																							else
																								echo "<option>";
																							echo $data['Name'];
																							echo "</option>";
																						}
																				?>
																			</select>	
																	</td>
																	
																	
																	<td style="text-align: right;" >Amount Paid: 
																	</td>
																	
																	<td style="text-align: left;" >
																		 <input type="text" name="txtAmntPaid" value="<?php   //global $tmptxtAmntPaid; echo $tmptxtAmntPaid; ?>" id="iBox"/> 
																	</td>
																	
																</tr>
																
																<tr>
																	<td style="text-align: right;" >Payment Notes: 
																	</td>
																
																	<td style="text-align: left;" >
																		<input type="text" name="txtNotes" id="iBox"/> 
																	</td>
																	<td style="text-align: right;" >
										 								<input type="submit"  value="Save" name="SavePayment" id="Btn" onclick="checkInput()">
																	</td>
																	<td style="text-align: left;" >
																		<input type="submit" value="Reset" name="ResetPayment" id="Btn">
																	</td>
																</tr>
																
													</table>
											</form>
													
							</div>
							<table cellpadding="0" cellspacing="0" border="1" class="table table-bordered table-condensed" id="dbResult">
								<thead>
									<tr>
										<th>ID</th>
										<th>Date</th>
										<th>Paid For</th>
										<th>Amount</th>
										<th>Transaction Mode</th>
										<th>Paid By</th>
										<th>Notes</th>
										<th>Action</th>
									</tr>
								</thead>
											<tbody>
													<?php 
													global $dateNow;
													$status="PaidTo";
													$sum=0;
													$sql = mysqli_query($con,"SELECT * FROM receiptpayment where rpDate=\"$dateNow\" AND rpStatus=\"$status\" AND rpFromTo='$Employee'  ")or die(mysqli_query());
														WHILE($Data=mysqli_fetch_array($sql))
													{ 
												
															$rpID = $Data['rpID'];
															$Dat=$Data['rpDate'];
															$for= $Data['rpFor'];
															$Amnt= $Data['rpAmnt'];
															$mode= $Data['rpMode'];
															$User= $Data['rpUser'];
															$notes = $Data['rpNotes'];
															$sum=$sum + $Amnt;
														$id = $Data['rpID'];
													?>
														
														<tr>
															<td><?php echo $rpID; ?></td>
															<td><?php echo $Dat; ?></td>
															<td><?php echo $for; ?></td>
															<td><?php echo $Amnt; ?></td>
															<td><?php echo $mode; ?></td>
															<td><?php echo $User; ?></td>
															<td><?php echo $notes; ?></td>
															<td><a href="delete/delpayment.php?ID=<?php echo $id;?>&name=<?php echo $Employee;?>" id="LinkBtnDel">Delete</a></td>
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
	</div>
</html>