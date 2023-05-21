
<?php

require_once 'config.php';

session_start();
include ('dbcon.php');
include ('config.php');

use \Picqer\Barcode\BarcodeGeneratorHTML as BG;

require __DIR__.'/vendor/autoload.php';


if (isset($_FILES['image-input']) && $_FILES['image-input']['error'] === UPLOAD_ERR_OK) {
    $fileData = file_get_contents($_FILES['image-input']['tmp_name']);
    $fileName = $_SESSION['verified_user_id'] . '.jpg'; // Use the user's ID as the filename

    // Specify the destination path in Firebase Storage
    $destination = 'user-profile/' . $_SESSION['verified_user_id'] . '/' . $fileName;

    // Upload the file to Firebase Storage
    $bucket->upload($fileData, [
        'name' => $destination,
    ]);

    // Get the URL of the uploaded file
    $fileUrl = $bucket->object($destination)->signedUrl(new \DateTime('+1 hour')); // Generate a signed URL that is valid for 1 hour

    // Store the photo URL in a session variable
    $_SESSION['photo_url'] = $fileUrl;

    // Store the photo URL in the database associated with the user
    // Replace this with your Firebase Realtime Database code
    $database = $factory->createDatabase();
    $database->getReference('users/' . $_SESSION['verified_user_id'])->update([
        'photo_url' => $fileUrl,
    ]);

    header('location: user_profile.php');
} else {
    header('location: user_profile.php');
}


?>