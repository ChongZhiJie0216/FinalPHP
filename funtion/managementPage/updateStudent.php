<?php
include_once $_SERVER['DOCUMENT_ROOT'] . '/Assignment03/config.php';

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] === "POST") {
  // Get the form data
  $stuId = $_POST['stu_id'];
  $stuAge = $_POST['stu_age'];
  $stuName = $_POST['stu_name'];
  $stuGender = $_POST['stu_gender'];
  $stuAddress = $_POST['stu_address'];

  // Check if a new photo is uploaded
  if (isset($_FILES['photo']) && $_FILES['photo']['error'] === UPLOAD_ERR_OK) {
    $fileTmpPath = $_FILES['photo']['tmp_name'];
    $fileName = $_FILES['photo']['name'];
    $fileSize = $_FILES['photo']['size'];
    $fileType = $_FILES['photo']['type'];

    // Move the uploaded photo to the destination folder
    $uploadDir = $_SERVER['DOCUMENT_ROOT'] . '/Assignment03/addStudent/';
    $fileDestination = $uploadDir . $fileName;
    move_uploaded_file($fileTmpPath, $fileDestination);

    // Update the student's photo in the database
    $sql = "UPDATE student SET stu_photo = ? WHERE stu_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ss", $fileName, $stuId);
    $stmt->execute();
    $stmt->close();
  }

  // Update the student's information in the database
  $sql = "UPDATE student SET stu_age = ?, stu_name = ?, stu_gender = ?, stu_address = ? WHERE stu_id = ?";
  $stmt = $conn->prepare($sql);
  $stmt->bind_param("issss", $stuAge, $stuName, $stuGender, $stuAddress, $stuId);
  $stmt->execute();
  $stmt->close();

  // Redirect back to the student management page
  header("Location: index.php");
  exit();
} else {
  // No form submission, redirect back to the student management page
  header("Location: index.php");
  exit();
}
?>
