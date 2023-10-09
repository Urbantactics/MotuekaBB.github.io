<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>List of Current Bookings</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="container">
        <h1 class="heading url-heading">List of Current Bookings</h1>
    </div>

    <div class="topnav">
        <a href="privacypolicy.html">Privacy Policy</a>
        <a href="makeabooking.html">Make Booking</a>
        <a href="showbooking_detailsview.html">Booking Details View</a>
        <a href="edit_booking.html">Edit Booking</a>
        <a href="delete_booking.html">Delete Booking</a>
        <a href="#" class="exit-button" onclick="window.close()">Exit</a>
    </div>

    <!-- Display confirmation message if available -->
    <?php
    if (isset($_GET['message'])) {
        $message = $_GET['message'];
        echo '<div class="confirmation-message">' . htmlspecialchars($message) . '</div>';
    }
    ?>

    <!-- Display booking information if available -->
    <?php
    if (isset($_GET['booking'])) {
        $booking = json_decode($_GET['booking'], true);

        // Check if the JSON decoding was successful
        if ($booking !== null) {
            echo '<div class="booking-details">';
            echo '<h2>Booking Details</h2>';
            echo '<p><strong>Guests Details:</strong> ' . htmlspecialchars($booking['GuestsDetails']) . '</p>';
            echo '<p><strong>Check-in Date:</strong> ' . htmlspecialchars($booking['CheckInDate']) . '</p>';
            echo '<p><strong>Check-out Date:</strong> ' . htmlspecialchars($booking['CheckOutDate']) . '</p>';
            echo '<p><strong>Room Details:</strong> ' . htmlspecialchars($booking['RoomDetails']) . '</p>';
            // Add more fields as needed
            echo '</div>';
        } else {
            echo '<p>Unable to decode booking information.</p>';
        }
    }
    ?>

    <!-- Rest of your content -->
    
    <footer>
        <p>&lt;&lt;&lt; &copy; <a href="about.html">Maselina Mataki</a>&gt;&gt;&gt;</p>
        <p><a href="#">Back to top</a></p>
    </footer>
</body>
</html>
