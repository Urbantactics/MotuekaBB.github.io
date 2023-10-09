<!DOCTYPE HTML>
<html lang="en">
<head>
    <title>Create a Booking</title>
    <!-- Include your CSS styles here -->
    <link rel="stylesheet" type="text/css" href="style.css">
</head>
<body>
    <h1>Create a Booking</h1>

    <?php
    include_once "config.php"; // Load database connection configuration
    $db_connection = mysqli_connect(DBHOST, DBUSER, DBPASSWORD, DBDATABASE);

    if (mysqli_connect_errno()) {
        echo "Error: Unable to connect to MySQL. " . mysqli_connect_error();
        exit;
    }

    // Fetch available rooms from the database
    $rooms_query = "SELECT * FROM Rooms";
    $rooms_result = mysqli_query($db_connection, $rooms_query);
    ?>

    <form method="POST" action="booking_process.php" onsubmit="return validateForm()">
        <label for="room">Select a Room:</label>
        <select id="room" name="room">
            <?php
            while ($row = mysqli_fetch_assoc($rooms_result)) {
                echo "<option value='" . $row['roomID'] . "'>" . $row['roomName'] . "</option>";
            }
            ?>
        </select>
        <br>

        <label for="checkin_date">Check-In Date:</label>
        <input type="date" id="checkin_date" name="checkin_date" required>
        <br>

        <label for="checkout_date">Check-Out Date:</label>
        <input type="date" id="checkout_date" name="checkout_date" required>
        <br>

        <!-- Add other booking input fields here, such as guest details, special requirements, etc. -->

        <input type="submit" name="submit" value="Create Booking">
    </form>

    <!-- Include your JavaScript validation code here -->
    <!-- Include your JavaScript validation code here -->
<script>
    function validateForm() {
        var checkinDate = document.getElementById("checkin_date").value;
        var checkoutDate = document.getElementById("checkout_date").value;

        // Add your validation logic here
        if (checkinDate >= checkoutDate) {
            alert("Check-out date must be after check-in date.");
            return false; // Prevent form submission
        }

        // Additional validation checks...

        return true; // Form is valid, allow submission
    }
</script>
    <?php
    mysqli_close($db_connection);
    ?>
</body>
</html>
