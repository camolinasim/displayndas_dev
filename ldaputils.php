<?php

//$_ldap_login_dn				=	"uid=oouidoo, cn=Accounts, dc=utep, dc=edu"; 
$_ldap_login_dn                               =       "uid=oouidoo, ou=people, dc=utep, dc=edu";
$_ldap_max_no_of_records	=	500;

$_ldap_input_login_name = "uid";
$_ldap_input_login_id = "uid";
$_ldap_input_first_name = "givenName";
$_ldap_input_last_name = "sn";

$_ldap_sort_by[0] = "givenName"; $_ldap_sort_by[1] = "sn"; 

$_ldap_login_id_output[0] = "uid";

$_ldap_ppl_output[0] = "displayname"; // full name
$_ldap_ppl_output[1] = "eduPersonAffiliation"; //rank
$_ldap_ppl_output[2] = ""; // dept name
$_ldap_ppl_output[3] = "uid"; //login id not login name
$_ldap_ppl_output[4] = "sn"; // last name
$_ldap_ppl_output[5] = "givenname"; // first name
$_ldap_ppl_output[6] = "initials"; // middlename

$_ldap_ppla_output[0] = $_ldap_ppl_output[0]; // full name
$_ldap_ppla_output[1] = $_ldap_ppl_output[1]; //rank
$_ldap_ppla_output[2] = $_ldap_ppl_output[2]; // dept name
$_ldap_ppla_output[3] = $_ldap_ppl_output[3]; //login id not login name
$_ldap_ppla_output[4] = $_ldap_ppl_output[4]; // last name
$_ldap_ppla_output[5] = $_ldap_ppl_output[5]; // first name
$_ldap_ppla_output[6] = $_ldap_ppl_output[6]; // middlename
$_ldap_ppla_output[7] = "telephoneNumber"; // Phone number
$_ldap_ppla_output[8] = "mail"; // email id
$_ldap_ppla_output[9] = "mail"; // email alias

$_ldap_pplb_output[0] = $_ldap_ppla_output[0]; // full name
$_ldap_pplb_output[1] = $_ldap_ppla_output[1]; // dept name
$_ldap_pplb_output[2] = $_ldap_ppla_output[2]; //rank
$_ldap_pplb_output[3] = $_ldap_ppla_output[3]; //login id not login name
$_ldap_pplb_output[4] = $_ldap_ppla_output[4]; // last name
$_ldap_pplb_output[5] = $_ldap_ppla_output[5]; // first name
$_ldap_pplb_output[6] = $_ldap_ppla_output[6]; // middlename
$_ldap_pplb_output[7] = $_ldap_ppla_output[7]; // Phone number
$_ldap_pplb_output[8] = $_ldap_ppla_output[8]; // email id
$_ldap_pplb_output[9] = "email"; // email alias
$_ldap_pplb_output[10] = ""; // room number
$_ldap_pplb_output[11] = ""; // building name
$_ldap_pplb_output[12] = ""; // PO Box number
$_ldap_pplb_output[13] = ""; // department code - People
$_ldap_pplb_output[14] = ""; //  - People
$_ldap_pplb_output[15] = ""; //  - People
$_ldap_pplb_output[16] = ""; //  - People
$_ldap_pplb_output[17] = ""; //  - People
$_ldap_pplb_output[18] = ""; //  - People
$_ldap_pplb_output[19] = ""; //  - People
$_ldap_pplb_output[20] = ""; //  - People

/***************************************************************************************
function: real_login_ldap
description: authenticates the user credentials using ldap and creates a session on success
params:
	$db_conn - database link
	$uid - user login id
	$passwd - user password
returns: session id
on error: redirects to error page
****************************************************************************************/
function real_login_ldap( $db_conn, $uid, $passwd )
{
	global $_ldap_server;
	global $_ldap_login_dn;
	global $_err_ldap_connect;
	global $_err_uid_null;
	global $_err_login;
	global $_err_page;
	real_reset_error();

	if( $uid == "" )
	{
		real_set_error( $_err_uid_null );  
		real_redirect_onerror( $_err_page, "", $db_conn);
	}
	if( $ldap = ldap_connect($_ldap_server)) 
	{ 
		//$ldap_dn = eregi_replace( "oouidoo", $uid, $_ldap_login_dn );
		$ldap_dn = preg_replace( "#oouidoo#", $uid, $_ldap_login_dn );
		//if (!($res = @ldap_bind($ldap, $ldap_dn, $passwd))) 
                //if (!($res = ldap_bind($ldap, $ldap_dn, $passwd)))
                if (($passwd == "") || !($res = ldap_bind($ldap, $ldap_dn, $passwd)))
		{
		        //echo "crashed, ldap_dn = $ldap_dn passwd = $passwd _ldap_login_dn = $_ldap_login_dn";
		        //exit();
			real_set_error( $_err_login );
			real_redirect_onerror( $_err_page, "", $db_conn);
		}
		else
		{
                  //echo "crashed, ldap_dn = $ldap_dn passwd = $passwd _ldap_login_dn = $_ldap_login_dn";
		  //exit();
		  return true;
		}
	}
	else
	{
		real_set_error( $_err_ldap_connect );
		real_redirect_onerror( $_err_page, "", $db_conn);
	}
}
// queries ldap for the required information.
function real_query_info_ldap($db_conn, $input_fields, $output_fields, $limit, $sort_by, $pageno )
{
	global $_ldap_server, $_ldap_global_dn, $_ldap_global_passwd, $_ldap_search_dn_ppl, $_browse_search_rows_per_page;
	global $_err_ldap_connect;
	global $_err_page;
	$_browse_search_rows_per_page = 10;
	$output = array();
	$dataset = array();
	$search_filter = "";
	$output[0][0] = "";
	//echo "_ldap_server = $_ldap_server _ldap_global_dn = $_ldap_global_dn";
	//echo "_ldap_global_passwd = $_ldap_global_passwd";
	//echo "_ldap_search_dn_ppl = $_ldap_search_dn_ppl";  
	if( $ldap = ldap_connect($_ldap_server) ) 
    { 
                //if (!($res = @ldap_bind($ldap, $_ldap_global_dn, $_ldap_global_passwd)))
                if (!($res = ldap_bind($ldap, $_ldap_global_dn, $_ldap_global_passwd)))
		{ 
		        //echo "crashed, _ldap_global_dn = $_ldap_global_dn, _ldap_global_passwd = _ldap_global_passwd";
		        //exit(1); 
			real_set_error( $_err_ldap_connect );
			real_log_error( $db_conn, "Could not connect to ldap server using the specified dn and password", "" );
			ldap_close( $ldap );
			real_redirect_onerror( $_err_page, "", $db_conn);
		}
		$num_inputs = count($input_fields);
		for($i=0; $i < $num_inputs; $i++)
		{
			$search_filter .= "(".$input_fields[$i][0]."=".$input_fields[$i][1].")";
		}
		//$search_filter = "(&(&".$search_filter.")(|(objectClass=utaStudent)(objectClass=utaEmployee)(objectClass=utaPerson)))";
		$search_filter = "(&".$search_filter.")";
		$sr = @ldap_search( $ldap, $_ldap_search_dn_ppl, $search_filter, $output_fields, 0, $limit, 0);
		//echo "_ldap_global_dn = $_ldap_global_dn  ";  
		//echo "_ldap_search_dn_ppl = $_ldap_search_dn_ppl  ";
		//echo "search_filter = $search_filter  ";
		//echo "count(output_fields) = ". count($output_fields);
                /*echo "output_fields[0] = '$output_fields[0]' <br>";  
                echo "output_fields[1] = '$output_fields[1]' <br>";  
                echo "output_fields[2] = '$output_fields[2]' <br>";  
                echo "output_fields[3] = '$output_fields[3]' <br>";  
                echo "output_fields[4] = '$output_fields[4]' <br>";  
                echo "output_fields[5] = '$output_fields[5]' <br>";  
		echo "output_fields[6] = '$output_fields[6]' <br>"; 
		echo "output_fields[7] = '$output_fields[7]' <br>"; 
		echo "output_fields[8] = '$output_fields[8]' <br>";*/ 
		if($sr)
		{
			if( $sort_by != null )
			{
				foreach($sort_by as $each_sort_by)
				{
					ldap_sort($ldap, $sr, $each_sort_by);
				}
			}
			$count_entries = ldap_count_entries ($ldap, $sr);
                        //echo "count_entries = $count_entries";
			$info = @ldap_get_entries($ldap, $sr);
			//echo 'info[0][0] = '. $info[0][1];
			//echo 'info[0]["displayname"]["count"] = '. $info[0]["displayname"]["count"] .'<br>';
			//echo 'info[0]["edupersonaffiliation"]["count"] = '. $info[0]["edupersonaffiliation"]["count"] .'<br>';
			//echo 'info[0]["edupersonaffiliation"][0] = '. $info[0]["edupersonaffiliation"][0]. '<br>';
			//echo 'info[0]["telephoneNumber"][0] = '. $info[0]["telephoneNumber"][0]. '<br>';
			//echo 'info[0]["dn"] = '. $info[0]["dn"];
			//echo 'info[0] = '. $info[0];
			//echo 'info[0]["count"] = '. $info[0]["count"];
			//echo "info[0]['sn'][1] = ".$info[0]['sn'][0];
			//echo "<pre>"; print_r($input_fields); echo "</pre>"; 
			//exit();
			$max_page = ceil( $count_entries / $_browse_search_rows_per_page ) ;
			if( $count_entries <=  ( ($pageno - 1) * $_browse_search_rows_per_page ) )
				$pageno =  $max_page ;
			if( $pageno > 0 )
			{
				$start_limit = ( $pageno - 1 ) * $_browse_search_rows_per_page;
				$end_limit = ($_browse_search_rows_per_page * $pageno) < $count_entries ? ($_browse_search_rows_per_page * $pageno): $count_entries;		
			}
			else
			{

				$start_limit = 0;
				$end_limit = $count_entries;		
			}
			for( $i = $start_limit; $i < $end_limit; $i++ )
			{
				//echo "i = $i <br>";
				for( $j = 0; $j < count( $output_fields ); $j++ )
				{
					//$z = count( $info[$i][strtolower($output_fields[$j])] ) - 1; 
					//echo "j = $j count( info[i][output_fields[j]] ) - 1 = ". $z ."<br>";
					//echo "output_fields[j] = ". strtolower($output_fields[$j]) ."<br>"; 
					//echo "info[i][$output_fields[$j]][0] = ". $info[$i][strtolower($output_fields[$j])][0] ."<br>";
					for( $k = 0; $k < count( $info[$i][strtolower($output_fields[$j])] ) - 1; $k++)
					{
						//echo "i = $i, j = $j, k = $k <br>";
						if( $k != 0 )
							$output[$i- $start_limit][$j] .=  ", ";
						// probable ldap error fix over here
						//echo "i = $i start_limit = $start_limit j = $j k = $k strtolower(output_fields[j]) = ". strtolower($output_fields[$j]) ." info[i][strtolower(output_fields[j])][k] = ". $info[$i][strtolower($output_fields[$j])][$k] ."<br>";
						$output[$i- $start_limit][$j] .=  $info[$i][strtolower($output_fields[$j])][$k];
						//$output[$i- $start_limit][$j] .=  $info[$i][$output_fields[$j]][$k];
					}
				}
			}
		}
		ldap_close( $ldap );
		$dataset[0] = $pageno;
		$dataset[1] = $max_page;
		$dataset[2] = $output;
		//echo "count(dataset[2]) = ".count($dataset[2]);
	        //echo "dataset[2][0][0] = ".$dataset[2][0][3];	
		return $dataset;
    }
	else
	{
		real_set_error( $_err_ldap_connect );
		real_redirect_onerror( $_err_page, "", $db_conn);
	}	
}

// gets the login id from ldap based on login name
function real_get_login_id_by_login_name_ldap($db_conn, $login_name)
{
		global $_ldap_input_login_name, $_ldap_login_id_output, $_ldap_max_no_of_records;
		$input_fields = array();
		$input_fields[0][0] = $_ldap_input_login_name; $input_fields[0][1] = $login_name;
		$result_ldap = real_query_info_ldap($db_conn, $input_fields, $_ldap_login_id_output, $_ldap_max_no_of_records, null, 0);
		return $result_ldap[2][0][0];			
}

// gets the ppl data from ldap based on login id
function real_get_ppl_by_login_id_ldap($db_conn, $login_id)
{
		global $_ldap_input_login_id, $_ldap_ppl_output,  $_ldap_sort_by, $_ldap_max_no_of_records;
		$input_fields = array();
				
		$input_fields[0][0] = $_ldap_input_login_id; $input_fields[0][1] = $login_id;
		$result_ldap = real_query_info_ldap($db_conn, $input_fields, $_ldap_ppl_output, $_ldap_max_no_of_records, $_ldap_sort_by, 0 );
		return $result_ldap;				
}

// gets the ppla data from ldap based on login id
function real_get_ppla_by_login_id_ldap($db_conn, $login_id)
{
		global $_ldap_input_login_id, $_ldap_ppla_output,  $_ldap_sort_by, $_ldap_max_no_of_records;
		$input_fields = array();

		$input_fields[0][0] = $_ldap_input_login_id; $input_fields[0][1] = $login_id;
		$result_ldap = real_query_info_ldap($db_conn, $input_fields, $_ldap_ppla_output, $_ldap_max_no_of_records, $_ldap_sort_by, 0 );
		return $result_ldap;				
}
// gets the pplb data from ldap based on login id
function real_get_pplb_by_login_id_ldap($db_conn, $login_id)
{
		global $_ldap_input_login_id, $_ldap_pplb_output,  $_ldap_sort_by, $_ldap_max_no_of_records;
		$input_fields = array();
				
		$input_fields[0][0] = $_ldap_input_login_id; $input_fields[0][1] = $login_id;
		$result_ldap = real_query_info_ldap($db_conn, $input_fields, $_ldap_pplb_output, $_ldap_max_no_of_records, $_ldap_sort_by, 0 );
		return $result_ldap;				
}

/***************************************************************************************
function: real_get_ppl_by_name_ldap
description: Gets the ppl data from ldap based on the name.
params: 
	$db_conn - an instance of the database connection
	$last_name - last name
	$first_name - first name
	$page_no - 
returns: nothing
****************************************************************************************/
function real_get_ppl_by_name_ldap($db_conn, $last_name, $first_name, $page_no)
{
		global $_ldap_input_last_name, $_ldap_input_first_name, $_ldap_ppl_output,  $_ldap_sort_by, $_ldap_max_no_of_records;
		$input_fields = array();
				
		$input_fields[0][0] = $_ldap_input_last_name; 	$input_fields[0][1] = $last_name."*";
		$input_fields[1][0] = $_ldap_input_first_name; 	$input_fields[1][1] = $first_name."*";	
		$result_ldap = real_query_info_ldap($db_conn, $input_fields, $_ldap_ppl_output, $_ldap_max_no_of_records, $_ldap_sort_by, $page_no );
		return $result_ldap;				
}

/***************************************************************************************
function: real_get_ppla_by_name_ldap
description: Gets the ppla data from ldap based on the name.
params: 
	$db_conn - an instance of the database connection
	$last_name - last name
	$first_name - first name
	$page_no - 
returns: nothing
****************************************************************************************/
function real_get_ppla_by_name_ldap($db_conn, $last_name, $first_name, $page_no)
{
		global $_ldap_input_last_name, $_ldap_input_first_name, $_ldap_ppla_output,  $_ldap_sort_by, $_ldap_max_no_of_records;
		$input_fields = array();

		$input_fields[0][0] = $_ldap_input_last_name; 	$input_fields[0][1] = $last_name."*";
		$input_fields[1][0] = $_ldap_input_first_name; 	$input_fields[1][1] = $first_name."*";	
		$result_ldap = real_query_info_ldap($db_conn, $input_fields, $_ldap_ppla_output, $_ldap_max_no_of_records, $_ldap_sort_by, $page_no );
		return $result_ldap;				
}

/***************************************************************************************
function: real_get_pplb_by_name_ldap
description: Gets the pplb data from ldap based on the name.
params: 
	$db_conn - an instance of the database connection
	$last_name - last name
	$first_name - first name
	$page_no - 
returns: nothing
****************************************************************************************/
function real_get_pplb_by_name_ldap($db_conn, $last_name, $first_name, $page_no)
{
		global $_ldap_input_last_name, $_ldap_input_first_name, $_ldap_pplb_output,  $_ldap_sort_by, $_ldap_max_no_of_records;
		$input_fields = array();
		$input_fields[0][0] = $_ldap_input_last_name; 	$input_fields[0][1] = $last_name."*";
		$input_fields[1][0] = $_ldap_input_first_name; 	$input_fields[1][1] = $first_name."*";	
		$result_ldap = real_query_info_ldap($db_conn, $input_fields, $_ldap_pplb_output, $_ldap_max_no_of_records, $_ldap_sort_by, $page_no );
		return $result_ldap;				
}

function real_search_ldap($key, $value, $_ldap_search_dn)
{
		global $_ldap_input_login_id, $_ldap_pplb_output,  $_ldap_sort_by;
		$input_fields = array();
		$input_fields[0][0] = $key; $input_fields[0][1] = $value;
		$result_ldap = search_ldap_core($input_fields, $_ldap_pplb_output, 
			5000, $_ldap_sort_by, 0, $_ldap_search_dn);
		return $result_ldap;
}

function search_ldap_core($input_fields, $output_fields, $limit, $sort_by, $pageno, $_ldap_search_dn)
{
	global $_ldap_server, $_ldap_global_dn, $_ldap_global_passwd, $_browse_search_rows_per_page;
	global $_err_ldap_connect;
	global $_err_page;
	$_browse_search_rows_per_page = 1000;
	$output = array();
	$dataset = array();
	if( $ldap = ldap_connect($_ldap_server) ) 
    { 
		if (!($res = @ldap_bind($ldap, $_ldap_global_dn, $_ldap_global_passwd)))
		{ 
			ldap_close( $ldap );
			echo "Could not connect to ldap server using the specified dn and password.<br>\n";
		}
		$search_filter = "(".$input_fields[0][0]."=".$input_fields[0][1].")";
		//echo "Search By: $search_filter In $_ldap_search_dn<br>\n";
		$sr = @ldap_search( $ldap, $_ldap_search_dn, $search_filter, $output_fields, 0, $limit, 0);
		if($sr)
		{
			$count_entries = ldap_count_entries ($ldap, $sr);
			$info = @ldap_get_entries($ldap, $sr);
			//echo "<pre>"; print_r($info); echo "</pre>";
			for ($i=0; $i<$info["count"]; $i++)
			{
				for($j=0; $j<count($output_fields); $j++)
				{
					$dataset[$i][$j] = $info[$i][strtolower($output_fields[$j])][0];
				}
			}
		}
		ldap_close( $ldap );
		//echo "-----------------------<br>\n";
		return $dataset;
    }
	else
		echo "LDAP Connect Error<br>\n";
}

?>
