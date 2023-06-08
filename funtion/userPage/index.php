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
          if (isset($_COOKIE['username'])) {
            $loggedInUsername = $_COOKIE['username'];

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
          <th width="100px">学生照片</th>
          <th width="100px">学号</th>
          <th width="100px">年龄</th>
          <th width="100px">姓名</th>
          <th width="100px">性别</th>
          <th width="750px">户籍</th>
          <th width="100px">操作</th>
        </tr>
        <?php
        include_once $_SERVER['DOCUMENT_ROOT'] . '/Assignment03/config.php';

        $sql = "SELECT stu_photo, stu_id, stu_age, stu_name, stu_gender, stu_address FROM student";
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
          while ($row = $result->fetch_assoc()) {
            echo "<tr>";
            echo "<td style='text-align: center;'><img src='../addStudent/" . $row['stu_photo'] . "' alt='Student Photo' width='180px' height='196px'></td>";
            echo "<td style='text-align: center;'>" . $row['stu_id'] . "</td>";
            echo "<td style='text-align: center;'>" . $row['stu_age'] . "</td>";
            echo "<td style='text-align: center;'>" . $row['stu_name'] . "</td>";
            echo "<td style='text-align: center;'>" . $row['stu_gender'] . "</td>";
            echo "<td style='text-align: center;'>" . $row['stu_address'] . "</td>";
            echo "<td style='text-align: center;'><a href='../addStudent/" . $row['stu_photo'] . "' download><button type='button'>Download</button></a></td>";
            echo "</tr>";
          }
        } else {
          echo "<tr><td colspan='7'>No data found.</td></tr>";
        }

        $conn->close();
        ?>
      </table>
    </div>
  </center>

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
      var searchInput = document.getElementById("search-input").value.toLowerCase();
      var tableRows = document.getElementsByTagName("tr");

      for (var i = 1; i < tableRows.length; i++) {
        var cells = tableRows[i].getElementsByTagName("td");
        var found = false;

        for (var j = 0; j < cells.length; j++) {
          var cellText = cells[j].textContent || cells[j].innerText;

          if (cellText.toLowerCase().includes(searchInput)) {
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
</body>

</html>
