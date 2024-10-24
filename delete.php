<?php
if (isset($_GET["center_name"])) {
    $center_name = $_GET['center_name'];

    // Database connection details
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "greenhub-app";

    // Create connection
    $connection = new mysqli($servername, $username, $password, $dbname);

    // Check for connection errors
    if ($connection->connect_error) {
        die("Connection failed: " . $connection->connect_error);
    }

    // Use prepared statement to prevent SQL injection
    $sql = "DELETE FROM recycling_centers WHERE center_name = ?";
    $stmt = $connection->prepare($sql);
    $stmt->bind_param("s", $center_name); // "s" indicates the parameter type is string

    // Execute the statement
    if ($stmt->execute()) {
        // Successfully deleted
    } else {
        // Handle the error
        die("Error deleting record: " . $stmt->error);
    }

    // Close the statement and connection
    $stmt->close();
    $connection->close();
}

// Redirect to Admin page
header("Location: /GreenHub/Admin.php");
exit;
?>
