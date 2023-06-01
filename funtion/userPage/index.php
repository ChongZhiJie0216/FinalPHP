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
  <center>
  <header>
    <div class="header-container">
      <h1>
        <?php
        // Check if the "username" cookie is set
        if (isset($_COOKIE['username'])) {
          $loggedInUsername = $_COOKIE['username'];

          // Display the personalized welcome message
          echo "Welcome, " . htmlspecialchars($loggedInUsername);
        }
        ?>
      </h1>
      <div class="action-buttons">
        <button id="logout-button" onclick="handleLogoutClick()">Logout</button>
      </div>
    </div>
  </header>
  <main>
    <div class="search-container">
      <input type="text" id="search-input" placeholder="Search...">
      <button id="search-button" onclick="handleSearchClick()">Search</button>
    </div>
  </main>
  <div id="table-container">
    <table border="1">
      <tr>
        <th width='100px'>学号</th>
        <th width='100px'>年龄</th>
        <th width='100px'>姓名</th>
        <th width='100px'>性别</th>
        <th width='750px'>户籍</th>
      </tr>
      <?php
      include_once $_SERVER['DOCUMENT_ROOT'] . '/Assignment03/config.php';

      // SQL query to fetch student data
      $sql = "SELECT stu_id AS 学号, stu_age AS 年龄, stu_name AS 姓名, stu_gender AS 性别, stu_address AS 户籍 FROM student";
      $result = $conn->query($sql);

      // Check if any rows were returned
      if ($result->num_rows > 0) {
        // Loop through each row of data
        while ($row = $result->fetch_assoc()) {
          echo "<tr>";
          echo "<td style='text-align: center;'>" . $row['学号'] . "</td>";
          echo "<td style='text-align: center;'>" . $row['年龄'] . "</td>";
          echo "<td style='text-align: center;'>" . $row['姓名'] . "</td>";
          echo "<td style='text-align: center;'>" . $row['性别'] . "</td>";
          echo "<td style='text-align: center;'>" . $row['户籍'] . "</td>";
          echo "</tr>";
        }
      } else {
        // No rows found
        echo "<tr><td colspan='5'>No data found.</td></tr>";
      }

      // Close the database connection
      $conn->close();
      ?>
    </table>
  </div>
  <script>
    function handleLogoutClick() {
      var logoutForm = document.createElement("form");
      logoutForm.method = "post";
      logoutForm.action = "logout.php";
      var logoutInput = document.createElement("input");
      logoutInput.type = "hidden";
      logoutInput.name = "logout";
      logoutInput.value = "1";
      logoutForm.appendChild(logoutInput);
      document.body.appendChild(logoutForm);
      logoutForm.submit();
    }

    function handleSearchClick() {
      var searchInput = document.getElementById("search-input").value;
      var tableRows = document.getElementsByTagName("tr");

      for (var i = 1; i < tableRows.length; i++) {
        var cells = tableRows[i].getElementsByTagName("td");
        var found = false;

        for (var j = 0; j < cells.length; j++) {
          var cellText = cells[j].textContent || cells[j].innerText;

          if (cellText.toLowerCase().includes(searchInput.toLowerCase())) {
            found = true;
            break;
          }
        }

        if (found) {
          tableRows[i].style.display = "";
        } else {
          tableRows[i].style.display = "none";
        }
      }
    }
  </script>
  </center>
</body>

</html>
