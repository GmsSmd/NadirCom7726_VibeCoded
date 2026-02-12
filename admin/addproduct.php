<?php
include_once('../session.php');
include_once('includes/variables.php');
include_once('includes/dbcon.php');
include_once('includes/globalvar.php');
	if (isset($_POST['addproduct']))
	{
		$name=$_POST['txtName'];
		$desc=$_POST['txtDesc'];
		$sq = mysqli_query($con,"INSErt INTO products(pName, pDescription) values('$name', '$desc')")or die(mysqli_query());
		//echo $name ." successfully added.";
		
		echo '<script type="text/javascript">alert("'. $name .' Successfully Entered");</script>';
	}
?>
<head>
			<title>Add Product</title>
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
						<center> <caption> <h2>Add New Product</h2></caption> </center>
						
				<div  style="border: solid black 0px; ">
						
							<form name="f1" action="" method="POST">
									<table cellpadding="0" cellspacing="0" border="0" class="table" id="HeadTable" >
												<tr>
													<td style="text-align: right;" >
														Product Name:
													</td>
													<td style="text-align: left;" >
													<input type="text" name="txtName" id="iBox">
													</td>
													<td style="text-align: right;" >
														Product Description:
													</td>
													<td style="text-align: left;" >
													<input type="text" name="txtDesc" id="iBox">
													</td>
													<td colspan="2" style="text-align: center;" > 
														<input type="submit"  value="Add New" name="addproduct" id="Btn">
													</td>
												</tr>
									</table>
							</form>
<br>
								
									
													<table cellpadding="0" cellspacing="0" border="1" class="" id="dbResult">
													<tr >
														<td colspan="6" > 
														<center>
														<h2> Product Details</h2>
														</center>
														</td>
													</tr>
													<tr>
														<th>Product ID</th>
														<th>Product Name</th>
														<th>Description</th>
														<th>Action</th>
													</tr>
												<?php
																							
													$sql = mysqli_query($con,"SELECT * FROM products")or die(mysqli_query());
														WHILE($Data=mysqli_fetch_array($sql))
															{ 
														$id = $Data['pID'];
															?>
															
															<tr>
																<td><?php echo $Data['pID']; ?></td>
																<td><?php echo $Data['pName']; ?></td>
																<td><?php echo $Data['pDescription']; ?></td>
																<td><a href="edit/editproduct.php?ID=<?php echo $id; ?>" id="LinkBtnEdit">Edit</a> &nbsp;&nbsp;&nbsp;&nbsp;
																<a href="delete/delproduct.php?ID=<?php echo $id; ?>" id="LinkBtnDel">Delete</a></td>
															</tr>
															<?php 
															}
													?>
													</table>
													
							</div>
			
	</div>
</html>
