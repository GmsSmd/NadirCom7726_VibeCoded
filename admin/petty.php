<?php
include_once('../session.php');
include_once('includes/dbcon.php');
include_once('includes/variables.php');
include_once('includes/globalvar.php');
	if (isset($_POST['Addit']))
	{
		$dt=$_POST['DT'];
		$typ=$_POST['Tselect'];
		$Amnt=$_POST['txtAmnt'];
		$Cmnt=$_POST['txtCmnt'];
		$mod=$_POST['modeSelect'];
		
if($Amnt=="")
{
	echo '<script type="text/javascript">alert("Plase Enter Amount");</script>';
}
else
{
		if($typ=='AddIntopetty')
		{
			$sq1 = mysqli_query($con,"INSErt INTO petty(date, status, fromTo,type, amnt, comments) values('$dt', 'Add','$mod','petty',$Amnt,'$Cmnt')")or die(mysqli_query());
			
			$columnsToAdd="rpFor,rpDate, rpStatus,rpFromTo, rpAmnt, rpmode, rpNotes";
			$valuesToAdd= " 'Withdraw', '$dt','PaidTo','Petty',$Amnt,'$mod','Shifted to Pettg Cash' ";
			//echo "$columnsToAdd". "<br>"."$valuesToAdd";
			$sq = mysqli_query($con,"INSErt INTO receiptpayment($columnsToAdd) values($valuesToAdd)")or die(mysqli_query());
		}
		else
		{
			$sq1 = mysqli_query($con,"INSErt INTO petty(date, status, fromTo,type, amnt, comments) values('$dt', 'Sub','$mod','petty',$Amnt,'$Cmnt')")or die(mysqli_query());
			
			$columnsToAdd="rpFor,rpDate, rpStatus, rpAmnt, rpmode, rpNotes";
			$valuesToAdd= " 'petty', '$dt','ReceivedFrom',$Amnt,'$mod','Received From Petty Cash' ";
			//echo "$columnsToAdd". "<br>"."$valuesToAdd";
			$sq = mysqli_query($con,"INSErt INTO receiptpayment($columnsToAdd) values($valuesToAdd)")or die(mysqli_query());
		
		}
		echo '<script type="text/javascript">alert("Successfully Entered");</script>';
}	
		
	
	}
?>
<head>
			<title>Petty Cash</title>
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
						<center> <caption> <h2>Petty Cash Management</h2></caption> </center>
						
				<div  style="border: solid black 0px; ">
						
							<form name="f1" action="" method="POST">
									<table cellpadding="0" cellspacing="0" border="0" class="table" id="HeadTable" >
												<tr>
													<td style="text-align: center;" >
														Date:
														<?php
															$strDate= date('Y-m-d');
															echo "<input type=\"date\" value= \"$strDate\"  name=\"DT\" id=\"tBox\">";
														?>
														Type: 
															<select name="Tselect" id="sBox">
																<option>AddIntopetty</option>
																<option>SubtractFrompetty</option>
															</select>
														Source:
															<select name="modeSelect" id="sBox"/>
																<option >Cash</option>
																<?php
																	$doQ=mysqli_query($con,"SELECT Name from company WHERE Type='BNK' ");
																	while($data=mysqli_fetch_array($doQ))
																	{
																		//if ($data['Name']==$_POST['modeSelect'] )
																		if ($data['Name']==$defaultBankName )
																			echo "<option selected>";
																		else
																			echo "<option>";
																		echo $data['Name'];
																		echo "</option>";
																	}
																?>
															</select>
														Amount:
														<input type="text" name="txtAmnt" id="iBox">
														Comments:
														<input type="text" name="txtCmnt" id="iBox">
														<input type="submit"  value="Save" name="Addit" id="Btn">
													</td>
												</tr>
									</table>
							</form>
<br>
								
									
													<table cellpadding="0" cellspacing="0" border="1" class="" id="dbResult">
													<tr >
														<td colspan="4" > 
														<center>
														<h2> Details</h2>
														</center>
														</td>
														<td> Opening Balance: </td>
														<?php
														echo "<td>";
														$qq=mysqli_query($con,"SELECT ocAmnt From openingclosing WHERE ocType='Petty Cash' AND oMonth='$CurrentMonth' ");
														$Data=mysqli_fetch_array($qq);
															echo $Data['ocAmnt'];
														echo "</td>";
														?>
													</tr>
													<tr>
														<th>Date</th>
														<th>Activity</th>
														<th>From / To</th>
														<th>Amount</th>
														<th>Comments</th>
														<th>Action</th>
													</tr>
												<?php
																							
													$sql = mysqli_query($con,"SELECT * FROM petty WHERE date BETWEEN '$QueryFD' AND '$QueryLD' ")or die(mysqli_query());
														WHILE($Data=mysqli_fetch_array($sql))
															{ 
																$id = $Data['id'];
															?>
															
															<tr>
																<td><?php echo $Data['date']; ?></td>
																<td><?php echo $Data['status']; ?></td>
																<td><?php echo $Data['fromTo']; ?></td>
																<td><?php echo $Data['amnt']; ?></td>
																<td><?php echo $Data['comments']; ?></td>
																														
																<td><a href="delete/delpetty.php?ID=<?php echo $id;?>" id="LinkBtnDel">Delete</a></td>
															
															</tr>
															<?php 
															}
													?>
													</table>
													
							</div>
			
	</div>
</html>
