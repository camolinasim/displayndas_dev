<?php
$path_to_NDAs = "\\\ORSPSRVAPP02\\webroot2\\NDAs (used by displayndas)\\";
// $redirect=  'Location: reportexample.php' ;
// header($redirect);

session_start();


// $scdocs_admins_access = $_SESSION["ADMIN_SCDOCS_DISPLAY"];

// if (!$scdocs_admins_access)
// {
//   exit();
// }
$mssqldb_conn = new PDO("sqlsrv:server=orspsrvapp02.utep.edu;Database=displayndas","orspbt","3T3p*r3N1w");
if (!$mssqldb_conn)
{
  echo "Unable to connect to the MSSQL server";
  exit(0);
}
if (isset($_POST['Submit2']))
{
  $dkt = filter_var($_POST["Docket"],
            FILTER_SANITIZE_STRING);

  $q = "INSERT INTO ndas ([Docket], [Effective Date], [Expiration Date]) VALUES ('".$dkt."', '".$_POST["EffectiveDate"]."', '".$_POST["ExpirationDate"]."');";
  $directory_created = mkdir($path_to_NDAs . $_POST["Docket"]);
  if($directory_created){
    echo "New docket added successfuly.";
  }
  else{
    echo("Docket already exists. Your docket was NOT added.");
  }


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
