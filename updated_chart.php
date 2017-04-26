<!DOCTYPE html>
<html>
<head>
<link href="css/extension-page-style.css" rel="stylesheet" type="text/css"  />
<script src="http://code.jquery.com/jquery-latest.min.js"></script>
<script type="text/javascript" src="http://static.fusioncharts.com/code/latest/fusioncharts.js"></script>
<script src="http://static.fusioncharts.com/code/latest/fusioncharts.charts.js"></script>
<script src="http://static.fusioncharts.com/code/latest/themes/fusioncharts.theme.zune.js"></script>


<style>

.code-block-holder pre {
      max-height: 188px;  
      min-height: 188px; 
      overflow: auto;
      border: 1px solid #ccc;
      border-radius: 5px;
}


.tab-btn-holder {
	width: 100%;
	margin: 20px 0 0;
	border-bottom: 1px solid #dfe3e4;
	min-height: 30px;
}

.tab-btn-holder a {
	background-color: #fff;
	font-size: 14px;
	text-transform: uppercase;
	color: #006bb8;
	text-decoration: none;
	display: inline-block;
	*zoom:1; *display:inline;


}

.tab-btn-holder a.active {
	color: #858585;
    padding: 9px 10px 8px;
    border: 1px solid #dfe3e4;
    border-bottom: 1px solid #fff;
    margin-bottom: -1px;
    border-top-left-radius: 5px;
    border-top-right-radius: 5px;
    position: relative;
    z-index: 300;
}

</style>

<script>
function getName() {
    //document.getElementById("mySelect").disabled=true;

}
</script>


</head>
<body>

<form method="post" action="<?php echo htmlentities($_SERVER['PHP_SELF']); ?>">
<select id="name" name="name">
  <option value="Rajon Rondo">Rajon Rondo</option>
  <option>Place Holder</option>
  <option>Place Holder</option>
  <option>Place Holder</option>
</select>
<select id="nbateamid" name="nbateamid">
	<option value="">Select Team</option>
	<?php echo add_teams();?>
</select>
<select id="player" name="player">
	<option value="">Select Player</option>
	
</select>

<br><br>
<input type="submit" name="formSubmit" value="Submit">
</form>

<br>

<script>

$(document).ready(function()
{

	$('#nbateamid').change(function(){
		var team_id = $(this).val();

		$.ajax({
			url:"player_drop.php",
			method:"POST",
			data:{team_id:team_id},
			dataType: "text",
			success:function(data){
				//alert(team_id);
				$('#player').html(data);
				
			}
		
		});
		
	});
});


</script>




<?php
function add_teams(){

$hostdb = "classmysql:3306";  // MySQl host
$userdb = "cs340_rameshv";  // MySQL username
$passdb = "6238";  // MySQL password
$namedb = "cs340_rameshv";  // MySQL database name

// Establish a connection to the database
$dbhandle = new mysqli($hostdb, $userdb, $passdb, $namedb);

$sql = "SELECT TeamName FROM team";
$set_teams = $dbhandle -> query($sql);
$teams_array = array();

	//echo "<select name='team' id='selected_team'>";
	while($entry = $set_teams -> fetch_assoc()){
		$output .= "<option value ='" . $entry["TeamName"] . "'>" . $entry['TeamName'] . "</option>";
	}
	//echo "</select>";
	return $output;
}
?>
<?php
// Including the wrapper file in the page
include("fusioncharts.php");

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



$name;
if(isset($_POST['formSubmit']))
{
  $FullName = $_POST["name"];
  global $name;
  $name = explode(" ", $FullName);
  $name[0]; //first name
  $name[1]; // last name
}

$strQuery = "SELECT PPG FROM Stats WHERE (First_Name = '$name[0]' AND Last_Name = '$name[1]'); ";
  $result = $dbhandle->query($strQuery) or exit("Error code ({$dbhandle->errno}): {$dbhandle->error}");


if ($result) {
    // Preparing the object of FusionCharts with needed informations
    /**
    * The parameters of the constructor are as follows
    * chartType   {String}  The type of chart that you intend to plot. e.g. Column3D, Column2D, Pie2D etc.
    * chartId     {String}  Id for the chart, using which it will be recognized in the HTML page. Each chart on the page should have a unique Id.
    * chartWidth  {String}  Intended width for the chart (in pixels). e.g. 400
    * chartHeight {String}  Intended height for the chart (in pixels). e.g. 300
    * containerId {String}  The id of the chart container. e.g. chart-1
    * dataFormat  {String}  Type of data used to render the chart. e.g. json, jsonurl, xml, xmlurl
    * dataSource  {String}  Actual data for the chart. e.g. {"chart":{},"data":[{"label":"Jan","value":"420000"}]}
    */

      $arrData = array(
        "chart" => array(
        "caption"=> $FullName,
        "subCaption"=> "Points per game",
        "captionPadding"=> "15",
        //"numberPrefix"=> "$",
        "showvalues"=> "1",
        "valueFontColor"=> "#ffffff",
        "placevaluesInside"=> "1",
        "usePlotGradientColor"=> "0",
        "legendShadow"=> "0",
        "showXAxisLine"=> "1",
        "xAxisLineColor"=> "#999999",
        "xAxisname"=> "Year",
        "yAxisName"=> "PPG",
        "divlineColor"=> "#999999",
        "divLineIsDashed"=> "1",
        "showAlternateVGridColor"=> "0",
        "alignCaptionWithCanvas"=> "0",
        "legendPadding"=> "15",
        "showHoverEffect"=> "1",
        "plotToolText"=> "<div><b>$label</b><br/>PPG : <b>$value</b><br/>Year : <b>$value</b></div>",
        "theme"=> "fint"
            )
          );

          $categoryArray=array();
          $dataseries1=array();

    while($row = mysqli_fetch_array($result)) {
      array_push($categoryArray, array(
        "label" => 'Year'
        )
      );
      array_push($dataseries1, array("value" => $row["PPG"]));
    }

        $arrData["categories"]=array(array("category"=>$categoryArray));
        $arrData["dataset"] = array(array("seriesName"=> "PPG", "data"=>$dataseries1));

  $jsonEncodedData = json_encode($arrData);

      // chart object
      $msChart = new FusionCharts("msbar2d", "chart1" , "50%", "350", "chart-1", "json", $jsonEncodedData);

      // Render the chart
      $msChart->render();

      // closing db connection
      $dbhandle->close();

      }


/*$columnChart = new FusionCharts("msbar2d", "ex1" , "50%", 400, "chart-1", "json", '{
      "chart": {
        "caption": "Rajon Rondo",
        "subCaption": "Points per game",
        "captionPadding": "15",
        "numberPrefix": "$",
        "showvalues": "1",
        "valueFontColor": "#ffffff",
        "placevaluesInside": "1",
        "usePlotGradientColor": "0",
        "legendShadow": "0",
        "showXAxisLine": "1",
        "xAxisLineColor": "#999999",
        "xAxisname": "Year",
        "yAxisName": "PPG",
        "divlineColor": "#999999",
        "divLineIsDashed": "1",
        "showAlternateVGridColor": "0",
        "alignCaptionWithCanvas": "0",
        "legendPadding": "15",
        "plotToolText": "<div><b>$label</b><br/>Product : <b>$seriesname</b><br/>Sales : <b>$$value</b></div>",
        "theme": "fint"
      },
      "categories": [{
        "category": [{
          "label": "Garden Groove harbour"
        }, {
          "label": "Bakersfield Central"
        }]
      }],
      "dataset": [{
        "seriesname": "Non-Food Products",
        "data": [{
          "value": "28800"
        }, {
          "value": "25400"
        }, {
          "value": "21800"
        }, {
          "value": "19500"
        }, {
          "value": "11500"
        }]
      }, {
        "seriesname": "Food Products",
        "data": [{
          "value": "17000"
        }, {
          "value": "19500"
        }, {
          "value": "12500"
        }, {
          "value": "14500"
        }, {
          "value": "17500"
        }]
      }]
    }');
// Render the chart
$columnChart->render();*/
?>
<div id="chart-1"><!-- Fusion Charts will render here--></div>
 
</body>
</html>













