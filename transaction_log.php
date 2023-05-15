<?php
use Kreait\Firebase\Value\Uid;
include('admin_auth.php');
include('includes/side-navbar.php');
?>

<!DOCTYPE html>
<html>
<head>
  <title> Transaction Log </title>
  <meta name="viewport" content="width=device-width, initial-scale=1">
<style>
  * {
    box-sizing: border-box;
    margin: 0;
    padding: 0;
  }
  body {
    background-color: #f6f6f6;
    overflow: hidden;
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
  h2 {
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
  .home-section::-webkit-scrollbar {
    width: 5px; 
  }
  .content::-webkit-scrollbar-track {
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
  <section class="home-section">
    <div class="row">
      <div class="col-md-12">
        <div class="card">
          <div class="card-header">
            <h2>
              TRANSACTION LOG
            </h2>
          </div>
          <div class="card-body">
            <table class="table table-bordered table-stripe">
              <thead>
                <tr>
                <th>EMPLOYEE</th>
                <th>PRODUCT NAME</th>
                <th>SUPPLIER NAME</th>
                <th>SKU</th>
                <th>QTY</th>
                <th>ACTION</th>
                <th>BARCODE</th>
                <th>DATE</th>           
                <th>UNIT PRICE</th>
                <th>TOTAL AMOUNT</th>
                </tr>
              </thead>
              <tbody>
                <?php
                  include ('dbcon.php');
                  $ref_transaction_log = 'transaction_log';
                  $fetchTransactionLog = $database->getReference($ref_transaction_log) -> getValue();

                  if ($fetchTransactionLog > 0) {
                    $i = 1;
                    foreach($fetchTransactionLog as $key => $row) {
                ?>
                <tr>
                  <td><?=$row['eId']?></td>
                  <td><?=$row['productName']?></td>
                  <td><?=$row['supplier_name']?></td>
                  <td><?=$row['skuId']?></td>
                  <td><?=$row['skuQtyId']?></td>
                  <td><?=$row['action']?></td>
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
                    <?=date("m/j/y", strtotime($row['currentDate']))?>
                    <br>
                    <?=date("h:i:s", strtotime($row['currentTime']))?>
                  </td>
                  <td>₱<?=$row['priceQuantity']?></td>
                  <td><?php echo isset($row['totalPrice']) ? '₱'.$row['totalPrice'] : ''; ?></td>
                  </tr>
                  <?php
                  }
                } else {
                  ?>
                  <tr>
                    <td colspan="8"> No records found</td>
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
</body>
</html>