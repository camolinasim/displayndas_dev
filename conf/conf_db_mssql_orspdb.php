<?php

//***************************************
// Note (09.27.13)
// All tables defined here are located on orspsrvapp00.utep.edu MS SQL 2005
// Databases: orspdb_dev, orspdb
//
//
//***************************************


//***************************************
// Server configuration
//***************************************

//$driver   = "SQL Server Native Client 10.0";  // Works for IIS 8.5 on Windows Server 2012 R2
// new PDO("odbc:DRIVER={ODBC Driver 13 for SQL Server}; server=ITDVSRSQLT02.utep.edu,58962;Database=Person","FacultyProfiler","pr0f1L3R");
$driver   = "{ODBC Driver 13 for SQL Server}";  // Works for IIS 8.5 on Windows Server 2012 R2
$server   = "ORSPSRVAPP02";

// Configure PDO
$username = "orspdb_dev";
$userpass = "ooo999(((";

$database = "orspdb";

$PDO_mssql_orspdb = "odbc:Driver=$driver; Server=$server; Database=$database; Uid=$username; Pwd=$userpass;";



?>
