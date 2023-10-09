<?php
include_once "config.php"; // Load database configuration

// Create a database connection
$conn = mysqli_connect(DBHOST, DBUSER, DBPASSWORD, DBDATABASE, null, '/Applications/XAMPP/xamppfiles/var/mysql/mysql.sock');

// Check the connection
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

function getBookingDetails($conn, $bookingId) {
    $sql = "SELECT * FROM Bookings WHERE BookingID = ?";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "i", $bookingId);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    return mysqli_fetch_assoc($result);
}

function displayBookingDetails($booking) {
    if ($booking) {
        echo "<p><strong>Booking ID:</strong> " . htmlspecialchars($booking['BookingID']) . "</p>";
        echo "<p><strong>Guests Details:</strong> " . htmlspecialchars($booking['GuestName']) . "</p>";
        echo "<p><strong>Check-in Date:</strong> " . htmlspecialchars($booking['CheckInDate']) . "</p>";
        echo "<p><strong>Check-out Date:</strong> " . htmlspecialchars($booking['CheckOutDate']) . "</p>";
        echo "<p><strong>Room Details:</strong> " . htmlspecialchars($booking['RoomDetails']) . "</p>";
        // Display other booking details here
        echo "<p><a href='list_currentbookings.php'>Back to List of Current Bookings</a></p>";
    } else {
        echo "Booking not found.";
    }
}

if (isset($_GET['booking_id'])) {
    $booking_id = $_GET['booking_id'];
    if (filter_var($booking_id, FILTER_VALIDATE_INT) && $booking_id > 0) {
        $booking = getBookingDetails($conn, $booking_id); // Remove the second argument here
        displayBookingDetails($booking);
    } else {
        echo "Invalid booking ID provided.";
    }
} else {
    echo "Booking ID not provided.";
}

// Debugging: Print out database credentials
//echo "Host: $host<br>";
//echo "Username: $username<br>";
//echo "Password: $password<br>";
//echo "Database Name: $database_name<br>";


mysqli_close($conn);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>View Booking Details</title>
</head>
<body>
    <h1>View Booking Details</h1>
    <!-- Your HTML content goes here -->
</body>
</html>
