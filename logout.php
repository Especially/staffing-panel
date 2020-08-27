<?php
	//Start session
	session_start();
	//Include database connection details
	require_once('cFigure.php');
	
	//Array to store validation errors
	$errmsg_arr = array();
	
	//Validation error flag
	$errflag = false;
	
	//Connect to mysql server
	$link = ($GLOBALS["___mysqli_ston"] = mysqli_connect(DB_HOST,  DB_USER,  DB_PASSWORD));
	if(!$link) {
		die('Failed to connect to server: ' . ((is_object($GLOBALS["___mysqli_ston"])) ? mysqli_error($GLOBALS["___mysqli_ston"]) : (($___mysqli_res = mysqli_connect_error()) ? $___mysqli_res : false)));
	}
	
	//Select database
	$db = ((bool)mysqli_query($GLOBALS["___mysqli_ston"], "USE " . constant('DB_DATABASE')));
	if(!$db) {
		die("Unable to select database");
	}


		$go ="UPDATE `control` SET status='0' WHERE uid =  '".$_SESSION['SESS_CONTROL_ID']."'";
		$goout = mysqli_query($GLOBALS["___mysqli_ston"], $go);
	
	//Unset the variables stored in session
	unset($_SESSION['SESS_CONTROL_FIRST']);
	unset($_SESSION['SESS_CONTROL_SURNAME']);
	unset($_SESSION['SESS_CONTROL_LOGIN']);
	unset($_SESSION['SESS_CONTROL_TYPE']);
	unset($_SESSION['SESS_CONTROL_VERIFY']);
	unset($_SESSION['SESS_CONTROL_STATUS']);
	unset($_SESSION['SESS_GLOBAL_DOMAIN']);
	unset($_SESSION['SESS_CONTROL_VCODE']);
	unset($_SESSION['SESS_CONTROL_CDATE']);
	unset($_SESSION['SESS_CONTROL_ID']);
	unset($_SESSION['SESS_CONTROL_EMAIL']);
?>
<!DOCTYPE html>
<html class="wf-museo-i3-active wf-museo-i7-active wf-museo-n3-active wf-museo-n7-active wf-active" style="position: relative; -webkit-transition: right 0.25s ease-in-out; transition: right 0.25s ease-in-out; right: 0px;">

<head>
<title>Log Out</title>
<link rel="shortcut icon" href="./img/brand/favicon.ico">
<link rel="stylesheet" type="text/css" href="./css/stylesheet.css">
<link rel="stylesheet" type="text/css" href="./css/LOGREG.css">
<link rel="stylesheet" href="./css/jquery.mCustomScrollbar.css">

<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<meta name="description" content="">
<meta http-equiv="x-dns-prefetch-control" content="off">

<script src="http://code.jquery.com/jquery-1.11.1.min.js"></script>
<script>
$(document).ready( function(){
if( /Android|webOS|iPhone|iPad|iPod|BlackBerry|IEMobile|Opera Mini/i.test(navigator.userAgent) ) {
$('head').append("<meta name=\"viewport\" content=\"width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no\" /"+">");
}else
{
$('body').append('<script src="./js/jquery.mCustomScrollbar.concat.min.js"></sc'+'ript>');
}
});
</script>
<script src="./js/Yarix.js"></script>
</head>
<body>

<div id="headerLOG" class="header mCustomScrollbar light" data-mcs-theme="minimal-dark">
<div class="content">
    <h1 style="font-size: 3em;"><a href="/">Always Care s<sub>P</sub> Login</a></h1>

    <div id="description">
        <p>"Your health begins with peace of mind."</p>
    </div>
        <div id="login">
        <form id="loginForm" name="loginForm" method="post" action="logum.php" class="white-pink">
      <table width="100%" border="0">
      <tr><td><?php if($_GET["session"] == "") echo "You have successfully logged out!<br/><a href='/login'>Click here to log in again</a>";
		  			if($_GET["session"]=="expired") echo "Your session has expired due to inactivity!<br/><a href='/login'>Click here to log in again</a>"; ?></td></tr>
  </table></form>
        </div>
    <div id="footer"> 		
<div id="logo_titleLOG"></div>
        
    </div>
  </div>
</div>
<script type="text/javascript">
var title_length = $('#header h1 *').contents().filter(function() { return this.nodeType == 3; }).text().length;
var title_width = Math.max(1.5, Math.min(3, 48 / title_length));
$('#header h1').css('font-size', title_width + 'em');
</script>

</body></html>