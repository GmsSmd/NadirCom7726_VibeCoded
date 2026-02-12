<?php
include_once('../session.php');
$Employee = $_GET['name'];
include_once('includes/dbcon.php');
include_once('includes/variables.php');
include_once('includes/globalvar.php');

if($Employee=="do" or $Employee=="DO")
		echo '<script type="text/javascript">alert("Please First Select a DO then perform additional working.");</script>';
else
	{

		if (isset($_POST['Savecomission']))
		{
			$dateNow=$_POST['txtDate'];
					if ($dateNow=="")
						$dateNow=date('Y-m-d');
			$type=$_POST['typeselect'];
			$emp=$Employee;
			//$emp=$_POST['empSelect'];
			$Amnt=$_POST['txtAmnt'];
			$Cmnt=$_POST['txtComments'];
			if ($Amnt=="")
				{ echo '<script type="text/javascript">alert("Please Enter any amount in \"comission Amount\" box.");</script>'; }
			else
			{
			$sq = mysqli_query($con,"INSErt INTO comission(comDate,rp, comType, comEmp, comAmnt, comComments) values('$dateNow','Paid', '$type','$emp' ,$Amnt, '$Cmnt' )")or die(mysqli_query());
			echo '<script type="text/javascript">alert("comission Rs. '.$Amnt.' successfully added.");</script>';
			}
			
		}
	}
?>
	<head>
			<title>Salary Deduction</title>
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
								<caption> <h2>Salary Deduction</h2></caption>
							</center>
				<div style="border: solid black 0px;" align="center" class="doBar">
					<?php
						//$doQ=mysqli_query($con,"SELECT EmpName from empinfo Where empType!='Fr'");
						$doQ=mysqli_query($con,"SELECT EmpName from empinfo WHERE EmpStatus='Active' AND (empType='DO' OR empType='SP' OR empType='ws') Order by sort_order ASC");
						while($data=mysqli_fetch_array($doQ))
							{
								$name=$data['EmpName'];
								if($name== $Employee)
									$nm='doLinkSelected';
								else
									$nm='doLink';
								?>
								<a href="salarydeduction.php?name=<?php echo $name;?>" id="<?php echo $nm;?>" class="button">
								<?php
								echo $data['EmpName']."</a>";
							}
					?>
				</div>
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
																	
																	<td style="text-align: right;"> Deduction Type:  </td>
																		
																	<td style="text-align: left;" >
																			<select name="typeselect" id="sBox">
																				<option selected>Salary Deduction</option>
																			</select>	
																	</td>
																</tr>
																<tr>	
																	<td style="text-align: right;" >Deduction Amount: 
																	</td>
																	
																	<td style="text-align: left;" >
																		 <input type="text" name="txtAmnt" value="" id="iBox"/ autofocus> 
																	</td>
																
																	<td style="text-align: right;" >Comments: 
																	</td>
																	
																	<td style="text-align: left;" >
																		 <input type="text" name="txtComments" value="" id="iBox"/> 
																	</td>
																</tr>
																<tr>
																	<td colspan ="4" style="text-align: center;" >
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
													$sql = mysqli_query($con,"SELECT sum(comAmnt) FROM comission WHERE rp='Jun-2019' AND comType='Salary Deduction' AND comEmp='$Employee'")or die(mysqli_query());
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
															<a href="delete/delcomissionpaid.php?ID=<?php echo $id; ?>&name=<?php echo $Employee;?>" id="LinkBtnDel">Delete</a>
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