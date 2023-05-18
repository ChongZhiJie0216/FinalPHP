<?php
include $_SERVER['DOCUMENT_ROOT'] . '/Assignment03/config.php';

$username = $_POST['username'];
$password = $_POST['password'];

// Prepare SQL statement
$stmt = $conn->prepare("SELECT * FROM admin_account WHERE username = ? AND password = ?");
$stmt->bind_param("ss", $username, $password);
$stmt->execute();
$result = $stmt->get_result();

// Check if a row was returned
if ($result->num_rows == 1) {
  // Login successful
  header("Location: ../managementPage/index.html");
} else {
  // Login failed
  echo "Invalid username or password";
}

// Close database connection
$stmt->close();
$conn->close();
