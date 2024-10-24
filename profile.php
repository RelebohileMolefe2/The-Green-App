        <?php
            include('server.php');

            // Check if user is logged in
            if (!isset($_SESSION['username'])) {
                header("location: login.php");
                exit();
            }

            // Retrieve logged-in user data
            $username = $_SESSION['username'];
            $query = "SELECT * FROM users WHERE username='$username'";
            $result = mysqli_query($db, $query);
            $user = mysqli_fetch_assoc($result);

            $email = $user['email'];

            // Handle profile update form submission
            if (isset($_POST['update_profile'])) {
                $new_username = mysqli_real_escape_string($db, $_POST['username']);
                $new_email = mysqli_real_escape_string($db, $_POST['email']);

                // Update the user data in the database
                $update_query = "UPDATE users SET username='$new_username', email='$new_email' WHERE username='$username'";
                mysqli_query($db, $update_query);

                // Update session username
                $_SESSION['username'] = $new_username;

                // Refresh page to reflect the updated data
                header("location: profile.php");
            }

            // Handle password change form submission
            if (isset($_POST['change_password'])) {
                $current_password = mysqli_real_escape_string($db, $_POST['current_password']);
                $new_password = mysqli_real_escape_string($db, $_POST['new_password']);
                $confirm_password = mysqli_real_escape_string($db, $_POST['confirm_password']);

                // Check if current password matches
                if (password_verify($current_password, $user['password'])) {
                    // Check if new password matches confirm password
                    if ($new_password === $confirm_password) {
                        // Hash new password
                        $new_password_hashed = password_hash($new_password, PASSWORD_DEFAULT);
                        // Update password in the database
                        $password_update_query = "UPDATE users SET password='$new_password_hashed' WHERE username='$username'";
                        mysqli_query($db, $password_update_query);
                        echo "Password changed successfully!";
                    } else {
                        echo "New password and confirm password do not match.";
                    }
                } else {
                    echo "Current password is incorrect.";
                }
            }
        ?>

        <!DOCTYPE html>
        <html lang="en">
        <head>
            <meta charset="UTF-8">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" />
            <title>Edit Profile</title>
            <style>
        body {
            font-family: 'Helvetica Neue', Arial, sans-serif;
            background: url('green2.jpg') no-repeat center center fixed;
            background-size: cover;
            color: #333;
        }
        .header {
            width: 100%;
            padding: 10px;
            background-color: #28a745;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.3);
            position: sticky;
        top: 0;
        }
        .logo-container {
            padding: 5px;
        }

        .logo-container img {
            width: 60px;
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

        .container {
            margin-top: 50px;
            display: flex;
            justify-content: center;
        }

        .profile-details,
        .edit-form,
        .password-form {
            background-color: rgba(255, 255, 255, 0.8); /* Semi-transparent white background */
            border-radius: 8px;
            padding: 20px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.15);
            width: 100%;
            max-width: 600px; /* Max width for better alignment */
        }

        h1 {
            color: #28a745;
            text-align: center;
            font-size: 2.5rem;
            margin-bottom: 20px;
        }

        .form-group {
            margin-bottom: 10px;
        }

        .form-control {
            width: 100%;
            padding: 10px;
            border: 1px solid #ced4da;
            border-radius: 4px;
            transition: border-color 0.3s;
        }

        .form-control:focus {
            border-color: #28a745; /* Highlight on focus */
            outline: none; /* Remove default outline */
        }

        .btn {
            padding: 10px 20px;
            border-radius: 4px;
            cursor: pointer;
            display: inline-block;
            border: none;
            transition: background-color 0.3s;
        }

        .btn-success {
            background-color: #28a745;
            color: white;
        }

        .btn-success:hover {
            background-color: #218838;
        }

        .profile-details p {
            font-size: 18px;
            color: #333;
            margin: 10px 0;
        }

        .edit-form, .password-form {
            display: none;
            margin-top: 20px;
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
                    max-width: 1500px;
                    margin: 0 auto;
                }

                .footer-section {
                    flex-basis: 30%;
                    margin-bottom: 10px;
                }

                .footer-section h3 {
                    margin-bottom: 10px;
                    font-size: 1.2rem;
                    text-align:center;
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
                    margin-right: 25px;
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
                        <li><a href="home.php">Home</a></li>
                        <li><a href="location.php">Location</a></li>
                        <li><a href="dashboard.php">Game DashBoard</a></li>
                        <li><a href="profile.php" class="active">Profile</a></li>
                        <li><a href="index.php">Logout</a></li>
                        </ul>
                    </div>
                </nav>
            </header>

            <div class="container">
                <div class="row">
                    <div class="col-sm-3"></div>
                    <div class="col-sm-6">
                        <!-- Profile Details -->
                        <h1 style="color: #004d40; text-align: center;">GreenHubber Details</h1>
                        <div class="profile-details">
                            <p><strong>Username:</strong> <?php echo $username; ?></p>
                            <p><strong>Email:</strong> <?php echo $email; ?></p>
                        </div>

                        <!-- Edit Profile and Change Password Buttons -->
                        <button id="editProfileBtn" class="btn btn-success" onclick="showEditForm()">Edit Profile</button>
                        <button id="changePasswordBtn" class="btn btn-success" onclick="showPasswordForm()">Change Password</button>

                        <!-- Edit Profile Form -->
                        <form id="editForm" class="edit-form" method="post">
                            <div class="form-group">
                                <label for="username">Username</label>
                                <input type="text" name="username" class="form-control" value="<?php echo $username; ?>" required>
                            </div>
                            <div class="form-group">
                                <label for="email">Email</label>
                                <input type="email" name="email" class="form-control" value="<?php echo $email; ?>" required>
                            </div>
                            <button type="submit" name="update_profile" class="btn btn-success">Save Changes</button>
                        </form>

                        <!-- Change Password Form -->
                        <form id="passwordForm" class="password-form" method="post">
                            <div class="form-group">
                                <label for="current_password">Current Password</label>
                                <input type="password" name="current_password" class="form-control" required>
                            </div>
                            <div class="form-group">
                                <label for="new_password">New Password</label>
                                <input type="password" name="new_password" class="form-control" required>
                            </div>
                            <div class="form-group">
                                <label for="confirm_password">Confirm New Password</label>
                                <input type="password" name="confirm_password" class="form-control" required>
                            </div>
                            <button type="submit" name="change_password" class="btn btn-success">Change Password</button>
                        </form>
                    </div>
                    <div class="col-sm-3"></div>
                </div>
            </div>
            
            <div class="changed-container">
                <p></p>
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
                        <li><a href=" https://www.facebook.com/RecycleProUK" target="_blank"><i class="fab fa-facebook-f"></i></a></li>
                        <li><a href=" https://x.com/greeneryorg?s=21" target="_blank"><i class="fab fa-twitter"></i></a></li>
                        <li><a href=" https://www.instagram.com/recycle.green/" target="_blank"><i class="fab fa-instagram"></i></a></li>
                    </ul>
                    </div>
                </div>
            <div class="footer-bottom">
                <p>&copy; MR AJ YAWA. All rights reserved.</p>
            </div>
        </footer>

            <script>
                // Function to show the edit profile form
                function showEditForm() {
                    var editForm = document.getElementById('editForm');
                    editForm.style.display = 'block';
                }

                // Function to show the change password form
                function showPasswordForm() {
                    var passwordForm = document.getElementById('passwordForm');
                    passwordForm.style.display = 'block';
                }
            </script>
        </body>
        </html>
