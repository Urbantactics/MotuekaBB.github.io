<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>View Booking Details</title>
</head>
<body>
    <h1>View Booking Details</h1>
    <?php
    // Include database connection
    include_once 'db_connection.php'; // Create this file to establish a database connection
    
    // Get booking ID from URL parameter and validate it
    if (isset($_GET['booking_id']) && is_numeric($_GET['booking_id'])) {
        $booking_id = $_GET['booking_id'];
        
        // Prepare a statement to fetch and display booking details
        $sql = "SELECT * FROM Bookings WHERE BookingID = ?";
        $stmt = mysqli_prepare($conn, $sql);
        mysqli_stmt_bind_param($stmt, 'i', $booking_id);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);
        
        if ($row = mysqli_fetch_assoc($result)) {
            echo "<p><strong>Booking ID:</strong> {$row['BookingID']}</p>";
            echo "<p><strong>Guest Name:</strong> {$row['GuestName']}</p>";
            echo "<p><strong>Check-in Date:</strong> {$row['CheckInDate']}</p>";
            echo "<p><strong>Check-out Date:</strong> {$row['CheckOutDate']}</p>";
            echo "<p><strong>Room Details:</strong> {$row['RoomDetails']}</p>";
            // Display other booking details here
        } else {
            echo "Booking not found.";
        }
        
        // Close the prepared statement
        mysqli_stmt_close($stmt);
    } else {
        echo "Invalid Booking ID.";
    }
    ?>
    <p><a href="previous_page.php">Back to Previous Page</a></p>
</body>
</html>
