<?php
include_once('../includes/dbcon.php');
include_once('../includes/globalvar.php');
$uid = $_GET['ID'];
$edit = mysqli_query($con,"SELECT * FROM users WHERE user_id = '$uid'") or die(mysqli_error());
$emp = mysqli_fetch_array($edit);
$fName=$emp['firstname'];
$lName=$emp['lastname'];
$uName=$emp['username'];
$oldPass=$emp['password'];



	if (isset($_POST['UpdateUser']))
	{
		$fName=$_POST['txtFName'];
		$lName=$_POST['txtLName'];
		$uName=$_POST['txtUName'];
		$pass3=$_POST['txtP3'];
		$pass1=$_POST['txtP1'];
		$pass2=$_POST['txtP2'];
		
		if($pass3==$oldPass)
			{
				if($pass1==$pass2)
				{		
					$sq = mysqli_query($con,"UPDATE users SET username='$uName' , password= '$pass1', firstname='$fName', lastname='$lName' WHERE user_id=$uid ")or die(mysqli_query());
					echo '<script type="text/javascript">alert("User succesfully Updated.");</script>';
					header("Location: ../addusers.php");
					}
				else 
					echo '<script type="text/javascript">alert("Passwords not matched.");</script>';
			}
		else
			echo '<script type="text/javascript">alert("Old Password Incorrect.");</script>';
	}

	
if (isset($_POST['CancelUEdit']))
	header("Location: ../addusers.php");
	
	
	
	
	
	?>
<head>
			<title>Update users</title>
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
						<center> <caption> <h2>Update User</h2></caption> </center>
						
				<div  style="border: solid black 0px; ">
						
							<form name="f1" action="" method="POST">
									<table cellpadding="0" cellspacing="0" border="0" class="table" id="HeadTable" >
												
												<tr>
													<td style="text-align: right;" >
														First Name:
													</td>
													<td style="text-align: left;" >
													<input type="text" name="txtFName" id="iBox" value="<?php echo $fName; ?>">
													</td>
												</tr>
												<tr>
													<td style="text-align: right;" >
														Last Name:
													</td>
													<td style="text-align: left;" >
													<input type="text" name="txtLName" id="iBox" value="<?php echo $lName; ?>">
													</td>
												</tr>
												<tr>
													<td style="text-align: right;" >
														Login ID:
													</td>
													<td style="text-align: left;" >
													<input type="text" name="txtUName" id="iBox" value="<?php echo $uName; ?>">
													</td>
												</tr>
												
												
												<tr>
													<td style="text-align: right;" >
														Old Password:
													</td>
													<td style="text-align: left;" >
													<input type="password" name="txtP3" id="iBox">
													</td>
												</tr>
												<tr>
													<td style="text-align: right;" >
														New Password:
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
														<input type="submit"  value="Update" name="UpdateUser" id="Btn"> &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;
														<input type="submit"  value="Cancel" name="CancelUEdit" id="Btn">
													</td>
												</tr>
									</table>
							</form>
				</div>
			
	</div>
</html>
