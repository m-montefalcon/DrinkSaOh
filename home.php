<?php 
session_start();
include('authentication.php');
include('includes/header.php');
include('dbcon.php');
?>

<div class="container">

    <div class="row">
        <div class="col-md-12">
        <?php
              if (isset($_SESSION['status'])) {
                echo "<h5 class = 'alert alert-success'>".$_SESSION['status']."</h5>";
                unset($_SESSION['status']);
              }
            
            ?>
        <h2>
            Home Page
        </h2>
        </div>
    </div>
</div>





