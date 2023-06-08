<?php
include('super_admin_auth.php');
include('includes/side-navbar.php');
include("dbcon.php");
?>

<!DOCTYPE html>
<html>
<head>
	<title> Registration </title>
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="stylesheet" href="https://use.fontawesome.com/releases/v6.4.0/css/all.css">
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" > </link>
<style>
	body {
		background-color: #f6f6f6;
		font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
		margin: 0;
		padding: 0;
		overflow-x: hidden;
	}
	form {
    	overflow-x: hidden;
		background-color: #FFFFFF;
		border-radius: 10px;
		box-shadow: 0px 0px 10px gray;
		padding: 30px;
		width: 100%;
	}
	.card {
		padding: 15px;
	}
	.card .card-header {
		border-bottom-color: #f9f9f9;
		line-height: 30px;
		-ms-grid-row-align: center;
		align-self: center;
		width: 100%;
		padding: 10px 25px;
		display: flex;
		align-items: center;
		border-radius: 10px;
		background: #11101D;
		/* background-image: linear-gradient(to right, #9C27B0FF, #1A0046FF); */
	}
	label {
		display: block;
		font-size: 16px;
		font-weight: 600;
		margin-bottom: 5px;
		color: #333333;
	}
	input[type="text"], 
	input[type="tel"], 
	input[type="email"], 
	input[type="password"] {
		background-color: #F2F2F2;
		box-shadow: inset 0px 0px 5px #9C27B0FF;
		border: none;
		border-radius: 5px;
		display: block;
		font-size: 16px;
		margin-bottom: 20px;
		padding: 10px;
		width: 100%;
		padding-left: 40px;
	}
	.input-group {
		position: relative;
	}
	.input-group span.input-group-text {
		position: absolute;
		top: 70%;
		transform: translateY(-50%);
		left: 13px;
		color: #9C27B0FF;
		font-size: 18px;
		color: black;
	}
	.input-group span.input-group-icon {
		position: absolute;
		top: 70%;
		transform: translateY(-50%);
		right: 13px;
		color: #9C27B0FF;
		font-size: 18px;
		color: black;
	}
	.input-group input[type="password"] {
		padding-right: 40px;
	}
	input[type="submit"],
	a.btn-danger {
		text-align: center;
		background-color: #9C27B0FF;
		border-radius: 6px;
		width: 100px;
		height: 40px;
		border: none;
		margin-top: 10px;
		display: inline-block;
		vertical-align: middle;
		font-size: 20px;
		justify-content: center;
		align-items: center;
		line-height: 40px;
  	}
	input[type="submit"] {
		background-color: #1A0046FF;
		color: white;
	}
	a.btn-danger {
		background-color: maroon;
    	color: white;
	}
	a.btn-danger.float-end {
		float: right;
	}
	a.btn-danger {
		background-color: maroon;
		margin-left: 0%;
		border-radius: 6px;
		cursor: pointer;
	}
	input[type="submit"]:hover {
		background-color: #11101D;
		cursor: pointer;
	}
	a.btn-danger:hover {
		background-color: #11101D;
		color: white;
	}
	body::-webkit-scrollbar {
		width: 5px; 
	}
	body::-webkit-scrollbar-track {
		background-color: #f6f6f6; 
	}
	body::-webkit-scrollbar-thumb {
		background-color: #ccc; 
	}
	body::-webkit-scrollbar-thumb:hover {
		background-color: #aaa; 
	}  
	.error {
		color: #FF0000;
		font-size: 14px;
		margin-top: 5px;
	}
</style>
</head>

<body>
	<div class="card">
		<div class="card-header">
			<h2> Register </h2>
		</div>
		
		<form action="userCred.php" method="POST">
			<?php
				if (isset($_SESSION['status'])) {
					echo "<h5 class = 'alert alert-success'>".$_SESSION['status']."</h5>";
					unset($_SESSION['status']);
				}
			?>
			
			<div class="form-group input-group">
				<div class="input-group-prepend">
					<span class="input-group-text"> <i class="fa-solid fa-user"></i> </span>
				</div>
				<label for="full_name"> Full Name </label>
				<input type="text" id="full_name" class="form-control" name="full_name" placeholder="Enter full name" required>
			</div>
			<div class="form-group input-group">
				<div class="input-group-prepend">
					<span class="input-group-text"> <i class="fa-solid fa-phone"></i> </span>
				</div>
				<label for="phone_number"> Phone Number </label>
				<input type="tel" id="phone_number" class="form-control" name="phone_number" pattern="[0-9]{10}" placeholder="Enter phone number" required>
			</div>
			<div class="form-group input-group">
				<div class="input-group-prepend">
					<span class="input-group-text"> <i class="fa-solid fa-at"></i> </span>
				</div>
				<label for="email_address"> Email Address </label>
				<input type="email" id="email_address" class="form-control" name="email_address" placeholder="Enter email address" required>
			</div>
			<div class="form-group input-group">
				<div class="input-group-prepend">
					<span class="input-group-text"> <i class="fa-solid fa-key"></i> </span>
				</div>
				<label for="password"> Password </label>
				<input type="password" id="password" class="form-control" name="password" minlength="8" placeholder="Must be atleast 8 characters" required>
				<span class="input-group-icon"> 
					<i class="fa fa-eye-slash password-toggle" id="password-toggle"></i>
				</span>
			</div>

			<input type="submit" name = "register_user_button" value="Register">
			<a href="profiles.php" class="btn btn-danger float-end" onclick="history.back()"> Cancel </a>

		</form>
	</div>
	<script>
		const passwordInput = document.getElementById('password');
		const passwordToggle = document.getElementById('password-toggle');

		passwordToggle.addEventListener('click', function() {
		const type = passwordInput.getAttribute('type') === 'password' ? 'text' : 'password';
		passwordInput.setAttribute('type', type);
		passwordToggle.classList.toggle('fa-eye');
		passwordInput.focus();
		});
	</script>
	<script src="//maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
	<script src="//cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
</body>
</html>