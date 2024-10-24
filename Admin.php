<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Recycling Centers</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" />


    <style>
        body {
            font-family: 'Lato', sans-serif; 
        }
        .btn-add {
            background-color: green; 
            color:white;
        }
        .btn-add-pin{
            background-color: yellow; 
            color:white;
        }

        h2 {
            text-align: center; 
            color: green; 
        }.footer {
    background-color: #4CAF50;
    color: #fff;
    padding: 10px 0;
    font-size: 0.9rem;
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
    <li><a href="admin_dashboard.php" class="active">Admin</a></li>
    <li><a href="profile.php">Profile</a></li>
    <li><a href="index.php">Logout</a></li>
    </ul>
</div>
</nav>
</header>
    <div class="container my-5">
        <h2>List of Recycling Centers</h2>
        <a class="btn btn-add" href="/GreenHub/addCenter.php" role="button">Add Recycling Center</a>

        <a class="btn btn-add-pin" href="/GreenHub/addPin.php" role="button">Add co-ordinates</a> 

        <br><br>

        <table class="table">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Center Name</th>
                    <th>Location</th>
                    <th>Operating Hours</th>
                    <th>Materials</th>
                    <th>Contact</th>
                    <th>Status</th>
                    <th>Date Added</th>
                    <th>Actions</th> <!-- Added a header for actions -->
                </tr>
            </thead>
            <tbody>
                <?php
                $servername = "localhost";
                $username = "root";
                $password = "";
                $dbname = "greenhub-app";

                // Create connection
                $connection = new mysqli($servername, $username, $password, $dbname);
                if ($connection->connect_error) {
                    die("Connection failed: " . $connection->connect_error);
                }

                // Read all rows from the database table
                $sql = "SELECT * FROM recycling_centers";
                $result = $connection->query($sql);

                if (!$result) {
                    die("Invalid query: " . $connection->error);
                }

                // Read from each row
                while ($row = $result->fetch_assoc()) {
                    echo "
                    <tr>
                        <td>{$row['center_id']}</td>
                        <td>{$row['center_name']}</td>
                        <td>{$row['location']}</td>
                        <td>{$row['operating_hours']}</td>
                        <td>{$row['accepted_materials']}</td>
                        <td>{$row['contact_info']}</td>
                        <td>{$row['status']}</td>
                        <td>{$row['date_added']}</td>
                        <td>
                            <a class='btn btn-primary btn-sm' href='/GreenHub/edit.php?center_name={$row['center_name']}'>Update</a>
                            <a class='btn btn-danger btn-sm' href='/GreenHub/delete.php?center_name={$row['center_name']}'>Delete</a>
                        </td>
                    </tr>";
                }
                ?>
            </tbody>
        </table>
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
                <li><a href="https://www.facebook.com/RecycleProUK" target="_blank"><i class="fab fa-facebook-f"></i></a></li>
                <li><a href="https://x.com/greeneryorg?s=21" target="_blank"><i class="fab fa-twitter"></i></a></li>
                <li><a href="https://www.instagram.com/recycle.green/" target="_blank"><i class="fab fa-instagram"></i></a></li>
            </ul>
        </div>
    </div>
    <div class="footer-bottom">
        <p>&copy; THE GREEN APP. All rights reserved.</p>
    </div>
</footer>

</body>
</html>
