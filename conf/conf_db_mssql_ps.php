<?php

//***************************************
// Note (10.31.16)
// All tables defined here are located on orspsrvapp00.utep.edu MS SQL 2005
// Databases: orspdb_dev, orspdb
//
//
//
//***************************************


//*******************************************
//  IT SQL Server - Pull Appointments
//
$server_it   = "ITDVSRSQLN01\NT01";

$database_it = "VPRPeoplesoft";
$username_it = "ORSPBudgetTool";
$userpass_it = "3T3p*r3N1w";

$PDO_peoplesoftdb  = "odbc:DRIVER={ODBC Driver 13 for SQL Server}; Server=$server_it; Database=$database_it; Uid=$username_it; Pwd=$userpass_it;";

//$PDO = "odbc:DRIVER={SQL Native Client}; Server=$server; Database=$database; Uid=$username; Pwd=$userpass;"; 

$ps_db = new PDO($PDO_peoplesoftdb);

//*************************************************
// Define Tables and PHP Var as applicable 
//*************************************************


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
