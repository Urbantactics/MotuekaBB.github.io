<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>List Current Bookings</title>
</head>
<body>
    <h1>List Current Bookings</h1>
    <table>
        <tr>
            <th>Booking ID</th>
            <th>Guests Details</th>
            <th>Check-in Date</th>
            <th>Check-out Date</th>
            <th>Actions</th>
        </tr>
        <?php
        // Include database connection
        include_once 'db_connection.php';

        // Function to fetch bookings
        function fetchBookings($conn) {
            $bookings = array();

            $sql = "SELECT * FROM Bookings";
            $result = mysqli_query($conn, $sql);

            while ($row = mysqli_fetch_assoc($result)) {
                $bookings[] = $row;
            }

            return $bookings;
        }

        // Fetch and display bookings
        $bookings = fetchBookings($conn);

        foreach ($bookings as $booking) {
            echo "<tr>";
            echo "<td>{$booking['BookingID']}</td>";
            echo "<td>{$booking['GuestsDetails']}</td>";
            echo "<td>{$booking['CheckInDate']}</td>";
            echo "<td>{$booking['CheckOutDate']}</td>";
            echo "<td><a href='view_booking.php?booking_id={$booking['BookingID']}'>View</a> | <a href='edit_booking.php?booking_id={$booking['BookingID']}'>Edit</a> | <a href='delete_booking.php?booking_id={$booking['BookingID']}'>Delete</a></td>";
            echo "</tr>";
        }
        ?>
    </table>
</body>
</html>
