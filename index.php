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
  <title> Inventory </title>
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
    width: 100%;
  }
  tr {
    text-align: center;
  }
  button.add-btn {
    position: absolute;
    text-align: center;
    background-color: white;
    color: black;
    border-radius: 6px;
    width: 100px;
    height: 30px;
    margin-left: 0%;
    right: 20px;
    justify-content: center;
    align-items: center;
    top: 10px;
    padding: 0 10px;
  }
  button.add-btn:hover {
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
  .low-quantity {
    background-color: red;
  }
  .category-select {
    display: flex;
    justify-content: flex-end;
    align-items: center;
    position: fixed;
    bottom: 0;
    right: 0;
    padding: 0 20px;
  }
  select {
    padding: 8px;
    font-size: 16px;
    border: 1px solid #ccc;
    border-radius: 4px;
    margin-right: 8px;
    width: 115px;
  }
  button {
    padding: 8px 16px;
    font-size: 16px;
    background-color: #1A0046FF;
    color: white;
    border: none;
    border-radius: 4px;
    cursor: pointer;
  }
  button:hover {
    background-color: #11101D;
  }
  .add-btn {
    position: absolute;
    text-align: center;
    background-color: white;
    color: black;
    border-radius: 6px;
    width: 100px;
    height: 30px;
    margin-left: 0%;
    right: 20px;
    justify-content: center;
    align-items: center;
    top: 10px;
    display: flex;
    padding: 0 10px;
  }
  .add-btn:hover {
    background-color: maroon;
    margin-left: 0%;
    border-radius: 6px;
    color: white;
  }
  .container {
    display: flex;
    padding: 15px;
    overflow: auto; 
  }
  #table {
    position: relative;
    height: 300px;
    width: 100%; 
    overflow: scroll; 
  }
  #table table {
    width: fit-content; 
    table-layout: fixed;
  }
  .table:not(.table-sm) tbody th {
    border-bottom: none;
    background-color: #e9e9eb;
    color: black;
    padding-top: 15px;
    padding-bottom: 15px;
    text-align: center;
    position: sticky;
    top: 0px;
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
    text-transform: uppercase;
    text-align: center;
  }
  #table tbody {
    white-space: nowrap; 
    display: block;
  }
  #table::-webkit-scrollbar {
    width: 4px;
    height: 6px;
  }
  #table::-webkit-scrollbar-track {
    background-color: #f1f1f1;
  }
  #table::-webkit-scrollbar-thumb {
    background-color: #888;
    border-radius: 4px;
  }
  #table::-webkit-scrollbar-thumb:hover {
    background-color: #555;
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


      .stock-in-btn {
      background-color: blue;
      color: white;
    }

    .stock-out-btn {
      background-color: red;
      color: white;
    }

    .modal {
  display: none;
  position: fixed;
  z-index: 1;
  left: 0;
  top: 0;
  width: 100%;
  height: 100%;
  overflow: auto;
  background-color: rgba(0, 0, 0, 0.4);
}

.modal-content {
  background-color: #fefefe;
  margin: 15% auto;
  padding: 20px;
  border: 1px solid #888;
  width: 50%;
}

.close {
  color: #aaa;
  float: right;
  font-size: 28px;
  font-weight: bold;
  cursor: pointer;
}

.close:hover,
.close:focus {
  color: black;
  text-decoration: none;
  cursor: pointer;
}

</style>

</head>

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
  <div>
          <select id="category-select" name="select_category_name" class="form-select form-select-lg mb-3" aria-label=".form-select-lg example" required>
            <option value="All">All</option>
            <option value="Canned">Canned</option>
            <option value="Bottled">Bottled</option>
          </select>
          <button id="filter-button" type="button">FILTER</button>
        </div>
          <br>
        <div class="card">
          <div class="card-header">
            <h2>
              INVENTORY
            </h2>
            <a class="add-btn" href="add-inventory.php" class="btn btn-primary float-end"> Add Item </a>
          </div>
          <div class="card-body">
          <div id="table">
            <table class="table table-bordered table-stripe">
              <tbody>
              <tr>
              <th>#</th>
              <th>PRODUCT NAME</th>
              <th>SUPPLIER PRICE</th>
              <th>UNIT PRICE</th>
              <th>QTY</th>
              <th>TOTAL</th>
              <th>PRODUCT CODE</th>
              <th>CATEGORY</th> <!-- This line was missing -->
              <th>BARCODE</th>
              <th>ACTIONS</th>
              <th>DATE</th>
              <th>EDIT</th>
              <th>DELETE</th>
            </tr>

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
                  <td>₱<?=$row['supplierPrice']?></td>
                  <td>₱<?=$row['priceQuantity']?></td>
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
                  <td>
                  <button onclick="openModal('in', '<?php echo $row['skuId']; ?>', '<?php echo $row['skuQtyId']; ?>', '<?php echo $row['productName']; ?>')">Stock In</button>
<button onclick="openModal('out', '<?php echo $row['skuId']; ?>', '<?php echo $row['skuQtyId']; ?>', '<?php echo $row['productName']; ?>')">Stock Out</button>
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
    </div> 
  </div>
  <div id="modal" class="modal">
    <div class="modal-content">
      <span class="close" onclick="closeModal()">&times;</span>
      <h2 id="modal-title"></h2>
      <p>SKU ID: <span id="modal-skuid"></span></p>
      <p>SKU Quantity ID: <span id="modal-skuqty"></span></p>
      <p>Product Name: <span id="modal-productname"></span></p>
      
      <form id="modal-form" action="code.php" method="POST">
  <label for="quantity">Quantity:</label>
  <input type="number" id="quantity" name="quantity" required>
  <input type="hidden" id="modal-key" name="key">
  <input type="hidden" id="modal-stockaction" name="stockAction"> 
  <input type="submit" value="Submit">
</form>

      </div>
    </div>


    <script>
  // Function to filter the table rows based on the selected category
  function filterTableRows(category) {
    const rows = document.querySelectorAll('tbody tr');

    rows.forEach(row => {
      const categoryCell = row.querySelector('td:nth-child(9)');
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

<script>
    // Function to filter the table rows based on the selected category


    function openModal(action, skuId, skuQtyId, productName) {
  var modal = document.getElementById("modal");
  var modalTitle = document.getElementById("modal-title");
  var modalSkuQty = document.getElementById("modal-skuqty");
var modalProductName = document.getElementById("modal-productname");
var modalSkuId = document.getElementById("modal-skuid");

  var form = document.getElementById("modal-form");

  modalTitle.innerHTML = action + " Form";
  modalSkuQty.innerHTML = skuQtyId;
  modalProductName.innerHTML = productName;
  modalSkuId.innerHTML = skuId;

  form.addEventListener("submit", function(event) {
    event.preventDefault();
    var quantity = document.getElementById("quantity").value;
    var keyInput = document.getElementById("modal-key");
    var stockActionInput = document.getElementById("modal-stockaction"); // New line
    keyInput.value = skuId;
    stockActionInput.value = action; // New line
    form.submit();
  });

  modal.style.display = "block";
}

    function closeModal() {
      var modal = document.getElementById("modal");
      modal.style.display = "none";
    }
  </script>

<script>
// Function to filter the table rows based on the selected category
function filterTableRows(category) {
  const rows = document.querySelectorAll('tbody tr');

  rows.forEach(row => {
    const categoryCell = row.querySelector('td:nth-child(8)');
    if (categoryCell) {
      const categoryText = categoryCell.textContent.trim();
      const display = category === 'All' || categoryText === category ? 'table-row' : 'none';
      row.style.display = display;
    }
  });
}
// Event listener for the filter button click
document.getElementById('filter-button').addEventListener('click', function() {
  const selectElement = document.getElementById('category-select');
  const selectedCategory = selectElement.value;
  console.log('Selected Category:', selectedCategory);
  filterTableRows(selectedCategory);
});

</script>


</body>
</html>
    
<?php 
include('includes/footer.php');
?>
