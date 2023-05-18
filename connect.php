<?php
// Get the user input
$host = $_POST['host'];
$username = $_POST['username'];
$password = $_POST['password'];
$database = $_POST['database'];

// Connect to the database
$conn = new mysqli($host, $username, $password);

$sql = "CREATE DATABASE IF NOT EXISTS $database";
if ($conn->query($sql) === FALSE) {
	die("Error creating database: " . $conn->error);
}

// Check for errors
if ($conn->connect_error) {
	die("Connection failed: " . $conn->connect_error);
}

// Save the connection information to a config.php file
$config = "<?php\n";
$config .= "\$host = '" . $host . "';\n";
$config .= "\$username = '" . $username . "';\n";
$config .= "\$password = '" . $password . "';\n";
$config .= "\$database = '" . $database . "';\n";
$config .= "\$conn = new mysqli(\$host, \$username, \$password, \$database);\n";
$config .= "?>";

// Save the config.php file
$file = fopen("config.php", "w") or die("Unable to open file!");
fwrite($file, $config);
fclose($file);

// Close the database connection
$conn->close();

// Redirect the user to the index.php file
header("Location: ./funtion/adminRegistration/adminRegistration.html");
exit();
?>
