<?php
require_once 'client/classloader.php';

// Create an administrator user
$username = 'admin';
$email = 'admin@fiverrclone.com';
$password = 'admin123';
$contact_number = '1234567890';
$is_client = 1; // Can act as client
$is_administrator = 1; // Is administrator

try {
    if ($userObj->createAdminUser($username, $email, $password, $contact_number, $is_client, $is_administrator)) {
        echo "Administrator user created successfully!<br>";
        echo "Username: admin<br>";
        echo "Email: admin@fiverrclone.com<br>";
        echo "Password: admin123<br>";
    } else {
        echo "Error creating administrator user!";
    }
} catch (Exception $e) {
    echo "Error: " . $e->getMessage();
}
?>
