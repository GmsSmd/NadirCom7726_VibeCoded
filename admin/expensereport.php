<?php
include_once('../session.php');
include_once('includes/dbcon.php');
include_once('includes/variables.php');
include_once('includes/globalvar.php');

	if (isset($_POST['showReport']))
	{
		$query_date=$_POST['DT'];
		$strDate=$_POST['DT'];
		$QueryFD= date('Y-m-01', strtotime($query_date));
		$QueryLD=date('Y-m-t', strtotime($query_date));
	}else{
	    $strDate= date('Y-m-d');
	}
?>
<head>
			<title>Expenses</title>
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
						<center> <caption> <h2>Expense Report</h2></caption> </center>
						
				<div  style="border: solid black 0px; ">
						
							<form name="f1" action="" method="POST">
									<table cellpadding="0" cellspacing="0" border="0" class="table" id="HeadTable" >
												<tr>
													<td style="text-align: center;" >
														Date:
														<?php
															//$strDate= date('Y-m-d');
															echo "<input type='date' value= '$strDate'  name='DT' id='tBox'>";
														?>
														<input type="submit"  value="Show" name="showReport" id="Btn">
													</td>
												</tr>
									</table>
							</form>
<br>
								
									
		<table cellpadding="0" cellspacing="0" border="1" class="" id="dbResult">
													<tr >
														<td colspan="6" > 
														<center>
														<h2> Details</h2>
														</center>
														</td>
													</tr>
													<tr>
														<th>Date</th>
														<th>Description</th>
														<th>Amount</th>
														<th>Action</th>
													</tr>
												<?php
															$sum=0;								
													$sql = mysqli_query($con,"SELECT * FROM regularexp WHERE  type='expense' AND expDate BETWEEN '$QueryFD' AND '$QueryLD'")or die(mysqli_query());
														WHILE($Data=mysqli_fetch_array($sql))
															{ 
																$id = $Data['id'];
															$Dates=$Data['expDate'];
															
															echo "<tr>";
															echo "<td>".$Data['expDate']."</td>";
															echo "<td>".$Data['description']."</td>";
															echo "<td>".$Data['amnt']."</td>";

																//	if ($currentUserType=="Admin")
																//		echo "<td><a onClick=\"javascript: return confirm('Please confirm Deletion');\" href=\"delete/delexp.php?ID=".$id."\"id=\"LinkBtnDel\">Delete</a></td>";
																//	else if($currentUserType=="Manager" && $Dates==date("Y-m-d"))
																//		echo "<td><a onClick=\"javascript: return confirm('Please confirm Deletion');\" href=\"delete/delexp.php?ID=".$id."\"id=\"LinkBtnDel\">Delete</a></td>";
																//	else
																		echo "<td></td>";
																	echo "</tr>";	
															$sum=$sum+$Data['amnt'];
															}
													?>
				<tfoot >
					<tr style="border: solid black 2px;"  >
						<td colspan="2" style="text-align: right;"> <b> TOTAL AMOUNT: </b></td>
						<td colspan="2" style="text-align: left;"> <b><?php echo $sum; ?></b></td>
					</tr>
				</tfoot>

		</table>
													
							</div>
			
	</div>
</html>
