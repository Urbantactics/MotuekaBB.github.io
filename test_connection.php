<?php
include_once "config.php"; // Load database connection configuration

// Establish the database connection with socket option and port
$db_connection = mysqli_init();
mysqli_options($db_connection, MYSQLI_OPT_CONNECT_TIMEOUT, 10); // Set a timeout in seconds

// Replace PORT_NUMBER with the actual port number you want to use
$port = 4306;

mysqli_real_connect($db_connection, DBHOST, DBUSER, DBPASSWORD, DBDATABASE, $port, '/Applications/XAMPP/xamppfiles/var/mysql/mysql.sock');

if (mysqli_connect_errno()) {
    die("Error: Unable to connect to MySQL. " . mysqli_connect_error());
}

// Test the connection by running a query
$query = "SELECT 1";
$result = mysqli_query($db_connection, $query);

if ($result) {
    echo "Database connection successful!";
} else {
    echo "Database connection failed: " . mysqli_error($db_connection);
}

// Close the connection
mysqli_close($db_connection);

?>
