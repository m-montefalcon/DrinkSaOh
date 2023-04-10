
<?php
session_start();
use Firebase\Auth\Token\Exception\InvalidToken;



include('dbcon.php');




//REGISTER USER

if(isset($_POST['register_user_button'])){
    $fullName = $_POST["full_name"];
    $emailAddress = $_POST["email_address"];
    $phoneNumber = $_POST["phone_number"];
    $password = $_POST["password"];

    $userProperties = [
        'email' => $emailAddress,
        'displayName' => $fullName ,
        'emailVerified' => false,
        'phoneNumber' => "+63".$phoneNumber,
        'password' => $password,
        
        
    ];

    $createUserCred = $auth->createUser($userProperties);
    if($createUserCred)
    {
        $_SESSION['status'] = "Successfully Created!";
        header('Location: home.php');
        exit();

    }else
    {
        $_SESSION['status'] = "Error!";
        header('Location: login.php');
        exit();
    }
    
}
//UPDATE USER
if(isset($_POST['update_user_button'])){

    $displayName = $_POST["full_name"];
    $email = $_POST["email_address"];
    $phone = $_POST["phone_number"];

    $uid = $_POST['edit-user-key'];
    $properties = [
        'displayName' => $displayName,
        'email' =>  $email,
        'phoneNumber' =>  $phone

    ];
    
    $updatedUser = $auth->updateUser($uid, $properties);

    if($updatedUser)
    {
        $_SESSION['status'] = "User Successfully Updated!";
        header('Location: profiles.php');
        exit();

    }else
    {
        $_SESSION['status'] = "Error!";
        header('Location: profiles.php');
        exit();
    }
    
}




//DELETE


if(isset($_POST['user_delete_button'])){

    $delete_uid = $_POST['user_delete_button'];


    $auth->deleteUser($delete_uid);


    try{
        if ($delete_uid === $_SESSION['verified_user_id']) {
            unset($_SESSION['verified_user_id']);
            unset($_SESSION['idTokenString']);

            $_SESSION['status'] = "Logged Out!";
            header('location: login.php');
            exit();
            header('Location: login.php');
            exit();
        } else {
            
            $_SESSION['status'] = "User Successfully Deleted!";
            header('Location: profiles.php');
            exit();
        }
    } catch (InvalidToken $e) {
        $_SESSION['status'] = "Token Expired/Invalid. Login Again";
        header('Location: login.php');
        exit();
        echo 'The token is invalid: '.$e->getMessage();
    } catch(Exception $e){
        $_SESSION['status'] = "Error!";
        header('Location: profiles.php');
        exit();
    }

}


//EDIT ACCOUNT SETTINGS

if (isset($_POST['enable_disable_user_button'])) {


    $disable_enable = $_POST['select_enable_disable'];
    $uid = $_POST['ena-dis-user'];

    if ($disable_enable == "Disabled") {

        $updatedUser = $auth->disableUser($uid);

        // Check if the user being disabled is currently logged in

        if ($uid === $_SESSION['verified_user_id']) {
            // Unset session variables to log the user out
            unset($_SESSION['verified_user_id']);
            unset($_SESSION['idTokenString']);

            // Redirect the user to the login page with a status message
            $_SESSION['status'] = "Your account has been disabled.";
            header('location: login.php');
            exit();
        }
        else{
            $updatedUser = $auth->disableUser($uid);
            $_SESSION['status'] = "User disabled successfully!";
            header('location: profiles.php');
            exit();

        }
    } else {
        $updatedUser = $auth->enableUser($uid);
        $_SESSION['status'] = "User enabled successfully!";
        header('location: profiles.php');
        exit();
    }
}


//CHANGE PASSWORD

if(isset($_POST['change_password_button'])){

    $new_password = $_POST['password'];
    $re_password = $_POST['confirm_password'];
    $uid = $_POST['change_password_id_value'];

    if($new_password == $re_password){
        $updatedUser = $auth->changeUserPassword($uid, $new_password );

        if($updatedUser){
            $_SESSION['status'] = "Password changed successfully!";
            header('location: profiles.php');
            exit();

        }


    }
    else{ 
            $_SESSION['status'] = "Unable to change password";
            header("Location: edit_account_settings_screens.php?uid=$uid");
            exit();
        
    }

}



?>