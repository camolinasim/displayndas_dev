<?php

//***************************************
// Note (09.27.13)
// All tables defined here are located on orspsrvapp00.utep.edu MS SQL 2005
// Databases: orspdb_dev, orspdb
//
//
//
//***************************************


//***************************************
// Server configuration
//***************************************

// $driver   = "SQL Server Native Client 10.0";
$driver   = "{ODBC Driver 13 for SQL Server}";

$server   = "ORSPSRVAPP02";

$username = "scdb";
$userpass = "m01sc!15";

// Configure a PDO to orspdb_dev
$database = "subcontracts";

$PDO_orspdb = "odbc:DRIVER={$driver}; Server=$server; Database=$database; Uid=$username; Pwd=$userpass;";


//*************************************************
// Define Tables and PHP Var as applicable 
//*************************************************

//*************************
// TABLE NAME: transmittal
// Note: Always ensure this file is sync'ed with mssql_lx_conf.php on orspprofile.utep.edu
//*************************
//$transmittal_table = "transmittal_test"; // The Development Transmittal Database Table
$orsp_db_table = "dbo.ORSPDatabase";
// $gm_proposal_table     = "GM_PROPOSAL";      
// $gm_prop_proj_table    = "GM_PROP_PROJ";
// $gm_prop_prof_table    = "GM_PROP_PROF";
// $gm_bud_hdr_table      = "GM_BUD_HDR";
// $gm_bud_fa_hdr_table   = "GM_BUD_FA_HDR";
// $gm_bud_fa_rate_table  = "GM_BUD_FA_RATE";
// $gm_bud_period_table   = "GM_BUD_PERIOD";
// $gm_bud_cs_sumin_table = "GM_BUD_CS_SUMIN";
// $gm_bud_line_dtl_table = "GM_BUD_LINE_DTL";
// $gm_bud_line_sum_table = "GM_BUD_LINE_SUM";

?>
