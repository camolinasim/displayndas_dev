<?php
//this script was created to organize the following path: \\orspsrvapp02\webroot2\NDAs_dev
//it used to have no folders: only 1000+ pdfs. This script creates a folder for each nda
//run move_files_into_folders.php after running this script. 

//delete
function println($data) {
$console = $data;
if (is_array($console))
$console = implode(',', $console);

echo "<script>console.log('Console: " . $console . "' );</script>";
}

include("conf_db_mssql_ndas.php");
$path = "\\\orspsrvapp02\\webroot2\\NDAs_dev\\";
$q1 = "SELECT Docket FROM [displayndas_dev].[dbo].[ndas]";
$q2 = "SELECT Filename FROM [displayndas_dev].[dbo].[ndafiles]";
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
//$mssqlresults = $mssqldb_conn->query($q1);

while($dockets = $mssqlresults->fetch(PDO::FETCH_ASSOC)){
   // echo("inside while");
  //println($mssqlresults);
  foreach ($dockets as $docket) {
    // echo($docket);
    //echo($path.$docket);

    if(!file_exists($path.$docket)){
      echo("trying to create the following folder: ".$path.$docket);
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
