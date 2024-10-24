<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "greenhub-app";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Fetch recycling centers
$sql = "SELECT name, latitude, longitude, type FROM recycling_centers";
$result = $conn->query($sql);

$centers = [];

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $centers[] = [
            'name' => $row['name'],
            'latitude' => $row['latitude'],
            'longitude' => $row['longitude'],
            'type' => $row['type']
        ];
    }
}

// Return the data as JSON
header('Content-Type: application/json');
echo json_encode($centers);

$conn->close();
?>
