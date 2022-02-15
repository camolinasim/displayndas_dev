<!DOCTYPE html>
<html>
<head>
<style>
table, th, td {
    border: 1px solid black;
}
</style>
</head>
<body>
<?php

if (!isset($_GET['subcontract'])) {
  $_GET['subcontract'] = "";
}

$redirect=  'Location: reportexample.php?subcontract='.$_GET['subcontract'];

session_start();

if (!isset($_SESSION['user'])) {
  $_SESSION['user'] = null;
}

if (($_SESSION['user'] == null) && ($_SERVER['HTTP_HOST'] != 'localhost')) {
  //echo(__FILE__.":".__LINE__.' Got this far.');exit();
  header( $redirect);
  exit(0);
}


if ($_SERVER['HTTP_HOST'] == 'localhost') {
  $_SESSION["UID"] = 'blekal';
}

$_SESSION['subcontract'] = $_GET['subcontract'];


// Setup user administrative access here.  Upload/Delete options
//
$scdocs_admins = array("osegueda", "blekal", "aherrera16", "mslopez4", "mcaire", "cholguin11", "cnlujan2", "mgarcia97");
$scdocs_admins_access = FALSE;

$_SESSION["ADMIN_SCDOCS_DISPLAY"] = FALSE;

if (in_array($_SESSION["UID"], $scdocs_admins)) {
    $_SESSION["ADMIN_SCDOCS_DISPLAY"] = TRUE;
}

$scdocs_admins_access = $_SESSION["ADMIN_SCDOCS_DISPLAY"];



//$mssqldb_conn = new PDO("sqlsrv:server=orspsrvapp02.utep.edu,1433;Database=orspdb","orspbt","3T3p*r3N1w");
$mssqldb_conn = new PDO("sqlsrv:server=orspsrvapp02.utep.edu;Database=orspdb","orspbt","3T3p*r3N1w");
if (!$mssqldb_conn) {
  echo "Unable to connect to the MSSQL server";
  exit(0);
}


//$mssqldb_conn2 = new PDO("sqlsrv:server=orspsrvapp02.utep.edu,1433;Database=subcontractsdocuments","orspbt","3T3p*r3N1w");
$mssqldb_conn2 = new PDO("sqlsrv:server=orspsrvapp02.utep.edu;Database=subcontractsdocuments","orspbt","3T3p*r3N1w");
if (!$mssqldb_conn2) {
  echo "Unable to connect to the MSSQL server";
  exit(0);
}


$driver   = "ODBC Driver 11 for SQL Server";
$server   = "ITDVSRSQLN01\NT01";
$username = "ORSPBudgetTool";
$userpass = "3T3p*r3N1w";
$database = "VPRPeopleSoft";


//$mssqldb_conn3 = new PDO("odbc:DRIVER={$driver};server=Itdvsrsqln01\nt01;Database=VPRPeopleSoft","ORSPBudgetTool","3T3p*r3N1w");
$mssqldb_conn3 = new PDO("odbc:DRIVER={$driver}; Server=$server; Database=$database; Uid=$username; Pwd=$userpass;");
if (!$mssqldb_conn3) {
  echo  __FILE__.":".__LINE__." Unable to connect to the MSSQL server.<br>";
  exit(0);
}


/*// Use sqlsrv_connect instead of PDO to avoid needing a port number to connect to SQL Server.

$mssqldb_conn3 = sqlsrv_connect("Itdvsrsqln01\nt01", array("UID" => "ORSPBudgetTool", "PWD" => "3T3p*r3N1w", "CharacterSet" => "UTF-8"));
if ($mssqldb_conn3)
{

}
else
{
  echo __FILE__.":".__LINE__." Unable to connect to the MSSQL server<br>";
  die( print_r( sqlsrv_errors(), true));
}*/
//$q = "SELECT DISTINCT [Award/Proposal #] FROM [orspdb].[dbo].[GM_AWD_PROJ_PROFILE] ORDER BY [Award/Proposal #] DESC";

$q = "SELECT DISTINCT SUBSTRING([Award/Proposal #],1,10) AS ORSPNumber 
      FROM [orspdb].[dbo].[GM_AWD_PROJ_PROFILE] 
      WHERE [Subcontract] = 'Yes' 
      ORDER BY ORSPNumber DESC ";
$mssqlresults = $mssqldb_conn->query($q);

if (!$mssqlresults) {
  echo "query = $q<br><br>"; 	    
  echo(__FILE__.":".__LINE__.' Error: ');
  print_r($mssqldb_conn->errorInfo());
  die();
}


echo '
<form action="index.php" method="get">
<select name="subcontract">';
   echo '	
   <option value="">All</option>';
while($row = $mssqlresults -> fetch(PDO::FETCH_ASSOC))
{
   if (preg_match("/(OR.*)[A-Z]/",$row['ORSPNumber'],$match))
   {

     // If the orsp number has a letter at the end then remove it.
 
     $row['ORSPNumber'] = $match[1];  
   }	
   echo '	
   <option value="'.$row['ORSPNumber'].'">'.$row['ORSPNumber'].'</option>';
}
echo '   
</select>
<input type="submit" value="Submit">
</form><br>';
echo '
<table>
  <tr>
    <th>Subcontract</th>
    <!--<th>Project Start Date</th>
    <th>Project End Date</th>-->
    <th>Subrecipient</th>
    <th>PeopleSoft Vendor Name</th>
    <th>Documents</th>
  </tr>';
if (!isset($_GET["subcontract"]))
{
  //$q = "SELECT DISTINCT [Project ID] AS ProjectID,[Project Start Date],[Project End Date] FROM [orspdb].[dbo].[GM_AWD_PROJ_PROFILE] ORDER BY [Project Start Date] DESC";
  $q = "SELECT DISTINCT SUBSTRING([Award/Proposal #],1,10) AS ORSPNumber FROM [orspdb].[dbo].[GM_AWD_PROJ_PROFILE] WHERE [Subcontract] = 'Yes' ORDER BY ORSPNumber DESC";
}
else
{
  /*if (preg_match("/(.*)[A-Z]/",$_GET["subcontract"],$match))
  {

    // If the project id for the NOA has a letter at the end then remove it.
 
    $_GET["subcontract"] = $match[1];  
  }*/	
  /*if ($_GET["subcontract"] == 'All')
  {
    $_GET["subcontract"] = '';
  }*/
  //$q = "SELECT DISTINCT [Project ID] AS ProjectID,[Project Start Date],[Project End Date] FROM [orspdb].[dbo].[GM_AWD_PROJ_PROFILE] WHERE [Project ID] LIKE '".$_GET["subcontract"]."%' ORDER BY [Project Start Date] DESC";
  $q = "SELECT DISTINCT SUBSTRING([Award/Proposal #],1,10) AS ORSPNumber FROM [orspdb].[dbo].[GM_AWD_PROJ_PROFILE] WHERE [Subcontract] = 'Yes' AND [Award/Proposal #] LIKE '".$_GET["subcontract"]."%' ORDER BY ORSPNumber DESC";
}
$mssqlresults = $mssqldb_conn->query($q);
if (!$mssqlresults)
{
  echo "query = $q<br><br>"; 	    
  echo(__FILE__.":".__LINE__.' Error: ');
  print_r($mssqldb_conn->errorInfo());
  die();
}
while($row = $mssqlresults -> fetch(PDO::FETCH_ASSOC))
{	
  /*if (preg_match("/(.*)[A-Z]/",$row['ProjectID'],$match))
  {

    // If the project id for the NOA has a letter at the end then remove it.
   
    $row['ProjectID'] = $match[1];  
  }*/  
  
  // Check the directories for the occurence of the orsp number and display once found the documents inside the folder having  // the orsp number as its name.

  if (file_exists("\\\ORSPSRVAPP02\\webroot2\\Subawards (used by subcontractsdocuments)\\".$row['ORSPNumber']))
  {
    $directory = dir("\\\ORSPSRVAPP02\\webroot2\\Subawards (used by subcontractsdocuments)\\".$row['ORSPNumber']."\\Sub-Awards"); 	  
    $directory->read();
    $directory->read();
    while ($entry = $directory->read())
    {	    
      echo '
  <tr>
    <td>'.$row['ORSPNumber'].'</td>';
      echo '
    <td>';
      echo $entry.'</td>';
      echo '
    <td>';
      /*$q = "SELECT DISTINCT [Vendor Name] AS VendorName FROM [orspdb].[dbo].[GM_AWD_PROJ_PROFILE] WHERE [Award/Proposal #] LIKE '".$row['ORSPNumber']."%'";
      //echo(__FILE__.":".__LINE__.' $q = '.$q.'<br>');
      $mssqlresults2 = $mssqldb_conn->query($q);
      if (!$mssqlresults2)
      {
        echo "query = $q<br><br>"; 	    
        echo(__FILE__.":".__LINE__.' Error: ');
        print_r($mssqldb_conn->errorInfo());
        die();
      }
      //echo(__FILE__.":".__LINE__.' $mssqlresults2 -> rowCount() = '.$mssqlresults2 -> rowCount().'<br>');
      $row2 = $mssqlresults2 -> fetch(PDO::FETCH_ASSOC);
      $temp = $row2['VendorName'];
      $row2 = $mssqlresults2 -> fetch(PDO::FETCH_ASSOC);*/
      //echo(__FILE__.":".__LINE__.' $mssqlresults2 -> rowCount() = '.$mssqlresults2 -> rowCount().'<br>');
      //if ($mssqlresults2 -> rowCount() > 1)
      //if ($row2['VendorName'] != "")
      //{       
        $q = "SELECT [Full Name] AS VendorName FROM SubrecipientFullNames WHERE Subrecipient = '".$entry."' AND ORSPNumber IS NULL";
        //echo(__FILE__.":".__LINE__.' $q = '.$q.'<br>');
        $mssqlresults2 = $mssqldb_conn2->query($q);
        if (!$mssqlresults2)
        {
          echo "query = $q<br><br>"; 	    
          echo(__FILE__.":".__LINE__.' Error: ');
          print_r($mssqldb_conn2->errorInfo());
          die();
        }
        $row2 = $mssqlresults2 -> fetch(PDO::FETCH_ASSOC);
      //}	
      //else
      //{
      //  $row2['VendorName'] = $temp; 
      //}
      //echo(__FILE__.":".__LINE__.' $mssqlresults2 -> rowCount() = '.$mssqlresults2 -> rowCount().'<br>');
      if ($mssqlresults2 -> rowCount() == 0)
      {
        $q = "SELECT [Full Name] AS VendorName FROM SubrecipientFullNames WHERE Subrecipient = '".$entry."' AND ORSPNumber = '".$row['ORSPNumber']."'";
        //echo(__FILE__.":".__LINE__.' $q = '.$q.'<br>');
        $mssqlresults2 = $mssqldb_conn2->query($q);
        if (!$mssqlresults2)
        {
          echo "query = $q<br><br>"; 	    
          echo(__FILE__.":".__LINE__.' Error: ');
          print_r($mssqldb_conn2->errorInfo());
          die();
        }
        $row2 = $mssqlresults2 -> fetch(PDO::FETCH_ASSOC);	
      }	
      //echo(__FILE__.":".__LINE__.' $mssqlresults2 -> rowCount() = '.$mssqlresults2 -> rowCount().'<br>');
      if ($mssqlresults2 -> rowCount() == 0)
      {
        //$q = "SELECT DISTINCT [Vendor Name] AS VendorName FROM [orspdb].[dbo].[GM_AWD_PROJ_PROFILE] WHERE [Award/Proposal #] LIKE '".$row['ORSPNumber']."%' AND SUBSTRING([Vendor Name],1,4) != 'THE ' AND SUBSTRING([Vendor Name],1,1) = '".substr($entry,0,1)."'";
        $q = "SELECT DISTINCT [Name] AS VendorName FROM UTE_GM_AWD_PRJ_VNDR WHERE [Contract] LIKE '".$row['ORSPNumber']."%' AND SUBSTRING([Name],1,4) != 'THE ' AND SUBSTRING([Name],1,1) = '".substr($entry,0,1)."'";
        //echo(__FILE__.":".__LINE__.' $q = '.$q.'<br>');
        $mssqlresults2 = $mssqldb_conn3->query($q);
        if (!$mssqlresults2)
        {
          echo "query = $q<br><br>"; 	    
          echo(__FILE__.":".__LINE__.' Error: ');
          print_r($mssqldb_conn3->errorInfo());
          die();
        }
        //echo(__FILE__.":".__LINE__.' $mssqlresults2 -> rowCount() = '.$mssqlresults2 -> rowCount().'<br>');
        $row2 = $mssqlresults2 -> fetch(PDO::FETCH_ASSOC);      
	$temp = $row2['VendorName']; 
	//echo(__FILE__.":".__LINE__.' $row2[VendorName] = '.$row2['VendorName'].'<br>');
        $row2 = $mssqlresults2 -> fetch(PDO::FETCH_ASSOC);      
        //echo(__FILE__.":".__LINE__.' $row2[VendorName] = '.$row2['VendorName'].'<br>');
        //echo(__FILE__.":".__LINE__.' $mssqlresults2 -> rowCount() = '.$mssqlresults2 -> rowCount().'<br>');
        //if ($mssqlresults2 -> rowCount() > 1)
        if ($row2['VendorName'] != "")
        {
	  $row2['VendorName'] = "";
	}
	else
	{
          $row2['VendorName'] = $temp; 
	}
      }
      echo $row2['VendorName'].'</td>';
      echo '
    <td>';
      $directory2 = dir("\\\ORSPSRVAPP02\\webroot2\\Subawards (used by subcontractsdocuments)\\".$row['ORSPNumber']."\\Sub-Awards\\".$entry); 
      $directory2->read();
      $directory2->read();
      $entry2 = $directory2->read();
      //$entry2 = str_replace('#','%23',$entry2); 
      echo '  <a href="https://orspweb2.utep.edu/Subawards (used by subcontractsdocuments)/',$row['ORSPNumber'],'/Sub-Awards/',$entry,'/',str_replace('#','%23',$entry2),'" target="_blank">',htmlentities($entry2),'</a>';
      if (($entry2) && (($_SESSION["UID"] == 'osegueda') || ($_SESSION["UID"] == 'blekal') || ($_SESSION["UID"] == 'mslopez4') || ($_SESSION["UID"] == 'ehzazueta') || ($_SESSION["UID"] == 'rchavez13') || ($_SESSION["UID"] == 'mvalvillar') || ($_SESSION["UID"] == 'aherrera16')))
      {
        echo '  <a href="DeleteFile.php?file=Subawards (used by subcontractsdocuments)\\',$row['ORSPNumber'],'\\Sub-Awards\\',$entry,'\\',urlencode($entry2),'" target="_blank"> Delete</a>';
      }	    
      while ($entry2 = $directory2->read())
      {
        //$entry2 = str_replace('#','%23',$entry2); 
        echo '  , <a href="https://orspweb2.utep.edu/Subawards (used by subcontractsdocuments)/',$row['ORSPNumber'],'/Sub-Awards/',$entry,'/',str_replace('#','%23',$entry2),'" target="_blank">',htmlentities($entry2),'</a>';
        if (($_SESSION["UID"] == 'osegueda') || ($_SESSION["UID"] == 'blekal') || ($_SESSION["UID"] == 'mslopez4') || ($_SESSION["UID"] == 'ehzazueta') || ($_SESSION["UID"] == 'rchavez13') || ($_SESSION["UID"] == 'mvalvillar') || ($_SESSION["UID"] == 'aherrera16'))
        {
          echo '  <a href="DeleteFile.php?file=Subawards (used by subcontractsdocuments)\\',$row['ORSPNumber'],'\\Sub-Awards\\',$entry,'\\',urlencode($entry2),'" target="_blank"> Delete</a>';
        }	    
      } 
      if (($_SESSION["UID"] == 'osegueda') || ($_SESSION["UID"] == 'blekal') || ($_SESSION["UID"] == 'mslopez4') || ($_SESSION["UID"] == 'ehzazueta') || ($_SESSION["UID"] == 'rchavez13') || ($_SESSION["UID"] == 'mvalvillar') || ($_SESSION["UID"] == 'aherrera16'))
      {
        echo '<a href="DeleteFile.php?file=Subawards (used by subcontractsdocuments)\\',$row['ORSPNumber'],'\\Sub-Awards\\',$entry,'" target="_blank"> Delete</a> <a href="https://orspweb2.utep.edu/subcontractsdocuments/UploadDocument.php?subrecipient='.$entry.'&subcontract='.$row['ORSPNumber'].'" target="_blank"> Upload</a></td>';
      }
      else 
      {
        echo '</td>';
      }
      echo '
  </tr>';
    }
    $directory->close();
    $directory2->close();
  }
  /*else if (file_exists("\\\ORSPSRVAPP02\\webroot2\\Contracts and Grants (used by displaynoas)\\NOAs\\DHHS- NIH People Soft\\".$row['ProjectID']))
  {
    $directory = dir("\\\ORSPSRVAPP02\\webroot2\\Contracts and Grants (used by displaynoas)\\NOAs\\DHHS- NIH People Soft\\".$row['ProjectID']); 	  
    echo '
    <td>';
    $directory->read();
    $directory->read();
    $entry = $directory->read();
    echo '  <a href="https://orspweb2.utep.edu/Contracts and Grants (used by displaynoas)/NOAS/DHHS- NIH People Soft/',$row['ProjectID'],'/',$entry,'" target="_blank">',$entry,'</a>';
    if (($entry) && (($_SESSION["UID"] == 'osegueda') || ($_SESSION["UID"] == 'blekal') || ($_SESSION["UID"] == 'mslopez4')))
    {
      echo '  <a href="DeleteFile.php?file=Contracts and Grants (used by displaynoas)\\NOAS\\DHHS- NIH People Soft\\',$row['ProjectID'],'\\',$entry,'" target="_blank"> Delete</a>';
    }	    
    while ($entry = $directory->read())
    {
      echo '  , <a href="https://orspweb2.utep.edu/Contracts and Grants (used by displaynoas)/NOAS/DHHS- NIH People Soft/',$row['ProjectID'],'/',$entry,'" target="_blank">',$entry,'</a>';
      if (($_SESSION["UID"] == 'osegueda') || ($_SESSION["UID"] == 'blekal') || ($_SESSION["UID"] == 'mslopez4'))
      {
        echo '  <a href="DeleteFile.php?file=Contracts and Grants (used by displaynoas)\\NOAS\\DHHS- NIH People Soft\\',$row['ProjectID'],'\\',$entry,'" target="_blank"> Delete</a>';
      }	    
    }
    if (($_SESSION["UID"] == 'osegueda') || ($_SESSION["UID"] == 'blekal') || ($_SESSION["UID"] == 'mslopez4'))
    {
      echo ' <a href="https://orspweb2.utep.edu/displaynoas/UploadNOA.php?Directory=NOAs\\DHHS- NIH People Soft&ProjectID='.$row['ProjectID'].'" target="_blank"> Upload</a></td>';
    }
    else
    {
      echo '</td>';
    }
    $directory->close();
  }
  else if (file_exists("\\\ORSPSRVAPP02\\webroot2\\Contracts and Grants (used by displaynoas)\\NOAs\\NSF People Soft\\".$row['ProjectID']))
  {
    $directory = dir("\\\ORSPSRVAPP02\\webroot2\\Contracts and Grants (used by displaynoas)\\NOAs\\NSF People Soft\\".$row['ProjectID']); 	  
    echo '
    <td>';
    $directory->read();
    $directory->read();
    $entry = $directory->read();
    echo '  <a href="https://orspweb2.utep.edu/Contracts and Grants (used by displaynoas)/NOAS/NSF People Soft/',$row['ProjectID'],'/',$entry,'" target="_blank">',$entry,'</a>';
    if (($entry) && (($_SESSION["UID"] == 'osegueda') || ($_SESSION["UID"] == 'blekal') || ($_SESSION["UID"] == 'mslopez4')))
    {
      echo '  <a href="DeleteFile.php?file=Contracts and Grants (used by displaynoas)\\NOAS\\NSF People Soft\\',$row['ProjectID'],'\\',$entry,'" target="_blank"> Delete</a>';
    }	    
    while ($entry = $directory->read())
    {
      echo '  , <a href="https://orspweb2.utep.edu/Contracts and Grants (used by displaynoas)/NOAS/NSF People Soft/',$row['ProjectID'],'/',$entry,'" target="_blank">',$entry,'</a>';
      if (($_SESSION["UID"] == 'osegueda') || ($_SESSION["UID"] == 'blekal') || ($_SESSION["UID"] == 'mslopez4'))
      {
        echo '  <a href="DeleteFile.php?file=Contracts and Grants (used by displaynoas)\\NOAS\\NSF People Soft\\',$row['ProjectID'],'\\',$entry,'" target="_blank"> Delete</a>';
      }	    
    }
    if (($_SESSION["UID"] == 'osegueda') || ($_SESSION["UID"] == 'blekal') || ($_SESSION["UID"] == 'mslopez4'))
    {
      echo ' <a href="https://orspweb2.utep.edu/displaynoas/UploadNOA.php?Directory=NOAs\\NSF People Soft&ProjectID='.$row['ProjectID'].'" target="_blank"> Upload</a></td>';
    }
    else
    {
      echo '</td>';
    }
    $directory->close();
  }
  else if (file_exists("\\\ORSPSRVAPP02\\webroot2\\Contracts and Grants (used by displaynoas)\\NOAs - No Cost Extensions\\".$row['ProjectID']))
  {
    $directory = dir("\\\ORSPSRVAPP02\\webroot2\\Contracts and Grants (used by displaynoas)\\NOAs - No Cost Extensions\\".$row['ProjectID']); 	  
    echo '
    <td>';
    $directory->read();
    $directory->read();
    $entry = $directory->read();
    echo '  <a href="https://orspweb2.utep.edu/Contracts and Grants (used by displaynoas)/NOAs - No Cost Extensions/',$row['ProjectID'],'/',$entry,'" target="_blank">',$entry,'</a>';
    if (($entry) && (($_SESSION["UID"] == 'osegueda') || ($_SESSION["UID"] == 'blekal') || ($_SESSION["UID"] == 'mslopez4')))
    {
      echo '  <a href="DeleteFile.php?file=Contracts and Grants (used by displaynoas)\\NOAs - No Cost Extensions\\',$row['ProjectID'],'\\',$entry,'" target="_blank"> Delete</a>';
    }	    
    while ($entry = $directory->read())
    {
      echo '  , <a href="https://orspweb2.utep.edu/Contracts and Grants (used by displaynoas)/NOAs - No Cost Extensions/',$row['ProjectID'],'/',$entry,'" target="_blank">',$entry,'</a>';
      if (($_SESSION["UID"] == 'osegueda') || ($_SESSION["UID"] == 'blekal') || ($_SESSION["UID"] == 'mslopez4'))
      {
        echo '  <a href="DeleteFile.php?file=Contracts and Grants (used by displaynoas)\\NOAs - No Cost Extensions\\',$row['ProjectID'],'\\',$entry,'" target="_blank"> Delete</a>';
      }	    
    }
    if (($_SESSION["UID"] == 'osegueda') || ($_SESSION["UID"] == 'blekal') || ($_SESSION["UID"] == 'mslopez4'))
    {
      echo ' <a href="https://orspweb2.utep.edu/displaynoas/UploadNOA.php?Directory=NOAs - No Cost Extensions&ProjectID='.$row['ProjectID'].'" target="_blank"> Upload</a></td>';
    }
    else
    {
      echo '</td>';
    }
    $directory->close();
  }
  else if (file_exists("\\\ORSPSRVAPP02\\webroot2\\Contracts and Grants (used by displaynoas)\\NOAs\\".$row['ProjectID']))
  {
    $directory = dir("\\\ORSPSRVAPP02\\webroot2\\Contracts and Grants (used by displaynoas)\\NOAs\\".$row['ProjectID']); 	  
    echo '
    <td>';
    $directory->read();
    $directory->read();
    $entry = $directory->read();
    echo '  <a href="https://orspweb2.utep.edu/Contracts and Grants (used by displaynoas)/NOAS/',$row['ProjectID'],'/',$entry,'" target="_blank">',$entry,'</a>';
    if (($entry) && (($_SESSION["UID"] == 'osegueda') || ($_SESSION["UID"] == 'blekal') || ($_SESSION["UID"] == 'mslopez4')))
    {
      echo '  <a href="DeleteFile.php?file=Contracts and Grants (used by displaynoas)\\NOAS\\',$row['ProjectID'],'\\',$entry,'" target="_blank"> Delete</a>';
    }	    
    while ($entry = $directory->read())
    {
      echo '  , <a href="https://orspweb2.utep.edu/Contracts and Grants (used by displaynoas)/NOAS/',$row['ProjectID'],'/',$entry,'" target="_blank">',$entry,'</a>';
      if (($_SESSION["UID"] == 'osegueda') || ($_SESSION["UID"] == 'blekal') || ($_SESSION["UID"] == 'mslopez4'))
      {
        echo '  <a href="DeleteFile.php?file=Contracts and Grants (used by displaynoas)\\NOAS\\',$row['ProjectID'],'\\',$entry,'" target="_blank"> Delete</a>';
      }	    
    }
    if (($_SESSION["UID"] == 'osegueda') || ($_SESSION["UID"] == 'blekal') || ($_SESSION["UID"] == 'mslopez4'))
    {
      echo ' <a href="https://orspweb2.utep.edu/displaynoas/UploadNOA.php?Directory=NOAs&ProjectID='.$row['ProjectID'].'" target="_blank"> Upload</a></td>';
    }
    else
    {
      echo '</td>';
    }
    $directory->close();
  }
  else if (file_exists("\\\ORSPSRVAPP02\\webroot2\\Contracts and Grants (used by displaynoas)\\Scanned Documents\NOAs\NOAs\\".$row['ProjectID']))
  {
    $directory = dir("\\\ORSPSRVAPP02\\webroot2\\Contracts and Grants (used by displaynoas)\\Scanned Documents\NOAs\NOAs\\".$row['ProjectID']); 	  
    echo '
    <td>';
    $directory->read();
    $directory->read();
    $entry = $directory->read();
    echo '  <a href="https://orspweb2.utep.edu/Contracts and Grants (used by displaynoas)/Scanned Documents/NOAs/NOAs/',$row['ProjectID'],'/',$entry,'" target="_blank">',$entry,'</a>';
    if (($entry) && (($_SESSION["UID"] == 'osegueda') || ($_SESSION["UID"] == 'blekal') || ($_SESSION["UID"] == 'mslopez4')))
    {
      echo '  <a href="DeleteFile.php?file=Contracts and Grants (used by displaynoas)\\Scanned Documents\\NOAs\\NOAs\\',$row['ProjectID'],'\\',$entry,'" target="_blank"> Delete</a>';
    }	    
    while ($entry = $directory->read())
    {
      echo '  , <a href="https://orspweb2.utep.edu/Contracts and Grants (used by displaynoas)/Scanned Documents/NOAs/NOAs/',$row['ProjectID'],'/',$entry,'" target="_blank">',$entry,'</a>';
      if (($_SESSION["UID"] == 'osegueda') || ($_SESSION["UID"] == 'blekal') || ($_SESSION["UID"] == 'mslopez4'))
      {
        echo '  <a href="DeleteFile.php?file=Contracts and Grants (used by displaynoas)\\Scanned Documents\\NOAs\\NOAs\\',$row['ProjectID'],'\\',$entry,'" target="_blank"> Delete</a>';
      }	    
    }
    if (($_SESSION["UID"] == 'osegueda') || ($_SESSION["UID"] == 'blekal') || ($_SESSION["UID"] == 'mslopez4'))
    {
      echo ' <a href="https://orspweb2.utep.edu/displaynoas/UploadNOA.php?Directory=Scanned Documents\\NOAs\NOAs&ProjectID='.$row['ProjectID'].'" target="_blank"> Upload</a></td>';
    }
    else
    {
      echo '</td>';
    }
    $directory->close();
  }*/
  else
  {
    echo '
  <tr>
    <td>'.$row['ORSPNumber'].'</td>';
    echo '
    <td>';
    if (($_SESSION["UID"] == 'osegueda') || ($_SESSION["UID"] == 'blekal') || ($_SESSION["UID"] == 'mslopez4') || ($_SESSION["UID"] == 'ehzazueta') || ($_SESSION["UID"] == 'rchavez13') || ($_SESSION["UID"] == 'mvalvillar') || ($_SESSION["UID"] == 'aherrera16'))
    {
      //echo ' <a href="https://orspweb2.utep.edu/subcontractsdocuments/UploadDocument.php?subrecipient=&subcontract='.$row['ORSPNumber'].'" target="_blank"> Upload</a></td>';
      echo ' <a href="UploadDocument.php?subrecipient=&subcontract='.$row['ORSPNumber'].'" target="_blank"> Upload</a></td>';
    }
    else
    {
      echo '</td>';
    }
    //echo '
    //<td>';
    //echo $row2['Vendor Name'].'</td>';
    echo '
  </tr>';
  }
}
?>
</table>
</body>
</html>
