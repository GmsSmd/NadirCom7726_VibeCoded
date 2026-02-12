<?php
include_once('../session.php');
include_once('includes/variables.php');
include_once('includes/globalvar.php');


	if (isset($_POST['addtax']))
	{
	
		$jnDate=$_POST['Date'];
		$Amnt=$_POST['txtAmnt'];
		$Bank=$_POST['Tselect'];
		
		if($Bank=='---')
			echo '<script type="text/javascript">alert("Please Select a Bank from list.");</script>';
		else if($Amnt=='')
			echo '<script type="text/javascript">alert("Please Enter Amount.");</script>';
		else
		{
		//$sq = mysqli_query($con,"INSErt INTO tax(taxDate,taxAmnt,source) values('$jnDate', $Amnt, '$Bank')")or die(mysqli_query());
		$sq1 = mysqli_query($con,"INSErt INTO receiptpayment(rpFor,rpDate,rpStatus,rpFromTo, rpAmnt,rpmode) values('tax','$jnDate', 'PaidTo', 'tax', $Amnt, '$Bank')")or die(mysqli_query());
		echo '<script type="text/javascript">alert("tax successfully entered.");</script>';
		
		//echo $nm ." successfully added.";
		}
	}
?>
<head>
			<title>Tax</title>
			<style>
			<?php
			include_once('styles/navbarstyle.php');
			include_once('styles/tablestyle.php');
			include_once('includes/navbar.php');
			?>
			</style>
	</head>
	<div class="container" align="center">
						<center> <caption> <h2>Tax Payment</h2></caption> </center>
						
				<div  style="border: solid black 0px; ">
						
							<form name="f1" action="" method="POST">
									<table cellpadding="0" cellspacing="0" border="0" class="table" id="HeadTable" >
												<tr>
													<td style="text-align: right;" > 
														Date:
													</td>
													<td style="text-align: left;" >
																<?php
																	$strDate= date('Y-m-d');
																	echo "<input type=\"date\" value= \"$strDate\"  name=\"Date\" id=\"tBox\">";
																?>
													</td>
												</tr>
												<tr>	
													<td style="text-align: right;"> Paid From: </td>
													<td style="text-align: left;" >
															<select name="Tselect" id="sBox">
																	<option >---</option>
																	<?php
																		$doQ=mysqli_query($con,"SELECT Name from company WHERE type='BNK' ");
																		while($data=mysqli_fetch_array($doQ))
																			{
																				//if($data['Name']==$Bank)
																				if($data['Name']==$defaultBankName)
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
														Amount:
													</td>
													<td style="text-align: left;" >
													<input type="text" name="txtAmnt" id="iBox" autofocus>
												</tr>
												<tr>
													<td></td>
													<td style="text-align: left;" >
														<input type="submit"  value="Add tax" name="addtax" id="Btn">
													</td>
												</tr>
									</table>
							</form>
<br>
								
									
									<table cellpadding="0" cellspacing="0" border="1" class="" id="dbResult">
											<thead>
												<tr >
													<th>ID</th>
													<th>Date</th>
													<th>Paid From</th>
													<th>Paid Amount</th>
													<th>Action</th>
												</tr>
											</thead>
											<tbody>
												<?php
												$sm=0;
													$sql = mysqli_query($con,"SELECT * FROM receiptpayment WHERE rpFor='tax' AND rpStatus='PaidTo' AND rpDate BETWEEN '$QueryFD' AND '$QueryLD' ")or die(mysqli_query());
														WHILE($Data=mysqli_fetch_array($sql))
															{ 
															$id = $Data['rpID'];
															$sm=$sm+$Data['rpAmnt'];
															?>
															<tr>
																<td><?php echo $Data['rpID']; ?></td>
																<td>	<?php 
																		$tm=strtotime($Data['rpDate']);
																		echo date("d-M-Y", $tm);
																		?>
																</td>
																<td><?php echo $Data['rpMode']; ?></td>
																<td><?php echo $Data['rpAmnt']; ?></td>
																<td> <a href="delete/deltax.php?ID=<?php echo $id; ?>" id="LinkBtnDel">Delete</a></td>
															</tr>
															<?php 
															}
													?>
											</tbody>
											<tfoot >
													<tr style="border: solid black 1px;"  >
													<td colspan="3" > <b> TOTAL: </b></td>
													<td colspan="2" > <b><?php echo $sm; ?></b></td>
													</tr>
											</tfoot>
									</table>
													
							</div>
			
	</div>
</html>
