<!DOCTYPE html>
<html>
<head>

	<!-- Meta -->
	<title>Crop Selection Tool</title>
	<meta name="viewport" content="width=device-width,initial-scale=1,maximum-scale=1,user-scalable=no">
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<meta name="description" content="CropBASE - Crop Selection Tool" />

	<!-- CSS -->
	<link href="../assets/bootstrap-3.3.7/css/bootstrap.min.css" rel="stylesheet" media="screen">
	<link href="../assets/font-awesome-4.6.3/css/font-awesome.min.css" rel="stylesheet" media="screen">
	<link href="../assets/css/style.css" rel="stylesheet" type="text/css" media="all" />
	<link rel="stylesheet" href="js/themes/blue/style.css" type="text/css" media="print, projection, screen" />

	<!-- JS -->
	<script src="../assets/js/jquery-3.1.0.min.js" type="text/javascript"></script>
	<script src="../assets/bootstrap-3.3.7/js/bootstrap.min.js" type="text/javascript"></script>
	<script src="../assets/js/js.cookie-2.1.3.min.js" type="text/javascript"></script>
  <script src="../assets/js/jquery-lang-3.0.0.min.js" type="text/javascript"></script>

	<!-- Fonts -->
  <link href="https://fonts.googleapis.com/css?family=Open+Sans|Raleway" rel="stylesheet">

	<!-- D3 JS javascript -->
	<script src="http://d3js.org/d3.v3.min.js"></script>

	<!-- Show and Hide script -->
	<script src="js/showHide.js"></script>
	<script src="js/prefixfree.min.js"></script>

	<!-- Script for table sorter -->
	<script type="text/javascript" src="js/jquery-latest.js"></script>
	<script type="text/javascript" src="js/jquery.tablesorter.js"></script>
	<script type="text/javascript" src="js/jquery.tablesorter.min.js"></script>

</head>
<style>

/*
.chart rect {
  fill: steelblue;
}
*/
.chart .legend {
  fill: black;
  font: 14px sans-serif;
  text-anchor: start;
  font-size: 12px;
}

.chart text {
  fill: white;
  font: 10px sans-serif;
  text-anchor: end;
}

.chart .label {
  fill: black;
  font: 14px sans-serif;
  text-anchor: end;
}

.bar:hover {
  fill: brown;
}

.axis path,
.axis line {
  fill: none;
  stroke: #000;
  shape-rendering: crispEdges;
}

path {  stroke: #fff; }
path:hover {  opacity:0.9; }
rect:hover {  fill:blue; }
.axis {  font: 10px sans-serif; }
.legend tr{    border-bottom:1px solid grey; }
.legend tr:first-child{    border-top:1px solid grey; }

.axis path,
.axis line {
  fill: none;
  stroke: #000;
  shape-rendering: crispEdges;
}

.x.axis path {  display: none; }
.legend{
    margin-bottom:76px;
    display:inline-block;
    border-collapse: collapse;
    border-spacing: 0px;
}
.legend td{
    padding:4px 5px;
    vertical-align:bottom;
}
.legendFreq, .legendPerc{
    align:right;
    width:50px;
}

img {
    max-width: 100%;
    max-height: 100%;
}

</style>

<body>

	<!-- Navigation -->
	<?php include('../include/navigation-engine.php'); ?>

<?php
// include database parameters
include("phpCode/connParm.php");
// function to prepare the script for dashboard
include("phpCode/dashboard_var_check.php");
// include the star drawing function
include("phpCode/starRack.php");

$conn = new mysqli($host, $user, $password, $schema , $port);
if ($conn->connect_error) {
	die('Could not connect: ' .$conn->connect_error);
	echo "Please contact you System administrator";
}

// Get user selection
$cropnumbeSent=$_GET["number"];
$incomeSent=$_GET["income"];
$yieldSent=$_GET["yield"];
$vitASent=$_GET["vita"];
$choSent=$_GET["cho"];
$protienSent=$_GET["protein"];
$nameLocationSent=$_GET["id"];
/*echo '<h2> no is ' .$cropnumbeSentr
.' <br> income is ' .$incomeSent
.' <br> yield is ' .$yieldSent
.' <br> vitA is ' .$vitASent
.' <br> chod is ' .$choSent
.' <br> protien is ' .$protienSent
.'  </h2><br><br>';*/

// Building the query tables/ condition/ not null condiditon to make sure all data is there
if ($incomeSent){
	$table_names.=",cropbase_v_4_0.tmp_income i";
	$whereCond.=" and i.cropID=a.cropID ";
	$notNULL.=" and i.income_ha_season IS NOT NULL ";
}
if ($yieldSent){
	$table_names.=",cropbase_v_4_0.crop_stat y";
	$whereCond.=" and y.cropID=a.cropID ";
	$notNULL.=" and y.reported_yield_mean IS NOT NULL ";
}
if ($vitASent){
	$table_names.=",cropbase_v_4_0.nutrients_vitamins_and_their_precursors va";
	$whereCond.=" and va.cropID=a.cropID ";
	$notNULL.=" and va.vitamin_a_rae_mean IS NOT NULL ";
}
// cho and protien in the same table so one condition
if ($choSent || $protienSent){
	$table_names.=",cropbase_v_4_0.nutrient_proximate_composition nuco";
	$whereCond.=" and nuco.cropID=a.cropID ";
	if ($choSent){
		$notNULL.=" and nuco.carbohydrates_cho_mean IS NOT NULL ";
	}
	if ($protienSent){
		$notNULL.=" and nuco.protein_mean IS NOT NULL ";
	}
}


$location_search='bera';
if ($location_search=='bera'){

	// Building the query
	$sql_Bera_tts='SELECT a.name_var_lndrce , b.ttsr
	FROM cropbase_v_4_0.crop_taxonomy a, cropbase_v_4_0.crop_ttsr_soil_climate_ps b,cropbase_v_4_0.crop_stat c ,
    		cropbase_v_4_0.nutrient_proximate_composition d, cropbase_v_4_0.nutrients_vitamins_and_their_precursors e, cropbase_v_4_0.tmp_income f
  ' .$table_names
	.' where a.cropID=b.cropid
            and b.cropid=c.cropID
			and b.cropID=d.cropID
			and b.cropID=e.cropID
			and e.cropID=f.cropID ' .$whereCond .$notNULL .' ORDER BY b.ttsr DESC LIMIT ' .$cropnumbeSent .';';

	// printing the query
	//echo '<h2>' .$sql_Bera_tts .' </h2>';


	$result_sql_Bera_tts = $conn->query($sql_Bera_tts);
	//$row=$result_sql_Bera_tts->fetch_assoc();
	while($row=$result_sql_Bera_tts->fetch_assoc()) {
		//$arrayTTSR[]=array($row['name_var_lndrce'] , $row['ttsr']);
		$arrayTTSR[$row['name_var_lndrce']]=$row['ttsr'];
		//echo $row['name_var_lndrce'] .' : ' .$row['ttsr'] .'<br><hr>';
	}

	//print '<pre>';
	//print_r($arrayTTSR);
	//print '</pre>';
	if ($incomeSent){
		$notNULL2.=" and f.income_ha_season IS NOT NULL ";
	}
	if ($yieldSent){
		$notNULL2.=" and c.reported_yield_mean IS NOT NULL ";
	}
	if ($vitASent){
		$notNULL2.=" and e.vitamin_a_rae_mean IS NOT NULL ";
	}
	// cho and protien in the same table so one condition

	if ($choSent){
		$notNULL2.=" and d.carbohydrates_cho_mean IS NOT NULL ";
	}
	if ($protienSent){
		$notNULL2.=" and d.protein_mean IS NOT NULL ";
	}



	$top10TTSRkeys=array_keys($arrayTTSR);
	foreach($top10TTSRkeys as $cropname){
		//echo $cropname .'<hr>';
		$sqlGetCropData='SELECT b.cropID , b.name_var_lndrce, a.ttsr ,
		c.reported_yield_mean, d.carbohydrates_cho_mean , d.protein_mean ,e.vitamin_a_rae_mean, f.income_ha_season , a.climate , a.soil

		FROM cropbase_v_4_0.crop_ttsr_soil_climate_ps a , cropbase_v_4_0.crop_taxonomy b , cropbase_v_4_0.crop_stat c ,
    		cropbase_v_4_0.nutrient_proximate_composition d, cropbase_v_4_0.nutrients_vitamins_and_their_precursors e, cropbase_v_4_0.tmp_income f

		where  a.cropID=b.cropID
    		and b.cropID=c.cropID
			and b.cropID=d.cropID
			and b.cropID=e.cropID
			and e.cropID=f.cropID
			and a.ttsr IS NOT NULL' .$notNULL2 .'
			and b.name_var_lndrce="' .$cropname .'";
		;';
		//echo $sqlGetCropData .'<hr>';
		$Result_sqlGetCropData = $conn->query($sqlGetCropData);
		while($row2=$Result_sqlGetCropData->fetch_assoc()) {
			$arrayData[$row2['cropID']][]=array($row2['name_var_lndrce'],$row2['ttsr'], $row2['reported_yield_mean'] ,$row2['carbohydrates_cho_mean'],
					$row2['protein_mean'],$row2['vitamin_a_rae_mean'],$row2['income_ha_season'],$row2['climate'],$row2['soil']);
			$arrayCropNameID[$row2['name_var_lndrce']]=$row2['cropID'];

			//echo '<br>' .$row2['cropID'] .' : ' . $row2['reported_yield_mean'] .' : ' .$row2['name_var_lndrce'] .'<br>';
		}

	}
} else {
	echo 'Sorry No data found';
}

// extracting each value in array
foreach ($arrayData as $cropData){
	foreach ($cropData as $pieces){
		$rankTTSR[]=array($pieces[1],$pieces[0]);
		$rankYield[]=array($pieces[2],$pieces[0]);
		$rankCHO[]=array($pieces[3],$pieces[0]);
		$rankProtein[]=array($pieces[4],$pieces[0]);
		$rankVitaminA[]=array($pieces[5],$pieces[0]);
		$rankIncome[]=array($pieces[6],$pieces[0]);
		$rankClimate[]=array($pieces[7],$pieces[0]);
		$rankSoil[]=array($pieces[8],$pieces[0]);
		$allCropNames[]=$pieces[0];

	}
}


// Sorting the arrays
sort($rankTTSR);
sort($rankYield);
sort($rankCHO);
sort($rankProtein);
sort($rankVitaminA);
sort($rankIncome);
sort($rankClimate);
sort($rankSoil);


// assgined ranked keys to the array value . taking crop name as key
foreach ($rankTTSR as $key => $value){
	//$rankTTSRVal[]=array($key,(cropname) =>$value[1]);
	$rankTTSRVal[$value[1]]=$key+1;
}
foreach ($rankYield as $key => $value){
	//$rankYieldVal[]=array($key,(cropname) =>$value[1]);
	$rankYieldVal[$value[1]]=$key+1;
}
foreach ($rankCHO as $key => $value){
	//$rankCHOVal[]=array($key,(cropname) =>$value[1]);
	$rankCHOVal[$value[1]]=$key+1;

}
foreach ($rankProtein as $key => $value){
	//$rankProteinVal[]=array($key,(cropname) =>$value[1]);
	$rankProteinVal[$value[1]]=$key+1;
}
foreach ($rankVitaminA as $key => $value){
	//$rankVitaminAVal[]=array($key,(cropname) =>$value[1]);
	$rankVitaminAVal[$value[1]]=$key+1;
}
foreach ($rankIncome as $key => $value){
	//$rankVitaminAVal[]=array($key,(cropname) =>$value[1]);
	$rankIncomeVal[$value[1]]=$key+1;
}
foreach ($rankClimate as $key => $value){
	//$rankVitaminAVal[]=array($key,(cropname) =>$value[1]);
	$rankClimateVal[$value[1]]=$key+1;
}
foreach ($rankSoil as $key => $value){
	//$rankVitaminAVal[]=array($key,(cropname) =>$value[1]);
	$rankSoilVal[$value[1]]=$key+1;
}
// Create total ranking by summing all ranking
$totalRank=0;
foreach ($allCropNames as $crop){
	// Summ all ranks
	$totalRank = ($rankTTSRVal[$crop] + $rankYieldVal[$crop] + $rankCHOVal[$crop] + $rankProteinVal[$crop] + $rankVitaminAVal[$crop]+$rankIncomeVal[$crop]);
	$totalRankVal[]=array($totalRank,$crop);

	// sum all nutrition ranks
	$totaNulRank = ($rankCHOVal[$crop] + $rankProteinVal[$crop] + $rankVitaminAVal[$crop]);
	$totalRankNuVal[]=array($totaNulRank,$crop);


}

// sort the total rank
sort($totalRankVal);


// assign the rank as value and put crop name as key
foreach ($totalRankVal as $key => $value){
	$totalRankValFinal[$value[1]]=$key;
}

// assign the rank as value and put crop name as key
foreach ($totalRankNuVal as $key => $value){
	$totalRankNuValFinal[$value[1]]=$key;
}

// collect crop name as key and all ranking as vlaues
foreach ($totalRankValFinal as $crop => $value){
	$totalRankArry[$crop]=Array($totalRankValFinal[$crop],$rankTTSRVal[$crop], $rankYieldVal[$crop] , $rankCHOVal[$crop] , $rankProteinVal[$crop] , $rankVitaminAVal[$crop],$crop, $totalRankNuVal[$crop],$rankIncomeVal[$crop],$rankClimateVal[$crop],$rankSoilVal[$crop]);
}


$i=count($totalRankArry);
foreach ($totalRankArry as $key =>$cropData){
	if($i < 10) $topTenCrops[$key]=$cropData;
	$i--;
}

$top7=array_slice($totalRankArryReversed,0,7);



// Ranking Climate suitability Ranking and use Star rating
//echo '<h1 align="center"> Climate Suitability "Top 10 Crops" </h1> <h2> Climate Suitability Temprature & Rainfall </h2>';

arsort($rankTTSRVal);

$i=10; $x=1;
foreach ($rankTTSRVal as $name => $value){
	if ($i > 0 ){
		//echo '<br><h3>' .$x .'- ' .$rank  .'<img src="stars/' .$i .'.jpg" alt="Star Ranking" align="right" >' .'</h3>' .'<br>';
		//echo '<br><h3>' .$x .'- ' .'<a href="images/' .$arrayCropNameID[$name] .'.jpg">' .$name .'</a>'  .'<img src="stars/' .((int)($i/2)) .'.jpg" alt="Star Ranking" align="right" >' .'</h3>' .'<br>';
		$totalRankingTopTen[$name]=$totalRankValFinal[$name];
		$yieldRankingTopTen[$name]=$rankYieldVal[$name];
		//$nuRankingTopTen[$name]=$totalRankNuValFinal[$name];
		$choRankingTopTen[$name]=$rankCHOVal[$name];
		$proteinRankingTopTen[$name]=$rankProteinVal[$name];
		$vitaminARankingTopTen[$name]=$rankVitaminAVal[$name];
		$incomeRankingTopTen[$name]=$rankIncomeVal[$name];
		$climateRankingTopTen[$name]=$rankClimateVal[$name];
		$soilRankingTopTen[$name]=$rankSoilVal[$name];
		$totalRankArryTopTen[$name]=$totalRankArry[$name];



	}
	$i--; $x++;
}


// Ranking Total Ranking and use Star rating
//echo '<br><br><br><hr><br>';
//echo '<h1 align="center">  Total Ranking "For Top 10 Crops in Climate Suitability" </h1> <h2> Total ranking:Climate Suitability, Yield, CHO, Protien & Vitamin A </h2>';
//echo '<pre>';print_r($totalRankingTopTen); echo '</pre>';
arsort($totalRankingTopTen);
//echo '<pre>';print_r($totalRankingTopTen); echo '</pre>';

$i=10; $x=1;
foreach ($totalRankingTopTen as $name => $value){
	if ($i > 0 ){
		//echo '<br><h3>' .$x .'- ' .'<a href="images/' .$arrayCropNameID[$name] .'.jpg">' .$name .'</a>'  .'<img src="stars/' .((int)($i/2)) .'.jpg" alt="Star Ranking" align="right" >' .'</h3>' .'<br>';
	}
	$i--; $x++;
}



// Ranking Yield Ranking and use Star rating
//echo '<br><br><br><hr><br>';
//echo '<h1 align="center"> Yield Ranking "For Top 10 Crops in Climate Suitability" </h1> ';
//echo '<pre>';print_r($rankTTSRVal); echo '</pre>';
arsort($yieldRankingTopTen);
$i=10; $x=1;
foreach ($yieldRankingTopTen as $name => $value){
	if ($i > 0 ){
		//echo '<br><h3>' .$x .'- ' .'<a href="images/' .$arrayCropNameID[$name] .'.jpg">' .$name .'</a>'  .'<img src="stars/' .((int)($i/2)) .'.jpg" alt="Star Ranking" align="right" >' .'</h3>' .'<br>';
	}
	$i--; $x++;
}

// Ranking CHO Ranking and use Star rating
//echo '<br><br><br><hr><br>';
//echo '<h1 align="center"> CHO Ranking "For Top 10 Crops in Climate Suitability" </h1> ';
//echo '<pre>';print_r($rankTTSRVal); echo '</pre>';
arsort($choRankingTopTen);
$i=10; $x=1;
foreach ($choRankingTopTen as $name => $value){
	if ($i > 0 ){
	//	echo '<br><h3>' .$x .'- ' .'<a href="images/' .$arrayCropNameID[$name] .'.jpg">' .$name .'</a>'  .'<img src="stars/' .((int)($i/2)) .'.jpg" alt="Star Ranking" align="right" >' .'</h3>' .'<br>';
	}
	$i--; $x++;
}



// Ranking Vitamen Ranking and use Star rating
//echo '<br><br><br><hr><br>';
//echo '<h1 align="center"> Vitamin A Ranking "For Top 10 Crops in Climate Suitability" </h1> ';
arsort($vitaminARankingTopTen);
$i=10; $x=1;
foreach ($vitaminARankingTopTen as $name => $value){
	if ($i > 0 ){
		//echo '<br><h3>' .$x .'- ' .'<a href="images/' .$arrayCropNameID[$name] .'.jpg">' .$name .'</a>'  .'<img src="stars/' .((int)($i/2)) .'.jpg" alt="Star Ranking" align="right" >' .'</h3>' .'<br>';
	}
	$i--; $x++;
}

//echo '<br><br><br><hr><br>';
//echo '<h1 align="center"> Protein Ranking "For Top 10 Crops in Climate Suitability" </h1> ';
arsort($proteinRankingTopTen);
$i=10; $x=1;
foreach ($proteinRankingTopTen as $name => $value){
	if ($i > 0 ){
		//echo '<br><h3>' .$x .'- ' .'<a href="images/' .$arrayCropNameID[$name] .'.jpg">' .$name .'</a>'  .'<img src="stars/' .((int)($i/2)) .'.jpg" alt="Star Ranking" align="right" >' .'</h3>' .'<br>';
	}
	$i--; $x++;
}

arsort($incomeRankingTopTen);
$i=10; $x=1;
foreach ($incomeRankingTopTen as $name => $value){
	if ($i > 0 ){
		//echo '<br><h3>' .$x .'- ' .'<a href="images/' .$arrayCropNameID[$name] .'.jpg">' .$name .'</a>'  .'<img src="stars/' .((int)($i/2)) .'.jpg" alt="Star Ranking" align="right" >' .'</h3>' .'<br>';
	}
	$i--; $x++;
}

arsort($climateRankingTopTen);
$i=10; $x=1;
foreach ($climateRankingTopTen as $name => $value){
	if ($i > 0 ){
		//echo '<br><h3>' .$x .'- ' .'<a href="images/' .$arrayCropNameID[$name] .'.jpg">' .$name .'</a>'  .'<img src="stars/' .((int)($i/2)) .'.jpg" alt="Star Ranking" align="right" >' .'</h3>' .'<br>';
	}
	$i--; $x++;
}

arsort($soilRankingTopTen);
$i=10; $x=1;
foreach ($soilRankingTopTen as $name => $value){
	if ($i > 0 ){
		//echo '<br><h3>' .$x .'- ' .'<a href="images/' .$arrayCropNameID[$name] .'.jpg">' .$name .'</a>'  .'<img src="stars/' .((int)($i/2)) .'.jpg" alt="Star Ranking" align="right" >' .'</h3>' .'<br>';
	}
	$i--; $x++;
}

//[$name]=$rankCHO[$name];
//$vitaminARankingTopTen[$name]=$rankVitaminA[$name];
//$proteinRankingTopTen[$name]=$rankProtein[$name];

// Ranking Nutrition Ranking and use Star rating
/*echo '<br><br><br><hr><br>';
echo '<h1 align="center"> Nutrition Ranking "CHO, Protein, Vitamen A" "For Top 10 Crops in Climate Suitability" </h1> ';
echo '<pre>';print_r($nuRankingTopTen); echo '</pre>';
echo '<pre>';print_r($totalRankNuValFinal); echo '</pre>';
arsort($nuRankingTopTen);
$i=10; $x=1;
foreach ($nuRankingTopTen as $name => $value ){
	if ($i > 0 ){
		echo '<br><h3>' .$x .'- ' .'<a href="images/' .$arrayCropNameID[$name] .'.jpg">' .$name .'</a>'  .'<img src="stars/' .((int)($i/2)) .'.jpg" alt="Star Ranking" align="right" >' .'</h3>' .'<br>';
	}
	$i--; $x++;
}*/

// Call ranking function to enable the dashboard graph.
$totalRankArryReversed=array_reverse($totalRankArry);
//echo '<br><hr><h1 align="center"> Nutrition Ranking "For Top 10 Crops in Climate Suitability" </h1>';
//echo check_var_Rank(array_slice($totalRankArryReversed,0,7));
//echo check_var_Rank($totalRankArryTopTen);

?>






		</div>
<!--content-->
		<div class="content">
			<div class="container">

				<!--products-->
			<div class="content-mid">
				<h3><?php echo 'Crop Ranking For : ' .$nameLocationSent ?></h3>
				<label class="line"></label>
				<div class="mid-popular">





<?php
foreach ($totalRankArry as $key =>$cropData){
	$totalCustomizeRank=$cropData[1];
	//$totalCustomizeRank=0;
	if ($yieldSent){
		$totalCustomizeRank+=$cropData[2];
	}
	if ($choSent) {
		$totalCustomizeRank+=$cropData[3];
	}
	if ($protienSent) {
		$totalCustomizeRank+=$cropData[4];
	}
	if ($vitASent){
		$totalCustomizeRank+=$cropData[5];
	}
	if ($incomeSent) {
		$totalCustomizeRank+=$cropData[8];
	}
	$customizedRankArrayTmp[$cropData[6]]=$totalCustomizeRank;
}

	// Sort the array from highest to lowest
	asort($customizedRankArrayTmp);
	// put the rank based on the number not the summed rank
	foreach ($customizedRankArrayTmp as $key => $value){
		$customizedRankArray[]=$key;
	}
	// get the size of the array
	$maxArray=count($customizedRankArray);
	// put the correct name in the key and the rank from 0 to 10
	foreach ($customizedRankArray as $key => $name){
		$customizedStarArray[$name]=round(($key*10)/$maxArray);
	}
	// sort them so the 10 will be the first one
	arsort($customizedStarArray);
	//echo '<br><h2>hihgest is ' .$maxArray .'</h2>';
	arsort($customizedRankArrayTmp);
	echo '<pre>'; print_r($customizedRankArrayTmp); echo '</pre>';
	//echo '<pre>'; print_r($customizedRankArray); echo '</pre>';
	//echo '<pre>'; print_r($customizedStarArray); echo '</pre>';
?>




<?php
$i=10; $x=1;
foreach ($customizedRankArrayTmp as $name => $value){

		// starting the div
		echo '<div class="col-xs-12 col-sm-6 col-md-3 simpleCart_shelfItem">
				<div class=" mid-pop">
				<div class="pro-img">';

		$sql_getImage='select * from cropbase_v_4_0.metadata
						where cropid="' .$arrayCropNameID[$name] .'"
						and table_col_id="545"
						LIMIT 1;';
		$res_sql_getImage = $conn->query($sql_getImage);
		$result_Image=mysqli_fetch_array($res_sql_getImage);
		//echo '<img src="data:image/jpeg;base64,'.base64_encode( $result_Image['image'] ).'"/>';
		echo '	<img src="data:image/jpeg;base64,' .base64_encode( $result_Image['image'] ) .'" class="img-responsive" alt="" style="width:100% height:50;" >
				<div class="zoom-icon ">
				<a class="picture" href="images/' .$arrayCropNameID[$name] .'.html" rel="title" class="b-link-stripe b-animate-go  thickbox"><i class="glyphicon glyphicon-globe icon "></i></a>
				</div>
				</div>
				<div class="mid-1">
				<div class="women">
				<div class="women-top">
				<span></span>
				<h6><a href="images/' .$arrayCropNameID[$name] .'.html">' .$x .'. '.$name  .'</a></h6>
				</div>
				<div class="clearfix"></div>
				</div>
				<div class="mid-2">
				<p ><em class="item_price"> Crop Customised Rank </em></p>
				 <div class="block">';
		// This is a function to return a string that contains 5 star image ranking "font awsom"
		$stars=starRackFnBig(11- $customizedStarArray[$name]);
		echo $stars;
		echo '</div>
				<div class="clearfix"></div>
				</div>';

		// ### Start Climate Ranking ##### Get the array of data that has the crop ID
		$arrTmp1=$arrayData[$arrayCropNameID[$name]][0];
		// Round it up to be integer
		$numValuClimateTSR=round($arrTmp1[1]/10);
// 		echo '<div class="mid-2">
// 		<p ><em class="item_price"><a href="images/' .$arrayCropNameID[$name] .'.html"> Climate  Suitability: ' .number_format($arrTmp1[1], 2, '.', '')  .'%</em></p></a>

// 		  <div class="block">';
// 		// call star drawing function and 10- is for the rank as it is 1 is the highest
// 		$stars=starRackFn(10-$numValuClimateTSR);
// 		//echo $stars;
// 		echo '</div>
// 		<div class="clearfix"></div>
// 		</div>';
		// ### End TTSR ranking #####

		// ### Start Climate Ranking ##### Get the array of data that has the crop ID
			echo '<div class="mid-2">
			<p ><em class="item_price"><a href="images/' .$arrayCropNameID[$name] .'.html"> Climate Suitability: ' .number_format($arrTmp1[7], 2, '.', '')  .'%</em></p></a>
			<div class="block">';
			echo '</div>
			<div class="clearfix"></div>
			</div>';
		// ### End Climate Ranking #####

		// ### Start Soil Ranking ##### Get the array of data that has the crop ID
// 		echo '<div class="mid-2">
// 		<p ><em class="item_price"><a href="images/Soil/' .$arrayCropNameID[$name] .'-soil.html"> Soil Suitability: ' .number_format($arrTmp1[8], 2, '.', '')  .'%</em></p></a>
// 		  <div class="block">';
// 		echo '</div>
// 		<div class="clearfix"></div>
// 		</div>';
		// ### End Climate Ranking #####

		// ### Start Yield Ranking ##### Get the array of data that has the crop ID
		// Round it up to be integer
		if($yieldSent){
			$yieldStarValue=round(($yieldRankingTopTen[$name]/38)*10);
			echo '<div class="mid-2">
			<p ><em class="item_price"> Yield :' .$arrTmp1[2] .' Kg/ha </em></p>
			  <div class="block">';
				// call star drawing function and 10- is for the rank as it is 1 is the highest
				$stars=starRackFn(11-$yieldStarValue);
				//echo $stars;
				echo '</div>
			<div class="clearfix"></div>
			</div>';
		}
		// ### End Yield Ranking #####

		// ### Start CHO Ranking ##### Get the array of data that has the crop ID
		// Round it up to be integer
		if($choSent){
			$choStarValue=round(($choRankingTopTen[$name]/38)*10);
			echo '<div class="mid-2">
			<p ><em class="item_price"> CHO :' .$arrTmp1[3] .' mg/100g </em></p>
			  <div class="block">';
			// call star drawing function and 10- is for the rank as it is 1 is the highest
			$stars=starRackFn(11-$choStarValue);
			//echo $stars;
			echo '</div>
			<div class="clearfix"></div>
			</div>';
		}
		// ### End CHO Ranking #####

		// ### Start Protein Ranking ##### Get the array of data that has the crop ID
		// Round it up to be integer
		if($protienSent){
			$proteinStarValue=round(($proteinRankingTopTen[$name]/38)*10);
			echo '<div class="mid-2">
			<p ><em class="item_price"> Protein :' .$arrTmp1[4] .' mg/100g </em></p>
			  <div class="block">';
			// call star drawing function and 10- is for the rank as it is 1 is the highest
			$stars=starRackFn(11-$proteinStarValue);
			//echo $stars;
			echo '</div>
			<div class="clearfix"></div>
			</div>';
		}
		// ### End Protein Ranking #####

		// ### Start Protein Ranking ##### Get the array of data that has the crop ID
		// Round it up to be integer
		if ($vitASent){
			$vitAStarValue=round(($vitaminARankingTopTen[$name]/38)*10);
			echo '<div class="mid-2">
			<p ><em class="item_price"> Vitamin A:' .$arrTmp1[5] .' IU/100g </em></p>
			  <div class="block">';
			// call star drawing function and 10- is for the rank as it is 1 is the highest
			$stars=starRackFn(11-$vitAStarValue);
			//echo $stars;
			echo '</div>
			<div class="clearfix"></div>
			</div>';
		}
		if ($incomeSent){
			echo '<div class="mid-2">
			<p ><em class="item_price"> Income: RM' .$arrTmp1[6] .' Ha/Season </em></p>
			  <div class="block">';
			// call star drawing function and 10- is for the rank as it is 1 is the highest
			$stars=starRackFn(11-$vitAStarValue);
			//echo $stars;
			echo '</div>
			<div class="clearfix"></div>
			</div>';
		}
		// ### End Protein Ranking #####




		echo '</div>
			</div>
			</div>';
		//	echo '<br><h3>' .$x .'- ' .'<a href="images/' .$arrayCropNameID[$name] .'.jpg">' .$name .'</a>'  .'<img src="stars/' .((int)($i/2)) .'.jpg" alt="Star Ranking" align="right" >' .'</h3>' .'<br>';

	$i--; $x++;

}

?>



				<!-- PHP Start: Crop Profile Rank Div: This is the div that shows the crop profile in the ranking tool. Image, Name,  -->

				<?php
					/*foreach ($totalRankArry as $key =>$cropData){
						// starting the div
						echo '<div class="col-md-3 item-grid simpleCart_shelfItem">
								<div class=" mid-pop">
								<div class="pro-img">';

						$sql_getImage='select * from cropbase_v_4_0.KBS_Metadata
										where cropid="' .$arrayCropNameID[$cropData[6]] .'"
										and table_col_id="545"
										LIMIT 1;';
						$res_sql_getImage = $conn->query($sql_getImage);
						$result_Image=mysqli_fetch_array($res_sql_getImage);
						//echo '<img src="data:image/jpeg;base64,'.base64_encode( $result_Image['image'] ).'"/>';
						echo '	<img src="data:image/jpeg;base64,' .base64_encode( $result_Image['image'] ) .'" class="img-responsive" alt="" style="width:100%;">
									<div class="zoom-icon ">
									<a class="picture" href="images/pc.jpg" rel="title" class="b-link-stripe b-animate-go  thickbox"><i class="glyphicon glyphicon-search icon "></i></a>
									<a href="single.html"><i class="glyphicon glyphicon-menu-right icon"></i></a>
									</div>
									</div>
									<div class="mid-1">
									<div class="women">
									<div class="women-top">
										<span>Fruits</span>
										<h6><a href="single.html">' .$cropData[6] .'</a></h6>
										</div>

										<div class="clearfix"></div>
										</div>
										<div class="mid-2">
											<p ><em class="item_price">' .$cropData[0] .'</em></p>
											  <div class="block">
												<i class="fa fa-star" style="color:orange"></i>
												<i class="fa fa-star" style="color:orange"></i>
												<i class="fa fa-star" style="color:orange"></i>
												<i class="fa fa-star" style="color:gray"></i>
												<i class="fa fa-star" style="color:gray"></i>
											</div>

											<div class="clearfix"></div>
										</div>

									</div>
								</div>
								</div>';
					}*/

				//echo '<pre>';print_r($totalRankingTopTen); echo '</pre>';
				// Highest Yield
					if ($scenarioVal=='1'){
						$i=10; $x=1;
						foreach ($yieldRankingTopTen as $name => $value){
							if ($i > 0 ){
								// starting the div
								echo '<div class="col-md-3 item-grid simpleCart_shelfItem">
								<div class=" mid-pop">
								<div class="pro-img">';

								$sql_getImage='select * from cropbase_v_4_0.metadata
										where cropid="' .$arrayCropNameID[$name] .'"
										and table_col_id="545"
										LIMIT 1;';
								$res_sql_getImage = $conn->query($sql_getImage);
								$result_Image=mysqli_fetch_array($res_sql_getImage);
								// ### Start Climate Ranking ##### Get the array of data that has the crop ID
								$arrTmp1=$arrayData[$arrayCropNameID[$name]][0];
								//echo '<img src="data:image/jpeg;base64,'.base64_encode( $result_Image['image'] ).'"/>';
								echo '	<img src="data:image/jpeg;base64,' .base64_encode( $result_Image['image'] ) .'" class="img-responsive" alt="" style="width:100% height:50;" >
									<div class="zoom-icon ">
										<a class="picture" href="images/' .$arrayCropNameID[$name] .'.gif" rel="title" class="b-link-stripe b-animate-go  thickbox"><i class="glyphicon glyphicon-search icon "></i></a>

									</div>
										</div>
										<div class="mid-1">
										<div class="women">
										<div class="women-top">
											<span></span>
											<h6><a href="images/' .$arrayCropNameID[$name] .'.html">' .$x .'-' .$name  .'</a></h6>
											</div>

											<div class="clearfix"></div>
											</div>

											<div class="mid-2">
												<p > Expected Yield: ' .$arrTmp1[2] .' Kg/ha </p>
												  <div class="block">';
								// This is a function to return a string that contains 5 star image ranking "font awsom"
								$stars=starRackFnBig($x);
								echo $stars;
								echo '</div>
												<div class="clearfix"></div>
											</div>';


								// ### Start Total Ranking ##### Get the array of data that has the crop ID
								// Round it up to be integer
								$totalStarValue=round(($totalRankingTopTen[$name]/38)*10);
								echo '<div class="mid-2">
											<p ><em class="item_price"> Overall Rank </em></p>';

								// call star drawing function and 10- is for the rank as it is 1 is the highest
								echo   '<div class="block">';
								$stars=starRackFn(11-$totalStarValue);
								echo $stars;
								echo '</div>';
											echo '<div class="clearfix"></div>
											</div>';
								// ### End Overall Ranking #####


								// ### Start Climate Ranking ##### Get the array of data that has the crop ID
								//$arrTmp1=$arrayData[$arrayCropNameID[$name]][0];
								// Round it up to be integer
								$numValuClimateTSR=round($arrTmp1[1]/10);
								echo '<div class="mid-2">
												<p ><em class="item_price"> Climate Suit: ' .number_format($arrTmp1[1], 2, '.', '')  .'%</em></p>';

								// call star drawing function and 10- is for the rank as it is 1 is the highest
								/*echo '<div class="block">';
								$stars=starRackFn(10-$numValuClimateTSR);
								echo $stars;
								echo '</div>*/
												echo '<div class="clearfix"></div>
											</div>';
								// ### End Climate ranking #####



								/*
								// ### Start CHO Ranking ##### Get the array of data that has the crop ID
								// Round it up to be integer
								$choStarValue=round(($choRankingTopTen[$name]/38)*10);
								echo '<div class="mid-2">
											<p ><em class="item_price"> CHO :' .$arrTmp1[3] .' mg/100g </em></p>
											  <div class="block">';
								// call star drawing function and 10- is for the rank as it is 1 is the highest
								$stars=starRackFn(11-$choStarValue);
								echo $stars;
								echo '</div>
											<div class="clearfix"></div>
											</div>';
								// ### End CHO Ranking #####

								// ### Start Protein Ranking ##### Get the array of data that has the crop ID
								// Round it up to be integer
								$proteinStarValue=round(($proteinRankingTopTen[$name]/38)*10);
								echo '<div class="mid-2">
											<p ><em class="item_price"> Protein :' .$arrTmp1[4] .' mg/100g </em></p>
											  <div class="block">';
								// call star drawing function and 10- is for the rank as it is 1 is the highest
								$stars=starRackFn(11-$proteinStarValue);
								echo $stars;
								echo '</div>
											<div class="clearfix"></div>
											</div>';
								// ### End Protein Ranking #####

								// ### Start Protein Ranking ##### Get the array of data that has the crop ID
								// Round it up to be integer
								$vitAStarValue=round(($vitaminARankingTopTen[$name]/38)*10);
								echo '<div class="mid-2">
											<p ><em class="item_price"> Vitamin A:' .$arrTmp1[5] .' IU/100g </em></p>
											  <div class="block">';
								// call star drawing function and 10- is for the rank as it is 1 is the highest
								$stars=starRackFn(11-$vitAStarValue);
								echo $stars;
								echo '</div>
											<div class="clearfix"></div>
											</div>';
								// ### End Protein Ranking #####*/




								echo '</div>
									</div>
									</div>';
								//	echo '<br><h3>' .$x .'- ' .'<a href="images/' .$arrayCropNameID[$name] .'.jpg">' .$name .'</a>'  .'<img src="stars/' .((int)($i/2)) .'.jpg" alt="Star Ranking" align="right" >' .'</h3>' .'<br>';
							}
							$i--; $x++;

						}

						// Start of Second Senario High Income
					}elseif($scenarioVal=='2'){
						$i=10; $x=1;
						foreach ($incomeRankingTopTen as $name => $value){
							if ($i > 0 ){
								// starting the div
								echo '<div class="col-md-3 item-grid simpleCart_shelfItem">
								<div class=" mid-pop">
								<div class="pro-img">';

								$sql_getImage='select * from cropbase_v_4_0.metadata
										where cropid="' .$arrayCropNameID[$name] .'"
										and table_col_id="545"
										LIMIT 1;';
								$res_sql_getImage = $conn->query($sql_getImage);
								$result_Image=mysqli_fetch_array($res_sql_getImage);
								// ### Start Climate Ranking ##### Get the array of data that has the crop ID
								$arrTmp1=$arrayData[$arrayCropNameID[$name]][0];
								//echo '<img src="data:image/jpeg;base64,'.base64_encode( $result_Image['image'] ).'"/>';
								echo '	<img src="data:image/jpeg;base64,' .base64_encode( $result_Image['image'] ) .'" class="img-responsive" alt="" style="width:100% height:50;" >
									<div class="zoom-icon ">
										<a class="picture" href="images/' .$arrayCropNameID[$name] .'.gif" rel="title" class="b-link-stripe b-animate-go  thickbox"><i class="glyphicon glyphicon-search icon "></i></a>

									</div>
										</div>
										<div class="mid-1">
										<div class="women">
										<div class="women-top">
											<span></span>
											<h6><a href="images/' .$arrayCropNameID[$name] .'.html">' .$x .'-' .$name  .'</a></h6>
											</div>

											<div class="clearfix"></div>
											</div>

											<div class="mid-2">
												<p > Income: RM ' .$arrTmp1[6] .' /Ha/Season </p>
												  <div class="block">';
								// This is a function to return a string that contains 5 star image ranking "font awsom"
								$stars=starRackFnBig($x);
								echo $stars;
								echo '</div>
												<div class="clearfix"></div>
											</div>';


								// ### Start Total Ranking ##### Get the array of data that has the crop ID
								// Round it up to be integer
								$totalStarValue=round(($totalRankingTopTen[$name]/38)*10);
								echo '<div class="mid-2">
											<p ><em class="item_price"> Overall Rank </em></p>';

								// call star drawing function and 10- is for the rank as it is 1 is the highest
								echo   '<div class="block">';
								$stars=starRackFn(11-$totalStarValue);
								echo $stars;
								echo '</div>';
											echo '<div class="clearfix"></div>
											</div>';
								// ### End Overall Ranking #####


								// ### Start Climate Ranking ##### Get the array of data that has the crop ID
								//$arrTmp1=$arrayData[$arrayCropNameID[$name]][0];
								// Round it up to be integer
								$numValuClimateTSR=round($arrTmp1[1]/10);
								echo '<div class="mid-2">
												<p ><em class="item_price"> Climate Suit: ' .number_format($arrTmp1[1], 2, '.', '')  .'%</em></p>';

								// call star drawing function and 10- is for the rank as it is 1 is the highest
								/*echo '<div class="block">';
								$stars=starRackFn(10-$numValuClimateTSR);
								echo $stars;
								echo '</div>*/
												echo '<div class="clearfix"></div>
											</div>';
								// ### End Climate ranking #####



								/*
								// ### Start CHO Ranking ##### Get the array of data that has the crop ID
								// Round it up to be integer
								$choStarValue=round(($choRankingTopTen[$name]/38)*10);
								echo '<div class="mid-2">
											<p ><em class="item_price"> CHO :' .$arrTmp1[3] .' mg/100g </em></p>
											  <div class="block">';
								// call star drawing function and 10- is for the rank as it is 1 is the highest
								$stars=starRackFn(11-$choStarValue);
								echo $stars;
								echo '</div>
											<div class="clearfix"></div>
											</div>';
								// ### End CHO Ranking #####

								// ### Start Protein Ranking ##### Get the array of data that has the crop ID
								// Round it up to be integer
								$proteinStarValue=round(($proteinRankingTopTen[$name]/38)*10);
								echo '<div class="mid-2">
											<p ><em class="item_price"> Protein :' .$arrTmp1[4] .' mg/100g </em></p>
											  <div class="block">';
								// call star drawing function and 10- is for the rank as it is 1 is the highest
								$stars=starRackFn(11-$proteinStarValue);
								echo $stars;
								echo '</div>
											<div class="clearfix"></div>
											</div>';
								// ### End Protein Ranking #####

								// ### Start Protein Ranking ##### Get the array of data that has the crop ID
								// Round it up to be integer
								$vitAStarValue=round(($vitaminARankingTopTen[$name]/38)*10);
								echo '<div class="mid-2">
											<p ><em class="item_price"> Vitamin A:' .$arrTmp1[5] .' IU/100g </em></p>
											  <div class="block">';
								// call star drawing function and 10- is for the rank as it is 1 is the highest
								$stars=starRackFn(11-$vitAStarValue);
								echo $stars;
								echo '</div>
											<div class="clearfix"></div>
											</div>';
								// ### End Protein Ranking #####*/




								echo '</div>
									</div>
									</div>';
								//	echo '<br><h3>' .$x .'- ' .'<a href="images/' .$arrayCropNameID[$name] .'.jpg">' .$name .'</a>'  .'<img src="stars/' .((int)($i/2)) .'.jpg" alt="Star Ranking" align="right" >' .'</h3>' .'<br>';
							}
							$i--; $x++;

						}

						// Start of Second Senario High Income
					} elseif($scenarioVal=='4'){

					}


				?>


				<!-- Start: Crop Profile Rank Div -->


				<!-- Just Moringa
				<div class="col-md-3 item-grid simpleCart_shelfItem">
					<div class=" mid-pop">
					<div class="pro-img">
					<?php
					$sql_getImage='select * from cropbase_v_4_0.metadata
										where cropid="10001000030"
										and table_col_id="545"
										LIMIT 1;';
					$res_sql_getImage = $conn->query($sql_getImage);
					$result_Image=mysqli_fetch_array($res_sql_getImage);
					//echo '<img src="data:image/jpeg;base64,'.base64_encode( $result_Image['image'] ).'"/>';
					echo '	<img src="data:image/jpeg;base64,' .base64_encode( $result_Image['image'] ) .'" class="img-responsive" alt="" style="width:100%;">';

					?>
						<div class="zoom-icon ">
						<a class="picture" href="images/pc.jpg" rel="title" class="b-link-stripe b-animate-go  thickbox"><i class="glyphicon glyphicon-search icon "></i></a>
						<a href="single.html"><i class="glyphicon glyphicon-menu-right icon"></i></a>
						</div>
						</div>
						<div class="mid-1">
						<div class="women">
						<div class="women-top">
							<span></span>
							<h6><a href="test.html">Moringa</a></h6>
							</div>
							<div class="img item_add">
							</div>
							<div class="clearfix"></div>
							</div>
							<div class="mid-2">
								<p ><em class="item_price">Crop Rank</em></p>
								  <div class="block">
									<i class="fa fa-star" style="color:orange"></i>
									<i class="fa fa-star" style="color:orange"></i>
									<i class="fa fa-star" style="color:orange"></i>
									<i class="fa fa-star" style="color:orange"></i>
									<i class="fa fa-star" style="color:orange"></i>
								</div>

								<div class="clearfix"></div>
							</div>

							</div>
						</div>
					</div> -->

					</div>
				</div>
			</div>
			</div>







</body>

</html>
