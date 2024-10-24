<?php
include('server.php'); // Database connection file

$errors = [];

// Check if the user is logged in and is an admin
if (!isset($_SESSION['role']) || $_SESSION['role'] != 'admin') {
    header('Location: home.php');
    exit();
}

$username = isset($_SESSION['username']) ? $_SESSION['username'] : 'Guest';

// Pagination setup
$limit = 10; // Number of users per page
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$offset = ($page - 1) * $limit;

// Fetch all users with pagination
$query = "SELECT * FROM users LIMIT $limit OFFSET $offset";
$result = mysqli_query($db, $query);

// Get total user count for pagination
$totalQuery = "SELECT COUNT(*) as total FROM users";
$totalResult = mysqli_query($db, $totalQuery);
$total = mysqli_fetch_assoc($totalResult)['total'];
$totalPages = ceil($total / $limit);

// Check if the form has been submitted to add a new user
if (isset($_POST['add_user'])) {
    $new_username = mysqli_real_escape_string($db, $_POST['new_username']);
    $new_email = mysqli_real_escape_string($db, $_POST['new_email']);
    $new_password = mysqli_real_escape_string($db, $_POST['new_password']);
    
    // Password hashing for security
    $hashed_password = password_hash($new_password, PASSWORD_DEFAULT);
    
    // Validate input (add your own validation logic as needed)
    if (empty($new_username) || empty($new_email) || empty($new_password)) {
        $errors[] = "All fields are required.";
    } else {
        // Insert new user into the database
        $insertQuery = "INSERT INTO users (username, email, password, role) VALUES ('$new_username', '$new_email', '$hashed_password', 'user')";
        if (mysqli_query($db, $insertQuery)) {
            // Optionally redirect or provide feedback
            header('Location: admin_dashboard.php?success=User added successfully');
            exit();
        } else {
            $errors[] = "Error adding user: " . mysqli_error($db);
        }
    }
}
// Check if the form has been submitted to change user role
if (isset($_POST['user_id']) && isset($_POST['new_role'])) {
    $userId = $_POST['user_id'];
    $newRole = $_POST['new_role'];

    // Function to change user role
    $stmt = $db->prepare("UPDATE users SET role = ? WHERE id = ?");
    $stmt->bind_param("si", $newRole, $userId);

    // Execute the statement
    if ($stmt->execute()) {
        $_SESSION['message'] = "User role updated to: $newRole";
    } else {
        $_SESSION['error'] = "Error updating role: " . $stmt->error;
    }

    $stmt->close();

    // Redirect to avoid resubmission
    header("Location: admin_dashboard.php");
    exit();
}

// Check if the form has been submitted to add a new user
if (isset($_POST['add_user'])) {
    $new_username = mysqli_real_escape_string($db, $_POST['new_username']);
    $new_email = mysqli_real_escape_string($db, $_POST['new_email']);
    $new_password = mysqli_real_escape_string($db, $_POST['new_password']);
    
    // Password hashing for security
    $hashed_password = password_hash($new_password, PASSWORD_DEFAULT);
    
    // Validate input
    if (empty($new_username) || empty($new_email) || empty($new_password)) {
        $errors[] = "All fields are required.";
    } else {
        // Insert new user into the database
        $insertQuery = "INSERT INTO users (username, email, password, role) VALUES ('$new_username', '$new_email', '$hashed_password', 'user')";
        if (mysqli_query($db, $insertQuery)) {
            $_SESSION['message'] = "User added successfully.";
        } else {
            $errors[] = "Error adding user: " . mysqli_error($db);
        }
    }

    // Redirect to avoid resubmission
    header("Location: admin_dashboard.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" />
    <title>GreenHub Admin Dashboard</title>
    <style>
body {
    font-family: 'Arial', sans-serif;
    background-color: #e8f5e9; 
    margin: 0;
    padding: 0;
    color: #333;
}

/* Admin Header */
.admin-header {
    background-color: #2e7d32; 
    color: #fff;
    padding: 15px 20px;
    text-align: center;
    border-bottom: 5px solid #1b5e20;
}

.admin-header h1 {
    margin: 0;
    font-size: 2.5em;
    text-shadow: 2px 2px 4px #000;
}

.admin-header p {
    font-size: 1.2em;
}

/* Updated Admin Container for Left-Side Navigation */
.admin-container {
    display: flex;
    flex-direction: row; 
    margin: 20px auto;
    width: 90%;
}

/* Admin Navigation (Left Sidebar) */
.admin-navigation {
    flex: 1;
    min-width: 250px;
    background-color: #4caf50;
    border-radius: 10px;
    padding: 15px;
    margin-right: 20px; 
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
    position: sticky;
    top: 20px;
}

.admin-navigation h2 {
    color: #fff;
    text-align: center;
}

.admin-navigation ul {
    list-style-type: none;
    padding: 0;
}

.admin-navigation ul li {
    margin: 10px 0;
}

.admin-navigation ul li a {
    color: #fff;
    text-decoration: none;
    font-weight: bold;
    font-size: 1.2em;
    display: block;
    padding: 10px;
    border-radius: 5px;
    background: #388e3c;
    text-align: center;
    transition: background-color 0.3s;
}

.admin-navigation ul li a:hover {
    background-color: #1b5e20;
}

/* Admin Content (Right Side) */
.admin-content {
    flex: 3;
    min-width: 600px;
    background-color: #f1f8e9;
    padding: 20px;
    border-radius: 10px;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
}

/* User Management Section */
.admin-section {
    margin-bottom: 20px;
}

.admin-section h3 {
    color: #2e7d32;
}

/* Form Styles */
form {
    margin: 20px 0;
}

form input[type="text"],
form input[type="email"],
form input[type="password"] {
    width: 100%;
    padding: 10px;
    margin: 8px 0;
    box-sizing: border-box;
    border: 2px solid #4caf50;
    border-radius: 5px;
}

/* Button Styles */
input[type="submit"],
.logout-button {
    background-color: #388e3c;
    color: white;
    border: none;
    padding: 10px 15px;
    border-radius: 5px;
    cursor: pointer;
    transition: background-color 0.3s;
}

input[type="submit"]:hover,
.logout-button:hover {
    background-color: #1b5e20;
}

/* Table Styles */
#userTable {
    width: 100%;
    border-collapse: collapse;
    margin: 20px 0;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
}

#userTable th,
#userTable td {
    text-align: left;
    padding: 12px;
    border-bottom: 1px solid #ddd;
}

#userTable th {
    background-color: #4caf50;
    color: white;
}

#userTable tr:hover {
    background-color: #f1f8e9;
}

/* Pagination Styles */
.pagination a {
    color: #4caf50;
    text-decoration: none;
    padding: 8px 16px;
    border: 1px solid #4caf50;
    margin: 0 4px;
    border-radius: 5px;
    transition: background-color 0.3s;
}

.pagination a:hover {
    background-color: #4caf50;
    color: #fff;
}

/* Error Display */
.error {
    background-color: #ffccbc;
    color: #d32f2f;
    border-left: 6px solid #d32f2f;
    padding: 10px;
    margin: 20px 0;
    border-radius: 5px;
}

/* Sticky Navigation on Scroll */
@media (max-width: 768px) {
    .admin-container {
        flex-direction: column;
    }

    .admin-navigation {
        margin-bottom: 20px;
        position: relative;
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
<div class="admin-header">
    <h1>Admin Dashboard</h1>
    <p style="font-size: 20px; text-transform: uppercase;">Welcome, <?php echo htmlspecialchars($username); ?></p>
    <form action="login.php" method="post" style="display:inline;">
        <button type="submit" class="logout-button">Logout</button>
    </form>
</div>


    <div class="admin-container">
        <div class="admin-navigation">
            <h2>Navigation</h2>
            <ul>
            <li><a href="Admin.php">Adding Recycling Centers</a></li>
                <li><a href="location.php">Recycling Centers Map</a></li>
                <li><a href="dashboard.php">Game Dashboard</a></li>
                <li><a href="profile.php">Profile Page</a></li>
                <li><a href="home.php">Home Page</a></li>
            </ul>
        </div>

        <div class="admin-content">
            <h2>User Management</h2>
            <div class="admin-section">
            <h3>Add New User</h3>
    <form action="admin_dashboard.php" method="POST">
        <input type="text" name="new_username" placeholder="Username" required>
        <input type="email" name="new_email" placeholder="Email" required>
        <input type="password" name="new_password" placeholder="Password" required>
        <input type="submit" name="add_user" value="Add User" style="background-color: #4CAF50; color: white; border: none; padding: 10px 15px; border-radius: 5px; cursor: pointer;">
    </form>

            <div class="admin-section">
            <h3>Monitor Users</h3>
                <input type="text" id="searchUser" placeholder="Search by username or email" onkeyup="filterUsers()">
                <table id="userTable" border="1">
                    <tr><th>ID</th><th>Username</th><th>Email</th><th>Role</th><th>Action</th></tr>
                    <?php
                    if ($result) {
                        while ($row = mysqli_fetch_assoc($result)) {
                            echo "<tr>";
                            echo "<td>" . htmlspecialchars($row['id']) . "</td>";
                            echo "<td>" . htmlspecialchars($row['username']) . "</td>";
                            echo "<td>" . htmlspecialchars($row['email']) . "</td>";
                            echo "<td>
                                <form action='admin_dashboard.php' method='POST'>
                                   <select name='new_role' onchange='this.form.submit()'>
                                        <option value='user' " . ($row['role'] == 'user' ? 'selected' : '') . ">User</option>
                                        <option value='admin' " . ($row['role'] == 'admin' ? 'selected' : '') . ">Admin</option>
                                    </select>
                                    <input type='hidden' name='user_id' value='" . htmlspecialchars($row['id']) . "'>
                                </form>
                              </td>";
                            echo "<td><a href='delete_user.php?id=" . urlencode($row['id']) . "' onclick=\"return confirm('Are you sure you want to delete this user?')\">Delete</a></td>";
                            echo "</tr>";
                        }
                    } else {
                        $errors[] = "Error fetching user data: " . mysqli_error($db);
                    }
                    ?>
                </table>

                <div class="pagination">
                    <?php for ($i = 1; $i <= $totalPages; $i++): ?>
                        <a href="admin_dashboard.php?page=<?php echo $i; ?>"><?php echo $i; ?></a>
                    <?php endfor; ?>
                </div>
            </div>
        </div>
    </div>

    <!-- Display errors if any -->
    <?php if (count($errors) > 0) : ?>
        <div class="error">
            <?php foreach ($errors as $error) : ?>
                <p><?php echo htmlspecialchars($error); ?></p>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>
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

    <script>
        function filterUsers() {
            const input = document.getElementById('searchUser');
            const filter = input.value.toLowerCase();
            const table = document.getElementById('userTable');
            const tr = table.getElementsByTagName('tr');

            for (let i = 1; i < tr.length; i++) {
                const tdUsername = tr[i].getElementsByTagName('td')[1];
                const tdEmail = tr[i].getElementsByTagName('td')[2];
                if (tdUsername || tdEmail) {
                    const usernameText = tdUsername.textContent || tdUsername.innerText;
                    const emailText = tdEmail.textContent || tdEmail.innerText;
                    if (usernameText.toLowerCase().indexOf(filter) > -1 || emailText.toLowerCase().indexOf(filter) > -1) {
                        tr[i].style.display = "";
                    } else {
                        tr[i].style.display = "none";
                    }
                }
            }
        }
    </script>
</body>
</html>
