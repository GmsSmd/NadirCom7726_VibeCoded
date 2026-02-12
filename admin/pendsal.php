<?php
include_once('../session.php');
$Employee = $_GET['name'];
include_once('includes/formula2.php');
include_once('includes/globalvar.php');
if (isset($_POST['AddIntoProfit']))
	{
		$dt=$_POST['txtDate'];
		$Desc=$_POST['txtDesc1'];
		$Amnt=$_POST['txtAmntAdded'];
	
		if($Amnt=="")
		{
			echo '<script type="text/javascript">alert("Plase fill Amount");</script>';
		}
		else
		{
				$columnsToAdd="rpFor,rpDate,rpStatus, rpFromTo, rpAmnt, rpMode";
				$valuesToAdd= " 'SalaryAdd','$dt','ReceivedFrom','SalaryAdd',$Amnt, ''";
					//echo "$columnsToAdd". "<br>"."$valuesToAdd";
				$sq = mysqli_query($con,"INSERT INTO receiptpayment($columnsToAdd) values($valuesToAdd)")or die(mysqli_query());
		}
	}
if (isset($_POST['SubFromProfit']))
	{
		$dt=$_POST['txtDate'];
		$Desc=$_POST['txtDesc2'];
		$Amnt=$_POST['txtAmntSub'];
	
		if($Amnt=="")
		{
			echo '<script type="text/javascript">alert("Plase fill Amount");</script>';
		}
		else
		{
				$columnsToAdd="rpFor,rpDate,rpStatus, rpFromTo, rpAmnt, rpMode";
				$valuesToAdd= " 'Withdraw','$dt','PaidTo','SalarySub',$Amnt, '$defaultBankName'";
					//echo "$columnsToAdd". "<br>"."$valuesToAdd";
				$sq = mysqli_query($con,"INSERT INTO receiptpayment($columnsToAdd) values($valuesToAdd)")or die(mysqli_query());
		}
	}



?>
	<head>
			<title>Profit</title>
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
								<caption> <h2>Salary</h2></caption>
							</center>
				
				
							<div  style="border: solid black 0px; ">
											<form id="" name="" action="" method="POST">
													<table cellpadding="0" cellspacing="0" border="0" class="table" id="HeadTable" >
																<tr>												
																	<td style="text-align: right;">Date:</td>
																	<td style="text-align: left;">
																			<?php
																				$strDate= date('Y-m-d');
																				echo "<input type=\"date\" value= \"$strDate\"  name=\"txtDate\" id=\"tBox\">";
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
																	
																	<td style="text-align: right;" >Add Salary: 
																	</td>
																	
																	<td style="text-align: left;" >
																		 <input type="text" name="txtAmntAdded" value="" id="iBox"/ > 
																	</td>
																	

																	<td style="text-align: right;" >Comments: 
																	</td>
																
																	<td style="text-align: left;" >
																		<input type="text" name="txtDesc1"  id="iBox"/> 
																		<input type="submit"  value="Add Into" name="AddIntoProfit" id="Btn">
																	</td>
																	
																</tr>
																
																<tr>
																	
																	<td style="text-align: right;" >Take Salary: 
																	</td>
																	
																	<td style="text-align: left;" >
																		 <input type="text" name="txtAmntSub" value="" id="iBox"/ autofocus> 
																	</td>
																	

																	<td style="text-align: right;" >Comments: 
																	</td>
																
																	<td style="text-align: left;" >
																		<input type="text" name="txtDesc2"  id="iBox"/> 
																		<input type="submit"  value="Take Amnt" name="SubFromProfit" id="Btn">
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
										<th>Added</th>
										<th>Comments</th>
										<th>Taken</th>
										<th>Comments</th>
										<th>Balance</th>
									</tr>
								</thead>
											<tbody>
											<?php
													$sq5 = mysqli_query($con,"SELECT ocAmnt FROM openingclosing where oMonth='$CurrentMonth' AND ocType='PendSalary' AND ocEmp='Franchise'  ")or die(mysqli_query());
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
															$q=mysqli_query($con,"SELECT sum(rpAmnt),rpNotes FROM receiptpayment WHERE rpFor='SalaryAdd' AND rpDate ='$cd' AND rpStatus='ReceivedFrom' AND rpFromTo='SalaryAdd' ");
															$Data=mysqli_fetch_array($q);
															$amntPaid=$Data['sum(rpAmnt)'];
														echo "<td>".$amntPaid."</td>";
														echo "<td>".$Data['rpNotes']."</td>";
														
															$q=mysqli_query($con,"SELECT sum(rpAmnt),rpNotes FROM receiptpayment WHERE rpFor='Withdraw' AND rpDate ='$cd' AND rpStatus='PaidTo' AND rpFromTo='SalarySub'");
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