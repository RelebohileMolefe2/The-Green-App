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
        <title>Recycling Centers Map with Search</title>
        <link rel="stylesheet" href="https://unpkg.com/leaflet/dist/leaflet.css" />
        <link rel="stylesheet" href="https://unpkg.com/leaflet-control-geocoder/dist/Control.Geocoder.css" />
        <link rel="stylesheet" href="https://unpkg.com/leaflet-routing-machine/dist/leaflet-routing-machine.css" />
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" />
        <style>
            {
        margin: 0;
        padding: 0;
        box-sizing: border-box;
    }

    body {
        font-family: Arial, sans-serif;
        line-height: 1.6;
        color: #333;
        background-color: #f4f4f4;
        background-image: url('background.webp');
        background-size: cover;
        background-position: center;
        background-repeat: no-repeat;
        background-attachment: fixed;
        position: relative;
        z-index: 1;
    }

    body::before {
        content: "";
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background-image: inherit;
        background-size: cover;
        background-position: center;
        background-repeat: no-repeat;
        filter: blur(10px);
        z-index: -1;
    }

    /* 3. Typography*/
    h1, h2, h3 {
        color: var(--text-color);
    }


    /* 4. Layout */
    .container {
        max-width: 1200px;
        margin: 0 auto;
        padding: 0 20px;
    }

    /* 5. Header */
    .header {
    width: 100%;
    padding: 10px;
    background-color: #28a745;
    box-shadow: 0 2px 8px rgba(0, 0, 0, 0.3);
    position: sticky;
    top: 0;
    z-index: 10000; /* Increase z-index to ensure it stays on top */
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

    h1 {
        font-size: 3em;
        margin-bottom: 10px;
        background: -webkit-linear-gradient(45deg, #00e676, #76ff03);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        text-align: center;
        animation: fadeIn 1s ease-in-out;
    }

    /* 8. Main Content */
    main {
        padding: 40px 20px;
    }

    /* 9. Hero Section */
    .hero {
        text-align: center;
        padding: 20px 0;
        margin-bottom: 20px;
        background-color: var(--background-color);
        
    }

    .hero h1 {
        font-size: 2.5rem;
        margin-bottom: 1rem;
        color: var(--accent-color);
    }

    .hero p {
        font-size: 1.2rem;
        margin-bottom: 2rem;
        color: #fff;
    }

    .cta-buttons {
        margin-top: 20px;
    }

    /* 10. Services Section */
    .services {
        display: flex;
        justify-content: space-around;
        flex-wrap: wrap;
        margin-top: 50px;
    }

    .service-item {
        flex-basis: calc(33.333% - 20px);
        background-color: var(--background-color);
        border: 1px solid #ccc;
        border-radius: 8px;
        padding: 20px;
        margin: 10px;
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        box-shadow: 0 0 10px rgba(0, 253, 228, 0.7);
        text-align: center;
        transition: transform 0.3s ease;
    }

    .service-item:hover {
        transform: translateY(-5px);
    }

    .service-item h3 {
        color: var(--accent-color);
        font-size: 20px;
        margin-bottom: 10px;
        text-align: right;
    }

    .service-item p {
        color: var(--text-color);
        margin-bottom: 20px;
    }

    /* 11. Footer */
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
                max-width: 1200px;
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
                margin-right: 10px;
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

            
            #map {
    height: 400px;
    width: 80%;
    margin: 20px auto;
    border: 2px solid #fff;
    border-radius: 10px;
    box-shadow: 0 4px 20px rgba(0, 0, 0, 0.5);
    margin-top: 50px; /* Ensure spacing under the header */
}

            .leaflet-control-geocoder {
                background: rgba(255, 255, 255, 0.8);
                border-radius: 20px;
                box-shadow: 0 2px 10px rgba(0, 0, 0, 0.3);
            }
            .leaflet-control-geocoder input {
                border: none;
                border-radius: 20px;
                padding: 10px;
                width: 200px;
                outline: none;
                box-shadow: none;
                transition: all 0.3s;
            }
            .leaflet-control-geocoder input:focus {
                box-shadow: 0 0 10px rgba(255, 255, 255, 0.7);
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

        <section class="hero">
                <h1>Recycle Centres</h1>.
                <p style="font-size: 20px; text-transform: uppercase;"><?php echo htmlspecialchars($username); ?></p>
                <p>Find a recyling centre near you and Recycle away</p>
            </section>
        
        <div id="map"></div>
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

        <script src="https://unpkg.com/leaflet/dist/leaflet.js"></script>
        <script src="https://unpkg.com/leaflet-control-geocoder/dist/Control.Geocoder.js"></script>
        <script src="https://unpkg.com/leaflet-routing-machine/dist/leaflet-routing-machine.js"></script>
        <script>
            var map = L.map('map').setView([-33.9333, 18.4995], 12);

            L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                maxZoom: 19,
                attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
            }).addTo(map);

            var recyclingCenters = [
                { name: 'Sea Point Dropoff', lat: -33.9116, lng: 18.3889, type: 'Dropoff' },
                { name: 'Atlantic Recycling', lat: -33.9178, lng: 18.4678, type: 'Recycling' },
                { name: 'meWasteSA', lat: -33.9247, lng: 18.4747, type: 'Recycling' },
                { name: 'Fine Trading (scrap metal recycling)', lat: -33.9306, lng: 18.4631, type: 'Scrap Metal' },
                { name: 'Newtech ewaste Recycling', lat: -33.9192, lng: 18.5672, type: 'E-waste' },
                { name: 'Regenerize', lat: -33.9444, lng: 18.5422, type: 'Recycling' },
                { name: 'AST Recycling Cape Town', lat: -33.9500, lng: 18.5589, type: 'Recycling' },
                { name: 'HLQ Recycle', lat: -33.9669, lng: 18.5067, type: 'Recycling' },
                { name: 'Oasis Recycling Depot', lat: -33.9861, lng: 18.4714, type: 'Recycling' }
            ];

            var customIcon = L.icon({
                iconUrl: 'licon.jpg', // Path to your icon image
                iconSize: [32, 32],
                iconAnchor: [16, 32],
                popupAnchor: [0, -32]
            });

            fetch('get_centers.php')
            .then(response => response.json())
            .then(data => {
                data.forEach(center => {
                    var marker = L.marker([center.latitude, center.longitude], { icon: customIcon })
                        .addTo(map)
                        .bindPopup(`<b>${center.name}</b><br>Type: ${center.type}<br><span class="get-directions">Get Directions</span>`);
                });
            })
            .catch(error => console.error('Error fetching recycling centers:', error));

            var searchedLocation = null;
            var routingControl;

            recyclingCenters.forEach(center => {
                var marker = L.marker([center.lat, center.lng], { icon: customIcon })
                    .addTo(map)
                    .bindPopup(`<b>${center.name}</b><br>Type: ${center.type}<br><span class="get-directions">Get Directions</span>`)
                    .on('click', function () {
                        if (searchedLocation) {
                            var distance = calculateDistance(searchedLocation.lat, searchedLocation.lng, center.lat, center.lng);
                            this.setPopupContent(`<b>${center.name}</b><br>Type: ${center.type}<br>Distance: ${distance.toFixed(2)} km<br><span class="get-directions">Get Directions</span>`);
                        }
                    });

                marker.on('popupopen', function () {
                    var popupContent = this.getPopup().getContent();
                    if (popupContent.includes('Get Directions')) {
                        this.getPopup().getContent().querySelector('.get-directions').onclick = function () {
                            if (searchedLocation) {
                                if (routingControl) {
                                    map.removeControl(routingControl);
                                }
                                routingControl = L.Routing.control({
                                    waypoints: [
                                        L.latLng(searchedLocation.lat, searchedLocation.lng),
                                        L.latLng(center.lat, center.lng)
                                    ],
                                    router: L.Routing.osrmv1({
                                        serviceUrl: 'https://router.project-osrm.org/route/v1'
                                    }),
                                    routeWhileDragging: true,
                                    geocoder: L.Control.Geocoder.nominatim()
                                }).addTo(map);
                            } else {
                                alert('Please search for your location first!');
                            }
                        };
                    }
                });
            });

            L.Control.geocoder({
                defaultMarkGeocode: false
            }).on('markgeocode', function (e) {
                var center = e.geocode.center;
                searchedLocation = { lat: center.lat, lng: center.lng };
                L.marker(center).addTo(map).bindPopup('You are here!').openPopup();
                map.setView(center, 14); // Zoom into the searched location
            }).addTo(map);

            function calculateDistance(lat1, lon1, lat2, lon2) {
                var R = 6371; // Radius of the Earth in km
                var dLat = (lat2 - lat1) * Math.PI / 180;
                var dLon = (lon2 - lon1) * Math.PI / 180;
                var a =
                    Math.sin(dLat / 2) * Math.sin(dLat / 2) +
                    Math.cos(lat1 * Math.PI / 180) * Math.cos(lat2 * Math.PI / 180) *
                    Math.sin(dLon / 2) * Math.sin(dLon / 2);
                var c = 2 * Math.atan2(Math.sqrt(a), Math.sqrt(1 - a));
                var distance = R * c; // Distance in km
                return distance;
            }
        </script>
    </body>
    </html>
