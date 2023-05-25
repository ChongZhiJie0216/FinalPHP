<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Student Information System</title>
</head>
<body>
  <center>
    <?php
    session_start(); // Start the session
    // Check if the "username" cookie is set
    if (isset($_COOKIE['username'])) {
        $loggedInUsername = $_COOKIE['username'];

        // Display the personalized welcome message
        echo "<h1>Welcome, " . $loggedInUsername . "</h1>";
    }
    ?>
  </center>
</body>
</html>
