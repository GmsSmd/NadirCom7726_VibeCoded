<?php
include_once('../session.php');
//$pNameHere = $_GET['for'];
include_once('includes/formula1.php');
include_once('includes/globalvar.php');
$strQuery="SELECT * FROM mfstransactions WHERE recorddate BETWEEN '$CurrentDate' AND '$CurrentDate' ORDER BY trid ASC";
	if (isset($_POST['ShowMFSTr']))
		{
			$strDateStart=$_POST['txtDateFrom'];
			$strDateEnd=$_POST['txtDateTo'];
			$employe=$_POST['EmpSelect'];
			$strQuery="SELECT * FROM mfstransactions WHERE doname='$employe' AND recorddate BETWEEN '$strDateStart' AND '$strDateEnd' ORDER BY trid ASC";
			if($employe=='---')
				$strQuery="SELECT * FROM mfstransactions WHERE recorddate BETWEEN '$strDateStart' AND '$strDateEnd' ORDER BY trid ASC ";
		}
?>
<head>
			<title>MFS Details</title>
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
								<caption> <h2>MFS Transactions</h2></caption>
							</center>
	
			
							<div  style="border: solid black 0px; ">
											<form  action="" method="POST">
													<table cellpadding="0" cellspacing="0" border="0" class="table" id="headTable" >
														<tr>
																	<td style="text-align: right;"> Employee: </td>
																	<td style="text-align: left;" >
																			<select name="EmpSelect" id="sBox">
																					<option >---</option>
																					<?php
																						$doQ=mysqli_query($con,"SELECT * from empinfo WHERE EmpStatus='Active' Order by sort_order ASC");
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
																			if (isset($_POST['ShowMFSTr']))
																				$strDate1=$_POST['txtDateFrom'];
																			else
																				$strDate1= $CurrentDate; //$QueryFD date('Y-m-d');
																			
																			echo "<input type=\"date\" value= \"$strDate1\"  name=\"txtDateFrom\" id=\"tBox\" >";
																			?>
																	</td>
															
																	<td style="text-align: right;"> Date To:</td>
																	<td style="text-align: left;">
																			<?php
																			if (isset($_POST['ShowMFSTr']))
																				$strDate2=$_POST['txtDateTo'];
																			else
																				$strDate2= date('Y-m-d');
																			
																			echo "<input type=\"date\" value= \"$strDate2\"  name=\"txtDateTo\" id=\"tBox\">";
																			?>
																	
										 								<input type="submit"  value="Show" name="ShowMFSTr" id="Btn" onclick="checkInput()">
																	</td>
																</tr>
																
													</table>
											</form>
													
							</div>
							<table cellpadding="0" cellspacing="0" border="1" class="" id="dbResult">
								<thead>
									<tr>
										
										<th>DO Name</th>
										<th>Tr Date</th>
										<th>Tr ID</th>
										<th>MSISDN</th>
										<th>Tr Type</th>
										<th>Tr Amount</th>
										<th>Portal Time</th>
										<th>Action</th>
									</tr>
								</thead>
											<tbody>
													<?php 
																$sql = mysqli_query($con,"$strQuery")or die(mysqli_query());
																	WHILE($Data=mysqli_fetch_array($sql))
																{
																	$id=$Data['mfstrid'];
																	$Dat=$Data['recorddate'];
																	echo "<tr>";
																	echo "<td>".$Data['doname'] ."</td>";
																	echo "<td>".$Data['recorddate'] ."</td>";
																	echo "<td>".$Data['trid']."</td>";
																	echo "<td>".$Data['orgmsisdn']."</td>";
																	echo "<td>".$Data['trtype']."</td>";
																	echo "<td>".$Data['tramnt']."</td>";
																	echo "<td>".$Data['trtime']."</td>";
																	//if ($currentUserType=="Admin")
																	if ($currentUserType=="Admin" && $Dat>=$QueryFD && $Dat<=$QueryLD)
																		echo "<td><a onClick=\"javascript: return confirm('Please confirm Deletion');\" href=\"delete/delmfstrs.php?ID=".$id."\" id=\"LinkBtnDel\">Delete</a></td>";
																	else if($currentUserType=="Manager" && $Dat==date("Y-m-d"))
																		echo "<td><a onClick=\"javascript: return confirm('Please confirm Deletion');\" href=\"delete/delmfstrs.php?ID=".$id."\" id=\"LinkBtnDel\">Delete</a></td>";
																	else
																		echo "<td></td>";
																	echo "</tr>";
																}
													?>
											</tbody>
											<!-- <tfoot >
								<tr style="border: solid black 2px;"  >
								<td colspan="2" style="text-align: Right;" > <b> TOTAL AMOUNT: </b></td>
								<td colspan="1" style="text-align: right;" > <b><?php echo $AmntSum; ?></b></td>
								<td colspan="3" > </td>
								
								</tr>
								</tfoot> -->
							</table>
	</div>