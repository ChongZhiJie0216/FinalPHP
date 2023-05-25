<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta http-equiv="X-UA-Compatible" content="IE=edge" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Student_Information System</title>
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
  <?php
  include_once $_SERVER['DOCUMENT_ROOT'] . '/Assignment03/config.php';

  $username = isset($_POST['username']) ? $_POST['username'] : '';
  $password = isset($_POST['password']) ? $_POST['password'] : '';
  $message = ""; // Variable to store the error message

  if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Prepare SQL statement
    $stmt = $conn->prepare("SELECT * FROM admin_account WHERE username = ? AND password = ?");
    $stmt->bind_param("ss", $username, $password);
    $stmt->execute();
    $result = $stmt->get_result();

    // Check if a row was returned
    if ($result->num_rows == 1) {
      // Login successful
      // Set a cookie named "username" with the value of the logged-in username
      setcookie("username", $username, time() + (86400 * 30), "/"); // Cookie expires in 30 days

      header("Location: ../managementPage/index.php");
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
    <h2>Admin Login</h2>
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