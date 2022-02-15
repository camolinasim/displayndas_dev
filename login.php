<?php

//remove session information
setcookie("UTEP_SE", NULL, -3600, "/", ".utep.edu");
setcookie("UTEP_SA", NULL, -3600, "/", ".utep.edu");

/*
if(isset($_SESSION["debug"])) {
  echo "DEBUG:::<br>". $_SESSION["debug"];
} else {
  echo "DEBUG:::<br> DEBUG SESSION NOT SET";
}
*/

//session_destroy();

// include_once("./assets/regions/navbar_login.php");


?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
    <title>NDA Display</title>

    <?php include_once("./assets/regions/header.php"); ?>
</head>

<body>

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

    <div id="sidr-container">

        <div class="container" id="container">
            <div class="container">
                <div class="flexBoxWrapper">
                    <div class="col-md-12">
                        <div class="main-content">

                            <!-- <span align="center"> -->
                            <h2>NDA Display</h2>
                            <div class="stroke" style="width:10%;"></div>
                            <p class="detail">Click the button below to login with your UTEP Account!</p>
                            <!-- </span> -->
                            <br>


                            <!-- FORM BOX -->
                            <form class="form-signin" action="loginVerify.php" method="post">
                                <!-- <div class="form-group">
                                    <div class="col-sm-12 text-center">
                                        <div class="alert alert-info login_legend">
                                            Please login:
                                        </div>
                                    </div>
                                </div> -->
                                <div class="form-group">
                                    <div class="col-sm-12 text-center">
                                        <button type="submit" class="btn btn-primary">Log In <span class="glyphicon glyphicon-log-in"></span></button>
                                        <br><br>
                                        <?php
                                        if (isset($_GET['noaccess'])) {
                                            echo "<div style='color:red'>You do not have permission to access this website</div>";
                                        }
                                        ?>
                                    </div>
                                </div>
                            </form>
                            <!-- / FORM BOX -->
                            <!--
                              <p>&nbsp;<br>&nbsp;<br>&nbsp;<br>&nbsp;</p>
                              -->

                            <!-- /Main COntent Deleted -->
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                            </div>
                            <div class="col-md-6">
                            </div>
                            <div class="col-md-12">
                            </div>
                        </div>
                    </div>
                    <!-- /col-md-9 -->

                    <!-- 
                        <div class="col-md-3 col-md-pull-9 leftSidebar">
                        <nav>
                            <h2>Side Bar Navigation</h2>
                                
                            <ul class="nav">
                                <li><a href="#">Menu Item</a></li>
                                    <li><a href="#">Menu Item</a></li>
                                    <li><a href="#">Menu Item</a></li>
                                    <li><a href="#">Menu Item</a></li>
                                    <li><a href="#">Menu Item</a></li>
                                    <li><a href="#">Menu Item</a></li>
                            </ul>
                            <ul class="nav UTEPGlobalIcons">
                                <li><a class="btn btn-primary" href="http://academics.utep.edu/Default.aspx?tabid=69423">Undergraduate Admissions</a></li>
                                <li><a class="btn btn-primary" href="http://graduate.utep.edu/applynow_temp.html">Graduate Admissions</a></li>
                            </ul>
                        </nav>

                        <h2>Connect With Us</h2>
                        <div class="right-stroke"></div>
                        <p>The University of Texas at El Paso<br/>
                        [Department Name]<br/>
                        [Department Building], Room [#]<br/>
                        500 W University<br/>
                        El Paso, Texas 79902
                        </p>

                        <p>E: <a href="mailto:[departmentEmail]@utep.edu">[departmentEmail]@utep.edu </a><br/>
                        P: (915) 747-****<br/>
                        F: (915) 747-****
                        </p>

                        <ul class="nav socialIcons">
                            <li><a class="facebook" href="https://www.facebook.com/UTEPCOE/ " target="_blank"><img alt="facebook" src="assets_r/images/facebook.png" title="facebook"/></a></li>
                            <li><a class="twitter" href="https://twitter.com/utepnews " target="_blank"><img alt="twitter" src="assets_r/images/twitter.png" title="twitter"/></a></li>
                            <li><a class="youtube" href="https://www.youtube.com/user/UTEP " target="_blank"><img alt="youtube" src="assets_r/images/youTube.png" title="youtube"/></a></li>
                        </ul>


                        </div>
                        -->


                    <!-- /col-md-3 -->
                </div>
                <!-- /flexBoxWrapper -->
            </div>
            <!-- /container -->
        </div>
        <!-- /#container -->
        <footer>
            <div class="container">
                <div class="col-md-3 footerLogo"><img alt="UTEP" class="img-responsive" src="assets/images/UTEP-Footer.png" title="UTEP" /></div>
                <!-- /col-md-3 -->
                <div class="col-md-9 requiredLinks">
                    <h2>THE UNIVERSITY OF TEXAS AT EL PASO</h2>
                    <ul>
                        <li><a href="http://admin.utep.edu/Default.aspx?tabid=59577" target="_blank">Web Accessibility</a></li>
                        <li><a href="https://adminapps.utep.edu/emergencynotification/generic/" target="_blank">Campus Alerts</a></li>
                        <li><a href="https://www.utep.edu/clery/" target="_blank">Clery Crime Statistics</a></li>
                    </ul>
                    <ul>
                        <li><a href="http://admin.utep.edu/Default.aspx?tabid=73912" target="_blank">Employment</a></li>
                        <li><a href="http://sao.fraud.state.tx.us/" target="_blank">Report Fraud</a></li>
                        <li><a href="http://admin.utep.edu/Default.aspx?tabid=54275" target="_blank">Required Links</a></li>
                    </ul>
                    <ul>
                        <li><a href="http://admin.utep.edu/Default.aspx?tabid=49976" target="_blank">State Reports</a></li>
                        <li><a href="http://www.utsystem.edu/" target="_blank">UT System</a></li>
                        <li><a href="http://utep.edu/feedback" target="_blank">Site Feedback</a></li>
                    </ul>
                    <div class="clearfix"></div>
                    <p>500 West University Avenue | El Paso, TX 79968 | 915-747-5000</p>
                </div>
                <!-- /col-md-9 -->
            </div>
            <!-- /container -->
        </footer>
    </div>
    <div class="full-screen modal fade" id="myModal" role="dialog">
        <div class="modal-dialog">
            <div class="transparent modal-content text-center">
                <div class="modal-header">
                    <button class="close" data-dismiss="modal" type="button">X</button>
                </div>
                <div class="modal-body">
                    <iframe frameborder="0" height="400" width="645"></iframe>
                </div>
            </div>
        </div>
    </div>


    <script src="assets/js/bootstrap.min.js" type="text/javascript"></script>
    <script src="assets/js/modernizr-2.8.3.min.js" type="text/javascript"></script>
    <script src="assets/js/jquery.sidr.js" type="text/javascript"></script>
    <script src="assets/js/iphone-inline-video.browser.js" type="text/javascript"></script>
    <script src="assets/js/carrousel-autoplay.js" type="text/javascript"></script>
    <script src="assets/js/main.js" type="text/javascript"></script>
    <script src="assets/js/carousel.js" type="text/javascript"></script>

</body>

</html>