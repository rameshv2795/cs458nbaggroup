<?php
   include("fusioncharts.php");
?>
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
		<script src="fusioncharts/fusioncharts.js"></script>
	</head>
	
	<body>

		<section id="intro">
			<h2>Project Info:</h2>
			<p>This page displays statics of NBA players over many different attributes throughout multiple years.</p>
		</section>
		
    <?php
        /**
         *  Step 3: Create a `columnChart` chart object using the FusionCharts PHP class constructor. 
         *  Syntax for the constructor: `FusionCharts("type of * chart", "unique chart id", "width of chart", 
         *  "height of chart", "div id to render the chart", "data format", "data source")`
         */
        $columnChart = new FusionCharts("Column2D", "myFirstChart" , 600, 300, "chart-1", "json",
            '{
                "chart": {
                    "caption": "Monthly revenue for last year",
                    "subCaption": "Harry\’s SuperMart",
                    "xAxisName": "Month",
                    "yAxisName": "Revenues (In USD)",
                    "numberPrefix": "$",
                    "theme": "zune"
                },
                "data": [
                        {"label": "Jan", "value": "420000"}, 
                        {"label": "Feb", "value": "810000"},
                        {"label": "Mar", "value": "720000"},
                        {"label": "Apr", "value": "550000"},
                        {"label": "May", "value": "910000"},
                        {"label": "Jun", "value": "510000"},
                        {"label": "Jul", "value": "680000"},
                        {"label": "Aug", "value": "620000"},
                        {"label": "Sep", "value": "610000"},
                        {"label": "Oct", "value": "490000"},
                        {"label": "Nov", "value": "900000"},
                        {"label": "Dec", "value": "730000"}
                    ]
                }');
        /**
         *  Because we are using JSON/XML to specify chart data, `json` is passed as the value for the data
         *   format parameter of the constructor. The actual chart data, in string format, is passed as the value
         *   for the data source parameter of the constructor. Alternatively, you can store this string in a 
         *   variable and pass the variable to the constructor.
         */

        /**
         * Step 4: Render the chart
         */
        $columnChart->render();
    ?>
    <div id="chart-1"><!-- Fusion Charts will render here--></div>

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

<!--<?php
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


?>-->


