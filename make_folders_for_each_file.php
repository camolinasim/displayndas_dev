<?php
//this file was created to organize the following path: \\orspsrvapp02\webroot2\NDAs_dev
//it used to have no folders: only 1000+ pdfs. This script scans the path metioned above, and creates folders for each file in the path
//It is meant to be run only once.
//After you run this script, run the move_folders_to_each_file.php script. 

//include("conf_db_mssql_ndas.php");
$path = "\\orspsrvapp02\webroot2\NDAs (used by displayndas)\\";
$q1 = "SELECT Docket FROM [displayndas].[dbo].[ndas]";
$q2 = "SELECT Filename FROM [displayndas].[dbo].[ndafiles]";
$extra_conn3 = new PDO($PDO_ndas);
//falta incluir el archivo donde esta el config -- donde esta el pdo ndas

//add all ndas in path to ndafiles table in DB
// $files = glob($path . '*');
// foreach ($files as $NDA) {
//   $q3 = "INSERT INTO [displayndas_dev].[dbo].[ndafiles] Filename VALUES"."(".$NDA.")";
//   $mssqlresults = $extra_conn3->query($q3);
//   $mssqlresults = $mssqldb_conn->query($q3);
// }




// to make the folders
// can delete since its not going to be used again
$mssqlresults = $extra_conn3->query($q1);
$mssqlresults = $mssqldb_conn->query($q1);

while($dockets = $mssqlresults->fetch(PDO::FETCH_ASSOC)){
  foreach ($dockets as $docket) {
    if(!file_exists($path.$docket)){
      mkdir($path.$docket);
    }
  }
}

// $directories = glob($path . '*' , GLOB_ONLYDIR); //gets every folder inside the path
// $mssqlresults = $extra_conn3->query($q2);
// $mssqlresults = $mssqldb_conn->query($q2);
//
// $NDAarr = array(); //where the NDAs will be temporarily stored
// while($ndas = $mssqlresults->fetch(PDO::FETCH_ASSOC)){
//   foreach ($ndas as $nda) {
//     array_push($NDAarr, $nda); //give me what's inside of nda's and push it to array
//   }
// }
//
// for ($i=0; $i < count($NDAarr); $i++) {
//   for ($j=0; $j < count($directories); $j++) {
//     if(strpos($NDAarr[$i], basename($directories[$j]))){ //looks for the directory name in the NDA
//       copy($path.$NDAarr[$i],$directories[$j].'\\'.$NDAarr[$i]); //from the parent folder, send them to their docket folder
//     }
//   }
// }

?>
