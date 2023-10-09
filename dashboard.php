<?php
session_start();
include_once 'session_functions.php'; // Include your session handling functions

// Check if the user is logged in and has the appropriate role
if (!checkUser()) {
    header('Location: login.php'); // Redirect to login page if not logged in
    exit(); // Stop script execution after the redirect
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Dashboard - Your Site Name</title>
    <!-- Include your CSS and other head content here -->
</head>
<body>
    <?php
    loginStatus(); // Show login status
    ?>
    <h1>Welcome to the Dashboard</h1>
    <!-- Include the rest of your page content -->
</body>
</html>
