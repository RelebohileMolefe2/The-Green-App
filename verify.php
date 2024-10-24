<?php
session_start();
$db = mysqli_connect('localhost', 'root', '', 'greenhub-app');

// Check if the token is provided in the URL
if (isset($_GET['token'])) {
    $token = mysqli_real_escape_string($db, $_GET['token']);

    // Look for the user with the given token
    $query = "SELECT * FROM users WHERE token='$token' AND is_verified=0 LIMIT 1";
    $result = mysqli_query($db, $query);
    $user = mysqli_fetch_assoc($result);

    if ($user) {
        // User found, update their verification status
        $query = "UPDATE users SET is_verified=1 WHERE token='$token'";
        mysqli_query($db, $query);

        if (mysqli_affected_rows($db) > 0) {
            $_SESSION['success'] = "Email verified successfully! You can now log in.";
            header('location: login.php'); // Redirect to login page
            exit();
        } else {
            $_SESSION['error'] = "Failed to verify email. Please try again.";
        }
    } else {
        $_SESSION['error'] = "Invalid token or email already verified.";
    }
} else {
    $_SESSION['error'] = "No token provided.";
}

// Redirect to an error page or display an error message
header('location: error.php'); // Create an error.php to display error messages
exit();
?>
