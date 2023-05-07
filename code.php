<?php



session_start();
include ('dbcon.php');
use \Picqer\Barcode\BarcodeGeneratorHTML as BG;

require __DIR__.'/vendor/autoload.php';

use Kreait\Firebase\Factory;
use Kreait\Firebase\ServiceAccount;
//DELETE
if (isset($_POST['delete_button'])) {
    $delete_id = $_POST['delete_button'];
    $ref_table = 'inventory/'.$delete_id;

    // Create a reference to the transaction log node
    $transactionLogRef = $database->getReference('transaction_log');

    // Get the inventory item data
    $inventoryItemRef = $database->getReference($ref_table);
    $inventoryItemData = $inventoryItemRef->getValue();
    $uid = $_SESSION['verified_user_id'];
    $user = $auth->getUser($uid);
    // Construct the transaction data array
    $transactionData = [
        'eId' => $user -> displayName,
        'action' => 'Deleted',
        'supplier_name' => $inventoryItemData['supplier_name'],
        'priceQuantity' => $inventoryItemData['priceQuantity'],
        'productName' => $inventoryItemData['productName'],
        'skuId' => $inventoryItemData['skuId'],
        'skuQtyId' => $inventoryItemData['skuQtyId'],
        'barcode' => $inventoryItemData['barcode'],
        'currentDate' => date('Y-m-d'),
        'currentTime' => date('H:i:s')
    ];

    $transactionLogResult = $transactionLogRef->push($transactionData);

    if ($transactionLogResult) {

        $deleteInventory = $inventoryItemRef->remove();

        if ($deleteInventory) {
            $_SESSION['status'] = "Deleted!";
            header('location: index.php');
        } else {
            $_SESSION['status'] = "Error deleting inventory item!";
            header('location: index.php');
        }
    } else {
        $_SESSION['status'] = "Error recording transaction log!";
        header('location: index.php');
    }
}




//EDIT
if(isset($_POST['edit_inventory']))
{
    $key = $_POST['key'];
    $sku_number = $_POST['sku_number'];
    $sku_qty = $_POST['sku_qty'];
    $product_name = $_POST['product_name'];

    $bd = $sku_number;
    $bg = new BG();
    $bi = $bg->getBarcode($bd, BG::TYPE_CODE_128);


    $style = 'style="font-size: 0.8em; padding: 0 2px;"';
    $bi = str_replace('height: 50px', $style, $bi);

    $uid = $_SESSION['verified_user_id'];
    $user = $auth->getUser($uid);

    $supplier_name = $_POST['supplier_name'];
    $price_per_quantity = $_POST['price_qty'];
    $total_price = $price_per_quantity * $sku_qty;

    
    $updateData = [
        'supplier_name' => $supplier_name,
        'priceQuantity' => $price_per_quantity,
        'productName' => $product_name,
        'totalPrice' => $total_price, 
        'skuId' => $sku_number,
        'skuQtyId' => $sku_qty,
        'barcode' => $bi,
        'currentDate' => date('Y-m-d'),
        'currentTime' => date('H:i:s')
    ];
    $ref_table = 'inventory/'.$key;
    $updateInventory = $database->getReference($ref_table)
            ->update($updateData);
    
    if($updateInventory)
    {
        $transactionLogRef = $database->getReference('transaction_log');
        $transactionData = [
            'eId' => $user->displayName,
            'action' => 'Edited',
            'supplier_name' => $supplier_name,
            'priceQuantity' => $price_per_quantity,
            'totalPrice' => $total_price, 
            'productName' => $product_name,
            'skuId' => $sku_number,
            'skuQtyId' => $sku_qty,
            'barcode' => $bi,
            'currentDate' => date('Y-m-d'),
            'currentTime' => date('H:i:s')
        ];

        $transactionLogRef->push($transactionData);
        $_SESSION['status'] = "Updated!";
        header('location: index.php');
        


    }else
    {
        $_SESSION['status'] = "Error!";
        header('location: index.php');
    }       
}

//ADD
if(isset($_POST['add_inventory']))
{
    $sku_number = $_POST['sku_number'];
    $sku_qty = $_POST['sku_qty'];
    $product_name = $_POST['product_name'];
    $supplier_name = $_POST['supplier_name'];
    $price_per_quantity = $_POST['price_qty'];
    
    $bd = $sku_number;
    $bg = new BG();
    $bi = $bg->getBarcode($bd, BG::TYPE_CODE_128);

    // Set font size and padding
    $style = 'style="font-size: 0.8em; padding: 0 2px;"';

    // Replace the default style for the bars with the new style
    $bi = str_replace('height: 50px', $style, $bi);

    $ref_table = "inventory";
   
    $inventoryQuery = $database->getReference($ref_table)
    ->orderByChild('skuId')
    ->equalTo($sku_number)
    ->getValue();

    $uid = $_SESSION['verified_user_id'];
    $user = $auth->getUser($uid);
    $total_price = $price_per_quantity * $sku_qty;

    if($inventoryQuery) {
        // SKU already exists, update quantity instead of creating a new entry
        foreach($inventoryQuery as $key => $inventory) {
            $newQty = $inventory['skuQtyId'] + $sku_qty;
            $updateData = [
                'totalPrice' => $total_price, 
                'supplier_name' => $supplier_name,
                'priceQuantity' => $price_per_quantity,
                'productName' => $product_name,
                'skuQtyId' => $newQty,
                'barcode' => $bi,
                'currentDate' => date('Y-m-d'),
                'currentTime' => date('H:i:s')
            ];
            $ref_table = 'inventory/'.$key;
            $updateInventory = $database->getReference($ref_table)->update($updateData);

            if($updateInventory)
        {

            $transactionLogRef = $database->getReference('transaction_log');
            $transactionData = [
                'eId' => $user->displayName,
                'supplier_name' => $supplier_name,
                'priceQuantity' => $price_per_quantity,
                'totalPrice' => $total_price, 
                'action' => 'Added',
                'productName' => $product_name,
                'skuId' => $sku_number,
                'skuQtyId' => $sku_qty,
                'barcode' => $barcode_img,
                'currentDate' => date('Y-m-d'),
                'currentTime' => date('H:i:s')
            ];
            $transactionLogRef->push($transactionData);
            $_SESSION['status'] = "Added!";
            header('location: index.php');

        }else
        {
            $_SESSION['status'] = "Error!";
            header('location: index.php');
        }
        }
    } else {

        $transactionLogRef = $database->getReference('transaction_log');
        $transactionData = [
            'eId' => $user->displayName,
            'totalPrice' => $total_price, 
            'supplier_name' => $supplier_name,
            'priceQuantity' => $price_per_quantity,
            'productName' => $product_name,
            'action' => 'Created',
            'skuId' => $sku_number,
            'skuQtyId' => $sku_qty,
            'barcode' => $bi,
            'currentDate' => date('Y-m-d'),
            'currentTime' => date('H:i:s')
        ];
        $transactionLogRef->push($transactionData);
        // SKU does not exist, create a new entry
        $postData = [
            'supplier_name' => $supplier_name,
            'priceQuantity' => $price_per_quantity,
            'totalPrice' => $total_price, 
            'productName' => $product_name,
            'skuId' => $sku_number,
            'skuQtyId' => $sku_qty,
            'barcode' => $bi,
            'currentDate' => date('Y-m-d'),
            'currentTime' => date('H:i:s')
        ];

        $postRef_result = $database->getReference($ref_table)->push($postData);

        if($postRef_result !== false && $postRef_result !== null)
            {
                $_SESSION['status'] = "Added!";
                header('location: index.php');
            }
            else
            {
                $_SESSION['status'] = "Error!";
                header('location: index.php');
            }
    }
}






?>

