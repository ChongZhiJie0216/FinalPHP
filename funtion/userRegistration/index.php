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
    $stmt = $conn->prepare("INSERT INTO user_account (username, password) VALUES (?, ?)");
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
  <link rel="stylesheet" type="text/css" href="styles.css" />
</head>

<body>
  <div class="login-container">
    <h2>User Register</h2>
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
