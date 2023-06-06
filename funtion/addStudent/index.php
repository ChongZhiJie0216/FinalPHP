<!DOCTYPE html>
<html>

<head>
  <title>Add Student</title>
  <link rel="stylesheet" type="text/css" href="styles.css" />
</head>

<body>
  <?php
  include_once $_SERVER['DOCUMENT_ROOT'] . '/Assignment03/config.php';
  $message = ""; 

  function sanitize($data)
  {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
  }

  if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve form inputs
    $stu_id = sanitize($_POST["stu_id"]);
    $stu_name = sanitize($_POST["stu_name"]);
    $stu_age = sanitize($_POST["stu_age"]);
    $stu_gender = sanitize($_POST["stu_gender"]);
    $stu_address = sanitize($_POST["stu_address"]);

    $query = "SELECT * FROM student WHERE stu_id = '$stu_id'";
    $result = $conn->query($query);

    if ($result->num_rows > 0) {
      $row = $result->fetch_assoc();
      $existing_photo = $row['stu_photo'];

      if (!empty($existing_photo)) {
        unlink($existing_photo);
      }

      $query = "UPDATE student SET stu_name = '$stu_name', stu_age = '$stu_age', stu_gender = '$stu_gender', stu_address = '$stu_address' WHERE stu_id = '$stu_id'";
    } else {
      $query = "INSERT INTO student (stu_id, stu_name, stu_age, stu_gender, stu_address) VALUES ('$stu_id', '$stu_name', '$stu_age', '$stu_gender', '$stu_address')";
    }

    if ($conn->query($query) === TRUE) {
      $message =  "Record saved successfully.";

      if (!empty($_FILES["stu_photo"]["name"])) {
        $target_dir = "photos/"; // Directory to store the photos

        if (!file_exists($target_dir)) {
          mkdir($target_dir, 0777, true);
        }

        $target_file = $target_dir . basename($_FILES["stu_photo"]["name"]);
        $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

        $new_filename = uniqid('photo_') . '.' . $imageFileType;
        $target_file = $target_dir . $new_filename;

        if (move_uploaded_file($_FILES["stu_photo"]["tmp_name"], $target_file)) {
          // Save the picture location in the database
          $query = "UPDATE student SET stu_photo = '$target_file' WHERE stu_id = '$stu_id'";
          $conn->query($query);
        } else {
          echo "Error uploading the photo.";
        }
      }
    } else {
      echo "Error: " . $query . "<br>";
    }
  }

  $conn->close();
  ?>


  <div class="container">
    <h2>Student Management</h2>
    <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" enctype="multipart/form-data">
      <div class="form-group">
        <label for="stu_id">Student ID:</label>
        <input type="text" id="stu_id" name="stu_id" required>
      </div>

      <div class="form-group">
        <label for="stu_name">Name:</label>
        <input type="text" id="stu_name" name="stu_name" required>
      </div>

      <div class="form-group">
        <label for="stu_age">Age:</label>
        <input type="number" id="stu_age" name="stu_age" required>
      </div>

      <div class="form-group">
        <label for="stu_gender">Gender:</label>
        <select id="stu_gender" name="stu_gender" required>
          <option value="Male">Male</option>
          <option value="Female">Female</option>
          <option value="Other">Other</option>
        </select>
      </div>

      <div class="form-group">
        <label for="stu_address">Address:</label>
        <textarea id="stu_address" name="stu_address" rows="8" cols="85" required></textarea>
      </div>

      <div class="form-group">
        <label for="stu_photo">Photo:</label>
        <input type="file" id="stu_photo" name="stu_photo">
      </div>
      <button   type="submit">Save</button>
    </form>
    <br>
    <button type=rtn onclick="window.location.href = '../managementPage/index.php';">Return to Management Page</button>
    <p class="record-message"><?php echo $message; ?></p>

  </div>
</body>

</html>