<?php
include('server.php'); // Include your database connection

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $token = $_POST['token'];
    $newPassword = $_POST['new_password'];
    $confirmPassword = $_POST['confirm_password'];

    // Validate token and fetch user
    $query = "SELECT * FROM users WHERE token = ?";
    $stmt = $db->prepare($query);
    $stmt->bind_param("s", $token);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $user = $result->fetch_assoc();

        // Check if new passwords match
        if ($newPassword === $confirmPassword) {
            // Hash the new password
            $hashedPassword = password_hash($newPassword, PASSWORD_BCRYPT);

            // Update password, clear token, and set password_changed
            $updateQuery = "UPDATE users SET password = ?, token = NULL, password_changed = 1 WHERE email = ?";
            $updateStmt = $db->prepare($updateQuery);
            $updateStmt->bind_param("ss", $hashedPassword, $user['email']);

            // Debugging statements
            echo "Updating password for email: " . $user['email'] . "<br>";
            echo "Hashed password: " . $hashedPassword . "<br>";

            if ($updateStmt->execute()) {
                // Redirect to login page after successful password reset
                header("Location: http://localhost/GreenHub/login.php");
                exit();
            } else {
                echo "Error updating password: " . $updateStmt->error; // More specific error
            }
        } else {
            echo "Passwords do not match.";
        }
    } else {
        echo "Invalid token.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reset Password</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body, html {
            height: 100%;
            font-family: Arial, sans-serif;
            color: #fff;
        }

        .video-container {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            overflow: hidden;
            z-index: -1;
        }

        #bg-video {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .logo {
            position: absolute;
            top: 10px;
            left: 10px;
            width: 80px;
        }

        .logo img {
            width: 100%;
            height: auto;
        }

        form {
            position: relative;
            z-index: 1;
            width: 400px;
            margin: 100px auto;
            padding: 20px;
            background-color: rgba(144, 238, 144, 0.9); /* Less transparent */
            border-radius: 10px;
            box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.5);
        }

        .h2 {
            color: black;
            text-align: center;
            margin-bottom: 20px;
        }

        .input-group {
            margin: 10px 0;
        }

        .input-group label {
            display: block;
            margin-bottom: 5px;
            font-size: 16px;
            font-weight: bold;
            color: black;
        }

        .input-group input {
            width: 100%;
            padding: 10px;
            font-size: 16px;
            border-radius: 5px;
            border: 1px solid #ccc;
            outline: none;
            background-color: rgba(255, 255, 255, 0.2);
            color: black;
        }

        .btn {
            width: 100%;
            padding: 10px;
            background-color: #28a745;
            border: none;
            border-radius: 5px;
            font-size: 16px;
            color: #fff;
            cursor: pointer;
        }

        .btn:hover {
            background-color: #218838;
        }

        p {
            text-align: center;
            margin-top: 20px;
        }

        p a {
            color: #28a745;
            text-decoration: none;
            font-weight: bold;
        }

        p a:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>
<div class="container">
    <div class="video-container">
        <video autoplay muted loop id="bg-video">
            <source src="backgroundvid.mp4" type="video/mp4">
            Your browser does not support HTML5 video.
        </video>
    </div>
    <div class="logo">
        <img src="icon.jpg" alt="Logo">
    </div>
    <form method="POST" action="">
        <h2 align="center" style="color: black; font-size: 30px;">Reset Password</h2>
        <div class="input-group">
            <label for="token">Enter your reset token:</label>
            <input type="text" id="token" name="token" required placeholder="Enter token">
        </div>
        <div class="input-group">
            <label for="new_password">New Password:</label>
            <input type="password" id="new_password" name="new_password" required placeholder="Enter your new password">
        </div>
        <div class="input-group">
            <label for="confirm_password">Confirm New Password:</label>
            <input type="password" id="confirm_password" name="confirm_password" required placeholder="Confirm your new password">
        </div>
        <div class="input-group">
            <button type="submit" class="btn">Submit</button>
        </div>
    </form>
</div>
</body>
</html>
