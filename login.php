<?php
session_start();
include("dbcon.php");
?>

<!DOCTYPE html>
<html>
<head>
	<title> Login </title>
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-KK94CHFLLe+nY2dmCWGMq91rCGa5gtU4mk92HdvYe+M/SXH301p5ILy+dN9+nJOZ" crossorigin="anonymous">
	<link href="//maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
	<link rel="stylesheet" href="https://use.fontawesome.com/releases/v6.4.0/css/all.css">
<style>
	body {
		/* background-image: linear-gradient(to bottom, #9C27B0FF, #1A0046FF); */
		background: #11101D;
		font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
		margin: 0;
		padding: 0;
	}
	.card {
		background: #11101D;
		border-radius: 10px;
		border: none;
		margin: 20px;
		overflow: hidden;
	}
	form {
		background-color: #FFFFFF;
		border-radius: 10px;
		box-shadow: 0px 0px 10px #BDBDBD;
		padding: 50px;
		padding-top: 20px;
		max-width: 600px;
		margin: auto;
		width: 100%;
	}
	h2 {
		margin-bottom: 20px;
		text-align: center;
		font: 2.5em sans-serif;
		font-family:'Franklin Gothic Medium', 'Arial Narrow', Arial, sans-serif;
	}
	input[type="text"], 
	input[type="tel"], 
	input[type="email"], 
	input[type="password"] {
		background-color: #F2F2F2;
		border: none;
		border-radius: 5px;
		box-shadow: inset 0px 0px 5px #BDBDBD;
		display: block;
		font-size: 16px;
		margin-bottom: 20px;
		/* padding: 10px; */
		width: 100%;
	}
	input[type="submit"] {
		background-color: #9C27B0FF;
		border: none;
		border-radius: 5px;
		color: #FFFFFF;
		cursor: pointer;
		font-size: 16px;
		margin-top: 20px;
		padding: 10px;
		width: 100%;
	}
	label {
		display: block;
		font-size: 16px;
		font-weight: 600;
		margin-bottom: 5px;
		color: #333333;
	}
	input[type="text"]:focus,
	input[type="tel"]:focus,
	input[type="email"]:focus,
	input[type="password"]:focus {
		background-color: #FFFFFF;
		box-shadow: inset 0px 0px 5px #9C27B0FF;
		color: black;
		outline: none;
	}
	input[type="submit"]:hover {
		background-color: #89229b;
	}
	.form-group {
		margin-bottom: 20px;
		position: relative;
	}
	h1 {
		display: flex;
		flex-direction: row;
		padding-top: 2em;
		font-size: 20px;
		color: black;
	}
	h1:before, h1:after{
		content: "";
		flex: 1 1;
		border-bottom: 1px solid;
		margin: auto;
	}
	h1:before {
		margin-right: 10px
	}
	h1:after {
		margin-left: 10px
	}
	.form-link {
		text-align: center;
		padding-top: 1em;
	}
	.form-link span {			
		color: black;
	}
	.form-link a:hover {	
		color: #9C27B0FF;
	}
	.form-link a {	
		color: #1A0046FF;
	}
	.error {
		color: #FF0000;
		font-size: 14px;
		margin-top: 5px;
	}
	.container {
		display: flex;
		align-items: center;
		justify-content: center;
		/* height: 100vh; */
	}

	@media screen and (max-width: 767px) {
    .container {
		flex-direction: column;
		align-items: center;
		width: 100%; 
		max-height: 100vh;
    }
  }

  /* @media screen and (max-width: 767px) {
    .card {
		flex-direction: column;
		align-items: center;
    }
  } */

	/* .logo {
		flex: 1;
	}
	.card {
		flex: 1;
	} */
	
	.logo-img {
		width: 80%; 
		margin-bottom: 20px;
	}

</style>
</head>

<body>
	<!-- <div class="container">
		<div class="logo">
			<img src="assets/logo_logo.png" class="logo-img">
		</div> -->
		<div class="card">
			<form action="loginCred.php" method="POST">
				<?php
					if (isset($_SESSION['status'])) {
						echo "<h5 class = 'alert alert-success'>".$_SESSION['status']."</h5>";
						unset($_SESSION['status']);
					}
				?>
				<div class="container">
					<img src="assets/DrinkSaOh_logo.png" class="logo-img">
				</div>
				<!-- <h2> Login </h2> -->
						
				<!-- <label for="email_address"> Email Address: </label> -->
				<div class="form-group input-group">
					<div class="input-group-prepend">
						<span class="input-group-text"> <i class="fa-solid fa-at"></i> </span>
					</div>
					<input type="email" id="email" class="form-control" name="email" placeholder="Enter email address" required>
				</div>
				<!-- <label for="email_address"> Password: </label> -->
				<div class="form-group input-group">
					<div class="input-group-prepend">
						<span class="input-group-text"> <i class="fa-solid fa-key"></i> </span>
					</div>
					<input type="password" id="password" class="form-control" name="password" minlength="8" placeholder="Must be atleast 8 characters" required>
					<span class="input-group-text"> 
						<i class="fa fa-eye-slash password-toggle" id="password-toggle"></i>
					</span>
				</div>

				<input type="submit" name = "login_user_button" value="Login">

			</form>
		</div>
	<!-- </div> -->
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