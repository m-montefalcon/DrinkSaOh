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
  .container {
    display: flex;
    flex-direction: column;
    padding: 15px;
    padding-top: 2px;
    padding-bottom: 2px;
    overflow: auto;
  }
  .table {
    width: 100%;
  }
  #table {
    position: relative;
    height: 500px;
    width: 100%; 
    overflow: scroll; 
    width: 100%;
    height: auto;
    max-height: 470px;
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
  .colspan {
    display: flex;
    align-items: center;
    justify-content: center;
  }  
  #refresh-button {
    position: absolute;
    text-align: center;
    background-color: white;
    color: black;
    border-radius: 6px;
    width: 50px;
    height: 30px;
    margin-left: 0%;
    right: 20px;
    justify-content: center;
    align-items: center;
    top: 10px;
    display: flex;
    padding: 0 10px;
  }
  #refresh-button:hover {
    background-color: maroon;
    margin-left: 0%;
    border-radius: 6px;
    color: white;
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
  #refresh-button {
    position: absolute;
    text-align: center;
    background-color: white;
    color: black;
    border-radius: 6px;
    width: 50px;
    height: 30px;
    margin-left: 0%;
    right: 20px;
    justify-content: center;
    align-items: center;
    top: 10px;
    display: flex;
    padding: 0 10px;
  }
  #refresh-button:hover {
    background-color: maroon;
    margin-left: 0%;
    border-radius: 6px;
    color: white;
  }
</style>
</head>

<body>
  <div class="container">
    <div class="row">
      <div class="col-md-12">
        <div class="card">
          <div class="card-header">
            <h2>
              TRANSACTION LOG
            </h2>
            <button id="refresh-button" type="button"> <i class="fas fa-sync"> </i></button>    
          </div>
          <div class="card-body">
            <div id="table">
              <table class="table table-bordered table-stripe">
                <tbody>
                  <tr>
                    <th>EMPLOYEE</th>
                    <th>PRODUCT NAME</th>
                    <th>SUPPLIER NAME</th>
                    <th>SUPPLIER PRICE</th>
                    <th>CRITICAL POINT</th>
                    <th>PRODUCT CATEGORY</th>
                    <th>SKU</th>
                    <th>QUANTITY</th>
                    <th>ACTION</th>
                    <th>BARCODE</th>
                    <th>DATE</th>           
                    <th>UNIT PRICE</th>
                    <th>TOTAL AMOUNT</th>
                  </tr>
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
                    <td>₱<?=$row['supplierPrice']?></td>
                    <td><?=$row['criticalPoint']?></td>
                    <td><?=$row['productCategory']?></td>
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
                      <td colspan="13"> No records found </td>
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
</body>
</html>