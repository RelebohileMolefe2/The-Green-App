<?php
session_start();
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'vendor/autoload.php';

// Enable error reporting
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Initializing variables
$username = "";
$email = "";
$role = "user"; // Default role
$errors = array(); 

// Connect to the database
$db = mysqli_connect('localhost', 'root', '', 'greenhub-app');

// Function to validate email format and domain
function isValidEmail($email) {
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        return false;
    }
    $domain = substr(strrchr($email, "@"), 1);
    return checkdnsrr($domain, "MX");
}

// Function to send confirmation email
function sendConfirmationEmail($email, $token) {
  error_log("Sending confirmation email to: $email");
  
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
      $mail->Subject = 'Verify Your Email Address';
      $mail->Body = "Your verification code is: <strong>$token</strong>. Please enter this code on the verification page.";
      $mail->AltBody = "Your verification code is: $token. Please enter this code on the verification page.";

      $mail->send();
      error_log("Email sent successfully to: $email");
  } catch (Exception $e) {
      error_log("Mailer Error: {$mail->ErrorInfo}");
  }
}


// REGISTER USER
if (isset($_POST['reg_user'])) {
    // Receive all input values from the form
    $username = mysqli_real_escape_string($db, $_POST['username']);
    $email = mysqli_real_escape_string($db, $_POST['email']);
    $password_1 = mysqli_real_escape_string($db, $_POST['password_1']);
    $password_2 = mysqli_real_escape_string($db, $_POST['password_2']);
    $role = mysqli_real_escape_string($db, $_POST['role']);

    // Form validation
    if (empty($username)) { array_push($errors, "Username is required"); }
    if (empty($email)) { array_push($errors, "Email is required"); }
    if (!isValidEmail($email)) { array_push($errors, "Invalid email format or domain"); }
    if (empty($password_1)) { array_push($errors, "Password is required"); }
    if ($password_1 != $password_2) { array_push($errors, "The two passwords do not match"); }

    // Check if the username or email already exists
    $user_check_query = "SELECT * FROM users WHERE username='$username' OR email='$email' LIMIT 1";
    $result = mysqli_query($db, $user_check_query);
    $user = mysqli_fetch_assoc($result);

    if ($user) {
        if ($user['username'] === $username) { array_push($errors, "Username already exists"); }
        if ($user['email'] === $email) { array_push($errors, "Email already exists"); }
    }

    // Register user if there are no errors
    if (count($errors) == 0) {
        $password = password_hash($password_1, PASSWORD_BCRYPT); // Encrypt the password securely
        $token = bin2hex(random_bytes(6)); // Generate a random token

        // Insert the user into the database with the selected role and token
        $query = "INSERT INTO users (username, email, password, role, token, is_verified) 
                  VALUES('$username', '$email', '$password', '$role', '$token', 0)";
        mysqli_query($db, $query);

        // Check for database errors
        if (mysqli_error($db)) {
            array_push($errors, "Database error: " . mysqli_error($db));
        }

        // Send confirmation email
        sendConfirmationEmail($email, $token);

        // Check if email was sent successfully
        if (empty($errors)) {
            // Store email in session for verification
            $_SESSION['email'] = $email; 
            header('location: verification.php'); // Redirect to verification page
            exit();
        } else {
            array_push($errors, "Error sending email: " . implode(", ", $errors));
        }
    }
}
?>
<!DOCTYPE html>
<html>
<head>
  <title>Registration system PHP and MySQL</title>
  <style>
    /* Reset some default browser settings */
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
        position: fixed;
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
        background-color: rgba(144, 238, 144, 0.9);
        border-radius: 10px;
        box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.5);
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
    select {
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
  
  <form method="post" action="register.php">
  <h2 style="text-align: center; color: black;">Register</h2>
  	<?php include('errors.php'); ?>
  	<div class="input-group">
  	  <label>Username:</label>
  	  <input type="text" name="username"placeholder="Enter your username" value="<?php echo $username; ?>">
  	</div>
  	<div class="input-group">
  	  <label>Email:</label>
  	  <input type="email" name="email" placeholder="Enter your email" value="<?php echo $email; ?>">
  	</div>
  	<div class="input-group">
  	  <label>Password:</label>
  	  <input type="password" name="password_1" placeholder="Enter your password">
  	</div>
  	<div class="input-group">
  	  <label>Confirm password:</label>
  	  <input type="password" name="password_2" placeholder="Confirm your password">
  	</div>
    
    <!-- Role Selection (Admin or User) -->
    <div class="input-group">
      <label>Select Role</label>
      <select name="role">
        <option value="user">User</option>
        <option value="admin">Admin</option>
      </select>
    </div>
    
  	<div class="input-group">
  	  <button type="submit" class="btn" name="reg_user">Register</button>
  	</div>
    <p>
      GreenHubber! <a href="login.php">Log in</a> to continue growing a greener tomorrow.
    </p>
  </form>
</body>
</html>
