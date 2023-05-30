
<?php
session_start();
use Kreait\Firebase\Factory;

use Firebase\Auth\Token\Exception\InvalidToken;
use Kreait\Firebase\ServiceAccount;


include('dbcon.php');



// Initialize Firebase Auth

// Function to check if email exists in Firebase Auth
function emailExists($email)
{
    global $auth;

    try {
        $user = $auth->getUserByEmail($email);
        return true; // Email exists
    } catch (\Kreait\Firebase\Exception\Auth\UserNotFound$e) {
        return false; // Email does not exist
    } catch (\Throwable $e) {
        // Handle other exceptions
        return false; // Return false or throw custom exception as per your requirements
    }
}
function phoneNumberExists($phoneNumber)
{
    global $auth;

    try {
        $user = $auth->getUserByPhoneNumber($phoneNumber);
        return true; // Phone number exists
    } catch (\Kreait\Firebase\Exception\Auth\UserNotFound $e) {
        return false; // Phone number does not exist
    } catch (\Throwable $e) {
        // Handle other exceptions
        return false; // Return false or throw custom exception as per your requirements
    }
}

//REGISTER USER 
if (isset($_POST['register_user_button'])) {
    $fullName = $_POST["full_name"];
    $emailAddress = $_POST["email_address"];
    $phoneNumber = $_POST["phone_number"];
    $password = $_POST["password"];

    try {
        // Check if email or phone number already exists
        if (emailExists($emailAddress)) {
            throw new Exception("Email address already exists.");
        }

        if (phoneNumberExists($phoneNumber)) {
            throw new Exception("Phone number already exists.");
        }

        // User properties for creating a new user
        $userProperties = [
            'email' => $emailAddress,
            'displayName' => $fullName,
            'emailVerified' => false,
            'phoneNumber' => '+63' . $phoneNumber,
            'password' => $password,
        ];

        // Assuming you have an instance of Firebase Authentication SDK assigned to $auth
        $createUserCred = $auth->createUser($userProperties);
        if ($createUserCred) {
            $_SESSION['status'] = "Successfully Created!";
            header('Location: profiles.php');
            exit();
        } else {
            $_SESSION['status'] = "Error!";
            header('Location: register.php');
            exit();
        }
    } catch (Exception $e) {
        // Handle the exception
        $_SESSION['status'] = $e->getMessage();
        header('Location: register.php');
        exit();
    }
}

//UPDATE USER ( SUPER ADMIN PRIVILAGE)
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




//DELETE ( SUPER ADMIN PRIVILAGE)


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


//EDIT ACCOUNT SETTINGS ( SUPER ADMIN PRIVILAGE)

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


//CHANGE PASSWORD (SUPER ADMIN PRIVILAGE)

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


if(isset($_POST['change_password_button_user'])){

    $new_password = $_POST['password'];
    $re_password = $_POST['confirm_password'];
    $uid = $_POST['change_password_id_value'];

    if($new_password == $re_password){
        $updatedUser = $auth->changeUserPassword($uid, $new_password );

        if($updatedUser){
            $_SESSION['status'] = "Password changed successfully!";
            header('location: user_profile_screen.php');
            exit();

        }


    }
    else{ 
            $_SESSION['status'] = "Unable to change password";
            header("Location: user_profile_screen.php?uid=$uid");
            exit();
        
    }

}

//ROLES ( SUPER ADMIN PRIVILAGE)


if(isset($_POST['roles_user_button'])){

    
    $uid = $_POST['roles-user-id'];
    $roles = $_POST['select_roles_user'];

    if($roles =='Superadmin'){

        $auth->setCustomUserClaims($uid, ['Superadmin' => true]);
        $msg = "Roles updated into SuperAdmin";
    }
    elseif($roles =='Admin'){
        $auth->setCustomUserClaims($uid, ['Admin' => true]);
        $msg = "Roles updated into Admin";
    } 
    elseif($roles =='Norole'){
        $auth->setCustomUserClaims($uid, null);
        $msg = "Roles updated into No roles";
    } 



    if ($msg) {
        $_SESSION['status'] = $msg;
        header("Location: profiles.php");
        exit();
    } else if (!$msg) {
        $_SESSION['status'] = "Unable to change roles";
        header("Location: profiles.php");
        exit();
    }
    
  
  

}



//EDIT PROFILE (ANY ROLES PRIVILAGE)

if(isset($_POST['user_profile_submit_button'])){

    $displayName = $_POST["full_name"];
    $email = $_POST["email_address"];
    $phone = $_POST["phone_number"];

    $uid = $_POST['user_profile_key'];

    $properties = [
        'displayName' => $displayName,
        'email' =>  $email,
        'phoneNumber' =>  $phone

    ];
    
    $updatedUser = $auth->updateUser($uid, $properties);

    if($updatedUser)
    {
        $_SESSION['status'] = "User Successfully Updated!";
        header('Location: user_profile.php');
        exit();

    }else
    {
        $_SESSION['status'] = "Error!";
        header('Location: user_profile.php');
        exit();
    }
    
}

//REGISTER SUPPLIER (SUPER ADMIN PRIVILAGE)

if(isset($_POST['register_supplier_user_button']))
{
    $supplier_full_name = $_POST['supplier_full_name'];
    $supplier_phoneNumber = $_POST['supplier_phone_number'];
    $supplier_emailAddress= $_POST['supplier_email_address'];
    

    $uid = $_SESSION['verified_user_id'];
    $user = $auth->getUser($uid);

    $supplierRef = $database->getReference('supplier');
    $supplierData = [
            'supplierFullName' => $supplier_full_name,
            'supplierPhoneNumber' => $supplier_phoneNumber, 
            'supplierEmailAddress' => $supplier_emailAddress,

        ];
       
        $supplierRef_result = $supplierRef->push($supplierData);

        if($supplierRef_result !== false && $supplierRef_result !== null)
            {
                $_SESSION['status'] = "Added!";
                header('location: supplier.php');
            }
            else
            {
                $_SESSION['status'] = "Error!";
                header('location: supplier.php');
            }
    
}

//EDIT SUPPLIER (SUPER ADMIN PRIVILAGE)

if (isset($_POST['edit_supplier_user_button'])) {
    $key = $_POST['key'];

    $ref_table = 'supplier/'.$key;

    $supplier_full_name = $_POST['supplier_full_name'];
    $supplier_phoneNumber = $_POST['supplier_phone_number'];
    $supplier_emailAddress = $_POST['supplier_email_address'];

    $supplierData = [
        'supplierFullName' => $supplier_full_name,
        'supplierPhoneNumber' => $supplier_phoneNumber, 
        'supplierEmailAddress' => $supplier_emailAddress,
    ];

    $supplierRef_result = $database->getReference($ref_table)
        ->update($supplierData);

    if ($supplierRef_result) {
        $_SESSION['status'] = "Updated";
        header('location: supplier.php');
        exit();
    } else {
        $_SESSION['status'] = "Error";
        header('location: supplier.php');
        exit();
    }
}
//DELETE SUPPLIER (SUPER ADMIN PRIVILAGE)


if(isset($_POST['delete_supplier_button'])){

    $delete_id = $_POST['delete_supplier_button'];
    $ref_table = 'supplier/'.$delete_id;
    $supplierRef = $database->getReference($ref_table);


    $deleteSupplierCred = $supplierRef->remove();

    if ($deleteSupplierCred) {
        $_SESSION['status'] = "Deleted!";
        header('location: supplier.php');
    } else {
        $_SESSION['status'] = "Error!";
        header('location: supplier.php');
    }
}

?>