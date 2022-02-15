<?php

include 'utils.php';

include 'ldapdbutils.php';

// get the uid and password
$uid = substr( real_unescape( $_POST[ "uid" ] ), 0, 255 );
$passwd = substr( real_unescape( $_POST[ "passwd" ] ), 0, 255 );


// connect to the database
$db_conn = real_db_connect($_db_server, $_db_username, $_db_password, $_db_name);

$sessionid = real_login( $db_conn, $uid, $passwd );

$view = $_GET['view'];
$login_id = $_SESSION["UID"];


/*// find if the user has already entered basic info.
$query = "SELECT fname, lname, email_id FROM gen_login_info WHERE login_id = " . real_mysql_specialchars( $login_id, false );

$results = real_execute_query ( $query, $db_conn );

// if the user has not entered basic info redirect him to first login else to his profiles.
if( mysql_num_rows( $results ) == 0 )
{

  // Connect to one of UTEP's IT Microsoft SQL databases

  $mssqldb_conn = mssql_connect("ITDVSRSQLT02.utep.edu","FacultyProfiler","pr0f1L3R");

  if( ! $mssqldb_conn )
  {
    echo "Unable to connect to the MSSQL server";
    exit(0);
  }
  else
  {
    $mssqldb_select = mssql_select_db("Person", $mssqldb_conn );
    if( ! $mssqldb_select )
    {
      echo "Unable to select the database on the MSSQL server";
      exit(0);
    }
  }

  // Pull the user's contact information

  $mssqlresults = mssql_query( $query, $mssqldb_conn );

  if( mssql_num_rows( $mssqlresults ) > 0 )
  {

    // Insert some of the contact information into our MySQL db_user_info table

    $mssqlrow = mssql_fetch_row($mssqlresults);
    $query = "INSERT INTO db_user_info (`rank`,`dept`,`login_id`,`l_name`,`f_name`,`m_name`,`phone`,`email`,`room`,`building`,`box`) VALUES" .
      " (" . real_mysql_specialchars($mssqlrow[8], false) . 
      ", " . real_mysql_specialchars($mssqlrow[4], false) .
      ", " . real_mysql_specialchars($login_id, false) . 
      ", " . real_mysql_specialchars($mssqlrow[1], false) .
      ", " . real_mysql_specialchars($mssqlrow[0], false) .
      ", " . real_mysql_specialchars($mssqlrow[2], false) .
      ", " . "'" . $mssqlrow[6] . " " . $mssqlrow[7] . "'" .
      ", " . real_mysql_specialchars($mssqlrow[3], false) .
      ", " . "'" . "'" .
      ", " . real_mysql_specialchars($mssqlrow[5], false) . 
      ", " . "'" . "'" . ")";

    //echo $query;
    //exit(0);
    real_execute_query ( $query, $db_conn );

    // Insert the rest of the contact information into our MySQL ppl_general_info table

    //$pid = mysql_insert_id( $db_conn );
    //  $query = "INSERT INTO ppl_general_info (`pid`,`login_id`,`f_name`,`m_name`,`l_name`,`pri_designation`,`email_id`,`phone_no_1`,`city`,`state`,`office_location`) VALUES" .
 //" (" . $pid . 
 //", " . real_mysql_specialchars( $login_id, false) .
 //", " . "'" . $mssqlrow[0] . "'" .
 //", " . "'" . $mssqlrow[2] . "'" .
 //", " . "'" . $mssqlrow[1] . "'" .
 //", " . "'" . $mssqlrow[8] . "'" . "-" . "'" . $mssqlrow[4] . "'" .
 //", " . "'" . $mssqlrow[3] . "'" .
 //", " . "'" . $mssqlrow[6] . " " . $mssqlrow[7] . "'" .
 //", " . "'El Paso'" .
 //", " . "'TX'" .
 //", " . "'" . $mssqlrow[5] . "'" . ")";
 //    real_execute_query ( $query, $db_conn );
  }
  else
  {
    echo "The query return no results";
  }

  // Disconnect from the IT server

  if( $mssqldb_conn != NULL )
    mssql_close( $mssqldb_conn );
        $user_results = real_get_ppla_by_login_id($db_conn, $login_id );
	if( count( $user_results ) > 0 )
	{
	  set_session_variables( $db_conn, session_id(), ucfirst($user_results[2][4]), ucfirst($user_results[2][5]), $user_results[2][8] );//print_r($user_results);exit;
		add_login_info( $db_conn, $login_id, ucfirst($user_results[2][4]), ucfirst($user_results[2][5]), $user_results[2][8],  $user_results[2][7]  );
		real_redirect( "f_firstlogin.php", "view=$view", $db_conn );
	}
}
else
{
	$row = mysql_fetch_row($results);*/
	//set_session_variables( $db_conn, session_id(), $row[0], $row[1], $row[2] );
	set_session_variables( $db_conn, session_id(), '', '', '' );
	set_last_login_datetime( $db_conn, $login_id );
	//real_redirect( "f_after_login.php?orspnumber=".$_GET['orspnumber'], "view=$view", $db_conn );
	header("Location: f_after_login.php?ProjectID=".$_GET['ProjectID']);
//}

function set_session_variables( $db_conn, $sessionid, $fname, $lname, $email )
{
	$query = "UPDATE gen_login_session SET ".
				" fname = " . real_mysql_specialchars( $fname, false, $db_conn ) .
				", lname = " . real_mysql_specialchars( $lname, false, $db_conn ) .
				", email = " . real_mysql_specialchars( $email, false, $db_conn ) .
				" WHERE session_id = '$sessionid'"; 
	real_execute_query( $query, $db_conn, 'mysql' );
}

function add_login_info( $db_conn, $login_id, $lname, $fname, $email, $phone )
{
	$query = "INSERT INTO gen_login_info ( login_id, fname, lname, email_id, phone_no, datetime, last_datetime ) VALUES " .
				" (" . real_mysql_specialchars( $login_id, false ) .
				", " . real_mysql_specialchars( $fname, false ) .

				", " . real_mysql_specialchars( $lname, false ) .
				", " . real_mysql_specialchars( $email, false ) .
				", " . real_mysql_specialchars( $phone, false ) .
				", NOW(), NOW() ) ";
	real_execute_query( $query, $db_conn );				
}

function set_last_login_datetime( $db_conn, $uid )
{
	$query = "UPDATE gen_login_info SET last_datetime = NOW()" .
				" WHERE login_id = '$uid'"; 
	real_execute_query( $query, $db_conn, 'mysql' );
}
?>
