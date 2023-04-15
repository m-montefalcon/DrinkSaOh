<?php
session_start();
include('authentication.php');
include('includes/header.php');
include("dbcon.php");
?>

<!DOCTYPE html>
<html>
<head>
	<title>EDIT USER</title>
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
			padding: 20px;
			margin: 50px auto;
			max-width: 600px;
			width: 100%;
		}
		h2 {
			font-size: 28px;
			font-weight: 600;
			margin: 0 0 30px;
			text-align: center;
		}
		label {
			display: block;
			font-size: 16px;
			font-weight: 600;
			margin-bottom: 5px;
			color: #333333;
		}
		input[type="text"], input[type="tel"], input[type="email"], input[type="password"] {
			background-color: #F2F2F2;
			border: none;
			border-radius: 5px;
			box-shadow: inset 0px 0px 5px #BDBDBD;
			display: block;
			font-size: 16px;
			margin-bottom: 20px;
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
			width: 100%;
		}
		input[type="submit"]:hover {
			background-color: #005EA8;
		}
		.error {
			color: #FF0000;
			font-size: 14px;
			margin-top: 5px;
		}
	</style>
</head>

<body>

	<form action="userCred.php" method="POST">
	<?php
              if (isset($_SESSION['status'])) {
                echo "<h5 class = 'alert alert-success'>".$_SESSION['status']."</h5>";
                unset($_SESSION['status']);
              }
            
            ?>

            <?php 
            include('dbcon.php');

            if(isset($_GET['id'])){

                $uid = $_GET['id'];

            }
            
            try {
                $user = $auth->getUser($uid);
    

              ?>
              <h2>EDIT USER</h2>
				


                
                <input type="hidden" name="user_profile_key" value="<?=$uid;?>">
                <label for="full_name">Full Name</label>
            
                <input type="text" id="full_name" value =  "<?=$user -> displayName ?>" name="full_name" required>

                <label for="phone_number">Phone Number</label>
                <input type="text" id="phone_number" value = "<?=$user -> phoneNumber ?>"name="phone_number" pattern="{10}">
                
                <label for="email_address">Email Address</label>
                <input type="email" id="email_address" value = "<?=$user -> email ?>" name="email_address" required>
                
            
            <input type="submit" name = "user_profile_submit_button" value="Save">
        </form>
              <?php

            } catch (\Kreait\Firebase\Exception\Auth\UserNotFound $e) {
                echo $e->getMessage();
            }
            ?>
	
</body>
</html>
