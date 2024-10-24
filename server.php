<?php
session_start();

// Initializing variables
$username = "";
$email = "";
$role = "user"; // Default role
$errors = array(); 

// Connect to the database
$db = mysqli_connect('localhost', 'root', '', 'greenhub-app');

// Include PHPMailer classes
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'vendor/autoload.php'; // Make sure to include Composer's autoload

// Function to validate email format and domain
function isValidEmail($email) {
    // Check email format
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        return false;
    }

    // Check if the domain has valid MX records
    $domain = substr(strrchr($email, "@"), 1);
    return checkdnsrr($domain, "MX");
}

// Function to send confirmation email
function sendConfirmationEmail($email, $token) {
    $mail = new PHPMailer(true);

    try {
        // Server settings
        $mail->isSMTP();                                      // Set mailer to use SMTP
        $mail->Host = 'smtp.gmail.com';                     // Specify main and backup SMTP servers
        $mail->SMTPAuth = true;                               // Enable SMTP authentication
        $mail->Username = 'thegreenhubapp@gmail.com';          // SMTP username
        $mail->Password = 'tmglvzsmwptkjolf';                    // SMTP password
        $mail->SMTPSecure = 'SSL';                            // Enable TLS encryption, `ssl` also accepted
        $mail->Port = 465;                                   // TCP port to connect to

        // Recipients
        $mail->setFrom('no-reply@thegreenhubapp.com', 'GreenHub');
        $mail->addAddress($email);                           // Add a recipient

        // Content
        $mail->isHTML(true);
      $mail->Subject = 'Verify Your Email Address';
      $mail->Body = "Your verification code is: <strong>$token</strong>. Please enter this code on the verification page.";
      $mail->AltBody = "Your verification code is: $token. Please enter this code on the verification page.";

        $mail->send();
    } catch (Exception $e) {
        echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
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

        // Send confirmation email
        sendConfirmationEmail($email, $token);

        // Store session info
        $_SESSION['username'] = $username;
        $_SESSION['role'] = $role;
        $_SESSION['success'] = "Registration successful! Please check your email to verify your account.";
        
        header('location: index.php');
        exit();
    }
}  

// LOGIN USER
if (isset($_POST['login_user'])) {
    $username = mysqli_real_escape_string($db, $_POST['username']);
    $password = mysqli_real_escape_string($db, $_POST['password']);

    if (empty($username)) { array_push($errors, "Username is required"); }
    if (empty($password)) { array_push($errors, "Password is required"); }

    if (count($errors) == 0) {
        // Fetch the user with the specified username
        $query = "SELECT * FROM users WHERE username='$username' AND is_verified=1";
        $results = mysqli_query($db, $query);
        
        if (mysqli_num_rows($results) == 1) {
            $logged_in_user = mysqli_fetch_assoc($results);

            // Verify the password
            if (password_verify($password, $logged_in_user['password'])) {
                $_SESSION['username'] = $username;
                $_SESSION['role'] = $logged_in_user['role'];
                $_SESSION['success'] = "You are now logged in";

                if ($logged_in_user['role'] == 'admin') {
                    header('location: admin_dashboard.php'); // Redirect to admin dashboard
                } else {
                    header('location: home.php'); // Redirect to user dashboard
                }
                exit();
            } else {
                array_push($errors, "Your username/password combination is incorrect.");
            }
        } else {
            array_push($errors, "Your email is not verified or the username/password combination is incorrect.");
        }
    }
}

// VERIFY EMAIL
if (isset($_GET['token'])) {
    $token = mysqli_real_escape_string($db, $_GET['token']);

    // Check if the token exists
    $query = "SELECT * FROM users WHERE token='$token' LIMIT 1";
    $result = mysqli_query($db, $query);
    $user = mysqli_fetch_assoc($result);

    if ($user) {
        // Update the user to set is_verified to 1
        $updateQuery = "UPDATE users SET is_verified=1, token=NULL WHERE token='$token'";
        mysqli_query($db, $updateQuery);

        $_SESSION['success'] = "Your email has been verified! You can now log in.";
        header('location: login.php');
        exit();
    } else {
        $_SESSION['error'] = "Invalid token. Please check your email for the correct link.";
        header('location: login.php');
        exit();
    }
}

?>
