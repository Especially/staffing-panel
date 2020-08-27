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
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
</head>

<body>
    <div class="base">
    	<h2>Manage User Settings</h2>
            <div class="base_sub">
            	<div class="base_box" style="width:75%;overflow:scroll;">
	                <h3>Manage User Accounts</h3>
                    <form name="manage">
                    <?php 
						echo ("<div id=\"result\"></div><table style='border-collapse:collapse;'><thead><tr><td>uID</td><td>Login</td><td>First Name</td><td>Last Name</td><td>Email</td><td>Verified</td><td>Creation Date</td><td>Last Login</td><td>Login Status</td><td>Acc Type</td><td></td></tr></thead>");
						$query = "SELECT * FROM control ORDER BY cDate DESC";
						$result = mysqli_query($GLOBALS["___mysqli_ston"], $query);
						while($row = mysqli_fetch_assoc($result)){
							$msg_prev = $row['notif_message'];
							$msg_full = $row['notif_message'];
							$numb = 32;
							if (strlen($msg_prev) > $numb) {
							  $msg_prev = substr($msg_prev, 0, $numb);
							  $msg_prev = substr($msg_prev,0,strrpos($msg_prev," "));
							  $etc = " ..."; 
							  $msg_prev = $msg_prev.$etc;
							  }

							echo('<tr class="row"><td data-note="uid">'.$row['uID'].'</td><td data-note="login">'.$row['login'].'</td><td data-note="first">'.$row['first_name'].'</td><td data-note="last">'.$row['surname'].'</td><td data-note="email">'.$row['email'].'</td><td data-note="verify">'.$row['verify'].'</td><td data-note="cdate">'.$row['cDate'].'</td><td data-note="lastlogin">'.$row['last_login'].'</td><td data-note="status">'.$row['status'].'</td><td data-note="type">'.$row['type'].'</td><td><a href="#/Notifications/Save" class="save-edit" data-note-id="'.$row['notif_id'].'" style="display:none;">Save</a><a href="#/Notifications/Edit" class="edit-notification">Edit</a><a href="#/Notifications/Delete" class="delete-note" data-note-id="'.$row['notif_id'].'">Delete</a></td></tr>');
					}
					?>
                    </form>
                </div>
            </div>
    
    </div>
<script type="text/javascript">
$(document).ready( function() {
	$(".edit-notification").click( function () {
		$('.edit-btn').show().removeClass('edit-btn');
		$('.save-btn').hide().removeClass('save-btn');
		$(this).hide().addClass('edit-btn');
		$(this).siblings('.save-edit').show().addClass('save-btn');
		$('textarea.ac-input').parent().hide();
		$(".ac-input").each( function () {
			$('.msg-preview').css("display","table-cell");
			var incon = $(this).val();
			$(this).parent().html(''+incon+'');
			$(this).parent("td").siblings("td.msg-preview").css("display","table-cell");
			$(this).parent("td").siblings("td.msg-full").css("display","none");
		});
		$(this).parent().siblings("td").each(function () {
			var identifier = $(this).data('note');
			var content = $(this).html();
			$('.msg-preview').css("display","none");
			$('.msg-full-title').css("display","table-cell");
			if (identifier== 'type') {
				$(this).html('<input type="number" class="ac-input" value="'+content+'" name="'+identifier+'">');
			}
			if (identifier== 'priority') {
				$(this).html('<input type="number" class="ac-input" value="'+content+'" name="'+identifier+'">');
			}
			if (identifier=='msg-full') {
				$(this).css("display","block").html('<textarea name="'+identifier+'" class="ac-input" style="height:100px;">'+content+'</textarea>');
			} if (identifier == 'id' || identifier == 'date' || identifier == 'poster' || identifier == 'recipient') {
				$(this).html('<input type="text" class="ac-input" value="'+content+'" name="'+identifier+'">');
			}
			
		});
	});
	$(".save-edit").click( function () {
		var notif_id = $(this).data('note-id');
		var notif_date = $("input[name='date'].ac-input").val();
		var notif_recipient = $("input[name='recipient'].ac-input").val();
		var notif_poster = $("input[name='poster'].ac-input").val();
		var notif_type = $("input[name='type']").val();
		var notif_priority = $("input[name='priority'].ac-input").val();
		var notif_content = $("textarea[name='msg-full'].ac-input").val();
        var proceed = true;
        if (proceed) {
            post_data = {'notif_id': notif_id, 'action': 'edit', 'notif_date': notif_date, 'notif_recipient': notif_recipient, 'notif_poster': notif_poster, 'notif_type': notif_type, 'notif_content': notif_content, 'notif_priority': notif_priority};
            $.post('nt_update.php', post_data, function (response) {
                if (response.type == 'error') {
                    output = '<div class="error">' + response.text + '</div>';
                } else {
                    output = '<div class="success">' + response.text + '</div>';
                }
                if (response.type == 'error') {
					$("form[name='manage'] #result").hide().html(output).slideDown();
				}
				else {
					$("form[name='manage'] #result").hide().html(output).slideDown();
					$('.msg-full-title').css("display","none");
					$('.msg-preview').css("display","table-cell");
					$('textarea.ac-input').parent().hide();
					$('.edit-btn').show().removeClass('edit-btn');
					$('.save-btn').hide().removeClass('save-btn');
					$(".ac-input").each( function () {
						var incon = $(this).val();
						$(this).parent().html(''+incon+'');
						$(this).parent().css("display","table-cell");
						$(this).parent().css("display","none");
					});
				}
            }, 'json');
        }
	});
	$(".delete-note").click( function () {
		$(this).parents("tr").addClass('deleting');
		var notif_id = $(this).data('note-id');
		var that = this;
        var proceed = true;
        if (proceed) {
            post_data = {'notif_id': notif_id, 'action': 'delete'};
            $.post('nt_update.php', post_data, function (response) {
                if (response.type == 'error') {
                    output = '<div class="error">' + response.text + '</div>';
                } else {
                    output = '<div class="success">' + response.text + '</div>';
                }
                if (response.type == 'error') {
					$("form[name='manage'] #result").hide().html(output).slideDown();
				}
				else {
					$('.deleting').fadeOut();
				}
            }, 'json');
        }
	});
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
	var myElem = document.getElementById('time_span');
	if (myElem !== null) {
	    document.getElementById('time_span').innerHTML = t_str;
	}
	
}
var TimeUpdater = setInterval(updateTime, 1000);
    $("#update").click(function () {
        //get input field values
        var message = $('form[name="new_notification"] textarea[name=info]').val();
        var notif_type = $('form[name="new_notification"] select[name=notification_type]').val();
        var priority = $('form[name="new_notification"] select[name=priority]').val();
        var from = $('form[name="new_notification"] select[name=notification_from]').val();
        var recipient = $('form[name="new_notification"] select[name=notification_recipient]').val();
        //simple validation at client's end
        //we simply change border color to red if empty field using .css()
        var proceed = true;
        if (message == "") {
            $('form[name="new_notification"] textarea[name=info]').css('border-color', 'red');
            proceed = false;
        }

        //everything looks good! proceed...
        if (proceed) {
            //data to be sent to server
            post_data = {'action': 'new','message': message,'from': from,'priority': priority, 'recipient': recipient, 'type': notif_type, 'action': 'new'};

            //Ajax post data to server
            $.post('nt_update.php', post_data, function (response) {

                //load json data from server and output message     
                if (response.type == 'error') {
                    output = '<div class="error">' + response.text + '</div>';
                } else {

                    output = '<div class="success">' + response.text + '</div>';

                    //reset values in all input fields
                }
                $('form[name="new_notification"] #result').hide().html(output).slideDown();
            }, 'json');

        }
    });
});
</script>
</body>
</html>