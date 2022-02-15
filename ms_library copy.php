<?php

/*
@author:jycabrera@miners.utep.edu
@date: 7.23.14
@last updated:8.11.14
This function returns the result template displayed in the index page!
the data is composed of all the fields entered for the specific subcontract

Reference:
http://www.rubular.com/r/XzVf1NQtjX   (Regexp editor)
http://stackoverflow.com/questions/12077177/how-does-recursiveiteratoriterator-work-in-php  (Recursive iterator directories)
*/


//require_once("./conf/conf_db_access_subcontracts.php");
require_once("./conf/conf_db_mssql_ps.php");
require_once("./conf/conf_db_mssql_ndas.php");
// Environment specific
require_once("./conf/env_var.php");


//
// Single Sign-On verify login
function verify_login()
{

  if (isset($_COOKIE['UTEP_SE']) && isset($_COOKIE['UTEP_SA'])) {

    $_SESSION["debug"] .= "<br> Setup cookies...";

    // echo "cookie utep_se is {$_COOKIE['UTEP_SE']}";
    $session = $_COOKIE['UTEP_SE'];//cookie contains the session
    $salt    = $_COOKIE['UTEP_SA'];//cookie contains the salt
    $client  = new SoapClient('http://websvs.utep.edu/databaseservices/public/externalsignon.asmx?WSDL');

    // var_dump($client);
    // var_dump($client->__getFunctions()); //uncomment to view functions available
    //parameters for the GetUserBySSIU function notice that two last params must be empty string
    $parameters = (object) array (
      'sessionId' => $session,
      'salt' => $salt,
      '' => '',
      '' => '',
    );

    $result = $client->GetUserBySSIU($parameters);//calling soap server function
    $user   = $result->GetUserBySSIUResult;//getting the response from server
    set_sessions($user);//setting the session variables can modify this to suit your needs

    /**
    * The cookie is not set
    * -> redirect to sso page for the user to log in
    */

  } else {

     $_SESSION["debug"] .= "<br> SSO redirect...";

    // current page for redirect back from sso page
    $uri        = 'https://'. $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];
    $uriEncoded = urlencode($uri);
    header('Location: https://adminapps.utep.edu/sso/default.aspx?redirectURL=' . $uriEncoded);//new sso page
    exit;

  }
}


//
// verifies user is in access table!
function verify_access()
{

  global $ndaDB; // Use global DB variable
  $username = "";

  if (!isset($_SESSION['U_NAME'])) {

    $_SESSION["debug"] .= "<br> AUTHENTICATED || EMAIL not set...";
    header("Location:login.php");
    exit;

  } else {

    $_SESSION["debug"] .= "<br> AUTHENTICATED || EMAIL IS SET...";

    // echo "Username: {$_SESSION['U_NAME']}";

    // Update query to correct access table!
    // $query = "SELECT Username 
    //           FROM dbo.PeopleWhoCanAccess 
    //           WHERE Username = '{$_SESSION['U_NAME']}'";
    $query = "SELECT Username 
              FROM dbo.PeopleWhoCanAccess 
              ";
    $query_result = $ndaDB->query($query);

    // $username = $query_result;
    // echo $username;
    $row = $query_result->fetchAll(PDO::FETCH_ASSOC);

    // $username = "";
    // $isEdit   = false;

    // if ($query_result) {
        foreach ($row as $user_info) {
          $username = $user_info['Username'];

          if ($username == $_SESSION["U_NAME"]){
            break;
          }


      // }

    //   echo "In query result <br>";

    //   $_SESSION["debug"] .= "<br> IN QUERY RESULT...";

    //   $row = $query_result->fetchAll(PDO::FETCH_ASSOC);

    //   foreach ($row as $user_info) {
    //     $username = $user_info['Username'];

    //     echo $username;
    //     // $access   = $user_info['edit'];  //"edit" field set to True(1) or False(0)

    //     // if ($access == true) {
    //     //   $isEdit = true;
    //     // }
    // }
  }



      // if ($isEdit == true) {
      //   $_SESSION['EDIT'] = "true";
      // } else {
      //   $_SESSION['EDIT'] = "false";
      // }

  // } else {

  //     $_SESSION["debug"] .= "<br> NO QUERY RESULT...";

  //     // CHOOSE 1(RESTRICTED) or 2(ALL UTEP LOGINS)

  //     // 1) **Uncomment** below if access is restricted to users in the access table 
  //     header('Location: ./login.php');
  //     exit;

  //     // 2) **Uncomment** below if access is not restricted to all UTEP users
  //     //$_SESSION['EDIT'] = "false";

  //   }

    // CHOOSE 1(RESTRICTED) or 2(ALL UTEP LOGINS)
    
    // 1) **Uncomment** below if access is restricted to users in the access table

    //echo "Username ". $username. "<br>";

    // $_SESSION["debug"] .= "<br> IN QUERY...". $username;
    //exit;

  }

    echo $username . "==" . $_SESSION["U_NAME"];
    if ($username == $_SESSION["U_NAME"]) {
      return true;
    } else {
      return false;
    }
    
    // 2) **Uncomment** below if access is not restricted to all UTEP users
    //return true;


  }


//
// This functions set some session variiables used throught the website
//   used by verify_login()
function set_sessions($user)
{
  $_SESSION['U_NAME']          = $user->UserName;
  $_SESSION['U_EMAIL']         = $user->EmailAddress;
  $_SESSION['U_AUTHENTICATED'] = $user->Authenticated;
  $_SESSION['ERROR']           = "No";
  $_SESSION['ERROR_MSG']       = "";

}


//
//checks if user is authenticated
function checkIfAuthenticated()
{

  $current_page = $_SERVER['PHP_SELF'];

  if (isset($_SESSION['EDIT'])) {
    if ($_SESSION['EDIT'] == "false" && $current_page != "/displayndas_dev/index.php") {
      header("Location:index.php");
    }
  } else {
    header("Location:login.php");
  }

}


//
// converts an excel time to php time */
function excel_to_php_time($excel)
{
  //this number should be numeric
  if (!is_numeric($excel)) {
    return null;
  } else {
    return date("m/d/Y",($excel - 25568)* 86400);
  }
}


//
//parse a mssql date into a php rformat
function parse_date($date)
{
  //
  if ($date == NULL || $date == "") {
    return "";
  } else {
    return date('m-d-Y',strtotime($date));
  }
}


//
//
function sanitize_json($string)
{
  $illegal_chars= array("–","_","$",".","-","\x96","'","\x92");
  // $temp= str_replace($illegal_chars,"",$string);
  return  str_replace($illegal_chars, "", $string);
}


//
// Issue with inserting singe quotes in mssql server
//   this will help!   ex.   O'dell  -->  O''dell
function mssql_escape($str)
{
   if (get_magic_quotes_gpc()) {
    $str = stripslashes($str);
   }
   return str_replace("'", "''", $str);
}


?>
