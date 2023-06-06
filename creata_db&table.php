<?php
$host = $_POST['host'];
$username = $_POST['username'];
$password = $_POST['password'];
$database = $_POST['database'];

$conn = new mysqli($host, $username, $password);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$sql = "CREATE DATABASE IF NOT EXISTS `$database`";
if ($conn->query($sql) === FALSE) {
    die("Error creating database: " . $conn->error);
}

$conn->select_db($database);

$sql = "CREATE TABLE IF NOT EXISTS `admin_account` (
  `id` INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  `username` VARCHAR(30) NOT NULL,
  `password` VARCHAR(30) NOT NULL
)";
if ($conn->query($sql) === FALSE) {
    die("Error creating admin_account table: " . $conn->error);
}

$sql = "CREATE TABLE IF NOT EXISTS `user_account` (
  `id` INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  `username` VARCHAR(30) NOT NULL,
  `password` VARCHAR(30) NOT NULL
)";
if ($conn->query($sql) === FALSE) {
    die("Error creating user_account table: " . $conn->error);
}

$sql = "CREATE TABLE IF NOT EXISTS `student` (
  `stu_id` INT(20) PRIMARY KEY,
  `stu_name` VARCHAR(20),
  `stu_age` INT,
  `stu_gender` VARCHAR(10),
  `stu_address` VARCHAR(255),
  `stu_photo` VARCHAR(255)
)";
if ($conn->query($sql) === FALSE) {
    die("Error creating student table: " . $conn->error);
}

$config = "<?php\n";
$config .= "\$host = '" . $host . "';\n";
$config .= "\$username = '" . $username . "';\n";
$config .= "\$password = '" . $password . "';\n";
$config .= "\$database = '" . $database . "';\n";
$config .= "\$conn = new mysqli(\$host, \$username, \$password, \$database);\n";
$config .= "?>";

$file = fopen("config.php", "w") or die("Unable to open file!");
fwrite($file, $config);
fclose($file);

$conn->close();

header("Location: ./funtion/adminRegistration/index.php");
exit();
?>
