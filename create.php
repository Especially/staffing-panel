<!DOCTYPE html>
<html class="wf-museo-i3-active wf-museo-i7-active wf-museo-n3-active wf-museo-n7-active wf-active" style="position: relative; -webkit-transition: right 0.25s ease-in-out; transition: right 0.25s ease-in-out; right: 0px;">

<head>
<title>New User</title>
<link rel="shortcut icon" href="./img/brand/favicon.ico">
<link rel="stylesheet" type="text/css" href="./css/stylesheet.css">
<link rel="stylesheet" type="text/css" href="./css/LOGREG.css">
<link rel="stylesheet" href="./css/jquery.mCustomScrollbar.css">

<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<meta name="viewport" content="initial-scale=1, minimum-scale=1">
<meta name="description" content="">
<meta http-equiv="x-dns-prefetch-control" content="off">
<?php
session_start();
?>
<script src="http://code.jquery.com/jquery-1.11.1.min.js"></script>
<script src="./js/Yarix.js"></script>
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
  <table width="300" border="0" align="center" cellpadding="2" cellspacing="0" style="text-align:left;">
<?php
	if( isset($_SESSION['ERRMSG_ARR']) && is_array($_SESSION['ERRMSG_ARR']) && count($_SESSION['ERRMSG_ARR']) >0 ) {
		echo '<ul class="err">';
		foreach($_SESSION['ERRMSG_ARR'] as $msg) {
			echo '<tr><td><li>',$msg,'</li></td></tr>'; 
		}
		echo '</ul>';
		unset($_SESSION['ERRMSG_ARR']);
	}
?>
    <tr>
      <th>First Name </th>
      <td><input name="fname" type="text" class="textfield" id="fname" /></td>
    </tr>
    <tr>
      <th>Surname </th>
      <td><input name="sname" type="text" class="textfield" id="lname" /></td>
    </tr>
    <tr>
      <th width="124">Login</th>
      <td width="168"><input name="login" type="text" class="textfield" id="login" /></td>
    </tr>
    <tr>
      <th width="124">Email</th>
      <td width="168"><input name="email" type="email" class="textfield" id="email" /></td>
    </tr>
    <tr>
      <th width="124">Account Type</th>
      <td width="168"><select name="type" id="type" onchange="changeFunc(2);">
        <option value="1">Regular</option>
        <option value="2">Admin</option>
      </select></td>
    </tr>
<script type="text/javascript">
function changeFunc($i) {
alert('WARNING: Giving this user Admin will allow them to disable accounts, delete staff logs and much more.')
	}
$('input[type="text"]').keyup(function(evt){
    var txt = $(this).val();


    // Regex taken from php.js (http://phpjs.org/functions/ucwords:569)
    $(this).val(txt.replace(/^(.)|\s(.)/g, function($1){ return $1.toUpperCase( ); }));
});
</script>
    <tr>
      <th>Password</th>
      <td><input name="password" type="password" class="textfield" id="password" /></td>
    </tr>
    <tr>
      <th>Confirm Password </th>
      <td><input name="cpassword" type="password" class="textfield" id="cpassword" /></td>
    </tr>
    <tr>
      <td><input name="ip" type="hidden" class="textfield" id="ip" value="<?php
	  function ip(){if (!empty($_SERVER['HTTP_CLIENT_IP'])){$ip=$_SERVER['HTTP_CLIENT_IP'];}else if (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])){$ip=$_SERVER['HTTP_X_FORWARDED_FOR'];}else{$ip=$_SERVER['REMOTE_ADDR'];}return $ip;}
$ip = ip();
/* Gathering Data Variables */
	$ip = $ip;
	echo($ip)
  ?>"/></td>
      <td><input type="submit" name="Submit" value="Create" class="button" /></td>
    </tr>
  </table>
</form>
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