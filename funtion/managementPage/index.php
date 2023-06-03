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
      <button id="modify-student-link" onclick="handleModifyStudentClick()">Modify Student</button>
      <button id="delete-student-link" onclick="handleDeleteStudentClick()">Delete Student</button>
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