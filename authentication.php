<?php

use Firebase\Auth\Token\Exception\InvalidToken;

include('dbcon.php');


if(isset($_SESSION['verified_user_id'])){

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
else{
    $_SESSION['status'] = "Login to Access";
    header('location: login.php');
    exit();

}



?>
