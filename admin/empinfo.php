<?php
include_once('../session.php');
include_once('includes/globalvar.php');
?>

<!doctype html>

<html>

<head>
			<title>summary</title>
			<style>
			<?php
			include_once('include_onces/dbcon.php');
			include_once('styles/navbarstyle.php');
			include_once('styles/tablestyle.php');
			?>
			</style>
			</head>
			
			<?php
include_once('include_onces/navbar.php');
?>

		<div class="container" align="center">
						<center> <caption> <h2>Employee Iformation</h2></caption> </center>
					
					
					<div  style="border: solid black 0px; ">
									<table cellpadding="0" cellspacing="0" border="0" class="" id="HeadTable">
												<tr>
												</tr>
									
									</table>
									
									<table cellpadding="0" cellspacing="0" border="1" class="" id="dbResult">
													<tr style="background-color: #FFDAB9; font-weight: bold;" >
														<th>ID</th>
														<th>Name</th>
														<th>Joining Date</th>
														<th>salary</th>
													</tr>
														<?php
															$sql = mysqli_query($con,"SELECT * FROM empinfo")or die(mysqli_query());
														
														WHILE($Data=mysqli_fetch_array($sql))
															{ 
															?>
															<tr>
																<td><?php echo $Data['EmpID']; ?></td>
																<td><?php echo $Data['EmpName']; ?></td>
																<td><?php echo $Data['EmpJoinDate']; ?></td>
																<td><?php echo $Data['EmpFixedSalary']; ?></td>
																<!-- <td><a href="edit_book.php?id=<?php echo $id; ?>" class="btn btn-success"><i class="fa fa-pencil"></i>Edit</a></td> -->
																<!--  <td><a rel="tooltip"  title="Delete" id="<?php echo $id; ?>" href="#delete_book<?php echo $id; ?>" data-toggle="modal"    class="btn btn-danger"><i class="icon-trash icon-large"></i></a></td>  -->
																<!--  <?php include_once('delete_book_modal.php'); ?>  -->
															</tr>
															<?php 
															}
													?>
													</table>
					</div>
		</div>
</html>
