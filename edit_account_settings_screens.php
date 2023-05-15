<?php 
session_start();
include('includes/side-navbar.php');
include('dbcon.php');
?>

<!DOCTYPE html>
<html>
<head>
	<title> Account Settings </title>
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css"></link>
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
		padding: 60px;
		width: 100%;
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
	h3 {
		font-size: 30px;
		margin-top: 20;
		text-align: center;
	}
	input[type="password"],
	input[type="password"] {
		background-color: #F2F2F2;
		border: none;
		border-radius: 5px;
		box-shadow: inset 0px 0px 5px #BDBDBD;
		display: block;
		font-size: 16px;
		margin-top: 20px;
		padding: 10px;
		width: 100%;
	}
	input[type="submit"] {
		background-color: #1A0046FF;
		border: none;
		border-radius: 5px;
		color: #FFFFFF;
		cursor: pointer;
		font-size: 16px;
		margin-top: 20px;
		padding: 10px;
	}
	input[type="submit"]:hover {
		background-color: #11101D;
	}
	.form-group {
		margin-bottom: 20px;
		position: relative;
	}
	.form-group .label {
		display: block;
		font-size: 16px;
		font-weight: 600;
		margin-bottom: 5px;
		color: #333333;
	}
	.form-group input[type="password"]:focus,
	.form-group input[type="password"]:focus {
		background-color: #FFFFFF;
		box-shadow: inset 0px 0px 5px #0077CC;
		color: #333333;
		outline: none;
	}
	.divider::before {
		content: "";
		display: block;
		border-top: 5px solid #333333;
		margin: 20px 0;
	}
	.btn-danger::before {
		content: "\f0a8"; 
		font-family: "Font Awesome 5 Free"; 
		font-weight: bold;
		font-size: 20px;
		color: black;
	}
	.btn-danger {
		background-color: transparent;      
		border: none;
		position: relative;
		right: 10px;
		bottom: 25px;
 	}
	.btn-danger:hover {
		background-color: transparent;      
		border: none;
	}
	select.form-select {
		background-color: white;
		color: black;
		border-radius: 6px;
		width: 100%;
		border-color: #1A0046FF;
		border: none;
		padding: 10px;
		font-size: 18px;
		border: 3px solid #ced4da;
	}
	select.form-select:focus {
		outline: #333333;
	}
	select.form-select option {
		background-color: white;
		color: black;
		font-size: 16px;
		padding: 10px;
	}
	.home-section::-webkit-scrollbar {
		width: 5px; 
	}
	.home-section::-webkit-scrollbar-track {
		background-color: #f6f6f6; 
	}
	.home-section::-webkit-scrollbar-thumb {
		background-color: #ccc; 
	}
	.home-section::-webkit-scrollbar-thumb:hover {
		background-color: #aaa; 
	} 
</style>
</head>

<body>
	<div class="home-section">
		<div class="row justify-content-center">
			<div class="col-md-12">
				<div class="card">
					<div class="card-header">
						<h2>
							EMPLOYEES ACCOUNT SETTINGS  
						</h2>
					</div>
					<form action="userCred.php" method="POST">
						<?php
							if (isset($_SESSION['status'])) {
								echo "<h5 class = 'alert alert-success'>".$_SESSION['status']."</h5>";
								unset($_SESSION['status']);
							}
						?>
						<div>
							<a href="profiles.php" class="btn btn-danger float-start" onclick="history.back()"> </a>
						</div>

						<h3> Account Settings </h3>
						<div class="form-group">
							<?php 
								if(isset($_GET['uid'])){
									$uid = $_GET['uid'];
								try {
									$user = $auth->getUser($uid);
							?>
							<input type="hidden" name="ena-dis-user" value="<?=$uid?>">

							<label for=""> Account Status: </label>

							<select name="select_enable_disable" class="form-select form-select-lg mb-3" aria-label=".form-select-lg example" required>
								<option value="Enabled">Enabled</option>
								<option value="Disabled">Disabled</option>
							</select>
							<br>
							<input type="submit" name = "enable_disable_user_button" value="Save">

							<td></td>
							<div class="divider"></div> 
							<h3></h3>			
						</div>
			
						<br> <br>

						<h3>Privacy Settings</h3>
						<form action="userCred.php" method="POST">
							<input type="hidden" name="change_password_id_value" value="<?=$uid?>">
							<div class="form-group">
								<label for="password">Password:</label>
								<input type="password" id="password" name="password" placeholder="Enter new password">
							</div>
							<div class="form-group">
								<label for="password">Confirm Password:</label>
								<input type="password" id="password" name="confirm_password" placeholder="Re-enter new password">
							</div>
							<input type="submit" name = "change_password_button" value="Change Password">
							
							<td></td>
							<div class="divider"></div> 
							<h3></h3>

							<br> <br>

							<h3>Roles</h3>	
							<form action="userCred.php" method="POST">
								<label for=""> Currently as: </label>
								<?php 
									$claims = $auth -> getUser($uid)-> customClaims;
									if(isset($claims['Superadmin']) == true) {
										echo "SuperAdmin";
									}
									if(isset($claims['Admin']) == true) {
										echo "Admin";
									} 
									elseif($claims == null) {
										echo "No roles";
									}
								?>
							<br>
							<input type="hidden" name="roles-user-id" value="<?=$uid?>">
							<br>
							<label for=""> Account Status: </label>
							<select name="select_roles_user" class="form-select form-select-lg mb-3" aria-label=".form-select-lg example" required>
								<option value="Select"> Select </option>
								<option value="Norole"> Noroles </option>
								<option value="Superadmin"> Superadmin </option>
								<option value="Admin"> Admin </option>						
							</select>
							<br>
							<input type="submit" name = "roles_user_button" value="Save">
							</form>
						</form>
						<?php
						} catch(Exception $e) {					
						}
					} else{
						echo "No user id found";
					}
					?>
					</form>
				</div>
	  		</div>
		</div>
	</div>
</body>
</html>