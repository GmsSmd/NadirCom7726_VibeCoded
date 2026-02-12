<?php
include_once('../session.php');
include_once('includes/variables.php');
include_once('includes/dbcon.php');
include_once('includes/globalvar.php');
if (isset($_POST['Savecomission']))
	{
		$dateNow=$_POST['txtDate'];
				if ($dateNow=="")
					$dateNow=date('Y-m-d');
		$type=$_POST['typeselect'];
		$emp=$_POST['empSelect'];
		$Amnt=$_POST['txtAmnt'];
		$Cmnt=$_POST['txtComments'];
		if ($Amnt=="")
			{ echo '<script type="text/javascript">alert("Please Enter any amount in \"comission Amount\" box.");</script>'; }
		else
		{
		    if($type=="Other Comission")
		    {
		        $sq = mysqli_query($con,"INSErt INTO comission(comDate,rp, comType, comEmp, comAmnt, comComments) values('$dateNow','Received', '$type','$emp' ,$Amnt, '$Cmnt' )")or die(mysqli_query());
		        $sq1 = mysqli_query($con,"INSErt INTO receiptpayment(rpFor,rpDate,rpStatus,rpFromTo, rpAmnt,rpmode,rpNotes,rpUser) values('Comission','$dateNow', 'ReceivedFrom', 'Company', $Amnt, '$defaultBankName','$Cmnt','$currentUser')")or die(mysqli_query());
		        echo '<script type="text/javascript">alert("comission Rs. '.$Amnt.' successfully added.");</script>';
		    }
		    else
		    {
		        $sq = mysqli_query($con,"INSErt INTO comission(comDate,rp, comType, comEmp, comAmnt, comComments) values('$dateNow','Received', '$type','$emp' ,$Amnt, '$Cmnt' )")or die(mysqli_query());
		        echo '<script type="text/javascript">alert("comission Rs. '.$Amnt.' successfully added.");</script>';
		    }
		}
		
	}







?>
	<head>
			<title>Get Comission</title>
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
								<caption> <h2>Comission Received</h2></caption>
							</center>
							
							<div  style="border: solid black 0px; ">
											<form id="" name="" action="" method="POST">
													<table cellpadding="0" cellspacing="0" border="0" class="table" id="HeadTable" >
																<tr>
																	<td style="text-align: right;" > 
																		Date:
																	</td>
																	<td style="text-align: left;" >
																				<?php
																					$strDate= date('Y-m-d');
																					echo "<input type=\"date\" value= \"$strDate\"  name=\"txtDate\" id=\"tBox\">";
																				?>
																	</td>
																	
																	<td style="text-align: right;"> Comission Type:  </td>
																		
																	<td style="text-align: left;" >
																			<select name="typeselect" id="sBox">
																				<option selected >MFS Comission</option>
																				<option >Other Comission</option>
																			</select>	
																	</td>
																</tr>
																<tr>		
																	<td style="text-align: right;"> From/To:  </td>
																		
																	<td style="text-align: left;" >
																			<select name="empSelect" id="sBox">
																				<option >---</option>
																				<?php
																					$doQ=mysqli_query($con,"SELECT Name from company WHERE Type='CO' ");
																						while($data=mysqli_fetch_array($doQ))
																						{
																							if($data['Name']==$parentCompany)
																								echo "<option selected>";
																							else
																								echo "<option>";
																							echo $data['Name'];
																							echo "<br>";
																							echo "</option>";
																						}
																				?>
																			</select>	
																	</td>
																
																	<td style="text-align: right;" >Comission Amount: 
																	</td>
																	
																	<td style="text-align: left;" >
																		 <input type="text" name="txtAmnt" value="" id="iBox"/ autofocus> 
																	</td>
																</tr>
																<tr>
																	<td style="text-align: right;" >Comments: 
																	</td>
																	
																	<td style="text-align: left;" >
																		 <input type="text" name="txtComments" value="" id="iBox"/> 
																	</td>
																
																	<td colspan ="2" style="text-align: center;" >
										 								<input type="submit"  value="Save" name="Savecomission" id="Btn">
																	</td>
																</tr>
																
													</table>
											</form>
													
							</div>
							<table cellpadding="0" cellspacing="0" border="1" class="table table-bordered table-condensed" id="dbResult">
								<thead>
									<tr>
										<th>ID</th>
										<th>Type</th>
										<th>From/To</th>
										<th>Amount</th>
										<th>Comments</th>
										<th>Action</th>
								</thead>
											<tbody>
													<?php 
													$dateNow1=date('Y-m-d');
													$sum=0;
													$sql = mysqli_query($con,"SELECT * FROM comission WHERE comDate= '$dateNow1' AND rp='Received' ")or die(mysqli_query());
													WHILE($Data=mysqli_fetch_array($sql))
													{
															$ID = $Data['comID'];
															$type=$Data['comType'];
															$Name= $Data['comEmp'];
															$Amnt= $Data['comAmnt'];
															$Cmnt=$Data['comComments'];
															$sum=$sum+$Amnt;
													$id = $Data['comID'];
													?>
														
														<tr>
															<td><?php echo $ID; ?></td>
															<td><?php echo $type; ?></td>
															<td><?php echo $Name; ?></td>
															<td><?php echo $Amnt; ?></td>
															<td><?php echo $Cmnt; ?></td>
														
															<td>
															<a href="delete/delcomissionget.php?ID=<?php echo $id; ?>" id="LinkBtnDel">Delete</a>
															</td>
														
														</tr>
													<?php 
													}
													?>
													
											</tbody>
											<tfoot >
								<tr style="border: solid black 2px;"  >
								<td colspan="3" > <b> TOTAL AMOUNT: </b></td>
								<td colspan="3" > <b><?php echo $sum; ?></b></td>
								</tr>
								</tfoot>
											
							</table>
	</div>
</html>