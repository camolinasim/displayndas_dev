<?php
//run this after mkfolders.php
//it places each file into its respective folder
include("conf_db_mssql_ndas.php");
include("conf.php");
$path = "\\\orspsrvapp02\\webroot2\\NDAs_dev\\";
$q2 = "SELECT Filename FROM [displayndas_dev].[dbo].[ndafiles]";
$extra_conn3 = new PDO($PDO_ndas);


$directories = glob($path . '*' , GLOB_ONLYDIR); //gets every folder inside the path
$mssqlresults = $extra_conn3->query($q2);

$NDAarr = array(); //where the NDAs will be temporarily stored
while($ndas = $mssqlresults->fetch(PDO::FETCH_ASSOC)){
  foreach ($ndas as $nda) {
    array_push($NDAarr, $nda); //give me what's inside of nda's and push it to array
  }
}

for ($i=0; $i < count($NDAarr); $i++) {
  for ($j=0; $j < count($directories); $j++) {
    if(strpos($NDAarr[$i], basename($directories[$j]))){ //looks for the directory name in the NDA
      copy($path.$NDAarr[$i],$directories[$j].'\\'.$NDAarr[$i]); //from the parent folder, send them to their docket folder
    }
  }
}

?>
