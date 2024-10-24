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
<title>The Green App - Home</title>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" />
<link rel="shortcut icon" type="image/png" href="images/green-app-icon.png" />
<script src="https://kit.fontawesome.com/dbed6b6114.js" crossorigin="anonymous"></script>

<style>
/* General Styles */
body {
    font-family: Arial, sans-serif;
    margin: 0;
    padding: 0;
    background-color: #98FB98; 
}

/* Header */
.header {
width: 100%;
padding: 5px;
background-color: #28a745;
box-shadow: 0 2px 8px rgba(0, 0, 0, 0.3);
position: sticky;
top: 0;
z-index: 20; /* Add this line to ensure header is on top */
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

h1 {
font-size: 3em;
margin-bottom: 10px;
background: -webkit-linear-gradient(45deg, #00e676, #76ff03);
-webkit-background-clip: text;
-webkit-text-fill-color: transparent;
text-align: center;
animation: fadeIn 1s ease-in-out;
}

/* Section One */
.section-one {
    padding: 40px 20px;
    text-align: center;
}

.about-content {
    max-width: 800px;
    margin: 0 auto;
}

.about-img img {
    max-width: 150px;
    border-radius: 50%;
}

blockquote {
    font-style: italic;
    color: #555;
    margin: 20px 0;
}

blockquote span {
    display: block;
    margin-top: 10px;
    font-weight: bold;
    color: #004d40;
}

.services {
    display: flex;
    justify-content: space-around;
    flex-wrap: wrap;
}
.service-item {
background-color: #fff;
border: 1px solid #ccc;
border-radius: 10px;
box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
padding: 20px;
margin: 10px;
max-width: 400px;
transition: transform 0.3s, box-shadow 0.3s;
}

.service-item:hover {
transform: translateY(-5px);
box-shadow: 0 8px 16px rgba(0, 0, 0, 0.2);
}

.service-item h3 {
    color: #004d40;
    font-size: 20px;
    margin-bottom: 10px;
}

.service-item p {
    color: #555;
    margin-bottom: 20px;
}

.btn {
background-color: #28a745;
color: white;
padding: 10px 20px;
text-decoration: none;
border-radius: 5px;
display: block; 
margin: 0 auto; 
width: fit-content; 
}
.btn:hover {
background-color: #218838;
transform: translateY(-2px);
}



/* Responsive Design */
@media (max-width: 768px) {
    .navBtn {
        display: block;
    }

    .top-nav ul {
        display: none;
        flex-direction: column;
        align-items: center;
        width: 100%;
        background-color: #28a745;
        position: absolute;
        top: 60px;
        left: 0;
    }

    .top-nav ul.show {
        display: flex;
    }

    .top-nav ul li {
        margin: 10px 0;
    }

    .search-icon {
        display: block;
        color: white;
        cursor: pointer;
    }

    .cancel-icon {
        display: block;
        color: white;
        cursor: pointer;
        display: none;
    }
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
<!-- Header -->
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
<!-- End of Header -->

<!-- Main Content -->
<section class="section-one">
<div class="container about">
    <div class="about-content">
        <div class="about-img flex">
            <img src="icon.jpg" alt="The Green App Logo">
        </div>
        <p style="font-size: 20px; text-transform: uppercase;"><?php echo htmlspecialchars($username); ?></p>
        <h2>Welcome to The Green App</h2>
        <h3>Recycle | Reduce | Reuse</h3>
        <blockquote>
            "The Earth is what we all have in common."
            <span>- Wendell Berry</span>
        </blockquote>
        <p>The Green App is dedicated to helping you find recycling centers near you and providing the best tips
            on how to recycle effectively. Join us in making the planet greener and more sustainable.</p>
    </div>
</div>
</section>
<div class="container">
    <h2 style="text-align:center; color: #28a745; font-size: 30px;">Explore Our Services</h2>
    <div class="services">
        <div class="service-item">
            <h3>Find Recycling Centers</h3>
            <p>Locate the nearest recycling centers and learn what items you can recycle there.</p>
            <a href="location.php" class="btn">Find Centers</a>
        </div>
        <div class="service-item">
            <h3>Recycling Tips</h3>
            <p>Learn the best practices for recycling and reducing waste in your community.</p>
            <a href="RecyclingTips.php" class="btn">Learn More</a>
        </div>
        <div class="service-item">
            <h3>About Us</h3>
            <p>Discover our mission and how we are working to make the planet greener.</p>
            <a href="AboutUs.php" class="btn">About Us</a>
        </div>
    </div>
</div>
<!-- End of Main Content -->

<!-- Footer -->
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
        <li><a href="https://x.com/greeneryorg?s=21" target="_blank"><i class="fab fa-twitter"></i></a></li>
        <li><a href=" https://www.instagram.com/recycle.green/" target="_blank"><i class="fab fa-instagram"></i></a></li>
    </ul>
</div>
</div>
<div class="footer-bottom">
<p>&copy; THE GREEN APP. All rights reserved.</p>
</div>
</footer>
<!-- End of Footer -->

<script>
// Script for responsive navigation menu
const navBtn = document.querySelector('.navBtn');
const myMenu = document.querySelector('#myMenu');

navBtn.addEventListener('click', () => {
    myMenu.classList.toggle('show');
});
</script>
</body>

</html>