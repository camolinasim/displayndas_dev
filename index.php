<?php

//delete
function println($data) {
$console = $data;
if (is_array($console))
$console = implode(',', $console);

echo "<script>console.log('Console: " . $console . "' );</script>";
}

//delete

require_once("./conf/conf_db_mssql_ndas.php");
require_once("./conf/conf.php");

if (!isset($_GET['docket'])) {
 $_GET['docket'] = "";
}

// $redirect=  'Location: reportexample.php?docket='.$_GET['docket'];

session_start();

// ----------
if ( isset($_SESSION[$userAuthenticationID_key]) && isset($_SESSION[$userAuthenticationAuth_key]) && isset($_SESSION[$userAuthenticationKey_key]) ){
 $_SESSION['docket'] = $_GET['docket'];
 // DO NOTHING
} else if ($_SERVER['HTTP_HOST'] != "localhost"){  // Only have the user log in if this is running on the server.
 //Redirect to login!
 header("Location:login.php"); exit(0);
}

// ----------

println($PDO_ndas);
$mssqldb_conn = new PDO($PDO_ndas);
$extra_conn = new PDO($PDO_ndas);


if (!$mssqldb_conn)
{
 echo "Unable to connect to the MSSQL server";
 exit(0);
}



//$NumberOfFiles = count(scandir("D:\inetpub\webroot2\\NDAs (used by displayndas)"));
$NumberOfFiles = count(scandir("\\\ORSPSRVAPP02\\webroot2\\NDAs_dev"));
$q = "SELECT NumberOfFiles FROM [displayndas_dev].[dbo].[ndafiles] WHERE NumberOfFiles IS NOT NULL";
$result2 = $mssqldb_conn->query($q);
if (!$result2)
{
 echo "query = $q<br><br>";
 echo(__FILE__.":".__LINE__.' Error: ');
 print_r($mssqldb_conn->errorInfo());
 die();
}
$row2 = $result2->fetch(PDO::FETCH_ASSOC);
//$d = dir("D:\4rpub\webroot2\\NDAs (used by displayndas)");


if ($row2['NumberOfFiles'] != $NumberOfFiles)
{
 $d = dir("\\\ORSPSRVAPP02\\webroot2\\NDAs_dev");

 // Delete all the records in table ndafiles...

 $q = "DELETE FROM [displayndas_dev].[dbo].[ndafiles];";
 $result = $mssqldb_conn->query($q);
 if (!$result)
 {
   echo "query = $q<br><br>";
   echo(__FILE__.":".__LINE__.' Error: ');
   print_r($mssqldb_conn->errorInfo());
   die();
 }


 $entry = $d->read();

 while (false !== ($entry = $d->read())) {

   $filename = "('".str_replace("'","`",$entry)."')";

   //-----
   // Insert filename into table  -FIX : Arnold 022120
   //-----

   $q = "INSERT INTO [displayndas_dev].[dbo].[ndafiles] (Filename) VALUES $filename;";
   $result = $mssqldb_conn->query($q);
   if (!$result)
   {
     echo "query = $q<br><br>";
     echo(__FILE__.":".__LINE__.' Error: ');
     print_r($mssqldb_conn->errorInfo());
     die();
   }

 }


 // Update the table with the current number of directories.

 $q = "INSERT INTO [displayndas_dev].[dbo].[ndafiles] (NumberOfFiles) VALUES (".$NumberOfFiles.");";
 $result = $mssqldb_conn->query($q);
 if (!$result)
 {
   echo "query = $q<br><br>";
   echo(__FILE__.":".__LINE__.' Error: ');
   print_r($mssqldb_conn->errorInfo());
   die();
 }
 $d->close();
}

//$q = "SELECT DISTINCT SUBSTRING([Award/Proposal #],1,10) AS ORSPNumber FROM [orspdb].[dbo].[GM_AWD_PROJ_PROFILE] WHERE [Subcontract] = 'Yes' ORDER BY ORSPNumber DESC";
//$q = "SELECT Docket FROM ndas ORDER BY Docket DESC";
//$q = "SELECT DISTINCT Docket,[Effective Date],[Expiration Date] FROM ndas ORDER BY Docket DESC";
$q = "SELECT DISTINCT Docket FROM ndas ORDER BY Docket DESC";
//$q = "SELECT DISTINCT SUBSTRING([Award/Proposal #],1,11) AS ORSPNumber FROM [orspdb].[dbo].[GM_AWD_PROJ_PROFILE] WHERE [Subcontract] = 'Yes' ORDER BY ORSPNumber DESC";


$mssqlresults = $mssqldb_conn->query($q);

if (!$mssqlresults)
{
 echo "query = $q<br><br>";
 echo(__FILE__.":".__LINE__.' Error: ');
 print_r($mssqldb_conn->errorInfo());
 die();
}

?>

<!DOCTYPE html
 PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
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
 <link href="https://cloud.typography.com/6793094/7122152/css/fonts.css" rel="stylesheet" type="text/css" />

 <!-- JS -->
 <script src="assets/js/jquery-2.1.1.min.js" type="text/javascript"></script>
 <script src="assets/js/jquery-ui.min.js" type="text/javascript"></script>

 <?php include_once("assets/regions/navbar.php"); ?>



 <script type="text/javascript">
   $(document).ready(function () {
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
           action: function () {
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

   table.table-fit thead th,
   table.table-fit tfoot th {
     width: auto !important;
   }

   table.table-fit tbody td,
   table.table-fit tfoot td {
     width: auto !important;
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

   .modal-backdrop {
     z-index: -1;
   }
 </style>

</head>


<body>

<div class="container" id="container">

<div class="container">
 <div class="flexBoxWrapper">
   <div class="col-md-12">
     <div class="visible-md visible-lg">
       <div class="row">
         <div class="col-md-12">
           <ul class="breadcrumb">
             <li><a href="index.php">NDA Display</a></li>
           </ul>
         </div>
       </div>
     </div>
     <br /><br />
     <h2 align="center">NDA Display </h2>


         <!-- The Add New NDA Modal -->
         <div id="ndaModal" class="modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
           aria-hidden="true">
           <br /><br />
           <div class="modal-dialog" role="document">

             <!-- Modal content -->
             <div class="modal-content">
               <div class="modal-header">
                 <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                   <span aria-hidden="true">&times;</span>
                 </button>
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
           </div>

           <script>
             // Get the modal
             var modal = document.getElementById("ndaModal");

             // Get the <span> element that closes the modal
             var span = document.getElementsByClassName("close")[0];


             // When the user clicks on <span> (x), close the modal
             span.onclick = function () {
               modal.style.display = "none";
             }

             // When the user clicks anywhere outside of the modal, close it
             window.onclick = function (event) {
               if (event.target == modal) {
                 modal.style.display = "none";
               }
             }
           </script>

         </div>

         <table id="ndas" class="table table-striped table-hover display table-fit" width="100%">
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

           <?php
             if (!isset($_GET["docket"])) {
               //$q = "SELECT DISTINCT [Project ID] AS ProjectID,[Project Start Date],[Project End Date] FROM [orspdb].[dbo].[GM_AWD_PROJ_PROFILE] ORDER BY [Project Start Date] DESC";
               //$q = "SELECT DISTINCT SUBSTRING([Award/Proposal #],1,10) AS ORSPNumber FROM [orspdb].[dbo].[GM_AWD_PROJ_PROFILE] WHERE [Subcontract] = 'Yes' ORDER BY ORSPNumber DESC";
               $q = "SELECT DISTINCT SUBSTRING([Award/Proposal #],1,11) AS ORSPNumber FROM [orspdb].[dbo].[GM_AWD_PROJ_PROFILE] WHERE [Subcontract] = 'Yes' ORDER BY ORSPNumber DESC";
             } else {
               $q = "SELECT DISTINCT Docket,[Effective Date],[Expiration Date] FROM [displayndas_dev].[dbo].[ndas] WHERE Docket LIKE '" . $_GET["docket"] . "%' ORDER BY docket DESC";
             }

             $extra_conn2 = new PDO($PDO_ndas);
             $mssqlresults = $extra_conn2->query($q);
             if (!$mssqlresults) {
               echo "query = $q<br><br>";
               echo (__FILE__ . ":" . __LINE__ . ' Error: ');
               print_r($extra_conn->errorInfo());
               die();
             }

             $mssqlresults = $mssqldb_conn->query($q);

             while ($row = $mssqlresults->fetch(PDO::FETCH_ASSOC)) {

               echo '
                 <tr>
                   <td>' . $row['Docket'] . '</td>
                   <td>' . $row['Effective Date'] . '</td>
                   <td>' . $row['Expiration Date'] . '</td>

                   <td>';

                     $q = "SELECT Filename FROM [displayndas_dev].[dbo].[ndafiles] WHERE Filename LIKE '%" . $row['Docket'] . "%'";
                     $result2 = $extra_conn->query($q);
                     if (!$result2) {
                       echo "<br> query = $q<br><br>";
                       echo (__FILE__ . ":" . __LINE__ . ' Error: ');
                       print_r($extra_conn->errorInfo());
                       die();
                     }
                     $row2 = $result2->fetch(PDO::FETCH_ASSOC);
                    //prints most filenames in the NDA's column
                     echo '<a href="https://orspweb2.utep.edu/NDAs_dev/', $row2['Filename'], '" target="_blank">', htmlentities($row2['Filename']), '</a>';

                     if (($row2['Filename']))
                     {
                       // $to_delete = rawurlencode($row2['Filename']);                    //file=NDAs_dev/
                       // $_POST['Filename'] = $to_delete;
                       echo '<form action="DeleteFile.php?file=', rawurlencode($row2['Filename']), '", method="POST"> <input type="submit" value="Delete!"></form>';

                       //'&nbsp;&nbsp;&nbsp;<button class="btn btn-warning" value="DeleteFile.php?fileName=', rawurlencode($row2['Filename']), '">Delete1 File </button>';
                     }
                     while ($row2 = $result2->fetch(PDO::FETCH_ASSOC))
                     {
                       //$entry2 = str_replace('#','%23',$entry2);
                       echo '<br><br> <a href="https://orspweb2.utep.edu/NDAs_dev/', $row2['Filename'],'" target="_blank">',htmlentities($row2['Filename']),'</a>';

                       // if ($scdocs_admins_access)
                       // {
                         echo '&nbsp;&nbsp;&nbsp;<button class="btn btn-warning" value="DeleteFile.php?file=NDAs_dev/', rawurlencode($row2['Filename']), '">Delete2 File </button>';
                       // }
                     }

                     // if ($scdocs_admins_access)
                     // {
                     echo '<td>';
                       //echo <form action="DeleteFile.php" method="POST"  <input type="submit" value="Delete Docket!"></form>;
                       echo '<form action="DeleteDocket.php?Docket=', $row['Docket'], '" method="post"> <input type="submit" value="Delete Docket!">';
                       //echo '<button class="btn btn-danger" value="DeleteFile.php?file=', $row['Docket'], '"> Delete Docket</button>';

                       echo '&nbsp;&nbsp;<button class="btn btn-primary" type="button" data-toggle="modal" data-target="#uploadDoc" value="https://orspweb2.utep.edu/displayndas_dev/UploadDocument.php?docket=' . $row['Docket'] . '">Upload File</button>
                     </td>'; ?>

                       <!-- The Upload New Docket Modal -->
                       <div id="uploadDoc" class="modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                           <br /><br />
                           <div class="modal-dialog" role="document">
                             <!-- Modal content -->
                             <div class="modal-content">
                               <div class="modal-header">
                               <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                               <span aria-hidden="true">&times;</span>
                             </button>
                                 <h2>Upload Document </h2>
                                 <p class="detail">Please fill out the form below to upload a new file.</p>
                               </div>
                               <div class="modal-body">

                               <?php include("UploadDocument.php"); ?>

                               <?php echo
                               '</div>
                               <div class="modal-footer">
                                 <h3>NDA Display</h3>
                               </div>
                             </div>
                           </div>' ?>

                         <script>
                             // Get the modal
                             var modal = document.getElementById("uploadDoc");

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

                 <?php echo '
                   </td>

                   </tr>';

             } //end of while loop that creates NDA main table

           ?>

         </table>

         <br><br>
       </div> <!-- cmd 12 -->
     </div> <!-- flexbox -->
   </div> <!-- container -->
   <!-- </div> main container -->


   <!-- footer -->
   <footer>
     <div class="container">

       <div class="col-md-3 footerLogo"><img alt="UTEP" class="img-responsive" src="assets/images/UTEP-Footer.png"
           title="UTEP" /></div>
       <!-- /col-md-3 -->
       <div class="col-md-9 requiredLinks">
         <h2>THE UNIVERSITY OF TEXAS AT EL PASO</h2>
         <ul>
           <li><a href="http://admin.utep.edu/Default.aspx?tabid=59577" target="_blank">Web Accessibility</a></li>
           <li><a href="https://adminapps.utep.edu/emergencynotification/generic/" target="_blank">Campus Alerts</a>
           </li>
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
       </div> <!-- /col-md-9 -->
     </div>
   </footer>
   <!-- </div> -->
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
   <link rel="stylesheet" type="text/css"
     href="https://cdn.datatables.net/buttons/1.3.1/css/buttons.dataTables.min.css" />
   <link rel="stylesheet" type="text/css"
     href="https://cdn.datatables.net/fixedheader/3.1.2/css/fixedHeader.dataTables.min.css" />


   <script type="text/javascript" src="https://cdn.datatables.net/1.10.15/js/jquery.dataTables.min.js"></script>
   <script type="text/javascript" src="https://cdn.datatables.net/buttons/1.3.1/js/dataTables.buttons.min.js"></script>
   <script type="text/javascript" src="https://cdn.datatables.net/buttons/1.3.1/js/buttons.flash.min.js"></script>
   <script type="text/javascript" src="https://cdn.datatables.net/buttons/1.3.1/js/buttons.html5.min.js"></script>
   <script type="text/javascript" src="https://cdn.datatables.net/buttons/1.3.1/js/buttons.print.min.js"></script>
   <script type="text/javascript"
     src="https://cdn.datatables.net/fixedheader/3.1.2/js/dataTables.fixedHeader.min.js"></script>


   <script type="text/javascript" language="javascript"
     src="https://cdn.datatables.net/buttons/1.3.1/js/dataTables.buttons.min.js">
     </script>
   <script type="text/javascript" language="javascript"
     src="//cdn.datatables.net/buttons/1.3.1/js/buttons.flash.min.js">
     </script>
   <script type="text/javascript" language="javascript"
     src="//cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js">
     </script>
   <script type="text/javascript" language="javascript"
     src="//cdn.rawgit.com/bpampuch/pdfmake/0.1.27/build/pdfmake.min.js">
     </script>
   <script type="text/javascript" language="javascript"
     src="//cdn.rawgit.com/bpampuch/pdfmake/0.1.27/build/vfs_fonts.js">
     </script>
   <script type="text/javascript" language="javascript"
     src="//cdn.datatables.net/buttons/1.3.1/js/buttons.html5.min.js">
     </script>
   <script type="text/javascript" language="javascript"
     src="//cdn.datatables.net/buttons/1.3.1/js/buttons.print.min.js">
     </script>

   <!-- MARKS TO HIGHLIGHT DATATABLE SEARCH -->
   <script type="text/javascript" language="javascript"
     src="https://cdn.jsdelivr.net/datatables.mark.js/2.0.0/datatables.mark.min.js">
     </script>
   <script type="text/javascript" language="javascript"
     src="https://cdn.jsdelivr.net/mark.js/8.6.0/jquery.mark.min.js">
     </script>

</body>

</html>
