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
	echo "Please contact your System administrator";
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

	<!-- Ranking Customization -->
	<div class="ui-kit">
		<div class="container">
			<div class="ui-kit-grids">
				<div class="col-md-6 ui-kit-grid-left">
					<div class="login-form">
						<form name='locationSel' action="engine/divtoolcust.php" autocomplete="on">
							<b> <h3 lang="en">Choose the number of top Climate suitable crops?</h3>	</b><br>
							<input name="number" type="number" value="100" onfocus="this.value = '';" onblur="if (this.value == '') {this.value = 'Name';}" required="">
							<input type="hidden" value="<?php echo $nameLocationSent ?>" name="id" />
														<br><br><b> <h3 lang="en">Choose Crop Type:</h3></b>
							<div class="ckeck-bg">
								<div class="checkbox-form">
									<div class="col-md-6">
  									<div>
              							<select name="type">
              								<option value="alltype" selected>All types</option>
                                            <option value="cereals">cereals</option>
                                            <option value="forest tree">forest tree</option>
                                            <option value="fruit">fruit</option>
                                            <option value="grass">grass</option>
                                            <option value="herb">herb</option>
                                            <option value="legume">legume</option>
                                            <option value="nut">nut</option>
                                            <option value="pseudocereal">pseudocereal</option>
                                            <option value="pulse">pulse</option>
                                            <option value="root">root</option>
                                            <option value="tuber">tuber</option>
                                            <option value="vegetable">vegetable</option>
                                            <option value="spices">spices</option>
                                            <option value="cash crop">cash crop</option>
                                            <option value="tree">tree</option>
                                            <option value="industrial crop">industrial crop</option>
                                            <option value="experimental">experimental</option>
                                          </select>
                                      </div>
									</div>
									<div class="clearfix"> </div>
								</div>
							</div>
							
							<b> <h3 lang="en">Period between harvests:</h3></b>
							<div class="ckeck-bg">
								<div class="checkbox-form">
									<div class="col-md-6">
  									<div>
              							<select name="season">
              								<option value="0" selected>Any Length</option>
                                            <option value="30">1 Month</option>
                                            <option value="60">2 Motnhs</option>
                                            <option value="90">3 Motnhs</option>
                                            <option value="120">4 Motnhs</option>
                                            <option value="150">5 Motnhs</option>
                                            <option value="180">6 Motnhs</option>
                                            <option value="210">7 Motnhs</option>
                                            <option value="240">8 Motnhs</option>
                                            <option value="270">9 Motnhs</option>
                                            <option value="300">10 Motnhs</option>
                                            <option value="330">11 Motnhs</option>
                                            <option value="360">12 Motnhs</option>
                                          </select>
                                      </div>
									</div>
									<div class="clearfix"> </div>
								</div>
							</div>
							<b> <h3 lang="en">Growth Cycle:</h3></b>
							<div class="ckeck-bg">
								<div class="checkbox-form">
									<div class="col-md-6">
  									<div>
              							<select name="growthcycle">
              								<option value="0" selected>Any</option>
                                            <option value="annual">Annual</option>
                                            <option value="Biannual">Biannual</option>
                                            <option value="Perennial">Perennial</option>
                                          </select>
                                      </div>
									</div>
									<div class="clearfix"> </div>
								</div>
							</div>
							<b> <h3 lang="en">Underutilised</h3>	</b>
<p><small>Underutilised: Species with unexploited potential for food security, health, income generation and/or environmental services</small> </p>

							<div class="ckeck-bg">
								<div class="checkbox-form">
									<div class="col-md-6">
										<div class="check">
											<label class=" checkbox" lang="en"><input type="checkbox" name="Underutilised" ><i> </i>Underutilised</label>
										</div> 
									</div> 
									<div class="clearfix"> </div>
								</div>
							</div>
							<b> <h3 lang="en">Income & Yield</h3>	</b>
							<div class="ckeck-bg">
								<div class="checkbox-form">
									<div class="col-md-6">
										<div class="check">
											<label class=" checkbox" lang="en"><input type="checkbox" name="income" ><i> </i>Highest Income</label>
										</div>
									</div>
									<div class="col-md-6">
										<div class="check">
											<label class="  checkbox" lang="en"><input type="checkbox" name="yield" ><i> </i>Highest Yield</label>
										</div>
									</div>
									<div class="clearfix"> </div>
								</div>
							</div>
							<br><b> <h3 lang="en">Nutrient content</h3></b>
							<div class="ckeck-bg">
								<div class="checkbox-form">
									<div class="col-md-6">
										<div class="check">
											<label class=" checkbox" lang="en"><input type="checkbox" name="vita" ><i> </i>Vitamin A Content </label>
										</div>
									</div>
									<div class="col-md-6">
										<div class="check">
											<label class=" checkbox" lang="en"><input type="checkbox" name="cho" ><i></i>CHO Content </label>
										</div>
									</div>
									<div class="col-md-6">
										<div class="check">
											<label class="checkbox" lang="en"><input type="checkbox" name="protein" ><i> </i>Protein Content</label>
										</div>
									</div>
									<div class="clearfix"> </div>
								</div>
							</div>


							<br><br><br><div class="clearfix"> </div>
							<input type="submit" value="SUBMIT" lang="en">
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
