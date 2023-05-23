<?php
session_start();
include('authentication.php');
include('includes/side-navbar.php');
include('dbcon.php');
include('config.php');
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
	<meta name="viewport" content="width=device-width, initial-scale=1">
  	<link rel='stylesheet' href='https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.1.3/css/bootstrap.min.css'>
	<link rel='stylesheet' href='https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.12.1/css/all.min.css'>
<style>
	* {
		box-sizing: border-box;
		margin: 0;
		padding: 0;
	}
	body {
		background-color: #f6f6f6;
		overflow: hidden;
	} 
	.employee-profile .card {
		border-radius: 10px;
	}
	.employee-profile .card .card-header .profile_img {
		width: 150px;
		height: 150px;
		object-fit: cover;
		margin: 10px auto;
		border: 10px solid #ccc;
		border-radius: 50%;
	}
	.employee-profile .card h3 {
		font-size: 20px;
		font-weight: 700;
		margin-top: 10px;
		text-align: center;
	}
	.employee-profile .card p {
		font-size: 16px;
		color: #000;
	}
	.employee-profile .table th,
	.employee-profile .table td {
		font-size: 14px;
		padding: 5px 10px;
		color: #000;
	}
	h4 {
		font-size: 20px;
		font-weight: 700;
	}
	h2 {
		font-size: 24px;
		font-weight: 700;
		margin-top: 10px;
		text-align: center;
	}
	label {
		display: block;
		font-size: 16px;
		font-weight: 600;
		margin-bottom: 10px;
		color: #333333;
	}
	input[type="text"], 
	input[type="tel"], 
	input[type="email"], 
	input[type="password"] {
		background-color: #F2F2F2;
		border: none;
		border-radius: 5px;
		box-shadow: inset 0px 0px 5px #9C27B0FF;
		display: block;
		font-size: 16px;
		margin-bottom: 20px;
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
		padding: 10px;
	}
	input[type="submit"]:hover {
		background-color: #11101D;
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
	.error {
		color: #FF0000;
		font-size: 14px;
		margin-top: 5px;
	}
	.user-profile img {
		height: 150px;
		width: 150px;
		object-fit: contain;
		object-position: center;
		border-radius: 50%;
		cursor: pointer;
	}
	button[type="submit"] {
		margin-top: 5px;
		background-color: #1A0046FF;
		border: none;
		border-radius: 5px;
		color: #FFFFFF;
		cursor: pointer;
		font-size: 16px;
	}
	button[type="submit"]:hover {
		background-color: #11101D;
	}
</style>
					
</head>

<div class="home-section">
  <div class="employee-profile py-4">
    <div class="container">
      <div class="row">
        <div class="col-lg-4">
          <div class="card shadow-sm">
            <form action="profile_picture_backend.php" method="POST" enctype="multipart/form-data" name="ex_card" class="forms-sample">
              <div class="card-header bg-transparent text-center">
			  <div class="user-profile">
				<?php
				if (isset($_SESSION['verified_user_id'])) {
					// Get the photo URL from the Firebase Storage
					$photoUrl = $bucket->object("user-profile/{$_SESSION['verified_user_id']}/{$_SESSION['verified_user_id']}.jpg")->signedUrl(new \DateTime('+1 hour'));

					// Display the user's profile image
					echo '<img id="user-image" src="' . $photoUrl . '" alt="User Profile Image" />';
				} else {
					// Display a default profile image if the user is not logged in
					echo '<img id="user-image" src="img/user-profile.jpg" alt="Default Profile Image" />';
				}
				?>
				<input id="image-input" type="file" name="image-input" />
				<br>
				<button type="submit" name="add_photo" class="btn btn-primary me-2">Update</button>
				</div>

				<h3>
             	 <?php echo $user->displayName ?>
           		</h3>
              </div>
            </form>
           
          </div>
        </div>
        <div class="col-lg-8">
          <div class="card shadow-sm">
            <div class="card-header bg-transparent border-0">
              <h4 class="mb-0">
                <i class="far fa-clone pr-1"> </i>
                General Information
              </h4>
            </div>
            <div class="card-body pt-0">
              <table class="table table-bordered">
                <tr>
                  <th width="30%"> Employee ID </th>
                  <td width="2%"> : </td>
                  <td> <?php echo $user-> uid ?> </td>
                </tr>
                <tr>
                  <th width="30%"> Role </th>
                  <td width="2%"> : </td>
                  <td>
                    <?php 
                      $claims = $auth -> getUser($user->uid)-> customClaims;
                      if(isset($claims['Superadmin']) == true) {
                        echo "SuperAdmin";
                      }
                      if(isset($claims['Admin']) == true) {                           
                        echo "Admin";
                      } elseif($claims == null){
                        echo "No roles";
                      }
                    ?>
                  </td>
                </tr>
                <tr>
                  <th width="30%"> Email Address </th>
                  <td width="2%"> : </td>
                  <td> <?=$user -> email ?> </td>
                </tr>
                <tr>
                  <th width="30%"> Contact Number </th>
                  <td width="2%"> : </td>
                  <td> <?=$user -> phoneNumber ?> </td>
                </tr>
                <tr>
                  <th width="30%"> Year Started </th>
                  <td width="2%"> : </td>
                  <td> 2023 </td>
				</tr>
									<!-- <tr>
										<th width="30%"> Gender </th>
										<td width="2%">:</td>
										<td>Male</td>
									</tr> -->
									<!-- <tr>
										<th width="30%"> Religion </th>
										<td width="2%"> : </td>
										<td> Group </td>
									</tr> -->
								</table>
							</div>
						</div>
					</div>
				</div>
				<div style="height: 26px"></div>
				<div class="card shadow-sm">
					<div class="card-header bg-transparent border-0">
						<h2 class="mb-0"> Edit Profile </h2>
					</div>
					<div class="card-body pt-0">
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
							
							<input type="hidden" name="user_profile_key" value="<?=$uid;?>">

							<label for="full_name"> Full Name </label>
							<input type="text" id="full_name" value =  "<?=$user -> displayName ?>" name="full_name" required>

							<label for="phone_number"> Phone Number </label>
							<input type="text" id="phone_number" value = "<?=$user -> phoneNumber ?>" name="phone_number" pattern="{10}">
							
							<label for="email_address"> Email Address </label>
							<input type="email" id="email_address" value = "<?=$user -> email ?>" name="email_address" required>
						
							<input type="submit" name = "user_profile_submit_button" value="Save">

							<td></td>
							<div class="divider"></div> 
							<h2></h2>

							<br>
							<h2> Privacy Settings </h2>
							
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
									
									<input type="submit" name = "change_password_button_user" value="Change Password">
							</form>
						</form>
						<?php
							} catch (\Kreait\Firebase\Exception\Auth\UserNotFound $e) {
								echo $e->getMessage();
							}
						?> 
          			</div>
        		</div>
      		</div>
    	</div>
  	</div>
	    
	  <script>
	  var firebaseConfig = {
	    apiKey: "AIzaSyDDJJulzEgxSoi7j1PM80DcS5qOn6e8j7Q",
	    authDomain: "system-inventory-management.firebaseapp.com",
	    projectId: "system-inventory-management",
	    storageBucket: "gs://system-inventory-management.appspot.com",
	    databaseURL: "https://system-inventory-management-default-rtdb.firebaseio.com/",
	  };
	  firebase.initializeApp(firebaseConfig);

	  // Get references to the image input and user image
	  var imageInput = document.getElementById("image-input");
	  var userImage = document.getElementById("user-image");

	  // Listen for changes in the input file
	  imageInput.addEventListener("change", function (event) {
	    var file = event.target.files[0];
	    var storageRef = firebase.storage().ref("user-profiles/" + file.name);

	    // Upload the file to Firebase Storage
	    var uploadTask = storageRef.put(file);

	    // Listen for upload completion
	    uploadTask.on(
	      "state_changed",
	      null,
	      function (error) {
	        // Handle upload error
	        console.error("Error uploading image:", error);
	      },
	      function () {
	        // Upload completed successfully
	        uploadTask.snapshot.ref.getDownloadURL().then(function (downloadURL) {
	          // Update the user image source and save the download URL in Firebase Realtime Database
	          userImage.src = downloadURL;

	          var databaseRef = firebase.database().ref("users/" + "<?php echo $user->userId ?>");
	          databaseRef.update({
	            photoUrl: downloadURL,
	          });
	        });
	      }
	    );
	  });
	</script>
</body>
</html>



