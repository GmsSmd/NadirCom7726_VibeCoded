<?php
include_once('../session.php');
include_once('includes/dbcon.php');
include_once('includes/formula.php');
include_once('includes/globalvar.php');
?>
	<head>
			<title>Subproducts</title>
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
								<caption> <h2>Product Sub-Types</h2></caption>
							</center>
							
							<div  style="border: solid black 0px; ">
											<form id="AddReceiptForm" name="AddReceiptForm" action="" method="POST">
													<table cellpadding="0" cellspacing="0" border="0" class="table" id="HeadTable" >
																<tr>
																	<td style="text-align: right;"> Product List:  </td>
																		
																	<td style="text-align: left;" >
																			<select name="pSelect" id="sBox">
																				<option >---</option>
																				<?php
																					$doQ=mysqli_query($con,"SELECT pName from products");
																						while($data=mysqli_fetch_array($doQ))
																						{
																							echo "<option>";
																							echo $data['pName'];
																							//echo "<br>";
																							echo "</option>";
																						}
																				?>
																			</select>	
																	</td>
																	
																	<td style="text-align: right;" >Product Sub-Type: 
																	</td>
																	
																	<td style="text-align: left;" >
																		 <input type="text" name="txtSubType" value="" id="iBox"/> 
																	</td>
																</tr>
																<tr>
																	<td style="text-align: right;" >Comments: 
																	</td>
																	
																	<td style="text-align: left;" >
																		 <input type="text" name="txtComments" value="" id="iBox"/> 
																	</td>
																
																	<td style="text-align: right;" >
										 								<input type="submit"  value="Save" name="SaveSubType" id="Btn">
																	</td>
																	<td style="text-align: left;" >
																		<input type="submit" value="Reset" name="Reset" id="Btn">
																	</td>
																</tr>
																
													</table>
											</form>
													
							</div>
							<table cellpadding="0" cellspacing="0" border="1" class="table table-bordered table-condensed" id="dbResult">
								<thead>
									<tr>
										<th>ID</th>
										<th>Product</th>
										<th>SubProduct</th>
										<th>Comments</th>
										<th>Action</th>
								</thead>
											<tbody>
													<?php 
												$sql = mysqli_query($con,"SELECT * FROM types")or die(mysqli_query());
													WHILE($Data=mysqli_fetch_array($sql))
													{
															$tID = $Data['typeID'];
															$pName=$Data['productName'];
															$tName= $Data['typeName'];
															$tCmnt=$Data['typeComments'];
													$id = $Data['typeID'];
													?>
														
														<tr>
														<!-- <tr class="gradeX del<?php echo $id;?>" id="<?php echo $id; ?>" > -->
															<td><?php echo $tID;?></td>
															<td><?php echo $pName;?></td>
															<td><?php echo $tName;?></td>
															<td><?php echo $tCmnt;?></td>
														
															<td>
															<a href="edit/editproducttypes.php?ID=<?php echo $id;?>" id="LinkBtnEdit">Edit</a>&nbsp;&nbsp;&nbsp;&nbsp;
															<a href="delete/delproducttypes.php?ID=<?php echo $id;?>" id="LinkBtnDel">Delete</a>
															</td>
														
														</tr>
													<?php 
													}
																?>
													
											</tbody>
							</table>
										
						
	</div>
</html>