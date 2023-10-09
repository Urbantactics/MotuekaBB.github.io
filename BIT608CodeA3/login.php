<?php
session_start();

// Check if "Remember Me" checkbox is checked
$remember_me = isset($_POST['remember_me']) ? true : false;

// Set the session duration based on whether "Remember Me" is checked
if ($remember_me) {
    // Set a longer session duration (e.g., 7 days)
    ini_set('session.cookie_lifetime', 7 * 24 * 3600);
}

// Set session timeout (e.g., 30 minutes of inactivity)
$_SESSION['timeout'] = 1800; // 1800 seconds = 30 minutes

// Initialize last activity time
if (!isset($_SESSION['last_activity'])) {
    $_SESSION['last_activity'] = time();
}

// Check if the session has timed out due to inactivity
if (time() - $_SESSION['last_activity'] > $_SESSION['timeout']) {
    // Session has timed out; destroy it and redirect to the login page
    session_destroy();
    header('Location: login.php');
    exit();
}

// Update last activity time on every page load
$_SESSION['last_activity'] = time();

// Include your database connection code here
include_once 'db_connection.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Use prepared statement to avoid SQL injection
    $query = "SELECT id, username, password, role FROM users WHERE username = ?";
    $stmt = mysqli_prepare($conn, $query);
    mysqli_stmt_bind_param($stmt, 's', $username);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);

    if ($row = mysqli_fetch_assoc($result)) {
        if (password_verify($password, $row['password'])) {
            $_SESSION['loggedin'] = true;
            $_SESSION['userid'] = $row['id'];
            $_SESSION['username'] = $row['username'];
            $_SESSION['role'] = $row['role'];

            // Set session timeout
            $_SESSION['last_activity'] = time();

            // Redirect to the appropriate page
            header('Location: listcustomers.php');
            exit();
        }
    }

    // Invalid credentials
    $error_message = "Invalid credentials. Please try again.";
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Login</title>
    <link rel="stylesheet" type="text/css" href="style.css">
</head>
<body>
    <div class="login-container">
        <h1>Login</h1>
        
        <?php if (isset($error_message)): ?>
            <p class="error-message"><?php echo $error_message; ?></p>
        <?php endif; ?>

        <form method="POST" action="login.php">
            <label for="username">Username:</label>
            <input type="text" id="username" name="username" required><br>
            <label for="password">Password:</label>
            <input type="password" id="password" name="password" required><br>
            
            <!-- "Remember Me" checkbox -->
            <label for="remember_me">Remember Me:</label>
            <input type="checkbox" id="remember_me" name="remember_me">
            
            <input type="submit" value="Log In">
        </form>
        
        <?php if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] === true): ?>
            <!-- Display Logout Link if User is Logged In -->
            <form method="POST" action="logout.php">
                <a href="logout.php" class="logout-link">Log Out</a>
            </form>
        <?php endif; ?>
    </div>
</body>
</html>
