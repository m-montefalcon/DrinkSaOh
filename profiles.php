
<?php

include('admin_auth.php');
include('includes/header.php');



?>

  <body>
    <div class="container">
        <div class="row">
          <div class="col-md-12">
            <?php
              if (isset($_SESSION['status'])) {
                echo "<h5 class = 'alert alert-success'>".$_SESSION['status']."</h5>";
                unset($_SESSION['status']);
              }
            
            ?>
            <div class="card">
              <div class="card-header">
                <h4>
                  PROFILES
                </h4>
              </div>
              <div class="card-body">
                <table class="table table-bordered table-stripe">
                  <thead>
                    <tr>
                      <th>#</th>
                      <th>EMPLOYEE ID</th>
                      <th>ROLES</th>
                      <th>FULL NAME</th>
                      <th>EMAIL</th>
                      <th>PHONE NUMBER</th>
                      <th>Account Status</th>
                      <th>EDIT</th>
                      <th>DELETE</th>
                      
                    </tr>
                  </thead>
                  <tbody>
                    <?php 
                    
                    include('dbcon.php');
                    $users = $auth->listUsers();

                    $i = 1;

                    foreach( $users as $user){

                      ?>

                      <tr>
                        <td><?=$i++;?></td>
                        <td><?=$user -> uid?></td>

                        <td>

                        <?php 

                            $claims = $auth -> getUser($user->uid)-> customClaims;
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
                            
                        </td>
                        <td><?=$user -> displayName ?></td>
                        
                        <td><?=$user -> email ?></td>
                        <td><?=$user -> phoneNumber ?></td>
                        <td>
                          <?php
                          
                          if($user -> disabled){
                            echo "Disable";
                          }else{
                            echo  "Enable";
                          }
                          
                          ?> 
                         <form action="edit_account_settings_screens.php" method = "GET">
                           <a href="edit_account_settings_screens.php?uid=<?=$user->uid?>" class="btn btn-primary btn-sm">Edit Status</a>
                          </form>
                        </td>
                        

                        <td>
                        <a href="user-edit.php?id=<?=$user -> uid?>" class="btn btn-primary">Edit</a>
                        </td>
                        <td>
                        <form action="userCred.php" method = "POST">
                            <button type="submit" name = "user_delete_button" value= "<?=$user -> uid?>" class = "btn btn-danger btn-sm" value = "<?=$key?>">Delete</button>
                          </form>
                        </td>
                        
                        




                      </tr>

                      <?php

                    }
                    
                    
                    
                    ?>


                  </tbody>
                </table>
              </div>
            </div>
          </div>
        </div>
    </div>

<?php 
include('includes/footer.php');
?>
    