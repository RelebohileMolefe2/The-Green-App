
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Game Dashboard</title>
    <style>
        /* Reset default margins and paddings */
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Poppins', sans-serif; /* Modern gamey font */
            color: #fff;
        }

        /* Body styling */
        body {
            background-image: url('gdash.jpg'); /* Replace with your image path */
            background-size: cover; /* Cover the entire header */
            background-position: center; /* Center the image */
            background-repeat: no-repeat; 
            min-height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
            flex-direction: column;
        }

        /* Container for both games and high scores */
        .container {
            width: 100%;
            max-width: 600px;
            display: flex;
            flex-direction: column;
            align-items: center;
        }
        
        .header {
            width: 100%;
            padding: 10px;
            background-color: #28a745;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.3);
            position: fixed; /* Changed from sticky to fixed */
            top: 0;
            left: 0;
            z-index: 1000; /* Ensures it stays above other content */
        }

        .logo-container {
            padding: 5px;
        }

        .logo-container img {
            width: 60px;
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
 
.dashboard-title {
    margin-top: 80px;
    text-align: center;
    font-size: 3em;
    color: #ffd700;
    text-shadow: 2px 2px 5px rgba(0, 0, 0, 0.7);
    padding: 20px;
    border-radius: 10px;
    border: 5px solid #004d00;
    transition: transform 0.3s;
}

.dashboard-title:hover {
    transform: scale(1.05);
}


        /* Main container for the dashboard */
        .games, .high-scores, .top-scores {
            width: 100%;
            background-color: rgba(0, 50, 0, 0.7);
            padding: 30px;
            border-radius: 15px;
            margin: 15px 0;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.5);
        }

        /* Subtitle and section headers */
        h2 {
            color: #33cc33;
            text-transform: uppercase;
            margin-bottom: 10px;
            font-size: 1.5em;
            border-bottom: 2px solid #66ff66;
            padding-bottom: 5px;
            letter-spacing: 1px;
        }

        /* Game links */
        .games ul {
            list-style: none;
            display: flex;
            justify-content: space-around;
            margin-top: 20px;
        }

        .games ul li {
            margin: 0 10px;
            text-align: center;
        }

        .games ul li a {
            display: block;
            padding: 15px 20px;
            background-color: #006600;
            border: 2px solid transparent;
            color: #66ff66;
            text-decoration: none;
            font-size: 1.2em;
            font-weight: bold;
            border-radius: 10px;
            transition: 0.4s;
            text-shadow: 2px 2px 8px rgba(0, 0, 0, 0.5);
        }

        /* Hover effect on game links */
        .games ul li a:hover {
            background-color: #33cc33;
            border: 2px solid #66ff66;
            transform: translateY(-5px);
            box-shadow: 0 8px 25px rgba(102, 255, 102, 0.8);
        }

        /* High score list */
        .high-scores ul, .top-scores ul {
            list-style: none;
            padding: 10px;
            margin-top: 20px;
            border-radius: 10px;
            background-color: rgba(0, 50, 0, 0.5);
            box-shadow: inset 0 2px 8px rgba(0, 0, 0, 0.5);
        }

        .high-scores ul li, .top-scores ul li {
            font-size: 1.2em;
            margin: 10px 0;
            background: linear-gradient(45deg, #33cc33, #66ff66);
            padding: 10px;
            border-radius: 10px;
            text-shadow: 1px 1px 3px rgba(0, 0, 0, 0.5);
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.3);
        }

        /* Add some animation */
        .games ul li a, .high-scores ul li, .top-scores ul li {
            animation: fadeIn 1s ease-in-out;
        }

        /* Fade-in animation */
        @keyframes fadeIn {
            0% {
                opacity: 0;
                transform: translateY(20px);
            }
            100% {
                opacity: 1;
                transform: translateY(0);
            }
        }

        /* Media queries for responsiveness */
        @media (max-width: 768px) {
            h1 {
                font-size: 2.5em;
            }

            h2 {
                font-size: 1.3em;
            }

            .games ul li a {
                font-size: 1em;
                padding: 12px 15px;
            }
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
                <li><a href="home.php">Home</a></li>
                <li><a href="location.php">Location</a></li>
                <li><a href="dashboard.php">Game DashBoard</a></li>
                <li><a href="profile.php" class="active">Profile</a></li>
                <li><a href="index.php">Logout</a></li>
            </ul>
        </div>
    </nav>
</header>
<h1 class="dashboard-title">Welcome to Your Game Dashboard</h1>

<div class="container">
    <div class="games">
        <h2>Select a Game:</h2>
        <ul>
            <li><a href="RecycleRush.php">Recycle Rush</a></li>
            <li><a href="RecycleQuiz.php">Recycle Quiz</a></li>
        </ul>
    </div>
    
</body>
</html>
