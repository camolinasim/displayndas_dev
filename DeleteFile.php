<?php
session_start();
if(isset($_GET['file']) && !empty($_GET['file'])){

  if (($_SESSION['user']==null) && ($_SERVER['HTTP_HOST'] != 'localhost'))
  {
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
  $path = str_replace("%2F","\\",$File); //replaces the "%2F" to "\\"
  $is_file_deleted = unlink($path);
  if($is_file_deleted){
    echo("The following file was deleted: " . $path);
  }
  else{
    echo("Your file was NOT deleted");
  }
}


?>
