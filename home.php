<?php 
session_start();
include('authentication.php');
include('includes/side-navbar.php');
include('dbcon.php');

require_once __DIR__.'/vendor/autoload.php';

use Kreait\Firebase\Factory;
use Kreait\Firebase\ServiceAccount;
?>

<!DOCTYPE html>
<html>
<head>
  <title> Home </title>
  <meta name="viewport" content="width=device-width, initial-scale=1">
</head>
<style>
  * {
    box-sizing: border-box;
    margin: 0;
    padding: 0;
    list-style: none;
    text-decoration: none;
    font-family: "Poppins", sans-serif;
  }
  body {
    font-family: Arial, sans-serif;
    font-size: 16px;
    background-color: #f6f6f6;
    overflow-x: hidden;
  }
  h1 {
    margin: 0;
  }
  h3 {
    font-size: 28px;
		font-weight: 600;
  }
  section {
    display: flex;
    justify-content: center;
    align-items: center;
    flex-wrap: wrap;
  }
  .box {
    display: flex;
    flex-direction: column;
    justify-content: flex-end;
    align-items: center;
    background-color: #f4f4f4;
    color: #333;
    border-radius: 25px;
    padding: 10px;
    margin: 20px;
    width: 260px;
    height: 220px;
    transition: all 0.3s ease;
    cursor: pointer;
    border: 8px solid black;
    border-bottom: none;
    text-decoration: underline;
    text-decoration-color: black;
  }
  .box:hover {
    transform: scale(1.1);
  }
  .admin {
    background-image: linear-gradient(to bottom, #ffce3a, #ba8b00);
    color: black;   
    box-shadow: 0px 0px 20px #ba8b00;
    text-align: center;
  }
  .superadmin {
    background-image: linear-gradient(to bottom, #007bff, #0056b3);
    color: black;   
    box-shadow: 0px 0px 20px #0056b3;
    text-align: center;
  }
  .products {
    background-image: linear-gradient(to bottom, #28a745, #19692c);
    color: black;    
    box-shadow: 0px 0px 20px #19692c;
    text-align: center;
  }
  .transactions {
    background-image: linear-gradient(to bottom, #dc3545, #a71d2a);
    color: black;  
    box-shadow: 0px 0px 20px #a71d2a;
    text-align: center;
  }
  .items {
    background-image: linear-gradient(to bottom, #008080, #003434);
    color: black;
    box-shadow: 0px 0px 20px #003434;
    text-align: center;
  }
  .home-section .icon ion-icon {
    font-size: 4em;
    margin-bottom: 20px;
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

  <!-- <div class="container-fluid bg-primary">
    <div class="row">
      <div class="col-md-12">
        <?php
          if (isset($_SESSION['status'])) {
            echo "<h5 class='alert alert-success'>".$_SESSION['status']."</h5>";
            unset($_SESSION['status']);
          }
        ?>
      </div>
    </div>
  </div> -->

<body>
  <section class="home-section">
    <a href="profiles.php">
      <div class="box admin">
        <span class="icon"> <ion-icon name="person-sharp"></ion-icon> </span>
        <h3> Admins </h3>
        <!-- <p>View and manage admins</p> -->
        <span> Admin Count:
          <?php 
            $adminCount = 0;

            $users = $auth->listUsers();
            foreach ($users as $user) {
                $claims = $user->customClaims;
                if(isset($claims['Admin']) == true){
                    $adminCount++;
                }
            }
            echo $adminCount;
          ?>
        </span>
      </div>
    </a>
    <a href="profiles.php">
      <div class="box superadmin">
        <span class="icon"> <ion-icon name="person-add-sharp"></ion-icon> </span>
        <h3> SuperAdmins </h3>
        <!-- <p>View and manage superadmins</p> -->
        <span> Superadmin Count: 
          <?php 
            $superadminCount = 0;
            $users = $auth->listUsers();
            foreach ($users as $user) {
              $claims = $user->customClaims;
              if(isset($claims['Superadmin']) == true) {
                $superadminCount++;
              }
            }
            echo $superadminCount;
          ?>
        </span>
      </div>
    </a>
    <a href="index.php">
      <div class="box products">
        <span class="icon"> <ion-icon name="pricetags-sharp"></ion-icon> </span>
        <h3> Products </h3>
        <!-- <p>View and manage products</p> -->
        <span>
          <?php 
            $ref_table = "inventory";
            $inventorySnapshot = $database->getReference($ref_table)->getSnapshot();
            $numDatasets = $inventorySnapshot->numChildren();
            echo "Products in Inventory: " . $numDatasets;
          ?>
        </span>
      </div>
    </a>
    <a href="transaction_log.php">
      <div class="box transactions">
        <span class="icon"> <ion-icon name="cart-sharp"></ion-icon> </span>
        <h3> Transactions </h3>
        <!-- <p>View last transaction made</p> -->
          <?php
            $transactionsRef = $database->getReference('transaction_log');
            $transactionsRef = $database->getReference('inventory');
            $transactions = $transactionsRef->getValue();

            $totalPriceSum = 0;
            if ($transactions) {
              foreach ($transactions as $transaction) {
                if (isset($transaction['totalPrice'])) {
                  $totalPriceSum += $transaction['totalPrice'];
                }
              }
            }
            echo 'Total Transactions: ' . count($transactions) . '</p>';
            echo 'Total Revenue: ₱' . $totalPriceSum . '</p>';
          ?>       
      </div>
    </a>
    <a href="index.php">
      <div class="box items">
        <span class="icon"> <ion-icon name="clipboard"></ion-icon> </span>
        <h3> Items </h3>
        <!-- <p>View and manage items</p> -->
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
            echo "Total Quantity: " . $totalQty;
          ?>
        </span>
      </div>
    </a>
    <script type="module" src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.esm.js"></script>
    <script nomodule src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.js"></script>
  </section>
</body>
</html>   