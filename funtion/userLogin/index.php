<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta http-equiv="X-UA-Compatible" content="IE=edge" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Student_Information System</title>
  <link rel="stylesheet" type="text/css" href="styles.css" />
</head>

<body>
  <?php
  include_once $_SERVER['DOCUMENT_ROOT'] . '/Assignment03/config.php';

  $username = isset($_POST['username']) ? $_POST['username'] : '';
  $password = isset($_POST['password']) ? $_POST['password'] : '';
  $message = ""; // Variable to store the error message

  if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Prepare SQL statement
    $stmt = $conn->prepare("SELECT * FROM user_account WHERE username = ? AND password = ?");
    $stmt->bind_param("ss", $username, $password);
    $stmt->execute();
    $result = $stmt->get_result();

    // Check if a row was returned
    if ($result->num_rows == 1) {
      // Login successful
      // Set a cookie named "username" with the value of the logged-in username
      setcookie("username", $username, time() + (86400 * 30), "/"); // Cookie expires in 30 days

      header("Location: ../userPage/index.php");
      exit;
    } else {
      // Login failed
      $message = "Invalid username or password";
    }

    // Close database connection
    $stmt->close();
    $conn->close();
  }
  ?>
  <center>
    <h1>Student_Information System</h1>
  </center>
  <div class="login-container">
    <h2>User Login</h2>
    <form method="post">
      <div class="form-group">
        <label for="username">Username</label>
        <input type="text" id="username" name="username" required />
      </div>
      <div class="form-group">
        <label for="password">Password</label>
        <input type="password" id="password" name="password" required />
      </div>
      <button type="submit">Login</button>
    </form>
    <p class="error-message"><?php echo $message; ?></p> <!-- Display error message -->
  </div>
</body>

</html>