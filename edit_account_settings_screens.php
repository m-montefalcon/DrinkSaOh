<?php 
session_start();

include('includes/header.php');
include('dbcon.php');

?>

<!DOCTYPE html>
<html>
<head>
	<title>Account Settings</title>
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<style>
		body {
			background-color: #F2F2F2;
			font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
			margin: 0;
			padding: 0;
		}
		form {
			background-color: #FFFFFF;
			border-radius: 10px;
			box-shadow: 0px 0px 10px #BDBDBD;
			padding: 50px;
			max-width: 600px;
			margin: auto;
			margin-top: 120px;
		}
		h2 {
			margin-top: 20;
			text-align: center;
		}
		input[type="email"],
		input[type="password"] {
			background-color: #F2F2F2;
			border: none;
			border-radius: 5px;
			box-shadow: inset 0px 0px 5px #BDBDBD;
			color: #777777;
			font-size: 16px;
			margin-top: 20px;
			padding: 10px;
			width: 95%;
		}
		input[type="submit"] {
			background-color: #0077CC;
			border: none;
			border-radius: 5px;
			color: #FFFFFF;
			cursor: pointer;
			font-size: 16px;
			margin-top: 20px;
			padding: 10px;
			width: 98%;
		}
		input[type="submit"]:hover {
			background-color: #005EA8;
		}
		.form-group {
			margin-bottom: 20px;
		}
		.form-group label {
			display: block;
			font-size: 16px;
			font-weight: bold;
			margin-bottom: 5px;
		}
		.form-group input[type="email"]:focus,
		.form-group input[type="password"]:focus {
			background-color: #FFFFFF;
			box-shadow: inset 0px 0px 5px #0077CC;
			color: #333333;
			outline: none;
		}
	</style>
        </head>
        <body>
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    
                        <form action="userCred.php" method="POST">
                            <?php
                                if (isset($_SESSION['status'])) {
                                    echo "<h5 class = 'alert alert-success'>".$_SESSION['status']."</h5>";
                                    unset($_SESSION['status']);
                                }
                                
                                ?>

                            <h2>Account Settings</h2>
                        
                            <div class="form-group">
								<?php 
								if(isset($_GET['uid'])){
									$uid = $_GET['uid'];

									try{
										$user = $auth->getUser($uid);
										?>

								<input type="hidden" name="ena-dis-user" value="<?=$uid?>">
								<label for="">Account Status:</label>



                                <select name="select_enable_disable" class="form-select form-select-lg mb-3" aria-label=".form-select-lg example" required>
								<option value="Enabled">Enabled</option>
								<option value="Disabled">Disabled</option>
								<input type="submit" name = "enable_disable_user_button" value="Save">

								</select>
								<td></td>
								<h2></h2>
								<h2>

								<br>

								</h2>
								
                            </div>
							<h2>Privacy Settings</h2>

								<form action="userCred.php" method="POST">
								<input type="hidden" name="change_password_id_value" value="<?=$uid?>">
								<div class="form-group">
										<label for="password">Password:</label>
										<input type="password" id="password" name="password" placeholder="Enter your password">
									</div>
									<div class="form-group">
										<label for="password">Confirm Password:</label>
										<input type="password" id="password" name="confirm_password" placeholder="Re Enter your password">
									</div>

									<input type="submit" name = "change_password_button" value="Change Password">

									

							<form action="userCred.php" method="POST">
							
							<h2>Roles</h2>
									<label for="">Currently as : </label>
	
									<?php 
									$claims = $auth -> getUser($uid)-> customClaims;
									if(isset($claims['Superadmin']) == true){
	
										echo "SuperAdmin";
									}
									if(isset($claims['Admin']) == true){
										
										echo "Admin";
									} 
									elseif($claims == null){
										echo "No roles";

								
								
									}
									
									
									?>
									<br>
									<input type="hidden" name="roles-user-id" value="<?=$uid?>">
									<label for="">Account Status:</label>
	
									<select name="select_roles_user" class="form-select form-select-lg mb-3" aria-label=".form-select-lg example" required>
									<option value="Select">Select</option>
									<option value="Norole">Noroles</option>
									<option value="Superadmin">Superadmin</option>
									<option value="Admin">Admin</option>
									
	
									<input type="submit" name = "roles_user_button" value="Save">
	
									</select>
								</form>

							</form>

								<?php
												} catch(Exception $e){
													

												}
											} else{
												echo "No user id found";
											}

								
								
								?>
            </div>
        </div>
    </div>
</body>
</html>

