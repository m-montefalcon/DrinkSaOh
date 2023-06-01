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
    border: 1px solid #ddd;
    border-radius: 10px;
    padding: 20px;
    margin-bottom: 20px;
    box-shadow: 0px 0px 10px #BDBDBD;
    position: relative;
    width: 100%;
  }
  tr {
    text-align: center;
  }
  .stock-card-table tr th {
    text-align: center;
    text-transform:uppercase;
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
  }
  .card-footer {
    background-color: transparent;
    padding: 20px 25px; 
  }
  .low-quantity {
    background-color: red;
  }
  .container {
    display: flex;
    padding: 15px;
    overflow: auto; 
  }
  .stock-card-table {
    width: 100%;
    border-collapse: collapse;
  }
  .stock-card-table th,
  .stock-card-table td {
    border: 1px solid #ddd;
    padding: 8px;
  }
  .stock-card-table th {
    background-color: #f9f9f9;
    font-weight: bold;
    text-align: left;
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
</style>
</head>

<body>
  <div class="container">
    <!-- <div class="row">
      <div class="col-md-12"> -->
        <?php
          if (isset($_SESSION['status'])) {
            echo "<h5 class = 'alert alert-success'>".$_SESSION['status']."</h5>";
            unset($_SESSION['status']);
          }
        ?>
        <div class="card">
          <div class="card-header">
            <h2>
              STOCK CARD
            </h2>
          </div>
          <div class="card-body">
          <?php
            include('dbcon.php');

            $ref_inventory = 'inventory';
            $fetchInventoryData = $database->getReference($ref_inventory) -> getValue();

            // Get the selected SKU ID from the query parameter
            $stockcardId = $_GET['stockcard_id'];

            // Retrieve the data under the selected SKU ID
            $stockcardref = 'stockcard/' . $stockcardId;
            $fetchData = $database->getReference($stockcardref)->getValue();

            $matchingData = null;
            foreach ($fetchInventoryData as $item) {
                if ($item['skuId'] == $stockcardId) {
                    $matchingData = $item;
                    break;
                }
            }

            if ($matchingData) {
          ?>
          <br>
          <tr>
            <td><strong>Product Code:</strong></td>
            <td><?= $matchingData['skuId']; ?></td>
          </tr>
          <br>
          <tr>
            <td><strong>Product Name:</strong></td>
            <td><?= $matchingData['productName']; ?></td>
          </tr>
          <br>
          <tr>
            <td><strong>Unit Price:</strong></td>
            <td>₱<?= $matchingData['priceQuantity']; ?></td>
          </tr>
          <br>
          <tr>
            <td><strong>Stock on-hand:</strong></td>
            <td><?=$matchingData['skuQtyId']?></td>
          </tr>
          <br>
          <tr>
            <td><strong>Inventory Amount:</strong></td>
            <td>₱<?=$matchingData['totalPrice']?></td>
          </tr>
          
          <?php
        
      } else {
        ?>
        <tr>
          <td colspan="2">No data found for the selected SKU ID.</td>
        </tr>
        <?php
      }
      ?>
            <!-- <div id="table"> -->
            <table class="stock-card-table">
            <br>
            <br>
              <thead>
                <tr>
                  <th>Date</th>
                  <th>Action</th>
                  <th>Quantity</th>
                  <th>AMOUNT</th>
                  <th>INVENTORY QUANTITY</th>
                  <th>INVENTORY AMOUNT</th>

                </tr>
              </thead>
                <?php
                  include('dbcon.php');

                  // Get the selected SKU ID from the query parameter
                  $stockcardId = $_GET['stockcard_id'];

                  // Retrieve the data under the selected SKU ID
                  $stockcardref = 'stockcard/' . $stockcardId;
                  $fetchData = $database->getReference($stockcardref)->getValue();

                  if ($fetchData) {
                      foreach ($fetchData as $key => $data) {
                          ?>
                          <tr>
                            <td><?= formatDate($data['currentDate']) ?> 
                              <br> <?= formatTime($data['currentTime']) ?> 
                            </td>
                            <td><?= $data['action']; ?></td>
                            <td><?= $data['skuQtyId']; ?></td>
                            <td>₱<?= $data['amount']; ?></td>
                            <td><?= $data['inventoryQuantity']; ?></td>
                            <td>₱<?= $data['inventoryAmount']; ?></td>


                            <!-- // wa ko kibaw unsa data kwaon // -->
                          </tr>
                          <?php
                      }
                  } else {
                      ?>
                      <tr>
                        <td colspan="9">No data found for the selected SKU ID.</td>
                      </tr>
                      <?php
                  }
                  ?>
                  <?php 
                  ?>
                </tbody>
              </table>
            <!-- </div> -->
          </div>
        </div>
      <!-- </div>
    </div>  -->
  </div> 
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


