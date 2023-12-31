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
    /* margin-bottom: 30px; */
    box-shadow: 0px 0px 10px #BDBDBD;
    width: 100%;
  }
  tr {
    text-align: center;
  }
  h3 {
    font-weight: bold;
    color: black;
    font-size: 30px;
    letter-spacing: .05em;
    text-transform: uppercase;
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
  .category-select {
    display: flex;
    justify-content: flex-end;
    align-items: center;
    position: fixed;
  }
  .search-input {
    display: flex;
    justify-content: flex-end;
    align-items: center;
    position: fixed;
    bottom: 0;
    right: 0;
    padding: 0 20px;
  }
  .filtercritical {
    display: flex;
    justify-content: flex-end;
    align-items: center;
    position: fixed;
    bottom: 0;
    right: 0;
    padding: 0 20px;
  }
  #search-input {
    margin-right: 8px;
    padding: 8px;
  }
  #reset-button {
    margin-right: 8px;
  }
  select {
    padding: 8px;
    font-size: 16px;
    border: 1px solid #ccc;
    border-radius: 4px;
    margin-right: 8px;
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
    flex-direction: column;
    padding: 15px;
    padding-top: 2px;
    overflow: auto; 
  }
  .table {
    width: 100%;
  }
  #table {
    position: relative;
    height: 400px;
    width: 100%; 
    overflow: scroll; 
    width: 100%;
    height: auto;
    max-height: 400px;
  }
  #table-res table {
    width: fit-content; 
    table-layout: fixed;
    width: 100%;
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
  #table-res tbody {
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
    border: 3px solid #11101D;
    width: 50%;
  }
  input[type="submit"] {
		background-color: #11101D;
		border: none;
		border-radius: 5px;
		color: #FFFFFF;
		cursor: pointer;
		margin-top: 20px;
		padding: 3px;
		width: 100px;
	}
  .close {
    color: #aaa;
    float: right;
    font-size: 28px;
    font-weight: bold;
    cursor: pointer;
    margin-left: auto;
  }
  .close:hover,
  .close:focus {
    color: black;
    text-decoration: none;
    cursor: pointer;
  }
  td .actions-container {
    display: flex;
    gap: 5px;
  }
  td .actions-container button {
    flex: 1;
    width: 110px;
  }
  .low-quantity {
    background-color: lightcoral;
    font-weight: bold;
    /* color: red; */
    /* border: 2px solid red; */
  }
  .overstock {
    background-color: lightblue;
    /* font-weight: bold; */
    /* color: yellow; */
    /* border: 2px solid blue; */
  }
  .container-form {
    display: flex;
    justify-content: space-between;
    align-items: flex-start;
    margin-bottom: 10px;
  }
  .query-form {
    display: flex;
    flex-direction: row;
    
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
        <div class="container-form">
          <span>
            <?php 
              $ref_table = "inventory";

              $totalQtySnapshot = $database->getReference($ref_table)
              ->orderByChild('skuId')
              ->getSnapshot();

              $totalQty = 0;
              if ($totalQtySnapshot->hasChildren()) {
                foreach ($totalQtySnapshot->getValue() as $inventory) {
                    $totalQty += $inventory['skuQtyId'];
                }
              }
              echo "<strong> Inventory stock on hand: </strong>" . $totalQty;
            ?>
            <br>
            <span>
              <?php
                $inventoryRef = $database->getReference('inventory');
                $inventoryValue = $inventoryRef->getValue();

                $totalPriceSum = 0;
                if ($inventoryValue) {
                  foreach ($inventoryValue as $inventoryValues) {
                    if (isset($inventoryValues['totalPrice'])) {
                      $totalPriceSum += $inventoryValues['totalPrice'];
                    }
                  }
                }
                echo '<strong> Inventory total amount value: </strong> ₱' . $totalPriceSum . '</p>';
              ?>       
            </span>
          </span>
          <div class="query-form">
            <select id="category-select" name="select_category_name" class="form-select form-select-lg mb-3" aria-label=".form-select-lg example" required>
              <option value="Category" disabled selected>Category</option>
              <option value="All">All</option>
              <option value="Canned">Canned</option>
              <option value="Bottled">Bottled</option>
              <option value="Plastic">Plastic</option>
            </select>
          <br>

            <input id="search-input" type="text" placeholder="Search by name or SKU">
            <br>

            <select id="filtercritical" name="select_category_name" class="form-select form-select-lg mb-3" aria-label=".form-select-lg example" required>
              <option value="Status" disabled selected> Status</option>
              <option value="overstock">Overstock</option>
              <option value="critical_point">Critical Point</option>
            </select>
            <br>
            <button id="reset-button">Reset</button>
            <br>
            <button id="refresh-button" type="button"> <i class="fas fa-sync"> </i></button> 
          </div>
        </div>
        <div class="card">
          <div class="card-header">
            <h2>
              INVENTORY
            </h2>
            <a class="add-btn" href="add-inventory.php" class="btn btn-primary float-end"> Add Item </a>
          </div>
          <div class="card-body">
          <div class="table-res" id="table">
            <table class="table table-bordered table-stripe">
              <tbody>
              <tr>
              <th>#</th>
              <th>PRODUCT NAME</th>
              <th>SUPPLIER PRICE</th>
              <th>UNIT PRICE</th>
              <th>QUANTITY</th>
              <th>TOTAL</th>
              <th>PRODUCT CODE</th>
              <th>CATEGORY</th>
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
                  <td class="<?php echo ($row['skuQtyId'] <= $row['criticalPoint']) ? 'low-quantity' : (($row['skuQtyId'] > $row['overstockPoint']) ? 'overstock' : ''); ?>">
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
                  <div class="actions-container">
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
                  <td colspan="13"> No record Found </td>
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
      <h3 id="modal-title"></h3>
      <p><strong><span id="modal-title"></span></strong></p>
      <p><strong>SKU ID: </strong><span id="modal-skuid"></span></strong></p>
      <p><strong>Quantity: </strong><span id="modal-skuqty"></span></p>
      <p><strong>Product Name: </strong><span id="modal-productname"></span></p>
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
  const resetstatusSelect = document.getElementById('filtercritical');

  const rows = document.querySelectorAll('tbody tr');

  rows.forEach(row => {
    const categoryCell = row.querySelector('td:nth-child(8)');
    if (categoryCell) {
      const categoryText = categoryCell.textContent.trim();
      const display = category === 'All' || categoryText === category ? 'table-row' : 'none';
      row.style.display = display;
      resetstatusSelect.value = 'Status';

    }
  });
}

// Event listener for the filter button click
document.getElementById('category-select').addEventListener('change', function() {
  const selectElement = document.getElementById('category-select');
  const selectedCategory = selectElement.value;
  console.log('Selected Category:', selectedCategory);
  filterTableRows(selectedCategory);

});

</script>


<script>
    // Event listener for the refresh button click
    document.getElementById('refresh-button').addEventListener('click', function() {
      location.reload(); // Refresh the page
    });
  </script>

<script>
  function searchInventory() {
    const searchInput = document.getElementById('search-input').value.toLowerCase();
    const tableRows = document.getElementsByTagName('tr');

    for (let i = 1; i < tableRows.length; i++) {
      const productName = tableRows[i].getElementsByTagName('td')[1].innerText.toLowerCase();
      const skuId = tableRows[i].getElementsByTagName('td')[6].innerText.toLowerCase();

      if (productName.includes(searchInput) || skuId.includes(searchInput)) {
        tableRows[i].style.display = '';
      } else {
        tableRows[i].style.display = 'none';
      }
    }
  }

  const searchInput = document.getElementById('search-input');
  searchInput.addEventListener('input', searchInventory);
</script>


<script>
  function filterInventory() {
  const categorySelect = document.getElementById('filtercritical');
  const selectedCategory = categorySelect.value.toLowerCase();
  const tableRows = document.getElementsByTagName('tr');
  const resetcategorySelect = document.getElementById('category-select');
  const resetstatusSelect = document.getElementById('filtercritical');

  for (let i = 1; i < tableRows.length; i++) {
    const cells = tableRows[i].getElementsByTagName('td');
    let hasLowQuantity = false;
    let hasOverstock = false;

    // Check if any of the cells within the row has the class 'low-quantity' or 'overstock'
    for (let j = 0; j < cells.length; j++) {
      if (cells[j].classList.contains('low-quantity')) {
        hasLowQuantity = true;
        break;
      } else if (cells[j].classList.contains('overstock')) {
        hasOverstock = true;
        break;
      }
    }

    if ((selectedCategory === 'critical_point' && hasLowQuantity) || (selectedCategory === 'overstock' && hasOverstock)) {
      tableRows[i].style.display = '';
      resetcategorySelect.value = 'Category';
    } else if (selectedCategory === 'all') {
      tableRows[i].style.display = '';
      resetcategorySelect.value = 'Category';
    } else {
      tableRows[i].style.display = 'none';
      resetcategorySelect.value = 'Category';
    }
  }
}

document.getElementById('filtercritical').addEventListener('change', filterInventory);

</script>

<script>
  // Function to reset the table rows and show all data
  function resetTableRows() {
    const tableRows = document.getElementsByTagName('tr');
    const categorySelect = document.getElementById('category-select');
    const statusSelect = document.getElementById('filtercritical');

    for (let i = 1; i < tableRows.length; i++) {
      tableRows[i].style.display = '';
    }

    // Reset the select elements to their default values
    categorySelect.value = 'Category';
    statusSelect.value = 'Status';

  }
  // Event listener for the reset button click
  document.getElementById('reset-button').addEventListener('click', function() {
    const categorySelect = document.getElementById('filtercritical');
    categorySelect.value = 'all'; // Set the value to 'all' to show all data
    resetTableRows();
  });
</script>

</body>
</html>
    
<?php 
include('includes/footer.php');
?>
