<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Edit Booking</title>
</head>
<body>
<?php
// Include database connection
include_once 'db_connection.php';

// Initialize variables
$bookingDetails = null;
$updateMessage = '';

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

        // Handle form submission for updating booking details
        if (isset($_POST['update'])) {
            // Retrieve updated values from form fields
            $updatedGuestName = mysqli_real_escape_string($conn, $_POST['guest_name']);
            $updatedCheckInDate = mysqli_real_escape_string($conn, $_POST['checkin_date']);
            $updatedCheckOutDate = mysqli_real_escape_string($conn, $_POST['checkout_date']);
            $updatedRoomDetails = mysqli_real_escape_string($conn, $_POST['room_details']);

            // Update booking details in the database using a prepared statement
            $updateSql = "UPDATE Bookings SET GuestName = ?, CheckInDate = ?, CheckOutDate = ?, RoomDetails = ? WHERE BookingID = ?";
            $stmt = mysqli_prepare($conn, $updateSql);
            mysqli_stmt_bind_param($stmt, 'sssssi', $updatedGuestName, $updatedCheckInDate, $updatedCheckOutDate, $updatedRoomDetails, $booking_id);

            if (mysqli_stmt_execute($stmt)) {
                $updateMessage = 'Booking details updated successfully.';
            } else {
                $updateMessage = 'Error updating booking details: ' . mysqli_error($conn);
            }
        }
    } else {
        echo "Booking not found.";
    }
} else {
    echo "Booking ID not provided.";
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Edit Booking</title>
</head>
<body>
    <?php if ($bookingDetails) : ?>
        <h1>Edit Booking</h1>
        <form method="POST">
            <label for="guest_name">Guest Name:</label>
            <?php if ($bookingDetails && isset($bookingDetails['GuestName'])) : ?>
    <input type="text" id="guest_name" name="guest_name" value="<?= htmlspecialchars($bookingDetails['GuestName']) ?>" required>
<?php else : ?>
    <input type="text" id="guest_name" name="guest_name" required>
<?php endif; ?>

            <br>

            <label for="checkin_date">Check-In Date:</label>
            <input type="date" id="checkin_date" name="checkin_date" value="<?= $bookingDetails['CheckInDate'] ?>" required>
            <br>

            <label for="checkout_date">Check-Out Date:</label>
            <input type="date" id="checkout_date" name="checkout_date" value="<?= $bookingDetails['CheckOutDate'] ?>" required>
            <br>

            <label for="room_details">Room Details:</label>
            <textarea id="room_details" name="room_details"><?= htmlspecialchars($bookingDetails['RoomDetails']) ?></textarea>
            <br>

            <input type="submit" name="update" value="Update">
        </form>

        <p><?= $updateMessage ?></p>
    <?php endif; ?>

    <!-- Add links back to the list of current bookings -->
    <p><a href="list_currentbookings.php">Back to List of Current Bookings</a></p>
</body>
</html>
