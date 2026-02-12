<?php
include_once('../includes/dbcon.php');
include_once('../includes/globalvar.php');

$eid = $_GET['ID'];
$edit = mysqli_query($con,"SELECT * FROM company WHERE ID = '$eid'") or die(mysqli_error());
$emp = mysqli_fetch_array($edit);
$name1=$emp['Name'];
$Cmnt1=$emp['Comments'];
$type=$emp['Type'];
	
	if (isset($_POST['Update']))
	{
		$nm=$_POST['txtName'];
		$Cmnt=$_POST['txtComments'];
		$type=$_POST['Tselect'];
		$sq = mysqli_query($con,"UPDATE company SET Name='$nm', Comments= '$Cmnt', Type='$type' WHERE ID = '$eid' ")or die(mysqli_query());
		//echo $nm ." successfully added.";
		echo '<script type="text/javascript">alert("'. $name1 .' Successfully Updated");</script>';

		header("Location: ../addcompany.php");
		exit;
	}
?>
<head>
			<title>Edit company</title>
			<style>
			<?php
			include_once('../styles/navbarstyle.php');
			include_once('../styles/tablestyle.php');
			?>
			</style>
	</head>
			
		<?php
			include_once('../includes/navbar.php');
		?>

	<div class="container" align="center">
						<center> <caption> <h2>Edit company</h2></caption> </center>
						
				<div  style="border: solid black 0px; ">
						
							<form name="f1" action="" method="POST">
									<table cellpadding="0" cellspacing="0" border="0" class="table" id="HeadTable" >
												<tr>
												<td style="text-align: right;" >
														ID:
													</td>
													<td style="text-align: left;" >
													<input type="text" name="txtID" id="iBox" value="<?php echo $eid; ?>" disabled>
													</td>
												</tr>
												<tr>
												<td style="text-align: right;"> Type: </td>
													<td style="text-align: left;" >
															<select name="Tselect" id="sBox">
																	<option >---</option>
																	<?php
																		$doQ=mysqli_query($con,"SELECT abbvr from abbvr WHERE type='Co' ");
																		while($data=mysqli_fetch_array($doQ))
																			{
																				if($data['abbvr']==$type)
																					echo "<option selected>";
																				else
																					echo "<option>";
																				
																				echo $data['abbvr'];
																				echo "</option>";
																			}
																	?>
															</select>
													</td>
												</tr>
												
												<tr>
													<td style="text-align: right;" >
														Name:
													</td>
													<td style="text-align: left;" >
													<input type="text" name="txtName" id="iBox" value="<?php echo $name1; ?>">
													</td>
												</tr>
											
												<tr>
													<td style="text-align: right;" > 
														Comments:
													</td>
													<td style="text-align: left;" >
													<input type="text" name="txtComments" id="iBox" value="<?php echo $Cmnt1; ?>">
													</td>
												</tr>
												<tr>
													<td colspan="2" style="text-align: center;" > 
														<input type="submit"  value="Update" name="Update" id="Btn">  <a href="../addcompany.php"><< back</a>
													</td>
												</tr>
									</table>
							</form>	
			</div>
			
	</div>
</html>
