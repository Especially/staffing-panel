<?php 
	require_once('cFigure.php');	
	require_once('auth.php');	
	$type = $_SESSION['SESS_CONTROL_TYPE'];
	if ($type !== '3'){
		die('Insufficient tier level!');
	}

	
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
<title>New Update</title>
<style>
#tab_items {
display:block;
position:relative;
float:left;
line-height:15px;
	-webkit-transition: all 0.4s, ease-in-out;
	/* For Safari 3.1 to 6.0 */
	transition: all 0.4s ease-in-out;
}
#tab_holder {
display:block;
overflow:hidden;
padding:5px;
width:300px;
	-webkit-transition: all 0.4s, ease-in-out;
	/* For Safari 3.1 to 6.0 */
	transition: all 0.4s ease-in-out;
}
.success {
	background: #CFFFF5;
	padding: 10px;
	margin-bottom: 10px;
	border: 1px solid #B9ECCE;
	border-radius: 5px;
	font-weight: normal;
}
.error {
	background: #A64949;
	padding: 10px;
	margin-bottom: 10px;
	border: 1px solid #662D2D;
	border-radius: 5px;
	font-weight: normal;
}
#dialogbox{
	display: block;
	position: fixed;
	background: #000;
	border-radius:7px; 
	width:550px;
	z-index: 10;
}
#dialogboxhead{ background: #666; font-size:19px; padding:10px; color:#CCC; }
#dialogboxbody{ background:#333; padding:20px; color:#FFF; }
#dialogboxfoot{ background: #666; padding:10px; text-align:right; }
</style>
</head>
<body>
<div id="dialogbox">
<div id="dialogboxhead"><p style="margin:0px;">New Update</p><div id="time_span" style="position:absolute;top:10px;right:15px;"></div></div>
    <div id="dialogboxbody">
    <form class="nav holder" action="javascript:void(0);" name="update_form" id="update_form">
            <div id="tab_holder">
          <div id="tab_items" >
            <div id="tab_items">
            	<div id="result"></div>
            </div>
          </div>
          <div id="tab_items">
	      <div id="tab_items" style="height: 55px;text-align: center;line-height: 50px;min-width:70px;">Recipient:</div>
          <?php 
		  echo("<select name=\"notification_recipient\"><option value=\"all\">Everyone</option><option value=\"1\">Basic</option><option value=\"2\">Regular</option><option value=\"3\">Enterprise</option>");
		  $query = "SELECT * FROM control WHERE uid NOT IN (SELECT uid FROM control WHERE uid = '".$_SESSION['SESS_CONTROL_ID']."')";
		$result = mysqli_query($GLOBALS["___mysqli_ston"], $query);
		if(mysqli_num_rows($result)>0){
		while($row = mysqli_fetch_assoc($result)){
			echo ("<option value=\"".$row['uid']."\">".$row['first_name']." (".$row['login'].")</option>");
		}
		}else {
			//Nothing Else
		}
		  echo("</select>");
		  ?>
          </div>
          <div id="tab_items">
	      <div id="tab_items" style="height: 55px;text-align: center;line-height: 50px;min-width:70px;">From:</div>
          <?php 
		  echo("<select name=\"notification_from\"><option value=\"System\">System</option><option value=\"".$_SESSION['SESS_CONTROL_FIRST']." (".$_SESSION['SESS_CONTROL_LOGIN'].")\">Me</option></select>");
		  ?>
          </div>
          <div id="tab_items">
	      <div id="tab_items" style="height: 55px;text-align: center;line-height: 50px;min-width:70px;">Type:</div>
          <?php 
		  echo("<select name=\"notification_type\"><option value=\"1\">Feature Update</option><option value=\"2\">Miscellaneous</option></select>");
		  ?>
          </div>
          <div id="tab_items">
	      <div id="tab_items" style="height: 55px;text-align: center;line-height: 50px;min-width:70px;">Priority:</div>
          <?php 
		  echo("<select name=\"priority\"><option value=\"0\">Unimportant</option><option value=\"1\">Stickey</option><option value=\"2\">Requires attention</option></select>");
		  ?>
          </div>
          <div id="tab_items" style="line-height:0px;">
	      <div id="tab_items" style="height: 55px;text-align: center;line-height: 50px;min-width:70px;">Message:</div>
             <textarea id="info" name="info" placeholder="What's new in 40 charactters or less..." style="height:70px;padding:5px;"></textarea>
          </div></div>
           </form>
 </div>
    <div id="dialogboxfoot">
        <div id="tab_items" style="float:right;">
            <input type="button" class="dialog-button" id="update" value="Update">
        </div>
        <div id="tab_items" style="float:right;">
        	<input type="button" class="dialog-button cancel" id="cancel" value="Cancel">
        </div>
    </div>
</div>
<script src="http://code.jquery.com/jquery-1.7.2.min.js"></script>
<script type="text/javascript">
function updateTime(){
    var currentTime = new Date();
	var Wordday = new Array("Sunday","Monday","Tuesday","Wednesday","Thursday","Friday","Saturday","Sunday");
    var hours = currentTime.getHours()
	if ( hours == 0 )  {
		hours = "0" ? 12 : hours
	};
    var minutes = currentTime.getMinutes();
    if (minutes < 10){
        minutes = "0" + minutes;
	};
	var seconds = currentTime.getSeconds();
	    if (seconds < 10){
        seconds = "0" + seconds;
	};
	var day = currentTime.getDay();
    var t_str = Wordday[day] + "&nbsp;" + hours + ":" + minutes + ":" + seconds + " ";
    if(hours > 11){
        t_str += "AM";
    } else {
        t_str += "PM";
    };
    document.getElementById('time_span').innerHTML = t_str;
}
var TimeUpdater = setInterval(updateTime, 1000);
$(document).ready(function () {
    $("#update").click(function () {
        //get input field values
        var message = $('form[name="update_form"] textarea[name=info]').val();
        var notif_type = $('form[name="update_form"] select[name=notification_type]').val();
        var priority = $('form[name="update_form"] select[name=priority]').val();
        var from = $('form[name="update_form"] select[name=notification_from]').val();
        var recipient = $('form[name="update_form"] select[name=notification_recipient]').val();
        //simple validation at client's end
        //we simply change border color to red if empty field using .css()
        var proceed = true;
        if (message == "") {
            $('form[name="update_form"] textarea[name=info]').css('border-color', 'red');
            proceed = false;
        }

        //everything looks good! proceed...
        if (proceed) {
            //data to be sent to server
            post_data = {'message': message,'from': from,'priority': priority, 'recipient': recipient, 'type': notif_type, 'action': 'new'};

            //Ajax post data to server
            $.post('notification_push.php?action=update', post_data, function (response) {

                //load json data from server and output message     
                if (response.type == 'error') {
                    presp = 'error';
					pmsg  = '' + response.text + '';
                } else {
                    presp = 'success';
					pmsg  = '' + response.text + '';
					clearInterval(TimeUpdater);
                    //reset values in all input fields
				  $('#overlay, #dialogboxholder').delay(3000).fadeOut();
				  $('#dialogboxholder').delay(3000).queue(function(next) {
					  $(this).html('');
					  }).next();
                }
				puno(""+pmsg+"",""+presp+"");
            }, 'json');

        }
    });
});
    $('.cancel').each(function () {
        $(this).click(function () {
			clearInterval(TimeUpdater);
			var a = $("#v_cal").css('display');
			var b = $("#widget_ep").css('display');
			if ((a == 'block' || b == 'block')){
            $('#dialogboxholder').delay(3000).fadeOut().dequeue();
            $('#dialogboxholder').delay(3000).queue(function () {
                $(this).html('');
            }).dequeue();
			}
			else {
		$('#overlay, #dialogboxholder').delay(3000).fadeOut().dequeue();
            $('#dialogboxholder').delay(3000).queue(function () {
                $(this).html('');
            }).dequeue();
			}
        });
    });
</script> 
  </body>
  </html>