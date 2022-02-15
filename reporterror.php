<?php
//$redirect=  'Location: prats.php' ;
$redirect=  'Location: index.php' ;
session_start();
$_SESSION['error'] = "yes";
header( $redirect);
?>
