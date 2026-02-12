<?php
include_once('../session.php');
$pNameHere = $_GET['for'];
include_once('includes/formula1.php');
include_once('includes/globalvar.php');
?>
<head>
			<title>Sales</title>
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
								<caption> <h2>Sale Summary</h2></caption>
							</center>
							
			<div style="border: solid black 0px;" align="center" class="doBar">
					<?php
						$doQ=mysqli_query($con,"SELECT pName from products");
						while($data=mysqli_fetch_array($doQ))
							{
								$name=$data['pName'];
								if($name== $pNameHere)
									$nm='doLinkSelected';
								else
									$nm='doLink';
								?>
								<a href="salesummary.php?for=<?php echo $name;?>" id="<?php echo $nm;?>" class="button">
								<?php
								echo $data['pName']."</a>";
							}
					?>
			</div>
						<?php
			if($pNameHere=='Otar')
						{
						?>
			
							<div  style="border: solid black 0px; ">
											<form  action="" method="POST">
													<table cellpadding="0" cellspacing="0" border="0" class="table" id="headTable" >
														<tr>
																	<td style="text-align: right;"> Employee: </td>
																	<td style="text-align: left;" >
																			<select name="EmpSelect" id="sBox">
																					<option >---</option>
																					<?php
																						$doQ=mysqli_query($con,"SELECT EmpName from empinfo WHERE EmpStatus='Active' Order by sort_order ASC");
																						while($data=mysqli_fetch_array($doQ))
																							{
																								if( $data['EmpName']==$_POST['EmpSelect'] )
																									echo "<option selected>";
																								else
																									echo "<option>";
																								echo $data['EmpName'];
																								echo "</option>";
																							}
																					?>
																			</select>	
																	</td>
														
																	
																	<td style="text-align: right;"> Date From:</td>
																	<td style="text-align: left;">
																			<?php
																			if (isset($_POST['ShowOtarSales']))
																				$strDate1=$_POST['txtDateFrom'];
																			else
																				$strDate1= $CurrentDate; //$QueryFD date('Y-m-d');
																			
																			echo "<input type=\"date\" value= \"$strDate1\"  name=\"txtDateFrom\" id=\"tBox\" >";
																			?>
																	</td>
															
																	<td style="text-align: right;"> Date To:</td>
																	<td style="text-align: left;">
																			<?php
																			if (isset($_POST['ShowOtarSales']))
																				$strDate2=$_POST['txtDateTo'];
																			else
																				$strDate2= date('Y-m-d');
																			
																			echo "<input type=\"date\" value= \"$strDate2\"  name=\"txtDateTo\" id=\"tBox\">";
																			?>
																	
										 								<input type="submit"  value="Show" name="ShowOtarSales" id="Btn" onclick="checkInput()">
																	</td>
																</tr>
																
													</table>
											</form>
													
							</div>
							<table cellpadding="0" cellspacing="0" border="1" class="" id="dbResult">
								<thead>
									<tr>
										
										<th>Date</th>
										<th>Employee</th>
										<th>Amount</th>
										<th>Sent By</th>
										<th>Comments</th>
										<th>Action</th>
									</tr>
								</thead>
											<tbody>
													<?php 
													$AmntSum=0;
													if (isset($_POST['ShowOtarSales']))
													{
																$QtySum=0;
																$sql = mysqli_query($con,"$NewQuery")or die(mysqli_query());
																	WHILE($Data=mysqli_fetch_array($sql))
																{
																		$Dat=$Data['loadDate'];
																		$thisEmp=$Data['loadEmp'];
																		$Amnt= $Data['loadAmnt'];
																		$user=$Data['User'];
																		$Cmnts= $Data['loadComments'];
																		$AmntSum=$AmntSum + $Amnt;
																	$id = $Data['loadID'];
																	$d=strtotime($Dat);
																	$dtNow=date("d-M-Y", $d);
																	echo "<tr>";
																	echo "<td style=\"text-align: Center;\">". $dtNow ."</td>";
																	echo "<td>". $thisEmp ."</td>";
																	echo "<td>".$Amnt."</td>";
																	echo "<td>".$user."</td>";
																	echo "<td>".$Cmnts."</td>";
																	if ($currentUserType=="Admin" && $Dat>=$QueryFD && $Dat<=$QueryLD)
																		echo "<td><a onClick=\"javascript: return confirm('Please confirm Deletion');\" href=\"delete/delsalesummary.php?ID=".$id."&for=".$pNameHere."\" id=\"LinkBtnDel\">Delete</a></td>";
																	else if($currentUserType=="Manager" && $Dat==date("Y-m-d"))
																		echo "<td><a onClick=\"javascript: return confirm('Please confirm Deletion');\" href=\"delete/delsalesummary.php?ID=".$id."&for=".$pNameHere."\" id=\"LinkBtnDel\">Delete</a></td>";
																	else
																		echo "<td></td>";
																	echo "</tr>";
																
																}
													}
													?>
											</tbody>
											<tfoot >
								<tr style="border: solid black 2px;"  >
								<td colspan="2" style="text-align: Right;" > <b> TOTAL AMOUNT: </b></td>
								<td colspan="1" style="text-align: right;" > <b><?php echo $AmntSum; ?></b></td>
								<td colspan="3" > </td>
								
								</tr>
								</tfoot>
							</table>
						<?php
						}
			else if($pNameHere=='MFS')
						{
						?>
			
							<div  style="border: solid black 0px; ">
											<form  action="" method="POST">
													<table cellpadding="0" cellspacing="0" border="0" class="table" id="headTable" >
														<tr>
																	<td style="text-align: right;"> Employee: </td>
																	<td style="text-align: left;" >
																			<select name="EmpSelect" id="sBox">
																					<option >---</option>
																					<?php
																						$doQ=mysqli_query($con,"SELECT EmpName from empinfo WHERE EmpStatus='Active'Order by sort_order ASC");
																						while($data=mysqli_fetch_array($doQ))
																							{
																								if( $data['EmpName']==$_POST['EmpSelect'] )
																									echo "<option selected>";
																								else
																									echo "<option>";
																								echo $data['EmpName'];
																								echo "</option>";
																							}
																					?>
																			</select>	
																	</td>
																	<td style="text-align: right;"> Date From:</td>
																	<td style="text-align: left;">
																			<?php
																			if (isset($_POST['ShowmfsSales']))
																				$strDate1=$_POST['txtDateFrom'];
																			else
																				$strDate1=$CurrentDate; //$QueryFD date('Y-m-d');
																			
																			echo "<input type=\"date\" value= \"$strDate1\"  name=\"txtDateFrom\" id=\"tBox\" >";
																			?>
																	</td>
															
																	<td style="text-align: right;"> Date To:</td>
																	<td style="text-align: left;">
																			<?php
																			if (isset($_POST['ShowmfsSales']))
																				$strDate2=$_POST['txtDateTo'];
																			else
																				$strDate2= date('Y-m-d');
																			
																			echo "<input type=\"date\" value= \"$strDate2\"  name=\"txtDateTo\" id=\"tBox\">";
																			?>
																	
										 								<input type="submit"  value="Show" name="ShowmfsSales" id="Btn" onclick="checkInput()">
																	</td>
																</tr>
																
													</table>
											</form>
													
							</div>
							<h2> MFS Sent</h2>
							<table cellpadding="0" cellspacing="0" border="1" class="" id="dbResult">
								<thead>
									<tr>
										
										<th>Date</th>
										<th>Employee</th>
										<th>Sent Amount</th>
										<th>Sent By</th>
										<th>Comments</th>
										<th>Action</th>
									</tr>
								</thead>
											<tbody>
													<?php 
													$AmntSum=0;
													if (isset($_POST['ShowmfsSales']))
													{
																$QtySum=0;
																$sql = mysqli_query($con,"$NewQuery")or die(mysqli_query());
																	WHILE($Data=mysqli_fetch_array($sql))
																{
																		$Dat=$Data['mfsDate'];
																		$thisEmp=$Data['mfsEmp'];
																		$Amnt= $Data['mfsAmnt'];
																		$user= $Data['User'];
																		$Cmnts= $Data['mfsComments'];
																		
																		$AmntSum=$AmntSum + $Amnt;
																	$id = $Data['mfsID'];
																$d=strtotime($Dat);
																	$dtNow=date("d-M-Y", $d);
																	echo "<tr>";
																	echo "<td style=\"text-align: Center;\">". $dtNow ."</td>";
																	echo "<td>". $thisEmp ."</td>";
																	echo "<td>".$Amnt."</td>";
																	echo "<td>".$user."</td>";
																	echo "<td>".$Cmnts."</td>";
																	if ($currentUserType=="Admin" && $Dat>=$QueryFD && $Dat<=$QueryLD)
																		echo "<td><a onClick=\"javascript: return confirm('Please confirm Deletion');\" href=\"delete/delsalesummary.php?ID=".$id."&for=".$pNameHere."\" id=\"LinkBtnDel\">Delete</a></td>";
																	else if($currentUserType=="Manager" && $Dat==date("Y-m-d"))
																		echo "<td><a onClick=\"javascript: return confirm('Please confirm Deletion');\" href=\"delete/delsalesummary.php?ID=".$id."&for=".$pNameHere."\" id=\"LinkBtnDel\">Delete</a></td>";
																	else
																		echo "<td></td>";
																	echo "</tr>";
																
																}
													}
													?>
											</tbody>
											<tfoot >
								<tr style="border: solid black 2px;"  >
								<td colspan="2" style="text-align: Right;" > <b> TOTAL AMOUNT: </b></td>
								<td colspan="1" style="text-align: right;" > <b><?php echo $AmntSum; ?></b></td>
								<td colspan="3" > </td>
								
								</tr>
								</tfoot>
							</table>
							<br>
							<br>
														<h2> MFS Received</h2>

							<table cellpadding="0" cellspacing="0" border="1" class="" id="dbResult">
								<thead>
									<tr>
										
										<th>Date</th>
										<th>Employee</th>
										<th>Received Amount</th>
										<th>Received By</th>
										<th>Comments</th>
										<th>Action</th>
									</tr>
								</thead>
											<tbody>
													<?php 
													$AmntSum=0;
													if (isset($_POST['ShowmfsSales']))
													{
																$QtySum=0;
																$sql = mysqli_query($con,"$NewQuery1")or die(mysqli_query());
																	WHILE($Data=mysqli_fetch_array($sql))
																{
																		$Dat=$Data['mfsDate'];
																		$thisEmp=$Data['mfsEmp'];
																		$user=$Data['User'];
																		$Amnt= $Data['mfsAmnt'];
																		$Cmnts= $Data['mfsComments'];
																		
																		$AmntSum=$AmntSum + $Amnt;
																	$id = $Data['mfsID'];
																$d=strtotime($Dat);
																	$dtNow=date("d-M-Y", $d);
																	echo "<tr>";
																	echo "<td style=\"text-align: Center;\">". $dtNow ."</td>";
																	echo "<td>". $thisEmp ."</td>";
																	echo "<td>".$Amnt."</td>";
																	echo "<td>".$user."</td>";
																	echo "<td>".$Cmnts."</td>";
																	if ($currentUserType=="Admin" && $Dat>=$QueryFD && $Dat<=$QueryLD)
																		echo "<td><a onClick=\"javascript: return confirm('Please confirm Deletion');\" href=\"delete/delsalesummary.php?ID=".$id."&for=".$pNameHere."\" id=\"LinkBtnDel\">Delete</a></td>";
																	else if($currentUserType=="Manager" && $Dat==date("Y-m-d"))
																		echo "<td><a onClick=\"javascript: return confirm('Please confirm Deletion');\" href=\"delete/delsalesummary.php?ID=".$id."&for=".$pNameHere."\" id=\"LinkBtnDel\">Delete</a></td>";
																	else
																		echo "<td></td>";
																	echo "</tr>";
																
																}
													}
													?>
											</tbody>
											<tfoot >
								<tr style="border: solid black 2px;"  >
								<td colspan="2" style="text-align: Right;" > <b> TOTAL AMOUNT: </b></td>
								<td colspan="1" style="text-align: right;" > <b><?php echo $AmntSum; ?></b></td>
								<td colspan="3" > </td>
								
								</tr>
								</tfoot>
							</table>
							
							
						<?php
						}
			else if($pNameHere=='Card')
						{
						?>
			
							<div  style="border: solid black 0px; ">
											<form  action="" method="POST">
													<table cellpadding="0" cellspacing="0" border="0" class="table" id="headTable" >
														<tr>
																	<td style="text-align: right;"> Employee: </td>
																	<td style="text-align: left;" >
																			<select name="EmpSelect" id="sBox">
																					<option >---</option>
																					<?php
																						$doQ=mysqli_query($con,"SELECT EmpName from empinfo WHERE EmpStatus='Active'Order by sort_order ASC");
																						while($data=mysqli_fetch_array($doQ))
																							{
																								if( $data['EmpName']==$_POST['EmpSelect'] )
																									echo "<option selected>";
																								else
																									echo "<option>";
																								echo $data['EmpName'];
																								echo "</option>";
																							}
																					?>
																			</select>	
																	</td>
																	<td style="text-align: right;"> Card Type: </td>
																	<td style="text-align: left;" >
																			<select name="SubPselect" id="sBox">
																				<option >---</option>
																				<?php
																					$doQ=mysqli_query($con,"SELECT typeName from types WHERE productName='Card' AND isActive=1");
																						while($data=mysqli_fetch_array($doQ))
																						{
																							if($data['typeName']==$_POST['SubPselect'])
																								echo "<option selected>";
																							else 
																								echo "<option>";
																							echo $data['typeName'];
																							echo "<br>";
																							echo "</option>";
																						}
																				?>
																			</select>	
																	</td>
																	<td style="text-align: right;"> Date From:</td>
																	<td style="text-align: left;">
																			<?php
																			if (isset($_POST['Showtbl_cardss']))
																				$strDate1=$_POST['txtDateFrom'];
																			else
																				$strDate1=$CurrentDate; //$QueryFD date('Y-m-d');
																			
																			echo "<input type=\"date\" value= \"$strDate1\"  name=\"txtDateFrom\" id=\"tBox\" >";
																			?>
																	</td>
															
																	<td style="text-align: right;"> Date To:</td>
																	<td style="text-align: left;">
																			<?php
																			if (isset($_POST['Showtbl_cardss']))
																				$strDate2=$_POST['txtDateTo'];
																			else
																				$strDate2= date('Y-m-d');
																			
																			echo "<input type=\"date\" value= \"$strDate2\"  name=\"txtDateTo\" id=\"tBox\">";
																			?>
																	
										 								<input type="submit"  value="Show" name="Showtbl_cardss" id="Btn" onclick="checkInput()">
																	</td>
																</tr>
																
													</table>
											</form>
													
							</div>
							<table cellpadding="0" cellspacing="0" border="1" class="" id="dbResult">
								<thead>
									<tr>
										
										<th>Date</th>
										<th>Employee</th>
										<th>Type</th>
										<th>Quantity</th>
										<th>Amount</th>
										<th>Sold By</th>
										<th>Comments</th>
										<th>Pro/Loss</th>
										<th>Action</th>
									</tr>
								</thead>
											<tbody>
													<?php 
													$AmntSum=0;
													$QtySum=0;
													$plSum=0;
													if (isset($_POST['Showtbl_cardss']))
													{													
													$sql = mysqli_query($con,"$NewQuery")or die(mysqli_query());
														WHILE($Data=mysqli_fetch_array($sql))
													    {
															
															$Dat=$Data['csDate'];
															$thisEmp=$Data['csEmp'];
															$Type= $Data['csType'];
															$Qty= $Data['csQty'];
															$Amnt= $Data['csTotalAmnt'];
															$user= $Data['User'];
															$Cmnts= $Data['csComments'];
															$pl=$Data['csProLoss'];
															
															$AmntSum=$AmntSum + $Amnt;
																$QtySum=$QtySum+$Qty;
															$id = $Data['csID'];
															$d=strtotime($Dat);
																	$dtNow=date("d-M-Y", $d);
																	echo "<tr>";
																	echo "<td style=\"text-align: Center;\">". $dtNow ."</td>";
																	echo "<td>". $thisEmp ."</td>";
																	echo "<td>".$Type."</td>";
																	echo "<td>".$Qty."</td>";
																	echo "<td>".$Amnt."</td>";
																	echo "<td>".$user."</td>";
																	echo "<td>".$Cmnts."</td>";
																	echo "<td>".$pl."</td>";
																	if ($currentUserType=="Admin" && $Dat>=$QueryFD && $Dat<=$QueryLD)
																		echo "<td><a onClick=\"javascript: return confirm('Please confirm Deletion');\" href=\"delete/delsalesummary.php?ID=".$id."&for=".$pNameHere."\" id=\"LinkBtnDel\">Delete</a></td>";
																	else if($currentUserType=="Manager" && $Dat==date("Y-m-d"))
																		echo "<td><a onClick=\"javascript: return confirm('Please confirm Deletion');\" href=\"delete/delsalesummary.php?ID=".$id."&for=".$pNameHere."\" id=\"LinkBtnDel\">Delete</a></td>";
																	else
																		echo "<td></td>";
																	echo "</tr>";
															
															
															$plSum=$plSum+$pl;
														}
													}
													?>
											</tbody>
											<tfoot >
								<tr style="border: solid black 2px;"  >
								<td colspan="3" > <b> TOTAL AMOUNT: </b></td>
								<td colspan="1" > <b><?php echo $QtySum; ?></b></td>
								<td colspan="1" > <b><?php echo $AmntSum; ?></b></td>
								<td colspan="2" > </td>
								<td colspan="1" > <b><?php echo $plSum; ?></b></td>
								<td colspan="1" > </td>
								</tr>
								</tfoot>
							</table>
						<?php
						}
			else if($pNameHere=='Mobile')
						{
						?>
			
							<div  style="border: solid black 0px; ">
											<form  action="" method="POST">
													<table cellpadding="0" cellspacing="0" border="0" class="table" id="headTable" >
														<tr>
																	<td style="text-align: right;"> Employee: </td>
																	<td style="text-align: left;" >
																			<select name="EmpSelect" id="sBox">
																					<option >---</option>
																					<?php
																						$doQ=mysqli_query($con,"SELECT EmpName from empinfo WHERE EmpStatus='Active'Order by sort_order ASC");
																						while($data=mysqli_fetch_array($doQ))
																							{
																								if( $data['EmpName']==$_POST['EmpSelect'] )
																									echo "<option selected>";
																								else
																									echo "<option>";
																								echo $data['EmpName'];
																								echo "</option>";
																							}
																					?>
																			</select>	
																	</td>
																	<td style="text-align: right;"> Device Type: </td>
																	<td style="text-align: left;" >
																			<select name="SubPselect" id="sBox">
																				<option >---</option>
																				<?php
																					$doQ=mysqli_query($con,"SELECT typeName from types WHERE productName='Mobile' AND isActive=1");
																						while($data=mysqli_fetch_array($doQ))
																						{
																							if($data['typeName']==$_POST['SubPselect'])
																								echo "<option selected>";
																							else 
																								echo "<option>";
																							echo $data['typeName'];
																							echo "<br>";
																							echo "</option>";
																						}
																				?>
																			</select>	
																	</td>
																	<td style="text-align: right;"> Date From:</td>
																	<td style="text-align: left;">
																			<?php
																			if (isset($_POST['ShowMobileSales']))
																				$strDate1=$_POST['txtDateFrom'];
																			else
																				$strDate1=$CurrentDate; //$QueryFD date('Y-m-d');
																			
																			echo "<input type=\"date\" value= \"$strDate1\"  name=\"txtDateFrom\" id=\"tBox\" >";
																			?>
																	</td>
															
																	<td style="text-align: right;"> Date To:</td>
																	<td style="text-align: left;">
																			<?php
																			if (isset($_POST['ShowMobileSales']))
																				$strDate2=$_POST['txtDateTo'];
																			else
																				$strDate2= date('Y-m-d');
																			
																			echo "<input type=\"date\" value= \"$strDate2\"  name=\"txtDateTo\" id=\"tBox\">";
																			?>
																	
										 								<input type="submit"  value="Show" name="ShowMobileSales" id="Btn" onclick="checkInput()">
																	</td>
																</tr>
																
													</table>
											</form>
													
							</div>
							<table cellpadding="0" cellspacing="0" border="1" class="" id="dbResult">
								<thead>
									<tr>
										<th>Date</th>
										<th>Employee</th>
										<th>Type</th>
										<th>Quantity</th>
										<th>Rate</th>
										<th>Amount</th>
										<th>Sold By</th>
										<th>Comments</th>
										<th>Pro/Loss</th>	
										<th>Action</th>
									</tr>
								</thead>
											<tbody>
													<?php 
													$AmntSum=0;
													$QtySum=0;
													$plSum=0;
													if (isset($_POST['ShowMobileSales']))
													{													
													$sql = mysqli_query($con,"$NewQuery")or die(mysqli_query());
														WHILE($Data=mysqli_fetch_array($sql))
													{
															$Dat=$Data['sDate'];
															$thisEmp=$Data['customer'];
															$Type= $Data['pSubType'];
															$Qty= $Data['qty'];
															$rat= $Data['rate'];
															$Amnt= $Qty*$rat;
															$user= $Data['User'];
															$Cmnts= $Data['sComments'];
															
															
															
															//getting purchase rate
															    $qry110 = mysqli_query($con,"SELECT purchasePrice FROM rates WHERE pName='Mobile' AND spName='$Type' ORDER BY rtID DESC LIMIT 1")or die(mysqli_query());
                                                        		$Data110=mysqli_fetch_array($qry110);
                                                        		$PurchaseRate= $Data110['purchasePrice'];
															
															$cost=$Qty*$PurchaseRate;
															$pl=$Amnt-$cost;
															
															
															$AmntSum=$AmntSum + $Amnt;
																$QtySum=$QtySum+$Qty;
															$id = $Data['sID'];
															$d=strtotime($Dat);
																	$dtNow=date("d-M-Y", $d);
																	echo "<tr>";
																	echo "<td style=\"text-align: Center;\">". $dtNow ."</td>";
																	echo "<td>". $thisEmp ."</td>";
																	echo "<td>".$Type."</td>";
																	echo "<td>".$Qty."</td>";
																	echo "<td>".$rat."</td>";
																	echo "<td>".$Amnt."</td>";
																	echo "<td>".$user."</td>";
																	echo "<td>".$Cmnts."</td>";
																	echo "<td>".$pl."</td>";
																	if ($currentUserType=="Admin" && $Dat>=$QueryFD && $Dat<=$QueryLD)
																		echo "<td><a onClick=\"javascript: return confirm('Please confirm Deletion');\" href=\"delete/delsalesummary.php?ID=".$id."&for=".$pNameHere."\" id=\"LinkBtnDel\">Delete</a></td>";
																	else if($currentUserType=="Manager" && $Dat==date("Y-m-d"))
																		echo "<td><a onClick=\"javascript: return confirm('Please confirm Deletion');\" href=\"delete/delsalesummary.php?ID=".$id."&for=".$pNameHere."\" id=\"LinkBtnDel\">Delete</a></td>";
																	else
																		echo "<td></td>";
																	echo "</tr>";
															
															$plSum=$plSum+$pl;
														}
													}
													?>
											</tbody>
											<tfoot >
								<tr style="border: solid black 2px;"  >
								<td colspan="3" style="text-align: right;"> <b> TOTAL AMOUNT: </b></td>
								<td colspan="1"style="text-align: Center;" > <b><?php echo $QtySum; ?></b></td>
								<td></td>
								<td colspan="1" style="text-align: right;"> <b><?php echo $AmntSum; ?></b></td>
								<td colspan="2" > </td>
								<td colspan="1" > <b><?php echo $plSum; ?></b></td>
								<td colspan="1" > </td>
								</tr>
								</tfoot>
							</table>
						<?php
						}
			else if($pNameHere=='SIM')
						{
						?>
			
							<div  style="border: solid black 0px; ">
											<form  action="" method="POST">
													<table cellpadding="0" cellspacing="0" border="0" class="table" id="headTable" >
														<tr>
																	<td style="text-align: right;"> Employee: </td>
																	<td style="text-align: left;" >
																			<select name="EmpSelect" id="sBox">
																					<option >---</option>
																					<?php
																						$doQ=mysqli_query($con,"SELECT EmpName from empinfo WHERE EmpStatus='Active'Order by sort_order ASC");
																						while($data=mysqli_fetch_array($doQ))
																							{
																								if( $data['EmpName']==$_POST['EmpSelect'] )
																									echo "<option selected>";
																								else
																									echo "<option>";
																								echo $data['EmpName'];
																								echo "</option>";
																							}
																					?>
																			</select>	
																	</td>
																	<td style="text-align: right;"> SIM Type: </td>
																	<td style="text-align: left;" >
																			<select name="SubPselect" id="sBox">
																				<option >---</option>
																				<?php
																					$doQ=mysqli_query($con,"SELECT typeName from types WHERE productName='SIM' AND isActive=1");
																						while($data=mysqli_fetch_array($doQ))
																						{
																							if($data['typeName']==$_POST['SubPselect'])
																								echo "<option selected>";
																							else 
																								echo "<option>";
																							echo $data['typeName'];
																							echo "<br>";
																							echo "</option>";
																						}
																				?>
																			</select>	
																	</td>
																	<td style="text-align: right;"> Date From:</td>
																	<td style="text-align: left;">
																			<?php
																			if (isset($_POST['ShowsIMSales']))
																				$strDate1=$_POST['txtDateFrom'];
																			else
																				$strDate1=$CurrentDate; //$QueryFD date('Y-m-d');
																			
																			echo "<input type=\"date\" value= \"$strDate1\"  name=\"txtDateFrom\" id=\"tBox\" >";
																			?>
																	</td>
															
																	<td style="text-align: right;"> Date To:</td>
																	<td style="text-align: left;">
																			<?php
																			if (isset($_POST['ShowsIMSales']))
																				$strDate2=$_POST['txtDateTo'];
																			else
																				$strDate2= date('Y-m-d');
																			
																			echo "<input type=\"date\" value= \"$strDate2\"  name=\"txtDateTo\" id=\"tBox\">";
																			?>
																	
										 								<input type="submit"  value="Show" name="ShowsIMSales" id="Btn" onclick="checkInput()">
																	</td>
																</tr>
																
													</table>
											</form>
													
							</div>
							<table cellpadding="0" cellspacing="0" border="1" class="" id="dbResult">
								<thead>
									<tr>
										<th>Date</th>
										<th>Employee</th>
										<th>Type</th>
										<th>Quantity</th>
										<th>Rate</th>
										<th>Amount</th>
										<th>Sold By</th>
										<th>Comments</th>
										<th>Pro/Loss</th>
										<th>Action</th>
									</tr>
								</thead>
											<tbody>
													<?php 
													$AmntSum=0;
													$QtySum=0;
													$plSum=0;
													if (isset($_POST['ShowsIMSales']))
													{													
													$sql = mysqli_query($con,"$NewQuery")or die(mysqli_query());
														WHILE($Data=mysqli_fetch_array($sql))
													{
															$Dat=$Data['sDate'];
															$thisEmp=$Data['customer'];
															$Type= $Data['pSubType'];
															$Qty= $Data['qty'];
															$user= $Data['User'];
															$rat= $Data['rate'];
															$Amnt= $Qty*$rat;
															$Cmnts= $Data['sComments'];
															
															
															
															//getting purchase rate
															    $qry110 = mysqli_query($con,"SELECT purchasePrice FROM rates WHERE pName='SIM' AND spName='$Type' ORDER BY rtID DESC LIMIT 1")or die(mysqli_query());
                                                        		$Data110=mysqli_fetch_array($qry110);
                                                        		$PurchaseRate= $Data110['purchasePrice'];
															
															$cost=$Qty*$PurchaseRate;
															$pl=$Amnt-$cost;
															
															
															$AmntSum=$AmntSum + $Amnt;
																$QtySum=$QtySum+$Qty;
															$id = $Data['sID'];
															$d=strtotime($Dat);
																	$dtNow=date("d-M-Y", $d);
																	echo "<tr>";
																	echo "<td style=\"text-align: Center;\">". $dtNow ."</td>";
																	echo "<td>". $thisEmp ."</td>";
																	echo "<td>".$Type."</td>";
																	echo "<td>".$Qty."</td>";
																	echo "<td>".$rat."</td>";
																	echo "<td>".$Amnt."</td>";
																	echo "<td>".$user."</td>";
																	echo "<td>".$Cmnts."</td>";
																	echo "<td>".$pl."</td>";
																	if ($currentUserType=="Admin" && $Dat>=$QueryFD && $Dat<=$QueryLD)
																		echo "<td><a onClick=\"javascript: return confirm('Please confirm Deletion');\" href=\"delete/delsalesummary.php?ID=".$id."&for=".$pNameHere."\" id=\"LinkBtnDel\">Delete</a></td>";
																	else if($currentUserType=="Manager" && $Dat==date("Y-m-d"))
																		echo "<td><a onClick=\"javascript: return confirm('Please confirm Deletion');\" href=\"delete/delsalesummary.php?ID=".$id."&for=".$pNameHere."\" id=\"LinkBtnDel\">Delete</a></td>";
																	else
																		echo "<td></td>";
																	echo "</tr>";
															
															$plSum=$plSum+$pl;
														}
													}
													?>
											</tbody>
											<tfoot >
								<tr style="border: solid black 2px;"  >
								<td colspan="3" style="text-align: right;"> <b> TOTAL AMOUNT: </b></td>
								<td colspan="1"style="text-align: Center;" > <b><?php echo $QtySum; ?></b></td>
								<td></td>
								<td colspan="1" style="text-align: right;"> <b><?php echo $AmntSum; ?></b></td>
								<td colspan="2" > </td>
								<td colspan="1" > <b><?php echo $plSum; ?></b></td>
								<td colspan="1" > </td>
								</tr>
								</tfoot>
							</table>
						<?php
						}
						
						
						
					else
					echo "<h2>Select an option then press \"Show\" Button</h2>";
						?>
						
	</div>