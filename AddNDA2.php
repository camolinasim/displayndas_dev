<?php
$path_to_NDAs = "\\\ORSPSRVAPP02\\webroot2\\NDAs_dev\\";
// $redirect=  'Location: reportexample.php' ;
// header($redirect);

session_start();

if (($_SESSION['user']==null) && ($_SERVER['HTTP_HOST'] != 'localhost')) {
  // echo '<script type="text/javascript">parent.location.reload();</script>';
  // header( $redirect);
  echo 'This website requires javascript enabled in order to work properly.';
  exit();
}


// $scdocs_admins_access = $_SESSION["ADMIN_SCDOCS_DISPLAY"];

// if (!$scdocs_admins_access)
// {
//   exit();
// }
$mssqldb_conn = new PDO("sqlsrv:server=orspsrvapp02.utep.edu;Database=displayndas_dev","orspbt","3T3p*r3N1w");
if (!$mssqldb_conn)
{
  echo "Unable to connect to the MSSQL server";
  exit(0);
}
if (isset($_POST['Submit2']))
{
  $q = "INSERT INTO ndas ([Docket], [Effective Date], [Expiration Date]) VALUES ('".$_POST["Docket"]."', '".$_POST["EffectiveDate"]."', '".$_POST["ExpirationDate"]."');";
  $directory_created = mkdir($path_to_NDAs . $_POST["Docket"]);
  if($directory_created){
    echo "New docket added successfuly.";
  }


  // header("Location: https://orspweb2.utep.edu/displayndas_dev/index.php");
}
else if (isset($_POST['Submit3']))
{
  $q = "UPDATE ndas SET [Effective Date] = '".$_POST["EffectiveDate"]."',[Expiration Date] = '".$_POST["ExpirationDate"]."' WHERE Docket = '".$_POST["Docket"]."'";
  echo "Docket updated.";
}
$result2 = $mssqldb_conn->query($q);
if (!$result2)
{
  echo "query = $q<br><br>";
  echo(__FILE__.":".__LINE__.' Error: ');
  print_r($mssqldb_conn->errorInfo());
  print_r($_POST);

  die();
}
?>
