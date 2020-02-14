<!--A Design by W3layouts
Author: W3layout
Author URL: http://w3layouts.com
License: Creative Commons Attribution 3.0 Unported
License URL: http://creativecommons.org/licenses/by/3.0/

Author: Modified by Ayman Salama
Author URL: cropbase.org
Note: "js and css directory are for this template. later your should integrate it with assets"
-->

<?php
// include database parameters
include("engine/phpCode/connParm.php");
// function to prepare the script for dashboard
include("engine/phpCode/dashboard_var_check.php");
// include the star drawing function
include("engine/phpCode/starRack.php");
session_start();

$conn = new mysqli($host, $user, $password, $schema , $port);
if ($conn->connect_error) {
	die('Could not connect: ' .$conn->connect_error);
	echo "Please contact you System administrator";
}
$nameLocationSent=$_GET["id"];
$lon=$_GET["lon"];
$lat=$_GET["lat"];
$cropid_sent=$_GET["cropid"];
$rloading=$_GET["rloading"];
if (isset($_GET['sortid'])) {
 $sortid= $_GET['sortid'];
}else{
 $sortid='1';
}
if (isset($_GET['cropType'])) {
 $cropType= $_GET['cropType'];
}else{
 $cropType='1';
}
if (isset($_GET['utilised'])) {
 $utilised= $_GET['utilised'];
}else{
 $utilised='1';
}
if (isset($_GET['period'])) {
 $period= $_GET['period'];
}else{
 $period='0';
}
if (isset($_GET['growthcycle'])) {
 $growthcycle= $_GET['growthcycle'];
}else{
 $growthcycle='1';
}
if (isset($_GET['irrigation'])) {
 $irrigation= $_GET['irrigation'];
}else{
 $irrigation='1';
}
if (isset($_GET['limitid'])) {
 $limitid= $_GET['limitid'];
}else{
 $limitid='0';
}

// calculating the limit count
switch ($limitid) {
 case "9":
  $limitidSql=' LIMIT 9 ';
  break;
 case "18":
  $limitidSql=' LIMIT 18 ';
  break;
 case "27":
  $limitidSql=' LIMIT 27 ';
  break;
 case "36":
  $limitidSql=' LIMIT 36 ';
  break;
 case "1":
  $limitidSql='  ';
  break; 
  case "0":
   $limitidSql=' LIMIT 9 ';
   break;
 default:
  $limitidSql=' LIMIT 9 ';
}


// calculating the query for the greowth cycle
switch ($growthcycle) {
 case "1":
  $growthcycleSql='  ';
  break;
 case "2":
  $growthcycleSql='   and gc.growth_cycle_annual="1"   ';
  break;
 case "3":
  $growthcycleSql='  and gc.growth_cycle_biannual="1"  ';
  break;
  case "4":
   $growthcycleSql='  and gc.growth_cycle_perennial="1"  ';
   break;
 default:
  $growthcycleSql='  ';
}

// Check the period codition and create query
if($period){
 $seasonSql=' and s.period_between_harvest_min < "' .$period .'"
and s.period_between_harvest_max > "' .$period .'" ';
} else {
 $seasonSql='';
}

// Check the underutilised codition and create query
switch ($utilised) {
 case "1":
  $utilisedSql='  ';
  break;
 case "2":
  $utilisedSql='  and u.crop_underutilised="1"  ';
  break;
 case "3":
  $utilisedSql='  and u.crop_underutilised="0"  ';
  break;
 default:
  $utilisedSql='  ';
}
// Check the sort condition and creat sort by 
switch ($sortid) {
    case "1":
        $orderBySQL='order by  a.ttsr DESC';
     break;
    case "2":
        $orderBySQL='order by  f.income_ha_season DESC';
     break;
    case "3":
        $orderBySQL='order by  c.reported_yield_mean DESC';
     break;   
    case "4":
        $orderBySQL='order by  c.reported_yield_mean ASC';
     break;
    case "5":
        $orderBySQL='order by   d.carbohydrates_cho_mean DESC';
     break;
    case "6":
        $orderBySQL='order by   d.protein_mean  DESC';
     break;
    case "7":
        $orderBySQL='order by  e.vitamin_a_rae_mean DESC';
     break;
    default:
        $orderBySQL='order by  a.ttsr DESC';
}
// Check the crop type and generate the select condition
switch ($cropType) {
 case "1":
  $cropTypeSQL='   ';
  break;
 case "2":
  $cropTypeSQL=' and g.type_cereals = "1" ';
  break;
 case "3":
  $cropTypeSQL=' and g.type_experimental = "1" ';
  break;
 case "4":
  $cropTypeSQL=' and g.type_forest_tree = "1" ';
  break;
 case "5":
  $cropTypeSQL=' and g.type_fruit = "1" ';
  break;
 case "6":
  $cropTypeSQL=' and g.type_grass = "1" ';
  break;
 case "7":
  $cropTypeSQL=' and g.type_herb = "1" ';
  break;
 case "8":
  $cropTypeSQL=' and g.type_industrial_crop = "1" ';
  break;
 case "9":
  $cropTypeSQL=' and g.type_legume = "1" ';
  break;
 case "10":
  $cropTypeSQL=' and g.type_nut = "1" ';
  break;
 case "11":
  $cropTypeSQL=' and g.type_pseudocereal = "1" ';
  break;
 case "12":
  $cropTypeSQL=' and g.type_pulse = "1" ';
  break;
 case "13":
  $cropTypeSQL=' and g.type_root = "1" ';
  break;
 case "14":
  $cropTypeSQL=' and g.type_cash_crop = "1" ';
  break;
 case "15":
  $cropTypeSQL=' and g.type_spices = "1" ';
  break;
 case "16":
  $cropTypeSQL=' and g.type_tree = "1" ';
  break;
 case "17":
  $cropTypeSQL=' and g.type_tuber = "1" ';
  break;
 case "18":
  $cropTypeSQL=' and g.type_vegetable = "1" ';
  break;
 default:
  $cropTypeSQL='   ';
}
// Check the crop type and generate type text
switch ($cropType) {
 case "1":
  $cropTypeStr='';
  break;
 case "2":
  $cropTypeStr='cereals';
  break;
 case "3":
  $cropTypeStr='experimental';
  break;
 case "4":
  $cropTypeStr='forest_tree';
  break;
 case "5":
  $cropTypeStr='fruit';
  break;
 case "6":
  $cropTypeStr='grass';
  break;
 case "7":
  $cropTypeStr='herb';
  break;
 case "8":
  $cropTypeStr='industrial_crop';
  break;
 case "9":
  $cropTypeStr='legume';
  break;
 case "10":
  $cropTypeStr='nut';
  break;
 case "11":
  $cropTypeStr='pseudocereal';
  break;
 case "12":
  $cropTypeStr='pulse';
  break;
 case "13":
  $cropTypeStr='root';
  break;
 case "14":
  $cropTypeStr='cash_crop';
  break;
 case "15":
  $cropTypeStr='spices';
  break;
 case "16":
  $cropTypeStr='tree';
  break;
 case "17":
  $cropTypeStr='tuber';
  break;
 case "18":
  $cropTypeStr='vegetable';
  break;
 default:
  $cropTypeStr='';
}


// In case of refresh with sorting order, the rloading is et to 1, so no need to start the Rscript again.
//if ($rloading != '1'){
 echo '<script> localStorage.removeItem("lastname");
          </script>';
 
 // Based on the user preferences, the user will choose irrigation, rainfall or both
 // rainfall 1, irrigation 2, rainfall and irrigation 3. thrid variable is the irrigation flag. 1 means irrigated
 switch ($irrigation) {
  case "1":
   exec("Rscript Rworkshop/future_climate.R $lon $lat 0 $cropid_sent", $data_R); 
   break;
  case "2":
   exec("Rscript Rworkshop/future_climate.R $lon $lat 1 $cropid_sent", $data_R); 
   break;
  default:
   exec("Rscript Rworkshop/future_climate.R $lon $lat 0 $cropid_sent", $data_R); 
 }
 //exec("Rscript Rworkshop/test4.R $lon $lat", $data_R); 
 // data headers are as below
 //  1	:	CROP_ID
 //  2	:	Jan
 //  3	:	Feb
 //  4	:	Mar
 //  5	:	Apr
 //  6	:	May
 //  7	:	Jun
 //  8	:	Jul
 //  9	:	Aug
 //  10	:	Sep
 //  11	:	Oct
 //  12	:	Nov
 //  13	:	Dec
 //  14	:	averagesoilsuit
 //  15	:	totalsoilsuit
 //  16 :   name
 $firstcropdata=explode(',', $data_R[5]);
//  echo '<h2> data' .$firstcropdata[14].'</h2>';
//   echo '<pre>'; print_r($data_R) ; echo '</pre>';
//  $firstcrop= array_search('CROP_ID', array_column($data_R, '1'));
 
//  echo '<h2>first key' .$firstcrop .'</h2>';
 // Truncate the table KBS_Crop_TTSR_soil_climate_PS to store new point data
 $sql_truncate_crop_climate_soil_point_based='TRUNCATE `crop_ttsr_soil_climate_ps`;';
 $res_truncate_table_climate_soil_point_based = $conn->query($sql_truncate_crop_climate_soil_point_based);
 if($firstcropdata[14]== '101'){
  echo "<script>
alert('Oops! We are not receiving any soil data for this location from soilgrids.org. We will use climate data for now!');
</script>";
  foreach ($data_R as $key=>$tmpRowResults ){
   if ($key > '5'){
    // Dividing the array into strings divided by ,
    $tmpRowResultsDivided = explode(',', $tmpRowResults);
    // Averging the climate on 12 Months
    $point_based_climate_suitability= (    $tmpRowResultsDivided[2] + $tmpRowResultsDivided[3]  + $tmpRowResultsDivided[4]  + $tmpRowResultsDivided[5]
    + $tmpRowResultsDivided[6] + $tmpRowResultsDivided[7]  + $tmpRowResultsDivided[8]  + $tmpRowResultsDivided[9]
    + $tmpRowResultsDivided[10] + $tmpRowResultsDivided[11]  + $tmpRowResultsDivided[12]  + $tmpRowResultsDivided[13]
    )/12;
    
    // Averging the climate on 12 Months + average soil suitability
    $point_based_ttsr= $point_based_climate_suitability;

    
    // Get the crop name from the cropID
    $sqlGetCropName='SELECT name_var_lndrce
							  FROM crop_taxonomy
							  where  cropID='.$tmpRowResultsDivided[1];
    $resultSqlGetCropName = $conn->query($sqlGetCropName);
    while($row=$resultSqlGetCropName->fetch_assoc()) {
     $tmpCropName=$row['name_var_lndrce'];
    }
    
    
    // Here we ignored the soil suitability for now. and we used average climate for both climate col and total suitability col and soil is just 100
    $sql_insert_crop_climate_soil_from_R="INSERT INTO `crop_ttsr_soil_climate_ps`
							        (`cropid`, `climate`, `avg_soil`, `total_soil`, `ttsr`, `jan`, `feb`, `mar`, `apr`, `may`, `june`, `july`, `aug`, `sept`, `oct`, `nov`, `dec`)
							         VALUES ('" .$tmpRowResultsDivided[1] ."', '" .$point_based_climate_suitability ."', '0', '0', '".$point_based_ttsr ."'
		                                   , '" .$tmpRowResultsDivided[2] ."', '" .$tmpRowResultsDivided[3] ."', '" .$tmpRowResultsDivided[4] ."', '" .$tmpRowResultsDivided[5] ."'
						                   , '" .$tmpRowResultsDivided[6] ."', '" .$tmpRowResultsDivided[7] ."', '" .$tmpRowResultsDivided[8] ."', '" .$tmpRowResultsDivided[9] ."'
							               , '" .$tmpRowResultsDivided[10] ."', '" .$tmpRowResultsDivided[11] ."', '" .$tmpRowResultsDivided[12] ."', '" .$tmpRowResultsDivided[13] ."'
							          );";
   }
   //   							  echo '<br> ' .$sql_insert_crop_climate_soil_from_R .'<br> ';
   $res_upload_table_climate_soil_point_based = $conn->query($sql_insert_crop_climate_soil_from_R);
  }
 } else {
  foreach ($data_R as $key=>$tmpRowResults ){
   if ($key > '5'){
    // Dividing the array into strings divided by ,
    $tmpRowResultsDivided = explode(',', $tmpRowResults);
    // Averging the climate on 12 Months
    $point_based_climate_suitability= (    $tmpRowResultsDivided[2] + $tmpRowResultsDivided[3]  + $tmpRowResultsDivided[4]  + $tmpRowResultsDivided[5]
    + $tmpRowResultsDivided[6] + $tmpRowResultsDivided[7]  + $tmpRowResultsDivided[8]  + $tmpRowResultsDivided[9]
    + $tmpRowResultsDivided[10] + $tmpRowResultsDivided[11]  + $tmpRowResultsDivided[12]  + $tmpRowResultsDivided[13]
    )/12;
    
    // Averging the climate on 12 Months + average soil suitability
    
    if (( $point_based_climate_suitability < '25') || ( $tmpRowResultsDivided[14] < '25')) {
     $point_based_ttsr='0';
    } else {
     $point_based_ttsr= ($point_based_climate_suitability + $tmpRowResultsDivided[14] )/2;
    }
    
    // Get the crop name from the cropID
    $sqlGetCropName='SELECT name_var_lndrce
							  FROM crop_taxonomy
							  where  cropID='.$tmpRowResultsDivided[1];
    $resultSqlGetCropName = $conn->query($sqlGetCropName);
    while($row=$resultSqlGetCropName->fetch_assoc()) {
     $tmpCropName=$row['name_var_lndrce'];
    }
    
    
    // Here we ignored the soil suitability for now. and we used average climate for both climate col and total suitability col and soil is just 100
    $sql_insert_crop_climate_soil_from_R="INSERT INTO `crop_ttsr_soil_climate_ps`
							        (`cropid`, `climate`, `avg_soil`, `total_soil`, `ttsr`, `jan`, `feb`, `mar`, `apr`, `may`, `june`, `july`, `aug`, `sept`, `oct`, `nov`, `dec`)
							         VALUES ('" .$tmpRowResultsDivided[1] ."', '" .$point_based_climate_suitability ."', '" .$tmpRowResultsDivided[14] ."', '".$tmpRowResultsDivided[15] ."', '".$point_based_ttsr ."'
		                                   , '" .$tmpRowResultsDivided[2] ."', '" .$tmpRowResultsDivided[3] ."', '" .$tmpRowResultsDivided[4] ."', '" .$tmpRowResultsDivided[5] ."'
						                   , '" .$tmpRowResultsDivided[6] ."', '" .$tmpRowResultsDivided[7] ."', '" .$tmpRowResultsDivided[8] ."', '" .$tmpRowResultsDivided[9] ."'
							               , '" .$tmpRowResultsDivided[10] ."', '" .$tmpRowResultsDivided[11] ."', '" .$tmpRowResultsDivided[12] ."', '" .$tmpRowResultsDivided[13] ."'
							          );";
   }
   //   							  echo '<br> ' .$sql_insert_crop_climate_soil_from_R .'<br> ';
   $res_upload_table_climate_soil_point_based = $conn->query($sql_insert_crop_climate_soil_from_R);
  }
 }

//}

?>

<!DOCTYPE HTML>
<html>
<head>
<title>CropBASE: Crop Diversification Tool</title>
<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link href="css/style.css" rel="stylesheet" type="text/css" media="all" />
<link href="css/form.css" rel="stylesheet" type="text/css" media="all" />
<link href='http://fonts.googleapis.com/css?family=Open+Sans:400,300,600,700,800' rel='stylesheet' type='text/css'>

<script type="text/javascript" src="js/jquery.min.js"></script>
<script src="js/jquery.easydropdown.js"></script>
<script type="text/javascript">
        $(document).ready(function() {
            $(".dropdown img.flag").addClass("flagvisibility");

            $(".dropdown dt a").click(function() {
                $(".dropdown dd ul").toggle();
            });
                        
            $(".dropdown dd ul li a").click(function() {
                var text = $(this).html();
                $(".dropdown dt a span").html(text);
                $(".dropdown dd ul").hide();
                $("#result").html("Selected value is: " + getSelectedValue("sample"));
            });
                        
            function getSelectedValue(id) {
                return $("#" + id).find("dt a span.value").html();
            }

            $(document).bind('click', function(e) {
                var $clicked = $(e.target);
                if (! $clicked.parents().hasClass("dropdown"))
                    $(".dropdown dd ul").hide();
            });


            $("#flagSwitcher").click(function() {
                $(".dropdown img.flag").toggleClass("flagvisibility");
            });
        });
     </script>
<!-- start menu -->     
<link href="css/megamenu.css" rel="stylesheet" type="text/css" media="all" />
<script type="text/javascript" src="js/megamenu.js"></script>
<script>$(document).ready(function(){$(".megamenu").megamenu();});</script>
<!-- end menu -->
<script type="text/javascript" src="js/jquery.jscrollpane.min.js"></script>
		<script type="text/javascript" id="sourcecode">
			$(function()
			{
				$('.scroll-pane').jScrollPane();
			});
		</script>
<!-- top scrolling -->
<script type="text/javascript" src="js/move-top.js"></script>
<script type="text/javascript" src="js/easing.js"></script>
   <script type="text/javascript">
		jQuery(document).ready(function($) {
			$(".scroll").click(function(event){		
				event.preventDefault();
				$('html,body').animate({scrollTop:$(this.hash).offset().top},1200);
			});
		});
	</script>	
	<!--  Google Pie Chart Donut chart -->
 <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>


<!-- Icons -->
<link rel="stylesheet" href="path/to/font-awesome/css/font-awesome.min.css">


<!--  Progress bar to visulize the climate and soil suitability -->
              <style>
              
              
              .container {
                width: 50%;
                background-color: #ddd;
              }
              
              .skills {
                text-align: right;
                padding-right: 15px;
                line-height: 20px;
                color: white;
                font-size: 12px;
              }
              
              .class00 {width: 30%; background-color: #FF0000;}
              .class10 {width: 30%; background-color: #FF0000;}
              .class20 {width: 30%; background-color: #FF0000;}
              .class30 {width: 30%; background-color: #FF0000;}
              .class40 {width: 40%; background-color: #FF9900;}
              .class50 {width: 50%; background-color: #FF9900;}
              .class60 {width: 60%; background-color: #FF9900;}
              .class70 {width: 70%; background-color: #009900;}
              .class80 {width: 80%; background-color: #009900;}
              .class90 {width: 90%; background-color: #009900;}
              .class100 {width: 100%; background-color: #009900;}
              
              .classxxx {width: 50%; background-color: #000000;}
              .classfaq {width: 30%; background-color: #0066FF;}
              .classx00 {width: 30%; background-color: #FF0000;}
              .classx10 {width: 30%; background-color: #D91F00;}
              .classx20 {width: 30%; background-color: #BF3300;}
              .classx30 {width: 30%; background-color: #A64700;}
              .classx40 {width: 40%; background-color: #737000;}
              .classx50 {width: 50%; background-color: #598500;}
              .classx60 {width: 60%; background-color: #409900;}
              .classx70 {width: 70%; background-color: #009900;}
              .classx80 {width: 80%; background-color: #19B800;}
              .classx90 {width: 90%; background-color: #0DC200;}
              .classx100 {width: 100%; background-color: #00CC00;}
              </style>

   <!-- Plotly.js -->
  <script src="https://cdn.plot.ly/plotly-latest.min.js"></script>
  
</head>
<body>

  <div class="header-top">
	 <div class="wrap"> 
		<div class="logo">
			<a href="http://www.cropsforthefuture.org/"><img src="images/logo.png" alt=""/></a>
	    </div>
	    <div class="cssmenu">
		   <ul>
		     <li class="active"><a href="index.php">Another Location</a></li> 
			 <li class="active"><a href="http://www.cropbase.org">Home</a></li> 
			 <li><a href="about.php">About</a></li> 
			 <li><a href="frequently-asked.php">FAQ</a></li> 
			 <li><a href="https://cropbase.org">Go Back</a></li> 
		   </ul>
		</div>
		<ul class="icon2 sub-icon2 profile_img">
			<li><a class="active-icon c2" href="#"> </a>
				<ul class="sub-icon2 list">
					<li><h3>More Crops!</h3><a href="http://www.cropbase.info/SqlMaestro/db_access/login.php"></a></li>
					<li><a href="http://www.cropbase.info/SqlMaestro/db_access/login.php"><p>Click here to add more data!</a></p></a></li>
				</ul>
			</li>
		</ul>
		<div class="clear"></div>
 	</div>
   </div>
   <div class="header-bottom">
   	<div class="wrap">
   		<!-- start header menu -->
		<ul class="megamenu skyblue">
			<li><a class="color5" href="index.php">Back</a></li>
		    <li><a class="color1" href="http://cropbase.org/">Home</a></li>
		
				<li><a class="color10" href="about.php">About</a></li>
				<li><a class="color11" href="frequently-asked.php">FAQ</a></li>
				<li><a class="color12" href="about.php">Contact Us</a></li>
		   </ul>
		   <div class="clear"></div>
     	</div>
       </div>

	 
       <div class="login">
         <div class="wrap">
     	    <div class="rsidebar span_1_of_left">

		      <!-- <section  class="sky-form">
					<h4>Heel Height</h4>
						<div class="row row1 scroll-pane">
							<div class="col col-4">
								<label class="checkbox"><input type="checkbox" name="checkbox" checked=""><i></i>Flat (20)</label>
							</div>
							<div class="col col-4">
								<label class="checkbox"><input type="checkbox" name="checkbox"><i></i>Under 1in(5)</label>
								<label class="checkbox"><input type="checkbox" name="checkbox"><i></i>1in - 1 3/4 in(5)</label>
								<label class="checkbox"><input type="checkbox" name="checkbox"><i></i>2in - 2 3/4 in(3)</label>
								<label class="checkbox"><input type="checkbox" name="checkbox" ><i></i>3in - 3 3/4 in(2)</label>
							</div>
						</div>
		       </section>
		       <section  class="sky-form">
					<h4>Price</h4>
						<div class="row row1 scroll-pane">
							<div class="col col-4">
								<label class="checkbox"><input type="checkbox" name="checkbox" checked=""><i></i>$50.00 and Under (30)</label>
							</div>
							<div class="col col-4">
								<label class="checkbox"><input type="checkbox" name="checkbox"><i></i>$100.00 and Under (30)</label>
								<label class="checkbox"><input type="checkbox" name="checkbox"><i></i>$200.00 and Under (30)</label>
								<label class="checkbox"><input type="checkbox" name="checkbox"><i></i>$300.00 and Under (30)</label>
								<label class="checkbox"><input type="checkbox" name="checkbox"><i></i>$400.00 and Under (30)</label>
							</div>
						</div>
		       </section>
		       <section  class="sky-form">
					<h4>Colors</h4>
						<div class="row row1 scroll-pane">
							<div class="col col-4">
								<label class="checkbox"><input type="checkbox" name="checkbox" checked=""><i></i>Red</label>
							</div>
							<div class="col col-4">
								<label class="checkbox"><input type="checkbox" name="checkbox"><i></i>Green</label>
								<label class="checkbox"><input type="checkbox" name="checkbox"><i></i>Black</label>
								<label class="checkbox"><input type="checkbox" name="checkbox"><i></i>Yellow</label>
								<label class="checkbox"><input type="checkbox" name="checkbox"><i></i>Orange</label>
							</div>
						</div>
		       </section> -->
		</div>
		<div class="cont span_2_of_3">
		  <div class="mens-toolbar">
		  <p><?php
		            // Printing the name of the location
		  if ($nameLocationSent)
		            echo  'Location :' .$nameLocationSent?></p>
              <div class="sort">
               	<div class="sort-by">
		            
		            
		            <label><label>3D Graph to visualize the variation of temperature and rainfall on crop suitability </label>


               </div>
    		</div>
    		<label></label>

     	    <div class="clear"></div>
	       </div>

	       
	       

	       
	       
<!-- Plotly chart will be drawn inside this DIV -->
<?php 
$sqlGetCropName1='SELECT name_var_lndrce
							  FROM crop_taxonomy
							  where  cropID='.$cropid_sent;
$resultSqlGetCropName1 = $conn->query($sqlGetCropName1);
while($row=$resultSqlGetCropName1->fetch_assoc()) {
    $tmpCropName1=$row['name_var_lndrce'];
}
?>

<div id="myDiv" style="width:800px; height:900px;"></div>
  <script>
//initial data..
z1 = [
    <?php 

            $temp_counter=0;
            foreach ($data_R as $key=>$tmpRowResults ){
	    	         // Dividing the array into strings divided by ,

	    	         $tmpRowResultsDivided = explode(',', $tmpRowResults);
	    	         if ($key >= '2'){
	    	           echo '[' .$tmpRowResultsDivided[1] .','
	    	                    .$tmpRowResultsDivided[2] .','
                                .$tmpRowResultsDivided[3] .','
                                .$tmpRowResultsDivided[4] .','
                                .$tmpRowResultsDivided[5] .','
                                .$tmpRowResultsDivided[6] .','
                                .$tmpRowResultsDivided[7] .','
                                .$tmpRowResultsDivided[8] .','
                                .$tmpRowResultsDivided[9] .','
                                .$tmpRowResultsDivided[10] .']'
                                ;
	    	           if ($temp_counter != 10){
	    	            echo ',';
	    	           }
	    	           $temp_counter++;
	    	          }
            }


 	       
 	       ?>
];

// generating data for other traces..
var layout = {
  title: 'Rainfall & Temperature  variation on Crop Suitability for " <?php echo $tmpCropName1;?> "',
  scene: {
	    xaxis: {title: 'X: Temprature',
		   	 ticktext:['-1 C','Current','+1 C','+2 C','+3 C','+4 C','+5 C','+6 C','+7 C','+8 C'],
			 tickvals:[0,1,2,3,4,5,6,7,8,9]
		    },
	    yaxis: {title: 'Y: Rainfall',
	   	 ticktext:['-50%','-40%','-30%','-20%','-10%','Current','+10%','+20%','+30%','+40%','+50%'],
		 tickvals:[0,1,2,3,4,5,6,7,8,9,10]
	        },
	    zaxis: {title: 'Z: Suitability'}
	  },
	  

};



// creating data objects..
var data_z1 = {z: z1, type: 'surface', colorscale: [
    ['0.0', 'rgb(165,0,38)'],
    ['0.111111111111', 'rgb(255,0,0)'],
    ['0.222222222222', 'rgb(244,109,67)'],
    ['0.333333333333', 'rgb(253,174,97)'],
    ['0.444444444444', 'rgb(254,224,144)'],
    ['0.555555555556', 'rgb(173,204,122)'],
    ['0.666666666667', 'rgb(0,255,0)'],
    ['0.777777777778', 'rgb(0,204,0)'],
    ['0.888888888889', 'rgb(0,153,51)'],
    ['1.0', 'rgb(0,102,0)']
  ]};



// Plotting the surfaces..
Plotly.newPlot('myDiv', [data_z1],layout);


  </script>
	
	
        
	       <!-- ################## HERE we start drawing the pictures and laying out information ################## -->
	        <?php  
         // Printing Long & Lat sent by Google
// 		 $lonInR = explode('"', $data_R[9]);
// 		 $latInR = explode('"', $data_R[10]);
		// echo '<h3> <b>You Location is:</b> Lon: "' .$lonInR[1] .'"  <br>and Lat: "' .$latInR[1] .'" </h3>';

	        
		 // building the query and ignoring all other values.
		 $sql_crops='  SELECT distinct b.cropID , 
                 b.name_var_lndrce, 
                 a.ttsr ,
                 a.climate, 
                 a.avg_soil, 
                 a.total_soil , 
                 b.scientific_name, 
                 g.type_cereals, 
                 g.type_forest_tree, 
                 g.type_fruit, 
                 g.type_grass, 
                 g.type_herb, 
                 g.type_legume, 
                 g.type_nut, 
                 g.type_pseudocereal, 
                 g.type_pulse, 
                 g.type_root, 
                 g.type_tuber, 
                 g.type_vegetable, 
                 g.type_spices, 
                 g.type_cash_crop, 
                 g.type_tree, 
                 g.type_industrial_crop, 
                 g.type_experimental, 
                 g.type_others,	    
                 c.reported_yield_mean, 
                 d.carbohydrates_cho_mean , 
                 d.protein_mean ,
                 e.vitamin_a_rae_mean, 
                 f.income_ha_season , 
                 u.crop_underutilised,
                 a.jan, 
                 a.feb, 
                 a.mar, 
                 a.apr,
                 a.may, 
                 a.june, 
                 a.july, 
                 a.aug, 
                 a.sept, 
                 a.oct, 
                 a.nov, 
                 a.dec,
                 ag.rainfall_optimal_max,
                 ag.rainfall_optimal_min,
                 ag.rainfall_absolute_max,
                 ag.rainfall_absolute_min,
                 ag.temperature_optimal_max,
                 ag.temperature_optimal_min,
                 ag.temperature_absolute_max,
                 ag.temperature_absolute_min,

                 ag.soil_depth_optimal_deep,
                 ag.soil_depth_optimal_medium,
                 ag.soil_depth_optimal_low,

                 ag.soil_depth_absolute_deep,
                 ag.soil_depth_absolute_medium,
                 ag.soil_depth_absolute_low,

                 ag.soil_ph_optimal_max,
                 ag.soil_ph_optimal_min,

                 ag.soil_ph_absolute_max,
                 ag.soil_ph_absolute_min,

                 ag.soil_fertility_optimal_high,
                 ag.soil_fertility_optimal_moderate, 
                 ag.soil_fertility_optimal_low, 

                 ag.soil_fertility_absolute_high, 
                 ag.soil_fertility_absolute_moderate, 
                 ag.soil_fertility_absolute_low, 

                 round((s.period_between_harvest_max + s.period_between_harvest_min)/60) season
                          
                  FROM 
                  crop_ttsr_soil_climate_ps a , 
                  crop_taxonomy b , 
                  crop_stat c ,
                  nutrient_proximate_composition d, 
                  nutrients_vitamins_and_their_precursors e, 
                  crop_where_underUtilised u,
                  crop_growth_cycle gc ,
                  tmp_income f,  
                  crop_type g,  
                  agro_crop_season s ,
                  agro_agroecology ag

                   where   a.cropID=b.cropID
                   and a.cropID=g.cropID
                   and b.cropID=c.cropID
                   and b.cropID=d.cropID
                   and b.cropID=e.cropID
                   and e.cropID=f.cropID 
                   and a.cropID=s.cropid
                   and a.cropID=u.cropid
                   and a.cropID=gc.cropid
                   and a.cropID=ag.cropID
                           ' .$cropTypeSQL .'  '  .$utilisedSql .'  ' .$seasonSql .'  ' .$growthcycleSql .' group by(a.cropid)  ' .$orderBySQL   .' 
                                 ' .$limitidSql ;
// 		 echo '<br>' .$sql_crops .'</br>'; 
    	   $results_sql_crops = $conn->query($sql_crops);
	       $dialogCounter=0;
	       $divCounter=0;
	       echo '<div class="box1">';
	       while($row=$results_sql_crops->fetch_assoc()) {
	        $cropid=$row['cropID'];
	        $scientific_name=$row['scientific_name'];
	        $name_var_lndrce=$row['name_var_lndrce'];
	        $ttsr=$row['ttsr'];
	        $reported_yield_mean=$row['reported_yield_mean'];
	        $carbohydrates_cho_mean=$row['carbohydrates_cho_mean'];
	        $protein_mean=$row['protein_mean'];
	        $vitamin_a_rae_mean=$row['vitamin_a_rae_mean'];
	        $income_ha_season=$row['income_ha_season'];
	        $season=$row['season'];
	        $crop_utilised=$row['crop_underutilised'];
	        $rainfall_optimal_max=$row['rainfall_optimal_max'];
	        $rainfall_optimal_min=$row['rainfall_optimal_min'];
	        $rainfall_absolute_max=$row['rainfall_absolute_max'];
	        $rainfall_absolute_min=$row['rainfall_absolute_min'];
	        $temperature_optimal_max=$row['temperature_optimal_max'];
	        $temperature_optimal_min=$row['temperature_optimal_min'];
	        $temperature_absolute_max=$row['temperature_absolute_max'];
	        $temperature_absolute_min=$row['temperature_absolute_min'];
	        $soil_depth_optimal_deep=$row['soil_depth_optimal_deep'];
	        $soil_depth_optimal_medium=$row['soil_depth_optimal_medium'];
	        $soil_depth_optimal_low=$row['soil_depth_optimal_low'];
	        $soil_depth_absolute_deep=$row['soil_depth_absolute_deep'];
	        $soil_depth_absolute_medium=$row['soil_depth_absolute_medium'];
	        $soil_depth_absolute_low=$row['soil_depth_absolute_low'];
	        $soil_ph_optimal_max=$row['soil_ph_optimal_max'];
	        $soil_ph_optimal_min=$row['soil_ph_optimal_min'];
	        $soil_ph_absolute_max=$row['soil_ph_absolute_max'];
	        $soil_ph_absolute_min=$row['soil_ph_absolute_min'];
	        $soil_fertility_optimal_high=$row['soil_fertility_optimal_high'];
	        $soil_fertility_optimal_moderate=$row['soil_fertility_optimal_moderate'];
	        $soil_fertility_optimal_low=$row['soil_fertility_optimal_low'];
	        $soil_fertility_absolute_high=$row['soil_fertility_absolute_high'];
	        $soil_fertility_absolute_moderate=$row['soil_fertility_absolute_moderate'];
	        $soil_fertility_absolute_low=$row['soil_fertility_absolute_low'];
	        $soil_fertility_absolute_high=$row['soil_fertility_absolute_high'];
	        $soil_fertility_absolute_moderate=$row['soil_fertility_absolute_moderate'];
	        $soil_fertility_absolute_low=$row['soil_fertility_absolute_low'];
	        $jan=$row['jan'];
    		$feb=$row['feb'];
    		$mar=$row['mar'];
    		$apr=$row['apr'];
    		$may=$row['may'];
    		$jun=$row['june'];
    		$jul=$row['july'];
    		$aug=$row['aug'];
    		$sep=$row['sept'];
    		$oct=$row['oct'];
    		$nov=$row['nov'];
    		$dec=$row['dec'];
    		$climate=$row['climate'];
    		$avg_Soil=$row['avg_soil'];
    		$total_soil=$row['total_soil'];
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
	        $sql_getImage='select * from metadata
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
	        if ($name_var_lndrce){
	         if($divCounter % 3 == 0)  {
	          echo '<div class="clear"></div></div><div class="box1">';
	         }
	         $divCounter++;
	         // calculate the stars
	         switch (true) {
	          case $ttsr > 80:
	           $star1=$star2=$star3=$star4=$star5=1;
	           break;
	           	
	          case $ttsr > 60:
	           $star1=$star2=$star3=$star4=1;
	           $star5=0;
	           break;
	           	
	          case $ttsr > 40:
	           $star1=$star2=$star3=1;
	           $star4=$star5=0;
	           break;
	           	
	          case $ttsr > 20:
	           $star1=$star2=1;
	           $star3=$star4=$star5=0;
	           break;
	        
	          case $ttsr > 10:
	           $star1=1;
	           $star2=$star3=$star4=$star5=0;
	           break;
	        
	          default:
	           $star1=1;
	           $star2=$star3=$star4=$star5=0;
	           break;
	         }
	         
	         // What data to display based on the sorting action
	         if($firstcropdata[14]== '101'){
	          switch ($sortid) {
	           case "1":
	            $dataToDisplay=' Climate Index: ' .round($ttsr) .'%';
	            break;
	           case "2":
	            $dataToDisplay=' Income: ' .$income_ha_season .' RM/Ha/Season';
	            break;
	           case "3":
	            $dataToDisplay=' Yield: ' .$reported_yield_mean .' Kg/Ha/Season';
	            break;
	           case "4":
	            $dataToDisplay=' Yield: ' .$reported_yield_mean .' Kg/Ha/Season';
	            break;
	           case "5":
	            $dataToDisplay=' Carbohydrates: ' .$carbohydrates_cho_mean .' mm/100g';
	            break;
	           case "6":
	            $dataToDisplay=' Protein: ' .$protein_mean .' mm/100g';
	            break;
	           case "7":
	            $dataToDisplay=' Vitamin A: ' .$vitamin_a_rae_mean .' mm/100g';
	            break;
	           default:
	            $dataToDisplay=' Climate Index: ' .round($ttsr) .'%';
	          }
	         } else {
	          switch ($sortid) {
	           case "1":
	            $dataToDisplay=' Climate & Soil Index: ' .round($ttsr) .'%';
	            break;
	           case "2":
	            $dataToDisplay=' Income: ' .$income_ha_season .' RM/Ha/Season';
	            break;
	           case "3":
	            $dataToDisplay=' Yield: ' .$reported_yield_mean .' Kg/Ha/Season';
	            break;
	           case "4":
	            $dataToDisplay=' Yield: ' .$reported_yield_mean .' Kg/Ha/Season';
	            break;
	           case "5":
	            $dataToDisplay=' Carbohydrates: ' .$carbohydrates_cho_mean .' mm/100g';
	            break;
	           case "6":
	            $dataToDisplay=' Protein: ' .$protein_mean .' mm/100g';
	            break;
	           case "7":
	            $dataToDisplay=' Vitamin A: ' .$vitamin_a_rae_mean .' mm/100g';
	            break;
	           default:
	            $dataToDisplay=' Climate & Soil Index: ' .round($ttsr) .'%';
	          }
	         }

	         if ($jan == "0"){
	          $jan="0.01";
	         }
	         if ($feb == "0"){
	          $feb="0.01";
	         }
	         if ($mar == "0"){
	          $mar="0.01";
	         }
	         if ($apr == "0"){
	          $apr="0.01";
	         }
	         if ($may == "0"){
	          $may="0.01";
	         }
	         if ($jun == "0"){
	          $jun="0.01";
	         }
	         if ($jul == "0"){
	          $jul="0.01";
	         }
	         if ($aug == "0"){
	          $aug="0.01";
	         }
	         if ($sep == "0"){
	          $sep="0.01";
	         }
	         if ($oct == "0"){
	          $oct="0.01";
	         }
	         if ($nov == "0"){
	          $nov="0.01";
	         }
	         if ($dec == "0"){
	          $dec="0.01";
	         }
	         echo ' <div class="col_1_of_single1 span_1_of_single1"><a href="#"> </a>
				     <div class="view1 view-fifth1">
				  	  <div class="top_box">
					  	<h3 >' .$dataToDisplay .' </h2>
					  	<p class="m_3">' .$scientific_name .'</p>
				         <div class="grid_img">
						   <div class="css3"><img src="data:image/jpeg;base64,' .base64_encode( $result_Image['image'] ) .'" alt=""/></div>
					          <div class="mask1">
	                       		<!-- <div class="info">Quick View</div> -->
			                  </div>
	                    </div>
                       <div class="price"> <h4>'  .$name_var_lndrce  .'</h4></div>
					   </div>
					    </div>
					   <span class="rating1">
				        <input type="radio" class="rating-input" id="rating-input-1-5" name="rating-input-1">
				        <label for="rating-input-1-5" class="rating-star' .$star1 .'"></label>
				        <input type="radio" class="rating-input" id="rating-input-1-4" name="rating-input-1">
				        <label for="rating-input-1-4" class="rating-star' .$star2 .'"></label>
				        <input type="radio" class="rating-input" id="rating-input-1-3" name="rating-input-1">
				        <label for="rating-input-1-3" class="rating-star' .$star3 .'"></label>
				        <input type="radio" class="rating-input" id="rating-input-1-2" name="rating-input-1">
				        <label for="rating-input-1-2" class="rating-star' .$star4 .'"></label>
				        <input type="radio" class="rating-input" id="rating-input-1-1" name="rating-input-1">
				        <label for="rating-input-1-1" class="rating-star' .$star5 .'"></label>&nbsp;
				
		    	      </span>
						 <ul class="list2">
						  <li>
						  	<ul class="icon1 sub-icon1 profile_img" >
							  <li><a class="active-icon c1" href="#"> &nbsp; Cycle: ' .round($ttsr) .'%  </a>
								<ul class="sub-icon1 list">

                                    <li><div id="donutchart' .$dialogCounter .'" style="width: 300px; height: 300px;"></div> </li>
		  							</ul>
							  </li>
							 </ul>
						   </li>
					     </ul>
                         	 <script type="text/javascript">
                               google.charts.load("current", {packages:["corechart"]});
                               google.charts.setOnLoadCallback(drawChart);

                               function drawChart() {
                                 var data = google.visualization.arrayToDataTable([
                                   ["Task", "Monthly Climate Index", { role: "style" }],
	                               ["Soil: ' .round($avg_Soil).'%",' .($avg_Soil).',"' .getColorCode($avg_Soil) .'"],
					               ["All: ' .round($climate).'%",' .($climate).',"' .getColorCode($climate).'"],
                                   ["Jan: ' .round($jan) .'%",' .$jan .',"' .getColorCode($jan) .'"],
                                   ["Feb: ' .round($feb) .'%",' .$feb .',"' .getColorCode($feb) .'"],
                                   ["Mar: ' .round($mar) .'%",' .$mar .',"' .getColorCode($mar) .'"],
                                   ["Apr: ' .round($apr) .'%",' .$apr .',"' .getColorCode($apr) .'"],
                                   ["May: ' .round($may) .'%",' .$may .',"' .getColorCode($may) .'"],
                                   ["Jun: ' .round($jun) .'%",' .$jun .',"' .getColorCode($jun) .'"],
                                   ["Jul: ' .round($jul) .'%",' .$jul .',"' .getColorCode($jul) .'"],
                                   ["Aug: ' .round($aug) .'%",' .$aug .',"' .getColorCode($aug) .'"],
                                   ["Sep: ' .round($sep) .'%",' .$sep .',"' .getColorCode($sep) .'"],
                                   ["Oct: ' .round($oct) .'%",' .$oct .',"' .getColorCode($oct) .'"],
                                   ["Nov: ' .round($nov) .'%",' .$nov .',"' .getColorCode($nov) .'"],
                                   ["Dec: ' .round($dec) .'%",' .$dec .',"' .getColorCode($dec) .'"]
                                 ]);
                         
                                 var options = {
                                   title: "Monthly Climate & Soil Index",
								   legend: { position: "none" },
						           tooltip: {text:"none"},
                                   hAxis: {viewWindow:{
                                                   max:100,
                                                   min:0
                                                 }}
                                 };
                         
                                 var chart = new google.visualization.BarChart(document.getElementById("donutchart' .$dialogCounter .'"));
                                 chart.draw(data, options);
                               }




					          

                             </script>
	  
			    	    <div class="clear"></div>
			    	</a></div>';
	        }
	        $dialogCounter++;
	       }
	       echo '<div class="clear"></div></div>';
	       //###################################################################################

					?>
	       		
				  
			  <!-- ############################################# -->



			  </div>
			  <div class="clear"></div>
			</div>
		   </div>
	  <!--   <div class="footer">
       	   <div class="footer-top">
       		<div class="wrap">
       			   <div class="col_1_of_footer-top span_1_of_footer-top">
				  	 <ul class="f_list">
				  	 	<li><img src="images/f_icon.png" alt=""/><span class="delivery">Free delivery on all orders over �100*</span></li>
				  	 </ul>
				   </div>
				   <div class="col_1_of_footer-top span_1_of_footer-top">
				  	<ul class="f_list">
				  	 	<li><img src="images/f_icon1.png" alt=""/><span class="delivery">Customer Service :<span class="orange"> (800) 000-2587 (freephone)</span></span></li>
				  	 </ul>
				   </div>
				   <div class="col_1_of_footer-top span_1_of_footer-top">
				  	<ul class="f_list">
				  	 	<li><img src="images/f_icon2.png" alt=""/><span class="delivery">Fast delivery & free returns</span></li>
				  	 </ul>
				   </div>
				  <div class="clear"></div>
			 </div>
       	    </div>
       	    <div class="footer-middle">
       	 	  <div class="wrap">
       	 		<div class="section group">
				<div class="col_1_of_middle span_1_of_middle">
					<dl id="sample" class="dropdown">
			        <dt><a href="#"><span>Please Select a Country</span></a></dt>
			        <dd>
			            <ul>
			                <li><a href="#">Australia<img class="flag" src="images/as.png" alt="" /><span class="value">AS</span></a></li>
			                <li><a href="#">Sri Lanka<img class="flag" src="images/srl.png" alt="" /><span class="value">SL</span></a></li>
			                <li><a href="#">Newziland<img class="flag" src="images/nz.png" alt="" /><span class="value">NZ</span></a></li>
			                <li><a href="#">Pakistan<img class="flag" src="images/pk.png" alt="" /><span class="value">Pk</span></a></li>
			                <li><a href="#">United Kingdom<img class="flag" src="images/uk.png" alt="" /><span class="value">UK</span></a></li>
			                <li><a href="#">United States<img class="flag" src="images/us.png" alt="" /><span class="value">US</span></a></li>
			            </ul>
			         </dd>
   				    </dl>
   				 </div>
				<div class="col_1_of_middle span_1_of_middle">
					<ul class="f_list1">
						<li><span class="m_8">Sign up for email and Get 15% off</span>
						<div class="search">	  
							<input type="text" name="s" class="textbox" value="Search" onfocus="this.value = '';" onblur="if (this.value == '') {this.value = 'Search';}">
							<input type="submit" value="Subscribe" id="submit" name="submit">
							<div id="response"> </div>
			 			</div><div class="clear"></div>
			 		    </li>
					</ul>
				</div>
				<div class="clear"></div>
			   </div>
       	 	</div>
       	 </div>
       	 <div class="footer-bottom">
       	 	<div class="wrap">
       	 		<div class="section group">
				<div class="col_1_of_5 span_1_of_5">
					<h3 class="m_9">Shop</h3>
					<ul class="sub_list">
						<h4 class="m_10">Men</h4>
					    <li><a href="crop_selection.php">Men's Shoes</a></li>
			            <li><a href="crop_selection.php">Men's Clothing</a></li>
			            <li><a href="crop_selection.php">Men's Accessories</a></li>
			        </ul>
			             <ul class="sub_list">
				            <h4 class="m_10">Women</h4>
				            <li><a href="crop_selection.php">Women's Shoes</a></li>
				            <li><a href="crop_selection.php">Women's Clothing</a></li>
				            <li><a href="crop_selection.php">Women's Accessories</a></li>
				         </ul>
				         <ul class="sub_list">
				            <h4 class="m_10">Kids</h4>
				            <li><a href="crop_selection.php">Kids Shoes</a></li>
				            <li><a href="crop_selection.php">Kids Clothing</a></li>
				            <li><a href="crop_selection.php">Kids Accessories</a></li>
				         </ul>
				        <ul class="sub_list">
				            <h4 class="m_10">style</h4>
				            <li><a href="crop_selection.php">Porsche Design Sport</a></li>
				            <li><a href="crop_selection.php">Porsche Design Shoes</a></li>
				            <li><a href="crop_selection.php">Porsche Design Clothing</a></li>
				        </ul>
				        <ul class="sub_list">
				            <h4 class="m_10">Adidas Neo Label</h4>
				            <li><a href="crop_selection.php">Adidas NEO Shoes</a></li>
				            <li><a href="crop_selection.php">Adidas NEO Clothing</a></li>
				        </ul>
				        <ul class="sub_list1">
				            <h4 class="m_10">Customise</h4>
				            <li><a href="crop_selection.php">mi adidas</a></li>
				            <li><a href="crop_selection.php">mi team</a></li>
				            <li><a href="crop_selection.php">new arrivals</a></li>
				        </ul>
				</div>
				<div class="col_1_of_5 span_1_of_5">
					<h3 class="m_9">Sports</h3>
					<ul class="list1">
					    <li><a href="crop_selection.php">Basketball</a></li>
			            <li><a href="crop_selection.php">Football</a></li>
			            <li><a href="crop_selection.php">Football Boots</a></li>
			            <li><a href="crop_selection.php">Predator</a></li>
			            <li><a href="crop_selection.php">F50</a></li>
			            <li><a href="crop_selection.php">Football Clothing</a></li>
			            <li><a href="crop_selection.php">Golf</a></li>
			            <li><a href="crop_selection.php">Golf Shoes</a></li>
			            <li><a href="crop_selection.php">Golf Clothing</a></li>
			            <li><a href="crop_selection.php">Outdoor</a></li>
			            <li><a href="crop_selection.php">Outdoor Shoes</a></li>
			            <li><a href="crop_selection.php">Outdoor Clothing</a></li>
			            <li><a href="crop_selection.php">Rugby</a></li>
			            <li><a href="crop_selection.php">Running</a></li>
			            <li><a href="crop_selection.php">Running Shoes</a></li>
			            <li><a href="crop_selection.php">Boost</a></li>
			            <li><a href="crop_selection.php">Supernova</a></li>
			            <li><a href="crop_selection.php">Running Clothing</a></li>
			            <li><a href="crop_selection.php">Swimming</a></li>
			            <li><a href="crop_selection.php">Tennis</a></li>
			            <li><a href="crop_selection.php">Tennis Shoes</a></li>
			            <li><a href="crop_selection.php">Tennis Clothing</a></li>
			            <li><a href="crop_selection.php">Training</a></li>
			            <li><a href="crop_selection.php">Training Shoes</a></li>
			            <li><a href="crop_selection.php">Training Clothing</a></li>
			            <li><a href="crop_selection.php">Training Accessories</a></li>
			            <li><a href="crop_selection.php">miCoach</a></li>
			            <li><a href="crop_selection.php">All Sports</a></li>
			         </ul>
				</div>
				<div class="col_1_of_5 span_1_of_5">
					<h3 class="m_9">Originals</h3>
					<ul class="list1">
					    <li><a href="crop_selection.php">Originals Shoes</a></li>
			            <li><a href="crop_selection.php">Gazelle</a></li>
			            <li><a href="crop_selection.php">Samba</a></li>
			            <li><a href="crop_selection.php">LA Trainer</a></li>
			            <li><a href="crop_selection.php">Superstar</a></li>
			            <li><a href="crop_selection.php">SL</a></li>
			            <li><a href="crop_selection.php">ZX</a></li>
			            <li><a href="crop_selection.php">Campus</a></li>
			            <li><a href="crop_selection.php">Spezial</a></li>
			            <li><a href="crop_selection.php">Dragon</a></li>
			            <li><a href="crop_selection.php">Originals Clothing</a></li>
			            <li><a href="crop_selection.php">Firebird</a></li>
			            <li><a href="crop_selection.php">Originals Accessories</a></li>
			            <li><a href="crop_selection.php">Men's Originals</a></li>
			            <li><a href="crop_selection.php">Women's Originals</a></li>
			            <li><a href="crop_selection.php">Kid's Originals</a></li>
			            <li><a href="crop_selection.php">All Originals</a></li>
		            </ul>
				</div>
				<div class="col_1_of_5 span_1_of_5">
					<h3 class="m_9">Product Types</h3>
					<ul class="list1">
					    <li><a href="crop_selection.php">Shirts</a></li>
					    <li><a href="crop_selection.php">Pants & Tights</a></li>
					    <li><a href="crop_selection.php">Shirts</a></li>
					    <li><a href="crop_selection.php">Jerseys</a></li>
					    <li><a href="crop_selection.php">Hoodies & Track Tops</a></li>
					    <li><a href="crop_selection.php">Bags</a></li>
					    <li><a href="crop_selection.php">Jackets</a></li>
					    <li><a href="crop_selection.php">Hi Tops</a></li>
					    <li><a href="crop_selection.php">SweatShirts</a></li>
					    <li><a href="crop_selection.php">Socks</a></li>
					    <li><a href="crop_selection.php">Swimwear</a></li>
					    <li><a href="crop_selection.php">Tracksuits</a></li>
					    <li><a href="crop_selection.php">Hats</a></li>
					    <li><a href="crop_selection.php">Football Boots</a></li>
					    <li><a href="crop_selection.php">Other Accessories</a></li>
					    <li><a href="crop_selection.php">Sandals & Flip Flops</a></li>
					    <li><a href="crop_selection.php">Skirts & Dresseses</a></li>
					    <li><a href="crop_selection.php">Balls</a></li>
					    <li><a href="crop_selection.php">Watches</a></li>
					    <li><a href="crop_selection.php">Fitness Equipment</a></li>
					    <li><a href="crop_selection.php">Eyewear</a></li>
					    <li><a href="crop_selection.php">Gloves</a></li>
					    <li><a href="crop_selection.php">Sports Bras</a></li>
					    <li><a href="crop_selection.php">Scarves</a></li>
					    <li><a href="crop_selection.php">Shinguards</a></li>
					    <li><a href="crop_selection.php">Underwear</a></li>
		            </ul>
				</div>
				<div class="col_1_of_5 span_1_of_5">
					<h3 class="m_9">Support</h3>
					<ul class="list1">
					   <li><a href="crop_selection.php">Store finder</a></li>
					   <li><a href="crop_selection.php">Customer Service</a></li>
					   <li><a href="frequently-asked.php">FAQ</a></li>
					   <li><a href="crop_selection.php">Online Shop Contact Us</a></li>
					   <li><a href="crop_selection.php">about adidas Products</a></li>
					   <li><a href="crop_selection.php">Size Charts </a></li>
					   <li><a href="crop_selection.php">Ordering </a></li>
					   <li><a href="crop_selection.php">Payment </a></li>
					   <li><a href="crop_selection.php">Shipping </a></li>
					   <li><a href="crop_selection.php">Returning</a></li>
					   <li><a href="crop_selection.php">Using out Site</a></li>
					   <li><a href="crop_selection.php">Delivery Terms</a></li>
					   <li><a href="crop_selection.php">Site Map</a></li>
					   <li><a href="crop_selection.php">Gift Card</a></li>
					  
		            </ul>
		            <ul class="sub_list2">
		               <h4 class="m_10">Company Info</h4>
			           <li><a href="crop_selection.php">About Us</a></li>
			           <li><a href="crop_selection.php">Careers</a></li>
			           <li><a href="crop_selection.php">Press</a></li>
			        </ul>
				</div>
				<div class="clear"></div>
			</div>
       	  </div>
       	 </div>-->
       	 <div class="copy">
       	   <div class="wrap">
       	   	  <p>� All rights reserved | Template by&nbsp;<a href="http://w3layouts.com/"> W3Layouts</a></p>
       	   	  <p>� All rights reserved | Template Modified by&nbsp;<a href="http://cropbase.org/"> CropBASE: Crops For The Future</a></p>
       	   </div>
       	 </div>
       </div> 
       <script type="text/javascript">
			$(document).ready(function() {
			
				var defaults = {
		  			containerID: 'toTop', // fading element id
					containerHoverID: 'toTopHover', // fading element hover id
					scrollSpeed: 1200,
					easingType: 'linear' 
		 		};
				
				
				$().UItoTop({ easingType: 'easeOutQuart' });
				
			});
		</script>
        <a href="#" id="toTop" style="display: block;"><span id="toTopHover" style="opacity: 1;"></span></a>
</body>
</html>
<script>
  (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
  (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
  m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
  })(window,document,'script','https://www.google-analytics.com/analytics.js','ga');

  ga('create', 'UA-97663404-1', 'auto');
  ga('send', 'pageview');

</script>
