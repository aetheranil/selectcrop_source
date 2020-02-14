<?php
// include database parameters
include("engine/phpCode/connParm.php");
// function to prepare the script for dashboard
include("engine/phpCode/dashboard_var_check.php");
// include the star drawing function
include("engine/phpCode/starRack.php");

$conn = new mysqli($host, $user, $password, $schema , $port);
if ($conn->connect_error) {
	die('Could not connect: ' .$conn->connect_error);
	echo "Please contact you System administrator";
}
$nameLocationSent=$_GET["id"];
$lon=$_GET["lon"];
$lat=$_GET["lat"];
$rad=$_GET["rad"];
?>
<!DOCTYPE html>
<html>
<head>

	<!-- Meta -->
	<title>CropBASE | Diversification Tool</title>
	<meta name="viewport" content="width=device-width,initial-scale=1,maximum-scale=1,user-scalable=no">
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<meta name="description" content="CropBASE - Crop Selection Tool" />

	<!-- CSS -->
	<link href="assets/bootstrap-3.3.7/css/bootstrap.min.css" rel="stylesheet" media="screen">
	<link href="assets/font-awesome-4.6.3/css/font-awesome.min.css" rel="stylesheet" media="screen">
	<link href="assets/css/style.css" rel="stylesheet" type="text/css" media="all" />
	<link rel="stylesheet" href="engine/js/themes/blue/style.css" type="text/css" media="print, projection, screen" />
	
	<!-- Magnific Popup core CSS file http://dimsemenov.com/plugins/magnific-popup/  -->
	<link rel="stylesheet" href="assets/css/magnific-popup.css">
	<link rel="stylesheet" type="text/css" href="assets/css/popupdialog.css">

	<!-- Fonts -->
	<link href="https://fonts.googleapis.com/css?family=Open+Sans|Raleway" rel="stylesheet">

 	<!-- JS -->
 	<script src="assets/js/jquery-3.1.0.min.js" type="text/javascript"></script>
 	<script src="assets/bootstrap-3.3.7/js/bootstrap.min.js" type="text/javascript"></script>
 	<script src="assets/js/js.cookie-2.1.3.min.js" type="text/javascript"></script>
   	<script src="assets/js/jquery-lang-3.0.0.min.js" type="text/javascript"></script>

    <!-- Script for table sorter --><!-- NEED NEWER JQUERY 3.1.0 - INCLUDED ABOVE
  	<script type="text/javascript" src="engine/js/jquery-latest.js"></script>-->
  	<script type="text/javascript" src="engine/js/jquery.tablesorter.js"></script>
  	<script type="text/javascript" src="engine/js/jquery.tablesorter.min.js"></script>
    <!-- Script for table sorter END -->
  
  	<!-- Magnific Popup core JS file  http://dimsemenov.com/plugins/magnific-popup/ -->
	<script src="assets/js/jquery.magnific-popup.js"></script>
	<script src="assets/js/popupdialog.js"></script>
	<!-- End of Magnific -->


    <!-- The below style is specifially for the grade view of the Climate suitability
    http://www.w3schools.com/colors/colors_mixer.asp TOP #FF0000 Lest #00CC00-->
    <style>
    .bg0 { background-color: #FF0000; display: flex; }
    .bg1 { background-color: #F20A00; display: flex; }
    .bg2 { background-color: #E61400; display: flex; }
    .bg3 { background-color: #D91F00; display: flex; }
    .bg4 { background-color: #CC2900; display: flex; }
    .bg5 { background-color: #BF3300; display: flex; }
    .bg6 { background-color: #B23D00; display: flex; }
    .bg7 { background-color: #A64700; display: flex; }
    .bg8 { background-color: #995200; display: flex; }
    .bg9 { background-color: #8C5C00; display: flex; }
    .bg10 { background-color: #806600; display: flex; }
    .bg11 { background-color: #737000; display: flex; }
    .bg12 { background-color: #667A00; display: flex; }
    .bg13 { background-color: #598500; display: flex; }
    .bg14 { background-color: #4D8F00; display: flex; }
    .bg15 { background-color: #409900; display: flex; }
    .bg16 { background-color: #33A300; display: flex; }
    .bg17 { background-color: #26AD00; display: flex; }
    .bg18 { background-color: #19B800; display: flex; }
    .bg19 { background-color: #0DC200; display: flex; }
    .bg20 { background-color: #00CC00; display: flex; }
    </style>

    <!-- css for table reflow on mobile -->
     <style media="screen">
     @media ( max-width: 479px ) {

     .ui-table-reflow th {
     	-webkit-box-sizing: border-box;
     	-moz-box-sizing: border-box;
     	box-sizing: border-box;
     	float: left;
     	width: 25% !important;
     	height: auto !important;
     }
     .ui-table-reflow th.cropname,
		 .ui-table-reflow th.avg-year {
     	width: 100% !important;
     	text-align: center;
     }

     .ui-table-reflow td{
     	-webkit-box-sizing: border-box;
     	-moz-box-sizing: border-box;
     	box-sizing: border-box;
     	float: right;
     	width: 90% !important;
     	height: auto !important;
     }
     .ui-table-reflow td.cropname {
     	width: 100% !important;
     	padding-top: 20px;
     	/*background-color: #CDCDCD;*/
     }
     .ui-table-reflow td.month:before {
     	position: absolute;
     	float: left;
     	left: 25px;
     }
		 .ui-table-reflow td.m00:before { content: 'Avg.'; }
     .ui-table-reflow td.m01:before { content: 'Jan'; }
     .ui-table-reflow td.m02:before { content: 'Feb'; }
     .ui-table-reflow td.m03:before { content: 'Mac'; }
     .ui-table-reflow td.m04:before { content: 'Apr'; }
     .ui-table-reflow td.m05:before { content: 'May'; }
     .ui-table-reflow td.m06:before { content: 'Jun'; }
     .ui-table-reflow td.m07:before { content: 'Jul'; }
     .ui-table-reflow td.m08:before { content: 'Aug'; }
     .ui-table-reflow td.m09:before { content: 'Sep'; }
     .ui-table-reflow td.m10:before { content: 'Oct'; }
     .ui-table-reflow td.m11:before { content: 'Nov'; }
     .ui-table-reflow td.m12:before { content: 'Dec'; }
     .ui-table-reflow td.season:before { content: 'Sesn'; }

     </style>

</head>

<body>
	<?php
	include('include/navigation-default.php');
	include('include/parallax-banner.php')
	?>

	<!-- ui-kit -->
	<div class="ui-kit">
		<div class="container">
			<div class="ui-kit-grids">
				<div class="col-md-8 col-md-offset-2 ui-kit-grid-left">
					<div class="login-form">
						<form name='locationSel' action="engine/divtool.php" autocomplete="on">
							<div class="clearfix"></div>
							<?php

							 $search='bera';

							 // Displaying the fields based ont he sent address.
							 $locNameDivided=explode(",",$nameLocationSent);
							 $secondLevelName=explode(" ",$locNameDivided[count($locNameDivided)-3]);
							 echo '<div class="bird-text">
							  <div class="bird-text-grids">
							  <div class="bird-text-grid-centre">
							  <h3><b>Country: </b>' .$locNameDivided[count($locNameDivided)-1] .'</h3>
							  <h3><b>State: </b>' .$locNameDivided[count($locNameDivided)-2] .'</h3>
	                          <h3><b>Full Address: </b>' .$nameLocationSent .'</h3>
							  ';

							 // Run R script World data for Climate
							 exec("Rscript Rworkshop/test3.R $lon $lat", $data_R);
// 							 							 echo  '<pre>';
// 							 							 print_r($data_R);
// 							 							 echo '</pre>';
							 					

							 // Printing Long & Lat sent by Google
							 $lonInR = explode('"', $data_R[9]);
							 $latInR = explode('"', $data_R[10]);
							 echo '<h3> <b>You Location is:</b> Lon: "' .$lonInR[1] .'"  <br>and Lat: "' .$latInR[1] .'" </h3>';
// 							 exec("Rscript Rworkshop/Y_w.R $data_R[50] $data_R[56]   ", $data_Y);
							 # exec("Rscript Rworkshop/Y_w.R $crop1 $crop2 $crop3", $data_Y);
// 							 echo '<br><hr>';
// 							 echo  '<pre>';
// 							 print_r($data_Y);
// 							 echo '</pre>';
							 	

							 // End the address Location printing
							 echo '</div>
							  <div class="clearfix"> </div>
							  </div>
							  </div> <br>';

							 // Truncate the table KBS_Crop_TTSR_soil_climate_PS to store new point data
							 $sql_truncate_crop_climate_soil_point_based='TRUNCATE `cropbase_v_4_0`.`crop_ttsr_soil_climate_ps`;';
							 $res_truncate_table_climate_soil_point_based = $conn->query($sql_truncate_crop_climate_soil_point_based);

							 //Transfer the result array of R to array of cropID and  TTSR to database tmp table
							 $id_incr=0;
							 foreach ($data_R as $key=>$tmpRowResults ){
							  if ($key > '16'){
							   // Dividing the array into strings divided by ,
							   $tmpRowResultsDivided = explode(',', $tmpRowResults);
							   // Averging the climate on 12 Months
							   $point_based_ttsr= (    $tmpRowResultsDivided[2] + $tmpRowResultsDivided[3]  + $tmpRowResultsDivided[4]  + $tmpRowResultsDivided[5]
                    							     + $tmpRowResultsDivided[6] + $tmpRowResultsDivided[7]  + $tmpRowResultsDivided[8]  + $tmpRowResultsDivided[9]
                    							  + $tmpRowResultsDivided[10] + $tmpRowResultsDivided[11]  + $tmpRowResultsDivided[12]  + $tmpRowResultsDivided[13]
							     )/12;

							   // Get the crop name from the cropID
							   $sqlGetCropName='SELECT name_var_lndrce
							  FROM cropbase_v_4_0.crop_taxonomy
							  where  cropID='.$tmpRowResultsDivided[1];
							   $resultSqlGetCropName = $conn->query($sqlGetCropName);
							   while($row=$resultSqlGetCropName->fetch_assoc()) {
							   	$tmpCropName=$row['name_var_lndrce'];
							   }


							   // Here we ignored the soil suitability for now. and we used average climate for both climate col and total suitability col and soil is just 100
							   $sql_insert_crop_climate_soil_from_R="INSERT INTO `cropbase_v_4_0`.`crop_ttsr_soil_climate_ps`
							        (`cropid`, `climate`, `soil`, `ttsr`, `jan`, `feb`, `mar`, `apr`, `may`, `june`, `july`, `aug`, `sept`, `oct`, `nov`, `dec`)
							         VALUES ('" .$tmpRowResultsDivided[1] ."', '" .$point_based_ttsr ."', '100', '" .$point_based_ttsr ."'
		                                   , '" .$tmpRowResultsDivided[2] ."', '" .$tmpRowResultsDivided[3] ."', '" .$tmpRowResultsDivided[4] ."', '" .$tmpRowResultsDivided[5] ."'
						                   , '" .$tmpRowResultsDivided[6] ."', '" .$tmpRowResultsDivided[7] ."', '" .$tmpRowResultsDivided[8] ."', '" .$tmpRowResultsDivided[9] ."'
							               , '" .$tmpRowResultsDivided[10] ."', '" .$tmpRowResultsDivided[11] ."', '" .$tmpRowResultsDivided[12] ."', '" .$tmpRowResultsDivided[13] ."'
							          );";
							  }
// 							  echo '<br> ' .$sql_insert_crop_climate_soil_from_R .'<br> ';
							  $res_upload_table_climate_soil_point_based = $conn->query($sql_insert_crop_climate_soil_from_R);
							 }

							// building the query and ignoring all other values.
							 $sql_Bera_tts='SELECT b.cropID , b.name_var_lndrce, a.ttsr ,a.jan, a.feb, a.mar, a.apr,a.may, a.june, a.july, a.aug, a.sept, a.oct, a.nov,a.dec 
                                 ,round((s.period_between_harvest_max + s.period_between_harvest_min)/60) season
                                 FROM cropbase_v_4_0.crop_ttsr_soil_climate_ps a , cropbase_v_4_0.crop_taxonomy b , cropbase_v_4_0.agro_crop_season s
                                 where  a.cropID=b.cropID
                                 
                                 and a.cropID=s.cropid
                                 ';
							 $result_sql_Bera_tts = $conn->query($sql_Bera_tts);
							 //$row=$result_sql_Bera_tts->fetch_assoc();
							 while($row=$result_sql_Bera_tts->fetch_assoc()) {
							  //$arrayTTSR[]=array($row['name_var_lndrce'] , $row['ttsr']);
							  $arrayTTSR[$row['name_var_lndrce']]=$row['ttsr'];
							  $arrayCropID[$row['name_var_lndrce']]=$row['cropID'];
							  //echo $row['name_var_lndrce'] .' : ' .$row['ttsr'] .'<br><hr>';
 							  $cropsClimateDataMod[$row['cropID']][]=
            							  array($row['jan'] , $row['feb'] , $row['mar'] , $row['apr'] , $row['may'] , $row['june']
            							      , $row['july'] , $row['aug'] , $row['sept'] ,  $row['oct'] , $row['nov'] , $row['dec'] ,
            							        $row['name_var_lndrce'],$row['season']);
							 }

							 // sorting the array based on ttsr
							 arsort ($arrayTTSR);


							 //############ this is only to show all crops
							 $top10TTSR=$arrayTTSR;
							 echo '<div> <a href="customize.php?id=' .$nameLocationSent .'" class="myButton">Customize Your Crops</a></div></div>';


							?>
						</form>
					</div>
				</div>
				<div class="clearfix"></div>
			</div>
			<div class="clearfix"></div>
		</div>
	</div>


	<div class="bird-text">
		<div class="bird-text-grids">
			<div class="bird-text-grid-centre">
				<h2> Crops that can grow in your selected area: </h2><br>
				<h5>Note: Crop Climate Suitability Index Ranking (based on historical rainfall and temperature average data 1950-2000) per season length.</h5>
				<h5>Note: Please click on the month to sort the crops.</h5>
				<img src="images/scale.jpg" height="50" width="300">
				<table id="DataTable" class="tablesorter ui-table-reflow">
					<thead>
						<tr>
						    <th class="cropname">Crop Name</th>
						    <th>Season</th>
						    <th class="avg-year">Average Yearly</th>
						    <th>Jan</th>
						    <th>Feb</th>
						    <th>March</th>
						    <th>April</th>
						    <th>May</th>
						    <th>June</th>
						    <th>July</th>
						    <th>Aug</th>
						    <th>Sept</th>
						    <th>Oct</th>
						    <th>Nov</th>
						    <th>Dec</th>
						</tr>

					</thead>
				<tbody>
<!-- 				########## This is to show the popup code with no changes -->
<!-- 				 <a class="popup-with-zoom-anim nav-link" href="#ref-small-dialogx"> -->
<!-- 		 			<i class="fa fa-book"></i> -->
<!-- 		 		</a> -->
<!-- 		 		<div id="ref-small-dialogx" class="zoom-anim-dialog mfp-hide small-dialog"> -->
<!-- 					<h3> References </h3> -->
<!-- 					<ul> -->
<!-- 						<li> <a href="">asdasd</a></li> -->
<!-- 					</ul> -->
<!-- 				</div> -->
				<?php
				$dialogCounter=0;
					foreach ($cropsClimateDataMod as $cropCSmonthly ){

						$cropCSyearly=($cropCSmonthly[0][0]+$cropCSmonthly[0][1]+$cropCSmonthly[0][2]+
										$cropCSmonthly[0][3]+$cropCSmonthly[0][4]+$cropCSmonthly[0][5]+
										$cropCSmonthly[0][6]+$cropCSmonthly[0][7]+$cropCSmonthly[0][8]+
										$cropCSmonthly[0][9]+$cropCSmonthly[0][10]+$cropCSmonthly[0][11])/12;
						echo '<tr>';
						// create  popup dialog for each crop with a dialog id using the counter 
						echo '<td><a class="popup-with-zoom-anim nav-link" href="#ref-small-dialog' .$dialogCounter .'">' .$cropCSmonthly[0][12] .'</a></td>';
						echo '<td class="month season">' .$cropCSmonthly[0][13] .' Months</td>';
						echo '<td class="month m00"><span class="bg' .round($cropCSyearly/5) .'" >' .round($cropCSyearly) .'%</span> </td>';
						// Use the round function to transfer the range of 100-0 to 21 color from red to green. refer to style bg0-20
						echo '<td class="month m01"><span class="bg' .round($cropCSmonthly[0][0]/5) .'" >' .$cropCSmonthly[0][0] .'%</span>  </td>';
						echo '<td class="month m02"><span class="bg' .round($cropCSmonthly[0][1]/5) .'" >' .$cropCSmonthly[0][1] .'%</span>  </td>';
						echo '<td class="month m03"><span class="bg' .round($cropCSmonthly[0][2]/5) .'" >' .$cropCSmonthly[0][2] .'%</span>  </td>';
						echo '<td class="month m04"><span class="bg' .round($cropCSmonthly[0][3]/5) .'" >' .$cropCSmonthly[0][3] .'%</span>  </td>';
						echo '<td class="month m05"><span class="bg' .round($cropCSmonthly[0][4]/5) .'" >' .$cropCSmonthly[0][4] .'%</span>  </td>';
						echo '<td class="month m06"><span class="bg' .round($cropCSmonthly[0][5]/5) .'" >' .$cropCSmonthly[0][5] .'%</span>  </td>';
						echo '<td class="month m07"><span class="bg' .round($cropCSmonthly[0][6]/5) .'" >' .$cropCSmonthly[0][6] .'%</span>  </td>';
						echo '<td class="month m08"><span class="bg' .round($cropCSmonthly[0][7]/5) .'" >' .$cropCSmonthly[0][7] .'%</span>  </td>';
						echo '<td class="month m09"><span class="bg' .round($cropCSmonthly[0][8]/5) .'" >' .$cropCSmonthly[0][8] .'%</span>  </td>';
						echo '<td class="month m10"><span class="bg' .round($cropCSmonthly[0][9]/5) .'" >' .$cropCSmonthly[0][9] .'%</span>  </td>';
						echo '<td class="month m11"><span class="bg' .round($cropCSmonthly[0][10]/5) .'" >' .$cropCSmonthly[0][10] .'%</span>  </td>';
						echo '<td class="month m12"><span class="bg' .round($cropCSmonthly[0][11]/5) .'" >' .$cropCSmonthly[0][11] .'%</span> </td>';
						echo '</tr>';
						
						// Creating the dialog popup
						$sqlCropProfil='SELECT b.cropID , b.name_var_lndrce, a.ttsr ,
                               g.type_cereals, g.type_forest_tree, g.type_fruit, g.type_grass, g.type_herb, g.type_legume, g.type_nut, g.type_pseudocereal, g.type_pulse, 
                               g.type_root, g.type_tuber, g.type_vegetable, g.type_spices, g.type_cash_crop, g.type_tree, g.type_industrial_crop, g.type_experimental, g.type_others,	    
                               c.reported_yield_mean, d.carbohydrates_cho_mean , d.protein_mean ,e.vitamin_a_rae_mean, f.income_ha_season , a.climate 
                               FROM cropbase_v_4_0.crop_ttsr_soil_climate_ps a , cropbase_v_4_0.crop_taxonomy b , cropbase_v_4_0.crop_stat c ,
                               cropbase_v_4_0.nutrient_proximate_composition d, cropbase_v_4_0.nutrients_vitamins_and_their_precursors e, cropbase_v_4_0.tmp_income f,  cropbase_v_4_0.crop_type g
                               where   a.cropID=b.cropID
                               and a.cropID=g.cropID
                               and b.cropID=c.cropID
                               and b.cropID=d.cropID
                               and b.cropID=e.cropID
                               and e.cropID=f.cropID 
                               and b.name_var_lndrce="' .$cropCSmonthly[0][12] .'";';
						$resSqlCropProfil = $conn->query($sqlCropProfil);
						// Initilizing the variables to avoid duplication. 
						$name_var_lndrce=$result_Image=$ttsr=$reported_yield_mean=$carbohydrates_cho_mean=$protein_mean=$vitamin_a_rae_mean=$income_ha_season=$typeInList=null;
						while($row=$resSqlCropProfil->fetch_assoc()) {
						    $cropid=$row['cropID'];
						    $name_var_lndrce=$row['name_var_lndrce'];
						    $ttsr=$row['ttsr'];
						    $reported_yield_mean=$row['reported_yield_mean'];
						    $carbohydrates_cho_mean=$row['carbohydrates_cho_mean'];
						    $protein_mean=$row['protein_mean'];
						    $vitamin_a_rae_mean=$row['vitamin_a_rae_mean'];
						    $income_ha_season=$row['income_ha_season'];
						    $type_cereals=$row["type_cereals"];
						    $type_forest_tree=$row["type_forest_tree"];
                            $type_fruit=$row["type_fruit"];
						    $type_grass=$row["type_grass"];
                            $type_herb=$row["type_herb"];
                            $type_legume=$row["type_legume"];
                            $type_nut=$row["type_nut"];
                            $type_pseudocereal=$row["type_pseudocereal"];
                            $type_pulse=$row["type_pulse"];
                            $type_root=$row["type_root"];
                            $type_tuber=$row["type_tuber"];
                            $type_vegetable=$row["type_vegetable"];
                            $type_spices=$row["type_spices"];
                            $type_cash_crop=$row["type_cash_crop"];
                            $type_tree=$row["type_tree"];
                            $type_industrial_crop=$row["type_industrial_crop"];
                            $type_experimental=$row["type_experimental"];
                            $type_others=$row["type_others"];
                            $sql_getImage='select * from cropbase_v_4_0.metadata
						           where cropid="' .$cropid .'"
            						and table_col_id="545"
            						LIMIT 1;';
                            $res_sql_getImage = $conn->query($sql_getImage);
                            $result_Image=mysqli_fetch_array($res_sql_getImage);
                            // printing the type of crop
                            $typeInList=''; // Initializing the list
                            if ($type_cereals=='1'){
                             $typeInList.='Cereals, ';
                            }
                            if ($type_forest_tree=='1'){
                             $typeInList.='Forest Tree, ';
                            }
                            if ($type_fruit=='1'){
                             $typeInList.='Fruit, ';
                            }
                            if ($type_grass=='1'){
                             $typeInList.='Grass, ';
                            }
                            if ($type_legume=='1'){
                             $typeInList.='Legume, ';
                            }
                            if ($type_nut=='1'){
                             $typeInList.='Nut, ';
                            }
                            if ($type_pseudocereal=='1'){
                             $typeInList.='Pseudocereal, ';
                            }
                            if ($type_pulse=='1'){
                             $typeInList.='Pulse, ';
                            }
                            if ($type_root=='1'){
                             $typeInList.='Root, ';
                            }
                            if ($type_tuber=='1'){
                             $typeInList.='Tuber, ';
                            }
                            if ($type_vegetable=='1'){
                             $typeInList.='Vegetable, ';
                            }
                            if ($type_spices=='1'){
                             $typeInList.='Spices, ';
                            }
                            if ($type_cash_crop=='1'){
                             $typeInList.='Cash Crop, ';
                            }
                            if ($type_tree=='1'){
                             $typeInList.='Tree, ';
                            }
                            if ($type_industrial_crop=='1'){
                             $typeInList.='Industrial Crop, ';
                            }
                            if ($type_experimental=='1'){
                             $typeInList.='Experimental, ';
                            }
                            if ($type_others=='1'){
                             $typeInList.=$type_others;
                            }
						}
						if ($name_var_lndrce){
						 echo '<div id="ref-small-dialog' .$dialogCounter .'" class="zoom-anim-dialog mfp-hide small-dialog">
             					<h3> ' .$name_var_lndrce .' </h3>
							    <img src="data:image/jpeg;base64,' .base64_encode( $result_Image['image'] ) .'" class="img-responsive" alt="" style="width:100% height:50;" >
						 
             					<ul>
             						<li> <b>Name:</b> ' .$name_var_lndrce .'</li>
                                	<li> <b>TTSR:</b> ' .$ttsr .'%</li>
                                	<li> <b>Reported Yield:</b> ' .$reported_yield_mean .' Kg/ha</li>
                                    <li> <b>CHO:</b> ' .$carbohydrates_cho_mean .' mg/100g</li>
                           		    <li> <b>Protien:</b> ' .$protein_mean .' mg/100g</li>
                                	<li> <b>Vitamin A:</b> ' .$vitamin_a_rae_mean .' IU/100g</li>
                                    <li> <b>Reported Income:</b> ' .$income_ha_season .' Ha/Season</li>
                    				<li> <b>Crop Type:</b> ' .$typeInList .' </li>
             					</ul>
             				</div>';
						} else {
						 echo '<div id="ref-small-dialog' .$dialogCounter .'" class="zoom-anim-dialog mfp-hide small-dialog">
             					<h3>Sorry, Data is no Available now, Please choose another Crop</h3>
             				</div>';
						}
						
						$dialogCounter++;
					}
				?>
				</tbody>
				</table>
				<script>
				    $(document).ready(function()
				        {
				            $("#DataTable").tablesorter({sortList: [[0,0]]});
				        }
				    );
				</script>

			</div>
			<div class="clearfix"> </div>
		</div>
	</div>

	<!-- Footer -->
	<?php
	include('include/footer.php');
	?>



</body>
</html>
