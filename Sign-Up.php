

<html>
<body>

	<form action="Sign-Up.php" method="post">
		Username: <input type="text" name="user" required>*required<br>
		First Name: <input type="text" name="first" required> *required (must only be letters)<br>
		Last Name: <input type="text" name="last" required>*required (must only be letters)<br>
		Email Address: <input type="text" name="email" required>*required<br>
		Password: <input type="text" name="pass" required>*required<br>
		Age: <input type="int" name="age">*optional but must be integer<br>
	<input type="submit" name="pressed">
	</form>
	<a href="List-Users.php">Link to database contents</a>
	<br><br>
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
	echo "";
	
	$valid_data = 1;
	$no_duplicate = 1;
	$u = $_POST["user"];
	$fir = $_POST["first"]; 
	$las = $_POST["last"];
	$e = $_POST['email'];
	$p = md5($_POST['pass']); /*Hashed password*/
	$ag = ($_POST['age']);
	
	/*Checking to see if valid data*/
	if(!ctype_digit($ag) and !empty($_POST['age'])){
		$valid_data = 0;
		if(isset($_POST['pressed'])){
			echo "Error: Invalid Age";
		}
		
	}
	if(!ctype_alpha($fir) or !ctype_alpha($las)){
		$valid_data = 0;
		if(isset($_POST['pressed'])){
			echo "Error: Invalid first or last name";
		}		
	}
	
	if($valid_data == "1" and isset($_POST['pressed'])){
		
		/*Check if same username/email exists*/
		$sql = mysql_query("SELECT * FROM Users (username) WHERE username = $u");
			if(mysql_num_rows($sql) > 0){
				$no_duplicate = 0;
				echo "Error: already exists";
			}
		$sql = mysql_query("SELECT * FROM Users (email) WHERE email = $e");
			if(mysql_num_rows($sql) > 0){
				$no_duplicate = 0;
				echo "Error: already exists";
			}			

		if($no_duplicate == "1"){
			$sql = "INSERT into Users(username,firstName,lastName,email,password,age) VALUES('$u','$fir','$las','$e','$p','$ag')";
			if ($conn->query($sql) === TRUE) {
				echo "New record created successfully";
			}
			else{
				echo "Error: username already exists";
				//echo "Error: " . $sql . "<br>" . $conn->error;
			} 
		}

		//$result = $mysqli_query($conn,$sql);
	}

/* 	if ($conn->query($sql) === TRUE) {
		echo "New record created successfully";
	}
	else{
   // echo "Error: " . $sql . "<br>" . $conn->error;
	} */
	
	$conn ->close();
	





                                                      /*SOURCES*/
/*

https://www.w3schools.com





*/																


?>


