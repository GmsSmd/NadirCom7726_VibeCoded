<?php
include_once('../session.php');
include_once('includes/dbcon.php');
include_once('includes/variables.php');
include_once('includes/globalvar.php');

	if (isset($_POST['AddIntoIncomeExp']))
	{
		$dt=$_POST['DT'];
		$Desc=$_POST['txtDesc'];
		$Amnt=$_POST['txtAmnt'];
	
		if($Amnt=="" OR $Desc=="")
		{
			echo '<script type="text/javascript">alert("Plase fill both fields");</script>';
		}
		else
		{
				$columnsToAdd="expDate,type, description,amnt";
				$valuesToAdd= " '$dt','profit','$Desc',$Amnt";
					//echo "$columnsToAdd". "<br>"."$valuesToAdd";
				$sq = mysqli_query($con,"INSErt INTO incomeexp($columnsToAdd) values($valuesToAdd)")or die(mysqli_query());
		}
	}
?>
<head>
			<title>Profit</title>
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
						<center> <caption> <h2>Profit Management</h2></caption> </center>
						
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
														Description:
														<input type="text" name="txtDesc" id="iBox">
														Amount:
														<input type="text" name="txtAmnt" id="iBox">
														<input type="submit"  value="Save" name="AddIntoIncomeExp" id="Btn">
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
													$sql = mysqli_query($con,"SELECT * FROM incomeexp WHERE type='profit' AND expDate BETWEEN '$QueryFD' AND '$QueryLD'")or die(mysqli_query());
														WHILE($Data=mysqli_fetch_array($sql))
															{ 
																$id = $Data['id'];
																
															?>
															
															<tr>
																<td><?php echo $Data['expDate']; ?></td>
																<td><?php echo $Data['description']; ?></td>
																<td><?php echo $Data['amnt']; ?></td>
																<td><a href="delete/delexp.php?ID=<?php echo $id;?>" id="LinkBtnDel">Delete</a></td>
															
															</tr>
															
															<?php 
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
