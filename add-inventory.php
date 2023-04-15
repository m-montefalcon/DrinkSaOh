
<?php
session_start();
include('includes/header.php');
include('authentication.php');


?>
 <style>
    body {
      font-family: Arial, sans-serif;
      background-color: #f2f2f2;
    }
    
    form {
      background-color: #fff;
      border-radius: 5px;
      padding: 20px;
      width: 400px;
      margin: 50px auto;
      box-shadow: 0px 0px 10px #ccc;
    }
    
    label {
      display: block;
      margin-bottom: 10px;
      font-weight: bold;
    }
    
    input[type="text"],
    input[type="tel"],
    input[type="email"],
    input[type="password"] {
      width: 100%;
      padding: 10px;
      border: 1px solid #ccc;
      border-radius: 3px;
      margin-bottom: 20px;
    }
    
    input[type="submit"] {
      background-color: #4CAF50;
      color: white;
      padding: 10px 20px;
      border: none;
      border-radius: 3px;
      cursor: pointer;
    }
    
    input[type="submit"]:hover {
      background-color: #45a049;
    }


  </style>
  <body>
    <div class="container">
        <div class="row justify-content-center">
          <div class="col-md-12">
          <div class="card">
                <div class="card-header">
                    <h4>
                    ADD INVENTORY
                    <a href="index.php" class="btn btn-danger float-end"> Add User</a>
                    </h4>
                    </div>
                          
                    <div class="card-body">
                        <form action="code.php" method="POST">
                        <div class="row">
                           
                        
                            <div class="col-md-4 form-group mb-3">
                            <label for="">SKU</label>
                            <input type="text" name="sku_number" class="form-control" maxlength="6" required>
                            </div>
                            <div class="col-md-4 form-group mb-3">
                            <label for="">QTY</label>
                            <input type="number" name="sku_qty" class="form-control" required>
                            </div>
                    </div>
                    <button type = "submit" name = "add_inventory" class = "btn btn-primary">Save</button>

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
    