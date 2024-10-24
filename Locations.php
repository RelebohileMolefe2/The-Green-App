<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>The Green App - location</title>
    <link rel="shortcut icon" type="image/png" href="images/green-app-icon.png" />
    <link rel="stylesheet" href="style2.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    </head>

<body>
    <header class="header">
        <nav class="nav-section">
            <div class="brand-and-navBtn">
                <div class="logo-container">
                    <img src="logo.jpeg" alt="Logo">
                </div>
                <span class="brand-name">The Green App</span>
    
            </div>
            <div class="search-container">
                <form action="#" method="get">
                    <input type="text" placeholder="Search..." name="search">
                    <button type="submit"><i class="fas fa-search"></i></button>
                </form>
            </div>
            <button class="navBtn" id="navBtn">
                <i class="fas fa-bars"></i>
            </button>
            <div class="top-nav" id="topNav">
                <ul>
                    <li><a href="Home.html">Home</a></li>
                    <li><a href="dashboard.php" >Game DashBoard</a></li>
                    <li><a href="Locations.php" class="active">Locations</a></li>
                    <li><a href="About.html">About</a></li>
                </ul>
            </div>
        </nav>
    </header>

    <main role="main">
        <section class="hero">
            <h1>Recycle Centres</h1>
            <p>Find a recyling centre near you and Recycle away</p>
        </section>


    <div class="map-section">
        <div class="map-container">
            <iframe
                src="https://maps.google.com/maps?q=recycling%20centers%20cape%20town&t=&z=13&ie=UTF8&iwloc=&output=embed"
                    width="100%" height="100%" frameborder="0" style="border:0;" allowfullscreen="" aria-hidden="false"
                        tabindex="0">
                </iframe>
            </div>
        </div>

        
    </main>

<footer class="footer">
    <div class="footer-container">
        <div class="footer-section">
            <h3>Stay Connected</h3>
            <form class="subscribe-form">
                <input type="email" placeholder="Enter your email">
                <button type="submit">Subscribe</button>
            </form>
        </div>
        <div class="footer-section">
            <h3>Contact Us</h3>
            <p>Email: info@thegreenapp.com</p>
            <p>Phone: (123) 456-7890</p>
        </div>
        <div class="footer-section">
            <h3>Follow Us</h3>
            <div class="social-icons">
                <a href="#"><i class="fab fa-facebook"></i></a>
                <a href="#"><i class="fab fa-twitter"></i></a>
                <a href="#"><i class="fab fa-instagram"></i></a>
            </div>
        </div>
    </div>
    <div class="footer-bottom">
        <p>&copy; MR AJ YAWA. All rights reserved.</p>
    </div>
</footer>

    <script>
        document.getElementById('navBtn').addEventListener('click', function () {
            document.getElementById('topNav').classList.toggle('show');
        });
    </script>
</body>

</html>