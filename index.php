<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="UTF-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Getting Started</title>
	<style>
		body {
			background-color: #f2f2f2;
			width: 400px;
			padding: 20px;
			margin: 100px auto;
			border-radius: 5px;
			box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
		}

		.container {
			background-color: #fff;
			width: 400px;
			padding: 20px;
			margin: 100px auto;
			border-radius: 5px;
			box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
		}

		h2 {
			text-align: center;
		}

		label {
			margin-bottom: 10px;
			font-weight: bold;
		}

		input[type="text"],
		input[type="password"] {
			width: 200px;
			padding: 10px;
			margin-bottom: 20px;
			border: 1px solid #ccc;
			border-radius: 4px;
		}

		input[type="submit"] {
			background-color: #4CAF50;
			color: #fff;
			padding: 10px 20px;
			border: none;
			border-radius: 4px;
			cursor: pointer;
			font-size: 16px;
		}

		input[type="submit"]:hover {
			background-color: #45a049;
		}
	</style>
</head>

<body>
	<center>
		<h1>Connect to MariaDB</h1>
		<?php
		if (file_exists("config.php")) {
			header("Location: ./funtion/directpage.html"); // Replace with the actual direct page URL
			exit;
		} else {
			echo '<form method="post" action="connect.php">
				<label for="host">Host:</label>
				<input type="text" id="host" name="host" placeholder="localhost" />
				<br /><br />
				<label for="username">Username:</label>
				<input type="text" id="username" name="username" placeholder="root" />
				<br /><br />
				<label for="password">Password:</label>
				<input type="password" id="password" name="password" placeholder="" />
				<br /><br />
				<label for="database">Database:</label>
				<input type="text" id="database" name="database" placeholder="Example:CPSS" />
				<br /><br />
				<input type="submit" value="Connect" />
				</form>';
		}
		?>
	</center>
</body>

</html>