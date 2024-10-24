<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>GreenHub - Login Required</title>
    <style>
        body {
            margin: 0;
            height: 100vh;
            background-image: url("backg.jpg"); /* Replace with your image path */
            background-size: cover;
            background-position: center;
            display: flex;
            justify-content: center;
            align-items: center;
            color: white;
            font-family: Arial, sans-serif;
        }

        .message {
            text-align: center;
            padding: 20px;
            border-radius: 8px;
        }

        .back-button {
            position: absolute;
            top: 20px;
            right: 20px;
            padding: 10px 20px;
            background-color: #28a745;
            color: white;
            border: none;
            border-radius: 5px;
            text-decoration: none;
            font-size: 16px;
        }

        .back-button:hover {
            background-color: #218838;
        }
    </style>
</head>
<body>
    <div class="message">
        <h2 style="font-color: #AAFF00;">Access Restricted</h2>
        <p>The GreenHubber needs to log in first before they can access the page.</p>
    </div>
    <a href="index.php" class="back-button">Back to Index</a>
</body>
</html>
