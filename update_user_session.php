<?php
session_start();
include('server.php'); // File to connect to the database

$user_id = $_SESSION['user_id'];

// Create or update a session record
if (!isset($_SESSION['session_id'])) {
    // Start a new session
    $query = "INSERT INTO user_sessions (user_id, page_count) VALUES ('$user_id', 1)";
    mysqli_query($db, $query);
    $_SESSION['session_id'] = mysqli_insert_id($db);
} else {
    // Update the existing session
    $session_id = $_SESSION['session_id'];
    $query = "UPDATE user_sessions SET page_count = page_count + 1 WHERE id = '$session_id'";
    mysqli_query($db, $query);
}
?>
