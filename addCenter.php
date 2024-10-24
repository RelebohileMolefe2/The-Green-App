<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "greenhub-app";

//connecting the database
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

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $center_name = $_POST['center_name'];
    $location = $_POST['location'];
    $operating_hours = $_POST['operating_hours'];
    $accepted_materials = $_POST['accepted_materials'];
    $contact_info = $_POST['contact_info'];
    $status = $_POST['status'];
    $date_added = $_POST['date_added'];

    // Form validation
    do {
        if (empty($center_name) || empty($location) || empty($operating_hours) || empty($accepted_materials)
            || empty($contact_info) || empty($status) || empty($date_added)) {
            $errorMessage = "All the fields are required";
            break;
        }

        // Check for duplicate center_name before inserting
        $check_sql = "SELECT * FROM recycling_centers WHERE center_name = '$center_name'";
        $check_result = $connection->query($check_sql);

        if ($check_result->num_rows > 0) {
            // If a duplicate center_name is found, set an error message
            $errorMessage = "Center name already exists. Please choose a different name.";
            break;
        }

        // If no duplicate is found, proceed with inserting into the database
        $sql = "INSERT INTO recycling_centers (center_name, location, operating_hours, accepted_materials, contact_info, status, date_added)
                VALUES ('$center_name', '$location', '$operating_hours', '$accepted_materials', '$contact_info', '$status', '$date_added')";

        $result = $connection->query($sql);

        if (!$result) {
            $errorMessage = "Invalid query: " . $connection->error;
            break;
        }

        // Reset fields after success (Optional: you may remove this part if redirection is preferred immediately)
        $center_id = "";
        $center_name = "";
        $location = "";
        $operating_hours = "";
        $accepted_materials = "";
        $contact_info = "";
        $status = "";
        $date_added = "";

        // Redirect to Admin.php after successful insertion
        header("Location: /GreenHub/Admin.php");
        exit;

    } while (false);

} elseif (isset($_POST['add_pin'])) {
    // Handle form submission for adding a pin
    $latitude = $_POST['latitude'];
    $longitude = $_POST['longitude'];

    // Insert the latitude and longitude into the database
    $insert_pin_sql = "INSERT INTO pins (latitude, longitude) VALUES ('$latitude', '$longitude')";
    $connection->query($insert_pin_sql);
    $successMessage = "Pin added successfully!";
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
    .header {
    width: 100%;
    padding: 10px;
    background-color: #28a745;
    box-shadow: 0 2px 8px rgba(0, 0, 0, 0.3);
    position: sticky;
    top: 0;
    z-index: 10000; /* Increase z-index to ensure it stays on top */
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
        padding: 8px 16px;
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
        <h2>New Center</h2>

        <!-- Error Message -->
        <?php
        if (!empty($errorMessage)) {
            echo "
            <div class='alert alert-warning alert-dismissible fade show' role='alert'>
                <strong>$errorMessage</strong>
                <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>
            </div>";
        }
        ?>

        <form method="post">
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
                     <button type="button" class="btn btn-outline-primary" id="cancelBtn">Cancel</button>
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
<script>
    // Function to clear the form fields
    function clearForm() {
        document.querySelector('form').reset();     }

    // Event listener for the Cancel button
    document.getElementById('cancelBtn').addEventListener('click', function() {
        clearForm();  
        window.location.href = "/GreenHub/Admin.php"; 
    });
</script>
</body>
</html>
