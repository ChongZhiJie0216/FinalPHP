<?php
session_start(); // Start the session

session_destroy();

setcookie('username', '', time() - 3600, '/');

header("Location: ../directpage.html");
exit;
?>