<?php
include_once('../session.php');
//$pNameHere = $_GET['for'];
include_once('includes/formula1.php');
include_once('includes/globalvar.php');
$strQuery="SELECT * FROM tbl_initiator_query WHERE recorddate BETWEEN '$CurrentDate' AND '$CurrentDate' ORDER BY ref_id ASC";
	if (isset($_POST['ShowMFSTr']))
		{
			$strDateStart=$_POST['txtDateFrom'];
			$strDateEnd=$_POST['txtDateTo'];
			$employe=$_POST['EmpSelect'];
			$strQuery="SELECT * FROM tbl_initiator_query WHERE do_name='$employe' AND recorddate BETWEEN '$strDateStart' AND '$strDateEnd' ORDER BY ref_id ASC";
			if($employe=='---')
				$strQuery="SELECT * FROM tbl_initiator_query WHERE recorddate BETWEEN '$strDateStart' AND '$strDateEnd' ORDER BY ref_id ASC ";
		}
?>
<head>
			<title>Initiator Query Entries</title>
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
                						<th>Tr ID</th>
                						<th>MSISDN</th>
                						<th>Name</th>
                						<th>Benificiary Name</th>
                						<th>Benificiary Number</th>
                						<th>Tr Type</th>
                						<th>Tr Effect</th>
                						<th>Tr Amount</th>
                						<th>DO Name</th>
                						<th>Tr Time</th>
                						<th>Status</th>
                						<th>Action</th> 
									    
										
									</tr>
								</thead>
											<tbody>
													<?php 
																$sql = mysqli_query($con,"$strQuery")or die(mysqli_query());
																	WHILE($Data=mysqli_fetch_array($sql))
																{
																	$id=$Data['ref_id'];
																	$Dat=$Data['recorddate'];
																	
																	echo "<tr>";
																	    echo "<td>".$Data['tx_id'] ."</td>";
																	    echo "<td>".$Data['initiator_msisdn'] ."</td>";
																	    echo "<td>".$Data['initiator_organization'] ."</td>";
																	    echo "<td>".$Data['beneficiary_name'] ."</td>";
																	   
																	   
                                        								    $nm=$Data['beneficiary_name'];
                                        								    $ddddoooo=$Data['do_name'];
                                            								    $qury2=mysqli_query($con,"SELECT * FROM retailers WHERE do_name='$ddddoooo' AND retailer_shop_name='$nm';")or die(mysqli_query());
                                                								$data2=mysqli_fetch_array($qury2);
                                                								$numbr=$data2['number'];
                                                								if($numbr!='' and $Data['beneficiary_name']!="$orgnization_name")
                                                								    echo "<td>".$numbr."</td>";
                                                								else if($numbr=='' and $Data['beneficiary_name']=="$orgnization_name")
                                                								    echo "<td>".$Data['initiator_msisdn']."</td>";
                                                								else
                                                								    echo "<td>Walking Customer</td>";
																	   
																	   //if($Data['tx_type']!="Transfer(B2B)" AND $Data['beneficiary_name']!="PAARIS COMMUNICATION")
																	   //{
																	   /*}
																	   else
																	   {
																	       echo "<td></td>";
																	   }*/
                                                						echo "<td>".$Data['tx_type'] ."</td>";
                                                						echo "<td>".$Data['tx_effect'] ."</td>";
                                                						echo "<td>".$Data['tx_amount'] ."</td>";
                                                						echo "<td>".$Data['do_name'] ."</td>";
                                                                        echo "<td>".$Data['recorddate']."</td>";
                                                                        echo "<td>".$Data['addstatus'] ."</td>";
                                        							
    																	if ($currentUserType=="Admin" && $Dat>=$QueryFD && $Dat<=$QueryLD)
    																		echo "<td><a onClick=\"javascript: return confirm('Please confirm Deletion');\" href=\"delete/delmfstrs_iq.php?ID=".$id."\" id=\"LinkBtnDel\">Delete</a></td>";
    																	else if($currentUserType=="Manager" && $Dat==date("Y-m-d"))
    																		echo "<td><a onClick=\"javascript: return confirm('Please confirm Deletion');\" href=\"delete/delmfstrs_iq.php?ID=".$id."\" id=\"LinkBtnDel\">Delete</a></td>";
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