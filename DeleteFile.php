<?php
print_r($_GET);
$redirect=  'Location: reportexample.php' ;
session_start();

if (($_SESSION['user']==null) && ($_SERVER['HTTP_HOST'] != 'localhost'))
{
  echo '<script type="text/javascript">parent.location.reload();</script>';
  header( $redirect);
  echo 'This website requires javascript enabled in order to work properly.';
  exit();
}

// $scdocs_admins_access = $_SESSION["ADMIN_SCDOCS_DISPLAY"];
//
// if (!$scdocs_admins_access)
// {
//   exit();
// }
$File = "\\inetpub\\webroot2\\NDAs_dev\\".($_GET["file"]); //obtains the path of the file with a "%2F" between docket and nda
                                                           //e.g. \\inetpub\\webroot2\\NDAs_dev\\2020-0022%2Ftest.pdf
                                                           //%2F comes from html turning the "/" char into ASCII
//echo(__FILE__.":".__LINE__.' $File = '.$File.'<br>' );
$path = str_replace("%2F","\\",$File); //replaces the "%2F" to "\\" to
unlink($path);

//ANYTHING UNDER THIS LINE IS USELESS NOW


if (!is_file($File))
{
  $mssqldb_conn = new PDO("sqlsrv:server=orspsrvapp02.utep.edu;Database=displayndas_dev","orspbt","3T3p*r3N1w");
  if (!$mssqldb_conn)
  {
    echo "Unable to connect to the MSSQL server";
    exit(0);
  }
  $q = "DELETE FROM [displayndas_dev].[dbo].[ndafiles] WHERE Filename='".rawurldecode($_GET["file"])."'";
  $result2 = $mssqldb_conn->query($q);
  if (!$result2)
  {
    echo "query = $q<br><br>";
    echo(__FILE__.":".__LINE__.' Error: ');
    print_r($mssqldb_conn->errorInfo());
    die();
  }
  echo "Docket '"."NDAs_dev/".rawurldecode($_GET["file"])."' has been deleted.";
  header("Location: https://orspweb2.utep.edu/displayndas_dev/index.php"); //remove ths after adding ajax
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
?>
