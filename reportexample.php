<?php

if (!isset($_GET['ProjectID'])) {
  $_GET['ProjectID'] = "";
}

// Redirect to https if you are not already in https.

if ($_SERVER['HTTPS'] != "on") {
  $redirect = "https://".$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];
  header("Location:$redirect");
}

session_start();


?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Display NDAs </title>

<style type="text/css">
<!--
html {
  height: 100%;

}

a {
	font-family: Arial, Helvetica, sans-serif;
	font-size: 12px;
	color: #00275B;
}
a:link {
	text-decoration: none;
	color: #0A246A;
	cursor: hand;
}
a:visited {
	text-decoration: none;
	color: #000000;
}
a:hover {
	text-decoration: underline;
	color: #000000;
}
a:active {
	text-decoration: none;
	color: #000000;
}
body, td, th {
	font-family: Arial, Helvetica, sans-serif;
	font-size: 12px;
	color: #00275B;
}
body {
	background-color: #FFF;
}
.table {
	border-width: 1px;
	border-style: dotted;
	border-color: #666666;
}

.footer {
    bottom: 0;
    height: 40px;
    background: #ff8d4f;
		color: #00275B;
		clear:both;
		position:absolute;
		bottom:0;
		width: 100%;
}

-->
</style>
  <link type="text/css" rel="stylesheet" href="./css/style.css" />
</head>

<body style="margin:0; min-height: 100%; position: relative; padding-bottom: 2px;">

<!-- branding -->
<div align="center" style="background:url(./img/ORSP_banner_bkg.jpg); background-color:#253B6E; width:100%; height: 110px; border-bottom: 4px solid #ff8d4f; ">
	<a href="http://research.utep.edu/">
	 <img src="./img/ORSP_banner_032013.png" alt="" />
	</a>
</div>
<br /><br />

<div id="ContentMain">
<div id="ContentMid">

<span style="font-size:18px; font-weight:bold; letter-spacing:-1px">Display NDAs</span> <br />
<span style="font-size:16px; font-weight:bold; letter-spacing:-1px; color:#CA4E02"> » Login </span>
<br />
<div style="width:500px;">
&nbsp;
<table border="0" width="285" align="center" cellpadding="0" cellspacing="0" bgcolor="#FFFFFF">
  <tr>
    <td>
			<?php
			echo '<form action="f_login.php?view=8&ProjectID=' .$_GET['ProjectID']. '" method="post" enctype="application/x-www-form-urlencoded" name="login" id="login">';
			?>
        <b>UTEP Miners Login</b><br />
        <br />
        <table width="283" border="0"  align="center" cellpadding="5" cellspacing="6" class="table">
          <tr align="left">
            <td width="119" align="right"> Username:</td>
            <td width="129"><input name="uid" type="text" id="uid" size="15" style="width:120px" /></td>
            <td></td>
          </tr>
          <tr align="left">
            <td align="right">Password: </td>
            <td><input name="passwd" type="password" id="passwd" size="15" style="width:120px" /></td>
            <td><input type="submit" value="Login" alt="Login" align="bottom" width="12" height="18" /></td>
		        <td></td>
          </tr>
        </table>
      </form>

			<?php

			if (isset($_SESSION['error'])) {
				if ($_SESSION['error'] == "yes") {
					echo '<p align="center">
									<font color="#FF0000">Invalid UserName and/or Password.</font>
								</p>';
					$_SESSION['error'] = "no";
				}
			}
			?>

      </td>
  </tr>
</table>
</div>

</div> <!-- contentMid -->
</div>  <!-- contentMain -->

<div class="footer"><br />
	<center>
	      <a href="http://www.utep.edu/">University of Texas at El Paso</a> |
				<a href="http://admin.utep.edu/Default.aspx?tabid=49976">State Reports</a> |
				<a href="http://www.utsystem.edu/">UT System</a> |
				<a href="http://www.utep.edu/customerservice.aspx">Customer Service Statement</a> |
				<a href="http://www.utep.edu/feedbackform.aspx">Site Feedback</a> |
				<a href="http://www.admin.utep.edu/Default.aspx?tabid=54275">Required Links</a> |
				<a href="http://admin.utep.edu/Default.aspx?tabid=37475">CLERY Crime Statistics</a>
	 </center>
 </div>

</body>
</html>
