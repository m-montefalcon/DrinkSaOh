<?php
include('admin_auth.php');
include('includes/side-navbar.php');
include('authentication.php');
?>

<!DOCTYPE html>
<html>
<head>
  <meta name="viewport" content="width=device-width, initial-scale=1">
<style>
  body {
    font-family: Arial, sans-serif;
    background-color: #f2f2f2;
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
  .form-grid {
    display: grid;
    grid-template-columns: repeat(1, 1fr);
    grid-template-rows: repeat(2, auto);
    grid-gap: 20px;
  }
  @media screen and (min-width: 768px) {
    .form-grid {
      grid-template-columns: repeat(3, 1fr);
    }
  }
  @media screen and (max-width: 767px) {
    .form-grid {
      grid-template-columns: repeat(1, 1fr);
    }
  }
  .form-group {
    display: flex;
    flex-direction: column;
  }
  .form-group label {
    margin-bottom: 5px;
  }
  .form-group input {
    background-color: #F2F2F2;
    border: none;
    border-radius: 5px;
    box-shadow: inset 0px 0px 5px #BDBDBD;
    font-size: 14px;
    padding: 10px;
    width: 100%;
  }
  .form-group input:focus {
    background-color: #FFFFFF;
    box-shadow: inset 0px 0px 5px #9C27B0FF;
    color: black;
    outline: none;
  }
  .form-actions {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-top: 20px;
  }
  .form-actions button {
    text-align: center;
    background-color: white;
    color: black;
    border-radius: 6px;
    width: 80px;
    height: 30px;
    display: flex;
    justify-content: center;
    align-items: center;
  }
  .form-actions button[type="submit"] {
    background-color: red;
    margin-left: 0%;
    border-radius: 6px;
    cursor: pointer;
  }
  button,
  a.btn-danger {
    text-align: center;
    background-color: #9C27B0FF;
    color: black;
    border-radius: 6px;
    width: 100px;
    height: 40px;
    border: none;
    margin-top: 30px;
    display: inline-block;
    vertical-align: middle;
    font-size: 20px;
    justify-content: center;
    align-items: center;
    line-height: 40px;
  }
  button[type="submit"] {
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
  button,
  a.btn-danger {
    background-color: maroon;
    margin-left: 0%;
    border-radius: 6px;
    cursor: pointer;
  }
  button[type="submit"]:hover {
    background-color: #1A0046FF;
    color: white;
  }
  a.btn-danger:hover {
    background-color: #11101D;
    color: white;
  }
  .card {
    padding: 15px;
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
    margin-bottom: 10px;
    font-weight: bold;
  }
  button[type="submit"]:hover {
    background-color: #11101D;
  }
  select {
    padding: 8px;
    border: 2px solid #ccc;
    border-radius: 5px;
    margin-right: 8px;
    width: 100%;
    background-color: #F2F2F2;
    box-shadow: inset 0px 0px 5px #BDBDBD;
    font-size: 14px;
  } 
  body::-webkit-scrollbar {
    width: 5px; 
  }
  body::-webkit-scrollbar-track {
    background-color: #f6f6f6; 
  }
  body::-webkit-scrollbar-thumb {
    background-color: #ccc; 
  }
  body::-webkit-scrollbar-thumb:hover {
    background-color: #aaa; 
  }
</style>
</head>

<body>
  <div class="card">
    <div class="card-header">
      <h2>
        EDIT INVENTORY  
      </h2>
    </div>
    <div class="card-body">
      <?php
        include('dbcon.php');
        if(isset($_GET['id'])) {
          $key_child = $_GET['id'];
          $ref_table = "inventory";
          $getData = $database->getReference($ref_table) -> getChild($key_child) -> getValue();
          if($getData > 0) {
      ?>           
      <form action="code.php" method="POST">
        <div class="form-grid">
          <input type="hidden" name="key" value="<?=$key_child;?>">
          <div class="col-md-4 form-group mb-3">
            <label for=""> Product Name </label>
            <input type="text" name="product_name" value = "<?=$getData['productName'];?>" class="form-control">
          </div>
          <div class="col-md-4 form-group mb-3">
            <label for=""> SKU </label>
            <input type="text" name="sku_number" value = "<?=$getData['skuId'];?>" class="form-control" maxlength="13">
          </div>
          <div class="col-md-4 form-group mb-3">
            <label for=""> Quantity </label>
            <input type="number" name="sku_qty" value = "<?=$getData['skuQtyId'];?>" class="form-control">
          </div>
          <div class="col-md-4 form-group mb-3">
            <label for=""> Supplier Name </label>
            <input type="text" name="supplier_name" value = "<?=$getData['supplier_name'];?>" class="form-control">
          </div>
          <div class="col-md-4 form-group mb-3">
              <label for=""> Critical Point</label>
              <input type="number" name="critical_point" value = "<?=$getData['criticalPoint'];?>" class="form-control" required>
          </div>
          <div class="col-md-4 form-group mb-3">
            <label for=""> Overstock Point</label>
            <input type="number" name="overstock_point" value = "<?=$getData['overstockPoint'];?>" class="form-control" required>
          </div>
          <div class="col-md-4 form-group mb-3">
              <label for=""> Supplier Price </label>
              <input type="number" name="supplier_price" class="form-control" value = "<?=$getData['supplierPrice'];?>" step=".01" required>
          </div>
          <div class="col-md-4 form-group mb-3">
            <label for=""> Unit Price </label>
            <input type="number" name="price_qty" step=".01"  value = "<?=$getData['priceQuantity'];?>" class="form-control">
          </div>
          <div class="col-md-4 form-group mb-3">
            <label for=""> Category </label>
            <select name="select_category_user" class="form-select form-select-lg mb-3" aria-label=".form-select-lg example" required>
              <option value="Bottled" <?php if ($getData['productCategory'] === 'Bottled') { echo 'selected'; } ?>>Bottled</option>
              <option value="Canned" <?php if ($getData['productCategory'] === 'Canned') { echo 'selected'; } ?>>Canned</option>
            </select>
          </div>
        </div>
        <button type = "submit" name = "edit_inventory" class = "btn btn-primary"> Save </button>
        <a href="index.php" class="btn btn-danger float-end" onclick="history.back()"> Cancel </a>
      </form>
    </div>
      <?php
        }
        else {
          $_SESSION['status'] =  "Invalid";
          header('Location: index.php');
          exit();
        }
      } else {
        $_SESSION['status'] =  "Not Found";
        header('Location: index.php');
        exit();
      }            
      ?>
  </div>
</body>
</html>

<?php 
include('includes/footer.php');
?>