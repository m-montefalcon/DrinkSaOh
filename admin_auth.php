<?php

use Firebase\Auth\Token\Exception\InvalidToken;
session_start();
include('dbcon.php');


if(isset($_SESSION['verified_user_id'])){

if(isset($_SESSION['verified_Superadmin'])){
    $uid = $_SESSION['verified_user_id'];
    $idTokenString = $_SESSION['idTokenString'];
    try {
        $verifiedIdToken = $auth->verifyIdToken($idTokenString);

    } catch (InvalidToken $e) {
        $_SESSION['status'] = "Token Expired/Invalid. Login Again";
        header('Location: logout.php');
        exit();
        echo 'The token is invalid: '.$e->getMessage();
        }
    } 
    
    elseif(isset($_SESSION['verified_admin'])){
        $uid = $_SESSION['verified_user_id'];

        $idTokenString = $_SESSION['idTokenString'];
    
        try {
            $verifiedIdToken = $auth->verifyIdToken($idTokenString);
      
        } catch (InvalidToken $e) {
            $_SESSION['status'] = "Token Expired/Invalid. Login Again";
            header('Location: logout.php');
            exit();
            echo 'The token is invalid: '.$e->getMessage();
        }
    }

    else {
        $_SESSION['status'] = "ACCESS DENIED";
        header('location: login.php');
        exit();
    }
    
}

else{
    $_SESSION['status'] = "Login to Access";
    header('location: login.php');
    exit();

}


    



?>
