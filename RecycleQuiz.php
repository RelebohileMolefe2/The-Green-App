<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Recycling Quiz Game</title>
    <style>
        body {
            font-family: 'Montserrat', sans-serif;
            background: linear-gradient(135deg, #004d00, #66ff66, #009900);
            background-size: 200% 200%;
            animation: gradientAnimation 15s ease infinite;
            display: flex;
            flex-direction: column;
            align-items: center;
            padding: 20px;
            height: 100vh;
            margin: 0;
        }

        @keyframes gradientAnimation {
            0% { background-position: 0% 50%; }
            50% { background-position: 100% 50%; }
            100% { background-position: 0% 50%; }
        }

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
            color: #004d00;
            text-shadow: 2px 2px 8px rgba(0, 0, 0, 0.5);
            margin-bottom: 10px;
            font-size: 2.5em;
            letter-spacing: 1px;
        }

        p {
            font-size: 1.5em;
            color: #333;
            margin-bottom: 20px;
            text-align: center;
        }

        .quiz-container {
            display: none; /* Keep it hidden until the quiz starts */
            margin-top: 20px;
            padding: 20px;
            border-radius: 15px;
            background-color: rgba(144, 238, 144, 0.3);
            box-shadow: 0 8px 30px rgba(0, 0, 0, 0.2);
            transition: transform 0.3s;
            max-width: 600px; /* Limit width for better readability */
            text-align: center; /* Center align text */
        }

        #quiz-question {
            font-size: 1.8em; /* Increase font size for questions */
            color: #004d00; /* Use a contrasting color */
            margin-bottom: 20px; /* Add some spacing below the question */
        }

        .quiz-option {
            margin: 10px 0;
            padding: 15px;
            border: none;
            border-radius: 10px;
            cursor: pointer;
            background-color: #e7f9f7;
            color: #004d00;
            font-size: 1.2em;
            transition: background-color 0.3s, transform 0.3s;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
            width: 100%; /* Make buttons full width */
        }

        .quiz-option:hover {
            background-color: #cceee0;
            transform: translateY(-2px);
        }

        #quiz-score {
            font-weight: bold;
            color: #333;
            font-size: 1.2em;
            margin-top: 20px; /* Add spacing above the score */
        }

        #next-stage-message {
            display: none;
            font-size: 1.5em;
            color: #004d00;
            margin-top: 20px;
        }

        .popup {
            display: none;
            position: fixed;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            background: white;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 0 20px rgba(0, 0, 0, 0.3);
            z-index: 1000;
            text-align: center;
            display: flex; /* Added flex display */
            flex-direction: column; /* Stack children vertically */
            align-items: center; /* Center children horizontally */
            justify-content: center; 
        }

        .overlay {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.5);
            z-index: 999;
        }

        .btn {
            margin-top: 10px;
            padding: 12px 25px;
            background-color: #008000;
            color: white;
            border: none;
            border-radius: 8px;
            cursor: pointer;
            font-size: 1em;
            transition: background-color 0.3s, transform 0.3s;
        }

        .btn:hover {
            background-color: #005700;
            transform: scale(1.05);
        }

        /* Cartoon Character Styles */
        .dancing, .crying { /* Combine styles for both characters */
            display: none;
            width: 150px;
            animation: dance 1s infinite alternate;
            margin-top: 20px; /* Add some spacing above */
        }

        @keyframes dance {
            0% { transform: translateY(0); }
            100% { transform: translateY(-15px); }
        }

        @keyframes cry {
            0% { transform: translateY(0); }
            100% { transform: translateY(15px); }
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
                <li><a href="dashboard.php">Game Dashboard</a></li>
                <li><a href="profile.php">Profile</a></li>
            </ul>
        </div>
    </nav>
</header>
<h1>Recycling Quiz Game</h1>
<p>Test your knowledge about recycling and the environment!</p>
<button class="btn" onclick="startQuiz()">Start Quiz</button>

<div class="quiz-container">
    <h2 id="quiz-question"></h2>
    <div id="quiz-options"></div>
    <div id="quiz-score">Score: 0</div>
    <div id="next-stage-message"></div> <!-- New message element -->
    <img id="happy-cartoon" class="dancing" src="happy.jpg" alt="Happy Cartoon">
    <img id="sad-cartoon" class="crying" src="sad.jpg" alt="Sad Cartoon">
</div>

<script>
    let score = 0;
    let currentStage = 1;
    let questionIndex = 0;
    let totalQuestions = 5;

    const quizQuestions = {
        1: [
            {
                question: "What is recycling?",
                options: ["Turning waste into new products", "Throwing waste in the trash", "Composting waste", "Burning waste"],
                answer: 0
            },
            {
                question: "Why is recycling important?",
                options: ["Reduces waste in landfills", "Increases pollution", "Wastes resources", "None of the above"],
                answer: 0
            },
            {
                question: "What can be recycled?",
                options: ["Glass", "Plastic", "Metal", "All of the above"],
                answer: 3
            },
            {
                question: "How does recycling help the environment?",
                options: ["Reduces pollution", "Saves energy", "Conserves resources", "All of the above"],
                answer: 3
            },
            {
                question: "What happens if you don't recycle?",
                options: ["Waste goes to landfills", "Waste is burned", "Both A and B", "None of the above"],
                answer: 2
            },
        ],
        2: [
            {
                question: "Which gas is emitted from landfills?",
                options: ["Oxygen", "Methane", "Nitrogen", "Carbon Dioxide"],
                answer: 1
            },
            {
                question: "What is a health hazard of not recycling?",
                options: ["Increased pollution", "Toxic waste", "Contaminated water", "All of the above"],
                answer: 3
            },
            {
                question: "What does global warming do to the planet?",
                options: ["Cools the Earth", "Heats the Earth", "Keeps the Earth stable", "None of the above"],
                answer: 1
            },
            {
                question: "How much energy can recycling save?",
                options: ["10%", "20%", "30%", "Up to 95%"],
                answer: 3
            },
            {
                question: "What is the impact of plastic waste on oceans?",
                options: ["Helps marine life", "Harms marine life", "Has no impact", "Creates jobs"],
                answer: 1
            },
        ],
        3: [
            {
                question: "What is one way to reduce waste?",
                options: ["Recycle more", "Throw everything away", "Burn waste", "Ignore it"],
                answer: 0
            },
            {
                question: "Which of the following is not recyclable?",
                options: ["Glass bottles", "Plastic containers", "Styrofoam cups", "Aluminum cans"],
                answer: 2
            },
            {
                question: "What does e-waste refer to?",
                options: ["Old electronics", "Food waste", "Metal waste", "Plastic waste"],
                answer: 0
            },
            {
                question: "What should be done with batteries?",
                options: ["Throw them in the trash", "Recycle them", "Burn them", "None of the above"],
                answer: 1
            },
            {
                question: "What is composting?",
                options: ["Turning organic waste into soil", "Burning waste", "Throwing waste in the trash", "None of the above"],
                answer: 0
            },
        ],
        4: [
            {
                question: "What type of plastic is commonly recycled?",
                options: ["PET", "PVC", "Polystyrene", "All of the above"],
                answer: 0
            },
            {
                question: "What is a recycling center?",
                options: ["A place to collect recyclables", "A trash dump", "A compost site", "None of the above"],
                answer: 0
            },
            {
                question: "Which material takes the longest to decompose?",
                options: ["Paper", "Food waste", "Plastic", "Metal"],
                answer: 2
            },
            {
                question: "What is a benefit of recycling paper?",
                options: ["Saves trees", "Uses more energy", "Pollutes water", "None of the above"],
                answer: 0
            },
        ],
        5: [
            {
                question: "What is the recycling symbol?",
                options: ["A triangle with arrows", "A square", "A circle", "None of the above"],
                answer: 0
            },
            {
                question: "How does recycling help the economy?",
                options: ["Creates jobs", "Costs money", "Decreases profits", "None of the above"],
                answer: 0
            },
            {
                question: "What should you do with food waste?",
                options: ["Throw it in the trash", "Compost it", "Burn it", "None of the above"],
                answer: 1
            },
            {
                question: "What is the role of government in recycling?",
                options: ["Encourages recycling programs", "Ignores it", "Wastes money", "None of the above"],
                answer: 0
            },
            {
                question: "Which of the following is a recyclable metal?",
                options: ["Steel", "Iron", "Aluminum", "All of the above"],
                answer: 3
            },
        ],
    };

    function startQuiz() {
        score = 0;
        questionIndex = 0;
        currentStage = 1;
        document.querySelector(".quiz-container").style.display = "block";
        document.getElementById("quiz-score").innerText = `Score: ${score}`;
        loadQuestion();
    }

    function loadQuestion() {
        if (questionIndex < totalQuestions) {
            const questionData = quizQuestions[currentStage][questionIndex];
            document.getElementById("quiz-question").innerText = questionData.question;
            const optionsHtml = questionData.options.map((option, index) => 
                `<button class="quiz-option" onclick="answerQuestion(${index})">${option}</button>`
            ).join("");
            document.getElementById("quiz-options").innerHTML = optionsHtml;
        } else {
            endStage();
        }
    }

    function answerQuestion(selectedIndex) {
        const questionData = quizQuestions[currentStage][questionIndex];
        document.getElementById("happy-cartoon").style.display = "none";
        document.getElementById("sad-cartoon").style.display = "none";

        if (selectedIndex === questionData.answer) {
            score++;
            document.getElementById("happy-cartoon").style.display = "block";
        } else {
            document.getElementById("sad-cartoon").style.display = "block";
        }

        questionIndex++;
        document.getElementById("quiz-score").innerText = `Score: ${score}`;
        
        loadQuestion();
    }

    function endStage() {
        if (currentStage < 5) {
            const nextStageMessage = document.getElementById("next-stage-message");
            nextStageMessage.innerText = `Great job! Moving to Stage ${currentStage + 1}...`;
            nextStageMessage.style.display = "block";

            // Hide the message after a delay, then load the next stage
            setTimeout(() => {
                nextStageMessage.style.display = "none";
                currentStage++;
                questionIndex = 0; // Reset question index for the new stage
                loadQuestion(); // Load the first question of the new stage
            }, 2000); // 2 seconds delay
        } else {
            document.querySelector(".quiz-container").style.display = "none";
            alert(`Quiz completed! Your final score is ${score}/${totalQuestions * 5}.`);
        }
    }
    function endStage() {
    if (currentStage < 5) {
        const nextStageMessage = document.getElementById("next-stage-message");
        nextStageMessage.innerText = `Great job! Moving to Stage ${currentStage + 1}...`;
        nextStageMessage.style.display = "block";

        // Show the popup for validation
        showPopup(`Great job! You completed Stage ${currentStage}. Moving to Stage ${currentStage + 1}...`);

        // Load the next stage after the popup is closed
        setTimeout(() => {
            nextStageMessage.style.display = "none";
            currentStage++;
            questionIndex = 0; // Reset question index for the new stage
            loadQuestion(); // Load the first question of the new stage
        }, 3000); // 3 seconds delay to keep the popup visible
    } else {
        document.querySelector(".quiz-container").style.display = "none";
        alert(`Quiz completed! Your final score is ${score}/${totalQuestions * 5}.`);
    }
}

function showPopup(message) {
    const popup = document.createElement("div");
    popup.className = "popup";
    popup.innerHTML = `<p>${message}</p><button class="btn" onclick="closePopup()">Close</button>`;
    
    // Add overlay to the body
    const overlay = document.createElement("div");
    overlay.className = "overlay";
    
    document.body.appendChild(overlay);
    document.body.appendChild(popup);

    // Display the popup and overlay
    overlay.style.display = "block";
    popup.style.display = "flex";
}

function closePopup() {
    const overlay = document.querySelector(".overlay");
    const popup = document.querySelector(".popup");
    
    if (overlay) overlay.remove();
    if (popup) popup.remove();
}

</script>
</body>
</html>
