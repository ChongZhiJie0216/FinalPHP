<?php
session_start();
// Logout function
function logout()
{
  // Destroy all session data
  session_destroy();
  setcookie('username', '', time() - 3600, '/');
  // Redirect to the login page or any other appropriate page
  header("Location: ../directpage.html");
  exit();
}

// Handle logout request
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['logout'])) {
  logout();
}

// Handle delete request
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['delete']) && isset($_POST['stu_id'])) {
  $stu_id = $_POST['stu_id'];
  
  // Perform the deletion in the database
  include_once $_SERVER['DOCUMENT_ROOT'] . '/Assignment03/config.php';
  
  $sql = "DELETE FROM student WHERE stu_id = ?";
  $stmt = $conn->prepare($sql);
  $stmt->bind_param("s", $stu_id);
  $stmt->execute();
  
  // Close the database connection
  $stmt->close();
  $conn->close();
  
  // Redirect back to the same page to refresh the table
  header("Location: ".$_SERVER['PHP_SELF']);
  exit();
}

?>

<!DOCTYPE html>
<html>

<head>
  <meta charset="UTF-8" />
  <meta http-equiv="X-UA-Compatible" content="IE=edge" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Student Management Page</title>
  <link rel="stylesheet" type="text/css" href="styles.css" />
</head>

<body>
  <header>
    <div class="header-container">
      <h1>Student Management Page</h1>
      <div class="action-buttons">
        <button id="add-user-link" onclick="handleAddUserClick()">Add User</button>
        <button id="add-admin-link" onclick="handleAddAdminClick()">Add Admin</button>
        <button id="logout-button" onclick="handleLogoutClick()">Logout</button>
      </div>
    </div>
  </header>
  <main>
    <br>
    <div class="search-container">
      <input type="text" id="search-input" placeholder="Search...">
      <button id="search-button">Search</button>
    </div>
  </main>
  <br>
  <center>
    <div class="action-buttons">
      <button id="add-student-link" onclick="handleAddStudentClick()">Add Student</button>
    </div>
  </center>
  <center>
    <div id="table-container">
      <table border="1">
        <tr>
          <th width="100px">学生照片</th>
          <th width="100px">学号</th>
          <th width="100px">年龄</th>
          <th width="100px">姓名</th>
          <th width="100px">性别</th>
          <th width="750px">户籍</th>
          <th width="100px">学生照片</th>
          <th width="100px">编辑</th>
          <th width="100px">删除</th>

        </tr>
        <?php
        include_once $_SERVER['DOCUMENT_ROOT'] . '/Assignment03/config.php';

        // SQL query to fetch student data
        $sql = "SELECT stu_photo, stu_id, stu_age, stu_name, stu_gender, stu_address FROM student";
        $result = $conn->query($sql);

        // Check if any rows were returned
        if ($result->num_rows > 0) {
          // Loop through each row of data
          while ($row = $result->fetch_assoc()) {
            echo "<tr>";
            echo "<td style='text-align: center;'><img src='../addStudent/" . $row['stu_photo'] . "' alt='Student Photo' width='180px' height='196px'></td>";
            echo "<td style='text-align: center;'>" . $row['stu_id'] . "</td>";
            echo "<td style='text-align: center;'>" . $row['stu_age'] . "</td>";
            echo "<td style='text-align: center;'>" . $row['stu_name'] . "</td>";
            echo "<td style='text-align: center;'>" . $row['stu_gender'] . "</td>";
            echo "<td style='text-align: center;'>" . $row['stu_address'] . "</td>";
            echo "<td style='text-align: center;'><a href='../addStudent/" . $row['stu_photo'] . "' download><button type='button'>Download</button></a></td>";
            echo "<td style='text-align: center;'><a href='editStudent.php?stu_id=" . $row['stu_id'] . "'><button type='button'>Edit</button></a></td>";
            echo "<td style='text-align: center;'>
                  <form method='post' onsubmit='return confirm(\"Are you sure you want to delete this student?\");'>
                    <input type='hidden' name='delete' value='1'>
                    <input type='hidden' name='stu_id' value='" . $row['stu_id'] . "'>
                    <button type='submit'>Delete</button>
                  </form>
                </td>";
            echo "</tr>";
          }
        } else {
          // No rows found
          echo "<tr><td colspan='8'>No data found.</td></tr>";
        }

        // Close the database connection
        $conn->close();
        ?>
      </table>
    </div>
  </center>
  <script>
    function handleAddAdminClick() {
      window.location.href = "../adminRegistration/index.php";
    }

    function handleAddUserClick() {
      window.location.href = "../userRegistration/index.php";
    }

    function handleLogoutClick() {
      var logoutForm = document.createElement("form");
      logoutForm.method = "post";
      logoutForm.action = "";
      var logoutInput = document.createElement("input");
      logoutInput.type = "hidden";
      logoutInput.name = "logout";
      logoutInput.value = "1";
      logoutForm.appendChild(logoutInput);
      document.body.appendChild(logoutForm);
      logoutForm.submit();
    }

    function handleAddStudentClick() {
      window.location.href = "../addStudent/index.php";
    }
  </script>
</body>

</html>
