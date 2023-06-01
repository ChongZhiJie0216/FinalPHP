<!DOCTYPE html>
<html>
<head>
  <title>Add Student</title>
  <link rel="stylesheet" type="text/css" href="styles.css" />
</head>
<body>

<?php
  include_once $_SERVER['DOCUMENT_ROOT'] . '/Assignment03/config.php';
  $message = ""; // Variable to store the error message

// Function to sanitize user inputs
function sanitize($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}

// Insert or update student record
// Insert or update student record
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve form inputs
    $stu_id = sanitize($_POST["stu_id"]);
    $stu_name = sanitize($_POST["stu_name"]);
    $stu_age = sanitize($_POST["stu_age"]);
    $stu_gender = sanitize($_POST["stu_gender"]);
    $stu_address = sanitize($_POST["stu_address"]);

    // Check if the student ID already exists in the database
    $query = "SELECT * FROM student WHERE stu_id = '$stu_id'";
    $result = $conn->query($query);

    if ($result->num_rows > 0) {
        // Update the existing record
        $query = "UPDATE student SET stu_name = '$stu_name', stu_age = '$stu_age', stu_gender = '$stu_gender', stu_address = '$stu_address' WHERE stu_id = '$stu_id'";
    } else {
        // Insert a new record
        $query = "INSERT INTO student (stu_id, stu_name, stu_age, stu_gender, stu_address) VALUES ('$stu_id', '$stu_name', '$stu_age', '$stu_gender', '$stu_address')";
    }

    // Execute the query
    if ($conn->query($query) === TRUE) {
        $message =  "Record saved successfully.";

        // Upload student photo if it is selected
        if (!empty($_FILES["stu_photo"]["name"])) {
            $target_dir = "/IMG/STD_IMG"; // Directory to store the uploaded photos
            $target_file = $target_dir . basename($_FILES["stu_photo"]["name"]);
            $uploadOk = 1;
            $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));
            
            // Create the target directory if it doesn't exist
            if (!file_exists($target_dir)) {
                mkdir($target_dir, 0777, true);
            }
            if (!file_exists($target_dir)) {
                $message = "Failed to create the directory.";
            }
            // Check if the file is an actual image
            $check = getimagesize($_FILES["stu_photo"]["tmp_name"]);
            if ($check !== false) {
                $uploadOk = 1;
            } else {
                $message = "The uploaded file is not an image.";
                $uploadOk = 0;
            }

            // Check if the file already exists
            if (file_exists($target_file)) {
                $message = "Sorry, the file already exists.";
                $uploadOk = 0;
            }

            // Check the file size (optional)
            if ($_FILES["stu_photo"]["size"] > 500000) {
                $message = "Sorry, the file is too large.";
                $uploadOk = 0;
            }

            // Allow only certain file formats (optional)
            if ($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg" && $imageFileType != "gif") {
                $message = "Sorry, only JPG, JPEG, PNG, and GIF files are allowed.";
                $uploadOk = 0;
            }

            // Move the uploaded file to the target directory
            if ($uploadOk == 1) {
                if (move_uploaded_file($_FILES["stu_photo"]["tmp_name"], $target_file)) {
                    // Update the photo path in the database
                    $photo_path = $target_dir . basename($_FILES["stu_photo"]["name"]);
                    $query = "UPDATE student SET stu_photo = '$photo_path' WHERE stu_id = '$stu_id'";
                    $conn->query($query);
                    $message = "Record and photo saved successfully.";
                } else {
                    $message = "Sorry, there was an error uploading the file.";
                }
            }
        }
    } else {
        echo "Error: " . $query . "<br>";
    }
}
// Close the database connection
$conn->close();
?>

<div class="container">
  <h2>Student Management</h2>
  <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
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
      <textarea id="stu_address" name="stu_address" rows="8" cols="85" required ></textarea>
    </div>

    <div class="form-group">
        <label for="stu_photo">Photo:</label>
        <input type="file" id="stu_photo" name="stu_photo">
    </div>
    <button type="submit">Save</button>
  </form>
  <p class="record-message"><?php echo $message; ?></p> <!-- Display error message -->

</div>

</body>
</html>
