
<?php
session_start();
include('includes/header.php');
include('authentication.php');


?>



<body>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <h4>
                            ADD INVENTORY
                            <a href="index.php" class="btn btn-danger float-end"> Back</a>
                        </h4>
                    </div>
                          
                    <div class="card-body">
                        <form action="code.php" method="POST">
                            <div class="row">
                                <div class="col-md-4 form-group mb-3">
                                    <label for=""> Name</label>
                                    <input type="text" name="product_name" class="form-control" required>     
                                </div>
                                <div class="col-md-4 form-group mb-3">
                                    <label for="">SKU</label>
                                    <input type="text" name="sku_number" class="form-control" maxlength="13" required>
                                </div>
                                <div class="col-md-4 form-group mb-3">
                                    <label for="">QTY</label>
                                    <input type="number" name="sku_qty" class="form-control" required>
                                </div>
                                <div class="col-md-4 form-group mb-3">
                                    <label for=""> Supplier Name</label>
                                    <input type="text" name="supplier_name" class="form-control" required>     
                                </div>
                                <div class="col-md-4 form-group mb-3">
                                    <label for="">Price per quantity</label>
                                    <input type="number" name="price_qty" class="form-control" step=".01" required>
                                </div>
                                
                            </div>
                            <button type="submit" name="add_inventory" class="btn btn-primary">Save</button>
                        </form>
                        <?php                     
                        ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
  
    <?php 
    include('includes/footer.php');
    ?>
</body>

    