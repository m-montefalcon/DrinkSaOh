<?php
session_start();
include('dbcon.php');

unset($_SESSION['verified_user_id']);
unset($_SESSION['idTokenString']);

if(isset($_SESSION['verified_Superadmin'])){
    unset($_SESSION['verified_Superadmin']);
    $_SESSION['status'] = "Logged Out!";
    header('location: login.php');
    exit();

}
elseif(isset($_SESSION['verified_admin'])){

    unset($_SESSION['verified_admin']);
    $_SESSION['status'] = "Logged Out!";
    header('location: login.php');
    exit();
}

$_SESSION['status'] = "Logged Out!";
header('location: login.php');
exit();


?>