<?php
if(isset($_GET['Docket']) && !empty($_GET['Docket']) ){
  //println("inside deleteDocket.php")

  function deleteDirectory($dir) {
    // echo ('<p>
    // Trying to delete the following:' . $dir .
    // '</p>');
      if (!file_exists($dir)) {
          return true;
      }

      if (!is_dir($dir)) {
          return unlink($dir);
      }

      foreach (scandir($dir) as $item) {
          if ($item == '.' || $item == '..') {
              continue;
          }

          if (!deleteDirectory($dir . DIRECTORY_SEPARATOR . $item)) {
              return false;
          }

      }

      return rmdir($dir);
  }


  $redirect=  'Location: reportexample.php' ;
  session_start();

  // if (($_SESSION['user']==null) && ($_SERVER['HTTP_HOST'] != 'localhost'))
  // {
  //   echo '<script type="text/javascript">parent.location.reload();</script>';
  //   // header( $redirect);
  //   echo 'This website requires javascript enabled in order to work properly.';
  //   exit();
  // }

  // $scdocs_admins_access = $_SESSION["ADMIN_SCDOCS_DISPLAY"];
  //
  // if (!$scdocs_admins_access)
  // {
  //   exit();
  // }
    $File = "ORSPSRVAPP02/webroot2/NDAs (used by displayndas)/".($_GET["Docket"]);

    //echo(__FILE__.":".__LINE__.' $File = '.$File.'<br>' );

  if (!is_file($File))
  {
    $mssqldb_conn = new PDO("sqlsrv:server=orspsrvapp02.utep.edu;Database=displayndas","orspbt","3T3p*r3N1w");
    if (!$mssqldb_conn)
    {
      echo "Unable to connect to the MSSQL server";
      exit(0);
    }
    $q = "DELETE FROM [displayndas].[dbo].[ndas] WHERE Docket='".rawurldecode($_GET["Docket"])."'";
    $result2 = $mssqldb_conn->query($q);
    if (!$result2)
    {
      echo "query = $q<br><br>";
      echo(__FILE__.":".__LINE__.' Error: ');
      print_r($mssqldb_conn->errorInfo());
      die();
    }
    //delete folder
    $target_dir  = "\\\ORSPSRVAPP02\\webroot2\\NDAs (used by displayndas)\\".$_GET['Docket'].'\\';
    $is_deleted = deleteDirectory($target_dir);
    if($is_deleted){
      echo("The following docket has been deleted: " . $target_dir);
    }
    else{
      echo("your files were NOT deleted");
     }

    exit();
  }
  if (is_file($File) && unlink($File)) {
    echo "The file: $File has been deleted.";

  } else if (rmdir($File)) {

    //echo "The directory $File has been deleted.<br>";
    $File = str_replace('\TEST','',$File);
    rmdir($File);
    //echo "The directory $File has been deleted.<br>";
    $File = str_replace('\Sub-Awards','',$File);
    rmdir($File);
    echo "The directory: $File has been deleted.<br>";
  }
}
?>
