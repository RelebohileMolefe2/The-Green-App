<?php 
  session_start();
  // Check if user is logged in
  if (!isset($_SESSION['username'])) {
    header('location: login.php');
    exit();
  }
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>GreenHub - Game Dashboard</title>
  <link rel="stylesheet" href="style.css">
</head>
<body>
  <div class="header">
    <h2>Game Dashboard</h2>
  </div>
  
  <div class="container">
    <h3>Available Games</h3>
    <ul>
      <li><a href="drag_and_drop_game.php">Drag and Drop Recycling Game</a></li>
      <li><a href="quiz_game.php">Recycling Quiz Game</a></li>
    </ul>
  </div>
</body>
</html>
