<?php
session_start();
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
  button,
  a.btn-danger {
    text-align: center;
    background-color: white;
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
  button[type="submit"]:hover {
    background-color: #11101D;
  }
  .home-section::-webkit-scrollbar {
    width: 5px; 
  }
  .home-section::-webkit-scrollbar-track {
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
  <div class="home-section">
    <div class="row justify-content-center">
      <div class="col-md-12">
        <div class="card">
          <div class="card-header">
            <h2>
              ADD INVENTORY
            </h2>
          </div>
          <div class="card-body">
            <form action="code.php" method="POST">
              <div class="form-grid">
                <div class="col-md-4 form-group mb-3">
                    <label for=""> Product Name </label>
                    <input type="text" name="product_name" class="form-control" required>     
                </div>
                <div class="col-md-4 form-group mb-3">
                    <label for=""> SKU </label>
                    <input type="text" name="sku_number" class="form-control" maxlength="13" required>
                </div>
                <div class="col-md-4 form-group mb-3">
                    <label for=""> Quantity </label>
                    <input type="number" name="sku_qty" class="form-control" required>
                </div>
                <div class="col-md-4 form-group mb-3">
                    <label for=""> Supplier Name </label>
                    <input type="text" name="supplier_name" class="form-control" required>     
                </div>
                <div class="col-md-4 form-group mb-3">
                    <label for=""> Unit Price </label>
                    <input type="number" name="price_qty" class="form-control" step=".01" required>
                </div>
              </div>
              <button type = "submit" name = "add_inventory" class = "btn btn-primary"> Add </button>
              <a href="index.php" class="btn btn-danger float-end" onclick="history.back()"> Cancel </a>
            </form>
                <?php                     
                ?>
          </div>    
        </div>
      </div>
    </div>
  </div>
</body>
</html>

<?php 
include('includes/footer.php');
?>
    