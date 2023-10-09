<?php
// Include database connection
include_once 'db_connection.php';

// Initialize variables
$bookingDetails = null;
$bookingDeleted = false;
$errorMsg = "";

// Check if a booking ID is provided in the URL
if (isset($_GET['booking_id'])) {
    $booking_id = $_GET['booking_id'];

    // Fetch booking details using a prepared statement
    $sql = "SELECT * FROM Bookings WHERE BookingID = ?";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, 'i', $booking_id);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);

    if ($row = mysqli_fetch_assoc($result)) {
        $bookingDetails = $row;

        // Check if the delete form is submitted
        if (isset($_POST['delete'])) {
            // Check for confirmation
            if (isset($_POST['confirm']) && $_POST['confirm'] === 'yes') {
                // Delete the booking using a prepared statement
                $delete_sql = "DELETE FROM Bookings WHERE BookingID = ?";
                $stmt = mysqli_prepare($conn, $delete_sql);
                mysqli_stmt_bind_param($stmt, 'i', $booking_id);

                if (mysqli_stmt_execute($stmt)) {
                    $bookingDeleted = true;
                } else {
                    $errorMsg = "Error deleting booking: " . mysqli_error($conn);
                }
            } else {
                $errorMsg = "Deletion not confirmed. Booking was not deleted.";
            }
        }
    } else {
        $errorMsg = "Booking not found.";
    }
} else {
    $errorMsg = "Booking ID not provided.";
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>Delete Booking</title>
</head>
<body>
    <h1>Delete Booking</h1>
    
    <?php if ($bookingDetails) : ?>
        <p><strong>Booking ID:</strong> <?= $bookingDetails['BookingID'] ?></p>
        <p><strong>Guest Name:</strong> <?= $bookingDetails['GuestName'] ?></p>
        <p><strong>Check-in Date:</strong> <?= $bookingDetails['CheckInDate'] ?></p>
        <p><strong>Check-out Date:</strong> <?= $bookingDetails['CheckOutDate'] ?></p>
        <p><strong>Room Details:</strong> <?= $bookingDetails['RoomDetails'] ?></p>
        
        <!-- Confirmation form -->
        <p>Are you sure you want to delete this booking?</p>
        <form method='POST'>
            <input type='hidden' name='booking_id' value='<?= $bookingDetails['BookingID'] ?>'>
            <input type='hidden' name='confirm' value='yes'>
            <input type='submit' name='delete' value='Delete'>
        </form>
        
        <!-- Display error message if deletion failed -->
        <?php if ($errorMsg) : ?>
            <p>Error: <?= $errorMsg ?></p>
        <?php endif; ?>

        <?php if ($bookingDeleted) : ?>
            <p>Booking deleted successfully.</p>
        <?php endif; ?>
    <?php endif; ?>

    <!-- Add a link back to the list of current bookings -->
    <p><a href="list_currentbookings.php">Back to List of Current Bookings</a></p>
</body>
</html>
