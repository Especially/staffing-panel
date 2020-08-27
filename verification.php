 <?php 
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
	
	//Function to sanitize values received from the form. Prevents SQL injection
	function clean($str) {
		$str = @trim($str);
		if(get_magic_quotes_gpc()) {
			$str = stripslashes($str);
		}
		return ((isset($GLOBALS["___mysqli_ston"]) && is_object($GLOBALS["___mysqli_ston"])) ? mysqli_real_escape_string($GLOBALS["___mysqli_ston"], $str) : ((trigger_error("[MySQLConverterToo] Fix the mysql_escape_string() call! This code does not work.", E_USER_ERROR)) ? "" : ""));
	}	
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
<title>Verify</title>
<link rel="shortcut icon" href="./img/brand/favicon.ico">
<link rel="stylesheet" type="text/css" href="./css/stylesheet.css">
<link rel="stylesheet" type="text/css" href="./css/LOGREG.css">
<link rel="stylesheet" href="./css/jquery.mCustomScrollbar.css">

<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<meta name="viewport" content="initial-scale=1, minimum-scale=1">
<meta name="description" content="">
<meta http-equiv="x-dns-prefetch-control" content="off">

<script src="http://code.jquery.com/jquery-1.7.2.min.js"></script>
<script src="Yarix.js"></script>
</head>
<body>

<div id="headerLOG" class="header mCustomScrollbar light" data-mcs-theme="minimal-dark">
<div class="content">
    <h1 style="font-size: 3em;"><a href="/">Always Care s<sub>P</sub> New User</a></h1>

    <div id="description">
        <p>"Your health begins with peace of mind."</p>
    </div>
        <div id="login">

<form id="controlForm" name="controlForm" method="post" action="cFusion.php" class="white-pink">
  <table width="300" border="0" align="center" cellpadding="2" cellspacing="0" style="text-align:left;" class="white-pink">
	<tr>
	    <td>
		<?php 
		$vcode = clean($_GET['token']);
		if ($vcode == "") {
			echo ('This verification code does not exist.');
		}
		else{
		$q1 = "SELECT * FROM control WHERE vcode='$vcode'";
		$resul = @mysqli_query($GLOBALS["___mysqli_ston"], $q1);
		if ($resul){
			if(mysqli_num_rows($resul) > 0){
			//If Verification Code Exists > 0 Values
				$q2 = "SELECT * FROM control WHERE vcode='$vcode' AND verify='0'";
				$resu = @mysqli_query($GLOBALS["___mysqli_ston"], $q2);
				if ($resu){
					if(mysqli_num_rows($resu) > 0){
							$qry = "UPDATE control SET verify='1' WHERE vcode='$vcode'";
							$result = @mysqli_query($GLOBALS["___mysqli_ston"], $qry);
							if ($result) {
									while($row = mysqli_fetch_assoc($resu)){
							    $first = $row['first_name'];						
									echo ("$first your account has been verified! <a href='/login'>Click Here To Log In!</a>");
									}
								}
							elseif (!$result){
								echo ('Error');
							}
					}
					else {
						echo ("This account has already been verified!<a href='/login'>Click Here to Log In</a>");
					}
				}
			}
			else {
			// If Verification Code Doesn't Exist (Less than 0 Values in Table)
				echo ('This verification code does not exist!');
			}
		}
		else {
			echo ('Error :(!');
		}
		}
		?></td>
        
        
    </tr>
  </table>
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
	<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js"></script>
	<script>window.jQuery || document.write('<script src="./js/minified/jquery-1.11.0.min.js"><\/script>')</script>
<script src="./js/jquery.mCustomScrollbar.concat.min.js"></script>

</body></html>