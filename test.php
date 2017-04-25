<?php 

include("fusioncharts/fusioncharts.php");

$hostdb = "classmysql:3306";  // MySQl host
$userdb = "cs340_rameshv";  // MySQL username
$passdb = "6238";  // MySQL password
$namedb = "cs340_rameshv";  // MySQL database name

  /*$servername = "classmysql:3306 ";
  $username = "cs340_rameshv";
  $password = "6238";
  $dbname = "cs340_rameshv";*/

$dbhandle = new mysqli($hostdb, $userdb, $passdb, $namedb);


if ($dbhandle->connect_error) {
  exit("There was an error with your connection: ".$dbhandle->connect_error);
}
?>

<html>
   <head>
      <title>Creating Multi-Series using PHP and MySQL</title>
        <script src="fusioncharts/fusioncharts.js"></script>
        
		<script src="fusioncharts/fusioncharts.charts.js"></script>
   </head>
   <body>
      <section id="intro">
      <h2>Project Info:</h2>
      <p>This page displays statics of NBA players over many different attributes throughout multiple years.</p>
    </section>
<?php
  

  $strQuery = "SELECT PPG, APG, RPG FROM Stats;";

     	$result = $dbhandle->query($strQuery) or exit("Error code ({$dbhandle->errno}): {$dbhandle->error}");

  if ($result) {
        	
	$arrData = array(
        "chart" => array(
        	"caption"=> "Multi Series Chart",
        	"showValues"=> "0"
              	)
           	);

        	// creating array for categories object
        	
        	$categoryArray=array();
        	$dataseries1=array();
        	$dataseries2=array();
        	// pushing category array values
        	while($row = mysqli_fetch_array($result)) {				
				array_push($categoryArray, array(
					"label" => $row["PPG"]
					)
				);
				array_push($dataseries1, array(
					"value" => $row["APG"]
					) 
				);
			
				array_push($dataseries2, array(
					"value" => $row["RPG"]
					)
				);
        	}
        	
        	$arrData["categories"]=array(array("category"=>$categoryArray));
			// creating dataset object
			$arrData["dataset"] = array(array("seriesName"=> "2014", "data"=>$dataseries1), array("seriesName"=> "2015", "data"=>$dataseries2));
		
			
				

            $jsonEncodedData = json_encode($arrData);
            
            //echo $jsonEncodedData;
			
			 $lineChart = new FusionCharts("msline", "myFirstChart" , "600", "400", "chart-container", "json", $jsonEncodedData);
             $lineChart->render();
			 
             $dbhandle->close();
           
         }

 
?>
<center>
 <div id="chart-container">Chart will render here!</div></center>
   </body>
</html>