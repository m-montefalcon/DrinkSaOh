<?php
session_start();
use Firebase\Auth\Token\Exception\InvalidToken;

include('dbcon.php');






if(isset($_POST['login_user_button'])){
    
    $email = $_POST["email"];
    $clearTextPassword = $_POST["password"];
    
    try {
        if(isset($_SESSION['verified_user_id'])) {
                $_SESSION['status'] = "Logged In!";
                header('Location: home.php');
                exit();
  
        } 

        $user = $auth->getUserByEmail("$email");

    try{

        $signInResult = $auth->signInWithEmailAndPassword($email, $clearTextPassword);
        $idTokenString = $signInResult->idToken(); 

        try {


            $verifiedIdToken = $auth->verifyIdToken($idTokenString);
            $uid = $signInResult->firebaseUserId(); 

            $_SESSION['verified_user_id'] = $uid;
            $_SESSION['idTokenString'] = $idTokenString;

            $_SESSION['status'] = "Logged In!";
            header('Location: home.php');
            exit();

        } catch (InvalidToken $e) {
            echo 'The token is invalid: '.$e->getMessage();
        }

    } catch(Exception $e){
        $_SESSION['status'] = "Wrong Password";
        header('Location: login.php');
        exit();


    }


    } catch (\Kreait\Firebase\Exception\Auth\UserNotFound $e) {
        $_SESSION['status'] = "Invalid Email Address";
        header('Location: login.php');
        exit();
    }
    

}

else{
    $_SESSION['status'] = "Not Allowed";
    header('Location: login.php');
    exit();
}

?>