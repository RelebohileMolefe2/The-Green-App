<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Location Pin</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" />
    <style>
        body {
            font-family: 'Lato', sans-serif; 
        }
        h2 {
            text-align: center; 
            color: green; 
        }
        /* Header */
.header {
width: 100%;
padding: 5px;
background-color: #28a745;
box-shadow: 0 2px 8px rgba(0, 0, 0, 0.3);
position: sticky;
top: 0;
z-index: 20; /* Add this line to ensure header is on top */
}
.logo-container {
padding: 5px;
}

.logo-container img {
width: 80px;
height: auto;
display: block;
}


.nav-section {
display: flex;
justify-content: space-between;
align-items: center;
color: #fff;
}

.brand-name {
font-size: 1.8em;
letter-spacing: 2px;
font-weight: bold;
color: #a7ffeb;
}

.nav-section ul {
list-style: none;
display: flex;
gap: 20px;
}

.nav-section ul li a {
text-decoration: none;
color: #a7ffeb;
font-weight: bold;
padding: 5px 8px;
border-radius: 20px;
transition: background-color 0.3s ease;
font-size: 20px;
}

.nav-section ul li a:hover {
background-color: #004d40;
color: #fff;
box-shadow: 0 4px 10px rgba(0, 0, 0, 0.4);
}

        
        .footer {
    background-color: #4CAF50;
    color: #fff;
    padding: 10px 0;
    font-size: 0.9rem;
}

.footer-container {
    display: flex;
    justify-content: space-around;
    flex-wrap: wrap;
    max-width: 1200px;
    margin: 0 auto;
}

.footer-section {
    flex-basis: 30%;
    margin-bottom: 10px;
}

.footer-section h3 {
    margin-bottom: 10px;
    font-size: 1.2rem;
    text-align: center;
}

.subscribe-form {
    display: flex;
    align-items: center;
}

.subscribe-form input[type="email"] {
    padding: 8px;
    width: 70%;
    border: none;
    border-radius: 5px 0 0 5px;
}

.subscribe-form button {
    padding: 8px;
    background-color: #00ffe5;
    border: none;
    color: #004d40;
    border-radius: 0 5px 5px 0;
    cursor: pointer;
}

.social-icons a {
    color: white;
    font-size: 20px;
    margin-right: 10px;
}

.social-icons ul {
    list-style-type: none;
    padding: 0;
    margin: 0;
    display: flex;
    justify-content: center;
}

.social-icons ul li {
    margin: 0 8px;
}

.social-icons ul li a {
    color: white;
    font-size: 20px;
    text-decoration: none;
}

.social-icons ul li a:hover {
    color: #80cbc4;
}

.footer-bottom {
    text-align: center;
    padding-top: 10px;
    border-top: 1px solid rgba(255, 255, 255, 0.1);
    font-size: 0.8rem;
}



    </style>
</head>
<body>
<header class="header">
            <nav class="nav-section">
                <div class="brand-and-navBtn">
                    <div class="logo-container">
                        <img src="logo.jpeg" alt="Logo">
                    </div>
                </div>
                <div class="top-nav" id="topNav">
                    <ul>
                    <li><a href="admin_dashboard.php" class="active">Admin</a></li>
                    <li><a href="profile.php">Profile</a></li>
                    <li><a href="index.php">Logout</a></li>
                    </ul>
                </div>
            </nav>
        </header>

    <div class="container my-5">
        <h2>Add Co-ordinates</h2>
        <form action="addPin.php" method="POST">
            <div class="mb-3">
                <label for="center_id" class="form-label">Recycling Center ID</label>
                <input type="number" class="form-control" id="center_id" name="center_id" required>
            </div>
            <div class="mb-3">
                <label for="latitude" class="form-label">Latitude</label>
                <input type="text" class="form-control" id="latitude" name="latitude" required>
            </div>
            <div class="mb-3">
                <label for="longitude" class="form-label">Longitude</label>
                <input type="text" class="form-control" id="longitude" name="longitude" required>
            </div>
            <div class="mb-3">
                <label for="description" class="form-label">Description</label>
                <textarea class="form-control" id="description" name="description" rows="3" required></textarea>
            </div>
            <button type="submit" class="btn btn-success">Add</button>
        </form>

        <?php
// Check if form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "greenhub-app";

    // Create connection
    $connection = new mysqli($servername, $username, $password, $dbname);
    if ($connection->connect_error) {
        die("Connection failed: " . $connection->connect_error);
    }

    // Collect form data
    $center_id = $_POST['center_id'];
    $latitude = $_POST['latitude'];
    $longitude = $_POST['longitude'];
    $description = $_POST['description'];

    // Check if the center_id exists in recycling_centers
    $check_sql = "SELECT * FROM recycling_centers WHERE center_id = ?";
    $check_stmt = $connection->prepare($check_sql);
    $check_stmt->bind_param("i", $center_id);
    $check_stmt->execute();
    $result = $check_stmt->get_result();

    if ($result->num_rows > 0) {
        // Proceed with the insert into location_pins
        $sql = "INSERT INTO location_pins (center_id, latitude, longitude, description) VALUES (?, ?, ?, ?)";
        $stmt = $connection->prepare($sql);
        $stmt->bind_param("isss", $center_id, $latitude, $longitude, $description);

        // Execute the statement and check for success
        if ($stmt->execute()) {
            echo "<div class='alert alert-success mt-3'>Pin added successfully!</div>";
        } else {
            echo "<div class='alert alert-danger mt-3'>Error adding pin: " . $stmt->error . "</div>";
        }

        // Close statement
        $stmt->close();
    } else {
        echo "<div class='alert alert-danger mt-3'>Error: The provided Center ID does not exist.</div>";
    }

    // Close the check statement and connection
    $check_stmt->close();
    $connection->close();
}
?>



<footer class="footer">
    <div class="footer-container">
        <div class="footer-section">
            <h3>Stay Connected</h3>
            <form class="subscribe-form">
                <input type="email" placeholder="Enter your email" required>
                <button type="submit">Subscribe</button>
            </form>
        </div>
        <div class="footer-section">
            <h3>Contact Us</h3>
            <p>Email: thegreenhubapp@gmail.com</p>
            <p>Phone: (123) 456-7890</p>
        </div>
        <div class="footer-section social-icons">
            <h3>Follow Us</h3>
            <ul>
                <li><a href="https://www.facebook.com/RecycleProUK" target="_blank"><i class="fab fa-facebook-f"></i></a></li>
                <li><a href="https://x.com/greeneryorg?s=21" target="_blank"><i class="fab fa-twitter"></i></a></li>
                <li><a href="https://www.instagram.com/recycle.green/" target="_blank"><i class="fab fa-instagram"></i></a></li>
            </ul>
        </div>
    </div>
    <div class="footer-bottom">
        <p>&copy; THE GREEN APP. All rights reserved.</p>
    </div>
</footer>



    </div>
</body>
</html>
