<?php
include_once('../session.php');
include_once('includes/variables.php');
include_once('includes/dbcon.php');
include_once('includes/globalvar.php');
if (isset($_POST['SaveChangedData']))
	{
		foreach ($_POST['emID'] as $idx => $stuff)
		{
			if($_POST['choice'][$stuff]=="Yes")
			{
				$sq = mysqli_query($con,"UPDATE types SET isActive=1 WHERE typeID = $stuff ")or die(mysqli_query());
			}
			else{
				$sq = mysqli_query($con,"UPDATE types SET isActive=0 WHERE typeID = $stuff ")or die(mysqli_query());
			}
		}
	echo '<script type="text/javascript">alert("Successfully Updated");</script>';
	}

?>
	<head>
			<title>Mark Active Sub-Products</title>
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
								<caption> <h2>Mark Active Sub-Products</h2></caption>
							</center>
							
			<div  style="border: solid black 0px; ">		
							
						<form method="POST">
							
							<table cellpadding="0" cellspacing="0" border="1" class="table table-bordered table-condensed" id="dbResult">
								<thead>
									<tr>
										<th>ID</th>
										<th>Product</th>
										<th>SubProduct</th>
										<th>Comments</th>
										<th>Active</th>
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
															echo "<tr>";
															//echo "<td>".$tID."</td>";
															echo "<td>";
														?>
														
															<input style="border: none; background: transparent;" type="text" name="emID[]" id="iBox3" value="<?php echo $tID; ?>" hidden><?php echo $Data['typeID']; ?></td>
														<?php
														//echo '<input style=\"border: none; background: transparent;\" type=\"text\" name=\"emID[]\" id="iBox3" value='.$tID.' hidden>'.$tID.'</td>';
														echo "<td>".$pName."</td>";
															echo "<td>".$tName."</td>";
															echo "<td>".$tCmnt."</td>";
															echo "<td>";
															if($Data['isActive']!=0)
															{	
																echo "<input type=\"radio\" name=\"choice[$id]\" id=\"choice\" value=\"Yes\" checked>Yes";
																echo "<input type=\"radio\" name=\"choice[$id]\" id=\"choice\" value=\"No\" >No";
															}
															else
															{
																echo "<input type=\"radio\" name=\"choice[$id]\" id=\"choice\" value=\"Yes\">Yes";
																echo "<input type=\"radio\" name=\"choice[$id]\" id=\"choice\" value=\"No\" checked>No";
															}
															echo "</td>";
														echo "</tr>";
													}
													?>
													<tr><td colspan="5" style="text-align: center;">
													<input type="submit"  value="Save" name="SaveChangedData" id="Btn">
													</td></tr>
								</tbody>
							</table>
						</form>
			</div>
	</div>
</html>