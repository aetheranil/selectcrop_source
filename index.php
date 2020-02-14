<!DOCTYPE html>
<html>
<head>
  <!-- Meta -->
  <title>CropBASE | Diversification Tool</title>
  <meta name="viewport" content="width=device-width,initial-scale=1,maximum-scale=1,user-scalable=no">
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
  <meta name="description" content="CropBASE - Crop Selection Tool" />

  <!-- CSS -->
  <link href="assets/bootstrap-3.3.7/css/bootstrap.min.css" rel="stylesheet" type="text/css">
  <link href="assets/font-awesome-4.6.3/css/font-awesome.min.css?v1" rel="stylesheet" type="text/css">
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
  include('include/navigation-location.php');
  include('include/parallax-banner.php');
  ?>

  <!-- Selection Tool -->
  <div class="container text-center">
    <div class="row">
      <div class="col-md-6 col-md-offset-3">
<!--         <div class="spacing"></div> -->
        <h1 lang="en">Crop Selection Tool</h1><br>
        <h4 lang="en">This tool is designed to help farmers and decision makers select crops for their areas based on available information.</h4><br>
        <a data-target="#us6-dialog" data-toggle="modal" class="myButton" lang="en">Select Your Location</a>
        <div class="spacing"></div>
      </div>
    </div>
  </div>

  <!-- Pop Up Google Map for selection Start -->
  <div id="us6-dialog" class="modal fade">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
          <h4 class="modal-title" lang="en">Drag the pen or search by name:</h4>
        </div>
        <div class="modal-body">
          <div class="form-horizontal">
            <div class="form-group">
              <label class="col-sm-2 control-label" lang="en">Location:</label>
              <div class="col-sm-10">
                <input type="text" class="form-control" id="us3-address" />
              </div>
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-default btn-green" onclick="ClearFields()" lang="en">Clear</button>
              <button type="button" class="btn btn-default btn-green" onclick="myFunction()" lang="en">Search This Location</button>
            </div>
            <div id="us3" style="width: 100%; height: 300px;"></div>
            <div class="clearfix">&nbsp;</div>
            <div class="">
              <label class="p-r-small col-sm-1 control-label">Lat.:</label>
              <div class="col-sm-5">
                <input type="text" class="form-control" id="us3-lat" />
              </div>
              <label class="p-r-small col-sm-1 control-label">Long.:</label>
              <div class="col-sm-5">
                <input type="text" class="form-control" id="us3-lon" />
              </div>
               <div class="form-group">
              
       		 </div>
            </div>
            <div class="clearfix"></div>
          </div>
        </div>
      </div>
    </div>
  </div>

  <!-- Footer -->
  <?php include('include/footer.php'); ?>

  <!-- Selection Map Location Picker -->
<script type="text/javascript" src=""></script>
  <script src="assets/js/locationpicker.jquery.min.js"></script>
  <script>
  $('#us3').locationpicker({
    location: {
      latitude: 2.94626101222013,
      longitude: 101.8720093036743
    },
    radius: 300,
    zoom: 7,
    inputBinding: {
      latitudeInput: $('#us3-lat'),
      longitudeInput: $('#us3-lon'),
      radiusInput: $('#us3-radius'),
      locationNameInput: $('#us3-address')
    },
    enableAutocomplete: true,
    // markerIcon: 'http://www.iconsdb.com/icons/preview/tropical-blue/map-marker-2-xl.png'
  });
  $('#us6-dialog').on('shown.bs.modal', function () {
    $('#us3').locationpicker('autosize');
  });
  function myFunction() {
	  lon=document.getElementById('us3-lon').value;
	  lat=document.getElementById('us3-lat').value;
      location.href = "crop_selection.php?id="+$('#us3').locationpicker('location').name+'&lon='+lon+'&lat='+lat;
    //location.href = "scenario.php?id="+$('#us3').locationpicker('location').name;
  }
  </script>

  <!-- Clear location field function -->
  <script type="text/javascript">
  function ClearFields() {
    document.getElementById("us3-address").value = "";
    $("#us3-address").focus();
  }
  </script>

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
