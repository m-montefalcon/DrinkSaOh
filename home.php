<?php 
session_start();
include('authentication.php');
include('includes/header.php');
include('dbcon.php');
?>

<div class="container-fluid bg-primary">
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
</div>

<html>
  <head>
    <meta charset="UTF-8">
    <title>Dashboard</title>
    <link rel="stylesheet" href="styles.css">
  </head>
  <body>
    <header>
      <h1>Dashboard</h1>
    </header>
    <main>
      <div class="container">
        <a href="#">
          <div class="box admin">
            <h2>Admins</h2>
            <p>View and manage admins</p>
          </div>
        </a>
        <a href="#">
          <div class="box superadmin">
            <h2>SuperAdmins</h2>
            <p>View and manage superadmins</p>
          </div>
        </a>
        <a href="#">
          <div class="box products">
            <h2>Products</h2>
            <p>View and manage products</p>
          </div>
        </a>
        <a href="#">
          <div class="box transactions">
            <h2>Last Transaction Made</h2>
            <p>View last transaction made</p>
          </div>
        </a>
        <a href="#">
          <div class="box items">
            <h2>Number of Items</h2>
            <p>View and manage items</p>
          </div>
        </a>
      </div>
      <style>
        * {
          box-sizing: border-box;
          margin: 0;
          padding: 0;
        }

        body {
          font-family: Arial, sans-serif;
          font-size: 16px;
        }

        header {
          background-color: #333;
          color: #fff;
          padding: 20px;
          text-align: center;
        }

        h1 {
          margin: 0;
        }

        main {
          display: flex;
          justify-content: center;
          align-items: center;
          height: 100vh;
        }

        .container {
          display: flex;
          flex-wrap: wrap;
          justify-content: center;
          align-items: center;
        }

        .box {
          display: flex;
          flex-direction: column;
          justify-content: flex-end;
          align-items: center;
          background-color: #f4f4f4;
          color: #333;
          border-radius: 5px;
          padding: 20px;
          margin: 20px;
          width: 250px;
          height: 250px;
          transition: all 0.3s ease;
          cursor: pointer;
        }

        .box:hover {
          transform: scale(1.1);
        }

        .admin {
          background-color: #ffc107;
          border-bottom: none;
        }

        .superadmin {
          background-color: #007bff;
          color: #fff;
          border-bottom: none;
        }

        .products {
          background-color: #28a745;
          color: #fff;
          border-bottom: none;
        }

        .transactions {
          background-color: #dc3545;
          color: #fff;
          border-bottom: none;
        }