
<?php

use Kreait\Firebase\Value\Uid;
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
                  INVENTORY
                  <a href="add-inventory.php" class="btn btn-primary float-end"> Add User</a>
                </h4>
              </div>
              <div class="card-body">
                <table class="table table-bordered table-stripe">
                  <thead>
                    <tr>
                      <th>Number</th>
                      <th>EmpID</th>
                      <th>SKU</th>
                      <th>QTY</th>
                      <th>BARCODE</th>
                      <th>DATE</th>
                      <th>TIME</th>
                      <th>Edit</th>
                      <th>Delete</th>
                    </tr>
                  </thead>
                  <tbody>
                    <?php
                    include ('dbcon.php');
                    $ref_inventory = 'inventory';
                    $fetchInventory = $database->getReference($ref_inventory) -> getValue();
                    $users = $auth->listUsers();

                    if ($fetchInventory > 0) {
                      $i = 1;
                      foreach($fetchInventory as $key => $row){
                        
                        ?>
                        <tr>
                         <td><?=$i++;?></td>
                         <td><?=$row['eId']?></td>
                         <td><?=$row['skuId']?></td>
                         <td><?=$row['skuQtyId']?></td>
                         <td><?=$row['barcode']?></td>
                         <td><?=$row['currentDate']?></td>
                         <td><?=$row['currentTime']?></td>
                         <td>
                          <a href="edit-inventory.php?id=<?=$key?>" class="btn btn-primary btn-sm">Edit</a>

                         </td>
                         <td>
                          <!-- <a href="delete-inventory.php" class="btn btn-danger btn-sm">Delete</a> -->
                          <form action="code.php" method = "POST">
                            <button type="submit" name = "delete_button" class = "btn btn-danger btn-sm" value = "<?=$key?>">Delete</button>
                          </form>

                         </td>


                        
                        
                        </tr>


                        <?php



                      }
                    } else{
                      ?>
                      <tr>
                        <td colspan="3">
                          No record Found
                        </td>
                      </tr>
                      <?php 
                    }
                    ?>
                    <tr>
                      <td></td>
                    </tr>
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
    