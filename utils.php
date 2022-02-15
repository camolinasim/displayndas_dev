<?php

//error_reporting(E_ERROR);
error_reporting(E_ALL);
ini_set('display_errors', 1);

$_authentication		=	"LDAP";

//if ($_SERVER['HTTP_HOST'] != 'localhost')
//{
  /*$_db_server				=	"orspprofile.utep.edu"; // database server name
  $_db_name				=	"profilesystem"; // database name
  $_db_username			=	"researchadmin"; // database user name
  $_db_password			=	"9p6s!x2"; // database password*/
  $_db_server				=	"orspsrvapp03.utep.edu"; // database server name
  $_db_name				=	"profilesystem"; // database name
  $_db_username			=	"researchadmin"; // database user name
  $_db_password			=	"9p6s!x2"; // database password
/*}
else
{
  $_db_server				=	"localhost"; // database server name
  $_db_name				=	"profilesystem"; // database name
  $_db_username			=	"root"; // database user name
  $_db_password			=	""; // database password
}*/

// Code modified because the database password was changed.
// Modified on 1/29/201
//$_db_password			=	"r12&sta$"; // database password
/*******/
$_home					=	"/profilesystem"; //home directory of the web site

$_ldap_server			=	"ldap.utep.edu"; // ldap server name
$_ldap_dn				=	"uid=ids-read, ou=Special Users, dc=utep, dc=edu"; // ldap dn - oouidoo will be replaced by uid
//$_ldap_global_dn 		=	"cn=real,cn=applications,dc=utep,dc=edu";
$_ldap_global_dn              =       "uid=ids-read, ou=Special Users, dc=utep, dc=edu";
$_ldap_global_passwd	=	"tyH4#aN;)'*6zK"; // your ldap password
$_ldap_search_dn	=	"ou=People, dc=utep, dc=edu";
$_ldap_search_dn_ppl	=	"ou=People, dc=utep, dc=edu";
//$_ldap_search_dn_acct	=	"ou=Accounts, dc=utep, dc=edu";
//$_ldap_search_dn_dept	=	"ou=Departments, dc=utep, dc=edu";

//$_ldap_search_filter	=	"AccountName=ids-read";
$_ldap_attr_lname		=	"sn";
$_ldap_attr_fname		=	"givenname";
$_ldap_attr_email		=	"mail";

$_index_page			=	"index.php"; // fully qualified url to index page to be redirected after logoff
//$_err_page				= 	$_home . "/errorpage.php"; // error page to be redirected after any error
$_err_page				= 	"reporterror.php"; // error page to be redirected after any error

$_session_time_out		=	60; // session time out in minutes

$_err_code				=	-1; // variable to hold the recent error code
$_err_msg				=	"";
$_err_info				=	"";

// error codes
$_err_fatal				=	0; 
$_err_ldap_connect		=	1;
$_err_db_connect		=	2;
$_err_db_select			=	3;
$_err_uid_null			=	4;
$_err_uid_not_found		=	5;
$_err_login				=	6;
$_err_session			=	7;
$_err_page_not_found	=	8;
$_err_unauthorized   	=   9;
$_err_bs   	=   10;

$contact_admin = " If you would like to report this to the administrator <a href='http://www.uta.edu/testrsp/profilesystem/feedback.php'>click here</a>.";
$go_back = " <a href='javascript:history.back()'>Click here</a> to go back.";
$go_home = " <a href='$_index_page'>Click here</a> to login again.";
// error messages
$_errors[$_err_fatal]				=	"Fatal Error" . $contact_admin;
$_errors[$_err_ldap_connect]		=	"The LDAP server could not be connected to." . $contact_admin;
$_errors[$_err_db_connect]			=	"The database server could not be connected.". $contact_admin;
$_errors[$_err_db_select]			=	"The organization database could not be found.". $contact_admin;
$_errors[$_err_uid_null]			=	"The user id should not be empty." . $go_back;
$_errors[$_err_uid_not_found]		=	"The user id could not be found in the system." . $go_back;
$_errors[$_err_login]				=	"Invalid user id or password." . $go_home;
$_errors[$_err_session]				=	"The current session has expired." . $go_home;
$_errors[$_err_unauthorized]               =        "You are unauthorized to view this page." . $go_home;
$_errors[$_err_page_not_found]		=	"The requested page is not found." . $go_back;
$_errors[$_err_bs] = "We encountered an error while auto saving bluesheet. Please notify erahelpdesk@uta.edu and we will fix this for you.";

$_filter_tags = array("script");
$_login_id = "Net ID";
$_browse_search_rows_per_page = 10;
/***************************************************************************************
function: real_mysql_specialchars
description: prepends \ to ', ", \, and other mysql special characters
params: 
	$value - string to be changed
	$bnumberic - true if the $value is numeric
returns: string with escaped mysql special characters
****************************************************************************************/
function real_mysql_specialchars( $value, $bnumeric, $db_conn )
{
   if (get_magic_quotes_gpc()) {
       $value = stripslashes($value);
   }

	//$value1 = mysql_real_escape_string( $value);
	$value1 = $db_conn->quote($value);
	if ($bnumeric == false) 
	{
      	//$value1 = "'" . trim($value1) . "'";
	}
	else
	{
		if( is_numeric( $value1 ) == false )
			$value1 = 0;
	}
	return $value1;
}

/***************************************************************************************
function: real_rte_specialchars
description: escapes single quotes, double quotes, returns and line feeds
params: 
	$value - string to be changed
returns: string with escaped mysql special characters
****************************************************************************************/
function real_rte_specialchars( $value )
{
	$tmpString = $value;
	
	//convert all types of single quotes
	$tmpString = str_replace(chr(145), chr(39), $tmpString);
	$tmpString = str_replace(chr(146), chr(39), $tmpString);
	$tmpString = str_replace("'", "&#39;", $tmpString);
	
	//convert all types of double quotes
	$tmpString = str_replace(chr(147), chr(34), $tmpString);
	$tmpString = str_replace(chr(148), chr(34), $tmpString);
	
	//replace carriage returns & line feeds
	$tmpString = str_replace(chr(10), " ", $tmpString);
	$tmpString = str_replace(chr(13), " ", $tmpString);

	
	return $tmpString;
}

/***************************************************************************************
function: real_unescape
description: strips the slashes prepended to ', ", and \
params:	$value - string to be changed
returns: string with unescaped special characters
****************************************************************************************/
function real_unescape( $value )
{
	if (get_magic_quotes_gpc()) 
	{
    	$value = stripslashes($value);
	}
	return $value;
}

/***************************************************************************************
function: real_log_error
description: logs the error in the gen_error_log table. 
params: 
	$db_conn - database link
	$message - error message maximum of 255 characters
	$info - additional information like query
returns: nothing
on error: redirects to the error page
****************************************************************************************/
function real_log_error( $db_conn, $message, $info )
{
	global $_err_msg, $_err_info;
	$err_query = "INSERT INTO gen_error_log ( message, info, datetime, login_id ) VALUES ".
					" ( ". real_mysql_specialchars( substr( $message, 0, 255 ), false ).
					", " . real_mysql_specialchars( $info, false ).
					", NOW(), '" . $_SESSION['UID'] . "' )";
	mysql_query( $err_query, $db_conn );
	$_err_msg = $message;
	$_err_info = $info;
}

/***************************************************************************************
function : real_check_error
description: checks for error in the recent function call
params: nothing
returns: true if error
****************************************************************************************/
function real_check_error()
{
	if( $_SESSION['err_code'] == -1 )
		return false;
	else
		return true;
}

/***************************************************************************************
function: real_error
description: gets the error message for the specified error code
params:	$err_code - error code for the error
returns: string corresponding to the error code
****************************************************************************************/
function real_error( $err_code )
{
	global $_errors;
	return $_errors[ $err_code ];
}

/***************************************************************************************
function: real_set_error
description: sets the error code for the recent error 
params: $err_code - error code of the recent error
returns: nothing
****************************************************************************************/
function real_set_error( $err_code )
{
  //$_SESSION['err_code'] = $err_code;
  session_start();
  $_SESSION['err_code'] = $err_code;
  //session_start();
  $old_sessid = session_id();
  session_regenerate_id();
  $new_sessid = session_id();
  session_id($old_sessid);
  session_destroy();

  $old_session = $_SESSION;
  session_id($new_sessid);
  session_start();
  $_SESSION = $old_session;
}
/***************************************************************************************
function: real_get_error
description: gets the error code for the recent error and sets default error if not set 
params: none
returns: nothing
****************************************************************************************/
function real_get_error()
{
	global $_err_fatal;
	
	if(!isset($_SESSION['err_code']))
	{
		real_set_error( $_err_fatal );
	}
	
	return $_SESSION['err_code'];
}
/***************************************************************************************
function: real_reset_error
description: resets the error code to -1
params: nothing
returns: nothing
****************************************************************************************/
function real_reset_error()
{
	$_SESSION['err_code'] = -1;

}

/***************************************************************************************
function: real_db_connect
description: connects the specified database
params:
	$dbserver - database server name
	$dbusername - database user name
	$dbpassword - database password
	$dbname - database name
returns: database link
on error: redirects to the error page
****************************************************************************************/
function real_db_connect($dbserver, $dbusername, $dbpassword, $dbname)
{
	global $_err_db_connect;
	global $_err_page;
	real_reset_error();
	/*echo $dbserver; echo "\n";echo $dbusername; echo "\n";echo $dbpassword; echo "\n";*/
        //if ($_SERVER['HTTP_HOST'] != 'localhost')
        //{
	  /*$db_conn = mysql_connect( $dbserver, $dbusername, $dbpassword );
          if (!$db_conn) {
            die(__FILE__.":".__LINE__.' Could not connect: ' . mysql_error());
	  }*/	
        //}
        //else
	//{	
	  $db_conn = new PDO('mysql:host='.$dbserver.';dbname='.$dbname, $dbusername, $dbpassword);
	//}
	if( ! $db_conn )
	{
		real_set_error( $_err_db_connect );
		real_redirect_onerror( $_err_page, "", $db_conn); 
	}
	else
	{
		//if ($_SERVER['HTTP_HOST'] != 'localhost')
                //{
		  /*$db_select = mysql_select_db( $dbname, $db_conn );
		  if( ! $db_select )
		  {
		  	  real_set_error( $_err_db_connect );
			  real_redirect_onerror( $_err_page, "", $db_conn);
		  }*/
		//}
	}

//	$query = "SET names 'utf8'";
//	real_execute_query( $query, $db_conn );
//	$query = "SET character_set_connection='utf8'";
//	real_execute_query( $query, $db_conn );
//	$query = "SET collation_connection='utf8_general_ci'";
//	real_execute_query( $query, $db_conn );
	
	return $db_conn;
}


/***************************************************************************************
function: real_execute_query
description: executes the specified query with the specified link
params: 
	$query - query to be executed
	$db_conn - database link
returns: results of the query
on error: logs the error message and redirects to the error page
****************************************************************************************/
function real_execute_query( $query, $db_conn, $DBType )
{
	global $_err_fatal;
	global $_err_page;
	real_reset_error();
        //echo "u10,";
  
	//$result = mysql_query( $query, $db_conn );
	$result = execute_query( $query, $db_conn, $DBType );
        //echo "u11,";
        
	//$error_msg = mysql_error( $db_conn ) ;
	$error_msg = $db_conn->errorInfo();
	$error_msg = $error_msg[2];
        //echo $error_msg;
        //echo "u12,";
        
	if( $error_msg != "" )
	{
	  //echo "u14,";
	        
		real_log_error( $db_conn, $error_msg, $query );
                //echo "u15,";
		
		real_set_error( $_err_fatal );
                //echo "u16,";
		
		real_redirect_onerror( $_err_page, "", $db_conn);
                //echo "u17,";
		
	}
        //echo "u13,";
       
	return $result;
}

function real_execute_bs_query( $query, $db_conn )
{
	global $_err_fatal;
	global $_err_page;
	real_reset_error();
	$result = mysql_query( $query, $db_conn );
	$error_msg = mysql_error( $db_conn ) ;
	if( $error_msg != "" )
	{
		real_log_error( $db_conn, $error_msg, $query );
		real_set_error( $_err_bs );
		real_redirect_onerror( $_err_page, "", $db_conn);
	}
	return $result;
}

/***************************************************************************************
function: real_prune_old_sessions
description: deletes all old sessions which are older than $_session_time_out value
params: $db_conn - database link
returns: nothing
on error: redirects to the error page
****************************************************************************************/
function real_prune_old_sessions( $db_conn )
{
  //echo "u5,";
        
	global $_session_time_out;
	//echo "u6,";
        
        real_reset_error();
	//echo "u7,";
        
        $query = "DELETE FROM gen_login_session WHERE ADDDATE( datetime, INTERVAL $_session_time_out MINUTE ) < NOW()";
	//echo "u8,";
        
        $result = real_execute_query( $query, $db_conn, 'mysql' );
        //echo "u9,";
   
}

/***************************************************************************************
function: real_check_valid_session
description: checks if the specified session is valid and updates the timestamp if valid
params:
	$db_conn - database link
	$uid - user login id
	$sessionid - session id
	$remoteip - ipaddress of the user
returns: nothing
on error: redirects to the error page even if the session is invalid
****************************************************************************************/
function real_check_valid_session( $db_conn, $uid, $sessionid, $remoteip )
{
	global $_err_session;
	global $_err_page;
	real_reset_error();
	real_prune_old_sessions( $db_conn );
	$query = " SELECT session_id, remote_ip, datetime FROM gen_login_session".
					" WHERE login_id = " . real_mysql_specialchars( $uid, false, $db_conn ).
					" AND session_id = " . real_mysql_specialchars( $sessionid, false, $db_conn ).
					" AND remote_ip = " . real_mysql_specialchars( $remoteip, false, $db_conn );
	$result = real_execute_query( $query, $db_conn, 'mysql' );
	//if( mysql_num_rows( $result ) == 0 )
	if( db_num_rows( $result ) == 0 )
	{
                session_destroy();
                session_start();
		real_set_error( $_err_session );
		//session_destroy();
		real_redirect_onerror( $_err_page, "", $db_conn);
	}
	else
	{
		$query = " UPDATE gen_login_session SET datetime = NOW() ".
					" WHERE login_id = " . real_mysql_specialchars( $uid, false, $db_conn ).
					" AND session_id = " . real_mysql_specialchars( $sessionid, false, $db_conn ).
					" AND remote_ip = " . real_mysql_specialchars( $remoteip, false, $db_conn );
		$result = real_execute_query( $query, $db_conn, 'mysql' );
	}
}


/***************************************************************************************
function: real_update_valid_session
description: updates the session timestamp if the specified session is valid
params:
	$db_conn - database link
	$uid - user login id
	$sessionid - session id
	$remoteip - ipaddress of the user
returns: nothing
on error: redirects to the error page even if the session is invalid
****************************************************************************************/
function real_update_valid_session( $db_conn, $uid, $sessionid, $remoteip )
{
  //echo "u1,";

        global $_err_session;
	global $_err_page;
	real_reset_error();

        //echo "u4,";
        
        real_prune_old_sessions( $db_conn );
        
        //echo "u3,";
         

	$query = " SELECT session_id, remote_ip, datetime FROM gen_login_session".
					" WHERE login_id = " . real_mysql_specialchars( $uid, false ).
					" AND session_id = " . real_mysql_specialchars( $sessionid, false ).
					" AND remote_ip = " . real_mysql_specialchars( $remoteip, false );
					
	$result = real_execute_query( $query, $db_conn );
	if( mysql_num_rows( $result ) > 0 )
	{
		$query = " UPDATE gen_login_session SET datetime = NOW() ".
					" WHERE login_id = " . real_mysql_specialchars( $uid, false ).
					" AND session_id = " . real_mysql_specialchars( $sessionid, false ).
					" AND remote_ip = " . real_mysql_specialchars( $remoteip, false );
		$result = real_execute_query( $query, $db_conn );
	}
}

/***************************************************************************************
function: real_check_session
description: checks if the user has a session entry
params:
	$db_conn - database link
	$uid - user login id
returns: true if the user has an entry in the gen_login_session table
****************************************************************************************/
function real_check_session( $db_conn, $uid )
{
	real_reset_error();
	$query = " SELECT session_id, remote_ip, datetime FROM gen_login_session".
					" WHERE login_id = " . real_mysql_specialchars( $uid, false, $db_conn );
					
	$result = real_execute_query( $query, $db_conn, 'mysql');
	//if( mysql_num_rows( $result ) > 0 )
	if( db_num_rows( $result ) > 0 )
		return true;
	else
		return false;
}


/***************************************************************************************
function: real_login_session
description: logs the session info in gen_login_session table during login. updates the
				existing session (relogin before the current session expires or logoff)
				or adds a new session
params:
	$db_conn - database link
	$uid - user login id
	$sessionid - current session id
	$remoteip = remote ip address
returns: true 
on error : redirects to error page
****************************************************************************************/
function real_login_session( $db_conn, $uid, $sessionid, $remoteip )
{
	$query = "";
	real_reset_error();
	$exists = real_check_session( $db_conn, $uid );
	if( $exists == true )
	{
		$query = "UPDATE gen_login_session SET" .
					" session_id = " . real_mysql_specialchars( $sessionid, false, $db_conn ).
					", remote_ip = " . real_mysql_specialchars( $remoteip, false, $db_conn ).
					", datetime = NOW() ".
					" WHERE login_id = " . real_mysql_specialchars( $uid, false, $db_conn );
	}
	else
	{
		$query = "INSERT INTO gen_login_session (login_id, session_id, remote_ip, datetime) VALUES". 
					" ( ". real_mysql_specialchars( $uid, false, $db_conn ).
					", " . real_mysql_specialchars( $sessionid, false, $db_conn ).
					", " . real_mysql_specialchars( $remoteip, false, $db_conn ).
					", NOW() )";
	}
	$result = real_execute_query( $query, $db_conn,'mysql' );
	//if( mysql_affected_rows( $db_conn ) > 0 )
	if( db_num_rows( $result ) > 0 )
		return true;
	else
		return false;
}

/***************************************************************************************
function: real_logoff_session
description: deletes the session for the specified login id
params:
	$db_conn - database link
	$uid - user login id
returns: nothing
on error: redirects to error page
****************************************************************************************/
function real_logoff_session( $db_conn, $uid )
{
	real_reset_error();
	$query = "DELETE FROM gen_login_session WHERE login_id = " . real_mysql_specialchars( $uid, false );
	$result = real_execute_query( $query, $db_conn );
	session_destroy();
}

/***************************************************************************************
function: real_redirect
description: redirects to the specififed page
params:
	$page - page to be redirected
	$querystring - querystring to be appended
	$db_conn - database link to be closed
returns: nothing
****************************************************************************************/
function real_redirect( $page, $querystring, $db_conn )
{

	$redirect = "Location: $page";
	if( $querystring != "" )
	{
		$redirect = "$redirect?$querystring";
	}
	header( $redirect ); 
	if( $db_conn != NULL )
		mysql_close( $db_conn );
	exit();
}

/***************************************************************************************
function: real_redirect_onerror
description: redirects to the specified page with the error code
params:
	$page - page to be redirected
	$querystring - query string to be appended
	$db_conn - database link to be closed
returns: nothing
****************************************************************************************/
/*
function real_redirect_onerror( $page, $querystring, $db_conn )
{
	global $_err_code;
        //echo "u19,";
	
	$redirect = "Location: $page?$querystring&err_code=$_err_code";
        //echo "u20,";
	//echo "redirect = ";
	//echo $redirect;
        //exit();

	header( $redirect );
        //echo "u18,";
	
	if( $db_conn != NULL )
		mysql_close( $db_conn );
	exit();
}
*/

/***************************************************************************************
function: real_redirect_onerror
description: redirects to the specified page with the error code
params:
	$page - page to be redirected
	$querystring - query string to be appended
	$db_conn - database link to be closed
returns: nothing
****************************************************************************************/
function real_redirect_onerror( $page, $querystring, $db_conn )
{
  /*print_r($_SESSION);echo "<script type=\"text/javascript\">
setTimeout(function() {window.location='errorpage.php';},5000);
</script>";*/
	//global $_err_code;
	$redirect = "Location: $page?$querystring";
        //echo $redirect;exit;
	header( $redirect ); 
	if( $db_conn != NULL )
		mysql_close( $db_conn );
	exit();
}

/***************************************************************************************
function: real_can_user_edit
description: checks whether the logged in user has edit permissions for the profile
params: 
	$db_conn - database link
	$pid - profile id	
returns: true if the user has edit rights, else false
on error: logs the error message and redirects to the error page
****************************************************************************************/
function real_can_user_edit( $db_conn, $pid )
{

	if( $_SESSION["UID"] == "" )
		return false;
	if( real_check_user_groupid( $db_conn, "admin" ) )
		return true;

	$profile_exists_query = "SELECT owner_login_id, user1_login_id, user2_login_id, type_id FROM gen_profile_info WHERE pid = " . real_mysql_specialchars( $pid, true );
	$profile_exists_results = real_execute_query ( $profile_exists_query, $db_conn );
	if( mysql_num_rows($profile_exists_results) > 0 )
	{
		$rows = mysql_fetch_row( $profile_exists_results );
		if( $rows[3] == 3 && real_check_user_groupid( $db_conn, "tech_admin" ) )
		{
			return true;
		}
		if( strcasecmp( $rows[0], $_SESSION["UID"] ) == 0 ||
				strcasecmp( $rows[1], $_SESSION["UID"] ) == 0 ||
				strcasecmp( $rows[2], $_SESSION["UID"] ) == 0 )
		{
			return true;
		}
	}
	return false;
}

/***************************************************************************************
function: real_check_user_groupid
description: checks whether the logged in user belongs to the specified group
params: 
	$db_conn - database link
	$grpid - group id	
returns: true if the user belongs to the specified group, else false
on error: logs the error message and redirects to the error page
****************************************************************************************/
function real_check_user_groupid( $db_conn, $grpid )
{
	if( $_SESSION["UID"] == "" )
		return false;
	$grpid_query = "SELECT login_id FROM gen_admin_info WHERE type = " . real_mysql_specialchars( $grpid, false, $db_conn ) . " AND login_id = " . real_mysql_specialchars( $_SESSION["UID"], false, $db_conn );
	$grpid_results = real_execute_query ( $grpid_query, $db_conn, 'mysql' );
	//if( mysql_num_rows($grpid_results) > 0 )
	if( db_num_rows($grpid_results) > 0 )
	{
		return true;
	}
	else
	{
		return false;
	}
}

/***************************************************************************************
function: real_update_last_modified_timestamp
description: checks whether the logged in user belongs to the specified group
params: 
	$db_conn - database link
	$pid - profile id	
returns: updates the last modified time stamp and the login id of the user
on error: logs the error message and redirects to the error page
****************************************************************************************/
function real_update_last_modified_timestamp( $db_conn, $pid )
{
	$user_query = "SELECT owner_login_id, user1_login_id, user2_login_id, type_id FROM gen_profile_info WHERE pid = " . real_mysql_specialchars( $pid, true ) ;
	$user_results = real_execute_query ( $user_query, $db_conn );
	$user_rows = mysql_fetch_array( $user_results );
	$user_id = $_SESSION["UID"];
	$field = $user_id == $user_rows[2] ? "user2_datetime" : "";
	$field = $user_id == $user_rows[1] ? "user1_datetime" : "";
	$field = $user_id == $user_rows[0] ? "owner_datetime" : "";
	if( $field == "" && ( real_check_user_groupid( $db_conn, "admin" ) || ( real_check_user_groupid( $db_conn, "tech_admin" ) && $user_rows[3] == 3 ) ) )
		$field = "admin_datetime";
	if( $field != "" )
	{
		$update_query = "UPDATE gen_profile_info SET last_modifier = " . real_mysql_specialchars( $user_id, false ) . ", " . $field . " = NOW() WHERE pid = " . real_mysql_specialchars( $pid, true ) ;
		$update_results = real_execute_query ( $update_query, $db_conn );
	}
}
////////////////////////////////////////////////////////
////////////////////////////////////////////////////////
////////////////////////////////////////////////////////
////////////////////////////////////////////////////////
////////////////////////////////////////////////////////
////////////////////////////////////////////////////////
////////////////////////////////////////////////////////
////////////////////////////////////////////////////////
function real_check_dept_admin($db_conn)
{
	$query = "SELECT * from gen_dept_admin where loginid = '" . $_SESSION['UID'] . "'";
	//echo $query;
	//exit;
	//$results = mysql_query($query, $db_conn) or die("0 - " . mysql_error());
	$results = real_execute_query($query, $db_conn);
	if (mysql_num_rows($results) > 0)
	{
		if($rows = mysql_fetch_array($results))
		{
			return $rows["hid"];
		}
	}
	return false;
}

function isOGCSAdmin($db_conn, $l_id)
{
	$query = "SELECT * from gen_admin_info where type='ogcs_admin' AND login_id = '" . $l_id . "'";
	//$results = mysql_query($query, $db_conn) or die("0 - " . mysql_error());
	$results = real_execute_query($query, $db_conn);
	if (mysql_num_rows($results) > 0)
	{
		return true;
	}
	return false;
}

function isOGCSSuperAdmin($l_id)
{
	if (($l_id == "000000010")/* VP Research */ || ($l_id == "000000011") /* OGCS Director */)
	{
		return true;
	}
	return false;
}
//echo "u2,";


/***************************************************************************************
function:simpleLDAPQuery
description:Simplifies LDAP query
params: 
String $base_dn ->the dn on which to perform LDAP search, ex: "cn=People,dc=uta,dc=edu"
String $filter ->LDAP search filter, ex: "(utaid=100012345)" or "(&(sn=McDon*)(givenname=Bill))"
Array $attributes->(Optional) the attributes to return from the search, ex: array("sn", "utaemployeetitle")
returns: the array returned by PHP's ldap_get_entries function
on error: returns false
****************************************************************************************/
function simpleLDAPQuery($base_dn, $filter, $attributes=array("*"))
{
  global $_ldap_server;
  global $_ldap_global_dn;
  global $_ldap_global_passwd;
  
  // connect to ldap server
  $ldapconn = ldap_connect("ldaps://" . $_ldap_server);
  
  if ($ldapconn) {
    // binding to ldap server
    $ldapbind = ldap_bind($ldapconn, $_ldap_global_dn, $_ldap_global_passwd);
    
    // verify binding
    if ($ldapbind) {
      $sizeLimit = 0;
      $timeLimit = 5;
      $read = ldap_search($ldapconn, $base_dn, $filter, $attributes, 0, $sizeLimit, $timeLimit);
      
      return ldap_get_entries($ldapconn, $read);
    }
    else
      return false;
  }
  else
    return false;
}


function real_validate_url($url){
	
	$urlcomponents = parse_url($url);
	if($urlcomponents['scheme'] == "" && $url != "")
		return "http://".$url;	
	else if($urlcomponents['scheme'] != "http")
		return "";
	else
		return $url;	
}

function FetchData($results)
{
  /*if ($_SERVER['HTTP_HOST'] != 'localhost')
  {
    return mysql_fetch_array($results);
  }
  else
  {*/
    return $results->fetch(PDO::FETCH_ASSOC);
  //}
}

function db_num_rows($results)
{
  /*if ($_SERVER['HTTP_HOST'] != 'localhost')
  {
    return mssql_num_rows($results);
  }
  else
  {*/
    return $results->rowCount();
  //}
}

function execute_query($q, $db_conn, $DBType)
{
  //if ($_SERVER['HTTP_HOST'] != 'localhost')
  //{
    /*$result = mysql_query($q);
    if (!$result) {
      echo "query = $q<br><br>";	
      die(__FILE__.":".__LINE__.' Invalid query: ' . mysql_error());
    }
    return $result;*/
  //}
  //else
  //{

    // Because [Award/Proposal #] as a field name doesn't work in MySQL but `Award/Proposal #` does.
	   
    if ($DBType == 'mysql')
    {
      $q = str_replace(array("[", "]"),"`",$q);   	  
    }  
    $result=$db_conn->query($q);
    if (!$result)
    {
      echo "query = $q<br><br>"; 	    
      echo(__FILE__.":".__LINE__.' Error: ');
      print_r($db_conn->errorInfo());
      die();
    }
    return $result;
  //}
}
?>
