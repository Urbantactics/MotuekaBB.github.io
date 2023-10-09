<?php

// Function to check if the user is logged in
function checkUser() {
    return isset($_SESSION['user_id']);
    }

// Function to display login status or a login form
function loginStatus() {
    if (checkUser()) {
        // User is logged in, display a welcome message or user details
        echo '<p>Welcome,to the Motueka B&B' . $_SESSION['username'] . '!</p>';
        echo '<p><a href="logout.php">Logout</a></p>'; // Provide a logout link
    } else {
        // User is not logged in, display a login form or a message
        echo '<p>Please log in to access the dashboard.</p>';
        echo '<p><a href="login.php">Login</a></p>'; // Provide a login link
    }
}

// You can include more session-related functions here

?>
