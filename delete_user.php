<?php
session_start();
include('server.php'); // Database connection file

if (isset($_GET['id'])) {
    $userId = mysqli_real_escape_string($db, $_GET['id']);
    
    // Log deletion
    $activityQuery = "SELECT username FROM users WHERE id='$userId'";
    $activityResult = mysqli_query($db, $activityQuery);
    $username = mysqli_fetch_assoc($activityResult)['username'];

    // Delete the user
    $query = "DELETE FROM users WHERE id='$userId'";
    mysqli_query($db, $query);
    
    logUserActivity($db, $userId, 'User Deleted', "Deleted user: $username");
    
    header('Location: admin_dashboard.php');
    exit();
}

function logUserActivity($db, $userId, $activityType, $details = '') {
    $query = "INSERT INTO user_activity_logs (user_id, activity_type, details) VALUES ('$userId', '$activityType', '$details')";
    mysqli_query($db, $query);
}
?>
