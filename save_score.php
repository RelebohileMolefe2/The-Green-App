<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

$servername = "localhost"; 
$username = "root"; 
$password = ""; // Your MySQL password
$dbname = "greenhub-app"; 

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Save score
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['action']) && $_POST['action'] == 'save_score') {
    session_start();
    
    if (!isset($_SESSION['username'])) { // Fixed typo here
        die("User not logged in");
    }

    $userId = $_SESSION['user_id']; // Get user ID from session
    $score = $_POST['score']; // Get score from request

    // Debug: Check score value
    var_dump($score);

    // Validate score
    if (!is_numeric($score)) {
        die("Invalid score");
    }

    // Prepare SQL to insert score
    $stmt = $conn->prepare("INSERT INTO scores (user_id, score) VALUES (?, ?)");
    if ($stmt === false) {
        die("Prepare failed: " . $conn->error);
    }

    $stmt->bind_param("ii", $userId, $score);

    if ($stmt->execute()) {
        echo "Score saved successfully";
    } else {
        die("Error saving score: " . $stmt->error);
    }

    $stmt->close();
}

$conn->close();
?>
