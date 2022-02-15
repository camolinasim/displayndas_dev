<?php
$redirect= 'Location: report1.php';
//$redirect1= 'Location: report.php';
//$redirect1= 'Location: prats.php';
$cwd = getcwd();

// Strip out the unnecessary characters from the "current working directory" string
// leaving only the part we need.

//$cwd = str_replace("/var/www/html/","",$cwd);
if ($_SERVER['HTTP_HOST'] != 'localhost')
{
  $cwd = str_replace("D:\\inetpub\\webroot2\\","",$cwd);
  $redirect1= 'Location: https://orspweb2.utep.edu/'.$cwd.'/index.php?docket='.$_GET['subcontract'];
}
else
{
  $cwd = str_replace("C:\\xampp\\htdocs\\","",$cwd);
  $redirect1= 'Location: https://localhost/'.$cwd.'/index.php?docket='.$_GET['subcontract'];
}
//$cwd = str_replace("/DataPortal","",$cwd);
//$redirect1= 'Location: https://orspprofile.utep.edu/'.$cwd.'/DataPortal/default-dnn.php';
//$redirect1= 'Location: https://orspprofile.utep.edu/'.$cwd.'/default-dnn.php?orspnumber='.$_GET['orspnumber'];
$redirect2= 'Location: reporterror.php';
//Original File Created by: Farhan Khan
//Modified by Rajat, Prathamesh for Effort Certification Application 09/26/2006
//Comments: Added link for $view=7 everywhere and added new case for including etapplicaiton/index for case 7
//Last modified by Rajat, Kenil for changing access to all for Effort Certification Application 12/08/2006
//Comments
include 'utils.php';
session_start();
$_SESSION['user']=10;
$db_conn = real_db_connect($_db_server, $_db_username, $_db_password, $_db_name);
real_check_valid_session( $db_conn, $_SESSION['UID'], session_id(), $_SERVER['REMOTE_ADDR']);
//$is_admin = real_check_user_groupid( $db_conn, "admin" );
//$is_tech_admin = real_check_user_groupid( $db_conn, "tech_admin" );
//$is_oric_admin = real_check_user_groupid( $db_conn, "oric_admin" );
//$is_curriculum_admin = real_check_user_groupid( $db_conn, "curriculum_admin" );
//$view=real_unescape($_GET['view']);
$view = 8;
$pname=$_SESSION["UID"];
if ($view=="")
{
     $view=1;
}
if ($view==8)
{
  /*$_db_name = "pvasi"; 
  $db_conn = real_db_connect($_db_server, $_db_username, $_db_password, $_db_name);
  if (!$db_conn)
  {
    $_SESSION['user']=null;
    die('Could not connect: ' . mysql_error());
  }*/

  $driver = "{ODBC Driver 13 for SQL Server}";
  $server   = "ORSPSRVAPP02";
  $username = "orspbt";
  $userpass = "3T3p*r3N1w";
  $database = "displayndas";
  $mssqldb_conn2_settings = "odbc:Driver=$driver; Server=$server; Database=$database; Uid=$username; Pwd=$userpass;";
  $mssqldb_conn2 = new PDO($mssqldb_conn2_settings);


  // $mssqldb_conn2 = new PDO("sqlsrv:server=orspsrvapp02.utep.edu;Database=displayndas","orspbt","3T3p*r3N1w");
  if (!$mssqldb_conn2)
  {
    echo "Unable to connect to the MSSQL server";
    exit(0);
  }  	
  //mysql_select_db("my_db", $db_conn);
  //echo "pname = '$pname'<br>";
  //$results = mysql_query("SELECT * FROM person where Username = '$pname' ");
  //$results = execute_query("SELECT * FROM person where Username = '$pname' ",$db_conn, 'mysql');
  $results = execute_query("SELECT * FROM PeopleWhoCanAccess where Username = '$pname' ",$mssqldb_conn2, 'sqlserver');
  //$results = execute_query("SELECT * FROM ORSPDatabase.RATable where RAEmail = '$pname@utep.edu'",$db_conn, 'mysql');
  //print "mysql_num_rows( results ) = ". mysql_num_rows( $results );
  //echo "<br>";
  //while($row = mysql_fetch_array($results))
  while($row = FetchData($results))
  {
    $xyz=$row['Username'];
    //echo "xyz = '$xyz'<br>";
  }
  /*$results = execute_query("SELECT * FROM DataPortal.ContractsAndGrantsPeople where Username = '$pname' ",$db_conn, 'mysql');
  while($row = FetchData($results))
  {
    $xyz2=$row['Username'];
    //echo "xyz = '$xyz'<br>";
  }*/
  /*if ($pname=='osegueda')
  {
    header($redirect);
  }*/

  //header($redirect1); // ***** Comment this out once we have restored our connection to the IT Datamart. This allows
  //exit(0);            // anybody with access to UTEP machines to login in. Normally only UTEP faculty and staff should be
                      // able to log in. 

  /*// Connect to one of UTEP's IT Microsoft SQL databases

  //$mssqldb_conn = mssql_connect("ITDVSRSQLT02.utep.edu:58962","FacultyProfiler","pr0f1L3R");
  $mssqldb_conn = new PDO("sqlsrv:server=ITDVSRSQLT02.utep.edu,58962;Database=Person","FacultyProfiler","pr0f1L3R");

  if( ! $mssqldb_conn )
  {
    echo "Unable to connect to the MSSQL server";
    $_SESSION['user']=null; 
    exit(0);
  }
  else
  {
    //$mssqldb_select = mssql_select_db("Person", $mssqldb_conn );
    //if( ! $mssqldb_select )
    //{
    //  echo "Unable to select the database on the MSSQL server";
    //  $_SESSION['user']=null;
    //  exit(0);
    //}
  }

  $query = "usp_GetFacultyStaffORSP";

  //$mssqlresults = mssql_query( $query, $mssqldb_conn );
  $mssqlresults = $mssqldb_conn->query($query);
  //while($row = mssql_fetch_array($mssqlresults))
  while($row = $mssqlresults->fetch(PDO::FETCH_ASSOC))
  {
    if (($row['EmailAddress'] == $pname ."@utep.edu") || ($row['EmailAddress'] == $pname ."@miners.utep.edu"))
    {
      break;
    }
    //echo $row['EmailAddress']."<br>";
  }

  // Disconnect from the server

  if( $mssqldb_conn != NULL )
    //mssql_close( $db_conn );
    $mssqldb_conn = null;*/
  
  //echo "Hello";
  //echo $row['EmailAddress']."<br>"; 
  //exit(0);

  // Check to see if the user is in Contracts and Grants or is an RA.

  $results = execute_query("SELECT * FROM ORSPDatabase.RATable where RAEmail = '$pname@utep.edu'",$db_conn, 'mysql');   
  $_SESSION["isAnRAOrIsInContractsAndGrants"] = 0;
  if (db_num_rows($results) > 0)
  {
    $_SESSION["isAnRAOrIsInContractsAndGrants"] = 1;
  }
  $results = execute_query("SELECT * FROM DataPortal.ContractsAndGrantsPeople where Username = '$pname' ",$db_conn, 'mysql');
  if (db_num_rows($results) > 0)
  {
    $_SESSION["isAnRAOrIsInContractsAndGrants"] = 1;
  }

  // Access is granted to the Data Portal if the user having already passed LDAP authentication to get to this point is
  // in the set of allowed people (contained in SQL Server table displayndas.PeopleWhoCanAccess).

  //if (($pname==$xyz) || (mssql_num_rows($mssqlresults) > 0 )) 
  if (($pname==$xyz) || ($row['EmailAddress'] == $pname ."@utep.edu") || ($row['EmailAddress'] == $pname ."@miners.utep.edu")) 
  //if (($pname."@utep.edu"==$xyz) || ($pname."@miners.utep.edu"==$xyz) || ($pname==$xyz2)) 
  {
    //echo(__FILE__.":".__LINE__.' Redirecting to '.$redirect1);exit();	  
    header($redirect1);
  }
  else 
  {
    $_SESSION['user']=null; 	  
    header($redirect2);
  }
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml"><!-- InstanceBegin template="/Templates/level1.dwt.php" codeOutsideHTMLIsLocked="false" -->
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<!-- InstanceBeginEditable name="title" -->
<title>My Research Space</title>
<!--
Created By: Rajat Mittal
Date: June 1st, 2005
-->
<!-- InstanceEndEditable -->
<link href="styles/style1.css" rel="stylesheet" type="text/css" />
<link href="styles/list.css" rel="stylesheet" type="text/css" />
<!-- InstanceBeginEditable name="script" -->
<style media="screen">
.tdHiLite {
	background-color: #3399FF;
	cursor:pointer;
}

.tdLoLite {
	background-color: #D5EAFF;
	cursor:pointer;
}
.style1 {
	font-family: Arial, Helvetica, sans-serif;
	font-size: 18px;
}
.style2 {
	font-family: Arial, Helvetica, sans-serif;
	font-size: 12px;
}
#navcontainer ul
{
width: 100%;
font: arial, helvetica, sans-serif;
text-align: left;
}

#navcontainer li 
{
display: inline;
border-right: 1px solid #fff;
}

#navcontainer li a
{
text-decoration: none;
color: #FFF;
}
</style>
<script language="JavaScript" type="text/javascript" src="scripts/section_and_menu.js"></script>
<script language="JavaScript" type="text/javascript" src="scripts/findprofile.js"></script>
<script type="text/javascript" src="fac_evaluation/javascript.js"></script>
<script language="JavaScript" type="text/javascript" src="scripts/section_and_menu.js"></script>
<script type="text/javascript">

<!--
startList = function() 
{
	if (document.all&&document.getElementById) 
	{
		navRoot = document.getElementById("nav");
		for (i=0; i<navRoot.childNodes.length; i++) 
		{
			node = navRoot.childNodes[i];
			if (node.nodeName=="LI") 
			{
				node.onmouseover=function() 
				{
					this.className+=" over";
				}
				node.onmouseout=function() 
				{
					this.className=this.className.replace(" over", "");
   				}
   			}
  		}
 	}
}

window.onload=function()
{
	startList();
}

//-->
</script>
<!-- InstanceEndEditable -->
<!-- InstanceBeginEditable name="head" --><!-- InstanceEndEditable -->
</head>
<body>
<table width="100%" border="0" align="center" cellpadding="0" cellspacing="0" bgcolor="#FFFFFF" class="form_elements_row_action" id="basic_layout">
 <tr>
    <td height="3" colspan="2" style="background-image:url(images/banner_background.jpg)">
      <table width="100%"  border="0" cellpadding="0" cellspacing="0">
        <tr>
          <td><div align="left"><img src="images/bannerpart1.jpg" alt="Research Profile" align="left" /></div>
          </td>
          <td>
	      	<form action="searchresults.php" method="get" enctype="application/x-www-form-urlencoded">
			    <input name="search" type="text" class="form_elements" id="search" size="15" />		  
			    <input name="Submit" type="submit" class="form_elements_row_action" value="Quick Search" />
			  </form>
		  </td>
	  <td><img src="images/bannerpart2.jpg" alt="Research Profile" align="right" /></td>
        </tr>
      </table>
    </td> 
  </tr> 
  <tr>
    <td width='30%' align="left" class="table_background_other"><!-- InstanceBeginEditable name="pagename" --><span class="page_heading">My Research Space </span><!-- InstanceEndEditable --></td>	  
    <td valign="top" class="table_background_other" align='right'>
		<div id="menu">
			<ul id="nav">
			  <li>
			  <?php
			  print( "<a href='$_home/index.php'>Home</a>" );
			  if( $_SESSION["UID"] != "" )
			  	{print( "<ul><li><a href='researchspace.php'>Research Space</a></li>");
			  	 print( "<li><a href='logoff.php'>Logoff</a></li></ul>" );
				}
			  ?>
			  </li>
			  <li><a href="browseprofiles.php?view=1">Browse </a>
				<ul>
				  <li><a href="browseprofiles.php?view=1">Faculty</a></li>
				  <li><a href="browseprofiles.php?view=2">Organized Research Centers</a></li>
				  <li><a href="browseprofiles.php?view=3">Technology</a></li>
				  <li><a href="browseprofiles.php?view=4">Facility</a></li>
				  <li><a href="browseprofiles.php?view=5">Equipment</a></li>
				  <li><a href="browseprofiles.php?view=6">Research Support Centers, Groups and Laboratories</a></li>
			  	  <li><a href="courses.php">Courses</a></li>
				</ul>
			  </li> 
			  <li><a href="newsearch.php">Search </a>
				<ul>
				  <li><a href="newsearch.php">Basic</a></li>
				  <li><a href="clustersearch.php">Discipline areas of research and expertise</a></li>
				  <!-- <li><a href="advsearch.php">Advanced</a></li> -->
				</ul>
			  </li>
			  <li><a href="aboutrsp.php">Support</a>
				<ul>
				  <li><a href="aboutrsp.php">About rSp</a></li>
				  <li><a href="help/index.htm">Help and FAQ's</a></li>
				  <li><a href="feedback.php">Contact Us</a></li>
				</ul>
			  </li>

			</ul>
      </div>

	</td>
  </tr>
  <!-- content goes here -->
  <tr>
    <td colspan="2">&nbsp;</td>
  </tr>
  <tr>
    <td colspan="2">
	<!-- InstanceBeginEditable name="content" -->
	
	<?php
		print( "<table width='100%' border='0' cellspacing='0' cellpadding='0'> " );
		print( "<tr >" );
		switch ($view)
		{
			case 1:
				print( "<td background='images/tabblue.gif' height='33' width='111' valign='bottom' align='center'><span class='tab_menu'>My Profiles</span></td>" );
				//print( "<td background='images/tabsilver.gif' width='111' valign='bottom' align='center' ><span class='tab_menu'><a href='researchspace.php?view=' style='text-decoration:none'> BlueSheet</a></span></td>" );
				break;

			case 2:
				print( "<td background='images/tabsilver.gif' height='33' width='111' valign='bottom' align='center'><span class='tab_menu'><a href='researchspace.php?view=' style='text-decoration:none'>My Profiles</a></span></td>" );
				//print( "<td background='images/tabblue.gif' width='111' valign='bottom' align='center' ><span class='tab_menu'> BlueSheet</span></td>" );
				break;
                     
			
}
		print( "<td>&nbsp;</td>" );
		print( "</tr>" );
		print( "<tr>" );
			print( "<td colspan='8' height='5' bgcolor='#8DB0D3'> </td>" );
		print( "</tr>" );
		print( "<tr>" );
			print( "<td colspan='6' height='5' > </td>" );
		print( "</tr>" );

		print( "</table>" );

		if ($view==1)
		{
			include "f_myprofiles.php";
		}
		if ($view==2)
		{
			$pid = "0";
			$query1 = "SELECT pid FROM gen_profile_info WHERE type_id=1 AND owner_login_id="
                             . real_mysql_specialchars($_SESSION['UID'], false);
			$results = real_execute_query($query1, $db_conn);
			while( $rows = mysql_fetch_array( $results ) )
			//if ($rows = mysql_fetch_row($results))
			{
				$pid = $rows["pid"];
			}
			// goto bluesheet manage page
			//include "f_bs_manage.php";// old bluesheet activity page (takes time to load)
			include "bluesheets.php"; // new bluesheet activity page done by Raghuveer Mamilla			
		}
	?>
	<!-- InstanceEndEditable -->
	</td>
  </tr>
</table>
<table width="100%"  border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td class="table_background">
	<!-- Partnership text in this section with the hyperlink should remain visible on the template page and should not deleted -->
	<div align="right"><a href="http://www.uta.edu/collaborate" target="_blank"><span class="font_on_dark_blue"><strong>powering - The Partnership</strong></span></a></div>
	<!-- End of Partnership text -->
	</td>
  </tr>
  <!-- footer content goes here -->
  <tr>
    <td bgcolor="#D7CFCD"><div align="center"><font size="2" class="form_elements_row_action">&copy;2006 The University of Texas at El Paso | <a href="http://research.utep.edu/Default.aspx?tabid=1995">Office of Research and Sponsored Projects
</a>, 500 West University Avenue | El Paso, Texas 79968  Voice: 915.747.5680 | Fax: 915.747.6474 | <a href="feedback.php">Site Feedback</a><br />
    </font></div>
	<!-- Start of StatCounter Code 
This spot can be used to enter tracking coutner code. Recommended: http://www.statcounter.com
End of StatCounter Code -->								
	</td>
<!--end of footer -->
  </tr>
  <tr>
    <td bgcolor="#D7CFCD" class="form_elements_row_action"> <div align="center"><span class="error_message">Important Disclaimer: </span><strong>The responsibility for the accuracy of the information contained on these pages lies with the authors and user providing such information. </strong></div></td>
  </tr>
</table>
</body>
<!-- InstanceEnd --></html>
