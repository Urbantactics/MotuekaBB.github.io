<?php
// Define your constants at the beginning of your script.
define("MY_CONSTANT_NAME", false);
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

// Load and execute SQL files
function executeSqlFile($filename, $connection) {
    $sql = file_get_contents($filename);
    if ($sql === false) {
        die("Error reading SQL file.");
    }

    $queries = explode(";", $sql);
    foreach ($queries as $query) {
        $query = trim($query);
        if (!empty($query)) {
            mysqli_query($connection, $query);
        }
    }
}

// Usage example
$filename = "/Users/mcsm/Desktop/BIT608WP A3/BIT608CodeA3/motueka.sql"; // Replace with the path to your SQL file

// Execute the SQL file using the established database connection
executeSqlFile($filename, $db_connection);

// Close the connection
mysqli_close($db_connection);
?>
