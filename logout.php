<?php
session_start();
include('dbcon.php');

unset($_SESSION['verified_user_id']);
unset($_SESSION['idTokenString']);

$_SESSION['status'] = "Logged Out!";
header('location: login.php');
exit();


?>