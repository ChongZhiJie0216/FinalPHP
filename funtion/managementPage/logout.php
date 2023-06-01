<?php
session_start(); // Start the session

// Destroy the session
session_destroy();

// Clear the username cookie
setcookie('username', '', time() - 3600, '/');

// Redirect the user to the login page
header("Location: ../directpage.html");
exit;
?>