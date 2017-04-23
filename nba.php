<!DOCTYPE html>
<html>
	<head>

		<meta name="author" content="Christopher Johnson">
		<meta name="description" content="Interactive webpage for NBA player statistics">
		<meta name="keywords" content="school, project, visual, information, visualization, homework, assignments">
		<link rel="stylesheet" href="stylesheet.css">
		<script>
			function myFunction() {
				document.getElementById("demo").innerHTML = "Paragraph changed.";
			}
		</script>
		<title>NBA Player Statistics</title>
		
	</head>
	
	<body>

		<section id="intro">
			<h2>Project Info:</h2>
			<p>This page displays statics of NBA players over many different attributes throughout multiple years.</p>
		</section>
		
		<!--
	<form action="Sign-Up.php" method="post">
		Username: <input type="text" name="user" required>*required<br>
		First Name: <input type="text" name="first" required> *required (must only be letters)<br>
		Last Name: <input type="text" name="last" required>*required (must only be letters)<br>
		Email Address: <input type="text" name="email" required>*required<br>
		Password: <input type="text" name="pass" required>*required<br>
		Age: <input type="int" name="age">*optional but must be integer<br>
	<input type="submit" name="pressed">
	</form>			
	-->

	</body>
</html>

<?php

	$servername = "classmysql:3306 ";
	$username = "cs340_rameshv";
	$password = "6238";
	$dbname = "cs340_rameshv";

	// Create connection
	$conn = mysqli_connect($servername, $username, $password, $dbname);

	// Check connection
	if (!$conn) {
		die("Connection failed: " . mysqli_connect_error());
	}
	else{
		echo "Successfully connected to database";
	}


?>


