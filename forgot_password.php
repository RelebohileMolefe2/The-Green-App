<?php
include('server.php'); // Include your database connection
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'vendor/autoload.php'; // Ensure PHPMailer is autoloaded

$message = ''; // Variable to hold success or error messages

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = $_POST['email'];

    // Check if the email exists and is verified
    $query = "SELECT * FROM users WHERE email = ? AND is_verified = 1";
    $stmt = $db->prepare($query);
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $user = $result->fetch_assoc();
        $token = bin2hex(random_bytes(6)); // Generate a secure token

        // Update user with the reset token
        $updateQuery = "UPDATE users SET token = ? WHERE email = ?";
        $updateStmt = $db->prepare($updateQuery);
        $updateStmt->bind_param("ss", $token, $user['email']);
        $updateStmt->execute();

        // Send the password reset email
        sendResetEmail($email, $token);
        
        // Set a message to inform the user that the email has been sent
        $message = "A password reset link has been sent to your email.";
    } else {
        $message = "Email not found or not verified.";
    }
}

function sendResetEmail($email, $token) {
    $mail = new PHPMailer(true);
    try {
        // Server settings
        $mail->isSMTP();
        $mail->Host = 'smtp.gmail.com';
        $mail->SMTPAuth = true;
        $mail->Username = 'thegreenhubapp@gmail.com'; // Update with your email
        $mail->Password = 'tmglvzsmwptkjolf'; // Update with your email password
        $mail->SMTPSecure = 'ssl';
        $mail->Port = 465;

        // Recipients
        $mail->setFrom('no-reply@thegreenhubapp.com', 'The Green App');
        $mail->addAddress($email);

        // Content
        $mail->isHTML(true);
        $mail->Subject = 'Password Reset Request';
        $mail->Body = "Your password reset token is: <strong>$token</strong>";
        $mail->AltBody = "Your password reset token is: $token";

        $mail->send();
    } catch (Exception $e) {
        error_log("Mailer Error: {$mail->ErrorInfo}");
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Forgot Password</title>
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
            background-color: rgba(144, 238, 144, 0.9);
            border-radius: 10px;
            box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.5);
        }

        .h2 {
            color: black;
            text-align: center;
            margin-bottom: 20px;
        }

        .p {
            text-align: center;
            font-size: 16px;
            font-weight: bold;
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

        .message {
            text-align: center;
            color: black;
            margin: 20px 0;
        }
    </style>
</head>
<body>
    <div class="video-container">
        <video autoplay muted loop id="bg-video">
            <source src="backgroundvid.mp4" type="video/mp4">
            Your browser does not support HTML5 video.
        </video>
    </div>
    <div class="logo">
        <img src="icon.jpg" alt="Logo">
    </div>
    <form method="POST">
        <h2 align="center" style="color: black; font-size: 30px;">Forgot Password</h2>
        <p>Provide your email address you are using for The Green App. To reconnect</p>
        
        <?php if ($message): ?>
            <div class="message"><?= htmlspecialchars($message) ?></div>
        <?php endif; ?>
        
        <div class="input-group">
            <label for="email">Email:</label>
            <input type="email" name="email" required placeholder="Enter your email">
        </div>
        <button type="submit" class="btn">Send Reset Link</button>
        <p>After sending email</p>
        <p>
            <a href="reset_password.php" style="color: #28a745;">Reset Password Here</a>
        </p>
    </form>
</body>
</html>
