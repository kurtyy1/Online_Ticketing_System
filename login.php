<?php  
session_start();
ob_start();
include('header.php');
include('admin/db_connect.php');
// Check if the form is submitted
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['login'])) {
  // Get username and password from the form
  $username = $_POST['username'];
  $password = $_POST['password'];

  // Validate user credentials against the database
  $stmt = $conn->prepare("SELECT * FROM users WHERE username = ?");
  $stmt->bind_param("s", $username);
  $stmt->execute();
  $result = $stmt->get_result();
  $row = $result->fetch_assoc();

  // Verify the password
  if ($row && password_verify($password, $row['password'])) {
      // Successful login
      $_SESSION['user_id'] = $row['user_id'];
      // Redirect to the index page or any other authorized page
      header("Location: index.php");
      exit();
  } else {
      // Invalid login credentials, display an error message
      echo '<script>alert("Invalid username or password.");</script>';
  }

  $stmt->close();
}
 ?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">
  <title>Online Ticketing System</title>

  <!-- Add your stylesheets and scripts here -->

  <style>
    body {
      margin: 0;
      padding: 0;
      font-family: Arial, sans-serif;
      background: #007bff;
    }

    main {
      display: flex;
      height: 100vh;
    }

    #login-left {
      position: absolute;
      left: 0;
      width: 60%;
      height: calc(100%);
      background: #59b6ec61;
      display: flex;
      align-items: center;
      background: url(assets/img/travel-cover.jpg);
      background-repeat: no-repeat;
      background-size: cover;
    }

    #login-right {
      position: absolute;
      right: 0;
      width: 40%;
      height: calc(100%);
      background: white;
      display: flex;
      align-items: center;
    }

    .card {
      margin: auto;
      z-index: 1
    }

    button {
      width: 100%;
      padding: 10px;
      margin-top: 10px;
      background-color: #007bff;
      color: #fff;
      border: none;
      cursor: pointer;
    }

    div#login-left::before,
    div#login-right::before {
      content: "";
      position: absolute;
      top: 0;
      left: 0;
      width: calc(100%);
      height: calc(100%);
      background: #00c4ff36;
    }
    .logo {
    margin: auto;
    font-size: 8rem;
    background: white;
    padding: .02em 0.05em;
    border-radius: 50%;
    color: #000000b3;
    z-index: 10;
}
  </style>
</head>

<body>

  <main>
    <div id="login-left">
      <div class="logo">
        <img src="assets/img/htm.png">
      </div>
    </div>
    <div id="login-right">
      <div class="card">
      <form id="login-form" method="post" action="index.php">
        <div>
          <label for="username">Username</label>
          <input type="text" id="username" name="username" required autocomplete="username">
        </div>
        <div>
          <label for="password">Password</label>
          <input type="password" id="password" name="password" required autocomplete="current-password">
        </div>
        <button type="submit" name="login">Login</button>
      </form>

        <div>
          <!-- Add signup button with a link to the signup page -->
          <button onclick="window.location.href='signup.php'">Signup</button>
        </div>
      </div>
    </div>
  </main>

  <script>
    function login() {
      // Perform login logic here using JavaScript
      var username = document.getElementById('username').value;
      var password = document.getElementById('password').value;

      // Implement your login logic (check credentials)

      // For demonstration purposes, redirect to a hypothetical index.php
      window.location.href = 'index.php';
    }
  </script>
</body>

</html>
