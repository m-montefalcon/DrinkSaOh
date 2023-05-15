<?php
session_start();
include('authentication.php');
include('includes/side-navbar.php');
include("dbcon.php");
?>

<!DOCTYPE html>
<html>
<head>
	<title> EDIT USER </title>
	<meta name="viewport" content="width=device-width, initial-scale=1">
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
	.error {
		color: #FF0000;
		font-size: 14px;
		margin-top: 5px;
	}
</style>
</head>

<body>
	<div class="home-section">
		<div class="card">
          	<div class="card-header">
				<h2>
					EDIT USER  
            	</h2>
          	</div>
			<form action="userCred.php" method="POST">
				<?php
					if (isset($_SESSION['status'])) {
						echo "<h5 class = 'alert alert-success'>".$_SESSION['status']."</h5>";
						unset($_SESSION['status']);
					}
				?>
				<?php 
					include('dbcon.php');
					if(isset($_GET['id'])) {
						$uid = $_GET['id'];
					}			
					try {
						$user = $auth->getUser($uid);
				?>
				
				<input type="hidden" name="edit-user-key" value="<?=$uid;?>">

				<label for="full_name"> Full Name </label>			
				<input type="text" id="full_name" value =  "<?=$user -> displayName ?>" name="full_name" placeholder="Enter full name" required>

				<label for="phone_number"> Phone Number </label>
				<input type="text" id="phone_number" value = "<?=$user -> phoneNumber ?>"name="phone_number" pattern="{10}" placeholder="Enter phone number">
				
				<label for="email_address"> Email Address </label>
				<input type="email" id="email_address" value = "<?=$user -> email ?>" name="email_address" placeholder="Enter email address" required>
				
				<input type="submit" name = "update_user_button" value="Edit">
				<a href="profiles.php" class="btn btn-danger float-end" onclick="history.back()"> Cancel </a>
			</form>
		</div>
	</div>
	<?php				
		} catch (\Kreait\Firebase\Exception\Auth\UserNotFound $e) {
			echo $e->getMessage();
		}
	?>
</body>
</html>