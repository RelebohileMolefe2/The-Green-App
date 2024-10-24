<?php include('server.php') ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Recycling Tips - GreenHub</title>
    <link href="https://fonts.googleapis.com/css2?family=Quicksand:wght@400;600&display=swap" rel="stylesheet">
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

    /* Centering the form on the page */
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


    /* Form Header */
    .h2 {
        color: black;
        text-align: center;
        margin-bottom: 20px;
    }

    /* Input fields */
    .input-group {
        margin: 10px 0;
    }

    .input-group label {
        display: block;
        margin-bottom: 5px;
        font-size: 16px;
        font-weight: bold;
        color:black;
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

    /* Footer link */
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

    <div class="video-container">
        <video autoplay muted loop id="bg-video">
            <source src="backgroundvid.mp4" type="video/mp4">
            Your browser does not support HTML5 video.
        </video>
    </div>

    <div class="logo">
        <img src="icon.jpg" alt="Logo">
    </div>

    <form method="post" action="login.php">
    <h2 align="center" style="color: black; font-size: 38px;">Login</h2>
        <?php include('errors.php'); ?>
        <div class="input-group">
            <label>Username:</label>
            <input type="text" name="username" placeholder="Enter your username">
        </div>
        <div class="input-group">
            <label>Password:</label>
            <input type="password" name="password" placeholder="Enter your password">
        </div>
        <p>
            <a href="forgot_password.php" style="color: #28a745;">Forgot Password?</a>
        </p>
        <div class="input-group">
            <button type="submit" class="btn" name="login_user">Login</button>
        </div>
        <p style="color: white;">
            Not a GreenHubber yet? Join the movement! Create an account to start exploring a greener tomorrow. <a href="register.php">Sign up</a>
        </p>
    </form>  
</body>
</html>
