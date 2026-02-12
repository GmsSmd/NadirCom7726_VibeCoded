<?php
include_once('../session.php');
$Employee = $_GET['name'];
include_once('includes/formula2.php');
include_once('includes/globalvar.php');
?>
	<head>
			<title>DO Dues</title>
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
								<caption> <h2>DO Dues</h2></caption>
							</center>
				<div style="border: solid black 0px;" align="center" class="doBar">
					<?php
						//$doQ=mysqli_query($con,"SELECT EmpName from empinfo ");
						//$doQ=mysqli_query($con,"SELECT EmpName from empinfo WHERE EmpStatus='Active' AND (empType='DO' OR empType='SP' OR empType='ws' OR empType='Acct') Order by sort_order ASC");
						$doQ=mysqli_query($con,"SELECT EmpName from empinfo WHERE (EmpStatus='Active' OR EmpStatus='Dfltr') AND (showIn=2 OR showIn=3) Order by sort_order ASC");
						while($data=mysqli_fetch_array($doQ))
							{
								$name=$data['EmpName'];
								if($name== $Employee)
									$nm='doLinkSelected';
								else
									$nm='doLink';
								?>
								<a href="dodues.php?name=<?php echo $name;?>" id="<?php echo $nm;?>" class="button">
								<?php
								echo $data['EmpName']."</a>";
							}
					?>
				</div>
				
							<div  style="border: solid black 0px; ">
											<form id="AddReceiptForm" name="AddReceiptForm" action="" method="POST">
													<table cellpadding="0" cellspacing="0" border="0" class="table" id="HeadTable" >
																<tr>												
																	<td style="text-align: right;">Date:</td>
																	<td style="text-align: left;">
																			<?php
																				$strDate= date('Y-m-d');
																				if ($currentUserType=="Admin")
																					echo "<input type=\"date\" value= \"$strDate\"  name=\"txtDate\" id=\"tBox\">";
																				else
																					echo "<input type=\"date\" value= \"$strDate\"  name=\"txtDate\" id=\"tBox\" readonly>";
																			?>
																	</td>
																	
																	<td style="text-align: right;">Mode:</td>
																	<td style="text-align: left;" >
																			<select name="modeSelect" id="sBox"/>
																				<option >---</option>
																				<option >Cash</option>
																				<?php
																					$doQ=mysqli_query($con,"SELECT Name from company WHERE Type='BNK' ");
																						while($data=mysqli_fetch_array($doQ))
																						{
																							//if ($data['Name']==$_POST['modeSelect'] )
																							if ($data['Name']==$defaultBankName)
																								echo "<option selected>";
																							else
																								echo "<option>";
																							echo $data['Name'];
																							echo "</option>";
																						}
																				?>
																			</select>	
																	</td>
																	
																</tr>
																
																<tr>
																	
																	<td style="text-align: right;" >
																	<?php
																	if($Employee=="DueSalary" OR $Employee=="DueProfit")
																		echo "Withdraw:";
																	else
																		echo "Pay To DO:";
																	
																	?>
																	
																	 
																	</td>
																	
																	<td style="text-align: left;" >
																		 <input type="text" name="txtAmntPaid" value="" id="iBox"/ autofocus> 
																	</td>
																	

																	<td style="text-align: right;" >Comments: 
																	</td>
																
																	<td style="text-align: left;" >
																		<input type="text" name="txtNotesP"  id="iBox"/> 
																		<input type="submit"  value="<?php if($Employee=="DueSalary" OR $Employee=="DueProfit") echo "Withdraw"; else echo "Pay";?>" name="SaveDuePaid" id="Btn">
																	</td>
																	
																</tr>
																
																<tr>
																	
																	<td style="text-align: right;" >
																	<?php
																	if($Employee=="DueSalary" OR $Employee=="DueProfit")
																		echo "Add Amount:";
																	else
																		echo "Receive From DO:";
																	
																	?>
																	 
																	</td>
																	
																	<td style="text-align: left;" >
																		 <input type="text" name="txtAmntReceived" value="" id="iBox"/> 
																	</td>
																	

																	<td style="text-align: right;" >Comments: 
																	</td>
																
																	<td style="text-align: left;" >
																		<input type="text" name="txtNotesR"  id="iBox"/> 
																		<input type="submit"  value="<?php if($Employee=="DueSalary" OR $Employee=="DueProfit") echo "Add Into"; else echo "Receive";?>" name="SaveDueReceived" id="Btn">
																	</td>
																	
																</tr>
																
																
																
																
													</table>
											</form>
													
							</div>
							<table cellpadding="0" cellspacing="0" border="1" class="table table-bordered table-condensed" id="dbResult">
								<thead>
									
									<tr>
										<th>Date</th>
										<th>Opening</th>
										<th><?php if($Employee=="DueSalary" OR $Employee=="DueProfit") echo "Withdraw"; else echo "Paid Amount";?></th>
										<th>Comments</th>
										<th><?php if($Employee=="DueSalary" OR $Employee=="DueProfit") echo "Added"; else echo "Received Amount";?></th>
										<th>Comments</th>
										<th>Closing</th>
									</tr>
								</thead>
											<tbody>
											<?php
													$sq5 = mysqli_query($con,"SELECT ocAmnt FROM openingclosing where oMonth='$CurrentMonth' AND ocType='DO Dues' AND ocEmp='$Employee'  ")or die(mysqli_query());
													$Data5=mysqli_fetch_array($sq5);
													
													$Opening=$Data5['ocAmnt'];
														
														for($i=$date_from; $i<=$date_to; $i+=86400)
														{
														echo "<tr>";
															$cd=date("Y-m-d", $i);
														echo "<td style=\"text-align: center;\">";
															echo date("d-M-Y", $i);
														echo "</td>";
														echo "<td>".$Opening."</td>";
															$q=mysqli_query($con,"SELECT sum(rpAmnt),rpNotes FROM receiptpayment WHERE rpFor='DO Dues' AND rpDate ='$cd' AND rpStatus='PaidTo' AND rpFromTo='$Employee' ");
															$Data=mysqli_fetch_array($q);
															$amntPaid=$Data['sum(rpAmnt)'];
														echo "<td>".$amntPaid."</td>";
														echo "<td>".$Data['rpNotes']."</td>";
														
															$q=mysqli_query($con,"SELECT sum(rpAmnt),rpNotes FROM receiptpayment WHERE rpFor='DO Dues' AND rpDate ='$cd' AND rpStatus='ReceivedFrom' AND rpFromTo='$Employee'  ");
															$Data=mysqli_fetch_array($q);
															$amntRcvd=$Data['sum(rpAmnt)'];
														echo "<td>".$amntRcvd."</td>";
														echo "<td>".$Data['rpNotes']."</td>";
															$closing= ($Opening+$amntPaid)-$amntRcvd;
														echo "<td>".$closing."</td>";
														
														
														$Opening=$closing;
														echo "</tr>";
													}
													?>
													
											</tbody>
											<tfoot >
								<tr style="border: solid black 2px;"  >
								<td colspan="3" > <b> TOTAL AMOUNT: </b></td>
								<td colspan="4" > <b><?php //echo $sum; ?></b></td>
								</tr>
								</tfoot>	
							</table>
	</div>
</html>