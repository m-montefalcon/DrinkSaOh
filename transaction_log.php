
<!DOCTYPE html>
<html>
<head>
	<title>Transaction Log</title>
	<style>
		table {
			border-collapse: collapse;
			width: 100%;
		}
		th, td {
			padding: 8px;
			text-align: left;
			border-bottom: 1px solid #ddd;
		}
		th {
			background-color: #f2f2f2;
		}
	</style>
</head>
<body>
	<table>
		<thead>
			<tr>
				<th>eId</th>
				<th>Product Name</th>
				<th>Suppler Name</th>
				<th>SKU</th>
				<th>SKU Quantity</th>
				<th>Action</th>
				<th>Barcode</th>
				<th>Date</th>
				<th>Time</th>
				<th>PRICE PER QUANTITY</th>
				<th>TOTAL AMOUNT</th>
			</tr>
		</thead>
		<tbody>
			<?php
            
				include ('dbcon.php');
                include('admin_auth.php');
                include('includes/header.php');
				$ref_transaction_log = 'transaction_log';
				$fetchTransactionLog = $database->getReference($ref_transaction_log) -> getValue();
				
				if ($fetchTransactionLog > 0) {
					$i = 1;
					foreach($fetchTransactionLog as $key => $row){
			?>
			<tr>
				<td><?=$row['eId']?></td>
				<td><?=$row['productName']?></td>
				<td><?=$row['supplier_name']?></td>
				<td><?=$row['skuId']?></td>
				<td><?=$row['skuQtyId']?></td>
				<td><?=$row['action']?></td>
				<td><?=$row['barcode']?></td>
				<td><?=date("M j, Y", strtotime($row['currentDate']))?></td>
				<td><?=date("h:i:s A", strtotime($row['currentTime']))?></td>
				<td>₱<?=$row['priceQuantity']?></td>
				<td>₱<?=$row['totalPrice']?></td>
			</tr>
			<?php
					}
				} else {
			?>
			<tr>
				<td colspan="8">No records found</td>
			</tr>
			<?php
				}
			?>
		</tbody>
	</table>
</body>
</html>
