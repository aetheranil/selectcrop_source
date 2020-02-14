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

	<!-- Fonts -->
  <link href="https://fonts.googleapis.com/css?family=Open+Sans|Raleway" rel="stylesheet">

	<!-- JS -->
	<script src="assets/js/jquery-3.1.0.min.js" type="text/javascript"></script>
	<script src="assets/bootstrap-3.3.7/js/bootstrap.min.js" type="text/javascript"></script>
	<script src="assets/js/js.cookie-2.1.3.min.js" type="text/javascript"></script>
  <script src="assets/js/jquery-lang-3.0.0.min.js" type="text/javascript"></script>

</head>

<body>

	<?php
	include('include/navigation-default.php');
	include('include/parallax-banner.php')
	?>

	<!-- Ranking Preference Selection -->
	<div class="ui-kit">
		<div class="container">
			<div class="ui-kit-grids">
				<div class="col-md-6 ui-kit-grid-left">
					<div class="login-form">
						<form name='locationSel' action="engine/divtool.php" autocomplete="on">
							<div class="clearfix"> </div>
							<?php
							/*if (strrchr($nameLocationSent,"Malaysia")){
							  if (strrchr($nameLocationSent,"Pahang")){
							    if (strrchr($nameLocationSent,"Bera")){
							      $search='bera';
							      echo '<font face="calibri"><h3> You Location is ' .$nameLocationSent .'</h3>';
							      echo '
							      <br> <h4> We will choose the top ten suitable crops based on the climate in your area <h4> <br>
							      <h3>  What is your preference: </h3><br>
							      <input type="submit" name="scenario" value="Highest Estimated Yield">
							      <input type="submit" name="scenario" value="Highest Estimated Income">
							      <input type="submit" name="scenario" value="Sustainable Crops">
							      <input type="submit" name="scenario" value="Customize your Search"></font>
							      ';
							    } else {
							      echo '<h3> Sorry No data for this Location </h3>';
							    }
							  }
							}*/

							$search='bera';

							//echo '<font face="calibri"><h3> You Location is </h3><input name="scenario" value="' .$nameLocationSent .'">';
							//Printing the top ten crops from the DB

							echo '
							<br><br>
							<h3><span lang="en">What is your preference</span>:</h3><br>
							<p>Ranks climate suitable crops in terms of yield (Kg/Ha)
							(based on data for the area closest to yours for which information is available).</p><br>
							<input type="submit" name="scenario" value="Highest Estimated Yield" lang="en">

							<br><br><p>Ranks climate suitable crops in terms of income
							(Based on data for the area closest to yours for which information is available)</p> <br>
							<input type="submit" name="scenario" value="Highest Estimated Income" lang="en">

							<br><br><p>Ranks climate suitable crops in terms of their social, economic and environmental sustainability</p><br>
							<input type="submit" name="scenario" value="Sustainable Crops" lang="en">
							';

							//echo '<br><br><a href="customize.php" class="myButton">Customize Your Search</a>';
							?>
						</form>
					</div>
				</div>
				<div class="clearfix"> </div>
			</div>
			<div class="clearfix"> </div>
		</div>
	</div>

	<!-- Footer -->
	<?php include('include/footer.php'); ?>

</body>
</html>
