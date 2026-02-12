<?php
include_once('login.php');
?>
<!doctype HTML>
<html>
	<head>
		<title>Login</title>
		<style> 
		<?php include_once('admin/styles/loginstyle.css'); ?>
		</style>
	</head>

	<body>
	<br/>
			<div class="app">
				<div class="bar">
					<h2>Welcome to Franchise Management System</h2>
				</div>
				<div class="img">
					 <img src="admin/resources/jazznew.PNG" alt="FMS" width="200" height="150"/>
				</div>
				<form id="form1" method="POST" action="">
					
					<input id="name" name="username" placeholder="Enter User Name" type="text"/>
					<br>
					
					<input id="password" name="password" placeholder="Enter Password" type="password"/><br>
					<input name="submit" type="submit" value=" Login " />
					
					<div>
					<h2><?php echo $error; ?></h2>
				</div>
				</form>
			</div>
	</body>
</html>