<?php
include_once('../session.php');
$bank = $_GET['for'];

$StartDate='';
$EndDate='';
include_once('includes/formula1.php');
include_once('includes/globalvar.php');
?>
<head>
			<title>Bank</title>
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
								<caption> <h2>Bank Statement for Month: <?php echo $CurrentMonth; ?></h2></caption>
							</center>
							
			<div style="border: solid black 0px;" align="center" class="doBar">
					<?php
						$doQ=mysqli_query($con,"SELECT Name from company WHERE Type='BNK' ");
						while($data=mysqli_fetch_array($doQ))
							{
								$name=$data['Name'];
								if($name== $bank)
									$nm='doLinkSelected';
								else
									$nm='doLink';
								?>
								<a href="bankstatementdowisefull.php?for=<?php echo $name;?>" id="<?php echo $nm;?>" class="button">
								<?php
								echo $data['Name']."</a>";
							}
					?>
			</div>
			<div  style="border: solid black 0px; ">
											<!--
											
											<form  action="" method="POST">
													<table cellpadding="0" cellspacing="0" border="0" class="table" id="headTable" >
														<tr>
																	<td style="text-align: right;"> Date From:</td>
																	<td style="text-align: left;">
																			<?php
																			if (isset($_POST['Showstock']))
																				$strDate1=$_POST['txtDateFrom'];
																			else
																				$strDate1= date('Y-m-d');
																			
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
											-->
													
							</div>
							<table cellpadding="0" cellspacing="0" border="1" class="" id="dbResult">
								<thead>
									<tr>
										<th>Name</th>
										<th>Deposit</th>
										<th>Withdraw</th>
										<th>Total</th>
									</tr>
								</thead>
								<tbody>
				<?php 
					$doQ=mysqli_query($con,"SELECT EmpName from empinfo WHERE EmpStatus='Active' AND (empType='DO' OR empType='SP' OR empType='ws') Order by sort_order ASC ");
						while($data=mysqli_fetch_array($doQ))
							{
								$emp=$data['EmpName'];
								echo "<tr>";
									
									echo "<td style=\"text-align: center;\">";
										echo $emp;
									echo "</td>";
								
								
								
										$q=mysqli_query($con," SELECT sum(rpAmnt) FROM receiptpayment WHERE rpStatus='ReceivedFrom' AND rpFromTo='$emp' AND rpMode='$bank' AND rpDate BETWEEN '$QueryFD' AND '$QueryLD' ");
										$Data=mysqli_fetch_array($q);
										$amntDeposit=$Data['sum(rpAmnt)'];
									echo "<td>".$amntDeposit."</td>";
									
										$q=mysqli_query($con," SELECT sum(rpAmnt) FROM receiptpayment WHERE rpStatus='PaidTo' AND rpFromTo='$emp' AND rpMode='$bank' AND rpDate BETWEEN '$QueryFD' AND '$QueryLD' ");
										$Data=mysqli_fetch_array($q);
										$amntWDraw=$Data['sum(rpAmnt)'];
									echo "<td>".$amntWDraw."</td>";
										$orgDeposit=$amntDeposit-$amntWDraw;
									echo "<td>".$orgDeposit."</td>";
								
								
							}
																
																
												/*
												
													$sq6 = mysqli_query($con,"SELECT ocAmnt FROM openingclosing where oMonth='$CurrentMonth' AND ocType='Cash' AND ocEmp='$NameHere'  ")or die(mysqli_query());
													$Data6=mysqli_fetch_array($sq6);
													
													$Opening=$Data6['ocAmnt'];
														$depositSum=0; $wDrawsum=0; $paySum=0; $orgDepositSum=0;
														for($i=$date_from; $i<=$date_to; $i+=86400)
														{
														echo "<tr>";
																	$cd=date("Y-m-d", $i);
																echo "<td style=\"text-align: center;\">";
																	echo date("d-M-Y", $i);
																echo "</td>";
																
																
																echo "<td>".$Opening."</td>";
																

																	$q=mysqli_query($con,"SELECT sum(rpAmnt) FROM receiptpayment WHERE rpDate ='$cd' AND rpStatus='ReceivedFrom' AND rpmode='$NameHere' ");
																	$Data=mysqli_fetch_array($q);
																	$amntDeposit=$Data['sum(rpAmnt)'];
																
																
																echo "<td>".$amntDeposit."</td>";
																
																	$q=mysqli_query($con,"SELECT sum(rpAmnt) FROM receiptpayment WHERE rpDate ='$cd' AND rpFor='Withdraw' AND rpStatus='PaidTo' AND rpmode='$NameHere' ");
																	$Data=mysqli_fetch_array($q);
																	$amntWDraw=$Data['sum(rpAmnt)'];
																echo "<td>".$amntWDraw."</td>";
																	$orgDeposit=$amntDeposit-$amntWDraw;
																
																echo "<td>".$orgDeposit."</td>";
																
																
																	$q=mysqli_query($con,"SELECT sum(rpAmnt) FROM receiptpayment WHERE rpDate ='$cd' AND rpFor!='Withdraw' AND rpStatus='PaidTo' AND rpmode='$NameHere' ");
																	$Data=mysqli_fetch_array($q);
																	$amntPay=$Data['sum(rpAmnt)'];
																echo "<td>".$amntPay."</td>";
																
																		$closing= ($Opening+$amntDeposit)-($amntWDraw+$amntPay);
																echo "<td>".$closing."</td>";
																
																
																$Opening=$closing;
														echo "</tr>";
													$depositSum=$depositSum+$amntDeposit;
													$orgDepositSum=$orgDepositSum+$orgDeposit;
													$wDrawsum=$wDrawsum+$amntWDraw;
													$paySum= $paySum+$amntPay;
													
													}*/
												?>
								</tbody>
						
											<tfoot >
											<!--
												<tr style="border: solid black 2px;"  >
														<td colspan="1" style="text-align: right;"> <b> TOTAL AMOUNT: </b></td>
														<td> <b><?php echo $Data6['ocAmnt']; ?></b></td>
														<td> <b><?php echo $depositSum; ?></b></td>
														<td> <b><?php echo $wDrawsum; ?></b></td>
														<td> <b><?php echo $orgDepositSum; ?></b></td>
														<td> <b><?php echo $paySum; ?></b></td>
														<td> <b><?php echo $closing; ?></b></td>
												</tr>
											-->
											</tfoot>
						
							</table>
	</div>