<?php
include_once('../session.php');
include_once('includes/variables.php');
include_once('includes/dbcon.php');
include_once('includes/globalvar.php');
	
	if (isset($_POST['AddUser']))
	{
		$fName=$_POST['txtFName'];
		$lName=$_POST['txtLName'];
		$uName=$_POST['txtUName'];
		$pass1=$_POST['txtP1'];
		$pass2=$_POST['txtP2'];
		
		if($uName=="")
			echo '<script type="text/javascript">alert("Login ID field can not be empty.");</script>';
		
		else if ($pass1=="")
			echo '<script type="text/javascript">alert("Password field can not be empty.");</script>';
		
		else if($pass1==$pass2)
			{		
			$sq = mysqli_query($con,"INSErt INTO users(username, password, firstname, lastname) values('$uName', '$pass1', '$fName', '$lName' )")or die(mysqli_query());
			echo '<script type="text/javascript">alert("User succesfully added.");</script>';
			}
		
		else
			echo '<script type="text/javascript">alert("Password does not match.");</script>'; 
	}
?>
<head>
			<title>Users</title>
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
						<center> <caption> <h2>Add New User</h2></caption> </center>
						
				<div  style="border: solid black 0px; ">
						
							<form name="f1" action="" method="POST">
									<table cellpadding="0" cellspacing="0" border="0" class="table" id="HeadTable" >
												<tr>
													<td style="text-align: right;" >
														First Name:
													</td>
													<td style="text-align: left;" >
													<input type="text" name="txtFName" id="iBox" autofocus>
													</td>
												</tr>
												<tr>
													<td style="text-align: right;" >
														Last Name:
													</td>
													<td style="text-align: left;" >
													<input type="text" name="txtLName" id="iBox">
													</td>
												</tr>
												<tr>
													<td style="text-align: right;" >
														Login ID:
													</td>
													<td style="text-align: left;" >
													<input type="text" name="txtUName" id="iBox">
													</td>
												</tr>
												<tr>
													<td style="text-align: right;" >
														Password:
													</td>
													<td style="text-align: left;" >
													<input type="password" name="txtP1" id="iBox">
													</td>
												</tr>
												<tr>
													<td style="text-align: right;" >
														Confirm Password:
													</td>
													<td style="text-align: left;" >
													<input type="password" name="txtP2" id="iBox">
													</td>
												</tr>
												<tr>
													<td colspan="2" style="text-align: center;" > 
														<input type="submit"  value="Add User" name="AddUser" id="Btn">
													</td>
												</tr>
									</table>
							</form>
<br>
								
									
													<table cellpadding="0" cellspacing="0" border="1" class="" id="dbResult">
													<tr >
														<td colspan="6" > 
														<center>
														<h2> Registered users</h2>
														</center>
														</td>
													</tr>
													<tr style="background-color: #FFDAB9; font-weight: bold;" >
														<th>ID</th>
														<th>Firsr Name</th>
														<th>Last Name </th>
														<th>Login ID</th>
														<th>Action</th>
													</tr>
												<?php
																							
													$sql = mysqli_query($con,"SELECT * FROM users")or die(mysqli_query());
														WHILE($Data=mysqli_fetch_array($sql))
															{ 
														$id = $Data['user_id'];
															?>
															<tr>
																<td><?php echo $Data['user_id']; ?></td>
																<td><?php echo $Data['firstname']; ?></td>
																<td><?php echo $Data['lastname']; ?></td>
																<td><?php echo $Data['username']; ?></td>
																
																
																<td>
																<a href="edit/editusers.php?ID=<?php echo $id; ?>" id="LinkBtnEdit">Edit</a> &nbsp;&nbsp;&nbsp;&nbsp;
																<a href="delete/delusers.php?ID=<?php echo $id; ?>" id="LinkBtnDel">Delete</a>
																</td>
																
															</tr>
															<?php 
															}
													?>
													</table>
													
							</div>
			
	</div>
</html>
