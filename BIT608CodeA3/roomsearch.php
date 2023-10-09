<?php
// Include database connection (You can add a comment with your actual database connection code)
include_once 'db_connection.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Check if required POST parameters are set
    if (isset($_POST['checkin_date']) && isset($_POST['checkout_date'])) {
        // Sanitize and validate user input
        $search_checkin_date = mysqli_real_escape_string($conn, $_POST['checkin_date']);
        $search_checkout_date = mysqli_real_escape_string($conn, $_POST['checkout_date']);

        // Perform database query to find available rooms within the date range
        $query = "SELECT * FROM Rooms WHERE RoomID NOT IN (
            SELECT DISTINCT RoomID FROM Bookings
            WHERE (CheckInDate BETWEEN ? AND ?)
               OR (CheckOutDate BETWEEN ? AND ?)
               OR (? BETWEEN CheckInDate AND CheckOutDate)
               OR (? BETWEEN CheckInDate AND CheckOutDate)
        )";

        // Prepare the SQL statement
        $stmt = mysqli_prepare($conn, $query);
        if (!$stmt) {
            die('Prepared statement error: ' . mysqli_error($conn));
        }

        // Bind parameters to the prepared statement
        mysqli_stmt_bind_param($stmt, 'sssss', $search_checkin_date, $search_checkout_date, $search_checkin_date, $search_checkout_date, $search_checkin_date, $search_checkout_date);
        
        // Execute the prepared statement
        mysqli_stmt_execute($stmt);
        
        // Get the result set
        $result = mysqli_stmt_get_result($stmt);

        if (!$result) {
            die('Database query error: ' . mysqli_error($conn));
        }

        // Fetch and store the available rooms in an array
        $availableRooms = array();
        while ($row = mysqli_fetch_assoc($result)) {
            $availableRooms[] = $row;
        }

        // Free the result set
        mysqli_free_result($result);

        // Close the database connection
        mysqli_close($conn);

        // Return the list of available rooms as JSON
        header('Content-Type: application/json');
        echo json_encode($availableRooms);
    } else {
        // Handle missing or invalid POST parameters
        echo json_encode(['error' => 'Invalid input data']);
    }
} else {
    // Handle the case where the request is not a POST request
    // You can provide a meaningful error message or redirect to an error page
    echo json_encode(['error' => 'Invalid request method']);
}
?>
