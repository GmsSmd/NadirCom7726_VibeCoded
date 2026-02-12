<?php
include_once('../session.php');
include_once('includes/variables.php');
include_once('includes/dbcon.php');
include_once('includes/globalvar.php');
	if (isset($_POST['addemp']))
	{
	
		$nm=$_POST['txtName'];
		$jnDate=$_POST['doJ'];
		$Cmnt=$_POST['txtComments'];
		$type=$_POST['Tselect'];
		
		if($type=='---')
			echo '<script type="text/javascript">alert("Please Select a Type from list.");</script>';
		else if($nm=='')
			echo '<script type="text/javascript">alert("Please Enter Name.");</script>';
		else
		{
		$sq = mysqli_query($con,"INSErt INTO company(Name,Type,Comments) values('$nm', '$type', '$Cmnt')")or die(mysqli_query());
		//echo $nm ." successfully added.";
		}
	}
?>
<head>
			<title>Company</title>
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
						<center> <caption> <h2>Add New company</h2></caption> </center>
						
				<div  style="border: solid black 0px; ">
						
							<form name="f1" action="" method="POST">
									<table cellpadding="0" cellspacing="0" border="0" class="table" id="HeadTable" >
												<tr>
													<td style="text-align: right;" > 
														Join Date:
													</td>
													<td style="text-align: left;" >
																<?php
																	$strDate= date('Y-m-d');
																	echo "<input type=\"date\" value= \"$strDate\"  name=\"doJ\" id=\"tBox\">";
																?>
													</td>
													<td style="text-align: right;"> Type: </td>
													<td style="text-align: left;" >
															<select name="Tselect" id="sBox">
																	<option >---</option>
																	<?php
																		$doQ=mysqli_query($con,"SELECT abbvr from abbvr WHERE type='Co' ");
																		while($data=mysqli_fetch_array($doQ))
																			{
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
													<input type="text" name="txtName" id="iBox">
													</td>
													<td style="text-align: right;" > 
														Comments:
													</td>
													<td style="text-align: left;" >
													<input type="text" name="txtComments" id="iBox">
													</td>
												</tr>
												<tr>
													<td colspan="4" style="text-align: center;" > 
														<input type="submit"  value="Add New" name="addemp" id="Btn">
													</td>
												</tr>
									</table>
							</form>
<br>
								
									
									<table cellpadding="0" cellspacing="0" border="1" class="" id="dbResult">
													<tr style="background-color: #FFDAB9; font-weight: bold;" >
														<th>ID</th>
														<th>Name</th>
														<th>company Type</th>
														<th>Comments</th>
														<th>Action</th>
													</tr>
												<?php
												
													$sql = mysqli_query($con,"SELECT * FROM company WHERE Type='CO' OR Type='BNK' ")or die(mysqli_query());
														WHILE($Data=mysqli_fetch_array($sql))
															{ 
														$id = $Data['ID'];
															?>
															<tr>
																<td><?php echo $Data['ID']; ?></td>
																<td><?php echo $Data['Name']; ?></td>
																<td><?php echo $Data['Type']; ?></td>
																<td><?php echo $Data['Comments']; ?></td>
																
																
																<td><a href="edit/editcompany.php?ID=<?php echo $id; ?>" id="LinkBtnEdit">Edit</a> &nbsp;&nbsp;&nbsp;&nbsp;
																<a href="delete/delcompany.php?ID=<?php echo $id; ?>" id="LinkBtnDel">Delete</a></td>
																
															</tr>
															<?php 
															}
													?>
									</table>
													
							</div>
			
	</div>
</html>
