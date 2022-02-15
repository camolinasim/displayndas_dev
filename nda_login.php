<?php

require_once("./conf/conf_db_mssql_ndas.php");
require_once("./conf/conf_db_mssql_orspdb.php");
require_once("./conf/conf_db_mssql_ps.php");
require_once("./conf/conf.php");

// if (isset($_GET['docket'])) {
//   $docket = $_GET['docket'];
//   $_SESSION['REDIRECT'] = 'nda_login.php?docket='. $docket;
// }

if (!isset($_GET['ProjectID'])) {
  $_GET['ProjectID'] = "";
}

// Redirect to https if you are not already in https.

if ($_SERVER['HTTPS'] != "on") {
  $redirect = "https://".$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];
  header("Location:$redirect");
}

session_start();

// if (isset($_GET['docket'])) {
//   $docket = $_GET['docket'];
//   $_SESSION['REDIRECT'] = 'Location:nda_login.php?docket='. $docket;
// }

// if ( isset($_SESSION[$userAuthenticationID_key]) && isset($_SESSION[$userAuthenticationAuth_key]) && isset($_SESSION[$userAuthenticationKey_key]) ){
//   // DO NOTHING
// } else if ($_SERVER['HTTP_HOST'] != "localhost"){  // Only have the user log in if this is running on the server.
//   //require("validate_access.php");
//   //Redirect to login!
//   header("Location:login.php"); exit(0);
// }

// $debug_set = FALSE;   // False - To turn off
// $debug_txt = "";

// echo "DEBUG:::<br>". $_SESSION["debug"];

// if (isset($_SESSION["debug"])) {
//   echo "DEBUG:::<br>". $_SESSION["debug"];
//   $debug_txt .= "DEBUG:::<br>". $_SESSION["debug"];
// } else {
//   //echo "DEBUG:::<br> DEBUG SESSION NOT SET";
//   $debug_txt .= "DEBUG:::<br> DEBUG SESSION NOT SET";
// }

// if ($_SERVER['HTTP_HOST'] == 'localhost') {
//   $_SESSION["UID"] = 'blekal';
// }

$_SESSION['docket'] = $_GET['docket'];


// Setup user administrative access here.  Upload/Delete options
//

//($_SESSION["UID"] == 'ehzazueta') || ($_SESSION["UID"] == 'rchavez13') || ($_SESSION["UID"] == 'mvalvillar') || ($_SESSION["UID"] == 'aherrera16')))
// $scdocs_admins = array("osegueda", "czhang3", "jlramirez14", "aherrera16", "jmcorral2", "ngustafson", "pesparza3", "imartin");
// $scdocs_admins_access = FALSE;

// $_SESSION["ADMIN_SCDOCS_DISPLAY"] = FALSE;

// if (in_array($_SESSION["UID"], $scdocs_admins)) {
//   $_SESSION["ADMIN_SCDOCS_DISPLAY"] = TRUE;
// }

// $scdocs_admins_access = $_SESSION["ADMIN_SCDOCS_DISPLAY"];

// if (!$scdocs_admins_access) {
//   // header("Location:login.php"); 
//   header($redirect);
//   exit(0);
// }

// $driver = "{ODBC Driver 13 for SQL Server}";
// $server   = "ORSPSRVAPP02";
// $username = "orspbt";
// $userpass = "3T3p*r3N1w";
// $database = "displayndas_dev";
// $mssqldb_conn_settings = "odbc:Driver=$driver; Server=$server; Database=$database; Uid=$username; Pwd=$userpass;";
$mssqldb_conn = new PDO($PDO_ndas);
$extra_conn = new PDO($PDO_ndas);

//$mssqldb_conn = new PDO("sqlsrv:server=orspsrvapp02.utep.edu,1433;Database=orspdb","orspbt","3T3p*r3N1w");
// $mssqldb_conn = new PDO("sqlsrv:server=orspsrvapp02.utep.edu;Database=displayndas","orspbt","3T3p*r3N1w");
if (!$mssqldb_conn) {
  echo "Unable to connect to the MSSQL server";
  exit(0);
}

//$NumberOfFiles = count(scandir("D:\inetpub\webroot2\\NDAs (used by displayndas)"));
$NumberOfFiles = count(scandir("\\\ORSPSRVAPP02\\webroot2\\NDAs_dev"));
$q = "SELECT NumberOfFiles FROM ndafiles WHERE NumberOfFiles IS NOT NULL";
$result2 = $mssqldb_conn->query($q);
if (!$result2) {
  echo "query = $q<br><br>";
  echo (__FILE__ . ":" . __LINE__ . ' Error: ');
  print_r($mssqldb_conn->errorInfo());
  die();
}
$row2 = $result2->fetch(PDO::FETCH_ASSOC);
//$d = dir("D:\inetpub\webroot2\\NDAs (used by displayndas)");


if ($row2['NumberOfFiles'] != $NumberOfFiles) {
  $d = dir("\\\ORSPSRVAPP02\\webroot2\\NDAs_dev");

  // Delete all the records in table ndafiles.

  $q = "DELETE FROM ndafiles;";
  $result = $mssqldb_conn->query($q);
  if (!$result) {
    echo "query = $q<br><br>";
    echo (__FILE__ . ":" . __LINE__ . ' Error: ');
    print_r($mssqldb_conn->errorInfo());
    die();
  }


  $entry = $d->read();

  while (false !== ($entry = $d->read())) {

    $filename = "('" . str_replace("'", "`", $entry) . "')";

    //-----
    // Insert filename into table  -FIX : Arnold 022120
    //-----

    $q = "INSERT INTO ndafiles (Filename) VALUES $filename;";
    $result = $mssqldb_conn->query($q);
    if (!$result) {
      echo "query = $q<br><br>";
      echo (__FILE__ . ":" . __LINE__ . ' Error: ');
      print_r($mssqldb_conn->errorInfo());
      die();
    }
  }


  // Update the table with the current number of directories.

  $q = "INSERT INTO ndafiles (NumberOfFiles) VALUES (" . $NumberOfFiles . ");";
  $result = $mssqldb_conn->query($q);
  if (!$result) {
    echo "query = $q<br><br>";
    echo (__FILE__ . ":" . __LINE__ . ' Error: ');
    print_r($mssqldb_conn->errorInfo());
    die();
  }
  $d->close();
}


//$mssqldb_conn2 = new PDO("sqlsrv:server=orspsrvapp02.utep.edu,1433;Database=subcontractsdocuments","orspbt","3T3p*r3N1w");
/*$mssqldb_conn2 = new PDO("sqlsrv:server=orspsrvapp02.utep.edu;Database=docketsview","orspbt","3T3p*r3N1w");
if (!$mssqldb_conn2)
{
  echo "Unable to connect to the MSSQL server";
  exit(0);
}


$driver   = "ODBC Driver 11 for SQL Server";
$server   = "ITDVSRSQLN01\NT01";
$username = 'ORSPWebAcct';
$userpass = 'HS*(#(*Qse(#$OIAr2354';
$database = "VPRPeopleSoft";


//$mssqldb_conn3 = new PDO("odbc:DRIVER={$driver};server=Itdvsrsqln01\nt01;Database=VPRPeopleSoft","ORSPWebAcct",'HS*(#(*Qse(#$OIAr2354');
$mssqldb_conn3 = new PDO("odbc:DRIVER={$driver}; Server=$server; Database=$database; Uid=$username; Pwd=$userpass;");
if (!$mssqldb_conn3)
{
  echo  __FILE__.":".__LINE__." Unable to connect to the MSSQL server.<br>";
  exit(0);
}*/


/*// Use sqlsrv_connect instead of PDO to avoid needing a port number to connect to SQL Server.

$mssqldb_conn3 = sqlsrv_connect("Itdvsrsqln01\nt01", array("UID" => "ORSPWebAcct", "PWD" => 'HS*(#(*Qse(#$OIAr2354', "CharacterSet" => "UTF-8"));
if ($mssqldb_conn3)
{

}
else
{
  echo __FILE__.":".__LINE__." Unable to connect to the MSSQL server<br>";
  die( print_r( sqlsrv_errors(), true));
}*/
//$q = "SELECT DISTINCT [Award/Proposal #] FROM [orspdb].[dbo].[GM_AWD_PROJ_PROFILE] ORDER BY [Award/Proposal #] DESC";

//$q = "SELECT DISTINCT SUBSTRING([Award/Proposal #],1,10) AS ORSPNumber FROM [orspdb].[dbo].[GM_AWD_PROJ_PROFILE] WHERE [Subcontract] = 'Yes' ORDER BY ORSPNumber DESC";
//$q = "SELECT Docket FROM ndas ORDER BY Docket DESC";
//$q = "SELECT DISTINCT Docket,[Effective Date],[Expiration Date] FROM ndas ORDER BY Docket DESC";
$q = "SELECT DISTINCT Docket FROM ndas ORDER BY Docket DESC";
//$q = "SELECT DISTINCT SUBSTRING([Award/Proposal #],1,11) AS ORSPNumber FROM [orspdb].[dbo].[GM_AWD_PROJ_PROFILE] WHERE [Subcontract] = 'Yes' ORDER BY ORSPNumber DESC";


$mssqlresults = $mssqldb_conn->query($q);

if (!$mssqlresults) {
  echo "query = $q<br><br>";
  echo (__FILE__ . ":" . __LINE__ . ' Error: ');
  print_r($mssqldb_conn->errorInfo());
  die();
}

include_once("assets/regions/navbar.php");

?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
  <title>NDA Display</title>

  <link href="https://cdn.utep.edu/images/favicon.ico" rel="icon" type="image/x-icon" />

  <!-- CSS -->
  <link href="assets/css/bootstrap.css" rel="stylesheet" />
  <!-- <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous"> -->

  <link href="assets/css/styles.css" rel="stylesheet" />
  <link href="assets/css/jquery.sidr.bare.css" rel="stylesheet" />

  <!-- Typography -->
  <link href="https://fonts.googleapis.com/css?family=Open+Sans:400,800,700,600" rel="stylesheet" type="text/css" />
  <!-- <link href="https://cloud.typography.com/6793094/7122152/css/fonts.css" rel="stylesheet" type="text/css" /> -->

  <!-- JS -->
  <script src="assets/js/jquery-2.1.1.min.js" type="text/javascript"></script>
  <script src="assets/js/jquery-ui.min.js" type="text/javascript"></script>
  <script>
    /*Insert Google Analytics*/
  </script>

  <!-- <script src="assets/js/bootstrap.min.js" type="text/javascript"></script>
  <script src="assets/js/modernizr-2.8.3.min.js" type="text/javascript"></script>
  <script src="assets/js/jquery.sidr.js" type="text/javascript"></script>
  <script src="assets/js/iphone-inline-video.browser.js" type="text/javascript"></script>
  <script src="assets/js/carrousel-autoplay.js" type="text/javascript"></script>
  <script src="assets/js/main.js" type="text/javascript"></script>
  <script src="assets/js/carousel.js" type="text/javascript"></script> -->

  <!-- INSERT TEST HERE -->

 
  <script type="text/javascript">
    $(document).ready(function() {
      $('#ndas').DataTable({
        dom: '<"wrapper"Bliftip>',
        mark: true,
        fixedHeader: {
          header: true,
          footer: true
        },
        order: [
          [0, "desc"]
        ],
        lengthMenu: [
          [50, 100, 250, -1],
          [50, 100, 250, "All"]
        ],
        buttons: [
          // {
          //   extend: 'collection',
          {
            text: 'Add New NDA',
            action: function() {
              // window.open("AddNDA.php");
              modal.style.display = "block";
            }

          }
          // buttons: [
          //   {text: "testing"}
          // ]
          // }
        ]
      });


      /* Modal */
      var modal = document.getElementById("ndaModal");

    });
  </script>


  <!-- styles for css -->
  <style type="text/css">
    a:visited {
      color: #245285;
      font-weight: bold;
      text-decoration: none;
    }

    a:hover {
      color: #cc3300;
      font-weight: bold;
      text-decoration: underline;
    }

    a:hover {
      color: #cc3300;
      font-weight: bold;
      text-decoration: underline;
    }


    /* Modal */
    .modal {
      display: none;
      /* Hidden by default */
      position: fixed;
      /* Stay in place */
      z-index: 1;
      /* Sit on top */
      padding-top: 100px;
      /* Location of the box */
      left: 0;
      top: 0;
      width: 100%;
      /* Full width */
      height: 100%;
      /* Full height */
      overflow: auto;
      /* Enable scroll if needed */
      background-color: rgb(0, 0, 0);
      /* Fallback color */
      background-color: rgba(0, 0, 0, 0.4);
      /* Black w/ opacity */
    }

    /* Modal Content */
    .modal-content {
      position: relative;
      background-color: #fefefe;
      margin: auto;
      padding: 0;
      border: 1px solid #888;
      width: 80%;
      box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.2), 0 6px 20px 0 rgba(0, 0, 0, 0.19);
      -webkit-animation-name: animatetop;
      -webkit-animation-duration: 0.4s;
      animation-name: animatetop;
      animation-duration: 0.4s
    }

    /* Add Animation */
    @-webkit-keyframes animatetop {
      from {
        top: -300px;
        opacity: 0
      }

      to {
        top: 0;
        opacity: 1
      }
    }

    @keyframes animatetop {
      from {
        top: -300px;
        opacity: 0
      }

      to {
        top: 0;
        opacity: 1
      }
    }

    /* The Close Button */
    .close {
      color: white;
      float: right;
      font-size: 28px;
      font-weight: bold;
    }

    .close:hover,
    .close:focus {
      color: #000;
      text-decoration: none;
      cursor: pointer;
    }

    .modal-header {
      padding: 2px 16px;
      background-color: #ff7d23;
      color: white;
    }

    .modal-body {
      padding: 2px 16px;
    }

    .modal-footer {
      padding: 2px 16px;
      background-color: #ff7d23;
      color: white;
    }
  </style>

</head>


<body>

  <!-- main content -->
  <div class="container" id="container">

    <div class="container">
      <div class="flexBoxWrapper">
        <div class="col-md-12">
          <div class="visible-md visible-lg">
            <div class="row">
              <div class="col-md-12">
                <ul class="breadcrumb">
                  <li><a href="home.php">NDA Display</a></li>
                </ul>
              </div>
            </div>
          </div>
          <br /><br />
          <h2 align="center">NDA Display </h2>

          <form action="home.php" method="get">

            <div class="form-group">
              <div class="row">
                <div class="col-md-auto">
                  <!-- <label for="docket">Filter:</label> -->
                  <!-- <select name="docket" class="form-control" id="docket">';
              <option value="">All</option> -->
                  <?php //while ($row = $mssqlresults->fetch(PDO::FETCH_ASSOC)) {
                    /*if (preg_match("/(OR.*)[A-Z]/",$row['ORSPNumber'],$match))
          {

          // If the orsp number has a letter at the end then remove it.

          $row['ORSPNumber'] = $match[1];
          }*/
                  ?>
                    <!-- <option value=<?php //echo $row['Docket']; 
                                        ?>> <?php //echo $row['Docket']; 
                                            ?> </option> -->

                  <?php
                  //}
                  ?>
                  <!-- </select> -->
                </div>

                <!-- <div class="col-md-auto">
            <input type="submit" class="btn btn-primary" value="Submit">
          </div> -->


              </div>
            </div>

          </form><br>

          <!-- The Add New NDA Modal -->
          <div id="ndaModal" class="modal">

            <!-- Modal content -->
            <div class="modal-content">
              <div class="modal-header">
                <span class="close">&times;</span>
                <h2>Add NDA</h2>
                <p class="detail">Please fill out the form below to add or update a NDA.</p>
              </div>
              <div class="modal-body">
                <?php include("AddNDA.php"); ?>
              </div>
              <div class="modal-footer">
                <h3>NDA Display</h3>
              </div>
            </div>

            <script>
            // Get the modal
            var modal = document.getElementById("ndaModal");

            // Get the <span> element that closes the modal
            var span = document.getElementsByClassName("close")[0];


            // When the user clicks on <span> (x), close the modal
            span.onclick = function() {
              modal.style.display = "none";
            }

            // When the user clicks anywhere outside of the modal, close it
            window.onclick = function(event) {
              if (event.target == modal) {
                modal.style.display = "none";
              }
            }
          </script>

          </div>

          <table id="ndas" class="display table table-striped table-hover display" cellspacing="0" width="100%">
            <thead>
              <tr>
                <th scope="col">Docket</th>
                <!--<th>Project Start Date</th>
    <th>Project End Date</th>-->
                <th scope="col">Effective Date</th>
                <th scope="col">Expiration Date</th>
                <th scope="col">NDAs</th>
                <th scope="col">Options</th>
              </tr>
            </thead>
            <tfoot>
              <tr>
                <th scope="col">Docket</th>
                <!--<th>Project Start Date</th>
    <th>Project End Date</th>-->
                <th scope="col">Effective Date</th>
                <th scope="col">Expiration Date</th>
                <th scope="col">NDAs</th>
                <th scope="col">Options</th>
              </tr>
            </tfoot>

            <?php if (!isset($_GET["docket"])) {
              //$q = "SELECT DISTINCT [Project ID] AS ProjectID,[Project Start Date],[Project End Date] FROM [orspdb].[dbo].[GM_AWD_PROJ_PROFILE] ORDER BY [Project Start Date] DESC";
              //$q = "SELECT DISTINCT SUBSTRING([Award/Proposal #],1,10) AS ORSPNumber FROM [orspdb].[dbo].[GM_AWD_PROJ_PROFILE] WHERE [Subcontract] = 'Yes' ORDER BY ORSPNumber DESC";
              $q = "SELECT DISTINCT SUBSTRING([Award/Proposal #],1,11) AS ORSPNumber FROM [orspdb].[dbo].[GM_AWD_PROJ_PROFILE] WHERE [Subcontract] = 'Yes' ORDER BY ORSPNumber DESC";
            } else {
              /*if (preg_match("/(.*)[A-Z]/",$_GET["subcontract"],$match))
        {

        // If the project id for the NOA has a letter at the end then remove it.

        $_GET["subcontract"] = $match[1];
        }*/
              /*if ($_GET["subcontract"] == 'All')
        {
        $_GET["subcontract"] = '';
        }*/
              //$q = "SELECT DISTINCT [Project ID] AS ProjectID,[Project Start Date],[Project End Date] FROM [orspdb].[dbo].[GM_AWD_PROJ_PROFILE] WHERE [Project ID] LIKE '".$_GET["subcontract"]."%' ORDER BY [Project Start Date] DESC";
              //$q = "SELECT DISTINCT SUBSTRING([Award/Proposal #],1,10) AS ORSPNumber FROM [orspdb].[dbo].[GM_AWD_PROJ_PROFILE] WHERE [Subcontract] = 'Yes' AND [Award/Proposal #] LIKE '".$_GET["subcontract"]."%' ORDER BY ORSPNumber DESC";
              //$q = "SELECT DISTINCT SUBSTRING([Award/Proposal #],1,11) AS ORSPNumber FROM [orspdb].[dbo].[GM_AWD_PROJ_PROFILE] WHERE [Subcontract] = 'Yes' AND [Award/Proposal #] LIKE '".$_GET["subcontract"]."%' ORDER BY ORSPNumber DESC";
              $q = "SELECT DISTINCT Docket,[Effective Date],[Expiration Date] FROM [displayndas_dev].[dbo].[ndas] WHERE Docket LIKE '" . $_GET["docket"] . "%' ORDER BY docket DESC";
            }
            $mssqlresults = $mssqldb_conn->query($q);
            if (!$mssqlresults) {
              echo "query = $q<br><br>";
              echo (__FILE__ . ":" . __LINE__ . ' Error: ');
              print_r($mssqldb_conn->errorInfo());
              die();
            }
            while ($row = $mssqlresults->fetch(PDO::FETCH_ASSOC)) {
              /*if (preg_match("/(.*)[A-Z]/",$row['ProjectID'],$match))
        {

        // If the project id for the NOA has a letter at the end then remove it.

        $row['ProjectID'] = $match[1];
        }*/

              // Check the directories for the occurence of the orsp number and display once found the documents inside the folder having // the orsp number as its name.

              //if (file_exists("\\\ORSPSRVAPP02\\webroot2\\Subawards (used by subcontractsdocuments)\\".$row['ORSPNumber']))
              //{
              //$directory = dir("\\\ORSPSRVAPP02\\webroot2\\Subawards (used by subcontractsdocuments)\\".$row['ORSPNumber']."\\Sub-Awards");
              //$directory = dir("\\\ORSPSRVAPP00\\Public\\Intellectual Property\\Non-Disclosures");
              //$directory = dir("\\\ORSPSRVAPP02\\webroot2\\NDAs (used by displayndas)");
              //$directory->read();
              //$directory->read();
              //while ($entry = $directory->read())
              //{
            ?>

              <?php


              /*$q = "SELECT DISTINCT [Vendor Name] AS VendorName FROM [orspdb].[dbo].[GM_AWD_PROJ_PROFILE] WHERE [Award/Proposal #] LIKE '".$row['ORSPNumber']."%'";
            //echo(__FILE__.":".__LINE__.' $q = '.$q.'<br>');
            $mssqlresults2 = $mssqldb_conn->query($q);
            if (!$mssqlresults2)
            {
            echo "query = $q<br><br>";
            echo(__FILE__.":".__LINE__.' Error: ');
            print_r($mssqldb_conn->errorInfo());
            die();
            }
            //echo(__FILE__.":".__LINE__.' $mssqlresults2 -> rowCount() = '.$mssqlresults2 -> rowCount().'<br>');
            $row2 = $mssqlresults2 -> fetch(PDO::FETCH_ASSOC);
            $temp = $row2['VendorName'];
            $row2 = $mssqlresults2 -> fetch(PDO::FETCH_ASSOC);*/
              //echo(__FILE__.":".__LINE__.' $mssqlresults2 -> rowCount() = '.$mssqlresults2 -> rowCount().'<br>');
              //if ($mssqlresults2 -> rowCount() > 1)
              //if ($row2['VendorName'] != "")
              //{
              /*$q = "SELECT [Full Name] AS VendorName FROM SubrecipientFullNames WHERE Subrecipient = '".$entry."' AND ORSPNumber IS NULL";
            //echo(__FILE__.":".__LINE__.' $q = '.$q.'<br>');
            $mssqlresults2 = $mssqldb_conn2->query($q);
            if (!$mssqlresults2)
            {
            echo "query = $q<br><br>";
            echo(__FILE__.":".__LINE__.' Error: ');
            print_r($mssqldb_conn2->errorInfo());
            die();
            }
            $row2 = $mssqlresults2 -> fetch(PDO::FETCH_ASSOC);
            //}
            //else
            //{
            // $row2['VendorName'] = $temp;
            //}
            //echo(__FILE__.":".__LINE__.' $mssqlresults2 -> rowCount() = '.$mssqlresults2 -> rowCount().'<br>');
            if ($mssqlresults2 -> rowCount() == 0)
            {
            $q = "SELECT [Full Name] AS VendorName FROM SubrecipientFullNames WHERE Subrecipient = '".$entry."' AND ORSPNumber = '".$row['ORSPNumber']."'";
            //echo(__FILE__.":".__LINE__.' $q = '.$q.'<br>');
            $mssqlresults2 = $mssqldb_conn2->query($q);
            if (!$mssqlresults2)
            {
            echo "query = $q<br><br>";
            echo(__FILE__.":".__LINE__.' Error: ');
            print_r($mssqldb_conn2->errorInfo());
            die();
            }
            $row2 = $mssqlresults2 -> fetch(PDO::FETCH_ASSOC);
            }
            //echo(__FILE__.":".__LINE__.' $mssqlresults2 -> rowCount() = '.$mssqlresults2 -> rowCount().'<br>');
            if ($mssqlresults2 -> rowCount() == 0)
            {
            //$q = "SELECT DISTINCT [Vendor Name] AS VendorName FROM [orspdb].[dbo].[GM_AWD_PROJ_PROFILE] WHERE [Award/Proposal #] LIKE '".$row['ORSPNumber']."%' AND SUBSTRING([Vendor Name],1,4) != 'THE ' AND SUBSTRING([Vendor Name],1,1) = '".substr($entry,0,1)."'";
            $q = "SELECT DISTINCT [Name] AS VendorName FROM UTE_GM_AWD_PRJ_VNDR WHERE [Contract] LIKE '".$row['ORSPNumber']."%' AND SUBSTRING([Name],1,4) != 'THE ' AND SUBSTRING([Name],1,1) = '".substr($entry,0,1)."'";
            //echo(__FILE__.":".__LINE__.' $q = '.$q.'<br>');
            $mssqlresults2 = $mssqldb_conn3->query($q);
            if (!$mssqlresults2)
            {
            echo "query = $q<br><br>";
            echo(__FILE__.":".__LINE__.' Error: ');
            print_r($mssqldb_conn3->errorInfo());
            die();
            }
            //echo(__FILE__.":".__LINE__.' $mssqlresults2 -> rowCount() = '.$mssqlresults2 -> rowCount().'<br>');
            $row2 = $mssqlresults2 -> fetch(PDO::FETCH_ASSOC);
            $temp = $row2['VendorName'];
            //echo(__FILE__.":".__LINE__.' $row2[VendorName] = '.$row2['VendorName'].'<br>');
            $row2 = $mssqlresults2 -> fetch(PDO::FETCH_ASSOC);
            //echo(__FILE__.":".__LINE__.' $row2[VendorName] = '.$row2['VendorName'].'<br>');
            //echo(__FILE__.":".__LINE__.' $mssqlresults2 -> rowCount() = '.$mssqlresults2 -> rowCount().'<br>');
            //if ($mssqlresults2 -> rowCount() > 1)
            if ($row2['VendorName'] != "")
            {
            $row2['VendorName'] = "";
            }
            else
            {
            $row2['VendorName'] = $temp;
            }
            }*/
              //echo substr($row['Expiration Date'],0,11).'</td>';
              ?>
              <?php // echo $row['Expiration Date']; 
              ?>

              <?php
              //$directory2 = dir("\\\ORSPSRVAPP02\\webroot2\\Subawards (used by subcontractsdocuments)\\".$row['ORSPNumber']."\\Sub-Awards\\".$entry);
              //$directory2->read();
              //$directory2->read();
              //$entry2 = $directory2->read();
              //$entry2 = str_replace('#','%23',$entry2);

              $q = "SELECT Filename FROM ndafiles WHERE Filename LIKE '%" . $row['Docket'] . "%'";
              $result2 = $extra_conn->query($q);
              if (!$result2) {
                echo "query = $q<br><br>";
                echo (__FILE__ . ":" . __LINE__ . ' Error: ');
                print_r($extra_conn->errorInfo());
                die();
              }
              $row2 = $result2->fetch(PDO::FETCH_ASSOC);
              // echo '<a href="https://orspweb2.utep.edu/NDAs_dev/', $row2['Filename'], '" target="_blank">', htmlentities($row2['Filename']), '</a></td>';

              if (($row2['Filename']) && ($scdocs_admins_access)) {

                echo '<tr>
                  <td>' . $row['Docket'] . '</td>
                  <td>' . $row['Effective Date'] . '</td>
                  <td>' . $row['Expiration Date'] . '</td>
                
                  <td><a href="https://orspweb2.utep.edu/NDAs_dev/', $row2['Filename'], '" target="_blank">', htmlentities($row2['Filename']), '</a></td>
                
                  <td>

                  <div class="form-group">
                          
                    <select class="form-control" id="exampleFormControlSelect1" onchange="location=this.value;">

                      <option value="DeleteFile.php?file=NDAs_dev\\', rawurlencode($row2['Filename']), '">Delete File </option>

                      <option value="https://orspweb2.utep.edu/displayndas_dev/UploadDocument.php?docket=' . $row['Docket'] . '">Upload File</option>

                    </select>
                  </div>
                
                  </td>
                </tr>';
              }

              while ($row2 = $result2->fetch(PDO::FETCH_ASSOC)) {
                if ($scdocs_admins_access) {
                  echo '<tr>
                        <td>' . $row['Docket'] . '</td>
                        <td>' . $row['Effective Date'] . '</td>
                        <td>' . $row['Expiration Date'] . '</td>
                        <td><a href="https://orspweb2.utep.edu/NDAs_dev/\\', rawurlencode($row2['Filename']), '" target="_blank" >', htmlentities($row2['Filename']), ' </a></td>

                        <td>
                        
                        <div class="form-group">
                          
                          <select class="form-control" id="exampleFormControlSelect1" onchange="location=this.value;">

                            <option value="DeleteFile.php?file=NDAs_dev\\', rawurlencode($row2['Filename']), '">Delete File </option>
                          
                            <option value="DeleteFile.php?file=', $row['Docket'], '"> Delete Docket</option>

                            <option value="https://orspweb2.utep.edu/displayndas_dev/UploadDocument.php?docket=' . $row['Docket'] . '">Upload File</option>
 
                          </select>
                        </div>

                        </td>
                        </tr>';



                  // <a href="DeleteFile.php?file=', $row['Docket'], '" target="_blank" class="btn btn-danger"> Delete Docket</a>

                  // <a href="DeleteFile.php?file=NDAs_dev\\', rawurlencode($row2['Filename']), '" target="_blank" class="btn btn-warning"> Delete </a>

                  // <a href="https://orspweb2.utep.edu/displayndas_dev/UploadDocument.php?docket=' . $row['Docket'] . '" target="_blank" class="btn btn-primary">Upload File</a>








                  // echo '&nbsp; , <a href="https://orspweb2.utep.edu/NDAs_dev/\\', rawurlencode($row2['Filename']), '" target="_blank" class="btn btn-warning"> 2nd file </a>';
                }


                //if (($entry2) && (($_SESSION["UID"] == 'osegueda') || ($_SESSION["UID"] == 'blekal') || ($_SESSION["UID"] == 'mslopez4') || ($_SESSION["UID"] == 'ehzazueta') || ($_SESSION["UID"] == 'rchavez13') || ($_SESSION["UID"] == 'mvalvillar')))
              }
              ?>

            <?php
              // if (($row2['Filename']) && ($scdocs_admins_access)) {
              //   echo '&nbsp; <a href="DeleteFile.php?file=NDAs_dev\\', rawurlencode($row2['Filename']), '" target="_blank" class="btn btn-danger"> [Delete]</a>';
              // }
              // while ($row2 = $result2->fetch(PDO::FETCH_ASSOC)) {
              //   //$entry2 = str_replace('#','%23',$entry2); 
              //   // echo '&nbsp;  , <a href="https://orspweb2.utep.edu/NDAs_dev/', $row2['Filename'], '" target="_blank">', htmlentities($row2['Filename']), '</a>';

              //   if ($scdocs_admins_access) {
              //     echo '&nbsp;  <a href="DeleteFile.php?file=NDAs_dev\\', rawurlencode($row2['Filename']), '" target="_blank" class="btn btn-warning"> [Delete2]</a>';
              //   }
              // }
              //if (($_SESSION["UID"] == 'osegueda') || ($_SESSION["UID"] == 'blekal') || ($_SESSION["UID"] == 'mslopez4') || ($_SESSION["UID"] == 'ehzazueta') || ($_SESSION["UID"] == 'rchavez13') || ($_SESSION["UID"] == 'mvalvillar'))
              //           if ($scdocs_admins_access) {
              //             echo '&nbsp;&nbsp;&nbsp; &nbsp; &nbsp; <a href="DeleteFile.php?file=', $row['Docket'], '" target="_blank" class="btn btn-danger"> Delete Docket</a> &nbsp;|&nbsp;';
              //             echo '&nbsp;<a href="https://orspweb2.utep.edu/displayndas_dev/UploadDocument.php?docket=' . $row['Docket'] . '" target="_blank" class="btn btn-primary">Upload File</a></td>';
              //           } else {
              //             echo '</td>';
              //           }
              //           echo '
              // </tr>';


              //}
              //$directory->close();
              //$directory2->close();
              //}
              /*else if (file_exists("\\\ORSPSRVAPP02\\webroot2\\Contracts and Grants (used by displaynoas)\\NOAs\\DHHS- NIH People Soft\\".$row['ProjectID']))
        {
        $directory = dir("\\\ORSPSRVAPP02\\webroot2\\Contracts and Grants (used by displaynoas)\\NOAs\\DHHS- NIH People Soft\\".$row['ProjectID']);
        echo '
        <td>';
          $directory->read();
          $directory->read();
          $entry = $directory->read();
          echo ' <a href="https://orspweb2.utep.edu/Contracts and Grants (used by displaynoas)/NOAS/DHHS- NIH People Soft/',$row['ProjectID'],'/',$entry,'" target="_blank">',$entry,'</a>';
          if (($entry) && (($_SESSION["UID"] == 'osegueda') || ($_SESSION["UID"] == 'blekal') || ($_SESSION["UID"] == 'mslopez4')))
          {
          echo ' <a href="DeleteFile.php?file=Contracts and Grants (used by displaynoas)\\NOAS\\DHHS- NIH People Soft\\',$row['ProjectID'],'\\',$entry,'" target="_blank"> Delete</a>';
          }
          while ($entry = $directory->read())
          {
          echo ' , <a href="https://orspweb2.utep.edu/Contracts and Grants (used by displaynoas)/NOAS/DHHS- NIH People Soft/',$row['ProjectID'],'/',$entry,'" target="_blank">',$entry,'</a>';
          if (($_SESSION["UID"] == 'osegueda') || ($_SESSION["UID"] == 'blekal') || ($_SESSION["UID"] == 'mslopez4'))
          {
          echo ' <a href="DeleteFile.php?file=Contracts and Grants (used by displaynoas)\\NOAS\\DHHS- NIH People Soft\\',$row['ProjectID'],'\\',$entry,'" target="_blank"> Delete</a>';
          }
          }
          if (($_SESSION["UID"] == 'osegueda') || ($_SESSION["UID"] == 'blekal') || ($_SESSION["UID"] == 'mslopez4'))
          {
          echo ' <a href="https://orspweb2.utep.edu/displaynoas/UploadNOA.php?Directory=NOAs\\DHHS- NIH People Soft&ProjectID='.$row['ProjectID'].'" target="_blank"> Upload</a></td>';
        }
        else
        {
        echo '</td>';
        }
        $directory->close();
        }
        else if (file_exists("\\\ORSPSRVAPP02\\webroot2\\Contracts and Grants (used by displaynoas)\\NOAs\\NSF People Soft\\".$row['ProjectID']))
        {
        $directory = dir("\\\ORSPSRVAPP02\\webroot2\\Contracts and Grants (used by displaynoas)\\NOAs\\NSF People Soft\\".$row['ProjectID']);
        echo '
        <td>';
          $directory->read();
          $directory->read();
          $entry = $directory->read();
          echo ' <a href="https://orspweb2.utep.edu/Contracts and Grants (used by displaynoas)/NOAS/NSF People Soft/',$row['ProjectID'],'/',$entry,'" target="_blank">',$entry,'</a>';
          if (($entry) && (($_SESSION["UID"] == 'osegueda') || ($_SESSION["UID"] == 'blekal') || ($_SESSION["UID"] == 'mslopez4')))
          {
          echo ' <a href="DeleteFile.php?file=Contracts and Grants (used by displaynoas)\\NOAS\\NSF People Soft\\',$row['ProjectID'],'\\',$entry,'" target="_blank"> Delete</a>';
          }
          while ($entry = $directory->read())
          {
          echo ' , <a href="https://orspweb2.utep.edu/Contracts and Grants (used by displaynoas)/NOAS/NSF People Soft/',$row['ProjectID'],'/',$entry,'" target="_blank">',$entry,'</a>';
          if (($_SESSION["UID"] == 'osegueda') || ($_SESSION["UID"] == 'blekal') || ($_SESSION["UID"] == 'mslopez4'))
          {
          echo ' <a href="DeleteFile.php?file=Contracts and Grants (used by displaynoas)\\NOAS\\NSF People Soft\\',$row['ProjectID'],'\\',$entry,'" target="_blank"> Delete</a>';
          }
          }
          if (($_SESSION["UID"] == 'osegueda') || ($_SESSION["UID"] == 'blekal') || ($_SESSION["UID"] == 'mslopez4'))
          {
          echo ' <a href="https://orspweb2.utep.edu/displaynoas/UploadNOA.php?Directory=NOAs\\NSF People Soft&ProjectID='.$row['ProjectID'].'" target="_blank"> Upload</a></td>';
        }
        else
        {
        echo '</td>';
        }
        $directory->close();
        }
        else if (file_exists("\\\ORSPSRVAPP02\\webroot2\\Contracts and Grants (used by displaynoas)\\NOAs - No Cost Extensions\\".$row['ProjectID']))
        {
        $directory = dir("\\\ORSPSRVAPP02\\webroot2\\Contracts and Grants (used by displaynoas)\\NOAs - No Cost Extensions\\".$row['ProjectID']);
        echo '
        <td>';
          $directory->read();
          $directory->read();
          $entry = $directory->read();
          echo ' <a href="https://orspweb2.utep.edu/Contracts and Grants (used by displaynoas)/NOAs - No Cost Extensions/',$row['ProjectID'],'/',$entry,'" target="_blank">',$entry,'</a>';
          if (($entry) && (($_SESSION["UID"] == 'osegueda') || ($_SESSION["UID"] == 'blekal') || ($_SESSION["UID"] == 'mslopez4')))
          {
          echo ' <a href="DeleteFile.php?file=Contracts and Grants (used by displaynoas)\\NOAs - No Cost Extensions\\',$row['ProjectID'],'\\',$entry,'" target="_blank"> Delete</a>';
          }
          while ($entry = $directory->read())
          {
          echo ' , <a href="https://orspweb2.utep.edu/Contracts and Grants (used by displaynoas)/NOAs - No Cost Extensions/',$row['ProjectID'],'/',$entry,'" target="_blank">',$entry,'</a>';
          if (($_SESSION["UID"] == 'osegueda') || ($_SESSION["UID"] == 'blekal') || ($_SESSION["UID"] == 'mslopez4'))
          {
          echo ' <a href="DeleteFile.php?file=Contracts and Grants (used by displaynoas)\\NOAs - No Cost Extensions\\',$row['ProjectID'],'\\',$entry,'" target="_blank"> Delete</a>';
          }
          }
          if (($_SESSION["UID"] == 'osegueda') || ($_SESSION["UID"] == 'blekal') || ($_SESSION["UID"] == 'mslopez4'))
          {
          echo ' <a href="https://orspweb2.utep.edu/displaynoas/UploadNOA.php?Directory=NOAs - No Cost Extensions&ProjectID='.$row['ProjectID'].'" target="_blank"> Upload</a></td>';
        }
        else
        {
        echo '</td>';
        }
        $directory->close();
        }
        else if (file_exists("\\\ORSPSRVAPP02\\webroot2\\Contracts and Grants (used by displaynoas)\\NOAs\\".$row['ProjectID']))
        {
        $directory = dir("\\\ORSPSRVAPP02\\webroot2\\Contracts and Grants (used by displaynoas)\\NOAs\\".$row['ProjectID']);
        echo '
        <td>';
          $directory->read();
          $directory->read();
          $entry = $directory->read();
          echo ' <a href="https://orspweb2.utep.edu/Contracts and Grants (used by displaynoas)/NOAS/',$row['ProjectID'],'/',$entry,'" target="_blank">',$entry,'</a>';
          if (($entry) && (($_SESSION["UID"] == 'osegueda') || ($_SESSION["UID"] == 'blekal') || ($_SESSION["UID"] == 'mslopez4')))
          {
          echo ' <a href="DeleteFile.php?file=Contracts and Grants (used by displaynoas)\\NOAS\\',$row['ProjectID'],'\\',$entry,'" target="_blank"> Delete</a>';
          }
          while ($entry = $directory->read())
          {
          echo ' , <a href="https://orspweb2.utep.edu/Contracts and Grants (used by displaynoas)/NOAS/',$row['ProjectID'],'/',$entry,'" target="_blank">',$entry,'</a>';
          if (($_SESSION["UID"] == 'osegueda') || ($_SESSION["UID"] == 'blekal') || ($_SESSION["UID"] == 'mslopez4'))
          {
          echo ' <a href="DeleteFile.php?file=Contracts and Grants (used by displaynoas)\\NOAS\\',$row['ProjectID'],'\\',$entry,'" target="_blank"> Delete</a>';
          }
          }
          if (($_SESSION["UID"] == 'osegueda') || ($_SESSION["UID"] == 'blekal') || ($_SESSION["UID"] == 'mslopez4'))
          {
          echo ' <a href="https://orspweb2.utep.edu/displaynoas/UploadNOA.php?Directory=NOAs&ProjectID='.$row['ProjectID'].'" target="_blank"> Upload</a></td>';
        }
        else
        {
        echo '</td>';
        }
        $directory->close();
        }
        else if (file_exists("\\\ORSPSRVAPP02\\webroot2\\Contracts and Grants (used by displaynoas)\\Scanned Documents\NOAs\NOAs\\".$row['ProjectID']))
        {
        $directory = dir("\\\ORSPSRVAPP02\\webroot2\\Contracts and Grants (used by displaynoas)\\Scanned Documents\NOAs\NOAs\\".$row['ProjectID']);
        echo '
        <td>';
          $directory->read();
          $directory->read();
          $entry = $directory->read();
          echo ' <a href="https://orspweb2.utep.edu/Contracts and Grants (used by displaynoas)/Scanned Documents/NOAs/NOAs/',$row['ProjectID'],'/',$entry,'" target="_blank">',$entry,'</a>';
          if (($entry) && (($_SESSION["UID"] == 'osegueda') || ($_SESSION["UID"] == 'blekal') || ($_SESSION["UID"] == 'mslopez4')))
          {
          echo ' <a href="DeleteFile.php?file=Contracts and Grants (used by displaynoas)\\Scanned Documents\\NOAs\\NOAs\\',$row['ProjectID'],'\\',$entry,'" target="_blank"> Delete</a>';
          }
          while ($entry = $directory->read())
          {
          echo ' , <a href="https://orspweb2.utep.edu/Contracts and Grants (used by displaynoas)/Scanned Documents/NOAs/NOAs/',$row['ProjectID'],'/',$entry,'" target="_blank">',$entry,'</a>';
          if (($_SESSION["UID"] == 'osegueda') || ($_SESSION["UID"] == 'blekal') || ($_SESSION["UID"] == 'mslopez4'))
          {
          echo ' <a href="DeleteFile.php?file=Contracts and Grants (used by displaynoas)\\Scanned Documents\\NOAs\\NOAs\\',$row['ProjectID'],'\\',$entry,'" target="_blank"> Delete</a>';
          }
          }
          if (($_SESSION["UID"] == 'osegueda') || ($_SESSION["UID"] == 'blekal') || ($_SESSION["UID"] == 'mslopez4'))
          {
          echo ' <a href="https://orspweb2.utep.edu/displaynoas/UploadNOA.php?Directory=Scanned Documents\\NOAs\NOAs&ProjectID='.$row['ProjectID'].'" target="_blank"> Upload</a></td>';
        }
        else
        {
        echo '</td>';
        }
        $directory->close();
        }*/
              /*else
        {
        echo '
        <tr>
          <td>'.$row['ORSPNumber'].'</td>';
          echo '
          <td>';
            //if (($_SESSION["UID"] == 'osegueda') || ($_SESSION["UID"] == 'blekal') || ($_SESSION["UID"] == 'mslopez4') || ($_SESSION["UID"] == 'ehzazueta') || ($_SESSION["UID"] == 'rchavez13') || ($_SESSION["UID"] == 'mvalvillar'))
            if ($scdocs_admins_access)
            {
            //echo ' <a href="https://orspweb2.utep.edu/subcontractsdocuments/UploadDocument.php?subrecipient=&subcontract='.$row['ORSPNumber'].'" target="_blank"> Upload</a></td>';
          echo ' <a href="UploadDocument.php?docket='.$row['ORSPNumber'].'" target="_blank"> Upload</a></td>';
          }
          else
          {
          echo '</td>';
          }
          //echo '
          //<td>';
            //echo $row2['Vendor Name'].'</td>';
          echo '
        </tr>';
        }*/
            }
            ?>

          </table>

          <br><br>
        </div> <!-- container -->
        

        <!-- footer -->
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


    <!-- js -->
    <script src="assets/js/bootstrap.min.js" type="text/javascript"></script>
    <script src="assets/js/modernizr-2.8.3.min.js" type="text/javascript"></script>
    <script src="assets/js/jquery.sidr.js" type="text/javascript"></script>
    <script src="assets/js/iphone-inline-video.browser.js" type="text/javascript"></script>
    <script src="assets/js/carrousel-autoplay.js" type="text/javascript"></script>
    <script src="assets/js/main.js" type="text/javascript"></script>
    <script src="assets/js/carousel.js" type="text/javascript"></script>

    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.15/css/jquery.dataTables.min.css" />
  <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/buttons/1.3.1/css/buttons.dataTables.min.css" />
  <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/fixedheader/3.1.2/css/fixedHeader.dataTables.min.css" />


  <script type="text/javascript" src="https://cdn.datatables.net/1.10.15/js/jquery.dataTables.min.js"></script>
  <script type="text/javascript" src="https://cdn.datatables.net/buttons/1.3.1/js/dataTables.buttons.min.js"></script>
  <script type="text/javascript" src="https://cdn.datatables.net/buttons/1.3.1/js/buttons.flash.min.js"></script>
  <script type="text/javascript" src="https://cdn.datatables.net/buttons/1.3.1/js/buttons.html5.min.js"></script>
  <script type="text/javascript" src="https://cdn.datatables.net/buttons/1.3.1/js/buttons.print.min.js"></script>
  <script type="text/javascript" src="https://cdn.datatables.net/fixedheader/3.1.2/js/dataTables.fixedHeader.min.js"></script>


    <script type="text/javascript" language="javascript" src="https://cdn.datatables.net/buttons/1.3.1/js/dataTables.buttons.min.js">
    </script>
    <script type="text/javascript" language="javascript" src="//cdn.datatables.net/buttons/1.3.1/js/buttons.flash.min.js">
    </script>
    <script type="text/javascript" language="javascript" src="//cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js">
    </script>
    <script type="text/javascript" language="javascript" src="//cdn.rawgit.com/bpampuch/pdfmake/0.1.27/build/pdfmake.min.js">
    </script>
    <script type="text/javascript" language="javascript" src="//cdn.rawgit.com/bpampuch/pdfmake/0.1.27/build/vfs_fonts.js">
    </script>
    <script type="text/javascript" language="javascript" src="//cdn.datatables.net/buttons/1.3.1/js/buttons.html5.min.js">
    </script>
    <script type="text/javascript" language="javascript" src="//cdn.datatables.net/buttons/1.3.1/js/buttons.print.min.js">
    </script>

    <!-- MARKS TO HIGHLIGHT DATATABLE SEARCH -->
    <script type="text/javascript" language="javascript" src="https://cdn.jsdelivr.net/datatables.mark.js/2.0.0/datatables.mark.min.js">
    </script>
    <script type="text/javascript" language="javascript" src="https://cdn.jsdelivr.net/mark.js/8.6.0/jquery.mark.min.js">
    </script>

    <!-- <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script> -->
</body>

</html>