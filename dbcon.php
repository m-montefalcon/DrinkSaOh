<?php

require __DIR__.'/vendor/autoload.php';
use Kreait\Firebase\Factory;
use Kreait\Firebase\Contract\Auth;
use Firebase\Auth\Token\Exception\InvalidToken;
use Kreait\Firebase\Exception\Auth\FailedToVerifyToken;

$factory = (new Factory)
->withServiceAccount('system-inventory-management-firebase-adminsdk-nk0g2-61b057670e.json')
->withDatabaseUri('https://system-inventory-management-default-rtdb.firebaseio.com/');


$database = $factory->createDatabase();


$auth = $factory->createAuth();



?>

