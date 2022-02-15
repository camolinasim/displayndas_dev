<?php

$_db_ppl_output = "CONCAT(l_name, ', ', f_name, IF(m_name<>'', ' ', ''), m_name) as name, rank, dept, login_id, l_name, f_name, m_name";
$_db_ppla_output = "CONCAT(l_name, ', ', f_name, IF(m_name<>'', ' ', ''), m_name) as name, rank, dept, login_id, l_name, f_name, m_name, phone, email, '' as emailalias";
$_db_pplb_output = "CONCAT(l_name, ', ', f_name, IF(m_name<>'', ' ', ''), m_name) as name, rank, dept, login_id, l_name, f_name, m_name, phone, email, '' as emailalias, room, building, box";
/***************************************************************************************
function: real_login_db
description: authenticates the user credentails using db and creates a session on success
params:
	$db_conn - database link
	$uid - user login id
	$passwd - user password
returns: session id
on error: redirects to error page
****************************************************************************************/
function real_login_db( $db_conn, $uid, $passwd )
{
	global $_err_login, $_err_page, $_err_uid_null;
	if( $uid == "" )
	{
		real_set_error( $_err_uid_null );  
		real_redirect_onerror( $_err_page, "", $db_conn);
	}
	$query = "SELECT login_id FROM db_authentication WHERE login_name = '$uid' AND password='" . md5($passwd) . "'";
	$results = real_execute_query( $query, $db_conn );
	if( mysql_num_rows( $results ) > 0 )
	{
		return true;
	}
	else
	{
		real_set_error( $_err_login );
		real_redirect_onerror( $_err_page, "", $db_conn);
	}
}

function real_get_login_id_by_login_name_db($db_conn, $login_name)
{
	$query = "SELECT login_id FROM db_authentication WHERE login_name = '$login_name'";
	$results = real_execute_query( $query, $db_conn );
	if( mysql_num_rows( $results ) > 0 )
	{
		$row = mysql_fetch_row( $results );
		return $row[0];
	}
	return "";
}

function real_get_ppl_by_login_id_db($db_conn, $login_id)
{
	global $_db_ppl_output;
	$query = "SELECT $_db_ppl_output FROM db_user_info WHERE login_id='$login_id' ";
	return real_get_first_row( $db_conn, $query );
}

function real_get_ppla_by_login_id_db($db_conn, $login_id)
{
	global $_db_ppla_output;
	$query = "SELECT $_db_ppla_output FROM db_user_info WHERE login_id='$login_id' ";
	return real_get_first_row( $db_conn, $query );
}

function real_get_pplb_by_login_id_db($db_conn, $login_id)
{
	global $_db_pplb_output;
	$query = "SELECT $_db_pplb_output FROM db_user_info WHERE login_id='$login_id' ";
	return real_get_first_row( $db_conn, $query );
}

function real_get_first_row( $db_conn, $query )
{
	$results = real_execute_query( $query, $db_conn );
	if( mysql_num_rows( $results ) > 0 )
	{
		$row = mysql_fetch_row( $results );
	}
	$retval[0] = 0; // page number -0 represents all records; in this case only one record
	$retval[1] = 1; // max page number
	$retval[2] = $row;
	return $retval;
}

function real_get_ppl_by_name_db($db_conn, $last_name, $first_name, $page_no)
{
	global $_db_ppl_output;
	$clause = " FROM db_user_info WHERE l_name LIKE '$last_name%' AND f_name LIKE '$first_name%' ORDER BY l_name, f_name ";
	$query_count = "SELECT COUNT(1) $clause";
	$query_info = "SELECT $_db_ppl_output $clause";
	return real_get_range_rows( $db_conn, $query_count, $query_info, $page_no );
}

function real_get_ppla_by_name_db($db_conn, $last_name, $first_name, $page_no)
{
	global $_db_ppla_output;
	$clause = " FROM db_user_info WHERE l_name LIKE '$last_name%' AND f_name LIKE '$first_name%' ORDER BY l_name, f_name ";
	$query_count = "SELECT COUNT(1) $clause";
	$query_info = "SELECT $_db_ppla_output $clause";
	return real_get_range_rows( $db_conn, $query_count, $query_info, $page_no );
}

function real_get_pplb_by_name_db($db_conn, $last_name, $first_name, $page_no)
{
	global $_db_pplb_output;
	$clause = " FROM db_user_info WHERE l_name LIKE '$last_name%' AND f_name LIKE '$first_name%' ORDER BY l_name, f_name ";
	$query_count = "SELECT COUNT(1) $clause";
	$query_info = "SELECT $_db_pplb_output $clause";
	return real_get_range_rows( $db_conn, $query_count, $query_info, $page_no );
}

function real_get_actual_page_no( $page_no, $count_entries )
{
	global $_browse_search_rows_per_page;
	$max_page = ceil( $count_entries / $_browse_search_rows_per_page ) ;
	if( $count_entries <=  ( ($page_no - 1) * $_browse_search_rows_per_page ) )
		$page_no =  $max_page ;
	$retval[0] = $page_no;
	$retval[1] = $max_page;
	return $retval;
}

function real_get_range_rows( $db_conn, $query_count, $query_info, $page_no )
{
	global $_browse_search_rows_per_page;
	$row_count = real_get_first_row( $db_conn, $query_count );
	$dataset = array();
	if( $row_count[2][0] > 0 )
	{
		if( $page_no > 0 )
		{
			$retval = real_get_actual_page_no( $page_no, $row_count[2][0] );
			$limit = ( $retval[0] - 1 ) * $_browse_search_rows_per_page;
			$dataset[0] = $retval[0];
			$dataset[1] = $retval[1];
			$query_info .= " LIMIT $limit, $_browse_search_rows_per_page";
		}
		else
		{
			$dataset[0] = 0;
			$dataset[1] = 1;
		}
		$results = real_execute_query( $query_info, $db_conn );
		$counter = 0;
		while($row = mysql_fetch_row( $results ))
		{
			$rows[$counter] = $row;
			$counter = $counter + 1;
		}
		$dataset[2] = $rows;
		return $dataset;
				
	}
	
}
?>