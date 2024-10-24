<?php
session_start();
include('server.php'); // Database connection file

if (isset($_POST['user_id']) && isset($_POST['role'])) {
    $userId = mysqli_real_escape_string($db, $_POST['user_id']);
    $newRole = mysqli_real_escape_string($db, $_POST['role']);

    $query = "UPDATE users SET role='$newRole' WHERE id='$userId'";
    mysqli_query($db, $query);
    
    // Log the role change
    logUserActivity($db, $userId, 'Role Changed', "New role: $newRole");
    
    header('Location: admin_dashboard.php');
    exit();
}

function logUserActivity($db, $userId, $activityType, $details = '') {
    $query = "INSERT INTO user_activity_logs (user_id, activity_type, details) VALUES ('$userId', '$activityType', '$details')";
    mysqli_query($db, $query);
}
?>
