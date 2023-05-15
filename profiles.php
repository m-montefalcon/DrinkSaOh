<?php
include('admin_auth.php');
include('includes/side-navbar.php');
?>

<!DOCTYPE html>
<html>
<head>
  <title> Profiles </title>
	<meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
<style>
@import url('https://fonts.googleapis.com/css2?family=Poppins:wght@200;300;400;500;600;700&display=swap');
* {
  box-sizing: border-box;
  margin: 0;
  padding: 0;
  }
  body{
    background-color: #f6f6f6;
    overflow: hidden;
  } 
  .card {
    background-color: #fff;
    border-radius: 10px;
    border: none;
    position: relative;
    margin-bottom: 30px;
    box-shadow: 0px 0px 10px #BDBDBD;
    width: fit-content;
  }
  .row {
    display: flex;
    justify-content: space-between;
    flex-wrap: wrap;
  }
  .col-md-12 {
    flex-basis: calc(100% - 0px);
    margin-bottom: 8px;
  }
  tr {
    text-align: center;
  }
  tbody .btn {
    background-color: transparent;      
    border: none;
  }
  tbody .btn:hover {
    background-color: maroon;      
    padding: 5px;
    border-radius: 5px;
    cursor: pointer;
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
  .card-footer {
    background-color: transparent;
    padding: 20px 25px;
  }
  .table:not(.table-sm) thead th {
    border-bottom: none;
    background-color: #e9e9eb;
    color: #666;
    padding-top: 15px;
    padding-bottom: 15px;
    text-align: center;
  }
  tr:hover {
    background-color: #f5f5f5;
  } 
  table tr {
  background-color: #f8f8f8;
  border: 1px solid #ddd!important;
  margin-bottom: 10px;
  }
  table th,
  table td {
    padding: .5em;
    text-align: left;
  }
  table td {
    font-size: .85em;
    letter-spacing: .05em;
    text-align: center;
  }
  form .btn-sm::before {
    content: "\e068"; 
    font-family: "Font Awesome 5 Free"; 
    font-weight: bold;
    font-size: 20px;
    color: black;
  }
  .btn-primary::before {
    content: "\f4ff"; 
    font-family: "Font Awesome 5 Free"; 
    font-weight: bold;
    font-size: 20px;
    color: black;
  }
  form .btn-danger::before {
    content: "\f1f8"; 
    font-family: "Font Awesome 5 Free"; 
    font-weight: bold;
    font-size: 20px;
    color: black;
  }
  .btn {
    background-color: transparent;      
    border: none;
  }
  .home-section::-webkit-scrollbar {
    width: 5px; 
  }
  .content::-webkit-scrollbar-track {
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
  <section class="home-section">
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
            <h2>
              PROFILES
            </h2>
          </div>
          <div class="card-body">
            <table class="table table-bordered table-stripe">
              <thead>
                <tr>
                  <th>#</th>
                  <th>EMPLOYEE ID</th>
                  <th>ROLES</th>
                  <th>FULL NAME</th>
                  <th>EMAIL ADDRESS</th>
                  <th>CONTACT NUMBER</th>
                  <!-- <th>CREATED</th> -->
                  <th>ACCOUNT STATUS</th>
                  <th>EDIT</th>
                  <th>DELETE</th>
                </tr>
              </thead>
              <tbody>
                <?php                 
                  include('dbcon.php');
                  $users = $auth->listUsers();

                  $i = 1;
                  
                  foreach( $users as $user) {
                ?>
                <tr>
                  <td><?=$i++;?></td>
                  <td><?=$user -> uid?></td>
                  <td>
                    <?php 
                      $claims = $auth -> getUser($user->uid)-> customClaims;
                      if(isset($claims['Superadmin']) == true) {
                        echo "SuperAdmin";
                      }
                      if(isset($claims['Admin']) == true) {                           
                        echo "Admin";
                      } elseif($claims == null) {
                        echo "No roles";
                      }
                    ?>
                  </td>
                  <td><?=$user -> displayName ?></td>
                  <td><?=$user -> email ?></td>
                  <td><?=$user -> phoneNumber ?></td>
                  <!-- <td><?=$user -> date_create ?></td> -->
                  <td>
                    <form action="edit_account_settings_screens.php" method = "GET">
                      <a href="edit_account_settings_screens.php?uid=<?=$user->uid?>" class="btn btn-primary btn-sm"></a>
                    </form>
                      <?php                           
                        if($user -> disabled) {
                          echo "Disabled";
                        } else {
                          echo  "Enabled";
                        }                       
                      ?> 
                  </td>
                  <td>
                    <a href="user-edit.php?id=<?=$user -> uid?>" class="btn btn-primary"> </a>
                  </td>                   
                  <td>                         
                    <form action="userCred.php" method = "POST">
                      <button type="submit" name = "user_delete_button" value= "<?=$user -> uid?>" class = "btn btn-danger btn-sm" value = "<?=$key?>"> </button>
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
  </section>
</body>
</html>
    
<?php 
include('includes/footer.php');
?>  