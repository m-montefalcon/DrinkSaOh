<?php
session_start();
include('authentication.php');
include('includes/header.php');
include('dbcon.php');


?>
<?php 
    $uid = $_SESSION['verified_user_id'];
    $user = $auth->getUser($uid);



?>
<!DOCTYPE html>
<html>
<head>
	<title>User Profile</title>
	<link rel="stylesheet" href="style.css">
</head>
<body>
	<div class="container">
		<div class="card">
			<div class="card-header">
				<h2>User Profile</h2>
			</div>
			<div class="card-body">
				<form method="POST" action="user_profile_screen.php">
					<table>
						
						<tr>
							<th>Display Name:</th>
							<td><?php echo $user->displayName ?></td>
						</tr>
						<tr>
							<th>Phone Number:</th>
							<td><?php echo $user->phoneNumber ?></td>
						</tr>
						<tr>
							<th>Email:</th>
							<td><?php echo $user->email ?></td>
						</tr>
					</table>
                    <br>
                    <button type="submit" name = "user_edit_profile_button" value= "<?=$user -> uid?>" class="btn btn-primary" value = "<?=$key?>">EDIT PROFILE</button>

				</form>
			</div>
		</div>
	</div>
</body>
<style>
    .container {
	margin: 0 auto;
	max-width: 800px;
	padding: 20px;
}

.card {
	background-color: #fff;
	box-shadow: 0px 1px 3px 0px rgba(0, 0, 0, 0.2);
	margin-bottom: 20px;
}

.card-header {
	background-color: #007bff;
	color: #fff;
	padding: 10px 20px;
}

.card-body {
	padding: 20px;
}

table {
	border-collapse: collapse;
	width: 100%;
}

th, td {
	padding: 10px;
	text-align: left;
	border-bottom: 1px solid #ddd;
}

th {
	background-color: #f2f2f2;
}

tr:hover {
	background-color: #f5f5f5;
}

</style>
</html>
?> 