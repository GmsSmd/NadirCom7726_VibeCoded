<?php
include_once('../session.php');
//echo "<br><br><br><br><br>";
include_once('includes/dbcon.php');
include_once('includes/receiptformula.php');
include_once('includes/globalvar.php');

//$dateNow=date('Y-m-d');
?>
	<head>
			<title>Lifting</title>
			<style>
			<?php
			include_once('styles/navbarstyle.php');
			include_once('styles/tablestyle.php');
			?>
			</style>
	</head>
		<?php
			include_once('includes/navbar.php');
		?>
	<!-- <body onload="myFunction()"> -->

		<div class="container" align="center">
							<center>
								<caption> <h2>Purchases From <?php $parentCompany;?></h2></caption>
							</center>
							
		<div  style="border: solid black 0px; ">
			<table id="mainTable" border="0">
				<tr>
							<td style="text-align: center;" id="subHead">Purchase Otar</td>
							<td style="text-align: center;" id="subHead">Purchase MFS</td>
							
				</tr>
				<tr>
							<td>
									<form id="inputForm" name="AddLoadForm" action="" method="POST">
													<table cellpadding="0" cellspacing="0" border="0" class="table" id="HeadTable" >
																<tr>
																	<td style="text-align: right;">Lifting Date:</td>
																	<td style="text-align: left;">
																			<?php
																				$strDate= date('Y-m-d');
																				if ($currentUserType=="Admin")
																					echo "<input type=\"date\" value= \"$strDate\"  name=\"txtDate\" id=\"tBox\">";
																				else
																					echo "<input type=\"date\" value= \"$strDate\"  name=\"txtDate\" id=\"tBox\" readonly>";
    																		?>
																	</td>

																	<td style="text-align: right;" >Load Amount: 
																	</td>
																	
																	<td style="text-align: left;" >
																		 <input type="text" name="txtAmntReceived" value="<?php  /* global $tmptxtAmntReceived; echo $tmptxtAmntReceived;*/ ?>" id="iBox1"/> 
																	</td>
																</tr>
																<tr>	
																	<td style="text-align: right;" >Comments: 
																	</td>
																
																	<td style="text-align: left;" >
																		<input type="text" name="txtNotes"  id="iBox"/> 
																	</td>
																
																	<td colspan="6" style="text-align: Center;" >
										 								<input type="submit"  value="Cash" name="SaveSendliftingLoad" id="Btn">
										 								<input type="submit"  value="Debit MFS" name="LoadFromMfs" id="Btn">
																		<input type="submit"  value="Credit" name="SaveliftingLoad" id="Btn">
																		<!-- <input type="submit" value="Reset" name="Reset" id="Btn"> -->
																	</td>
																</tr>
																
													</table>
									</form>
											
							</td>
										
							<td>
									<form id="inputForm" name="AddmfsForm" action="" method="POST">
													<table cellpadding="0" cellspacing="0" border="0" class="table" id="HeadTable" >
																<tr>
																	<td style="text-align: right;"> Lifting Date:</td>
																	<td style="text-align: left;">
																			<?php
																				$strDate= date('Y-m-d');
																				if ($currentUserType=="Admin")
																					echo "<input type=\"date\" value= \"$strDate\"  name=\"txtDate\" id=\"tBox\">";
																				else
																					echo "<input type=\"date\" value= \"$strDate\"  name=\"txtDate\" id=\"tBox\" readonly>";
																			?>
																	</td>

																	<td style="text-align: right;" >MFS Amount: 
																	</td>
																	
																	<td style="text-align: left;" >
																		 <input type="text" name="txtAmntReceived" value="<?php /*  global $tmptxtAmntReceived; echo $tmptxtAmntReceived; */?>" id="iBox1"/> 
																	</td>
																</tr>
																<tr>	
																	<td style="text-align: right;" >Comments: 
																	</td>
																	<td style="text-align: left;" >
																		<input type="text" name="txtNotes"  id="iBox"/> 
																	</td>
																	<td colspan="6" style="text-align: center;" >
										 								<input type="submit"  value="Cash" name="SaveSendliftingmfs" id="Btn">
																		<input type="submit"  value="Credit" name="Saveliftingmfs" id="Btn">
																	</td>
																</tr>
																
													</table>
									</form>
										
							</td>
				</tr>
				<tr>
							<td>
							
									<table cellpadding="0" cellspacing="0" border="1" class="" id="dbResult">
										<thead>
											<tr>
												<th>ID</th>
												<th>Amount (Rs)</th>
												<th>Comments</th>
												<th>Type</th>
												<th>Action</th>
											</tr>
										</thead>
											<tbody>
													<?php 
													global $dateNow;
													$sum=0;
													$sql = mysqli_query($con,"SELECT * FROM tbl_mobile_load WHERE loadDate=\"$dateNow\" AND loadEmp='$parentCompany' ")or die(mysqli_query());
													
													WHILE($Data=mysqli_fetch_array($sql))
													{ 
															$rpID = $Data['loadID'];
															$Amnt= $Data['loadAmnt'];
															$notes = $Data['loadComments'];
															$sum=$sum+$Amnt;
														$id = $Data['loadID'];
													?>
														
														<tr>
															<td><?php echo $rpID; ?></td>
															<td><?php echo $Amnt; ?></td>
															<td><?php echo $notes; ?></td>
															<td><?php echo $Data['purchaseType'];?></td>
															<!-- <td><a href="delete/delotar.php?ID=<?php echo $id; ?>" id="LinkBtnDel">Delete</a></td> -->
															<td></td>
														</tr>
													<?php 
													}
													?>
													
											</tbody>
											<tfoot >
												<tr style="border: solid black 2px;"  >
												<td colspan="" > <b> TOTAL AMOUNT: </b></td>
												<td colspan="4" > <b><?php echo $sum; ?></b></td>
												</tr>
											</tfoot>
														
									</table>
							</td>
							<td>
							
									<table cellpadding="0" cellspacing="0" border="1" class="" id="dbResult">
												<thead>
													<tr>
														<th>ID</th>
														<th>Amount (Rs)</th>
														<th>Comments</th>
														<th>Type</th>
														<th>Action</th>
													</tr>
												</thead>
													<tbody>
															<?php 
															global $dateNow;
															$sum=0;
															$sql = mysqli_query($con,"SELECT * FROM tbl_financial_service WHERE mfsStatus='Received' AND mfsDate=\"$dateNow\" AND mfsEmp='$parentCompany' ")or die(mysqli_query());
															
															WHILE($Data=mysqli_fetch_array($sql))
															{ 
																	$rpID = $Data['mfsID'];
																	$Amnt= $Data['mfsAmnt'];
																	$notes = $Data['mfsComments'];
																	$sum=$sum+$Amnt;
																$id = $Data['mfsID'];
															?>
																
																<tr>
																	<td><?php echo $rpID; ?></td>
																	<td><?php echo $Amnt; ?></td>
																	<td><?php echo $notes; ?></td>
																	<td><?php echo $Data['purchaseType']; ?></td>
																	<!-- <td><a href="delete/delmfs.php?ID=<?php echo $id; ?>" id="LinkBtnDel">Delete</a></td> -->
																	<td></td>
																</tr>
														<?php
														}
														?>
													</tbody>
											<tfoot >
													<tr style="border: solid black 2px;"  >
													<td colspan="" > <b> TOTAL AMOUNT: </b></td>
													<td colspan="4" > <b><?php echo $sum; ?></b></td>
													</tr>
											</tfoot>
											
									</table>
							</td>
				</tr>
				<tr>
				
							<td style="text-align: center;"  id="subHead" ><br>Purchase Cards</td>
							<td style="text-align: center;" id="subHead">Debit MFS</td>
				</tr>
				<tr>
							<td>
									<form id="inputForm" name="AddCardForm" action="" method="POST">
													<table cellpadding="0" cellspacing="0" border="0" class="table" id="HeadTable" >
																<tr>
																	<td style="text-align: right;"> Purchase Date:</td>
																	<td style="text-align: left;">
																			<?php
																				$strDate= date('Y-m-d');
																				if ($currentUserType=="Admin")
																					echo "<input type=\"date\" value= \"$strDate\"  name=\"txtDate\" id=\"tBox\">";
																				else
																					echo "<input type=\"date\" value= \"$strDate\"  name=\"txtDate\" id=\"tBox\" readonly>";
																			?>
																	</td>
																	<td style="text-align: right;"> Card Type: </td>
																	<td style="text-align: left;" >
																			<select name="SubPselect" id="sBox1">
																				<!-- <option >---</option> -->
																				<?php
																					$doQ=mysqli_query($con,"SELECT typeName from types WHERE productName='Card' AND isActive=1");
																						while($data=mysqli_fetch_array($doQ))
																						{
																							echo "<option>";
																							echo $data['typeName'];
																							echo "<br>";
																							echo "</option>";
																						}
																				?>
																			</select>	
																	</td>
																	<td style="text-align: right;" >Card Quantity: 
																		</td>
																		<td style="text-align: left;" >
																			 <input type="text" name="txtAmntReceived" value="<?php  /* global $tmptxtAmntReceived; echo $tmptxtAmntReceived;*/ ?>" id="iBox1"/> 
																		</td>
																	</tr>
																<tr>
																	
																	<td style="text-align: right;" >Comments: 
																	</td>
																	<td colspan="2" style="text-align: left;" >
																		<input type="text" name="txtNotes"  id="iBox"/> 
																	</td>
																	<td colspan="3" style="text-align: center;" >
										 								<input type="submit"  value="Cash" name="SaveSendliftingCard" id="Btn">
																		<input type="submit"  value="Credit" name="SaveliftingCard" id="Btn">
																		<!--<input type="submit" value="Reset" name="Reset" id="Btn">-->
																	</td>
																</tr>
																
													</table>
									</form>
											
							</td>
							<td>
									<form id="inputForm" name="AddmfsForm" action="" method="POST">
													<table cellpadding="0" cellspacing="0" border="0" class="table" id="HeadTable" >
																<tr>
																	<td style="text-align: right;"> Debit Date:</td>
																	<td style="text-align: left;">
																			<?php
																				$strDate= date('Y-m-d');
																				if ($currentUserType=="Admin")
																					echo "<input type=\"date\" value= \"$strDate\"  name=\"txtDate\" id=\"tBox\">";
																				else
																					echo "<input type=\"date\" value= \"$strDate\"  name=\"txtDate\" id=\"tBox\" readonly>";
																			?>
																	</td>

																	<td style="text-align: right;" >MFS Amount: 
																	</td>
																	
																	<td style="text-align: left;" >
																		 <input type="text" name="txtAmntReceived" value="<?php /*  global $tmptxtAmntReceived; echo $tmptxtAmntReceived; */?>" id="iBox1"/> 
																	</td>
																</tr>
																<tr>	
																	<td style="text-align: right;" >Comments: 
																	</td>
																	<td style="text-align: left;" >
																		<input type="text" name="txtNotes"  id="iBox"/> 
																	</td>
																	<td colspan="6" style="text-align: center;" >
																		<input type="submit" value="Debit" name="DebitMFS" id="Btn">
																	</td>
																</tr>
																
													</table>
									</form>
										
							</td>
				</tr>
				<tr>
							<td>
							
									<table cellpadding="0" cellspacing="0" border="1" class="table table-bordered table-condensed" id="dbResult">
										<thead>
											<tr>
												<th>ID</th>
												<th>Card Type</th>
												<th>Card Qty</th>
												<th>Rate</th>
												<th>Comments</th>
												<th>Type</th>
												<th>Action</th>
											</tr>
										</thead>
											<tbody>
													<?php 
													global $dateNow;
													$sum=0;
													$sql = mysqli_query($con,"SELECT * FROM tbl_cards WHERE csDate=\"$dateNow\" AND csEmp='$parentCompany' ")or die(mysqli_query());
													
													WHILE($Data=mysqli_fetch_array($sql))
													{ 
															$rpID = $Data['csID'];
															$type=$Data['csType'];
															$qty= $Data['csQty'];
															$rt=$Data['csRate'];
															$notes = $Data['csComments'];
															$sum=$sum+$qty;
														$id = $Data['csID'];
													?>
														
														<tr>
															<td><?php echo $rpID; ?></td>
															<td><?php echo $type; ?></td>
															<td><?php echo $qty; ?></td>
															<td><?php echo $rt; ?></td>
															<td><?php echo $notes; ?></td>
															<td><?php echo $Data['purchaseType']; ?></td>
															<!-- <td><a href="delete/delcard.php?ID=<?php echo $id; ?>" id="LinkBtnDel">Delete</a></td> -->
															<td></td>
														</tr>
													<?php 
													}
													?>
													
											</tbody>
											<tfoot >
								<tr style="border: solid black 2px;"  >
								<td colspan="2" > <b> TOTAL QUANTITY: </b></td>
								<td colspan="5" > <b><?php echo $sum; ?></b></td>
								</tr>
								</tfoot>
											
							</table>
							</td>
							<td>
							
									<table cellpadding="0" cellspacing="0" border="1" class="" id="dbResult">
												<thead>
													<tr>
														<th>ID</th>
														<th>Amount (Rs)</th>
														<th>Comments</th>
														<th>Action</th>
													</tr>
												</thead>
													<tbody>
															<?php 
															global $dateNow;
															$sum=0;
															$sql = mysqli_query($con,"SELECT mfsID, mfsAmnt, mfsComments FROM tbl_financial_service WHERE mfsStatus='Sent' AND mfsDate=\"$dateNow\" AND mfsEmp='$parentCompany' ")or die(mysqli_query());
															
															WHILE($Data=mysqli_fetch_array($sql))
															{ 
																	$rpID = $Data['mfsID'];
																	$Amnt= $Data['mfsAmnt'];
																	$notes = $Data['mfsComments'];
																	$sum=$sum+$Amnt;
																$id = $Data['mfsID'];
															?>
																
																<tr>
																	<td><?php echo $rpID; ?></td>
																	<td><?php echo $Amnt; ?></td>
																	<td><?php echo $notes; ?></td>
																	<!-- <td><a href="delete/delmfs.php?ID=<?php echo $id; ?>" id="LinkBtnDel">Delete</a></td> -->
																	<td></td>
																</tr>
														<?php
														}
														?>
													</tbody>
											<tfoot >
													<tr style="border: solid black 2px;"  >
													<td colspan="" > <b> TOTAL AMOUNT: </b></td>
													<td colspan="3" > <b><?php echo $sum; ?></b></td>
													</tr>
											</tfoot>
											
									</table>
							</td>
				</tr>
				<tr>
							
							<td style="text-align: center;"  id="subHead" ><br>Purchase SIM</td>
							<td style="text-align: center;"  id="subHead" ><br>Purchase Mobile</td>
				</tr>
				<tr>
							<td>
									<form id="inputForm" name="AddSIMForm" action="" method="POST">
													<table cellpadding="0" cellspacing="0" border="0" class="table" id="HeadTable" >
																<tr>
																	<td style="text-align: right;"> Purchase Date:</td>
																	<td style="text-align: left;">
																			<?php
																				$strDate= date('Y-m-d');
																				if ($currentUserType=="Admin")
																					echo "<input type=\"date\" value= \"$strDate\"  name=\"txtDate\" id=\"tBox\">";
																				else
																					echo "<input type=\"date\" value= \"$strDate\"  name=\"txtDate\" id=\"tBox\" readonly>";
																			?>
																	</td>
																	<td style="text-align: right;"> SIM Type: </td>
																	<td style="text-align: left;" >
																			<select name="SubPselect" id="sBox1">
																				<option >---</option>
																				<?php
																					$doQ=mysqli_query($con,"SELECT typeName from types WHERE productName='SIM' AND isActive=1 ");
																						while($data=mysqli_fetch_array($doQ))
																						{
																							echo "<option>";
																							echo $data['typeName'];
																							echo "<br>";
																							echo "</option>";
																						}
																				?>
																			</select>	
																	</td>
																	<td style="text-align: right;" >SIM Quantity: 
																	</td>
																	<td style="text-align: left;" >
																		<input type="text" name="txtAmntReceived" value="<?php  /* global $tmptxtAmntReceived; echo $tmptxtAmntReceived; */?>" id="iBox1"/> 
																	</td>
																</tr>
																<tr>
																	<td style="text-align: right;" >Comments: 
																	</td>
																	<td colspan="2" style="text-align: left;" >
																		<input type="text" name="txtNotes"  id="iBox"/> 
																	</td>
																	<td colspan="3" style="text-align: center;" >
										 								<input type="submit"  value="Cash" name="SaveSendliftingSIM" id="Btn">
																		<input type="submit"  value="Credit" name="SaveliftingSIM" id="Btn">
																		<!--<input type="submit" value="Reset" name="Reset" id="Btn">-->
																	</td>
																</tr>
																
													</table>
									</form>
							</td>	
							<td>
									<form id="inputForm" name="AddPhonesForm" action="" method="POST">
													<table cellpadding="0" cellspacing="0" border="0" class="table" id="HeadTable" >
																<tr>
																	<td style="text-align: right;"> Purchase Date:</td>
																	<td style="text-align: left;">
																			<?php
																				$strDate= date('Y-m-d');
																				if ($currentUserType=="Admin")
																					echo "<input type=\"date\" value= \"$strDate\"  name=\"txtDate\" id=\"tBox\">";
																				else
																					echo "<input type=\"date\" value= \"$strDate\"  name=\"txtDate\" id=\"tBox\" readonly>";
																			?>
																	</td>
																	<td style="text-align: right;"> Phone Type: </td>
																	<td style="text-align: left;" >
																			<select name="SubPselect" id="sBox1">
																				<option >---</option>
																				<?php
																					$doQ=mysqli_query($con,"SELECT typeName from types WHERE productName='Mobile' AND isActive=1");
																						while($data=mysqli_fetch_array($doQ))
																						{
																							echo "<option>";
																							echo $data['typeName'];
																							echo "<br>";
																							echo "</option>";
																						}
																				?>
																			</select>	
																	</td>
																	<td style="text-align: right;" >Phone Quantity: 
																	</td>
																	<td style="text-align: left;" >
																		<input type="text" name="txtAmntReceived" value="<?php /*  global $tmptxtAmntReceived; echo $tmptxtAmntReceived; */?>" id="iBox1"/> 
																	</td>
																</tr>
																<tr>
																	<td style="text-align: right;" >Comments: 
																	</td>
																	<td colspan="2" style="text-align: left;" >
																		<input type="text" name="txtNotes"  id="iBox"/> 
																	</td>
																	<td colspan="3" style="text-align: center;" >
										 								<input type="submit"  value="Cash" name="SaveSendliftingPhone" id="Btn">
																		<input type="submit"  value="Credit" name="SaveliftingPhone" id="Btn">
																		<!--<input type="submit" value="Reset" name="Reset" id="Btn">-->
																	</td>
																</tr>
																
													</table>
									</form>
											
							</td>
							</tr>
							<tr>
							
							<td>
									<table cellpadding="0" cellspacing="0" border="1" class="" id="dbResult">
										<thead>
											<tr>
												<th>ID</th>
												<th>SIM Type</th>
												<th>SIM Qty</th>
												<th>Rate</th>
												<th>Comments</th>
												<th>Type</th>
												<th>Action</th>
											</tr>
										</thead>
											<tbody>
													<?php 
													global $dateNow;
													$sum=0;
													$sql = mysqli_query($con,"SELECT * FROM tbl_product_stock WHERE sDate=\"$dateNow\" AND pName='SIM' AND customer='$parentCompany' AND trtype='Received' ")or die(mysqli_query());
													
													WHILE($Data=mysqli_fetch_array($sql))
													{ 
															$rpID = $Data['sID'];
															$type=$Data['pSubType'];
															$qty= $Data['qty'];
															$rt=$Data['rate'];
															$notes = $Data['sComments'];
															$sum=$sum+$qty;
														$id = $Data['sID'];
													?>
														
														<tr>
															<td><?php echo $rpID; ?></td>
															<td><?php echo $type; ?></td>
															<td><?php echo $qty; ?></td>
															<td><?php echo $rt; ?></td>
															<td><?php echo $notes; ?></td>
															<td><?php echo $Data['purchaseType']; ?></td>
															<!-- <td><a href="delete/delsim.php?ID=<?php echo $id; ?>" id="LinkBtnDel">Delete</a></td> -->
															<td></td>
														</tr>
													<?php 
													}
													?>
													
											</tbody>
											<tfoot >
								<tr style="border: solid black 2px;"  >
								<td colspan="2" > <b> TOTAL QUANTITY: </b></td>
								<td colspan="5" > <b><?php echo $sum; ?></b></td>
								</tr>
								</tfoot>
											
							</table>
							</td>
							<td>
							
									<table cellpadding="0" cellspacing="0" border="1" class="table table-bordered table-condensed" id="dbResult">
												<thead>
											<tr>
												<th>ID</th>
												<th>Mobile Type</th>
												<th>Mobile Qty</th>
												<th>Rate</th>
												<th>Comments</th>
												<th>Type</th>
												<th>Action</th>
											</tr>
										</thead>
											<tbody>
													<?php 
													global $dateNow;
													$sum=0;
													$sql = mysqli_query($con,"SELECT * FROM tbl_product_stock WHERE sDate=\"$dateNow\" AND pName='Mobile' AND customer='$parentCompany' AND trtype='Received' ")or die(mysqli_query());
													
													WHILE($Data=mysqli_fetch_array($sql))
													{ 
															$rpID = $Data['sID'];
															$type=$Data['pSubType'];
															$qty= $Data['qty'];
															$rt=$Data['rate'];
															$notes = $Data['sComments'];
															$sum=$sum+$qty;
														$id = $Data['sID'];
													?>
														
														<tr>
															<td><?php echo $rpID; ?></td>
															<td><?php echo $type; ?></td>
															<td><?php echo $qty; ?></td>
															<td><?php echo $rt; ?></td>
															<td><?php echo $notes; ?></td>
															<td><?php echo $Data['purchaseType']; ?></td>
															<!-- <td><a href="delete/delmob.php?ID=<?php echo $id; ?>" id="LinkBtnDel">Delete</a></td> -->
															<td></td>
														</tr>
													<?php 
													}
													?>
													
											</tbody>
											<tfoot >
								<tr style="border: solid black 2px;"  >
								<td colspan="2" > <b> TOTAL QUANTITY: </b></td>
								<td colspan="5" > <b><?php echo $sum; ?></b></td>
								</tr>
								</tfoot>
											
							</table>
							</td>
				</tr>
			</table>						
		</div>	
<!-- </body>		
<script>
function myFunction()
	{
    document.getElementById("tBox1").readOnly = true;
	}
</script>
-->
</html>