<!DOCTYPE html>
<html>
<head>
    <title>GreenHubber</title>
    <style>
    body {
  font-family: Arial, sans-serif;
  margin: 0;
  padding: 0;
}
body {
    background-image: url("backg.jpg");
    background-size: 100% auto; 
    background-repeat: no-repeat;
    background-attachment: fixed;
    
}
.header {
  display: flex;
  justify-content: space-between;
  align-items: center;
  padding: 15px;
  background-color: transparent;
  color: #fff;
}

.logo {
  height: 50px;
}
.logo img {
    height: 50px;
    width: auto;
}

.button-group {
  float: right;
  display: flex;
  gap: 10px;
}

.button-group button {
  padding: 10px 20px;
  background-color: #4CAF50;
  color: #fff;
  border: none;
  cursor: pointer;
}

.centered-h2 {
  text-align: center;
  margin-top: 40px;
  margin-bottom: 20px;
  color: #AAFF00;
  font-size: 30px;
}
p {
    text-align: center;
    margin-top: 20px;
    color: white;

  }
.btn {
  display: block;
  margin: 20px auto;
  padding: 15px 30px;
  background-color: #4CAF50;
  color: #fff;
  border: none;
  cursor: pointer;
}
</style>
</head>
<body>
    <div class="header">
        <div class="logo">
            <img src="icon.jpg" alt="Logo">
        </div>
        <div class="button-group">
            <button id="registerBtn">Register</button>
            <button id="loginBtn">Login</button>
        </div>
    </div>

    <h2 class="centered-h2">Simplify Your Recycling Today! With GreenHub</h2>
    <p>Make recycling effortless in Cape Town! Create an account to learn more about your waste.</p>
    <p>Turn your waste into opportunities with just few taps.</p>
    <button type="button" class="btn" onclick="redirectToLocation()">Recycle Now</button>
</body>
<script>
    const registerBtn = document.getElementById('registerBtn');
    const loginBtn = document.getElementById('loginBtn');

    registerBtn.addEventListener('click', () => {
        window.location.href = 'register.php';
    });

    loginBtn.addEventListener('click', () => {
        window.location.href = 'login.php';
    });

    function redirectToLocation() {
        window.location.href = "restricted.php";
    }
</script>
</html>