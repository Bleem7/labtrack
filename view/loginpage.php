<?php
  session_start();
  if(isset($_SESSION['Username'])){
    unset($_SESSION['UserID']);
    unset($_SESSION['Username']);
    session_destroy();
  }
?>


<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Login | Lab-Track</title>
  <link rel="stylesheet" href="../css/loginpage.css">
</head>
<body>
  <div class="container">
    <div class="login-container">
        <h2>Login to <span class="blue-text">Lab-Track</span></h2>
      <form action = "../Login/loginphp.php" name = "login"id = "login" method="POST">
        <div class="form-group">
          <label for="username">Username</label>
          <input type="text" id="username" name="username" placeholder="Enter your username" required>
        </div>
        <div class="form-group">
          <label for="password">Password</label>
          <input type="password" id="password" name="password" placeholder="Enter your password" required>
        </div>
        <button type="submit">Login</button>
      </form>
      <p>Don't have an account? <a href="registerpage.html">Register here</a></p>
    </div>
  </div>
</body>
</html>
