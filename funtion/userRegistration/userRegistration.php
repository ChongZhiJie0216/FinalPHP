<?php
include $_SERVER['DOCUMENT_ROOT'] . '/Assignment03/config.php';

// Get the user input
$username = $_POST['username'];
$password = $_POST['password'];

// Select the cpss database
$conn->select_db($database);

// Connect to the existing user_account table
$sql = "SELECT * FROM user_account";
$result = $conn->query($sql);

// Check if the table exists
if (!$result) {
  die("Error connecting to table: " . $conn->error);
}

// Prepare the SQL statement to insert the user's registration information into the user_account table
$stmt = $conn->prepare("INSERT INTO user_account (username, password) VALUES (?, ?)");
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
