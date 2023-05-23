<?php
use Kreait\Firebase\Value\Uid;
include('admin_auth.php');
include('includes/side-navbar.php');

function formatTime($time) {
  $timestamp = strtotime($time);
  return date("h:i:s", $timestamp);
}

function formatDate($date) {
  return date("m/j/y", strtotime($date));
}
?>

<!DOCTYPE html>
<html>
<head>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css"></link>
<style>
  * {
    box-sizing: border-box;
    margin: 0;
    padding: 0;
  }
  body {
    background-color: #f6f6f6;
    overflow-x: hidden;
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
  button .btn-primary {
    position: absolute;
    text-align: center;
    background-color: white;
    color: black;
    border-radius: 6px;
    width: 80px;
    height: 30px;
    margin-left: 0%;
    right: 20px;
    display: flex;
    justify-content: center;
    align-items: center;
    top: 10px;
  }
  button .btn-primary:hover {
    background-color: maroon;
    margin-left: 0%;
    border-radius: 6px;
    color: white;
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
  .btn-sm::before {
    content: "\f044"; 
    font-family: "Font Awesome 5 Free"; 
    font-weight: bold;
    font-size: 20px;
    color: black;
  }
  .btn-danger::before {
    content: "\f1f8"; 
    font-family: "Font Awesome 5 Free"; 
    font-weight: bold;
    font-size: 20px;
    color: black;
  }
  tbody .btn {
    background-color: transparent;      
    border: none;
  }
  tbody .btn:hover {
    background-color: red;      
    padding: 6px;
    border-radius: 6px;
    cursor: pointer;
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
    padding: 1em;
    text-align: left;
  }
  table td {
    font-size: .85em;
    letter-spacing: .05em;
    text-transform: uppercase;
    text-align: center;
  }
  .content::-webkit-scrollbar {
    width: 5px; 
  }
  .content::-webkit-scrollbar-track {
    background-color: #f6f6f6; 
  }
  .content::-webkit-scrollbar-thumb {
      background-color: #ccc; 
  }
  .content::-webkit-scrollbar-thumb:hover {
    background-color: #aaa; 
  }  
  .low-quantity {
  background-color: red;
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
              INVENTORY
            </h2>
            
            <button>
              <a href="add-inventory.php" class="btn btn-primary float-end"> Add Item </a>
            </button>
          </div>
          <div style="margin-right: auto;">
            <select id="category-select" name="select_category_name" class="form-select form-select-lg mb-3" aria-label=".form-select-lg example" required>
              <option value="All">All</option>
              <option value="Canned">Canned</option>
              <option value="Bottled">Bottled</option>
            </select>
            <button id="filter-button" type="button">FILTER</button>
          </div>
          <div class="card-body">
            <table class="table table-bordered table-stripe">
              <thead>
                <tr>
                  <th>#</th>
                  <th>PRODUCT NAME</th>
                  <th>SUPPLIER PRICE</th>
                  <th>UNIT PRICE</th>
                  <th>QTY</th>
                  <th>TOTAL</th>
                  <th>PRODUCT CODE</th>
                  <th>CATEGORY</th>
                  <th>BARCODE</th>
                  <th>DATE</th>
                  <th>EDIT</th>
                  <th>DELETE</th>
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
                    foreach($fetchInventory as $key => $row) {    
                ?>
                <tr>
                  <td><?=$i++;?></td>
                  <td><?=$row['productName']?></td>
                  <td>₱<?=$row['priceQuantity']?></td>
                  <td>₱<?=$row['supplierPrice']?></td>
                  
                  <td <?php if ($row['skuQtyId'] <= ($row['criticalPoint'])) { echo 'class="low-quantity"'; } ?>>
                  <?=$row['skuQtyId']?>
                </td>
                  <td>₱<?=$row['totalPrice']?></td>
                  <td><?=$row['skuId']?></td>
                  <td><?=$row['productCategory']?></td>
                  <td>
                    <?php
                      if(strpos($row['barcode'], "image/svg+xml;base64") !== false) {
                        echo "<img src='".$row['barcode']."' />";
                      } else {
                        echo $row['barcode'];
                      }
                    ?>
                  </td>
                  <td><?= formatDate($row['currentDate']) ?> 
                    <br> <?= formatTime($row['currentTime']) ?> 
                  </td>
                  
                  <td>
                    <a href="edit-inventory.php?id=<?=$key?>" class="btn btn-primary btn-sm"> </a>
                  </td>
                  <td>
                    <form action="code.php" method = "POST">
                      <button type="submit" name = "delete_button" class = "btn btn-danger btn-sm" value = "<?=$key?>"></button>
                    </form>
                  </td>            
                </tr>
                <?php
                  }
                } else {
                ?>
                <tr>
                  <td colspan="3"> No record Found </td>
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
  <script>
    let menu = document.querySelector('#menu-icon');
    let sidenavbar = document.querySelector('.side-navbar');
    let content = document.querySelector('.content');
    
    menu.onclick = () => {
      sidenavbar.classList.toggle('active');
      content.classList.toggle('active');
    }
  </script>
  <script>
    // Function to filter the table rows based on the selected category
    function filterTableRows(category) {
      const rows = document.querySelectorAll('tbody tr');

      rows.forEach(row => {
        const categoryCell = row.querySelector('td:nth-child(8)');
        const display = category === 'All' || categoryCell.textContent === category ? 'table-row' : 'none';
        row.style.display = display;
      });
    }

    // Event listener for the filter button click
    document.getElementById('filter-button').addEventListener('click', function() {
      const selectElement = document.getElementById('category-select');
      const selectedCategory = selectElement.value;
      filterTableRows(selectedCategory);
    });
  </script>

</body>
</html>
    
<?php 
include('includes/footer.php');
?>


<!-- <td>
  <form action="code.php" method = "POST">
  <input type="checkbox" id="check">
    <label type="submit" class = "btn btn-danger btn-sm" for="check"></label>
    <div class="background"></div>
    <div class="alert_box">
      <div class="icon">
        <i class="fas fa-exclamation"></i>
      </div>
      <header>Confirm</header>
      <p>Are you sure want to permanently delete this Item?</p>
      <div class="btns">
        <label for="check" type="submit" name = "delete_button" value = "<?=$key?>"> Delete</label>
        <label for="check">Cancel</label>
      </div>
    </div>
  </form>
</td>    -->
 <!-- <a type="submit" name = "delete_button" class = "btn btn-danger btn-sm" value = "<?=$key?>"> </a> -->   