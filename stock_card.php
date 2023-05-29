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
  .table:not(.table-sm) thead th {
    border-bottom: none;
    background-color: #e9e9eb;
    color: #666;
    padding-top: 15px;
    padding-bottom: 15px;
    text-align: center;
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
    padding: 1em;
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
  .home-section::-webkit-scrollbar-track {
    background-color: #f6f6f6; 
  }
  .home-section::-webkit-scrollbar-thumb {
    background-color: #ccc; 
  }
  .home-section::-webkit-scrollbar-thumb:hover {
    background-color: #aaa; 
  }   
  .low-quantity {
    background-color: red;
  }
  @media (max-width: 768px) {
  .card-body table {
    width: 100%;
    overflow-x: auto;
  }
  .card-body table thead {
    display: none;
  }
  .card-body table tbody td {
    display: block;
    text-align: center;
  }
  .card-body table tbody td:before {
    content: attr(data-label);
    font-weight: bold;
    display: block;
    margin-bottom: 5px;
    font-size: 14px;
  }
  .card-body table tbody tr {
    border-bottom: 1px solid #ddd;
  }
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
</style>
</head>

<body>
  <section class="home-section">
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
              STOCK CARD
            </h2>
          
          </div>
          <div class="card-body">
          <div class="table-responsive">
            <table class="table table-bordered table-stripe">
              <thead>
                <tr>
                  <th>#</th>
 
                  <th>PRODUCT CODE</th>

                  <th>VIEW</th>
                </tr>
              </thead>
              <tbody>
              <?php
                include('dbcon.php');
                $stockcardref = 'stockcard';
                $fetchInventory = $database->getReference($stockcardref)->getValue();
                $users = $auth->listUsers();
                
                if ($fetchInventory) {
                    $i = 1;
                    foreach ($fetchInventory as $stockcardId => $row) {
                        ?>
                        <tr>
                            <td><?= $i++; ?></td>
                            <td><?= $stockcardId; ?></td>
                            <td>
                                <form action="stock_card_details.php" method="GET">
                                    <input type="hidden" name="stockcard_id" value="<?= $stockcardId; ?>">
                                    <button type="submit" class="btn btn-success btn-sm">Open</button>
                                </form>
                            </td>
                        </tr>
                        <?php
                    }
                } else {
                    ?>
                    <tr>
                        <td colspan="3">No data found.</td>
                    </tr>
                    <?php
                }
                ?>
                
                  <tr>
                      <td colspan="3">No record Found</td>
                  </tr>

                <?php 
                ?>
              </tbody>
            </table>
          </div>
          </div>
        </div>
      </div>
    </div> 
  </section>
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


