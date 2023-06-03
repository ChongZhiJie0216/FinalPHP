<?php
// Get the user input
$host = $_POST['host'];
$username = $_POST['username'];
$password = $_POST['password'];
$database = $_POST['database'];

// Connect to the database
$conn = new mysqli($host, $username, $password);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Create the database if it doesn't exist
$sql = "CREATE DATABASE IF NOT EXISTS $database";
if ($conn->query($sql) === FALSE) {
    die("Error creating database: " . $conn->error);
}

// Select the database
$conn->select_db($database);

// Create the admin_account table if it doesn't exist
$sql = "CREATE TABLE IF NOT EXISTS admin_account (
  id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  username VARCHAR(30) NOT NULL,
  password VARCHAR(30) NOT NULL
)";
if ($conn->query($sql) === FALSE) {
    die("Error creating admin_account table: " . $conn->error);
}

// Create the user_account table if it doesn't exist
$sql = "CREATE TABLE IF NOT EXISTS user_account (
  id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  username VARCHAR(30) NOT NULL,
  password VARCHAR(30) NOT NULL
)";
if ($conn->query($sql) === FALSE) {
    die("Error creating user_account table: " . $conn->error);
}

// Create the student table if it doesn't exist
  $sql = "CREATE TABLE IF NOT EXISTS student (
    stu_id INT(20),
    stu_name VARCHAR(20),
    stu_age INT,
    stu_gender VARCHAR(10),
    stu_address VARCHAR(50),
    stu_photo VARCHAR(255) -- New column for storing the student picture location
    PRIMARY KEY (stu_id)
  )";
if ($conn->query($sql) === FALSE) {
  die("Error creating user_account table: " . $conn->error);
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

// Redirect the user to the adminRegistration.html file
header("Location: ./funtion/adminRegistration/index.php");
exit();
?>
