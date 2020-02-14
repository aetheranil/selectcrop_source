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

  <style media="screen">
  #data-faq:before,
  #application-faq:before,
  #upgrades-faq:before {
    display: block;
    content: "";
    height: 60px;
    visibility: hidden;
  }
</style>

</head>
<body>

  <?php
  include('include/navigation-default.php');
  include('include/parallax-banner.php')
  ?>

  <div class="container">
    <div class="row text-center" id="anchor">
      <br>
      <div class="col-xs-4 col-md-4">
        <a href="#data-faq"><i class="fa fa-tasks fa-2x" aria-hidden="true"></i><br>Data</a>
      </div>
      <div class="col-xs-4 col-md-4">
        <a href="#application-faq"><i class="fa fa-cubes fa-2x" aria-hidden="true"></i><br>Application</a>
      </div>
      <div class="col-xs-4 col-md-4">
        <a href="#upgrades-faq"><i class="fa fa-cloud-upload fa-2x" aria-hidden="true"></i><br>Upgrades</a>
      </div>
    </div>

    <!-- Data -->
    <div class="row">
      <div class="col-md-10 col-md-offset-1">
        <div class="bera-faq-section">
          <div class="row" id="data-faq">
            <h3 class="col-md-12">
              Data
              <div class="pull-right">
                <a href="#data-faq" class="btn btn-default open-all-data">Expand All</a>
                <a href="#data-faq" class="btn btn-default close-all-data">Collapse All</a>
              </div>
            </h3>
          </div>
          <div class="panel-group">

            <!-- data-faq-01 -->
            <div class="panel panel-default panel-faq">
              <div class="panel-heading">
                <a data-toggle="collapse" data-parent="#data-faq" href="#data-faq-01">
                  <h4 class="panel-title">
                    1. How many species do you have in your database?
                    <span class="pull-right"><i class="glyphicon glyphicon-plus"></i></span>
                  </h4>
                </a>
              </div>
              <div id="data-faq-01" class="data-panel panel-collapse collapse">
                <div class="panel-body">
                  <p>
                    a. Currently 220 crops are listed in our database. Some of them are labelled as 'underutilised', some of them are crops that are growing in Bera district Malaysia and some are crops that have been grown in our Field Research Centre (FRC). We use collected data of these crops to showcase the SELECTCROP.
                  </p>
                  <p>
                    b. We are in the process of enhancing our taxonomic backbone (data about species and landraces names) by integrating taxonomic data from major databases like USDA GRIN and Global Biodiversity Information Database (GBIF). This taxonomy data that amounts to more than 100K species names will be integrated in the next iteration of the database.
                  </p>
                </div>
              </div>
            </div>

            <!-- data-faq-02 -->
            <div class="panel panel-default panel-faq">
              <div class="panel-heading">
                <a data-toggle="collapse" data-parent="#data-faq" href="#data-faq-02">
                  <h4 class="panel-title">
                    2. How you collect data for the crops listed in your database?
                    <span class="pull-right"><i class="glyphicon glyphicon-plus"></i></span>
                  </h4>
                </a>
              </div>
              <div id="data-faq-02" class="data-panel panel-collapse collapse">
                <div class="panel-body">
                  <p>
                    a. The data is collected using variety of methods to cover value chain of crops;
                  </p>
                  <p>
                    i. Manual data collection using available literature online and offline. The data is entered by data collectors using an online curation system. Metadata, including references, location, images, notes and ‘reliability flags’ will also be collected for the purpose of curation and validation.
                  </p>
                  <p>
                    ii. We have identified quite a few databases that can supply the information we need and we are in the process of linking and integrating data from those databases. These databases include, FAO Ecocrop on ecological characteristics of almost 2700 crop species, Food Plants International data on around 7000 nutritious crop species around the world, AVRDC nutrition database on around 60 vegetables. We also have partnership with Malaysian institutes like Malaysian Department of Agriculture (DOA) and Malaysian Agricultural Research and Development Institute (MARDI) that would supply the local data needed for this project.
                  </p>
                  <p>
                    iii. Ground data (mostly socio-economics information) are collected by contacting local authorities. We are in the process of developing standard questionnaires to collect local and farmers’ data.
                  </p>
                </div>
              </div>
            </div>

            <!-- data-faq-03 -->
            <div class="panel panel-default panel-faq">
              <div class="panel-heading">
                <a data-toggle="collapse" data-parent="#data-faq" href="#data-faq-03">
                  <h4 class="panel-title">
                    3. What will you do if you have missing data?
                    <span class="pull-right"><i class="glyphicon glyphicon-plus"></i></span>
                  </h4>
                </a>
              </div>
              <div id="data-faq-03" class="data-panel panel-collapse collapse">
                <div class="panel-body">
                  <p>
                    a. Gap filling using available data will be done at three levels (is not integrated in the database yet);
                  </p>
                  <p>
                    i. Closest relatives (at both genotypic of the phenotypic levels)<br>
                    ii. Data from the nearest location for the same crop <br>
                    iii. Available data from the next reliable source
                  </p>
                </div>
              </div>
            </div>

            <!-- data-faq-04 -->
            <div class="panel panel-default panel-faq">
              <div class="panel-heading">
                <a data-toggle="collapse" data-parent="#data-faq" href="#data-faq-04">
                  <h4 class="panel-title">
                    4. Where is your own data that had been collected within CFF?
                    <span class="pull-right"><i class="glyphicon glyphicon-plus"></i></span>
                  </h4>
                </a>
              </div>
              <div id="data-faq-04" class="data-panel panel-collapse collapse">
                <div class="panel-body">
                  <p>
                    a. The data that is collected from variety of sources will need to be validated by experts both within and out outside the centre. We will demonstrate the data reliability flags in the next iterations of the database.
                  </p>
                  <p>
                    b. Experimental data and the data collected by CFF personnel will be added to the database in the next iteration of the tool.
                  </p>
                </div>
              </div>
            </div>

            <!-- data-faq-05 -->
            <div class="panel panel-default panel-faq">
              <div class="panel-heading">
                <a data-toggle="collapse" data-parent="#data-faq" href="#data-faq-05">
                  <h4 class="panel-title">
                    5. Why do you have data for major crops in your database?
                    <span class="pull-right"><i class="glyphicon glyphicon-plus"></i></span>
                  </h4>
                </a>
              </div>
              <div id="data-faq-05" class="data-panel panel-collapse collapse">
                <div class="panel-body">
                  <p>
                    a. For the purpose of comparison.
                  </p>
                  <p>
                    b. In order to show the areas that underutilised crops can complement and solve local problems and where major crops can or will perform sub-par.
                  </p>
                </div>
              </div>
            </div>

            <!-- data-faq-06 -->
            <div class="panel panel-default panel-faq">
              <div class="panel-heading">
                <a data-toggle="collapse" data-parent="#data-faq" href="#data-faq-06">
                  <h4 class="panel-title">
                    6. What if the data that you have is not accurate?
                    <span class="pull-right"><i class="glyphicon glyphicon-plus"></i></span>
                  </h4>
                </a>
              </div>
              <div id="data-faq-06" class="data-panel panel-collapse collapse">
                <div class="panel-body">
                  <p>
                    a. We have a curation system that will be open to the experts and users to curate and validate the data after the data is collected. This will be available in the next iteration.
                  </p>
                  <p>
                    b. We will also provide the source and reliability criteria for all of the data that is used for any analysis so that inconsistencies and errors can be flagged and reported.
                  </p>
                </div>
              </div>
            </div>

            <!-- data-faq-07 -->
            <div class="panel panel-default panel-faq">
              <div class="panel-heading">
                <a data-toggle="collapse" data-parent="#data-faq" href="#data-faq-07">
                  <h4 class="panel-title">
                    7. Did you verify those results with farmers?
                    <span class="pull-right"><i class="glyphicon glyphicon-plus"></i></span>
                  </h4>
                </a>
              </div>
              <div id="data-faq-07" class="data-panel panel-collapse collapse">
                <div class="panel-body">
                  <p>
                    Our team of socio-economic experts have initiated a task force that includes local farmers and representatives of the government organisations working in this area to review the system and provide feedback.
                  </p>
                </div>
              </div>
            </div>

          </div>
        </div>
      </div>
    </div>

    <!-- Application -->
    <div class="row">
      <div class="col-md-10 col-md-offset-1">
        <div class="bera-faq-section">
          <div class="row" id="application-faq">
            <h3 class="col-md-12">
              Application
              <div class="pull-right">
                <a href="#application-faq" class="btn btn-default open-all-application">Expand All</a>
                <a href="#application-faq" class="btn btn-default close-all-application">Collapse All</a>
              </div>
            </h3>
          </div>
          <div class="panel-group">

            <!-- application-faq-01 -->
            <div class="panel panel-default panel-faq">
              <div class="panel-heading">
                <a data-toggle="collapse" data-parent="#application-faq" href="#application-faq-01">
                  <h4 class="panel-title">
                    1. What is the permanent address of this system?
                    <span class="pull-right"><i class="glyphicon glyphicon-plus"></i></span>
                  </h4>
                </a>
              </div>
              <div id="application-faq-01" class="application-panel panel-collapse collapse">
                <div class="panel-body">
                  <p>
                    Simply go to <a href="http://cropbase.org/">CropBASE</a> landing page and click on “SELECTCROP”.
                  </p>
                </div>
              </div>
            </div>






            <!-- application-faq-06 -->
            <div class="panel panel-default panel-faq">
              <div class="panel-heading">
                <a data-toggle="collapse" data-parent="#application-faq" href="#application-faq-06">
                  <h4 class="panel-title">
                    2. How you come up with the final crop options?
                    <span class="pull-right"><i class="glyphicon glyphicon-plus"></i></span>
                  </h4>
                </a>
              </div>
              <div id="application-faq-06" class="application-panel panel-collapse collapse">
                <div class="panel-body">
                  <p>
                    a. Two stage simplified ranking:
                    <ol>
                      <li>
                        The process starts by the user selecting her area of interest. The system will extract the district in which the selected point is located.
                      </li>
                      <li>
                        The system will then screen the crops in the database in terms of climate and soil suitability indices and shows 9 best crops in the first page.
                      </li>
                      <li>
                        At the next step the system will rank 10 crops according to user preferences (yield, income etc.)
                      </li>
                    </ol>
                  </p>
                  <p>
                    b. One stage customised ranking:
                    <ol>
                      <li>
                        User will have freedom to combine total climate and soil suitability ranking (default) with any other criteria and any number of crops. This type of ranking will be extended to one stage ranking in the next iteration of the tool.
                      </li>
                    </ol>
                  </p>
                </div>
              </div>
            </div>

            <!-- application-faq-07 -->
            <div class="panel panel-default panel-faq">
              <div class="panel-heading">
                <a data-toggle="collapse" data-parent="#application-faq" href="#application-faq-07">
                  <h4 class="panel-title">
                    3. What is the next step?
                    <span class="pull-right"><i class="glyphicon glyphicon-plus"></i></span>
                  </h4>
                </a>
              </div>
              <div id="application-faq-07" class="application-panel panel-collapse collapse">
                <div class="panel-body">
                  <p>
                    The next step is to provide a modelling choice for the selected crops to provide yield and price estimates at the chosen location.
                  </p>
                </div>
              </div>
            </div>

            <!-- application-faq-08 -->
            <div class="panel panel-default panel-faq">
              <div class="panel-heading">
                <a data-toggle="collapse" data-parent="#application-faq" href="#application-faq-08">
                  <h4 class="panel-title">
                    4. What are the technologies that you are using?
                    <span class="pull-right"><i class="glyphicon glyphicon-plus"></i></span>
                  </h4>
                </a>
              </div>
              <div id="application-faq-08" class="application-panel panel-collapse collapse">
                <div class="panel-body">
                  <p>
                    a. Linux Operating System, Dell Servers
                  </p>
                  <p>
                    b. Various programming language and various cutting edge technologies for data processing and visualisations.
                  </p>
                </div>
              </div>
            </div>

            <!-- application-faq-09 -->
            <div class="panel panel-default panel-faq">
              <div class="panel-heading">
                <a data-toggle="collapse" data-parent="#application-faq" href="#application-faq-09">
                  <h4 class="panel-title">
                    5. Is this online?
                    <span class="pull-right"><i class="glyphicon glyphicon-plus"></i></span>
                  </h4>
                </a>
              </div>
              <div id="application-faq-09" class="application-panel panel-collapse collapse">
                <div class="panel-body">
                  <p>
                    Yes the system is online on our server within our own domain.
                  </p>
                </div>
              </div>
            </div>

            <!-- application-faq-10 -->
            <div class="panel panel-default panel-faq">
              <div class="panel-heading">
                <a data-toggle="collapse" data-parent="#application-faq" href="#application-faq-10">
                  <h4 class="panel-title">
                    6. Is it free?
                    <span class="pull-right"><i class="glyphicon glyphicon-plus"></i></span>
                  </h4>
                </a>
              </div>
              <div id="application-faq-10" class="application-panel panel-collapse collapse">
                <div class="panel-body">
                  <p>
                    The data and the tool will be provided on subscription basis and free for high level decision makers at the ministry and department level.
                  </p>
                </div>
              </div>
            </div>

            <!-- application-faq-11 -->
            <div class="panel panel-default panel-faq">
              <div class="panel-heading">
                <a data-toggle="collapse" data-parent="#application-faq" href="#application-faq-11">
                  <h4 class="panel-title">
                    7. Do I need internet to access this system?
                    <span class="pull-right"><i class="glyphicon glyphicon-plus"></i></span>
                  </h4>
                </a>
              </div>
              <div id="application-faq-11" class="application-panel panel-collapse collapse">
                <div class="panel-body">
                  <p>
                    a. Yes at the moment you will need internet connection to access this system.
                  </p>
                  <p>
                    b. An offline demo version is available for demonstration purposes only.
                  </p>
                </div>
              </div>
            </div>

            <!-- application-faq-12 -->
            <div class="panel panel-default panel-faq">
              <div class="panel-heading">
                <a data-toggle="collapse" data-parent="#application-faq" href="#application-faq-12">
                  <h4 class="panel-title">
                    8. Who else is interested in this tool?
                    <span class="pull-right"><i class="glyphicon glyphicon-plus"></i></span>
                  </h4>
                </a>
              </div>
              <div id="application-faq-12" class="application-panel panel-collapse collapse">
                <div class="panel-body">
                  <p>
                    a. We have tested some of the results of this tools (climate suitability only) in Dehiowita District of Sri Lanka and we received lots of interest from the local stockholders so far.
                  </p>
                  <p>
                    b. We have received positive response from international partners and funders over the extension of this tool in Africa.
                  </p>
                </div>
              </div>
            </div>

            <!-- application-faq-13 -->
            <div class="panel panel-default panel-faq">
              <div class="panel-heading">
                <a data-toggle="collapse" data-parent="#application-faq" href="#application-faq-13">
                  <h4 class="panel-title">
                    9. Will there be an app version for this tool?
                    <span class="pull-right"><i class="glyphicon glyphicon-plus"></i></span>
                  </h4>
                </a>
              </div>
              <div id="application-faq-13" class="application-panel panel-collapse collapse">
                <div class="panel-body">
                  <p>
                    The system is being developed to be â€˜mobile friendlyâ€™. <br>
                    We have plans to extend the functionality of this system into a stand-alone app that can be used offline with an extension for data collection and user feedback.
                  </p>
                </div>
              </div>
            </div>

          </div>
        </div>
      </div>
    </div>

    <!-- Upgrades -->
    <div class="row">
      <div class="col-md-10 col-md-offset-1">
        <div class="bera-faq-section">
          <div class="row" id="upgrades-faq">
            <h3 class="col-md-12">
              Upgrades
              <div class="pull-right">
                <a href="#upgrades-faq" class="btn btn-default open-all-upgrades">Expand All</a>
                <a href="#upgrades-faq" class="btn btn-default close-all-upgrades">Collapse All</a>
              </div>
            </h3>
          </div>
          <div class="panel-group">

            <!-- upgrades-faq-01 -->
            <div class="panel panel-default panel-faq">
              <div class="panel-heading">
                <a data-toggle="collapse" data-parent="#upgrades-faq" href="#upgrades-faq-01">
                  <h4 class="panel-title">
                    1. How do you plan to expand this system?
                    <span class="pull-right"><i class="glyphicon glyphicon-plus"></i></span>
                  </h4>
                </a>
              </div>
              <div id="upgrades-faq-01" class="upgrades-panel panel-collapse collapse">
                <div class="panel-body">
                  <p>
                    a. Date
                    <ol>
                      <li>Providing higher resolution (<1km) climate and soil suitability</li>
                      <li>Text mining for automatic data collection from literature</li>
                      <li>Integration with more databases on crops across value chain</li>
                      <li>Curation and validation system</li>
                      <li>Extend the localities and resolution of the system from district level to farm/plot level</li>
                      <li>Extension of the system to stand alone mobile platforms</li>
                    </ol>
                  </p>
                  <p>
                    b. Development
                    <ol>
                      <li>Inclusion of soil suitability index in overall ranking</li>
                      <li>Extending the 10 best crops to unlimited number</li>
                      <li>Giving the users more choice for screening the crops (Include 800+ variables in the selection algorithm)</li>
                      <li>On the fly Online calculation for the climate, soil suitability</li>
                      <li>On the fly modelling (yield and price)</li>
                      <li>Develop data gap filling algorithm for missing data on crops</li>
                    </ol>
                  </p>
                </div>
              </div>
            </div>

          </div>
        </div>
      </div>
    </div>

  </div>

  <!-- Footer -->
  <?php
  include('include/footer.php');
  ?>

  <script type="text/javascript">
  $(document).ready(function() {
    $('.collapse').on('show.bs.collapse', function() {
      var id = $(this).attr('id');
      $('a[href="#' + id + '"]').closest('.panel-heading').addClass('active-faq');
      $('a[href="#' + id + '"] .panel-title span').html('<i class="glyphicon glyphicon-minus"></i>');
    });
    $('.collapse').on('hide.bs.collapse', function() {
      var id = $(this).attr('id');
      $('a[href="#' + id + '"]').closest('.panel-heading').removeClass('active-faq');
      $('a[href="#' + id + '"] .panel-title span').html('<i class="glyphicon glyphicon-plus"></i>');
    });
  });
  </script>

  <script type="text/javascript">
  $('.close-all-data').click(function(){
    $('.data-panel.panel-collapse.collapse.in').collapse('hide');
  });
  $('.open-all-data').click(function(){
    $('.data-panel.panel-collapse.collapse:not(".in")').collapse('show');
  });
  $('.close-all-application').click(function(){
    $('.application-panel.panel-collapse.collapse.in').collapse('hide');
  });
  $('.open-all-application').click(function(){
    $('.application-panel.panel-collapse.collapse:not(".in")').collapse('show');
  });
  $('.close-all-upgrades').click(function(){
    $('.upgrades-panel.panel-collapse.collapse.in').collapse('hide');
  });
  $('.open-all-upgrades').click(function(){
    $('.upgrades-panel.panel-collapse.collapse:not(".in")').collapse('show');
  });
  </script>

</body>
</html>
