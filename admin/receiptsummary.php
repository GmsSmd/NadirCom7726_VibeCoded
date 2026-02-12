<?php
include_once('../session.php');
$Employee="";
include_once('includes/formula3.php');
include_once('includes/globalvar.php');
?>


<head>
			<title>Receipt Summary</title>
			<style>
			<?php
			include_once('styles/navbarstyle.php');
			include_once('styles/tablestyle.php');
			include_once('includes/navbar.php');
			?>
			</style>
			</head>
			
			<?php
?>
	<div class="container" align="center">
			
							<center>
								<caption> <h2>Receipts Summary</h2></caption>
							</center>
							
							<div  style="border: dashed blue 0px; ">
											<form id="AddReceiptForm" name="AddReceiptForm" action="" method="POST">
													
													
													
													<table cellpadding="0" cellspacing="0" border="0" class="table" id="headTable" >
																<tr>
																	<td style="text-align: right;"> Received From:  </td>
																		
																	<td style="text-align: left;" >
																			<select name="empSelect" id="sBox"/>
																				<option >---</option>
																				<?php
																					$doQ=mysqli_query($con,"SELECT EmpName from empinfo WHERE EmpStatus='Active' Order by sort_order ASC");
																						while($data=mysqli_fetch_array($doQ))
																						{
																							if ( $_POST['empSelect'] == $data['EmpName'])
																								echo "<option selected>";
																							else
																								echo "<option>";
																							echo $data['EmpName'];
																							echo "</option>";
																						}
																					$doQ=mysqli_query($con,"SELECT Name from company ORDER BY Name ASC");
																						while($data=mysqli_fetch_array($doQ))
																						{
																							if ( $_POST['empSelect'] == $data['Name'])
																								echo "<option selected>";
																							else
																								echo "<option>";
																							echo $data['Name'];
																							echo "</option>";
																						}
																				?>
																			</select>	
																	</td>
																	<td style="text-align: left;" >Received For:
																			<select name="ocSelect" id="sBox">
																				<option selected>---</option>
																				<?php
																					//$doQ=mysqli_query($con,"SELECT pName from products");
																					$doQ=mysqli_query($con,"SELECT DISTINCT rpFor FROM receiptpayment WHERE rpStatus='ReceivedFrom' ");
																						while($data=mysqli_fetch_array($doQ))
																						{
																							if ( $data['rpFor'] == $_POST['ocSelect'] )
																								echo "<option selected>";
																							else
																								echo "<option>";
																							echo $data['rpFor'];
																							echo "</option>";
																						}
																				?>
																			</select>	
																	</td>
																	
																	<td style="text-align: right;"> Date From:</td>
																	<td style="text-align: left;">
																			<?php
																					if (isset($_POST['Showreceipts']))
																						$strDate1=$_POST['txtDateFrom'];
																					else
																						$strDate1= date('Y-m-d');
																				echo "<input type=\"date\" value= \"$strDate1\"  name=\"txtDateFrom\" id=\"tBox\">";
																			?>
																	</td>
																	<td style="text-align: right;"> Date To:</td>
																	<td style="text-align: left;">
																			<?php
																					if (isset($_POST['Showreceipts']))
																						$strDate2=$_POST['txtDateTo'];
																					else
																						$strDate2= date('Y-m-d');
																				echo "<input type=\"date\" value= \"$strDate2\"  name=\"txtDateTo\" id=\"tBox\">";
																			?>
																	
										 								<input type="submit"  value="Show" name="Showreceipts" id="Btn">
																		</td>
																</tr>
																
													</table>
											</form>
													
							</div>
							
					<div class="" style="border: solid black 0px;">
							<table cellpadding="0" cellspacing="0" border="1" class="" id="dbResult">
							<h2> Receipts</h2>
								<thead>
									<tr>
										
										<th>Date</th>
										<th>Received From</th>
										<th>For</th>
										<th>Amount</th>
										<th>Transaction Mode</th>
										<th>Received By</th>
										<th>Notes</th>
										<th>Action</th>
									</tr>
								</thead>
											<tbody>
													<?php 
												
													global $receiptsummaryflag;
													if($receiptsummaryflag==0)
														
														$receiptsummary ="SELECT * FROM receiptpayment WHERE rpStatus= \"ReceivedFrom\" AND rpDate=\"$dateNow\" ";
													
													global $receiptsummary;
													$sum=0;
													$sql = mysqli_query($con,"$receiptsummary")or die(mysqli_query());
														WHILE($Data=mysqli_fetch_array($sql))
													{
															$rpID = $Data['rpID'];
															$Dat=$Data['rpDate'];
															$for=$Data['rpFor'];
															$fromTo= $Data['rpFromTo'];
															$Amnt= $Data['rpAmnt'];
															$mode= $Data['rpMode'];
															$User= $Data['rpUser'];
															$notes = $Data['rpNotes'];
															
															$sum=$sum + $Amnt;
															
														$id = $Data['rpID'];
														$d=strtotime($Dat);
																	$dtNow=date("d-M-Y", $d);
																	echo "<tr>";
																	echo "<td style=\"text-align: Center;\">". $dtNow ."</td>";
																	echo "<td>".$fromTo ."</td>";
																	echo "<td>".$for."</td>";
																	echo "<td>".$Amnt."</td>";
																	echo "<td>".$mode."</td>";
																	echo "<td>".$User."</td>";
																	echo "<td>".$notes."</td>";
																	if ($currentUserType=="Admin" && $Dat>=$QueryFD && $Dat<=$QueryLD)
																		echo "<td><a href=\"delete/delreceiptsummary.php?ID=".$id."\" id=\"LinkBtnDel\">Delete</a></td>";
																	else if($currentUserType=="Manager" && $Dat==date("Y-m-d"))
																		echo "<td><a href=\"delete/delreceiptsummary.php?ID=".$id."\" id=\"LinkBtnDel\">Delete</a></td>";
																	else
																		echo "<td></td>";
																	echo "</tr>";
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
						
	</div>
</html>