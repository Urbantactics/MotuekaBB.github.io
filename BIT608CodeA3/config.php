<?php
// Database Configuration Constants
define("DBHOST", "localhost");
define("DBUSER", "root");
define("DBPASSWORD", "root");
define("DBDATABASE", "motueka");

// Include the database configuration
include_once "config.php";

// Create a database connection
$conn = mysqli_connect(DBHOST, DBUSER, DBPASSWORD, DBDATABASE, null, '/Applications/XAMPP/xamppfiles/var/mysql/mysql.sock');

// Check the connection
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

// Now you can use $conn to perform database operations
?>
