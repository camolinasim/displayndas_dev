<?php

    //**************
    // Contact info
  $contact_name  = "Arnold Herrera";
  $contact_email = "aherrera16@utep.edu";
  $contact_phone = "747-7901";

  $contact = "${contact_name} at ${contact_phone} <a href=\"mailto:${contact_email}\" >${contact_email}</a>";


    //**************
    //Notifications

    // List to $CC in all notifications sent out by the application
  $helpDesk_email = "helpdesk@utep.edu";

  $res_email = "research@utep.edu";
  $res_name  = "Research";

  $db_admins = "mcaire@utep.edu aherrera16@utep.edu blekal@utep.edu";
  $db_admins = "aherrera16@utep.edu";

    // Note this is capital CC not lowercase
  $CC        = "research@utep.edu aherrera16@utep.edu";

  $webmaster = "aherrera16@utep.edu";



    //****************
    // Site Meta tags
  $title            = "NDA Display";
  $keywords         = "";
  $favicon          = "";


    //**********************************
    // Obvious Title of the Application
  $app_title        = "NDA Display";


    //**************************************************
    // Session variables that track the logged in user
  $U_NAME  = "U_NAME";
  $U_EMAIL = "U_EMAIL";


    //*************************************************************
    // Configure and start a session
    // Key and value pairs used for $_SESSION based access control
    //
    //  _key is the $_SESSION array key (index)
    //  _val is the $_SESSION array value (element)
    //*************************************************************

    //****************************************************************************************
    // Used to make this session unique so that multiple apps can be open in the same browser
  $session_prefix   = "NDAs";
  
    //***************************************************************************************
    // Change these so that another application doesnt inadvertently give access to this one
  $session_redirect = "${session_prefix}_REDIRECT";


    // As of 04.10.13, Specific value is set by the login processing script
  $userAuthenticationID_key    = "${session_prefix}_ID";
  $userAuthenticationID_val    = "";

    // As of 04.10.13, set by the login processing script to default value
  $userAuthenticationAuth_key  = "${session_prefix}_AUTHENTICATION";
  $userAuthenticationAuth_val  = "AUTHENTICATED";

    // As of 04.10.13, not used
  $userAuthenticationAdmin_key = "${session_prefix}_ACCESS";
  $userAuthenticationAdmin_val = "";         //Access Level - Admin/Edit??

    // As of 04.10.13, set by the login processing script to default value
  $userAuthenticationKey_key   = "${session_prefix}_KEY";
  $userAuthenticationKey_val   = "KEY_VALUE";

  //@session_start();


    //*************************************
    // Generic Absolute Path Configuration
    // Need a way to identify if this is a IIS server and remove the effing DRIVE: part
    // This probably does not work with virtual directories
    // This works only because conf is always one level above the application's root directory
  $http_root = str_replace("D:", "", $_SERVER["DOCUMENT_ROOT"] );
  $http_root = str_replace("\\", "/", $http_root ) . "/";

  $http_server = "orspweb2";
  $http_index  = "index.php";  // Should be a clone of the main application page

  $http_prot   = "https://";
  $http_port   = "";

  $dns_level_2 = "utep.edu";


    // To do (09.03.13)
    //   $app_dir is the only file that needs to be configured/defined
    //   It would be nice to find an automatic php way to extract the directory for this application
    // Update (09.03.13)
    //   The following works on Linux PHP 4
    //   Who knows if it will break the conf script?
    //   It has some quirks when copying code to another directory and trying to access
  $app_dir = str_replace("D:", "", dirname(__FILE__) );
  $app_dir = str_replace("\\", "/", $app_dir );
  $app_dir = str_replace("/conf", "/", $app_dir );
  $app_dir = str_replace($http_root, "", $app_dir );
  $app_dir = str_replace("/", "", $app_dir );

  $app_path = $http_root . $app_dir . "/";


    //*****************************************
    // Generic Functions Should be placed here
  $base_dir      = "base_general";
  $base_path     = $http_root . $base_dir . "/";


    //**********************
    // Third Party Packages

    // Location of DataTables
  $dataTables_dir  = "base_packages/DataTables-1.9.4";
  $dataTables_path = "../" . $dataTables_dir . "/" . "media/css/demo_table_jui.css";


    // Location of Bootstrap
  $bootstrap_dir   = "base_packages/bootstrap-3.1.1-dist/css";
  $bootstrap_path  = "../" . $bootstrap_dir . "/";
  $bootstrap_css   = $bootstrap_path . "bootstrap.min.spacelab.css";
  $app_style_path  = $bootstrap_css;


    // Location of PHPMailer
  $phpMailer_dir   = "base_packages/php_mailer";
  $phpMailer_path  = "../" . $phpMailer_dir . "/";


    //JavaScript
  $bootstrap_js     = "../../base_packages/bootstrap-3.1.1-dist/js/bootstrap.min.js";
  $jquery_js        = "https://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js";


    //*************
    // HTTP Config
  if ($http_port != ":80"){
    $app_url      = "${http_prot}${http_server}.${dns_level_2}${http_port}/${app_dir}/";
    $base_url     = "${http_prot}${http_server}.${dns_level_2}${http_port}/${base_dir}/";
  }
  else{
    $app_url      = "${http_prot}${http_server}.${dns_level_2}/${app_dir}/";
    $base_url     = "${http_prot}${http_server}.${dns_level_2}/${base_dir}/";
  }


    //***********
    //* 03.19.13
    //* There may be a problem that occurs redirecting this to https
    //  The way I have implemented the applications is by using
  $app_home_page       = $app_url . $http_index;  // Delete once changes are cascaded to dependent files (09.03.13)
  $app_home_page_user  = $app_url . $http_index;
  $app_home_page_admin = $app_url . $http_index;


    // Where to direct logins
  $login_page    = "./login.php";


    //******************
    // Request Host URI
 // $request_host_uri = $http_prot . $_SERVER["HTTP_HOST"] . $_SERVER["REQUEST_URI"];


    //****************************************
    // Directory that contains generic images
  $img_dir  = $base_url . "imgs/";
  $icon_dir = $img_dir . "icons/";


    //*****************
    // Download config
  $download_dir   = "downloads";
  $download_path  = "../" . $download_dir;
  $download_url   = "${http_prot}${http_server}.${dns_level_2}${http_port}/${download_dir}";

    //*****************
    // Upload config
  $upload_dir     = "attachments";
  $upload_path    = "./" . $upload_dir;
  $upload_url     = "${http_prot}${http_server}.${dns_level_2}${http_port}/${upload_dir}";


    //*****************
    // Directory permissions used by default when creating directories for upload
  $directory_perms = "0770";

?>
