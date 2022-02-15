<?php 

require_once("./conf/conf_db_mssql_ndas.php");
require_once("./ms_library.php");
require_once("./conf/conf.php"); 

session_start();

$_SESSION["debug"] = "";

$db_nda = new PDO($PDO_ndas);

global $ndaDB;
$ndaDB = $db_nda;

verify_login(); //check if user is logged in


if (isset($_SESSION['U_AUTHENTICATED'])) {

  //echo "AUTHENTICATED SESSION SET....SETUP APP USER AUTH <br>";
  $_SESSION[$userAuthenticationID_key]   = $userAuthenticationID_val;
  $_SESSION[$userAuthenticationAuth_key]  = $userAuthenticationAuth_val;
  $_SESSION[$userAuthenticationKey_key]   = $userAuthenticationKey_val;
  $_SESSION[$userAuthenticationAdmin_key] = $userAuthenticationAdmin_val;

}

/*
echo "<pre>";
print_r($_SESSION);
echo "</pre>";

exit;
*/

// checkIfAuthenticated();//check if user logged in
if (verify_access()) {
  // $redirect = (isset($_SESSION['REDIRECT'])) ? $_SESSION['REDIRECT'] : 'index.php';  // ?docket='.$_GET['subcontract'];
	// header("Location:$redirect");
  header("Location:index.php");
} else {
	header("Location:login.php?noaccess=true");
}

?>
