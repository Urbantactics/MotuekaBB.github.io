<?php
// Define a custom exception class for database-related errors
class DatabaseException extends Exception {}

// Define your database configuration constants (consider using environment variables)
define("DBHOST", "localhost");
define("DBUSER", "root");
define("DBPASSWORD", "root");
define("DBDATABASE", "motueka");

// Function to connect to the database
function connectToDatabase() {
    $conn = new mysqli(DBHOST, DBUSER, DBPASSWORD, DBDATABASE);

    if ($conn->connect_error) {
        throw new DatabaseException("Database connection failed: " . $conn->connect_error);
    }

    return $conn;
}

// Function to execute the motueka.sql file
function executeMotuekaSql($connection) {
    $filename = "/Users/mcsm/Desktop/BIT608WP A3/BIT608CodeA3/motueka.sql"; // Replace with the path to your motueka.sql file
    $sql = file_get_contents($filename);

    if ($sql === false) {
        throw new DatabaseException("Error reading SQL file: $filename");
    }

    if ($connection->multi_query($sql)) {
        do {
            // Consume each query result (even if it's just to skip it)
            if ($result = $connection->store_result()) {
                $result->free();
            }
        } while ($connection->more_results() && $connection->next_result());
    } else {
        throw new DatabaseException("Error executing SQL script: " . $connection->error);
    }
}

// Main execution
try {
    $conn = connectToDatabase();

    // Execute the motueka.sql file
    executeMotuekaSql($conn);

    // Close the connection
    $conn->close();

    echo "Sample data inserted successfully.";
} catch (DatabaseException $e) {
    echo "Database Error: " . $e->getMessage();
} catch (Exception $e) {
    echo "An error occurred: " . $e->getMessage();
}
?>
