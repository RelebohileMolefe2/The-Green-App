
<?php
session_start(); // Start the session

// Check if the user is logged in
if (!isset($_SESSION['username'])) {
header('Location: login.php'); // Redirect to login page
exit();
}

$username = $_SESSION['username']; // Assuming the username is stored in session
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" />
    <link href="https://fonts.googleapis.com/css2?family=Quicksand:wght@400;600&display=swap" rel="stylesheet">
    <title>About Us - GreenHub</title>
    <style>
        body {
            margin: 0;
            padding: 0;
            background-color: #f4f4f4;
            color: #333;
            font-family: 'Quicksand', sans-serif; /* Added font */
        }
        /* Header */
        .header {
            width: 100%;
            padding: 5px;
            background-color: #28a745;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.3);
            position: sticky;
            top: 0;
            z-index: 20;
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

        .container {
            max-width: 1000px;
            margin: 40px auto;
            background-image: url('AB.jpg');
            background-position: center;
            background-size: cover;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        }
        h2 {
            color: #0FFF50;
            font-size: 32px;
            margin-bottom: 15px;
        }
        p {
            font-size: 20px;
            line-height: 1.6;
            margin-bottom: 20px;
        }
        .features {
            display: flex;
            flex-wrap: wrap;
            justify-content: space-around;
            margin-top: 30px;
        }
        .feature {
            flex-basis: 45%;
            margin: 20px 0;
            background-color: #f4f4f4;
            padding: 20px;
            border-radius: 8px;
            text-align: center;
            box-shadow: 0 1px 5px rgba(0, 0, 0, 0.1);
        }
        .feature h3 {
            color: #28a745;
            font-size: 26px;
            margin-bottom: 15px;
            text-align: center;
        }
        .feature p {
            font-size: 20px;
        }
        .footer {
                background-color: #4CAF50;
                color: #fff;
                padding: 6px 0;
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
                margin-bottom: 6px;
            }

            .footer-section h3 {
                margin-bottom: 6px;
                font-size: 1.2rem;
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
                <li><a href="home.php" class="active">Home</a></li>
                <li><a href="location.php">Locations</a></li>
                <li><a href="dashboard.php">Game DashBoard</a></li>
                <li><a href="profile.php">Profile</a></li>
                <li><a href="index.php">Logout</a></li>
            </ul>
        </div>
    </nav>
</header>

<div class="container">
    <h2>Our Mission</h2>
    <p style="color: white; text-align: center;">At GreenHub, we are committed to making sustainability simple and accessible for everyone. Our mission is to help individuals and communities take an active role in protecting the environment by connecting them with nearby recycling centers. Whether it's plastic, metal, glass, or electronic waste, GreenHub makes it easier to find the right place to dispose of waste responsibly.</p>

    <p style="color: white; text-align: center;">We believe that every small action contributes to a greener future, and by providing a platform that simplifies recycling, we aim to reduce the amount of waste that ends up in landfills. Our user-friendly app allows you to quickly locate the nearest recycling center based on your location, check what materials they accept, and even get tips on how to prepare your waste for recycling.</p>

    <p style="color: white; text-align: center;">At GreenHub, we’re passionate about empowering people to make eco-friendly choices, and we envision a future where everyone is a part of the solution for a cleaner, healthier planet.</p>

    <div class="features">
        <div class="feature">
            <h3>Local Recycling Centers</h3>
            <p>Instantly locate the nearest recycling center with detailed information on accepted materials.</p>
        </div>
        <div class="feature">
            <h3>Environmental Impact</h3>
            <p>Reduce waste and contribute to a more sustainable world by recycling responsibly.</p>
        </div>
        <div class="feature">
            <h3>Easy to Use</h3>
            <p>Our app is designed for simplicity, making it easy for anyone to take part in recycling efforts.</p>
        </div>
        <div class="feature">
            <h3>Stay Informed</h3>
            <p>Get real-time updates on recycling tips, center availability, and more.</p>
        </div>
    </div>
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
            <p>&copy; THE GREEN APP. All rights reserved.</p>
        </div>
    </footer>
</body>
</html>
