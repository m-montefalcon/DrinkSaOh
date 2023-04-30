<?php 
session_start();

include('includes/header.php');
include('dbcon.php');

?>

<!DOCTYPE html>
<html>
<head>
	<title>Login Form</title>
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
                    
                        <form action="loginCred.php" method="POST">
                            <?php
                                if (isset($_SESSION['status'])) {
                                    echo "<h5 class = 'alert alert-success'>".$_SESSION['status']."</h5>";
                                    unset($_SESSION['status']);
                                }
                                
                                ?>

                            <h2>Login</h2>
                        
                            <div class="form-group">

                                <label for="email">Email Address:</label>
                                <input type="email" id="email" name="email" placeholder="Enter your email address" required>
                            </div>
                                <div class="form-group">
                                    <label for="password">Password:</label>
                                    <input type="password" id="password" name="password" placeholder="Enter your password" required>
                                </div>
                            <input type="submit" name = "login_user_button" value="Login">
                    </form>
              
            </div>
        </div>
    </div>
    
</body>
</html>
