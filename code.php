<?php
session_start();
include ('dbcon.php');

//DELETE
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


    $updateData = [
        'eId' => $_SESSION['verified_user_id'],
        'skuId' => $sku_number,
        'skuQtyId' => $sku_qty,
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

//ADD
if(isset($_POST['add_inventory']))
{

    $sku_number = $_POST['sku_number'];
    $sku_qty = $_POST['sku_qty'];




    $postData = [
        'eId' => $_SESSION['verified_user_id'],
        'skuId' => $sku_number,
        'skuQtyId' => $sku_qty,
        'currentDate' => date('Y-m-d'),
        'currentTime' => date('H:i:s')
    ];

    $ref_table = "inventory";
    $postRef_result = $database->getReference($ref_table)->push($postData);
    
    if($postRef_result)
    {
        $_SESSION['status'] = "Added!";
        header('location: index.php');

    }else
    {
        $_SESSION['status'] = "Error!";
        header('location: index.php');
    }
   

}






?>