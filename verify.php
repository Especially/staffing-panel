<?php
	//Start session
	session_start();
	// set maximun inactive time(this time is set in seconds )
	$max_time = 900;
	// Get current time on server;
	$current = time(); 
	 
	if (!isset ($_SESSION['Inactive']))
	{ // Create session inactive;
	  $_SESSION['Inactive'] = time();
	}
	 
	else
	 
	{
// Extract current time from inactive time.
$session_life = $current - $_SESSION['Inactive'] ;
 
    // Verify if inactive time is greater than maximun allow i
       if ($session_life > $max_time )
        {
        // Send the last page visited by user in the get variables
         $referrer = urlencode ($_SERVER['PHP_SELF']);
         // this will destroy the session that already exist;
         session_destroy();
         //Redirect user
         header('Location: logout?session=expired');
         //stop the script
         exit();
       }
   else
      {
        // Re-assign value to inactive
        $_SESSION['Inactive'] = time(); 
 
      } 
 
}
	
	//Check whether the session variable SESS_UID is present or not
	if(!isset($_SESSION['SESS_CONTROL_ID']) || (trim($_SESSION['SESS_CONTROL_ID']) == '')) {
		header("location: login");
		exit();
	}
$status = $_SESSION['SESS_CONTROL_STATUS'];
if ($status == "2") {
	header('Location: /blocked');
}
$verify = $_SESSION['SESS_CONTROL_VERIFY'];
if ($verify == "1") {
	header('Location: /main');
}
	$name = $_SESSION['SESS_CONTROL_NAME'];
	$vcode = $_SESSION['SESS_CONTROL_VCODE'];
    $user_Email = $_SESSION['SESS_CONTROL_EMAIL'];
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
<style>
.success{ background: #CFFFF5;padding: 10px; margin-bottom: 10px; border: 1px solid #B9ECCE; border-radius: 5px; font-weight: normal; }
.error{ background: #FFDFDF; padding: 10px; margin-bottom: 10px; border: 1px solid #FFCACA; border-radius: 5px; font-weight: normal;}
</style>
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

<fieldset class="white-pink">
  <table width="300" border="0" align="center" cellpadding="2" cellspacing="0" style="text-align:left;" class="white-pink">
<tr><td><div id="result"></div></td></tr>
	<tr>
	    <td>
<?php 
$verify = $_SESSION['SESS_CONTROL_VERIFY'];
$login = $_SESSION['SESS_CONTROL_LOGIN'];
$email = $_SESSION['SESS_CONTROL_EMAIL'];
if ($verify == "0") {
echo ("$login, it appears that your account has not been verified. Please check your email for a verification email, if one is not in your inbox, it may be in your spam/junk. If you still cannot find one, click the button below to send the message again.<a href='#' id='verify'>Re-send verification to $email</a>");
} 
elseif ($verify =="1") {
	echo ('Your email has already been verified!');
	}
	else {
		echo ('ERROR 1103x');
	}
	?>
    </td>
    </tr>
    <tr>
    <td>
    <a href='/logout' id='log-out'>Log Out</a>
    </td>
    </tr>
  </table>
  </fieldset>
        </div>
    <div id="footer"> 		
<div id="logo_titleLOG"></div>
        
    </div>
  </div>
</div>
<!-- SEND EMAIL -->
<script type="text/javascript">
$(document).ready(function() {
    $("#verify").click(function() { 
        var ndxr = <?php $to_Email = $_SESSION['SESS_CONTROL_FIRST']; echo json_encode($to_Email); ?>;
        var proceed = true;
        if(proceed) 
        {
            post_data = {'ndxr':ndxr};
            $.post('vsender.php', post_data, function(response){  
                if(response.type == 'error')
                {
                    output = '<div class="error">'+response.text+'</div>';
                }else{
                    output = '<div class="success">'+response.text+'</div>';
                    $('#contact_form input').val(''); 
                    $('#contact_form textarea').val(''); 
                }
                $("#result").hide().html(output).slideDown();
            }, 'json');
        }
    });
    
    //reset previously set border colors and hide all message on .keyup()
    $("#contact_form input, #contact_form textarea").keyup(function() { 
        $("#contact_form input, #contact_form textarea").css('border-color',''); 
        $("#result").slideUp();
    });
    
});
</script>
<!-- SEND EMAIL -->

<script type="text/javascript">
var title_length = $('#header h1 *').contents().filter(function() { return this.nodeType == 3; }).text().length;
var title_width = Math.max(1.5, Math.min(3, 48 / title_length));
$('#header h1').css('font-size', title_width + 'em');
</script>
<script src="./js/jquery.mCustomScrollbar.concat.min.js"></script>

</body></html>