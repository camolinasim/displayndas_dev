<?php


try{   
	$driver   = "SQL Server Native Client 11.0";  // Works for IIS 8.5 on Windows Server 2012 R2
	$server   = "ORSPSRVAPP04";
	$username = "orspdb_dev";
	$userpass = "ooo999(((";
	$database = "orspdb";


  $PDO_mssql_srvapp04 = "odbc:DRIVER={$driver}; Server=$server; Database=$database; Uid=$username; Pwd=$userpass;";
  $PDO_srvapp04 = new PDO($PDO_mssql_srvapp04);
}
catch(PDOException $e) {
    //echo $e->getMessage();
    $PDO_srvapp04 = null;
}


?>
