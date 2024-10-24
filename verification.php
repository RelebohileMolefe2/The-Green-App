<?php
session_start();
$db = mysqli_connect('localhost', 'root', '', 'greenhub-app');

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $entered_token = mysqli_real_escape_string($db, $_POST['token']);
    $email = $_SESSION['email'];

    // Check if the token exists in the database for the given email
    $query = "SELECT * FROM users WHERE email='$email' AND token='$entered_token' LIMIT 1";
    $result = mysqli_query($db, $query);

    if (mysqli_num_rows($result) > 0) {
        // Update the user record to mark as verified
        $updateQuery = "UPDATE users SET is_verified=1, token=NULL WHERE email='$email'";
        mysqli_query($db, $updateQuery);

        // Redirect to the login page after successful verification
        header('Location: login.php');
        exit();
    } else {
        $error_message = "Invalid verification code. Please try again.";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Verify Your Email</title>
    <style>
        body {
    font-family: Arial, sans-serif;
    background-color: #f4f4f4;
    margin: 0;
    padding: 0;
}
 /* Styling the background video */
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

    /* Container for the logo */
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


.container {
    position: relative;
        z-index: 1;
        width: 400px;
        margin: 100px auto;
        padding: 20px;
        background-color: rgba(144, 238, 144);
        border-radius: 10px;
        box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.5);
}

h1 {
    color: black;
    text-align: center;
}

.input-group {
    margin-bottom: 15px;
}

label {
    display: block;
        margin-bottom: 5px;
        font-size: 18px;
        font-weight: bold;
        color: black;
}

input[type="text"] {
    width: 100%;
        padding: 8px;
        font-size: 16px;
        border-radius: 5px;
        border: 1px solid #ccc;
        outline: none;
        background-color: rgba(255, 255, 255, 0.2);
        color: black;
}

input[type="text"]:focus {
    border-color: #218838;
    outline: none;
}

/* Submit button */
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

.info {
    margin-top: 14px;
    font-size: 16px;
    color: white;
}

.error {
    margin-top: 10px;
    color: black;
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
    <div class="container">
        <h1>Almost There!</h1>
        <p>You're just one step away from becoming an official GreenHubber!</p>
        <p>Please enter the verification code sent to your email.</p>
        <form method="post" action="verification.php">
            <div class="input-group">
                <label for="token">Enter Verification Code:</label>
                <input type="text" name="token" required>
            </div>
            <button type="submit" class="btn">Verify</button>
        </form>
        <div class="info">
            <p>If you didn't receive the email, please check your spam folder or <a href="register.php">register again</a>.</p>
        </div>
        <?php if (isset($error_message)): ?>
            <div class="error"><?php echo $error_message; ?></div>
        <?php endif; ?>
    </div>
</body>
</html>
