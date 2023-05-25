<!DOCTYPE html>
<html>

<head>
  <meta charset="UTF-8" />
  <meta http-equiv="X-UA-Compatible" content="IE=edge" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Student Management Page</title>
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
    <div class="search-container">
      <input type="text" id="search-input" placeholder="Search...">
      <button id="search-button">Search</button>
    </div>
  </main>
  <script>
     function handleAddAdminClick() {
      // Add your logic here to handle the "Add User" link click event
      // For example, you can redirect to another PHP page using JavaScript:
      window.location.href = "../adminRegistration/index.php";
    }
    function handleAddUserClick() {
      // Add your logic here to handle the "Add User" link click event
      // For example, you can redirect to another PHP page using JavaScript:
      window.location.href = "../userRegistration/index.php";
    }
    function handleLogoutClick(){
      window.location.href ="../directpage.html";
    }
  </script>
</body>

</html>
