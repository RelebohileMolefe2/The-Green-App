<?php
session_start();

// Check if user is logged in
if (!isset($_SESSION['username'])) {
    echo "User not logged in"; // Handle the error
    exit();
}

// Connect to the database
$db = mysqli_connect('localhost', 'root', '', 'greenhub-app');

// Get the username and user ID
$username = $_SESSION['username'];
$sql = "SELECT id FROM users WHERE username='$username'";
$result = mysqli_query($db, $sql);
$user = mysqli_fetch_assoc($result);
$user_id = $user['id'];

// Handle AJAX request to update the score
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $score = $_POST['score']; // Get the submitted score from the AJAX request
    $game_name = 'Recycle Rush'; // Set the game name

    // Check if the user already has a score for this game
    $sql = "SELECT * FROM high_scores WHERE user_id='$user_id' AND game_name='$game_name'";
    $result = mysqli_query($db, $sql);

    if (mysqli_num_rows($result) > 0) {
        // Update the existing score
        $sql = "UPDATE high_scores SET score='$score' WHERE user_id='$user_id' AND game_name='$game_name'";
    } else {
        // Insert a new score
        $sql = "INSERT INTO high_scores (user_id, game_name, score) VALUES ('$user_id', '$game_name', '$score')";
    }

    mysqli_query($db, $sql);
    echo "Score updated successfully"; // Optionally send a response back
} 

mysqli_close($db);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Recycle Challenge Game - Multi Stage</title>
    <style>
        /* Reset default margins and paddings */
* {
    margin: 0;
    padding: 0;
    box-sizing: border-box;
    font-family: 'Poppins', sans-serif;
}

/* Body styling */
body {
    background: linear-gradient(135deg, #004d40, #26a69a);
    min-height: 100vh;
    display: flex;
    justify-content: center;
    align-items: center;
    flex-direction: column;
    color: #fff;
}

/* Header and Navigation */
.header {
    width: 100%;
    padding: 10px;
    background-color: #28a745;
    box-shadow: 0 2px 8px rgba(0, 0, 0, 0.3);
    position: sticky;
  top: 0;
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

/* Game Container */
.game-container {
    background-color: rgba(0, 77, 64, 0.9);
    padding: 40px;
    border-radius: 20px;
    box-shadow: 0 8px 30px rgba(0, 0, 0, 0.3);
    text-align: center;
    width: 90%;
    max-width: 800px;
}

.bins {
    display: flex;
    justify-content: space-between;
    margin-top: 20px;
}

.bin {
    flex: 1;
    padding: 15px;
    margin: 5px;
    background-color: #00796b;
    border-radius: 10px;
    text-align: center;
    font-size: 1.2em;
    transition: 0.3s;
    cursor: pointer;
    box-shadow: 0 4px 10px rgba(0, 0, 0, 0.4);
}

.bin:hover {
    background-color: #004d40;
    transform: translateY(-5px);
}

.waste-items {
    display: flex;
    justify-content: space-around;
    margin-top: 20px;
}

.waste {
    background-color: #ffeb3b;
    color: #000;
    padding: 10px;
    border-radius: 10px;
    font-size: 1.2em;
    margin: 5px;
    cursor: grab;
    transition: transform 0.3s ease;
}

.waste:active {
    cursor: grabbing;
}

#score {
    font-size: 1.5em;
    margin-top: 20px;
    background-color: rgba(255, 255, 255, 0.1);
    padding: 10px;
    border-radius: 10px;
}

#next-stage-btn {
    background-color: #00c853;
    color: #fff;
    padding: 10px 20px;
    margin-top: 20px;
    border: none;
    border-radius: 30px;
    cursor: pointer;
    transition: 0.3s;
    box-shadow: 0 4px 10px rgba(0, 0, 0, 0.4);
}

#next-stage-btn:hover {
    background-color: #00e676;
    transform: translateY(-3px);
}

#stage-message {
    font-size: 2em;
    margin-bottom: 20px;
    animation: fadeIn 1s ease-in-out;
}

/* Popups */
#popup, #wrong-popup {
    position: fixed;
    top: 50%;
    left: 50%;
    transform: translate(-50%, -50%);
    background-color: #004d40;
    padding: 30px;
    border-radius: 20px;
    text-align: center;
    color: #fff;
    z-index: 10;
    box-shadow: 0 8px 30px rgba(0, 0, 0, 0.4);
    display: none;
}

#popup-overlay, #wrong-popup-overlay {
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background-color: rgba(0, 0, 0, 0.5);
    z-index: 5;
    display: none;
}

#popup-message, #wrong-popup-message {
    font-size: 1.5em;
    margin-bottom: 20px;
}

#popup-btn, #wrong-popup-btn {
    background-color: #00e676;
    border: none;
    padding: 10px 20px;
    border-radius: 20px;
    cursor: pointer;
    transition: 0.3s;
}

#popup-btn:hover, #wrong-popup-btn:hover {
    background-color: #00c853;
}

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

/* Media Queries */
@media (max-width: 768px) {
    .bins, .waste-items {
        flex-direction: column;
        align-items: center;
    }

    h1 {
        font-size: 2.5em;
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
                <li><a href="home.php" class="active">Home</a></li>
                <li><a href="dashboard.php">Game DashBoard</a></li>
                <li><a href="profile.php">Profile</a></li>
                </ul>
            </div>
        </nav>
    </header>
    <h1>Recycle Challenge Game</h1>
    <p>Drag and drop the items into the correct bin.</p>
    
    <div class="game-container">
        <!-- Stage Message -->
        <div id="stage-message">Stage 1</div>
        
        <!-- Bins -->
        <div class="bins">
            <div class="bin" id="paper-bin">Paper</div>
            <div class="bin" id="plastic-bin">Plastic</div>
            <div class="bin" id="glass-bin">Glass</div>
            <div class="bin" id="metal-bin">Metal</div>
            <div class="bin" id="compost-bin">Compost</div>
            <div class="bin" id="waste-bin">General Waste</div>
        </div>

        <!-- Waste Items -->
        <div class="waste-items" id="waste-items">
            <!-- Items will be generated dynamically -->
        </div>

        <div id="score">Score: 0</div>
        
        <!-- Button to move to the next stage -->
        <button id="next-stage-btn" onclick="nextStage()">Next Stage</button>
    </div>
    

    <!-- Popup for correct sorting -->
    <div id="popup-overlay"></div>
    <div id="popup">
        <div id="popup-message">Well done GreenHubber for sorting out the waste. Go GreenHubber!</div>
        <button id="popup-btn" onclick="closePopup()">Close</button>
    </div>

    <!-- Popup for wrong sorting -->
    <div id="wrong-popup-overlay"></div>
    <div id="wrong-popup">
        <div id="wrong-popup-message"></div>
        <button id="wrong-popup-btn" onclick="closeWrongPopup()">Close</button>
    </div>

    <script>
        let score = 0;
        let currentStage = 1;
        const stages = {
            1: [
                { id: 'newspaper', name: 'Newspaper', bin: 'paper-bin', info: 'Newspapers can be recycled in the paper bin.' },
                { id: 'plastic-bottle', name: 'Plastic Bottle', bin: 'plastic-bin', info: 'Plastic bottles are recyclable. Place them in the plastic bin.' },
                { id: 'glass-bottle', name: 'Glass Bottle', bin: 'glass-bin', info: 'Glass bottles can be recycled in the glass bin.' }
            ],
            2: [
                { id: 'soda-can', name: 'Soda Can', bin: 'metal-bin', info: 'Soda cans can be recycled in the metal bin.' },
                { id: 'apple-core', name: 'Apple Core', bin: 'compost-bin', info: 'Apple cores can go in the compost bin.' },
                { id: 'broken-mug', name: 'Broken Mug', bin: 'waste-bin', info: 'Broken items like mugs should go in the general waste bin.' }
            ],
            3: [
                { id: 'magazine', name: 'Magazine', bin: 'paper-bin', info: 'Magazines can be recycled in the paper bin.' },
                { id: 'milk-jug', name: 'Milk Jug', bin: 'plastic-bin', info: 'Milk jugs are recyclable. Place them in the plastic bin.' },
                { id: 'wine-bottle', name: 'Wine Bottle', bin: 'glass-bin', info: 'Wine bottles can be recycled in the glass bin.' },
                { id: 'tin-can', name: 'Tin Can', bin: 'metal-bin', info: 'Tin cans can go in the metal bin.' }
            ],
            4: [
                { id: 'cardboard', name: 'Cardboard', bin: 'paper-bin', info: 'Cardboard can be recycled in the paper bin.' },
                { id: 'plastic-wrap', name: 'Plastic Wrap', bin: 'waste-bin', info: 'Plastic wrap is generally not recyclable. Place in waste bin.' },
                { id: 'light-bulb', name: 'Glass Light Bulb', bin: 'waste-bin', info: 'Glass light bulbs should be placed in the general waste bin.' },
                { id: 'aluminum-foil', name: 'Aluminum Foil', bin: 'metal-bin', info: 'Aluminum foil can be recycled in the metal bin.' }
            ],
            5: [
                { id: 'pizza-box', name: 'Pizza Box', bin: 'compost-bin', info: 'Pizza boxes can go in the compost bin if clean.' },
                { id: 'plastic-bag', name: 'Plastic Bag', bin: 'waste-bin', info: 'Plastic bags should go in the general waste bin.' },
                { id: 'ceramic-plate', name: 'Ceramic Plate', bin: 'waste-bin', info: 'Ceramic plates are not recyclable. Dispose in waste bin.' },
                { id: 'water-bottle', name: 'Water Bottle', bin: 'plastic-bin', info: 'Water bottles can be recycled in the plastic bin.' }
            ],
            6: [
                { id: 'wrapping-paper', name: 'Wrapping Paper', bin: 'waste-bin', info: 'Wrapping paper may not be recyclable. Place in waste bin.' },
                { id: 'container', name: 'Food Container', bin: 'plastic-bin', info: 'Food containers can go in the plastic bin.' },
                { id: 'wine-glass', name: 'Wine Glass', bin: 'glass-bin', info: 'Wine glasses should be placed in the waste bin.' },
                { id: 'soda-bottle', name: 'Soda Bottle', bin: 'plastic-bin', info: 'Soda bottles can be recycled in the plastic bin.' }
            ],
            7: [
                { id: 'cereal-box', name: 'Cereal Box', bin: 'paper-bin', info: 'Cereal boxes can be recycled in the paper bin.' },
                { id: 'straw', name: 'Plastic Straw', bin: 'plaste-bin', info: 'Plastic straws are not recyclable. Place in waste bin.' },
                { id: 'glass-jar', name: 'Glass Jar', bin: 'glass-bin', info: 'Glass jars can be recycled in the glass bin.' },
                { id: 'metal-bottle', name: 'Metal Bottle', bin: 'metal-bin', info: 'Metal bottles can be recycled in the metal bin.' }
            ],
            8: [
                { id: 'ketchup-bottle', name: 'Ketchup Bottle', bin: 'plastic-bin', info: 'Ketchup bottles can be recycled in the plastic bin.' },
                { id: 'napkin', name: 'Paper Napkin', bin: 'waste-bin', info: 'Used paper napkins are not recyclable. Place in waste bin.' },
                { id: 'glass-cup', name: 'Glass Cup', bin: 'glass-bin', info: 'Glass cups should go in the waste bin.' },
                { id: 'steel-can', name: 'Steel Can', bin: 'metal-bin', info: 'Steel cans can be recycled in the metal bin.' }
            ],
            9: [
                { id: 'food-wrap', name: 'Food Wrap', bin: 'waste-bin', info: 'Food wraps are not recyclable. Place in waste bin.' },
                { id: 'tin-foil', name: 'Tin Foil', bin: 'metal-bin', info: 'Tin foil can be recycled in the metal bin.' },
                { id: 'plastic-container', name: 'Plastic Container', bin: 'plastic-bin', info: 'Plastic containers can be recycled in the plastic bin.' },
                { id: 'egg-carton', name: 'Egg Carton', bin: 'compost-bin', info: 'Egg cartons can go in the compost bin.' }
            ],
            10: [
                { id: 'plastic-tub', name: 'Plastic Tub', bin: 'plastic-bin', info: 'Plastic tubs can be recycled in the plastic bin.' },
                { id: 'food-scraps', name: 'Food Scraps', bin: 'compost-bin', info: 'Food scraps can go in the compost bin.' },
                { id: 'sponge', name: 'Sponge', bin: 'waste-bin', info: 'Sponges should be placed in the waste bin.' },
                { id: 'cardboard-box', name: 'Cardboard Box', bin: 'paper-bin', info: 'Cardboard boxes can be recycled in the paper bin.' }
            ]
        };

        // Handle the drag and drop functionality
        document.querySelectorAll('.bin').forEach(bin => {
            bin.addEventListener('dragover', dragOver);
            bin.addEventListener('drop', dropItem);
        });

        function dragStart(event) {
            event.dataTransfer.setData('text', event.target.id);
        }

        function dragOver(event) {
            event.preventDefault();
        }

        function dropItem(event) {
            event.preventDefault();
            const wasteItemId = event.dataTransfer.getData('text');
            const wasteItem = document.getElementById(wasteItemId);

            // Find the correct bin for the waste item
            const currentItems = stages[currentStage];
            const item = currentItems.find(i => i.id === wasteItemId);
            if (event.target.id === item.bin) {
                event.target.appendChild(wasteItem);
                score += 10;
                document.getElementById('score').innerText = `Score: ${score}`;
                wasteItem.remove();  // Remove item once correctly sorted
            } else {
                score -= 5;
                document.getElementById('score').innerText = `Score: ${score}`;
                showWrongPopup(item);
            }

            checkCompletion();
        }

        // Check if all items in the stage are sorted correctly
        function checkCompletion() {
            const wasteItems = document.querySelectorAll('.waste');
            if (wasteItems.length === 0) {
                showPopup();
            }
        }

        // Show the popup message for correct sorting
        function showPopup() {
            document.getElementById('popup').style.display = 'block';
            document.getElementById('popup-overlay').style.display = 'block';
        }

        // Close the correct sorting popup and show the next stage button
        function closePopup() {
            document.getElementById('popup').style.display = 'none';
            document.getElementById('popup-overlay').style.display = 'none';
            document.getElementById('next-stage-btn').style.display = 'block';
        }

        // Show the wrong sorting popup with information
        function showWrongPopup(item) {
            document.getElementById('wrong-popup-message').innerText = item.info;
            document.getElementById('wrong-popup').style.display = 'block';
            document.getElementById('wrong-popup-overlay').style.display = 'block';
        }

        // Close the wrong sorting popup
        function closeWrongPopup() {
            document.getElementById('wrong-popup').style.display = 'none';
            document.getElementById('wrong-popup-overlay').style.display = 'none';
        }

        // Load the next stage
        function nextStage() {
            currentStage++;
            if (currentStage > Object.keys(stages).length) {
                document.getElementById('stage-message').innerText = 'Congratulations! You have completed all stages!';
                document.getElementById('next-stage-btn').style.display = 'none';
                return;
            }

            document.getElementById('stage-message').innerText = `Stage ${currentStage}`;
            document.getElementById('next-stage-btn').style.display = 'none';
            loadStage(currentStage);
        }

        // Load waste items for the current stage
        function loadStage(stage) {
            const wasteContainer = document.getElementById('waste-items');
            wasteContainer.innerHTML = '';  // Clear previous items

            stages[stage].forEach(item => {
                const wasteDiv = document.createElement('div');
                wasteDiv.className = 'waste';
                wasteDiv.id = item.id;
                wasteDiv.draggable = true;
                wasteDiv.innerText = item.name;
                wasteDiv.addEventListener('dragstart', dragStart);
                wasteContainer.appendChild(wasteDiv);
            });
        }

        // Initialize the first stage
        loadStage(currentStage);
        function submitScore(score) {
    const xhr = new XMLHttpRequest();
    xhr.open("POST", "RecycleRush.php", true);
    xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    
    xhr.onreadystatechange = function() {
        if (xhr.readyState == 4 && xhr.status == 200) {
            alert("Score submitted successfully!");
            // Optionally redirect to the dashboard
            window.location.href = 'dashboard.php';
        }
    };
    
    xhr.send("score=" + score);
}
// Function to handle game end and score submission using AJAX
function gameEnd(score) {
    // Create an XMLHttpRequest object
    var xhr = new XMLHttpRequest();

    // Prepare the request
    xhr.open("POST", "updateScore.php", true);
    xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");

    // Create the data to send
    var data = "score=" + encodeURIComponent(score);

    // Send the request with the score
    xhr.send(data);

    // Optional: Handle the response (if needed)
    xhr.onreadystatechange = function() {
        if (xhr.readyState == 4 && xhr.status == 200) {
            console.log("Score updated successfully");
            // You can also refresh the dashboard or update it dynamically here
        }
    };
}
gameEnd(100);

    </script>
</body>
</html>
