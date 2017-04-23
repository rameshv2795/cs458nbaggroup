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
	
	$sql = "SELECT username, firstName, lastName, email, password, age FROM Users";
	$r = $conn -> query($sql);
	
	if($r -> num_rows > 0){ /*If 1 or more rows*/
		echo "<table>";
			echo "<tr>";
				echo "<th>" . "Username" ."</th>";
				echo "<th>" . "First Name" ."</th>";
				echo "<th>" . "Last Name" ."</th>";
				echo "<th>" . "Password" ."</th>";
				echo "<th>" . "Email" ."</th>";
				echo "<th>" . "Age" ."</th>";
			echo "</tr>";		
		while($entry = $r -> fetch_assoc()){ /*entry is each row*/

		
			echo "<tr>";
				
					echo "<td>" . $entry["username"] . "</td>";
					echo "<td>" . $entry["firstName"] . "</td>";
					echo "<td>" . $entry["lastName"] . "</td>";
					echo "<td>" . $entry["password"] . "</td>";
					echo "<td>" . $entry["email"] . "</td>";
					echo "<td>" . $entry["age"] . "</td>";
			
			echo "</tr>";
		}
		echo "</table>";
	
	}
	
	$conn ->close();
	





                                                      /*SOURCES*/
/*

https://www.w3schools.com





*/																


?>
