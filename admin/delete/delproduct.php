<?php
include_once('../includes/dbcon.php');
include_once('../includes/globalvar.php');
$pid = $_GET['ID'];
$edit = mysqli_query($con,"SELECT * FROM products WHERE pID = '$pid'") or die(mysqli_error());
$product = mysqli_fetch_array($edit);
$name1=$product['pName'];
$desc1=$product['pDescription'];

	if (isset($_POST['Delete']))
	{
		$rid=$pid;
		
		$rsq = mysqli_query($con,"DELETE FROM products WHERE pID = $rid ")or die(mysqli_query());
		
		echo '<script type="text/javascript">alert("Successfully Deleted");</script>';
		
		header("Location: ../addproduct.php");
		exit;
	}
?>
<head>
			<title>Delete Product</title>
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
						<center> <caption> <h2>Edit Product</h2></caption> </center>
						
				<div  style="border: solid black 0px; ">
						
							<form name="f1" action="" method="POST">
									<table cellpadding="0" cellspacing="0" border="0" class="table" id="HeadTable" >
								
											<tr>
													<td style="text-align: right;" >
														Product ID:
													</td>
													<td style="text-align: left;" >
													<input type="text" name="txtID" id="iBox" value="<?php echo $pid; ?>" disabled>
													</td>
												</tr>
									
									
												<tr>
													<td style="text-align: right;" >
														Product Name:
													</td>
													<td style="text-align: left;" >
													<input type="text" name="txtName" id="iBox" value="<?php echo $name1; ?>" disabled>
													</td>
												</tr>
												<tr>
													<td style="text-align: right;" >
														Product Description:
													</td>
													<td style="text-align: left;" >
													<input type="text" name="txtDesc" id="iBox"
													value="<?php echo $desc1; ?>" disabled>
													</td>
												</tr>
												<tr>
													<td colspan="2" style="text-align: center;" > 
														<input type="submit"  value="Delete" name="Delete" id="Btn"> <a href="../addproduct.php"><< back</a>
													</td>
												</tr>
									</table>
							</form>

				</div>
			
	</div>
</html>
