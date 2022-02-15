<?php
include 'ldaputils.php';
include 'dbutils.php';

function real_login( $db_conn, $uid, $passwd )
{
	global $_authentication; 
        global $_err_login;
        global $_err_page;
	$login_status = false;
	if( $_authentication == "LDAP" )
		$login_status = real_login_ldap( $db_conn, $uid, $passwd );
	else if( $_authentication == "DB" )
		$login_status = real_login_db( $db_conn, $uid, $passwd ); 
	if( $login_status == true )
	  {    
		session_start();
		$old_sessid = session_id();
		session_regenerate_id();
		$new_sessid = session_id();
		session_id($old_sessid);
		session_destroy();
		
		$old_session = $_SESSION;
		session_id($new_sessid);
		session_start();
		$_SESSION = $old_session;
		
		$login_id = real_get_login_id_by_login_name( $db_conn, $uid );
		if($login_id == "")
		{
		        //echo "login_id is empty"; 
		        //exit();
			real_set_error( $_err_login );
			real_redirect_onerror( $_err_page, "", $db_conn);
		}
		$_SESSION['UID'] = $login_id;
		$sessionid = session_id();
		$remoteip = $_SERVER['REMOTE_ADDR'];
		$log = real_login_session( $db_conn, $login_id, $sessionid, $remoteip );
		if( $log == false )
		{
			real_set_error( $_err_login );
			real_redirect_onerror( $_err_page, "", $db_conn);
		}
		else
		{
			return $sessionid;
		}
	} 
	else
		return "";		
}

function real_get_login_id_by_login_name($db_conn, $login_name)
{
	global $_authentication;	
	if( $_authentication == "LDAP" )
	        return real_get_login_id_by_login_name_ldap($db_conn, $login_name);
	        // return real_get_login_id_by_login_name_db($db_conn, $login_name);
	else if( $_authentication == "DB" )
		return real_get_login_id_by_login_name_db($db_conn, $login_name);
}

function real_get_ppl_by_login_id($db_conn, $login_id)
{
	global $_authentication;	
	if( $_authentication == "LDAP" )
		return real_get_ppl_by_login_id_ldap($db_conn, $login_id);
	else if( $_authentication == "DB" )
		return real_get_ppl_by_login_id_db($db_conn, $login_id);
}

function real_get_ppla_by_login_id($db_conn, $login_id)
{
	global $_authentication;	
	if( $_authentication == "LDAP" )
	        //return real_get_ppla_by_login_id_ldap($db_conn, $login_id);
	        return real_get_ppla_by_login_id_db($db_conn, $login_id);
	else if( $_authentication == "DB" )
		return real_get_ppla_by_login_id_db($db_conn, $login_id);
}

function real_get_pplb_by_login_id($db_conn, $login_id)
{
	global $_authentication;	
	if( $_authentication == "LDAP" )
		return real_get_pplb_by_login_id_ldap($db_conn, $login_id);
	else if( $_authentication == "DB" )
		return real_get_pplb_by_login_id_db($db_conn, $login_id);
}

function real_get_ppl_by_name($db_conn, $last_name, $first_name, $page_no)
{
	global $_authentication;	
	if( $_authentication == "LDAP" )
		return real_get_ppl_by_name_ldap($db_conn, $last_name, $first_name, $page_no);
	else if( $_authentication == "DB" )
		return real_get_ppl_by_name_db($db_conn, $last_name, $first_name, $page_no);
}

function real_get_ppla_by_name($db_conn, $last_name, $first_name, $page_no)
{
	global $_authentication;	
	if( $_authentication == "LDAP" )
		return real_get_ppla_by_name_ldap($db_conn, $last_name, $first_name, $page_no);
	else if( $_authentication == "DB" )
		return real_get_ppla_by_name_db($db_conn, $last_name, $first_name, $page_no);
}

function real_get_pplb_by_name($db_conn, $last_name, $first_name, $page_no)
{
	global $_authentication;	
	if( $_authentication == "LDAP" )
		return real_get_pplb_by_name_ldap($db_conn, $last_name, $first_name, $page_no);
	else if( $_authentication == "DB" )
		return real_get_pplb_by_name_db($db_conn, $last_name, $first_name, $page_no);
}

?>