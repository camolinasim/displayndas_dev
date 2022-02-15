<?php

/*
	AUTHOR: Arnoldo Herrera
	DATE: 4-20-17
	FILENAME: env_var.php
    DESCRIPTION: Sets variables for development environment or production environment
	   This file helps avoid changing environment variables/settings back and forth inside application files

	COMMENTS: ...
	   
*/


///////////////////////////////////////////////////////////
////////////////// DEVELOPMENT ENV ////////////////////////
///////////////////////////////////////////////////////////

//
// PATHS
//

// Local directory base path	
$APP_BASE_PATH = dir("\\\ORSPSRVAPP02\\webroot2\\displayndas_dev");

// Website base path
$WEB_BASE_PATH = 'http://orspweb2.utep.edu/displayndas_dev/';

// Milestones Documents path
$SUBK_DOCS_BASE_PATH = "\\\ORSPSRVAPP02\\webroot2\\displayndas_dev\\docs";

// Milestones Documents path
$SUBK_DOCS_WEB_BASE_PATH = "https://orspweb2.utep.edu/displayndas_dev/docs/";

// Blank for Production Only
$SERVER_TEST_MSG = "::TEST::";


?>