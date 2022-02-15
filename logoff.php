<?php

session_start();

//remove session information
setcookie("UTEP_SE",NULL,-3600,"/",".utep.edu");
setcookie("UTEP_SA",NULL,-3600,"/",".utep.edu");

session_destroy();

//$login = 'login.php';

header("Location:login.php");
//exit();


?>
