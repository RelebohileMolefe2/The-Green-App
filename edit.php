<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "greenhub-app";

// Connecting the database
$connection = new mysqli($servername, $username, $password, $dbname);


$center_name = "";
$location = "";
$operating_hours = "";
$accepted_materials = "";
$contact_info = "";
$status = "";
$date_added = "";

$errorMessage = "";
$successMessage = "";

if ($_SERVER['REQUEST_METHOD'] == 'GET') {

    if (!isset($_GET['center_name'])) {
        header("Location: /Admin.php");
        exit;
    }

    $center_name = $_GET["center_name"];

    $sql = "SELECT * FROM recycling_centers WHERE center_name= '$center_name'";
    $result = $connection->query($sql);
    $row = $result->fetch_assoc();

    if (!$row) {
        header("Location: /Admin.php");
        exit;
    }

    // Correctly assign the fetched values to the variables
    $center_name = $row['center_name'];
    $location = $row['location'];
    $operating_hours = $row['operating_hours'];
    $accepted_materials = $row['accepted_materials'];
    $contact_info = $row['contact_info'];
    $status = $row['status'];
    $date_added = $row['date_added'];
} else {
    // Fetch POST values
    $center_name = $_POST["center_name"];
    $location = $_POST["location"];
    $operating_hours = $_POST["operating_hours"];
    $accepted_materials = $_POST["accepted_materials"];
    $contact_info = $_POST["contact_info"];
    $status = $_POST["status"];
    $date_added = $_POST["date_added"];

    do {
        // Form validation
        if ( empty($center_name) || empty($location) || empty($operating_hours) || empty($accepted_materials)
            || empty($contact_info) || empty($status) || empty($date_added)) {
            $errorMessage = "All the fields are required";
            break;
        }

        // SQL query to update the center information
        $sql = "UPDATE recycling_centers
        SET center_name='$center_name', location='$location', operating_hours='$operating_hours', accepted_materials='$accepted_materials',
            contact_info='$contact_info', status='$status', date_added='$date_added'
        WHERE center_name='$center_name'";

        $result = $connection->query($sql);

        if (!$result) {
            $errorMessage = "Invalid query: " . $connection->error;
            break;
        }

        $successMessage = "Recycling center updated correctly";

        // Redirect to Admin page after success
        header("Location:/GreenHub/Admin.php");
        exit;

    } while (false);
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Center</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" />

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</head>

<style>
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
                <li><a href="home.php" class="active">Home</a></li>
                <li><a href="location.php">Locations</a></li>
                <li><a href="dashboard.php">Game DashBoard</a></li>
                <li><a href="profile.php">Profile</a></li>
                <li><a href="index.php">Logout</a></li>
            </ul>
        </div>
    </nav>
</header>


    <div class="container my-5">
        <h2>New Center</h2>

        <!-- Error Message -->
        <?php
        if (!empty($errorMessage)) {
            echo "
            <div class='alert alert-warning alert-dismissible fade show' role='alert'>
                <strong>$errorMessage</strong>
                <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>
            </div> 
            ";
        }
        ?>

        <form method="post">
            <input type ="hidden" name="center_name" value="<?php echo $center_name;?>">
            <!-- Center Name Field -->
            <div class="row mb-3">
                <label class="col-sm-3 col-form-label">Center Name</label>
                <div class="col-sm-6">
                    <input type="text" class="form-control" name="center_name" value="<?php echo $center_name; ?>">
                </div>
            </div>

            <!-- Address Field -->
            <div class="row mb-3">
                <label class="col-sm-3 col-form-label">Address</label>
                <div class="col-sm-6">
                    <input type="text" class="form-control" name="location" value="<?php echo $location; ?>">
                </div>
            </div>

            <!-- Operating Hours Field -->
            <div class="row mb-3">
                <label class="col-sm-3 col-form-label">Operating Hours</label>
                <div class="col-sm-6">
                    <input type="text" class="form-control" name="operating_hours" value="<?php echo $operating_hours; ?>">
                </div>
            </div>

            <!-- Material Field -->
            <div class="row mb-3">
                <label class="col-sm-3 col-form-label">Material</label>
                <div class="col-sm-6">
                    <input type="text" class="form-control" name="accepted_materials" value="<?php echo $accepted_materials; ?>">
                </div>
            </div>

            <!-- Contact Info Field -->
            <div class="row mb-3">
                <label class="col-sm-3 col-form-label">Contact</label>
                <div class="col-sm-6">
                    <input type="text" class="form-control" name="contact_info" value="<?php echo $contact_info; ?>">
                </div>
            </div>

            <!-- Status Field -->
            <div class="row mb-3">
                <label class="col-sm-3 col-form-label">Status</label>
                <div class="col-sm-6">
                    <input type="text" class="form-control" name="status" value="<?php echo $status; ?>">
                </div>
            </div>

            <!-- Date Field -->
            <div class="row mb-3">
                <label class="col-sm-3 col-form-label">Date</label>
                <div class="col-sm-6">
                    <input type="text" class="form-control" name="date_added" value="<?php echo $date_added; ?>">
                </div>
            </div>

            <!-- Success Message -->
            <?php
            if (!empty($successMessage)) {
                echo "
                <div class='row mb-3'>
                    <div class='offset-sm-3 col-sm-6'>
                        <div class='alert alert-success alert-dismissible fade show' role='alert'>
                            <strong>$successMessage</strong>
                            <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>
                        </div>
                    </div>
                </div>";
            }
            ?>

            <!-- Submit and Cancel Buttons -->
            <div class="row mb-3">
                <div class="offset-sm-3 col-sm-3 d-grid">
                    <button type="submit" class="btn btn-primary">Submit</button>
                </div>
                <div class="col-sm-3 d-grid">
                    <a class="btn btn-outline-primary" href="/Admin.php" role="button">Cancel</a>
                    </div>
            </div>
        </form>
    </div>


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
            <p>Email: info@thegreenapp.com</p>
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





</body>
</html>