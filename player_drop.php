<?php
$hostdb = "classmysql:3306";  // MySQl host
$userdb = "cs340_rameshv";  // MySQL username
$passdb = "6238";  // MySQL password
$namedb = "cs340_rameshv";  // MySQL database name

// Establish a connection to the database
$dbhandle = new mysqli($hostdb, $userdb, $passdb, $namedb);
    
/*Render an error message, to avoid abrupt failure, if the database connection parameters are incorrect */
if ($dbhandle->connect_error) {
  exit("There was an error with your connection: ".$dbhandle->connect_error);
}

  $output = '';
  $sql = "SELECT * FROM player WHERE team = '".$_POST["team_id"]."'";
  $result = $dbhandle -> query($sql);
  
  $output = '<option value =""> Select Player</option>';

  while($row = mysqli_fetch_array($result)){
	$output .= ' <option value="'.$row["playerid"].'">'.$row["FirstName"].'</option>';
	//$output = '<option value =""> GOOD</option>';
 }


echo $output;

?>