<?php
include_once('../session.php');
//echo "<br><br><br><br><br>";
$Employee = $_GET['name'];
include_once('includes/receiptformula.php');
include_once('includes/globalvar.php');

?>

<head>
			<title>Payments</title>
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
								<caption> <h2>Today's Payments</h2></caption>
							</center>
	
				<div style="border: solid black 0px;" align="center" class="doBar">
					<?php
						$doQ=mysqli_query($con,"SELECT Name from company WHERE Name='$parentCompany' OR Name='Waseela' ");
						while($data=mysqli_fetch_array($doQ))
							{
								$name=$data['Name'];
								if($name== $Employee)
									$nm='doLinkSelected';
								else
									$nm='doLink';
								?>
								<a href="companypayment.php?name=<?php echo $name;?>" id="<?php echo $nm;?>" class="button">
								<?php
								echo $data['Name']."</a>";
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
																			<select name="pfSelect" id="sBox"/ autofocus>
																				<option >---</option>
																				
																				<?php
																					$doQ=mysqli_query($con,"SELECT abbvr from abbvr WHERE type='Pro' ");
																						while($data=mysqli_fetch_array($doQ))
																						{
																							//if ($Employee == 'Waseela' && $data['abbvr']=='mfs' )
																							//	echo "<option selected>";
																							//else if ($Employee == $parentCompany && $data['abbvr']=='Otar' )
																								//echo "<option selected>";
																							//else
																							echo "<option>";
																							echo $data['abbvr'];
																							echo "</option>";
																						}
																				?>
																			</select>	
																	</td>
																	
																</tr>
																
																<tr>
																	<td style="text-align: right;"> Payment From:  </td>
																	<td style="text-align: left;" >
																			<select name="modeSelect" id="sBox"/>
																				<option >---</option>
																				<?php
																					$doQ=mysqli_query($con,"SELECT Name from company WHERE Type='BNK' ");
																						while($data=mysqli_fetch_array($doQ))
																						{
																							//if ($data['Name']==$_POST['modeSelect'] )
																							//if ($data['Name']==$defaultBankName )
																								//echo "<option selected>";
																							//else
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
										 								<input type="submit"  value="Save" name="SaveCompanyPayment" id="Btn" onclick="checkInput()">
																	</td>
																	<td style="text-align: left;" >
																		<input type="submit" value="Reset" name="ResetPayment" id="Btn">
																	</td>
																</tr>
																
													</table>
											</form>
													
							</div>
			<!--	<div>
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
															<td><a href="delete/delcompanypayment.php?ID=<?php echo $id;?>&name=<?php echo $Employee;?>" id="LinkBtnDel">Delete</a></td>
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
				</div> -->
			<br />
			<br />
	
				<div>
							<table cellpadding="0" cellspacing="0" border="1" class="table table-bordered table-condensed" id="dbResult">
								<thead>
									<tr>
										<th>ID</th>
										<th>Date</th>
										<th>Product</th>
										<th>Type</th>
										<th>Quantity</th>
										<th>Amount Payable</th>
										<th>Purchased By</th>
										<th>Comments</th>
										<th>Action</th>
									</tr>
								</thead>
											<tbody>
													<?php
													$sum=0;
													
													    	
														$sql3 = mysqli_query($con,"SELECT * FROM tbl_mobile_load where loadStatus='Received' AND purchaseType='Credit' ")or die(mysqli_query());
														WHILE($Data3=mysqli_fetch_array($sql3))
															{ 
																$ID3=$Data3['loadID'];
																$proName3="Otar";
																$amounts=$Data3['loadAmnt'];
																if($parentCompany=='Mobilink')
																	$amount3=$amounts-($amounts*($marginReceived));
																else
																	$amount3=$amounts;
																echo "<tr>";
																echo "<td>".$ID3."</td>";
																echo "<td>".$Data3['loadDate']."</td>";
																echo "<td> ".$proName3." </td>";
																echo "<td></td>";
																echo "<td>".$amounts."</td>";
																echo "<td>".$amount3."</td>";
																echo "<td>".$Data3['User']."</td>";
																echo "<td>".$Data3['loadComments']."</td>";
																echo "<td><a onClick=\"javascript: return confirm('Please confirm Payment');\" href='edit/paytocompany.php?ID=".$ID3."&For=".$proName3."&Amnt=".$amount3."' id=\"LinkBtnEdit\">Pay Now</a></td></tr>";
																//echo '<td><a href="edit/paytocompany.php?ID='.$ID3.'&For='.$proName3.'&Amnt='.$amount3.'" id="LinkBtnEdit">Pay Now</a></td>';
																//echo "</tr>";
																$sum=$sum+$amount3;
															}
													
															
															
														$sql2 = mysqli_query($con,"SELECT * FROM tbl_financial_service where mfsStatus='Received' AND purchaseType='Credit' ")or die(mysqli_query());
														WHILE($Data2=mysqli_fetch_array($sql2))
															{ 
																$ID2=$Data2['mfsID'];
																$proName2="MFS";
																$amount2=$Data2['mfsAmnt'];
																echo "<tr>";
																echo "<td>".$ID2."</td>";
																echo "<td>".$Data2['mfsDate']."</td>";
																echo "<td> ".$proName2." </td>";
																echo "<td></td>";
																echo "<td>".$amount2."</td>";
																echo "<td>".$amount2."</td>";
																echo "<td>".$Data2['User']."</td>";
																echo "<td>".$Data2['mfsComments']."</td>";
																echo "<td><a onClick=\"javascript: return confirm('Please confirm Payment');\" href='edit/paytocompany.php?ID=".$ID2."&For=".$proName2."&Amnt=".$amount2."' id=\"LinkBtnEdit\">Pay Now</a></td></tr>";

																//echo '<td><a href="edit/paytocompany.php?ID='.$ID2.'&For='.$proName2.'&Amnt='.$amount2.'" id="LinkBtnEdit">Pay Now</a></td>';
																//echo "</tr>";
																$sum=$sum+$amount2;
															}
															
																$sql = mysqli_query($con,"SELECT * FROM tbl_cards where csStatus='Received' AND purchaseType='Credit' ")or die(mysqli_query());
														WHILE($Data=mysqli_fetch_array($sql))
															{ 
																$ID1=$Data['csID'];
																$proName1="Card";
																$amount1=$Data['csOrgAmnt'];
																echo "<tr>";
																echo "<td>".$ID1."</td>";
																echo "<td>".$Data['csDate']."</td>";
																echo "<td>".$proName1."</td>";
																echo "<td>".$Data['csType']."</td>";
																echo "<td>".$Data['csQty']."</td>";
																echo "<td>".$amount1."</td>";
																echo "<td>".$Data['User']."</td>";
																echo "<td>".$Data['csComments']."</td>";
																echo "<td><a onClick=\"javascript: return confirm('Please confirm Payment');\" href='edit/paytocompany.php?ID=".$ID1."&For=".$proName1."&Amnt=".$amount1."' id=\"LinkBtnEdit\">Pay Now</a></td></tr>";
																//echo '<td><a href="edit/paytocompany.php?ID='.$ID1.'&For='.$proName1.'&Amnt='.$amount1.'" id="LinkBtnEdit">Pay Now</a></td>';
																//echo "</tr>";
																$sum=$sum+$amount1;
															}
															
															
															$sql5 = mysqli_query($con,"SELECT * FROM tbl_product_stock where pName='Mobile' AND trType='Received' AND purchaseType='Credit' ")or die(mysqli_query());
														WHILE($Data5=mysqli_fetch_array($sql5))
															{ 
																$ID5=$Data5['sID'];
																$proName5="Mobile";
																$amount5=($Data5['qty'])*($Data5['rate']);
																echo "<tr>";
																echo "<td>".$ID5."</td>";
																echo "<td>".$Data5['sDate']."</td>";
																echo "<td> ".$proName5." </td>";
																echo "<td>".$Data5['pSubType']."</td>";
																echo "<td>".$Data5['qty']."</td>";
																echo "<td>".$amount5."</td>";
																echo "<td>".$Data5['User']."</td>";
																echo "<td>".$Data5['sComments']."</td>";
																echo "<td><a onClick=\"javascript: return confirm('Please confirm Payment');\" href='edit/paytocompany.php?ID=".$ID5."&For=".$proName5."&Amnt=".$amount5."' id=\"LinkBtnEdit\">Pay Now</a></td></tr>";

																//echo '<td><a href="edit/paytocompany.php?ID='.$ID5.'&For='.$proName5.'&Amnt='.$amount5.'" id="LinkBtnEdit">Pay Now</a></td>';
																//echo "</tr>";
																$sum=$sum+$amount5;
															}
															
															
														
														$sql4 = mysqli_query($con,"SELECT * FROM tbl_product_stock where pName='SIM' AND trType='Received' AND purchaseType='Credit' ")or die(mysqli_query());
														WHILE($Data4=mysqli_fetch_array($sql4))
															{ 
																$ID4=$Data4['sID'];
																$proName4="SIM";
																$amount4=($Data4['qty'])*($Data4['rate']);
																echo "<tr>";
																echo "<td>".$ID4."</td>";
																echo "<td>".$Data4['sDate']."</td>";
																echo "<td> ".$proName4." </td>";
																echo "<td>".$Data4['pSubType']."</td>";
																echo "<td>".$Data4['qty']."</td>";
																echo "<td>".$amount4."</td>";
																echo "<td>".$Data4['User']."</td>";
																echo "<td>".$Data4['sComments']."</td>";
																echo "<td><a onClick=\"javascript: return confirm('Please confirm Payment');\" href='edit/paytocompany.php?ID=".$ID4."&For=".$proName4."&Amnt=".$amount4."' id=\"LinkBtnEdit\">Pay Now</a></td></tr>";

																//echo '<td><a href="edit/paytocompany.php?ID='.$ID4.'&For='.$proName4.'&Amnt='.$amount4.'" id="LinkBtnEdit">Pay Now</a></td>';
																//echo "</tr>";
																$sum=$sum+$amount4;
															}
															
															
													?>
													
											</tbody>
											<tfoot >
								<tr style="border: solid black 2px;"  >
								<td colspan="5" > <b> TOTAL PAYABLE AMOUNT:</b></td>
								<td colspan="4" > <b><?php echo $sum; ?></b></td>
								</tr>
								</tfoot>	
							</table>
				</div>
	
	</div>
</html>