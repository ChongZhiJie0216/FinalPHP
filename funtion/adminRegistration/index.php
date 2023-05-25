<?php
$message = ''; // Initialize the error message

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  include $_SERVER['DOCUMENT_ROOT'] . '/Assignment03/config.php';

  // Get the user input
  $username = $_POST['username'];
  $password = $_POST['password'];
  $confirmPassword = $_POST['confirm_password'];
  
  // Validate password
  if ($password !== $confirmPassword) {
    $message = "Password and Retype Password do not match";
  } else {
    // Check connection
    if ($conn->connect_error) {
      die("Connection failed: " . $conn->connect_error);
    }

    // Prepare the SQL statement to insert the user's registration information into the admin_account table
    $stmt = $conn->prepare("INSERT INTO admin_account (username, password) VALUES (?, ?)");
    $stmt->bind_param("ss", $username, $password);

    // Execute the prepared statement
    if ($stmt->execute() === FALSE) {
      die("Error registering account: " . $stmt->error);
    }

    // Close the prepared statement
    $stmt->close();
    $conn->close();

    // Redirect to the main page after successful registration
    header("Location: ../directpage.html");
    exit();
  }
}
?>

<!DOCTYPE html>
<html>

<head>
  <meta charset="UTF-8" />
  <meta http-equiv="X-UA-Compatible" content="IE=edge" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Student Information System</title>
  <style>
    body {
      font-family: Arial, sans-serif;
      background-color: #f2f2f2;
      margin: 0;
      padding: 0;
    }

    .login-container {
      background-color: #fff;
      width: 300px;
      padding: 20px;
      margin: 100px auto;
      border-radius: 5px;
      box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
    }

    .login-container h2 {
      text-align: center;
    }

    .form-group {
      margin-bottom: 20px;
    }

    .form-group label {
      display: block;
      margin-bottom: 5px;
    }

    .form-group input {
      width: 100%;
      padding: 5px;
      border: 1px solid #ccc;
      border-radius: 3px;
    }

    button[type="submit"] {
      display: block;
      width: 100%;
      padding: 10px;
      border: none;
      background-color: #4caf50;
      color: #fff;
      font-size: 16px;
      font-weight: bold;
      border-radius: 3px;
      cursor: pointer;
    }

    button[type="submit"]:hover {
      background-color: #45a049;
    }

    .error-message {
      color: red;
      text-align: center;
    }
  </style>
</head>

<body>
  <div class="login-container">
    <h2>Admin Register</h2>
    <form method="post" action="">
      <div class="form-group">
        <label for="username">Username</label>
        <input type="text" id="username" name="username" required />
      </div>
      <div class="form-group">
        <label for="password">Password</label>
        <input type="password" id="password" name="password" required />
      </div>
      <div class="form-group">
        <label for="confirm-password">Retype Password</label>
        <input type="password" id="confirm-password" name="confirm_password" required />
      </div>
      <button type="submit">Register</button>
    </form>
    <p class="error-message"><?php echo $message; ?></p>
  </div>
</body>

</html>
