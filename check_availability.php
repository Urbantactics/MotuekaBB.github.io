<?php
// Include database connection
include_once 'db_connection.php'; // Replace with your actual database connection code

// Retrieve and validate check-in and check-out dates from POST parameters
$fromDate = $_POST['from_date'];
$endDate = $_POST['end_date'];

// Validate date inputs (you can use a date validation library for more robust validation)
if (!validateDate($fromDate) || !validateDate($endDate)) {
    http_response_code(400); // Bad Request
    echo json_encode(['error' => 'Invalid date format']);
    exit();
}

// Prepare a SQL query using prepared statements
$query = "SELECT * FROM room WHERE roomID NOT IN (
    SELECT roomID FROM booking
    WHERE checkin >= ? AND checkout <= ?
)";
$stmt = mysqli_prepare($conn, $query);

if (!$stmt) {
    http_response_code(500); // Internal Server Error
    echo json_encode(['error' => 'Database error']);
    exit();
}

// Bind parameters and execute the query
mysqli_stmt_bind_param($stmt, 'ss', $fromDate, $endDate);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);

// Fetch and store the available rooms in an array
$availableRooms = array();
while ($row = mysqli_fetch_assoc($result)) {
    $availableRooms[] = $row;
}

// Close the statement and database connection
mysqli_stmt_close($stmt);
mysqli_close($conn);

// Return the list of available rooms as JSON
header('Content-Type: application/json');
echo json_encode($availableRooms);

// Function to validate date format (example; you can replace with a more robust method)
function validateDate($date) {
    return (bool) strtotime($date);
}
?>
