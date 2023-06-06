<?php
function cookieze($name, $value, $expiry = 2592000, $path = '/') {
  setcookie($name, $value, time() + $expiry, $path);
}

include_once $_SERVER['DOCUMENT_ROOT'] . '/Assignment03/config.php';

$username = isset($_POST['username']) ? $_POST['username'] : '';
$password = isset($_POST['password']) ? $_POST['password'] : '';
$message = ""; 

if ($_SERVER["REQUEST_METHOD"] == "POST") {
  $stmt = $conn->prepare("SELECT * FROM admin_account WHERE username = ? AND password = ?");
  $stmt->bind_param("ss", $username, $password);
  $stmt->execute();
  $result = $stmt->get_result();

  if ($result->num_rows == 1) {
    cookieze("username", $username, 2592000, "/");

    header("Location: ../managementPage/index.php");
    exit;
  } else {
    $message = "Invalid username or password";
  }

  $stmt->close();
  $conn->close();
}
?>
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
    <p class="error-message"><?php echo $message; ?></p>
  </div>
</body>

</html>
