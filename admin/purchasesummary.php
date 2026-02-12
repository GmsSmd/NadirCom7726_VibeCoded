<?php
include_once('../session.php');
$pNameHere = $_GET['for'];
include_once('includes/formula1.php');
include_once('includes/globalvar.php');
?>
<head>
			<title>Purchases</title>
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
								<caption> <h2>Purchase Summary</h2></caption>
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
								<a href="purchasesummary.php?for=<?php echo $name;?>" id="<?php echo $nm;?>" class="button">
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
																	
																	<td style="text-align: right;"> Date From:</td>
																	<td style="text-align: left;">
																			<?php
																			if (isset($_POST['ShowOtarPurchases']))
																				$strDate1=$_POST['txtDateFrom'];
																			else
																				$strDate1= $CurrentDate; //$QueryFD date('Y-m-d');
																			
																			echo "<input type=\"date\" value= \"$strDate1\"  name=\"txtDateFrom\" id=\"tBox\" >";
																			?>
																	</td>
															
																	<td style="text-align: right;"> Date To:</td>
																	<td style="text-align: left;">
																			<?php
																			if (isset($_POST['ShowOtarPurchases']))
																				$strDate2=$_POST['txtDateTo'];
																			else
																				$strDate2= date('Y-m-d');
																			
																			echo "<input type=\"date\" value= \"$strDate2\"  name=\"txtDateTo\" id=\"tBox\">";
																			?>
																	
										 								<input type="submit"  value="Show" name="ShowOtarPurchases" id="Btn" onclick="checkInput()">
																	</td>
																</tr>
																
													</table>
											</form>
													
							</div>
							<table cellpadding="0" cellspacing="0" border="1" class="" id="dbResult">
								<thead>
									<tr>
										
										<th>Date</th>
										<th>Amount</th>
										<th>Purchased By</th>
										<th>Comments</th>
										<th>Action</th>
									</tr>
								</thead>
											<tbody>
													<?php 
													$AmntSum=0;
													if (isset($_POST['ShowOtarPurchases']))
													{
																$QtySum=0;
																$sql = mysqli_query($con,"$NewQuery")or die(mysqli_query());
																	WHILE($Data=mysqli_fetch_array($sql))
																{
																		$Dat=$Data['loadDate'];
																		$Amnt= $Data['loadAmnt'];
																		$user= $Data['User'];
																		$Cmnts= $Data['loadComments'];
																		
																		$AmntSum=$AmntSum + $Amnt;
																	$id = $Data['loadID'];
																	$d=strtotime($Dat);
																	$dtNow=date("d-M-Y", $d);
																	echo "<tr>";
																	echo "<td style=\"text-align: Center;\">". $dtNow ."</td>";
																	echo "<td style=\"text-align: right;\">". $Amnt ."</td>";
																	echo "<td>". $user ."</td>";
																	echo "<td>".$Cmnts."</td>";
																	
																	if ($currentUserType=="Admin" && $Dat>=$QueryFD && $Dat<=$QueryLD)
																    //  echo "<td><a onClick=\"javascript: return confirm('Please confirm Payment');\" href='edit/paysalary.php?ID=".$id."&dt=".$dt1."&sl=".$sal."' id=\"LinkBtnEdit\">Pay Now</a></td></tr>";
																		echo "<td><a onClick=\"javascript: return confirm('Please confirm Deletion');\" href=\"delete/delpurchasesummary.php?ID=".$id."&for=".$pNameHere."\" id=\"LinkBtnDel\">Delete</a></td>";
																	else if($currentUserType=="Manager" && $Dat==date("Y-m-d"))
																		echo "<td><a onClick=\"javascript: return confirm('Please confirm Deletion');\" href=\"delete/delpurchasesummary.php?ID=".$id."&for=".$pNameHere."\" id=\"LinkBtnDel\">Delete</a></td>";

																		//echo "<td><a href=\"delete/delpurchasesummary.php?ID=".$id."&for=".$pNameHere."\" id=\"LinkBtnDel\">Delete</a></td>";
																	else
																		echo "<td></td>";
																	echo "</tr>";
																}
													}
													?>
											</tbody>
											<tfoot >
								<tr style="border: solid black 2px;"  >
								<td colspan="1" style="text-align: Right;" > <b> TOTAL AMOUNT: </b></td>
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
																	
																	<td style="text-align: right;"> Date From:</td>
																	<td style="text-align: left;">
																			<?php
																			if (isset($_POST['ShowmfsPurchases']))
																				$strDate1=$_POST['txtDateFrom'];
																			else
																				$strDate1= $CurrentDate; //$QueryFD date('Y-m-d');
																			
																			echo "<input type=\"date\" value= \"$strDate1\"  name=\"txtDateFrom\" id=\"tBox\" >";
																			?>
																	</td>
															
																	<td style="text-align: right;"> Date To:</td>
																	<td style="text-align: left;">
																			<?php
																			if (isset($_POST['ShowmfsPurchases']))
																				$strDate2=$_POST['txtDateTo'];
																			else
																				$strDate2= date('Y-m-d');
																			
																			echo "<input type=\"date\" value= \"$strDate2\"  name=\"txtDateTo\" id=\"tBox\">";
																			?>
																	
										 								<input type="submit"  value="Show" name="ShowmfsPurchases" id="Btn" onclick="checkInput()">
																	</td>
																</tr>
																
													</table>
											</form>
													
							</div>
							<table cellpadding="0" cellspacing="0" border="1" class="" id="dbResult">
								<thead>
									<tr>
										
										<th>Date</th>
										<th>Amount</th>
										<th>Purchased By</th>
										<th>Comments</th>
										<th>Action</th>
									</tr>
								</thead>
											<tbody>
													<?php 
													$AmntSum=0;
													if (isset($_POST['ShowmfsPurchases']))
													{
																$QtySum=0;
																$sql = mysqli_query($con,"$NewQuery")or die(mysqli_query());
																	WHILE($Data=mysqli_fetch_array($sql))
																{
																		$Dat=$Data['mfsDate'];
																		$Amnt= $Data['mfsAmnt'];
																		$user= $Data['User'];
																		$Cmnts= $Data['mfsComments'];
																		
																		$AmntSum=$AmntSum + $Amnt;
																	$id = $Data['mfsID'];
																
																	$d=strtotime($Dat);
																	$dtNow=date("d-M-Y", $d);
																	echo "<tr>";
																	echo "<td style=\"text-align: Center;\">". $dtNow ."</td>";
																	echo "<td style=\"text-align: right;\">". $Amnt ."</td>";
																	echo "<td>". $user ."</td>";
																	echo "<td>".$Cmnts."</td>";
																	if ($currentUserType=="Admin" && $Dat>=$QueryFD && $Dat<=$QueryLD)
																	//  echo "<td><a onClick=\"javascript: return confirm('Please confirm Payment');\" href='edit/paysalary.php?ID=".$id."&dt=".$dt1."&sl=".$sal."' id=\"LinkBtnEdit\">Pay Now</a></td></tr>";
																		echo "<td><a onClick=\"javascript: return confirm('Please confirm Deletion');\" href=\"delete/delpurchasesummary.php?ID=".$id."&for=".$pNameHere."\" id=\"LinkBtnDel\">Delete</a></td>";
																	else if($currentUserType=="Manager" && $Dat==date("Y-m-d"))
																		echo "<td><a onClick=\"javascript: return confirm('Please confirm Deletion');\" href=\"delete/delpurchasesummary.php?ID=".$id."&for=".$pNameHere."\" id=\"LinkBtnDel\">Delete</a></td>";
																	else
																		echo "<td></td>";
																	echo "</tr>";
																}
													}
													?>
											</tbody>
											<tfoot >
								<tr style="border: solid black 2px;"  >
								<td colspan="1" style="text-align: Right;" > <b> TOTAL AMOUNT: </b></td>
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
																			if (isset($_POST['ShowCardPurchases']))
																				$strDate1=$_POST['txtDateFrom'];
																			else
																				$strDate1=$CurrentDate; //$QueryFD date('Y-m-d');
																			
																			echo "<input type=\"date\" value= \"$strDate1\"  name=\"txtDateFrom\" id=\"tBox\" >";
																			?>
																	</td>
															
																	<td style="text-align: right;"> Date To:</td>
																	<td style="text-align: left;">
																			<?php
																			if (isset($_POST['ShowCardPurchases']))
																				$strDate2=$_POST['txtDateTo'];
																			else
																				$strDate2= date('Y-m-d');
																			
																			echo "<input type=\"date\" value= \"$strDate2\"  name=\"txtDateTo\" id=\"tBox\">";
																			?>
																	
										 								<input type="submit"  value="Show" name="ShowCardPurchases" id="Btn" onclick="checkInput()">
																	</td>
																</tr>
																
													</table>
											</form>
													
							</div>
							<table cellpadding="0" cellspacing="0" border="1" class="" id="dbResult">
								<thead>
									<tr>
										
										<th>Date</th>
										<th>Type</th>
										<th>Quantity</th>
										<th>Amount</th>
										<th>Purchased By</th>
										<th>Comments</th>
										<th>Action</th>
									</tr>
								</thead>
											<tbody>
													<?php 
													$AmntSum=0;
													$QtySum=0;
													if (isset($_POST['ShowCardPurchases']))
													{													
													$sql = mysqli_query($con,"$NewQuery")or die(mysqli_query());
														WHILE($Data=mysqli_fetch_array($sql))
													{
															
															$Dat=$Data['csDate'];
															$Type= $Data['csType'];
															$Qty= $Data['csQty'];
															$Amnt= $Data['csOrgAmnt'];
															$user= $Data['User'];
															$Cmnts= $Data['csComments'];
															
															$AmntSum=$AmntSum + $Amnt;
																$QtySum=$QtySum+$Qty;
															$id = $Data['csID'];
															
															$d=strtotime($Dat);
																	$dtNow=date("d-M-Y", $d);
																	echo "<tr>";
																	echo "<td style=\"text-align: Center;\">". $dtNow ."</td>";
																	echo "<td>".$Type."</td>";
																	echo "<td>".$Qty."</td>";
																	echo "<td style=\"text-align: right;\">". $Amnt ."</td>";
																	echo "<td>". $user ."</td>";
																	echo "<td>".$Cmnts."</td>";
																	if ($currentUserType=="Admin" && $Dat>=$QueryFD && $Dat<=$QueryLD)
																		echo "<td><a onClick=\"javascript: return confirm('Please confirm Deletion');\" href=\"delete/delpurchasesummary.php?ID=".$id."&for=".$pNameHere."\" id=\"LinkBtnDel\">Delete</a></td>";
																	else if($currentUserType=="Manager" && $Dat==date("Y-m-d"))
																		echo "<td><a onClick=\"javascript: return confirm('Please confirm Deletion');\" href=\"delete/delpurchasesummary.php?ID=".$id."&for=".$pNameHere."\" id=\"LinkBtnDel\">Delete</a></td>";
																	else
																		echo "<td></td>";
																	echo "</tr>";
															
														}
													}
													?>
											</tbody>
											<tfoot >
								<tr style="border: solid black 2px;"  >
								<td colspan="2" > <b> TOTAL AMOUNT: </b></td>
								<td colspan="1" > <b><?php echo $QtySum; ?></b></td>
								<td colspan="1" > <b><?php echo $AmntSum; ?></b></td>
								<td colspan="3" > </td>
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
																			if (isset($_POST['ShowMobilePurchases']))
																				$strDate1=$_POST['txtDateFrom'];
																			else
																				$strDate1=$CurrentDate; //$QueryFD date('Y-m-d');
																			
																			echo "<input type=\"date\" value= \"$strDate1\"  name=\"txtDateFrom\" id=\"tBox\" >";
																			?>
																	</td>
															
																	<td style="text-align: right;"> Date To:</td>
																	<td style="text-align: left;">
																			<?php
																			if (isset($_POST['ShowMobilePurchases']))
																				$strDate2=$_POST['txtDateTo'];
																			else
																				$strDate2= date('Y-m-d');
																			
																			echo "<input type=\"date\" value= \"$strDate2\"  name=\"txtDateTo\" id=\"tBox\">";
																			?>
																	
										 								<input type="submit"  value="Show" name="ShowMobilePurchases" id="Btn" onclick="checkInput()">
																	</td>
																</tr>
																
													</table>
											</form>
													
							</div>
							<table cellpadding="0" cellspacing="0" border="1" class="" id="dbResult">
								<thead>
									<tr>
										<th>Date</th>
										<th>Type</th>
										<th>Quantity</th>
										<th>Rate</th>
										<th>Amount</th>
										<th>Purchased By</th>
										<th>Comments</th>
										<th>Action</th>
									</tr>
								</thead>
											<tbody>
													<?php 
													$AmntSum=0;
													$QtySum=0;
													if (isset($_POST['ShowMobilePurchases']))
													{													
													$sql = mysqli_query($con,"$NewQuery")or die(mysqli_query());
														WHILE($Data=mysqli_fetch_array($sql))
													{
															$Dat=$Data['sDate'];
															$Type= $Data['pSubType'];
															$Qty= $Data['qty'];
															$rat= $Data['rate'];
															$Amnt= $Qty*$rat;
															$user= $Data['User'];
															$Cmnts= $Data['sComments'];
															
															$AmntSum=$AmntSum + $Amnt;
																$QtySum=$QtySum+$Qty;
															$id = $Data['sID'];
															
															$d=strtotime($Dat);
																	$dtNow=date("d-M-Y", $d);
																	echo "<tr>";
																	echo "<td style=\"text-align: Center;\">". $dtNow ."</td>";
																	echo "<td>".$Type."</td>";
																	echo "<td>".$Qty."</td>";
																	echo "<td>".$rat."</td>";
																	echo "<td style=\"text-align: right;\">". $Amnt ."</td>";
																	echo "<td>". $user ."</td>";
																	echo "<td>".$Cmnts."</td>";
																	if ($currentUserType=="Admin" && $Dat>=$QueryFD && $Dat<=$QueryLD)
																		echo "<td><a onClick=\"javascript: return confirm('Please confirm Deletion');\" href=\"delete/delpurchasesummary.php?ID=".$id."&for=".$pNameHere."\" id=\"LinkBtnDel\">Delete</a></td>";
																	else if($currentUserType=="Manager" && $Dat==date("Y-m-d"))
																		echo "<td><a onClick=\"javascript: return confirm('Please confirm Deletion');\" href=\"delete/delpurchasesummary.php?ID=".$id."&for=".$pNameHere."\" id=\"LinkBtnDel\">Delete</a></td>";
																	else
																		echo "<td></td>";
																	echo "</tr>";
														}
													}
													?>
											</tbody>
											<tfoot >
								<tr style="border: solid black 2px;"  >
								<td colspan="2" style="text-align: right;"> <b> TOTAL AMOUNT: </b></td>
								<td colspan="1"style="text-align: Center;" > <b><?php echo $QtySum; ?></b></td>
								<td></td>
								<td colspan="1" style="text-align: right;"> <b><?php echo $AmntSum; ?></b></td>
								<td colspan="3" > </td>
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
																			if (isset($_POST['ShowsIMPurchases']))
																				$strDate1=$_POST['txtDateFrom'];
																			else
																				$strDate1=$CurrentDate; //$QueryFD date('Y-m-d');
																			
																			echo "<input type=\"date\" value= \"$strDate1\"  name=\"txtDateFrom\" id=\"tBox\" >";
																			?>
																	</td>
															
																	<td style="text-align: right;"> Date To:</td>
																	<td style="text-align: left;">
																			<?php
																			if (isset($_POST['ShowsIMPurchases']))
																				$strDate2=$_POST['txtDateTo'];
																			else
																				$strDate2= date('Y-m-d');
																			
																			echo "<input type=\"date\" value= \"$strDate2\"  name=\"txtDateTo\" id=\"tBox\">";
																			?>
																	
										 								<input type="submit"  value="Show" name="ShowsIMPurchases" id="Btn" onclick="checkInput()">
																	</td>
																</tr>
																
													</table>
											</form>
													
							</div>
							<table cellpadding="0" cellspacing="0" border="1" class="" id="dbResult">
								<thead>
									<tr>
										<th>Date</th>
										<th>Type</th>
										<th>Quantity</th>
										<th>Rate</th>
										<th>Amount</th>
										<th>Purchased By</th>
										<th>Comments</th>
										<th>Action</th>
									</tr>
								</thead>
											<tbody>
													<?php 
													$AmntSum=0;
													$QtySum=0;
													if (isset($_POST['ShowsIMPurchases']))
													{													
													$sql = mysqli_query($con,"$NewQuery")or die(mysqli_query());
														WHILE($Data=mysqli_fetch_array($sql))
													{
															$Dat=$Data['sDate'];
															$Type= $Data['pSubType'];
															$Qty= $Data['qty'];
															$rat= $Data['rate'];
															$Amnt= $Qty*$rat;
															$user= $Data['User'];
															$Cmnts= $Data['sComments'];
															
															$AmntSum=$AmntSum + $Amnt;
																$QtySum=$QtySum+$Qty;
															$id = $Data['sID'];
															$d=strtotime($Dat);
																	$dtNow=date("d-M-Y", $d);
																	echo "<tr>";
																	echo "<td style=\"text-align: Center;\">". $dtNow ."</td>";
																	echo "<td>".$Type."</td>";
																	echo "<td>".$Qty."</td>";
																	echo "<td>".$rat."</td>";
																	echo "<td style=\"text-align: right;\">". $Amnt ."</td>";
																	echo "<td>". $user ."</td>";
																	echo "<td>".$Cmnts."</td>";
																	if ($currentUserType=="Admin" && $Dat>=$QueryFD && $Dat<=$QueryLD)
																		echo "<td><a onClick=\"javascript: return confirm('Please confirm Deletion');\" href=\"delete/delpurchasesummary.php?ID=".$id."&for=".$pNameHere."\" id=\"LinkBtnDel\">Delete</a></td>";
																	else if($currentUserType=="Manager" && $Dat==date("Y-m-d"))
																		echo "<td><a onClick=\"javascript: return confirm('Please confirm Deletion');\" href=\"delete/delpurchasesummary.php?ID=".$id."&for=".$pNameHere."\" id=\"LinkBtnDel\">Delete</a></td>";
																	else
																		echo "<td></td>";
																	echo "</tr>";
														}
													}
													?>
											</tbody>
											<tfoot >
								<tr style="border: solid black 2px;"  >
								<td colspan="2" style="text-align: right;"> <b> TOTAL AMOUNT: </b></td>
								<td colspan="1"style="text-align: Center;" > <b><?php echo $QtySum; ?></b></td>
								<td></td>
								<td colspan="1" style="text-align: right;"> <b><?php echo $AmntSum; ?></b></td>
								<td colspan="3" > </td>
								</tr>
								</tfoot>
							</table>
						<?php
						}
						
						
						
					else
							
						{
						?>
							
							<table cellpadding="0" cellspacing="0" border="1" class="" id="dbResult">
								<thead>
									<tr>
										<th>ID</th>
										<th>Date</th>
										<th>Action</th>
									</tr>
								</thead>
								
								<!--
								
								<thead>
									<tr>
										<th>ID</th>
										<th>Date</th>
										<th>Type</th>
										<th>Quantity</th>
										<th>Amount</th>
										<th>Comments</th>
										<th>Action</th>
									</tr>
								</thead>
											<tbody>
													<?php 
													$AmntSum=0;
													$QtySum=0;
													$sql = mysqli_query($con,"$NewQuery1")or die(mysqli_query());
														WHILE($Data=mysqli_fetch_array($sql))
													{
															$IDs = $Data['csID'];
															$Dat=$Data['csDate'];
															$Type= $Data['csType'];
															$Qty= $Data['csQty'];
															$Amnt= $Data['csOrgAmnt'];
															$Cmnts= $Data['csComments'];
															
															$AmntSum=$AmntSum + $Amnt;
															$QtySum=$QtySum+$Qty;
														$id = $Data['csID'];
													?>
														
														<tr>
														<!-- <tr class="gradeX del<?php echo $id; ?>" id="<?php echo $id; ?>" > -->
															<td><?php echo $IDs; ?></td>
															<td><?php echo $Dat; ?></td>
															<td><?php echo $Type; ?></td>
															<td><?php echo $Qty; ?></td>
															<td><?php echo $Amnt; ?></td>
															<td><?php echo $Cmnts; ?></td>
															<td><a href="delete/delpaymentsummary.php?ID=<?php echo $id; ?>" id="LinkBtnDel">Delete</a></td>
															
															
														</tr>
													<?php 
													}
													?>
											</tbody>
											<tfoot >
								<tr style="border: solid black 2px;"  >
								<td colspan="3" > <b> TOTAL AMOUNT: </b></td>
								<td colspan="1" > <b><?php echo $QtySum; ?></b></td>
								<td colspan="1" > <b><?php echo $AmntSum; ?></b></td>
								<td colspan="3" > </td>
								</tr>
								</tfoot>
							-->
							
							
							</table>
						<?php
						}
						?>
						
	</div>