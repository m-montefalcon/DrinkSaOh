<?php



session_start();
include ('dbcon.php');
include ('config.php');

use \Picqer\Barcode\BarcodeGeneratorHTML as BG;

require __DIR__.'/vendor/autoload.php';

use Kreait\Firebase\Factory;
use Kreait\Firebase\ServiceAccount;
use Kreait\Firebase\Storage;

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
        'totalPrice' => $inventoryItemData['totalPrice'],
        'productCategory' => $inventoryItemData['productCategory'],
        'supplierPrice' => $inventoryItemData['supplierPrice'],
        'criticalPoint' => $inventoryItemData['criticalPoint'],
        'overstockPoint' => $inventoryItemData['overstockPoint'],
        'currentDate' => date('Y-m-d'),
        'currentTime' => date('H:i:s')
    ];
    $stockCardRef = $database->getReference('stockcard')->getChild($inventoryItemData['skuId']);
    $stockCardRef->remove();
    
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
    $supplier_price = $_POST['supplier_price'];
    $critical_point = $_POST['critical_point'];
    $product_category = $_POST['select_category_user'];
    $overstock_point = $_POST['overstock_point'];
    


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
        'productCategory' => $product_category,
        'supplierPrice' => $supplier_price,
        'criticalPoint' => $critical_point,
        'overstockPoint' => $overstock_point,
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
            'productCategory' => $product_category,
            'supplierPrice' => $supplier_price,
            'criticalPoint' => $critical_point,
            'overstockPoint' => $overstock_point,
            'barcode' => $bi,
            'currentDate' => date('Y-m-d'),
            'currentTime' => date('H:i:s')
        ];
        $stockCardRef = $database->getReference('stockcard')
        ->getChild($sku_number);
        $action = "EDITED";

        $stockCardPushRef = $stockCardRef->push();

        $stockCardData = $stockCardPushRef->set([
            'currentDate' => date('Y-m-d'),
            'currentTime' => date('H:i:s'),
            'action' => $action,
            'skuQtyId' => $sku_qty,
            'amount' => $total_price,
            'inventoryQuantity' => $sku_qty,
            'inventoryAmount' => $total_price,

        ]);
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
    $supplier_price = $_POST['supplier_price'];
    $critical_point = $_POST['critical_point'];
    $product_category = $_POST['select_category_user'];
    $price_per_quantity = $_POST['price_qty'];
    $overstock_point = $_POST['overstock_point'];


    
    
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
                'productCategory' => $product_category,
                'supplierPrice' => $supplier_price,
                'criticalPoint' => $critical_point,
                'barcode' => $bi,
                'overstockPoint' => $overstock_point,
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
                'productCategory' => $product_category,
                'supplierPrice' => $supplier_price,
                'criticalPoint' => $critical_point,
                'barcode' => $bi,
                'overstockPoint'=> $overstock_point,
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
            'productCategory' => $product_category,
            'supplierPrice' => $supplier_price,
            'criticalPoint' => $critical_point,
            'criticalPoint' => $critical_point,
            'overstockPoint'=> $overstock_point,

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
            'productCategory' => $product_category,
            'supplierPrice' => $supplier_price,
            'criticalPoint' => $critical_point,
            'barcode' => $bi,
            'overstockPoint'=> $overstock_point,

            'currentDate' => date('Y-m-d'),
            'currentTime' => date('H:i:s')
        ];

        $stockCardRef = $database->getReference('stockcard')
            ->getChild($sku_number);
            $action = "REGISTERED IN";

            $stockCardPushRef = $stockCardRef->push();
  
            $stockCardData = $stockCardPushRef->set([
                'currentDate' => date('Y-m-d'),
                'currentTime' => date('H:i:s'),
                'action' => $action,
                'skuQtyId' => $sku_qty,
                'amount' => $total_price,
                'inventoryQuantity' => $sku_qty,
                'inventoryAmount' => $total_price,

            ]);
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

//STOCK CARD
if (isset($_POST['stockAction']) && isset($_POST['quantity']) && isset($_POST['key'])) {
    $stockAction = $_POST['stockAction'];
    $quantity = $_POST['quantity'];
    $key = $_POST['key'];

    $inventoryRef = $database->getReference('inventory')
        ->orderByChild('skuId')
        ->equalTo($key)
        ->getSnapshot()
        ->getValue();

    if ($inventoryRef) {
        $inventoryKey = array_keys($inventoryRef)[0]; // Get the key of the inventory entry

        $inventoryData = $inventoryRef[$inventoryKey]; // Get the data of the inventory entry

        if ($stockAction === 'in') {

            $fetchInventoryData = $database->getReference('inventory') -> getValue();
            $matchingData = null;
            foreach ($fetchInventoryData as $item) {
                if ($item['skuId'] == $key) {
                    $matchingData = $item;
                    break;
                }
            }
            // Handle stock in action by adding the quantity to the existing quantity
            $amount = $matchingData['priceQuantity'] * $quantity;
            $inventoryAmount = $matchingData['totalPrice'] + $amount;
            $inventoryQuantity = $quantity + $matchingData['skuQtyId'];
            $inventoryAmount = $matchingData['totalPrice'] + $amount;
            

            $currentQuantity = isset($inventoryData['skuQtyId']) ? $inventoryData['skuQtyId'] : 0;
            $newQuantity = $currentQuantity + $quantity;
            $inventoryRef = $database->getReference('inventory/' . $inventoryKey)->update(['skuQtyId' => $newQuantity]);


            $currentTotalPrice = isset($inventoryData['totalPrice']) ? $inventoryData['totalPrice'] : 0;
            $newTotalPrice = $currentTotalPrice + $amount;
            $inventoryRef = $database->getReference('inventory/' . $inventoryKey)->update(['totalPrice' => $newTotalPrice]);


            
            $stockCardRef = $database->getReference('stockcard')
            ->getChild($key);
            $action = "IN";

            $stockCardPushRef = $stockCardRef->push();
  
            $stockCardData = $stockCardPushRef->set([
                'currentDate' => date('Y-m-d'),
                'currentTime' => date('H:i:s'),
                'action' => $action,
                'skuQtyId' => $quantity,
                'amount' => $amount,
                'inventoryQuantity' => $inventoryQuantity,
                'inventoryAmount' => $newTotalPrice,

            ]);


            $_SESSION['status'] = "Successfully Stocked In!";
            header('location: index.php');
            exit();



        } elseif ($stockAction === 'out') {
            $fetchInventoryData = $database->getReference('inventory') -> getValue();
            $matchingData = null;
            foreach ($fetchInventoryData as $item) {
                if ($item['skuId'] == $key) {
                    $matchingData = $item;
                    break;
                }
            }
            
            if ($matchingData['skuQtyId'] >= $quantity) {
               
           
            $amount = $matchingData['priceQuantity'] * $quantity;
            $inventoryAmount = $matchingData['totalPrice'] + $amount;
            $inventoryQuantity =  $matchingData['skuQtyId'] - $quantity;
            $inventoryAmount = $matchingData['totalPrice'] - $amount;
            
            // Handle stock out action by subtracting the quantity from the existing quantity
            $currentQuantity = isset($inventoryData['skuQtyId']) ? $inventoryData['skuQtyId'] : 0;
            $newQuantity = $currentQuantity - $quantity;
            $inventoryRef = $database->getReference('inventory/' . $inventoryKey)->update(['skuQtyId' => $newQuantity]);

            $currentTotalPrice = isset($inventoryData['totalPrice']) ? $inventoryData['totalPrice'] : 0;
            $newTotalPrice = $currentTotalPrice - $amount;
            $inventoryRef = $database->getReference('inventory/' . $inventoryKey)->update(['totalPrice' => $newTotalPrice]);




            $stockCardRef = $database->getReference('stockcard')
            ->getChild($key);
                $action = "OUT";
    
            $stockCardPushRef = $stockCardRef->push();
               $stockCardData = $stockCardPushRef->set([
                'currentDate' => date('Y-m-d'),
                'currentTime' => date('H:i:s'),
                'action' => $action,
                'skuQtyId' => $quantity,
                'amount' => $amount,
                'inventoryQuantity' => $inventoryQuantity,
                'inventoryAmount' => $newTotalPrice,

            ]);
    

                $_SESSION['status'] = "Successfully Stocked Out!";
                header('location: index.php');
                exit();
            } else {
                $_SESSION['status'] = "Insufficient stock quantity!";
                header('location: index.php');
                exit();
            }
        } else {
            $_SESSION['status'] = "Invalid stock action";
            header('location: index.php');
            exit();
            // Invalid stock action
        }
    } else {
        $_SESSION['status'] = "SKU ID not found in inventory";
        header('location: index.php');
        exit();
    }
} 




?>

