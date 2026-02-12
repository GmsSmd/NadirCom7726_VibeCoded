<?php
	session_start();
	$error='';
	if (isset($_POST['submit'])) 
	{
		if (empty($_POST['username']) || empty($_POST['password'])) 
			{
			$error = "Please enter user name and password.";
			}
		else
			{
				include('admin/includes/dbcon.php');
				$username=$_POST['username'];
				$password=$_POST['password'];
				$username = stripslashes($username);
				$password = stripslashes($password);
				$username = mysqli_real_escape_string($con,$username);
				$password = mysqli_real_escape_string($con,$password);
				$query = mysqli_query($con,"select * from users where password='$password' AND username='$username'") or die(mysqli_error($con));
				$data=mysqli_fetch_array($query);
				$u_type=$data['user_type'];
				$rows = mysqli_num_rows($query);
				if ($rows == 1) 
					{
						$qury = mysqli_query($con,"select * from config") or die(mysqli_error($con));
						$dat=mysqli_fetch_array($qury);
						$companyName=$dat['company'];
						$organizationName=$dat['organization'];
						$default_bank=$dat['defaultbank'];
					
					session_regenerate_id(true);
					$_SESSION['login_user']=$username;
					$_SESSION['login_type']=$u_type;
					$_SESSION['company_name']=$companyName;
					$_SESSION['organization_name']=$organizationName;
					$_SESSION['default_bank']=$default_bank;
					$error = "OK";
					header("Location: admin/summary.php");
					}
				else
					{
					$error = "Invalid UserName or Password.";
					}
			}
	}
?>