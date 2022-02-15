<?php
header('Access-Control-Allow-Origin: *');
$dirasset = explode('/', $_SERVER['REQUEST_URI']); 
$dirasset = $dirasset[1];
$sitedir = "https://$_SERVER[HTTP_HOST]/$dirasset/assets/";

?>

 <a class="sr-only sr-only-focusable" href="#mainContentArea" id="skippy"><span class="container" style="display:block;"><span class="skiplink-text">Skip to main content</span></span></a>
  <div id="sidr-container">
    <div class="sticky-wrapper">
      <nav class="navbar navbar-default utep-nav utepHeader affix" id="header">
        <div class="bodyBg"></div>
        <div class="container headerContainer">
          <div class="hidden-below-1365" id="search-bar">
            <form action="https://my.utep.edu/Search?" id="myutep-search" role="search" style="display: none;">
              <div class="container">
                <input autocomplete="off" id="search-query" name="q" type="search" />
                <label for="search-query" id="search-query-label">Search pages and people</label>
              </div>
            </form>
          </div>
          <div class="UTEP-Branding">
            <a class="UTEP-Logo" href="https://www.utep.edu/"><img alt="UTEP" src="assets/images/UTEP.png" title="UTEP" /></a>
            <div class="navbar-header">
              <button aria-expanded="false" class="navbar-toggle collapsed" data-target="#bs-example-navbar-collapse-1" data-toggle="collapse" type="button">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
              </button>
            </div>
            <!-- /navbar-header -->
          </div>
          <!-- /UTEP-Branding -->
          <div class="navbarCollapseContainer">
            <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">

              <ul class="nav navbar-nav">
                <li class="dropdown"><a aria-expanded="false" aria-haspopup="true" class="dropdown-toggle" href="index.php" role="button">Home</a>
                </li>
              </ul>

              <ul class="nav navbar-nav navbar-right">
                <li class="hidden-below-1365"><a href="#" id="search-trigger" title="Search pages and people"><span aria-hidden="true" class="glyphiconglyphicon-search"></span></a></li>

              </ul>

              <!-- Fix iphone 5 menu UC-79 */ -->
              <br class="visible-xs" />
              <br class="visible-xs" />
              <!-- END Fix iphone 5 menu UC-79 */ -->
              <br class="hidden-above-1365" />
              <div class="sidr right" id="sidr">
                <button aria-label="Close" class="close close-sidr" data-dismiss="modal" type="button"><span aria-hidden="true">X</span></button>
                <h3>Quick Links</h3>
                <hr class="stroke" />
                <ul class="menu">
                  <li><a href="http://libraryweb.utep.edu/">Library</a></li>
                  <li><a href="http://admin.utep.edu/Default.aspx?tabid=50621">Parking &amp; Maps</a></li>
                  <li><a href="http://news.utep.edu/">UTEP News</a></li>
                  <li><a href="http://studentlife.utep.edu/">Student Life</a></li>
                  <li><a href="http://admin.utep.edu/Default.aspx?tabid=73912">Employment</a></li>
                </ul>
              </div>
            </div><!-- /.navbar-collapse -->
          </div><!-- /.container-fluid -->

          <!-- <div class="departmentHeading">
            <h1 role="banner"><a href="http://orspweb2.utep.edu/displayndas_dev">NDA Display</a></h1>
            <h2 role="banner"><a href="http://research.utep.edu">Office of Research & Sponsored Projects</a></h2>
          </div> -->




        </div><!-- /container -->
      </nav>
    </div>
    <div class="container" id="container">
      <div id="mainContentArea" tabindex="0">Main Content</div>
      <div class="col-md-12 visible-sm visible-xs">

        <div class="row">
          <div class="col-md-12">
            <ul class="breadcrumb">
              <li><a href="http://research.utep.edu">ORSP</a></li>
              <li><a href="http://orspweb2.utep.edu/displayndas_dev">NDA Display</a></li>
            </ul>
          </div>
        </div>
      </div>
      <!-- end of navbar header -->