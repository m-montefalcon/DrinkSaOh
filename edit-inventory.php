
<?php
include('admin_auth.php');
include('includes/header.php');




?>



  <body>
    <div class="container">
        <div class="row justify-content-center">
          <div class="col-md-12">
          <div class="card">
                <div class="card-header">
                    <h4>
                    EDIT INVENTORY
                    <a href="index.php" class="btn btn-danger float-end"> Back</a>
                    </h4>
                    </div>
                    <div class="card-body">
                    <?php
                      include('dbcon.php');
                      
                      if(isset($_GET['id'])){
                        $key_child = $_GET['id'];
                        $ref_table = "inventory";
                        $getData = $database->getReference($ref_table) -> getChild($key_child) -> getValue();
                        if($getData > 0)
                        {
                            ?>
                        

                        <form action="code.php" method="POST">
    
                        <div class="row">
                        <input type="hidden" name="key" value="<?=$key_child;?>">
                        <div class="col-md-4 form-group mb-3">
                            <label for=""> Name</label>
                            <input type="text" name="product_name" value = "<?=$getData['productName'];?>" class="form-control">
                            </div>
                            
                            <div class="col-md-4 form-group mb-3">
                            <label for="">SKU</label>
                            <input type="text" name="sku_number" value = "<?=$getData['skuId'];?>" class="form-control" maxlength="13">
                            </div>
                            <div class="col-md-4 form-group mb-3">
                            <label for="">QTY</label>
                            <input type="number" name="sku_qty" value = "<?=$getData['skuQtyId'];?>" class="form-control">
                            </div>
                            
                            <div class="col-md-4 form-group mb-3">
                            <label for="">Supplier Name</label>
                            <input type="text" name="supplier_name" value = "<?=$getData['supplier_name'];?>" class="form-control">
                            </div>
                            <div class="col-md-4 form-group mb-3">
                            <label for="">Price per quantity</label>
                            <input type="number" name="price_qty" step=".01" value = "<?=$getData['priceQuantity'];?>" class="form-control">
                            </div>
                    </div>
                    <button type = "submit" name = "edit_inventory" class = "btn btn-primary">Save</button>

                    </form>
                    
                </div>
                <?php
                             }
                        else {
                          $_SESSION['status'] =  "Invalid";
                          header('Location: index.php');
                          exit();
                          
                        }

                      }
                      else {
                        $_SESSION['status'] =  "Not Found";
                        header('Location: index.php');
                        exit();
                        
                      }            
                          ?>
          </div>
        </div>
    </div>

<?php 
include('includes/footer.php');
?>
    