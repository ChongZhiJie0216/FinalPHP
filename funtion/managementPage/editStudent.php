<?php
include_once $_SERVER['DOCUMENT_ROOT'] . '/Assignment03/config.php';

// Check if the "stu_id" parameter is present in the URL
if (isset($_GET['stu_id'])) {
  $stuId = $_GET['stu_id'];

  // Fetch the student data based on the stu_id
  $sql = "SELECT stu_photo, stu_id, stu_age, stu_name, stu_gender, stu_address FROM student WHERE stu_id = ?";
  $stmt = $conn->prepare($sql);
  $stmt->bind_param("s", $stuId);
  $stmt->execute();
  $result = $stmt->get_result();

  // Check if a row was found
  if ($result->num_rows > 0) {
    // Fetch the student details
    $row = $result->fetch_assoc();
    $stuPhoto = $row['stu_photo'];
    $stuId = $row['stu_id'];
    $stuAge = $row['stu_age'];
    $stuName = $row['stu_name'];
    $stuGender = $row['stu_gender'];
    $stuAddress = $row['stu_address'];

    // Display the form to edit student information
    ?>
    <!DOCTYPE html>
    <html>
    <head>
      <meta charset='UTF-8' />
      <meta http-equiv='X-UA-Compatible' content='IE=edge' />
      <meta name='viewport' content='width=device-width, initial-scale=1.0' />
      <title>Edit Student</title>
      <style>
      body {
        font-family: Arial, sans-serif;
        margin: 0;
        padding: 0;
      }

      header {
        background-color: #f2f2f2;
        padding: 10px;
        border-bottom: 1px solid #ccc;
      }

      .header-container {
        display: flex;
        justify-content: space-between;
        align-items: center;
      }

      .action-buttons button {
        background-color: #4CAF50;
        color: white;
        border: none;
        padding: 10px 20px;
        text-align: center;
        text-decoration: none;
        display: inline-block;
        font-size: 16px;
        margin-left: 10px;
        cursor: pointer;
      }

      .action-buttons button:hover {
        background-color: #45a049;
      }

      .search-container {
        margin-top: 20px;
        text-align: center;
      }

      #search-input {
        padding: 8px;
        width: 300px;
        border: 1px solid #ccc;
      }

      #search-button {
        background-color: #008CBA;
        color: white;
        border: none;
        padding: 8px 16px;
        text-align: center;
        text-decoration: none;
        display: inline-block;
        font-size: 16px;
        cursor: pointer;
        margin-left: 5px;
      }

      #search-button:hover {
        background-color: #006080;
      }
    </style>
    </head>
    <body>
      <center>
        <h1>Edit Student</h1>
        <form method='post' action='updateStudent.php' enctype='multipart/form-data'>
          <input type='hidden' name='stu_id' value='<?php echo $stuId; ?>'>
          <table>
            <tr>
              <td>Student Photo:</td>
              <td><img src='../addStudent/<?php echo $stuPhoto; ?>' alt='Student Photo' width='180px' height='196px'></td>
            </tr>
            <tr>
              <td>Upload New Photo:</td>
              <td><input type='file' name='photo'></td>
            </tr>
            <tr>
              <td>Student ID:</td>
              <td><input type='text' name='stu_id' value='<?php echo $stuId; ?>' readonly></td>
            </tr>
            <tr>
              <td>Age:</td>
              <td><input type='number' name='stu_age' value='<?php echo $stuAge; ?>'></td>
            </tr>
            <tr>
              <td>Name:</td>
              <td><input type='text' name='stu_name' value='<?php echo $stuName; ?>'></td>
            </tr>
            <tr>
              <td>Gender:</td>
              <td>
                <select name='stu_gender'>
                  <option value='Male'<?php if ($stuGender === 'Male') echo ' selected'; ?>>Male</option>
                  <option value='Female'<?php if ($stuGender === 'Female') echo ' selected'; ?>>Female</option>
                </select>
              </td>
            </tr>
            <tr>
              <td>Address:</td>
              <td><input type='text' name='stu_address' value='<?php echo $stuAddress; ?>'></td>
            </tr>
            <tr>
              <td colspan='2' style='text-align: center;'>
                <button type='submit'>Update</button>
                <button type='button' onclick='history.back()'>Cancel</button>
              </td>
            </tr>
          </table>
        </form>
      </center>
    </body>
    </html>
    <?php
  } else {
    // No student found with the provided stu_id
    echo "No student found.";
  }

  // Close the prepared statement
  $stmt->close();
} else {
  // No stu_id parameter provided in the URL
  echo "Invalid request.";
}

// Close the database connection
$conn->close();
?>
