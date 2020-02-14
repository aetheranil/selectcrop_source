<?php include('social-links.php'); ?>

<!-- Navbar -->
<div id="nav">
  <div class="navbar navbar-default" data-spy="affix" data-offset-top="55" role="navigation">
    <div class="container">
      <div class="navbar-header">
        <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
          <span class="sr-only">Toggle navigation</span>
          <span class="icon-bar"></span>
          <span class="icon-bar"></span>
          <span class="icon-bar"></span>
        </button>
        <a class="navbar-brand" href="http://www.cropbase.org">CropBASE</a>
      </div>
      <div class="navbar-collapse collapse navbar-right">
        <ul class="nav navbar-nav">
          <li><a href=""><span lang="en">Home</span></a></li>
          <li><a href="about.php"><span lang="en">About</span></a></li>
          <li><a href="contact.php"><span lang="en">Contact</span></a></li>
          <li><a href="frequently-asked.php"><span lang="en">FAQ</span></a></li>
          <li class="dropdown">
            <a href="#lang-en" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false" lang="en">Language</a>
            <ul class="dropdown-menu">
              <li><a href="#lang-en" onclick="window.lang.change('en'); return false;">English</a></li>
              <li><a href="#lang-my" onclick="window.lang.change('my'); return false;">Malay</a></li>
            </ul>
          </li>
        </ul>
      </div>
    </div>
  </div>
</div>

<!-- Display Language Selection -->
<script type="text/javascript">
$(document).ready(function() {
  $(".dropdown-menu li a").click(function(){
    $(this).parents(".dropdown").find('.dropdown-toggle').html($(this).text());
  });
});
</script>

<!-- Language Initialisation -->
<script type="text/javascript">
// Instantiate the library
var lang = new Lang();
// Declare a dynamic language pack
lang.dynamic('my', 'assets/js/langpack/my.json');
// Initialise the library
lang.init({
    defaultLang: 'en',
    cookie: {
        name: 'divtool_lang',
        expiry: 30,
        path: '/'
    }
});
</script>

<!-- Body padding on affix -->
<script type="text/javascript">
$('#nav').on('affix.bs.affix affix-top.bs.affix', function (e) {
  var padding = e.type === 'affix' ? $(this).height() : '';
  $('body').css('padding-top', padding);
});
</script>
