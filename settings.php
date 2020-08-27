<?php 
	require_once('cFigure.php');
	require_once('auth.php');	
	
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
?>
<html>
<head>
<?php 	require_once('includes.php'); ?>
<meta name="description" content="Robots rule.txt">
<script>
Date.prototype.toDateInputValue = (function() {
    var local = new Date(this);
    local.setMinutes(this.getMinutes() - this.getTimezoneOffset());
    return local.toJSON().slice(0,10);
});
</script>
</head>
<body class="mCustomScrollbar light" data-mcs-theme="minimal" style="color:white;">
<div id="holder" class="root" data-mcs-theme="light-thick" data-title-location="Settings - Always Care Staffing Panel" data-root-location="/Settings">
  <div id="box">
    <h2 style="color: rgba(255, 255, 255, 1);
text-shadow: 0px 1px 0px rgba(255, 255, 255, 0.5);padding-left:40px;padding-top:10px;padding-bottom:10px;background: url(../img/misc/stgs_white.png) left 10px center no-repeat;background-size: 33px;">Account Settings</h2>
<p style="color:white;"><?php echo(''.$_SESSION['SESS_CONTROL_FIRST'].', here you can update your account information. Leave the fields as they are if you wish to keep them the same.'); ?></p>
<p style="color:white;">COMING SOON: Email notifications. Be notified via email when there are pending shifts to be filled, and possile logistics.</p>
<fieldset style="background:none;border:none;">
<div class="primary">
    <table class="counterTable" style="color:white;">
        <tr>
        <td colspan="2"><div id="result"></div></td>
        </tr>
        <tr>
        	<td>Account Type:</td>
        	<td style="text-indent:10px;"><?php $type = $_SESSION['SESS_CONTROL_TYPE']; if($type == '1'){echo('Basic Account');} if($type == '2'){echo('Regular Account');} if($type == '3'){echo('Enterprise Account');}; ?></td>
        </tr>
        <tr>
        	<td>Name:</td>
        	<td><input type="text" name="first" value="<?php echo($_SESSION['SESS_CONTROL_FIRST']); ?>"/> <input type="text" name="last" value="<?php echo($_SESSION['SESS_CONTROL_SURNAME']); ?>"/></td>
        </tr>
        <tr>
        	<td>Login:</td>
        	<td><input type="text" name="login" value="<?php echo($_SESSION['SESS_CONTROL_LOGIN']); ?>"/></td>
        </tr>
        <tr>
        	<td>Email:</td>
        	<td><input type="email" name="email" value="<?php echo($_SESSION['SESS_CONTROL_EMAIL']); ?>"/></td>
        </tr>
        <tr>
        	<td>Password:</td>
        	<td><span class="pw">Click here</span> to change your password</td>
        </tr>
        <tr style="text-align:center;">
        	<td colspan="2"><input type="button" value="Update" id="prim-up"></td>
        </tr>
        </table>
</div>
<div class="pass" style="display:none;">
    <table class="counterTable" style="color:white;">
        <tr>
        	<td>Old Password:</td>
        	<td><input type="password" name="oldp"/></td>
        </tr>
        <tr>
        	<td>New Password:</td>
        	<td><input type="password" name="newp"/></td>
        </tr>
        <tr>
        	<td>Verify Password:</td>
        	<td><input type="password" name="verp"/></td>
        </tr>
        <tr style="text-align:center;">
        	<td colspan="2"><input type="button" value="Change" id="sec-up"></td>
        </tr>
    </table>
</div>
</fieldset>


      </div>

  <script type="text/javascript">
$(document).ready(function () {
$('.pw').click( function() {
		$('.pass').toggle();
});
$("#prim-up").click(function () {
        //get input field values
        var first = $('input[name=first]').val();
		var last = $('input[name=last]').val();
		var login = $('input[name=login]').val();
		var email = $('input[name=email]').val();

        //simple validation at client's end
        //we simply change border color to red if empty field using .css()
        var proceed = true;
        if (first == "") {
            $('input[name=first]').css('border-color', 'red');
            proceed = false;
        }
        if (last == "") {
            $('input[name=last]').css('border-color', 'red');
            proceed = false;
        }
        if (login == "") {
            $('input[name=login]').css('border-color', 'red');
            proceed = false;
        }
        if (email == "") {
            $('input[name=email]').css('border-color', 'red');
            proceed = false;
        }

        //everything looks good! proceed...
        if (proceed) {
            //data to be sent to server
            post_data = {'first': first, 'login': login, 'last': last, 'email': email, 'action': 'primary'};

            //Ajax post data to server
            $.post(''+root+'settings_push.php', post_data, function (response) {

                //load json data from server and output message     
                if (response.type == 'error') {
                    puno(response.text,"error");
                } else {
                    puno(response.text,"success");
                }
            }, 'json');

        }
    });
	
$("#sec-up").click(function () {
        //get input field values
        var Old = $('input[name=oldp]').val();
		var New = $('input[name=newp]').val();
		var Renew = $('input[name=verp]').val();

        //simple validation at client's end
        //we simply change border color to red if empty field using .css()
        var proceed = true;
        if (Old == "") {
            $('input[name=oldp]').css('border-color', 'red');
            proceed = false;
        }
        if (New == "") {
            $('input[name=newp]').css('border-color', 'red');
            proceed = false;
        }
        if (Renew == "") {
            $('input[name=verp]').css('border-color', 'red');
            proceed = false;
        }

        //everything looks good! proceed...
        if (proceed) {
            //data to be sent to server
            post_data = {'old': Old, 'new': New, 'renew': Renew, 'action': 'secondary'};

            //Ajax post data to server
            $.post(''+root+'settings_push.php', post_data, function (response) {

                //load json data from server and output message     
                if (response.type == 'error') {
                    puno(response.text,"error");
                } else {
                    puno(response.text,"success");
                }
//                $("#result").hide().html(output).slideDown().show();
            }, 'json');

        }
    });

});
</script> 
</div>
</body>
</html>