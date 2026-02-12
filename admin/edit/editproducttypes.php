<?php
include_once('../includes/dbcon.php');
//include_once('../includes/formula.php');
include_once('../includes/globalvar.php');

$id = $_GET['ID'];
$edit = mysqli_query($con,"SELECT * FROM types WHERE typeid='$id'") or die(mysqli_error());
$emp=mysqli_fetch_array($edit);
$pName=$emp['productName'];
$tName=$emp['typeName'];
$cmnts=$emp['typeComments'];


if (isset($_POST['UpdateSubType']))
	{
	$pName=$_POST['pSelect'];
	$subType=$_POST['txtSubType'];
	$cmnts=$_POST['txtComments'];
	if ($pName== "---")
			{ echo '<script type="text/javascript">alert("Please Select a Product from \"Product List\".");</script>'; }
	else if ($subType=="")
			{ echo '<script type="text/javascript">alert("Please Enter Sub-Type i.e. \"Card Rs. 100\"   or  \"xCite J-100\".");</script>'; }
	else
	{
		$sq = mysqli_query($con,"UPDATE types SET productName='$pName',typeName='$subType',typeComments='$cmnts' WHERE typeID=$id")or die(mysqli_query());
		echo '<script type="text/javascript">alert("Sub-Type Successfully Entered");</script>';
		header("Location: ../addproducttypes.php");
	}
	}
if (isset($_POST['Cancel']))
	header("Location: ../addproducttypes.php");


?>
	<head>
			<title>Edit Subproducts</title>
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
							<center>
								<caption> <h2>Product Sub-types</h2></caption>
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
																							if ($data['pName']==$pName)
																								echo "<option selected>";
																							else
																								echo "<option>";
																							echo $data['pName'];
																							//echo "<br>";
																							echo "</option>";
																						}
																				?>
																			</select>	
																	</td>
																</tr>
																<tr>
																	<td style="text-align: right;" >Product Sub-Type: 
																	</td>
																	<td style="text-align: left;" >
																		 <input type="text" name="txtSubType" value="<?php echo $tName;?>" id="iBox"/> 
																	</td>
																</tr>
																<tr>
																	<td style="text-align: right;" >Comments: 
																	</td>
																	
																	<td style="text-align: left;" >
																		 <input type="text" name="txtComments" value="<?php echo $cmnts ?>" id="iBox"/> 
																	</td>
																</tr>
																<tr>
																	<td style="text-align: right;" >
										 								<input type="submit"  value="Update" name="UpdateSubType" id="Btn">
																	</td>
																	<td style="text-align: left;" >
																		<input type="submit" value="Cancel" name="Cancel" id="Btn">
																	</td>
																</tr>
																
													</table>
											</form>
													
							</div>
	</div>
</html>