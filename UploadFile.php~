<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

$redirect=  'Location: reportexample.php' ;
session_start();


if (($_SESSION['user'] == null) && ($_SERVER['HTTP_HOST'] != 'localhost')) {
  echo '<script type="text/javascript">parent.location.reload();</script>';
  header( $redirect);
  echo 'This website requires javascript enabled in order to work properly.';
  exit();
}

// Do not display functions if not authorized
$scdocs_admins_access = $_SESSION["ADMIN_SCDOCS_DISPLAY"];

if (!$scdocs_admins_access)
{
  exit();
}

//
/*if ($_POST["subrecipient"] == "") {
  echo "Please type in a subrecipient.";
  exit();
}*/


if (isset($_POST["Submit2"])) {

  /*$q = "SELECT EmailAddress FROM ORSPDatabase.PITableMysql WHERE EID = ".$_GET["eid"]; 
  $result2 = $db_conn->query($q);
  if (!$result2)
  {
    echo "query = $q<br><br>"; 	    
    echo(__FILE__.":".__LINE__.' Error: ');
    print_r($db_conn->errorInfo());
    die();
  }
  $row = $result2->fetch(PDO::FETCH_ASSOC);
  $UserName = substr($row['EmailAddress'],0,-9); // Drop the last 9 characters which are "@utep.edu".
  $q = "SELECT TransmittalsPackageDirectoryName FROM DataPortal.TransmittalsInfo WHERE TransmittalsPackageDirectoryName LIKE "."'%".$_GET["orspnumber"]."%'"; 
  $result2 = $db_conn->query($q);
  if (!$result2)
  {
    echo "query = $q<br><br>"; 	    
    echo(__FILE__.":".__LINE__.' Error: ');
    print_r($db_conn->errorInfo());
    die();
  }
  $row = $result2->fetch(PDO::FETCH_ASSOC);

  // This was sent from the upload related files code.

  //$target_dir = "D:\webroot2\\final_proposal_packages\\".$UserName."_".$_POST["NOI"]."_".$_POST["TRANSMITTALRecord"]."_".$_GET["orspnumber"]."\\";
  if ($result2->rowCount() == 0)
  { 
    $target_dir = "D:\webroot2\\final_proposal_packages\\".$UserName."_"."_".$_GET["orspnumber"]."\\";
  }  
  else
  {
    $target_dir = "D:\webroot2\\final_proposal_packages\\".$row['TransmittalsPackageDirectoryName']."\\";  
  }*/
  //$target_dir = "D:\webroot2\\final_proposal_packages\\".$UserName."_"."_".$_GET["orspnumber"]."\\";
  //$target_dir = "D:\webroot2\\Contracts & Grants (used by displaynoas)\\".$_GET["Directory"]."\\".$_GET["ProjectID"]."\\";
  //$target_dir = "D:\inetpub\\webroot2\\Contracts and Grants (used by displaynoas)\\".$_GET["Directory"]."\\".$_GET["ProjectID"]."\\";

  //$target_dir  = "D:\inetpub\\webroot2\\Subawards (used by subcontractsdocuments)\\".$_GET["subcontract"]."\\Sub-Awards\\".$_POST["subrecipient"]."\\";
  $target_dir  = "D:\inetpub\\webroot2\\NDAs (used by displayndas)\\";
  //$target_dir2 = "D:\inetpub\\webroot2\\Subawards (used by subcontractsdocuments)\\".$_GET["subcontract"]."\\";
  //$target_dir3 = "D:\inetpub\\webroot2\\Subawards (used by subcontractsdocuments)\\".$_GET["subcontract"]."\\Sub-Awards\\";
  $target_file = $target_dir . basename($_FILES["fileToUpload"]["name"]);
  
  $uploadOk    = 1;


  // Check if file already exists
  if (file_exists($target_file)) {
    echo "The file already exists.";
    $uploadOk = 0;
  }


  // Check file size
  if ($_FILES["fileToUpload"]["size"] > 65062000) {
    echo " Your file is too large.";
    $uploadOk = 0;
  }

  // Check if $uploadOk is set to 0 by an error
  if ($uploadOk == 0) {
      echo " Your file was not uploaded."; 
      exit();

  // if everything is ok, try to upload file
  } else {

      if (!is_dir($target_dir)) {

        //echo(__FILE__.":".__LINE__.' target_dir = '.$target_dir.'<br>' );
      	/*$TestDirectory3 = "D:\webroot2\\Contracts & Grants (used by displaynoas)\\".$_GET["Directory"]."\\".$_GET["ProjectID"]."\\"; 
      	$TestDirectory4 = "D:\inetpub\\webroot2\\Contracts & Grants (used by displaynoas)\\".$_GET["Directory"]."\\".$_GET["ProjectID"]."\\"; 
      	//$TestDirectory = "D:\webroot2\\Contracts & Grants (used by displaynoas)\\".$_GET["Directory"]."\\"; 
      	//$TestDirectory = "D:\webroot2\\Contracts & Grants (used by displaynoas)\\"; 
      	$TestDirectory1 = "D:\webroot2\\"; 
      	$TestDirectory2 = "D:\inetpub\\webroot2\\"; 
      	echo(__FILE__.":".__LINE__.' is_dir('.$TestDirectory1.') = '.var_dump(is_dir($TestDirectory1)).'<br>' );
      	echo(__FILE__.":".__LINE__.' is_dir('.$TestDirectory2.') = '.var_dump(is_dir($TestDirectory2)).'<br>' );
      	echo(__FILE__.":".__LINE__.' is_dir('.$TestDirectory3.') = '.var_dump(is_dir($TestDirectory3)).'<br>' );
      	echo(__FILE__.":".__LINE__.' is_dir('.$TestDirectory4.') = '.var_dump(is_dir($TestDirectory4)).'<br>' );*/

        //Check if OR directory exists, if not...create it
      	if (!is_dir($target_dir2)) { 
      	  mkdir($target_dir2);
      	}

        //Check if "Sub-Awards" directory exists, if not...create it
      	if (!is_dir($target_dir3)) { 
      	  mkdir($target_dir3);
      	}

        //Finally, create subrecipient folder
        mkdir($target_dir);
      }


      if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file)) {
        //echo " The file ". basename( $_FILES["fileToUpload"]["name"]). " has been uploaded.";
        echo " The file ". basename( $target_file). " has been uploaded.";
	      //echo "<br>target_file = $target_file"; exit();
	      $row2['NumberOfDirectories'] = 0; // Force the reuploading of the names of the files in the proposal packages directory so that this new file will be visible in the Data Portal.  
      } else {
          echo " There was an error uploading your file.";
      }

    }
}
?>
