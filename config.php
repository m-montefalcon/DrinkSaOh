<?php
require __DIR__.'/vendor/autoload.php';

use Kreait\Firebase\Factory;
use Kreait\Firebase\ServiceAccount;
use Kreait\Firebase\Storage;

// Load the service account JSON file

// Initialize the Firebase app
$factory = (new Factory)
    ->withServiceAccount(__DIR__.'/system-inventory-management-firebase-adminsdk-nk0g2-61b057670e.json')
    ->withDatabaseUri('https://system-inventory-management-default-rtdb.firebaseio.com/');

$storage = $factory->createStorage();

// Get the default storage bucket
$bucket = $storage->getBucket();
?>
