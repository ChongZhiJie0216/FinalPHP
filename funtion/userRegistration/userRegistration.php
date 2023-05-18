<?php
include $_SERVER['DOCUMENT_ROOT'] . '/Assignment03/config.php';

// Get the user input
$username = $_POST['username'];
$password = $_POST['password'];

// Select the cpss database
$conn->select_db($database);

// Create the admin_account table if it doesn't exist
$sql = "CREATE TABLE IF NOT EXISTS user_account (
  id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  username VARCHAR(30) NOT NULL,
  password VARCHAR(30) NOT NULL
)";
if ($conn->query($sql) === FALSE) {
  die("Error creating table: " . $conn->error);
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

// Redirect to the main page after successful registration
header("Location: ../directpage.html");
exit();
?>
