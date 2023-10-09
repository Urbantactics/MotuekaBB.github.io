<?php
// Database Configuration Constants
define("DBHOST", "localhost");
define("DBUSER", "root");
define("DBPASSWORD", "root");
define("DBDATABASE", "motueka");

$confirmationMessage = ''; // Initialize the confirmation message
$bookingInfo = array(); // Initialize an array to store booking information

// Check if the script is running as a result of a form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Create a database connection
    $conn = mysqli_connect(DBHOST, DBUSER, DBPASSWORD, DBDATABASE, null, '/Applications/XAMPP/xamppfiles/var/mysql/mysql.sock');

    // Check the connection
    if (mysqli_connect_errno()) {
        die("Error: Unable to connect to MySQL. " . mysqli_connect_error());
    }

    if (isset($_POST["guests"]) && isset($_POST["checkin_date"]) && isset($_POST["checkout_date"]) && isset($_POST["roomDetails"]) && isset($_POST["cancellationPolicy"]) && isset($_POST["paymentMethod"]) && isset($_POST["roomID"]) && isset($_POST["customerID"])) {
        // Retrieve and sanitize form data
        $guests = mysqli_real_escape_string($conn, $_POST['guests']);
        $checkin_date = mysqli_real_escape_string($conn, $_POST['checkin_date']);
        $checkout_date = mysqli_real_escape_string($conn, $_POST['checkout_date']);
        $roomDetails = mysqli_real_escape_string($conn, $_POST['roomDetails']);
        $specialRequirements = mysqli_real_escape_string($conn, $_POST['specialRequirements']);
        $cancellationPolicy = mysqli_real_escape_string($conn, $_POST['cancellationPolicy']);
        $paymentMethod = mysqli_real_escape_string($conn, $_POST['paymentMethod']);
        $roomID = mysqli_real_escape_string($conn, $_POST['roomID']); // New field
        $customerID = mysqli_real_escape_string($conn, $_POST['customerID']); // New field

        // Prepare and execute SQL query using prepared statements
        $sql = "INSERT INTO Booking (GuestsDetails, CheckInDate, CheckOutDate, RoomDetails, SpecialRequirements, CancellationPolicy, PaymentMethod, RoomID, CustomerID)
                VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)";

        $stmt = mysqli_prepare($conn, $sql);
        mysqli_stmt_bind_param($stmt, "sssssssss", $guests, $checkin_date, $checkout_date, $roomDetails, $specialRequirements, $cancellationPolicy, $paymentMethod, $roomID, $customerID);

        if (mysqli_stmt_execute($stmt)) {
            $confirmationMessage = "Booking successfully created.";

            // Store booking information in an array
            $bookingInfo = [
                'GuestsDetails' => $guests,
                'CheckInDate' => $checkin_date,
                'CheckOutDate' => $checkout_date,
                'RoomDetails' => $roomDetails,
                'SpecialRequirements' => $specialRequirements,
                'CancellationPolicy' => $cancellationPolicy,
                'PaymentMethod' => $paymentMethod,
                'RoomID' => $roomID,
                'CustomerID' => $customerID
            ];
        } else {
            $confirmationMessage = "Error creating booking: " . mysqli_error($conn);
        }

        // Close the statement
        mysqli_stmt_close($stmt);

        // Close the connection
        mysqli_close($conn);

        // Redirect to the "List of Current Bookings" page with the confirmation message and booking information
        header("Location: list_currentbookings.php?message=" . urlencode($confirmationMessage) . "&booking=" . urlencode(json_encode($bookingInfo)));
        exit; // Terminate script after redirection
    } else {
        $confirmationMessage = "Form data is incomplete. Please fill out all required fields.";
    }
}
?>
