<?php



session_start();
include ('dbcon.php');
use Picqer\Barcode\BarcodeGeneratorHTML;
require __DIR__.'/vendor/autoload.php';

use Kreait\Firebase\Factory;
use Kreait\Firebase\ServiceAccount;

//DELET


if(isset($_POST['delete_button'])){
    $delete_id = $_POST['delete_button'];
    $ref_table = 'inventory/'.$delete_id;
    $deleteInventory =  $database->getReference($ref_table)->remove();
    if($deleteInventory)
    {
        $_SESSION['status'] = "Deleted!";
        header('location: index.php');

    }else
    {
        $_SESSION['status'] = "Error!";
        header('location: index.php');
    }
}


//EDIT
if(isset($_POST['edit_inventory']))
{
    $key = $_POST['key'];
    $sku_number = $_POST['sku_number'];
    $sku_qty = $_POST['sku_qty'];

    $barcode_data = $sku_number . "-" . $sku_qty;
 
   
    $barcode = new \Picqer\Barcode\BarcodeGeneratorHTML();
    $barcode_img = $barcode->getBarcode($barcode_data, $barcode::TYPE_CODE_128);

    $updateData = [
        'eId' => $_SESSION['verified_user_id'],
        'skuId' => $sku_number,
        'skuQtyId' => $sku_qty,
        'barcode' => $barcode_img,
        'currentDate' => date('Y-m-d'),
        'currentTime' => date('H:i:s')
    ];
    $ref_table = 'inventory/'.$key;
    $updateInventory = $database->getReference($ref_table)
            ->update($updateData);
    
    if($updateInventory)
    {
        $_SESSION['status'] = "Updated!";
        header('location: index.php');
        


    }else
    {
        $_SESSION['status'] = "Error!";
        header('location: index.php');
    }       
}

// ADD


// if(isset($_POST['add_inventory']))
// {
//     $sku_number = $_POST['sku_number'];
//     $sku_qty = $_POST['sku_qty'];
//     $redColor = [255, 0, 0];

//     $barcode_data = $sku_number . "-" . $sku_qty;
 
   
//     $barcode = new \Picqer\Barcode\BarcodeGeneratorHTML();
//     $barcode_img = $barcode->getBarcode($barcode_data, $barcode::TYPE_CODE_128);

//     $postData = [
//         'eId' => $_SESSION['verified_user_id'],
//         'skuId' => $sku_number,
//         'skuQtyId' => $sku_qty,
//         'barcode' => $barcode_img,
//         'currentDate' => date('Y-m-d'),
//         'currentTime' => date('H:i:s')
//     ];

//     $ref_table = "inventory";
//     $postRef_result = $database->getReference($ref_table)->push($postData);
    
//     if($postRef_result)
//     {
//         $_SESSION['status'] = "Added!";
//         header('location: index.php');

//     }else
//     {
//         $_SESSION['status'] = "Error!";
//         header('location: index.php');
//     }
   

// if(isset($_POST['add_inventory']))
// {
//     $sku_number = $_POST['sku_number'];
//     $sku_qty = $_POST['sku_qty'];

//     $barcode_data = $sku_number . "-" . $sku_qty;
 
   
//     $barcode = new \Picqer\Barcode\BarcodeGeneratorHTML();
//     $barcode_img = $barcode->getBarcode($barcode_data, $barcode::TYPE_CODE_128);



//     $ref_table = "inventory";
//     $inventoryQuery = $database->getReference($ref_table)->orderByChild('skuId')->equalTo($sku_number)->getSnapshot();

//     if ($inventoryQuery->exists()) {
//         // SKU already exists, update quantity instead of creating a new entry
//         foreach ($inventoryQuery->getValue() as $key => $inventory) {
//             $newQty = $inventory['skuQtyId'] + $sku_qty;
//             $updateData = [
//                 'eId' => $_SESSION['verified_user_id'],
//                 'skuQtyId' => $newQty,
//                 'barcode' => $barcode_img,
//                 'currentDate' => date('Y-m-d'),
//                 'currentTime' => date('H:i:s')
//             ];
//             $ref_table = 'inventory/'.$key;
//             $updateInventory = $database->getReference($ref_table)->update($updateData);

//             if ($updateInventory) {
//                 $_SESSION['status'] = "Added!";
//                 header('location: index.php');
//                 exit;
//             } else {
//                 $_SESSION['status'] = "Error!";
//                 header('location: index.php');
//                 exit;
//             }
//         }
//     } else {
//         // SKU does not exist, create a new entry
       
//         $postData = [
//             'eId' => $_SESSION['verified_user_id'],
//             'skuId' => $sku_number,
//             'skuQtyId' => $sku_qty,
//             'barcode' => $barcode_img,
//             'currentDate' => date('Y-m-d'),
//             'currentTime' => date('H:i:s')
//         ];
//         $postRef_result = $database->getReference($ref_table)->push($postData);
//         print_r($postRef_result);
        

        
    
//         if ($postRef_result) {
//             $_SESSION['status'] = "Added!";
//             header('location: index.php');
//             exit;
//         } else {
//             $_SESSION['status'] = "Error!";
//             header('location: index.php');
//             exit;
//         }
//     }
// }

if(isset($_POST['add_inventory']))
{
    $sku_number = $_POST['sku_number'];
    $sku_qty = $_POST['sku_qty'];
    $redColor = [255, 0, 0];
    $barcode_data = $sku_number . "-" . $sku_qty;
 
   
    $barcode = new \Picqer\Barcode\BarcodeGeneratorHTML();
    $barcode_img = $barcode->getBarcode($barcode_data, $barcode::TYPE_CODE_128);



    $ref_table = "inventory";
   
    $inventoryQuery = $database->getReference($ref_table)
    ->orderByChild('skuId')
    ->equalTo($sku_number)
    ->getValue();


    if($inventoryQuery) {
        // SKU already exists, update quantity instead of creating a new entry
        foreach($inventoryQuery as $key => $inventory) {
            $newQty = $inventory['skuQtyId'] + $sku_qty;
            $updateData = [
                'eId' => $_SESSION['verified_user_id'],
                'skuQtyId' => $newQty,
                'barcode' => $barcode_img,
                'currentDate' => date('Y-m-d'),
                'currentTime' => date('H:i:s')
            ];
            $ref_table = 'inventory/'.$key;
            $updateInventory = $database->getReference($ref_table)->update($updateData);

            if($updateInventory)
        {
            $_SESSION['status'] = "Added!";
            header('location: index.php');

        }else
        {
            $_SESSION['status'] = "Error!";
            header('location: index.php');
        }
        }
    } else {
        // SKU does not exist, create a new entry
        $postData = [
            'eId' => $_SESSION['verified_user_id'],
            'skuId' => $sku_number,
            'skuQtyId' => $sku_qty,
            'barcode' => $barcode_img,
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

