<?php
$message = ''; 

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
    if ($conn->connect_error) {
      die("Connection failed: " . $conn->connect_error);
    }

    $stmt = $conn->prepare("INSERT INTO admin_account (username, password) VALUES (?, ?)");
    $stmt->bind_param("ss", $username, $password);

    if ($stmt->execute() === FALSE) {
      die("Error registering account: " . $stmt->error);
    }

    $stmt->close();
    $conn->close();

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
