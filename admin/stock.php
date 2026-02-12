<?php
include_once('../session.php');
$pNameHere = $_GET['for'];
$StartDate='';
$EndDate='';
include_once('includes/formula1.php');
include_once('includes/globalvar.php');
?>
<head>
			<title>Stock</title>
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
								<caption> <h2>Stock Summary</h2></caption>
							</center>
							
			<div style="border: solid black 0px;" align="center" class="doBar">
					<?php
						$doQ=mysqli_query($con,"SELECT pName from products WHERE pName!='Otar' AND pName!='mfs' ");
						while($data=mysqli_fetch_array($doQ))
							{
								$name=$data['pName'];
								if($name== $pNameHere)
									$nm='doLinkSelected';
								else
									$nm='doLink';
								?>
								<a href="stock.php?for=<?php echo $name;?>" id="<?php echo $nm;?>" class="button">
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
																						$doQ=mysqli_query($con,"SELECT EmpName from empinfo ORDER BY EmpName ASC");
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
																				$strDate1=$QueryFD; // date('Y-m-d');
																			
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
																		$Cmnts= $Data['loadComments'];
																		$AmntSum=$AmntSum + $Amnt;
																	$id = $Data['loadID'];
																?>
																	
																	<tr>
																		<td style="text-align: Center;"><?php $d=strtotime($Dat); echo date("d-M-Y", $d); ?></td>
																		<td style="text-align: Left;"><?php echo $thisEmp; ?></td>
																		<td style="text-align: right;"> <?php echo $Amnt; ?></td>
																		<td><?php echo $Cmnts; ?></td>
																		<td><a href="delete/delsalesummary.php?ID=<?php echo $id; ?>&for=<?php echo $pNameHere; ?>" id="LinkBtnDel">Delete</a></td>
																	</tr>
																<?php 
																}
													}
													?>
											</tbody>
											<tfoot >
								<tr style="border: solid black 2px;"  >
								<td colspan="2" style="text-align: Right;" > <b> TOTAL AMOUNT: </b></td>
								<td colspan="1" style="text-align: right;" > <b><?php echo $AmntSum; ?></b></td>
								<td colspan="2" > </td>
								
								</tr>
								</tfoot>
							</table>
						<?php
						}
			else if($pNameHere=='mfs')
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
																						$doQ=mysqli_query($con,"SELECT EmpName from empinfo ORDER BY EmpName ASC");
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
																				$strDate1=$QueryFD; // date('Y-m-d');
																			
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
							<table cellpadding="0" cellspacing="0" border="1" class="" id="dbResult">
								<thead>
									<tr>
										
										<th>Date</th>
										<th>Employee</th>
										<th>Amount</th>
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
																		$Cmnts= $Data['mfsComments'];
																		
																		$AmntSum=$AmntSum + $Amnt;
																	$id = $Data['mfsID'];
																?>
																	
																	<tr>
																		<td style="text-align: Center;"><?php $d=strtotime($Dat); echo date("d-M-Y", $d); ?></td>
																		<td style="text-align: Left;"><?php echo $thisEmp; ?></td>
																		<td style="text-align: right;"> <?php echo $Amnt; ?></td>
																		<td><?php echo $Cmnts; ?></td>
																		<td><a href="delete/delsalesummary.php?ID=<?php echo $id; ?>&for=<?php echo $pNameHere; ?>" id="LinkBtnDel">Delete</a></td>
																		
																		
																	</tr>
																<?php 
																}
													}
													?>
											</tbody>
											<tfoot >
								<tr style="border: solid black 2px;"  >
								<td colspan="2" style="text-align: Right;" > <b> TOTAL AMOUNT: </b></td>
								<td colspan="1" style="text-align: right;" > <b><?php echo $AmntSum; ?></b></td>
								<td colspan="2" > </td>
								
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
																	<td style="text-align: right;"> Date From:</td>
																	<td style="text-align: left;">
																			<?php
																			if (isset($_POST['Showstock']))
																				$strDate1=$_POST['txtDateFrom'];
																			else
																				$strDate1=$QueryFD; // date('Y-m-d');
																			
																			echo "<input type=\"date\" value= \"$strDate1\"  name=\"txtDateFrom\" id=\"tBox\" >";
																			?>
																	</td>
															
																	<td style="text-align: right;"> Date To:</td>
																	<td style="text-align: left;">
																			<?php
																			if (isset($_POST['Showstock']))
																				$strDate2=$_POST['txtDateTo'];
																			else
																				$strDate2= date('Y-m-d');
																			
																			echo "<input type=\"date\" value= \"$strDate2\"  name=\"txtDateTo\" id=\"tBox\">";
																			?>
																	
										 								<input type="submit"  value="Show" name="Showstock" id="Btn" >
																	</td>
																</tr>
																
													</table>
											</form>
													
							</div>
							<table cellpadding="0" cellspacing="0" border="1" class="" id="dbResult">
								<thead>
								<tr>
										<th rowspan="2">Type</th>
										<th colSpan="3">Opening</th>
										<th colSpan="3">Purchase</th>
										<th colSpan="3">Sale</th>
										<th colSpan="2">Closing</th>
										<th rowspan="2">Collection</th>
									</tr>
									<tr>
									
										<th>Qty</th>
											<th>Rate</th>
												<th>Amount</th>
										<th>Qty</th>
											<th>Rate</th>
												<th>Amount</th>
										<th>Qty</th>
											<th>Avg Rate</th>
												<th>Amount</th>
										<th>Qty</th>
											<th>Amount</th>
									
									</tr>
								</thead>
											<tbody>
													<?php 
													$opQtySum=0;
													$opAmntSum=0;
													$pQtySum=0;
													$pAmntSum=0;
													$sQtySum=0;
													$sAmntSum=0;
													$cQtySum=0;
													$cAmntSum=0;
													$colSum=0;
													if (isset($_POST['Showstock']))
													{													
													$sql = mysqli_query($con,"SELECT typeName FROM types WHERE productName='Card' AND isActive=1")or die(mysqli_query());
													WHILE($Data=mysqli_fetch_array($sql))
														
													
														{
															$subType=$Data['typeName'];
															echo "<tr>";
															echo "<td>";
																	echo $subType;
															echo "</td>";
																	$q = mysqli_query($con,"SELECT * from openingclosing WHERE ocType= 'Card' AND oMonth='$CurrentMonth' AND ocEmp='$subType' ORDER BY ocID DESC LIMIT 1 ")or die(mysqli_query());	
																		$d=mysqli_fetch_array($q);
																	$open=$d['ocAmnt'];
																	
															echo "<td>";		
																	echo $open;
															echo "</td>";		
																	$q = mysqli_query($con,"SELECT purchasePrice from rates WHERE pName= 'Card' AND spName='$subType' ORDER BY rtID DESC LIMIT 1 ")or die(mysqli_query());	
																		$r=mysqli_fetch_array($q);
																		$rt1=$r['purchasePrice'];
															echo "<td>";
																	echo $rt1;
															echo "</td>";
															echo "<td>";
																		$opAmnt=$open * $rt1;
																	echo $opAmnt;
															echo "</td>";
																	$q = mysqli_query($con,"SELECT sum(csQty) from tbl_cards WHERE csType='$subType' AND csStatus='Received' AND csDate BETWEEN '$StartDate' AND '$EndDate'  ")or die(mysqli_query());	
																		$d=mysqli_fetch_array($q);
																	$purchz=$d['sum(csQty)'];
															echo "<td>";		
																	echo $purchz;
															echo "</td>";
															echo "<td>";
																	echo $rt1;
															echo "</td>";
															echo "<td>";
																		$prAmnt=$purchz*$rt1;
																	echo $prAmnt;
															echo "</td>";
																		$slAmnt=0;
																		$qt2=0;
																		$rt2=0;
																		$sumrt=0;
																		$cnt=0;
																		$avgrt=0;
																		$q = mysqli_query($con," SELECT sum(csQty), avg(csRate) from tbl_cards WHERE csType='$subType' AND csStatus='Sent' AND csDate BETWEEN '$StartDate' AND '$EndDate' ")or die(mysqli_query());	
																		WHILE($d=mysqli_fetch_array($q))
																			{
																			$qt2=$qt2+$d['sum(csQty)'];
																			$rt2=$d['avg(csRate)'];
																			$sumrt=$sumrt+$rt2;
																			$cnt=$cnt+1;
																			}
															echo "<td>";
																	echo $qt2;
															echo "</td>";
																		if($cnt>0)
																			$avgrt=$sumrt/$cnt;
															echo "<td>";
																	echo round($avgrt,2);
															echo "</td>";
															
															echo "<td>";
																			$slAmnt=$qt2*$avgrt;
																	echo round($slAmnt,2);
															echo "</td>";
																	$cl=$open + $purchz - $qt2;
															echo "<td>";
																	echo $cl;
															echo "</td>";
															echo "<td>";
																	$clAmnt=$cl*$rt1;
																	echo round($clAmnt,2);
															echo "</td>";
															
															echo "</tr>"; 
														
														$opQtySum=$opQtySum + $open;
														$opAmntSum=$opAmntSum + $opAmnt;
														$pQtySum=$pQtySum + $purchz;
														$pAmntSum=$pAmntSum + $prAmnt;
														$sQtySum=$sQtySum + $qt2;
														$sAmntSum=$sAmntSum + $slAmnt;
														$cQtySum=$cQtySum + $cl;
														$cAmntSum=$cAmntSum + $clAmnt;
														
														
														
														}
														
													}
													$q = mysqli_query($con,"SELECT sum(rpAmnt) from receiptpayment WHERE rpFor='Card' AND rpStatus='ReceivedFrom' AND rpDate BETWEEN '$StartDate' AND '$EndDate'  ")or die(mysqli_query());	
													$d=mysqli_fetch_array($q);
													$colSum=$d['sum(rpAmnt)'];
									
													?>
											</tbody>
						
											<tfoot >
								<tr style="border: solid black 2px;"  >
										<td colspan="1" style="text-align: right;"> <b> TOTAL AMOUNT: </b></td>
										<td> <b><?php echo $opQtySum; ?></b></td>
										<td> <b></b></td>
										<td> <b><?php echo $opAmntSum; ?></b></td>
										<td> <b><?php echo $pQtySum; ?></b></td>
										<td> <b></b></td>
										<td> <b><?php echo $pAmntSum; ?></b></td>
										<td> <b><?php echo $sQtySum; ?></b></td>
										<td> <b></b></td>
										<td> <b><?php echo round($sAmntSum,2); ?></b></td>
										<td> <b><?php echo $cQtySum; ?></b></td>
										<td> <b><?php echo $cAmntSum; ?></b></td>
										<td> <b><?php echo $colSum; ?></b></td>
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
																	<td style="text-align: right;"> Date From:</td>
																	<td style="text-align: left;">
																			<?php
																			if (isset($_POST['Showstock']))
																				$strDate1=$_POST['txtDateFrom'];
																			else
																				$strDate1=$QueryFD; // date('Y-m-d');
																			
																			echo "<input type=\"date\" value= \"$strDate1\"  name=\"txtDateFrom\" id=\"tBox\" >";
																			?>
																	</td>
															
																	<td style="text-align: right;"> Date To:</td>
																	<td style="text-align: left;">
																			<?php
																			if (isset($_POST['Showstock']))
																				$strDate2=$_POST['txtDateTo'];
																			else
																				$strDate2= date('Y-m-d');
																			
																			echo "<input type=\"date\" value= \"$strDate2\"  name=\"txtDateTo\" id=\"tBox\">";
																			?>
																	
										 								<input type="submit"  value="Show" name="Showstock" id="Btn" >
																	</td>
																</tr>
																
													</table>
											</form>
													
							</div>
							<table cellpadding="0" cellspacing="0" border="1" class="" id="dbResult">
								<thead>
								<tr>
										<th rowspan="2">Type</th>
										<th colSpan="3">Opening</th>
										<th colSpan="3">Purchase</th>
										<th colSpan="3">Sale</th>
										<th colSpan="2">Closing</th>
										<th rowspan="2">Collection</th>
									</tr>
									<tr>
									
										<th>Qty</th>
											<th>Rate</th>
												<th>Amount</th>
										<th>Qty</th>
											<th>Rate</th>
												<th>Amount</th>
										<th>Qty</th>
											<th>Avg Rate</th>
												<th>Amount</th>
										<th>Qty</th>
											<th>Amount</th>
									
									</tr>
								</thead>
											<tbody>
													<?php 
													$opQtySum=0;
													$opAmntSum=0;
													$pQtySum=0;
													$pAmntSum=0;
													$sQtySum=0;
													$sAmntSum=0;
													$cQtySum=0;
													$cAmntSum=0;
													$colSum=0;
													if (isset($_POST['Showstock']))
													{													
													$sql = mysqli_query($con,"SELECT typeName FROM types WHERE productName='Mobile' AND isActive=1")or die(mysqli_query());
													WHILE($Data=mysqli_fetch_array($sql))
														
													
														{
															$subType=$Data['typeName'];
															echo "<tr>";
															echo "<td>";
																	echo $subType;			// showing product name in first column
															echo "</td>";
															
																							// getting opening stock
																	$q = mysqli_query($con,"SELECT * from openingclosing WHERE ocType= 'Mobile' AND oMonth='$CurrentMonth' AND ocEmp='$subType' ORDER BY ocID DESC LIMIT 1 ")or die(mysqli_query());	
																		$d=mysqli_fetch_array($q);
																	$open=$d['ocAmnt'];
															echo "<td>";		
																	echo $open;
															echo "</td>";		
															
															
																							// getting purchase price
																	$q = mysqli_query($con,"SELECT purchasePrice from rates WHERE pName= 'Mobile' AND spName='$subType' ORDER BY rtID DESC LIMIT 1 ")or die(mysqli_query());	
																		$r=mysqli_fetch_array($q);
																		$rt1=$r['purchasePrice'];
															echo "<td>";
																	echo $rt1;
															echo "</td>";
															echo "<td>";
																		$opAmnt=$open * $rt1;
																	echo $opAmnt;
															echo "</td>";
															
																							// getting purchases during current month
																	$q = mysqli_query($con,"SELECT sum(qty) from tbl_product_stock WHERE pSubType='$subType' AND trtype='Received' AND sDate BETWEEN '$StartDate' AND '$EndDate'  ")or die(mysqli_query());	
																		$d=mysqli_fetch_array($q);
																	$purchz=$d['sum(qty)'];
															echo "<td>";		
																	echo $purchz;
															echo "</td>";
															echo "<td>";
																	echo $rt1;
															echo "</td>";
															echo "<td>";
																		$prAmnt=$purchz*$rt1;
																	echo $prAmnt;
															echo "</td>";
																		$slAmnt=0;
																		$Sumqt2=0;
																		$Sumrt2=0;
																		$sumrt=0;
																		$sum=0;
																		$cnt=0;
																		$avgrt=0;
																						// getting sale quantity, sale rate and sale amount
																		$q = mysqli_query($con,"SELECT * from tbl_product_stock WHERE pSubType='$subType' AND trtype='Sent' AND sDate BETWEEN '$StartDate' AND '$EndDate'  ")or die(mysqli_query());	
																		WHILE($d=mysqli_fetch_array($q))
																			{
																			$qt2=0;
																			$rt2=0;
																			$qt2=$d['qty'];
																			$rt2=$d['rate'];
																			$sumrt=$sumrt+$rt2;
																			$sum=$sum+($qt2*$rt2);
																			
																			$cnt=$cnt+1;
																			$Sumqt2=$Sumqt2+$qt2;
																			$rt2=0;
																			}
															echo "<td>";
																	echo $Sumqt2;
															echo "</td>";
																		if($cnt>0)
																			$avgrt=$sumrt/$cnt;
															echo "<td>";
																	echo round($avgrt,2);
															echo "</td>";
															
															echo "<td>";
																			//$slAmnt=$qt2*$avgrt;
																			$slAmnt=$sum;
																	echo round($slAmnt,2);
															echo "</td>";
																	$cl=$open + $purchz - $Sumqt2;
															echo "<td>";
																	echo $cl;
															echo "</td>";
															echo "<td>";
																	$clAmnt=$cl*$rt1;
																	echo round($clAmnt,2);
															echo "</td>";
															
															echo "</tr>"; 
														
														$opQtySum=$opQtySum + $open;
														$opAmntSum=$opAmntSum + $opAmnt;
														$pQtySum=$pQtySum + $purchz;
														$pAmntSum=$pAmntSum + $prAmnt;
														$sQtySum=$sQtySum + $Sumqt2;
														$sAmntSum=$sAmntSum + $slAmnt;
														$cQtySum=$cQtySum + $cl;
														$cAmntSum=$cAmntSum + $clAmnt;
														
														}
														
													}
													$q = mysqli_query($con,"SELECT sum(rpAmnt) from receiptpayment WHERE rpFor='Mobile' AND rpStatus='ReceivedFrom' AND rpDate BETWEEN '$StartDate' AND '$EndDate'  ")or die(mysqli_query());	
													$d=mysqli_fetch_array($q);
													$colSum=$d['sum(rpAmnt)'];
													?>
											</tbody>
						
											<tfoot >
								<tr style="border: solid black 2px;"  >
										<td colspan="1" style="text-align: right;"> <b> TOTAL AMOUNT: </b></td>
										<td> <b><?php echo $opQtySum; ?></b></td>
										<td> <b></b></td>
										<td> <b><?php echo $opAmntSum; ?></b></td>
										<td> <b><?php echo $pQtySum; ?></b></td>
										<td> <b></b></td>
										<td> <b><?php echo $pAmntSum; ?></b></td>
										<td> <b><?php echo $sQtySum; ?></b></td>
										<td> <b></b></td>
										<td> <b><?php echo round($sAmntSum,2); ?></b></td>
										<td> <b><?php echo $cQtySum; ?></b></td>
										<td> <b><?php echo $cAmntSum; ?></b></td>
										<td> <b><?php echo $colSum; ?></b></td>
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
																	<td style="text-align: right;"> Date From:</td>
																	<td style="text-align: left;">
																			<?php
																			if (isset($_POST['Showstock']))
																				$strDate1=$_POST['txtDateFrom'];
																			else
																				$strDate1=$QueryFD; // date('Y-m-d');
																			
																			echo "<input type=\"date\" value= \"$strDate1\"  name=\"txtDateFrom\" id=\"tBox\" >";
																			?>
																	</td>
															
																	<td style="text-align: right;"> Date To:</td>
																	<td style="text-align: left;">
																			<?php
																			if (isset($_POST['Showstock']))
																				$strDate2=$_POST['txtDateTo'];
																			else
																				$strDate2= date('Y-m-d');
																			
																			echo "<input type=\"date\" value= \"$strDate2\"  name=\"txtDateTo\" id=\"tBox\">";
																			?>
																	
										 								<input type="submit"  value="Show" name="Showstock" id="Btn" >
																	</td>
																</tr>
																
													</table>
											</form>
													
							</div>
							<table cellpadding="0" cellspacing="0" border="1" class="" id="dbResult">
								<thead>
								<tr>
										<th rowspan="2">Type</th>
										<th colSpan="3">Opening</th>
										<th colSpan="3">Purchase</th>
										<th colSpan="3">Sale</th>
										<th colSpan="2">Closing</th>
										<th rowspan="2">Collection</th>
									</tr>
									<tr>
									
										<th>Qty</th>
											<th>Rate</th>
												<th>Amount</th>
										<th>Qty</th>
											<th>Rate</th>
												<th>Amount</th>
										<th>Qty</th>
											<th>Avg Rate</th>
												<th>Amount</th>
										<th>Qty</th>
											<th>Amount</th>
									
									</tr>
								</thead>
											<tbody>
											<?php 
													$opQtySum=0;
													$opAmntSum=0;
													$pQtySum=0;
													$pAmntSum=0;
													$sQtySum=0;
													$sAmntSum=0;
													$cQtySum=0;
													$cAmntSum=0;
													$colSum=0;
													if (isset($_POST['Showstock']))
													{													
													$sql = mysqli_query($con,"SELECT typeName FROM types WHERE productName='SIM' AND isActive=1")or die(mysqli_query());
													WHILE($Data=mysqli_fetch_array($sql))
														
													
														{
															$subType=$Data['typeName'];
															echo "<tr>";
															echo "<td>";
																	echo $subType;			// showing product name in first column
															echo "</td>";
															
																							// getting opening stock
																	$q = mysqli_query($con,"SELECT * from openingclosing WHERE ocType= 'SIM' AND oMonth='$CurrentMonth' AND ocEmp='$subType' ORDER BY ocID DESC LIMIT 1 ")or die(mysqli_query());	
																		$d=mysqli_fetch_array($q);
																	$open=$d['ocAmnt'];
															echo "<td>";		
																	echo $open;
															echo "</td>";		
															
															
																							// getting purchase price
																	$q = mysqli_query($con,"SELECT purchasePrice from rates WHERE pName= 'SIM' AND spName='$subType' ORDER BY rtID DESC LIMIT 1 ")or die(mysqli_query());	
																		$r=mysqli_fetch_array($q);
																		$rt1=$r['purchasePrice'];
															echo "<td>";
																	echo $rt1;
															echo "</td>";
															echo "<td>";
																		$opAmnt=$open * $rt1;
																	echo $opAmnt;
															echo "</td>";
															
																							// getting purchases during current month
																	$q = mysqli_query($con,"SELECT sum(qty) from tbl_product_stock WHERE pSubType='$subType' AND trtype='Received' AND sDate BETWEEN '$StartDate' AND '$EndDate'  ")or die(mysqli_query());	
																		$d=mysqli_fetch_array($q);
																	$purchz=$d['sum(qty)'];
															echo "<td>";		
																	echo $purchz;
															echo "</td>";
															echo "<td>";
																	echo $rt1;
															echo "</td>";
															echo "<td>";
																		$prAmnt=$purchz*$rt1;
																	echo $prAmnt;
															echo "</td>";
																		$slAmnt=0;
																		$Sumqt2=0;
																		$Sumrt2=0;
																		$sumrt=0;
																		$sum=0;
																		$cnt=0;
																		$avgrt=0;
																						// getting sale quantity, sale rate and sale amount
																		$q = mysqli_query($con,"SELECT * from tbl_product_stock WHERE pSubType='$subType' AND trtype='Sent' AND sDate BETWEEN '$StartDate' AND '$EndDate'  ")or die(mysqli_query());	
																		WHILE($d=mysqli_fetch_array($q))
																			{
																			$qt2=0;
																			$rt2=0;
																			$qt2=$d['qty'];
																			$rt2=$d['rate'];
																			$sumrt=$sumrt+$rt2;
																			$sum=$sum+($qt2*$rt2);
																			
																			$cnt=$cnt+1;
																			$Sumqt2=$Sumqt2+$qt2;
																			$rt2=0;
																			}
															echo "<td>";
																	echo $Sumqt2;
															echo "</td>";
																		if($cnt>0)
																			$avgrt=$sumrt/$cnt;
															echo "<td>";
																	echo round($avgrt,2);
															echo "</td>";
															
															echo "<td>";
																			//$slAmnt=$qt2*$avgrt;
																			$slAmnt=$sum;
																	echo round($slAmnt,2);
															echo "</td>";
																	$cl=$open + $purchz - $Sumqt2;
															echo "<td>";
																	echo $cl;
															echo "</td>";
															echo "<td>";
																	$clAmnt=$cl*$rt1;
																	echo round($clAmnt,2);
															echo "</td>";
															
															echo "</tr>"; 
														
														$opQtySum=$opQtySum + $open;
														$opAmntSum=$opAmntSum + $opAmnt;
														$pQtySum=$pQtySum + $purchz;
														$pAmntSum=$pAmntSum + $prAmnt;
														$sQtySum=$sQtySum + $Sumqt2;
														$sAmntSum=$sAmntSum + $slAmnt;
														$cQtySum=$cQtySum + $cl;
														$cAmntSum=$cAmntSum + $clAmnt;
														
														}
														
													}
													$q = mysqli_query($con,"SELECT sum(rpAmnt) from receiptpayment WHERE rpFor='SIM' AND rpStatus='ReceivedFrom' AND rpDate BETWEEN '$StartDate' AND '$EndDate'  ")or die(mysqli_query());	
													$d=mysqli_fetch_array($q);
													$colSum=$d['sum(rpAmnt)'];
													?>
											
											
											
											
													<?php 
													
											/*
													$opQtySum=0;
													$opAmntSum=0;
													$pQtySum=0;
													$pAmntSum=0;
													$sQtySum=0;
													$sAmntSum=0;
													$cQtySum=0;
													$cAmntSum=0;
													$colSum=0;
													if (isset($_POST['Showstock']))
													{													
													$sql = mysqli_query($con,"SELECT typeName FROM types WHERE productName='SIM'")or die(mysqli_query());
													WHILE($Data=mysqli_fetch_array($sql))
														
													
														{
															$subType=$Data['typeName'];
															echo "<tr>";
															echo "<td>";
																	echo $subType;
															echo "</td>";
																	$q = mysqli_query($con,"SELECT * from openingclosing WHERE ocType= 'SIM' AND oMonth='$CurrentMonth' AND ocEmp='$subType' ORDER BY ocID DESC LIMIT 1 ")or die(mysqli_query());	
																		$d=mysqli_fetch_array($q);
																	$open=$d['ocAmnt'];
															echo "<td>";		
																	echo $open;
															echo "</td>";		
																	$q = mysqli_query($con,"SELECT purchasePrice from rates WHERE pName= 'SIM' AND spName='$subType' ORDER BY rtID DESC LIMIT 1 ")or die(mysqli_query());	
																		$r=mysqli_fetch_array($q);
																		$rt1=$r['purchasePrice'];
															echo "<td>";
																	echo $rt1;
															echo "</td>";
															echo "<td>";
																		$opAmnt=$open * $rt1;
																	echo $opAmnt;
															echo "</td>";
																	$q = mysqli_query($con,"SELECT sum(qty) from tbl_product_stock WHERE pSubType='$subType' AND trtype='Received' AND sDate BETWEEN '$StartDate' AND '$EndDate'  ")or die(mysqli_query());	
																		$d=mysqli_fetch_array($q);
																	$purchz=$d['sum(qty)'];
															echo "<td>";		
																	echo $purchz;
															echo "</td>";
															echo "<td>";
																	echo $rt1;
															echo "</td>";
															echo "<td>";
																		$prAmnt=$purchz*$rt1;
																	echo $prAmnt;
															echo "</td>";
																		$slAmnt=0;
																		$qt2=0;
																		$rt2=0;
																		$sumrt=0;
																		$cnt=0;
																		$avgrt=0;
																		$q = mysqli_query($con,"SELECT * from tbl_product_stock WHERE pSubType='$subType' AND trtype='Sent' AND sDate BETWEEN '$StartDate' AND '$EndDate'  ")or die(mysqli_query());	
																		WHILE($d=mysqli_fetch_array($q))
																			{
																			$qt2=$qt2+$d['qty'];
																			$rt2=$d['rate'];
																			$slAmnt=$slAmnt+($qt2*$rt2);
																			$sumrt=$sumrt+$rt2;
																			$cnt=$cnt+1;
																			}
															echo "<td>";
																	echo $qt2;
															echo "</td>";
																		if($cnt>0)
																			$avgrt=$sumrt/$cnt;
															echo "<td>";
																	echo round($avgrt,2);
															echo "</td>";
															
															echo "<td>";
																			//$slAmnt=$qt2*$avgrt;
																	echo round($slAmnt,2);
															echo "</td>";
																	$cl=$open + $purchz - $qt2;
															echo "<td>";
																	echo $cl;
															echo "</td>";
															echo "<td>";
																	$clAmnt=$cl*$rt1;
																	echo round($clAmnt,2);
															echo "</td>";
															
															echo "</tr>"; 
														
														$opQtySum=$opQtySum + $open;
														$opAmntSum=$opAmntSum + $opAmnt;
														$pQtySum=$pQtySum + $purchz;
														$pAmntSum=$pAmntSum + $prAmnt;
														$sQtySum=$sQtySum + $qt2;
														$sAmntSum=$sAmntSum + $slAmnt;
														$cQtySum=$cQtySum + $cl;
														$cAmntSum=$cAmntSum + $clAmnt;
														
														
														
														}
														
													}
													$q = mysqli_query($con,"SELECT sum(rpAmnt) from receiptpayment WHERE rpFor='SIM' AND rpStatus='ReceivedFrom' AND rpDate BETWEEN '$StartDate' AND '$EndDate'  ")or die(mysqli_query());	
													$d=mysqli_fetch_array($q);
													$colSum=$d['sum(rpAmnt)'];
									*/
													?>
											</tbody>
						
											<tfoot >
								<tr style="border: solid black 2px;"  >
										<td colspan="1" style="text-align: right;"> <b> TOTAL AMOUNT: </b></td>
										<td> <b><?php echo $opQtySum; ?></b></td>
										<td> <b></b></td>
										<td> <b><?php echo $opAmntSum; ?></b></td>
										<td> <b><?php echo $pQtySum; ?></b></td>
										<td> <b></b></td>
										<td> <b><?php echo $pAmntSum; ?></b></td>
										<td> <b><?php echo $sQtySum; ?></b></td>
										<td> <b></b></td>
										<td> <b><?php echo round($sAmntSum,2); ?></b></td>
										<td> <b><?php echo $cQtySum; ?></b></td>
										<td> <b><?php echo $cAmntSum; ?></b></td>
										<td> <b><?php echo $colSum; ?></b></td>
								</tr>
								</tfoot>
						
							</table>
						<?php
						}
						
						
						
					else
					echo "<h2>Select an option then press \"Show\" Button</h2>";
						?>
						
	</div>