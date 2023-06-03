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
    width: 100%;
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
    width: 130px;
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
        <div class="card">
          <div class="card-header">
            <h2>
              SUPPLIER
            </h2>
            <a class="add-btn" href="register_supplier.php" class="btn btn-primary float-end"> Add Supplier </a>
          </div>
          <div class="card-body">
            <div class="table-res" id="table">
              <table class="table table-bordered table-stripe">
                <tbody>
                  <tr>
                    <th>#</th>
                    <th>SUPPLIER NAME</th>
                    <th>SUPPLIER PHONE NUMBER</th>
                    <th>SUPPLER EMAIL ADDRESS</th>
                    <th>EDIT</th>
                    <th>DELETE</th>
                  </tr>
                  <?php
                    include ('dbcon.php');
                    $ref_supplier = 'supplier';
                    $fetchInventory = $database->getReference($ref_supplier) -> getValue();
                    $users = $auth->listUsers();

                    if ($fetchInventory > 0) {
                      $i = 1;
                      foreach($fetchInventory as $key => $row) {    
                  ?>
                  <tr>
                    <td><?=$i++;?></td>
                    <td><?=$row['supplierFullName']?></td>
                    <td>+63<?=$row['supplierPhoneNumber']?></td>
                    <td><?=$row['supplierEmailAddress']?></td>
                    <td>
                      <a href="edit_supplier_cred.php?id=<?=$key?>" class="btn btn-primary btn-sm"> </a>
                    </td>
                    <td>
                      <form action="userCred.php" method = "POST">
                        <button type="submit" name = "delete_supplier_button" class = "btn btn-danger btn-sm" value = "<?=$key?>"></button>
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