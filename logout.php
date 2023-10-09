<?php
// Start the session at the very beginning of the script
session_start();

// Include your session handling functions
include_once 'session_functions.php';

// Call the logout function
logout();

// Redirect to the login page after logout
header('Location: login.php');
exit(); // Ensure that no further code is executed after the redirection
?>
