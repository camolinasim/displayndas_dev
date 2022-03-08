<?php

$path = "\\inetpub\\webroot2\\NDAs_dev\\";
$q1 = "SELECT Docket FROM [displayndas_dev].[dbo].[ndas]";
$q2 = "SELECT Filename FROM [displayndas_dev].[dbo].[ndafiles]";

$extra_conn3 = new PDO($PDO_ndas);

//to make the folders
//can delete since its not going to be used again
// $mssqlresults = $extra_conn3->query($q1);
// $mssqlresults = $mssqldb_conn->query($q1);
//
// while($dockets = $mssqlresults->fetch(PDO::FETCH_ASSOC)){
//   foreach ($dockets as $docket) {
//     if(!file_exists($path.$docket)){
//       mkdir($path.$docket);
//     }
//   }
// }

$directories = glob($path . '*' , GLOB_ONLYDIR); //gets every folder inside the path
$mssqlresults = $extra_conn3->query($q2);
$mssqlresults = $mssqldb_conn->query($q2);

$NDAarr = array(); //where the NDAs will be temporarily stored
while($ndas = $mssqlresults->fetch(PDO::FETCH_ASSOC)){
  foreach ($ndas as $nda) {
    array_push($NDAarr, $nda); //could do lines 31-37 here but readability is better like this
  }
}

for ($i=0; $i < count($NDAarr); $i++) {
  for ($j=0; $j < count($directories); $j++) {
    if(strpos($NDAarr[$i], basename($directories[$j]))){ //looks for the directory name in the NDA
      copy($path.$NDAarr[$i],$directories[$j].'\\'.$NDAarr[$i]); //could be move command instead of copy
    }
  }
}

?>
