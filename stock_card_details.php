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
  .print-btn {
    position: absolute;
    text-align: center;
    background-color: white;
    color: black;
    border-radius: 6px;
    width: 130px;
    height: 30px;
    margin-left: 0%;
    right: 30px;
    justify-content: center;
    align-items: center;
    top: 30px;
    display: flex;
    padding: 0 10px;
  }
  .print-btn:hover {
    background-color: maroon;
    margin-left: 0%;
    border-radius: 6px;
    color: white;
    cursor: pointer;
  }
  .left-section {
    float: left;
  }

  .right-section {
    float: right;
  }
</style>
</head>

<body>
<button id="refresh-button" type="button">REFRESH</button> 
            <script>
            // Event listener for the refresh button click
            document.getElementById('refresh-button').addEventListener('click', function() {
              location.reload(); // Refresh the page
            });
          </script>
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
            <a class="print-btn" onclick="printAsPDF()" class="btn btn-primary float-end"> Print as PDF </a>
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
          <div class="left-section">
          <tr>
            <td><strong>Product Name:</strong></td>
            <td><?= $matchingData['productName'] ?> </td>, 
            <td> <?= $matchingData['productCategory']; ?></td>
          </tr>
          <br>
          <tr>
            <td><strong>Supplier Name:</strong></td>
            <td><?= $matchingData['supplier_name'] ?> </td> 
          </tr>
          </div>

          <div class="right-section">
          <tr>
            <td><strong>Product Code:</strong></td>
            <td><?= $matchingData['skuId']; ?></td>
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
          </div>
          <br>

              <tr>
              <label for="from-month">From:</label>

              <select id="from-month">
                <option value="1">January</option>
                <option value="2">February</option>
                <option value="3">March</option>
                <option value="4">April</option>
                <option value="5">May</option>
                <option value="6">June</option>
                <option value="7">July</option>
                <option value="8">August</option>
                <option value="9">September</option>
                <option value="10">October</option>
                <option value="11">November</option>
                <option value="12">December</option>
              </select>
              
              <label for="to-month">To:</label>

              <select id="to-month">
                <option value="1">January</option>
                <option value="2">February</option>
                <option value="3">March</option>
                <option value="4">April</option>
                <option value="5">May</option>
                <option value="6">June</option>
                <option value="7">July</option>
                <option value="8">August</option>
                <option value="9">September</option>
                <option value="10">October</option>
                <option value="11">November</option>
                <option value="12">December</option>
              </select>

      <button id="fetch-button" type="button">Fetch Data</button>
      <button id="reset-button" type="button">Reset</button>

              </tr>
              <script>
              document.getElementById('fetch-button').addEventListener('click', function() {
  const fromMonth = parseInt(document.getElementById('from-month').value);
  const toMonth = parseInt(document.getElementById('to-month').value);
  
  const tableRows = document.querySelectorAll('.stock-card-table tbody tr');
  tableRows.forEach(function(row) {
    const dateCell = row.querySelector('td:first-child');
    const date = dateCell.innerText;
    const month = parseInt(date.split('/')[0]);
    
    if (month >= fromMonth && month <= toMonth) {
      row.style.display = 'table-row';
    } else {
      row.style.display = 'none';
    }
  });
  document.getElementById('reset-button').addEventListener('click', function() {
    const tableRows = document.querySelectorAll('.stock-card-table tbody tr');
    tableRows.forEach(function(row) {
      row.style.display = 'table-row';
    });
  });
  
});
              </script>
            

              
          
          <?php
        
      } else {
        ?>
        <tr>
          <td colspan="2">No data found for the selected SKU ID.</td>
        </tr>
        <?php
      }
      ?>
           <table class="stock-card-table">
            <br>
            <br>
              <thead> 
                <tr>
                  <th>DATE</th>
                  <th>ACTION</th>
                  <th>QUANTITY</th>
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
                        <td colspan="6">No data found for the selected SKU ID.</td>
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
function printAsPDF() {
  // Fetch the container element that holds the card
  const cardContainer = document.querySelector('.card');

  // Create a new window to open the printable document
  const printWindow = window.open('', '_blank');
  
  // Write the card's HTML content to the new window
  printWindow.document.write('<html><head><title>Stock Card</title></head><body>');
  printWindow.document.write('<style>.stock-card-table tr th, .stock-card-table td {border: 1px solid #ddd; padding: 8px; text-align: center;}</style>');
  
  // Remove the print button from the card content
  const cardContent = cardContainer.innerHTML;
  const modifiedContent = cardContent.replace('<button onclick="printAsPDF()">Print as PDF</button>', '');
  printWindow.document.write(modifiedContent);
  
  printWindow.document.write('</body></html>');
  
  // Call the print function of the new window
  printWindow.print();
}
</script>



</body>
</html>
    
<?php 
include('includes/footer.php');
?>


