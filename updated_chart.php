<!DOCTYPE html>
<html>
<head>
<link href="style.css" rel="stylesheet" type="text/css"  />
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

</head>
<body>

<form method="post" action="<?php echo htmlentities($_SERVER['PHP_SELF']); ?>">
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
$userdb = "cs340_rameshv";    // MySQL username
$passdb = "6238";             // MySQL password
$namedb = "cs340_rameshv";    // MySQL database name

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

if(isset($_POST['formSubmit']))
{
  /*Set name for caption*/
  $strQuery = "SELECT * FROM player WHERE playerid = '".$_POST["player"]."'";
  $result = $dbhandle->query($strQuery) or exit("Error code ({$dbhandle->errno}): {$dbhandle->error}");
  while($entry = $result -> fetch_assoc()){
		$selected_first_name = $entry["FirstName"];
		$selected_last_name = $entry["LastName"];
  }
  $full_name = $selected_first_name . ' ' . $selected_last_name;
}

$strQuery = "SELECT * FROM statistics WHERE nba_player = '".$_POST["player"]."'";
$result = $dbhandle->query($strQuery) or exit("Error code ({$dbhandle->errno}): {$dbhandle->error}");

if ($result) {

  // initialize arrays to store stats
  $ppgArray=array();
  $apgArray=array();
  $rpgArray=array();
  $fgArray=array();
  $tovArray=array();
  $ftArray=array();
  $bpgArray=array();
  $tpArray=array();
  $perArray=array();
  $tsArray=array();
  $gpArray=array();
  $yearArray=array();

  while($row = mysqli_fetch_array($result)) {
    // Collect all data
    array_push($ppgArray, array("value" => $row["PPG"]));
    array_push($apgArray, array("value" => $row["APG"]));
    array_push($rpgArray, array("value" => $row["RPG"]));
    array_push($fgArray, array("value" => $row["FG%"]));
    array_push($tovArray, array("value" => $row["TOV"]));
    array_push($ftArray, array("value" => $row["FT%"]));
    array_push($bpgArray, array("value" => $row["BPG"]));
    array_push($tpArray, array("value" => $row["3P%"]));
    array_push($perArray, array("value" => $row["PER"]));
    array_push($tsArray, array("value" => $row["TS%"]));
    array_push($gpArray, array("value" => $row["GP"]));
    array_push($yearArray, array("label" => $row["year"]));
  }

  // create charts
  $chartID = 0;
  generateChart($ppgArray, $yearArray, $full_name, "Points Per Game", "PPG", $chartID, "chart-ppg");
  generateChart($apgArray, $yearArray, $full_name, "Assist Per Game", "APG", $chartID+1, "chart-apg");
  generateChart($rpgArray, $yearArray, $full_name, "Rebounds Per Game", "RPG", $chartID+2, "chart-rpg");
  generateChart($fgArray, $yearArray, $full_name, "Field Goal Percentage Per Game", "FG%", $chartID+3, "chart-fg");
  generateChart($tovArray, $yearArray, $full_name, "Turnovers Per Game", "TOV", $chartID+4, "chart-tov");
  generateChart($ftArray, $yearArray, $full_name, "Free Throw Percentage Per Game", "FT%", $chartID+5, "chart-ft");
  generateChart($bpgArray, $yearArray, $full_name, "Blocks Per Game", "BPG", $chartID+6, "chart-bpg");
  generateChart($tpArray, $yearArray, $full_name, "Three Point Percentage Per Game", "3P%", $chartID+7, "chart-tp");
  generateChart($perArray, $yearArray, $full_name, "Player Efficiency Rating", "PER", $chartID+8, "chart-per");
  generateChart($tsArray, $yearArray, $full_name, "True Shooting Percentage Per Game", "TS%", $chartID+9, "chart-ts");
  generateChart($gpArray, $yearArray, $full_name, "Games Played Per Year", "GP", $chartID+10, "chart-gp");

  // closing db connection
  $dbhandle->close();
}

function initChart($full_name, $caption, $genArray, $yearArray){
    $arrData = array(
      "chart" => array(
      "caption"=> $full_name,
      "subCaption"=> $caption,
      "captionPadding"=> "15",
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
      "plotToolText"=> "<div><b>$label</b><br/>PPG : <b>$genArray</b><br/>Year : <b>$yearArray</b></div>",
      "theme"=> "fint"
    )
  );
    return $arrData;
}

function generateChart($genArray, $yearArray, $full_name, $title, $key, $id, $divID){
  $arrData = initChart($full_name, $title, $genArray, $yearArray);
  $arrData["categories"]=array(array("category"=>$yearArray));
  $arrData["dataset"] = array(array("seriesName"=> $key, "data"=>$genArray));

  $jsonEncodedData = json_encode($arrData);

  // chart object
  $msChart = new FusionCharts("msbar2d", $id , "30%", "350", $divID, "json", $jsonEncodedData);
  // Render the chart
  $msChart->render();
}

?>
<div class="box" id="chart-ppg"></div>
<div class="box" id="chart-apg"></div>
<div class="box" id="chart-rpg"></div>
<div class="box" id="chart-fg"></div>
<div class="box" id="chart-tov"></div>
<div class="box" id="chart-ft"></div>
<div class="box" id="chart-bpg"></div>
<div class="box" id="chart-tp"></div>
<div class="box" id="chart-per"></div>
<div class="box" id="chart-ts"></div>
<div class="box" id="chart-gp"></div>

</body>
</html>













