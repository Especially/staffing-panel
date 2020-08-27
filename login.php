<?php
session_start();
$status = $_SESSION['SESS_CONTROL_STATUS'];
if ($status == "1") {
	header('Location: /main');
}
?>
<!DOCTYPE html>
<html>

<head>
<title>Login</title>
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

<div id="headerLOG" class="header">
<div class="content">
    <h1 style="font-size: 3em;"><a href="/">Always Care s<sub>P</sub> Login</a></h1>

    <div id="description">
        <p>"Your health begins with peace of mind."</p>
    </div>
        <div id="login">
        <form id="loginForm" name="loginForm" method="post" action="logum.php" class="white-pink" autocomplete="off">
      <table width="100%" border="0">
<tr>
<td>
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
</td>
</tr>
      <tr>
        <td><?php echo $referer ?><input name="login" type="text" class="textfield" id="login" placeholder="Username" autocomplete="off" /></td>
        </tr>
        <tr>
        <td><input name="password" type="password" class="textfield" id="password" placeholder="Password" autocomplete="off"/></td>
        </tr>
        <tr>
        	<td><input type="submit" alt="Log In" title="Log In" class="button" value="Log In"/></td>
        </tr>
  </table>
  <div id="extras">
  <input type="hidden" name="return_to" value="<?php echo($_GET['return_to']); ?>">
  <input type="hidden" name="referer_url" value="<?php echo($referer); ?>">
  </div>
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

</body></html>