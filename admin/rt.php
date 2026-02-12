<?php
include_once('../session.php');
include_once('includes/rtformula.php');
include_once('includes/globalvar.php');
?>
	<head>
			<title>Retailer MFS</title>
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

	<div class="container" align="center">
							<center>
								<caption> <h2>Send MFS to Retailer</h2></caption>
							</center>
							
							<div  style="border: solid black 0px; ">
											<form id="" name="" action="" method="POST">
													<table cellpadding="0" cellspacing="0" border="0" class="table" id="HeadTable" >
																<tr>
																	<td colspan="2" style="text-align: center;" >Date:
																	
																				<?php
																					$strDate= date('Y-m-d');
																					echo "<input type=\"date\" value= \"$strDate\"  name=\"txtDate\" id=\"tBox\">";
																				?>
																	</td>
																</tr>
																<tr>
																	<td style="text-align: right;" >Retailer Number: 
																	 <input type="text" name="txtrtnumber" value="<?php if (isset($_POST['getdo'])){echo $_POST['txtrtnumber'];} ?>" id="iBox"/ autofocus> 
																	</td>
																	<td style="text-align: left;"> D.O Name:
																			<input type="text" name="emp" value="<?php if (isset($_POST['getdo'])){echo $doName;} ?>" id="iBox" readonly /> 
																			<input type="submit"  value="Get DO" name="getdo" id="Btn">
																	</td>
																</tr>
																<tr>
																	<td style="text-align: right;" >Amount To Send:
																		 <input type="text" name="txtAmntSend" value="" id="iBox"/>
																	</td>
																	<td style="text-align: left;" >Comments:
																		 <input type="text" name="txtComments1" value="" id="iBox"/> 
																		  <input type="submit"  value="Send MFS" name="SavertmfsSent" id="Btn">
																	</td>
																</tr>
																<tr>
																	<td style="text-align: right;" >Amount Received:
																		 <input type="text" name="txtAmntReceived" value="" id="iBox"/>
																	</td>
																	<td style="text-align: left;" >Comments:
																		 <input type="text" name="txtComments2" value="" id="iBox"/> 
																		  <input type="submit"  value="Receive MFS" name="SavertmfsReceive" id="Btn">
																	</td>
																</tr>
											</form>
													
							</div>
							<table cellpadding="0" cellspacing="0" border="1" class="table table-bordered table-condensed" id="dbResult">
								<thead>
									<tr>
										<th>ID</th>
										<th>DO</th>
										<th>Status</th>
										<th>Amount</th>
										<th>Comments</th>
										<th>Action</th>
								</thead>
											<tbody>
													<?php 
													$dateNow1=date('Y-m-d');
													global $doName;
													$sum=0;
													$sql = mysqli_query($con,"SELECT * FROM tbl_financial_service WHERE mfsEmp='$doName' AND mfsDate='$dateNow1'  ")or die(mysqli_query());
													WHILE($Data=mysqli_fetch_array($sql))
													{
															$ID = $Data['mfsID'];
															$Name= $Data['mfsEmp'];
															$status= $Data['mfsStatus'];
															$Amnt= $Data['mfsAmnt'];
															$Cmnt=$Data['mfsComments'];
															$sum=$sum+$Amnt;
													$id = $Data['mfsID'];
													?>
														
														<tr>
															<td><?php echo $ID; ?></td>
															<td><?php echo $Name; ?></td>
															<td><?php echo $status; ?></td>
															<td><?php echo $Amnt; ?></td>
															<td><?php echo $Cmnt; ?></td>
														
															<td>
															<a href="delete/delrt.php?ID=<?php echo $id; ?>" id="LinkBtnDel">Delete</a>
															</td>
														
														</tr>
													<?php 
													}
													?>
													
											</tbody>
								<!--
											<tfoot >
								<tr style="border: solid black 2px;"  >
								<td colspan="3" > <b> TOTAL AMOUNT: </b></td>
								<td colspan="3" > <b><?php echo $sum; ?></b></td>
								</tr>
								</tfoot>
										-->	
							</table>
	</div>
</html>