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
session_start();
	$type = $_SESSION['SESS_CONTROL_TYPE'];
	$action = filter_var($_GET["action"], FILTER_SANITIZE_STRING);
?>
<style>
.notif-read {
	background-color:rgba(239, 239, 239, 0.7);
/*	border-radius:5px; */
	-webkit-transition: 0.3s ease;
    -moz-transition: 0.3s ease;
    -o-transition: 0.3s ease;
    transition: 0.3s ease;
}
</style>
  <?php
if ($action == 'holder'){
	echo('<style>.notif_item,.notif_box_item{padding:5px;}</style>');
$qry = "SELECT * FROM notifications WHERE ((notif_recipient = 'all') OR (notif_recipient = '".$_SESSION['SESS_CONTROL_TYPE']."') OR (notif_recipient = '".$_SESSION['SESS_CONTROL_ID']."')) ORDER BY notif_date DESC,notif_priority DESC";
$qrytest = "SELECT notifications.notif_id,notifications.notif_message,notifications.notif_priority,notifications.notif_poster,notifications.notif_date,notifications_read.notif_read_count FROM notifications LEFT JOIN notifications_read ON notifications.notif_id=notifications_read.notif_id WHERE ((notif_recipient = 'all') OR (notif_recipient = '".$_SESSION['SESS_CONTROL_TYPE']."') OR (notif_recipient = '".$_SESSION['SESS_CONTROL_ID']."')) ORDER BY notif_priority DESC,notif_date DESC";
$result = mysqli_query($GLOBALS["___mysqli_ston"], $qrytest);
if(mysqli_num_rows($result)>0){
while($row = mysqli_fetch_assoc($result)){
	$exists = $row['notif_read_count'];
	if ($exists > 1){
		echo ('<div class="notif_box_item" data-uid="'.$_SESSION['SESS_CONTROL_ID'].'" data-notif="'.$row['notif_id'].'" data-priority="'.$row['notif_priority'].'" style="background-color:rgba(239, 239, 239, 0.7);border-bottom: 1px solid rgb(135, 135, 135);"><b style="color: orange;">'.$row['notif_poster'].' '.$row['notif_date'].':</b><br/><p style="padding-left:15px;margin:0px;"><input type="checkbox" class="chk-notif" data-chk-priority="'.$row['notif_priority'].'" data-chk-notif="'.$row['notif_id'].'" style="position: absolute;left: 0px;" />'.$row['notif_message'].'</p></div>');
	}
	else{
		echo ('<div class="notif_box_item notif-unread" data-uid="'.$_SESSION['SESS_CONTROL_ID'].'" data-notif="'.$row['notif_id'].'" data-priority="'.$row['notif_priority'].'" style="border-bottom: 1px solid rgb(135, 135, 135);"><b style="color: orange;">'.$row['notif_poster'].' '.$row['notif_date'].':</b><br/><p style="padding-left:15px;margin:0px;"><input type="checkbox" class="chk-notif" data-chk-priority="'.$row['notif_priority'].'" data-chk-notif="'.$row['notif_id'].'" style="position: absolute;left: 0px;" />'.$row['notif_message'].'</p></div>');
	}
}
}
else {
	echo ('<tr><td colspan="8">No notifications!</td></tr>');
	}
}
if ($action == 'sidebar'){
	echo('<p style="margin: 1px;font-weight: bold;color: rgb(38, 38, 38);">Notifications</p>
<break></break>
<div style="text-align: left;max-height: 361px;overflow: auto;">');
$qry = "SELECT * FROM notifications WHERE ((notif_recipient = 'all') OR (notif_recipient = '".$_SESSION['SESS_CONTROL_TYPE']."') OR (notif_recipient = '".$_SESSION['SESS_CONTROL_ID']."')) AND (notif_id NOT IN (SELECT notif_id FROM notifications_read WHERE notif_recipient_uid = '".$_SESSION['SESS_CONTROL_ID']."' AND notif_priority = '0')) ORDER BY notif_priority DESC,notif_date DESC LIMIT 5";
$result = mysqli_query($GLOBALS["___mysqli_ston"], $qry);
if(mysqli_num_rows($result)>0){
while($row = mysqli_fetch_assoc($result)){
$importance = $row['notif_priority'];
$date = $row['notif_date'];
$date = strtotime($date);
$date = date("M d",$date);
$poster = $row['notif_poster'];
	if($importance == '1'){
	echo (
	'<div class="notif_item" data-uid="'.$_SESSION['SESS_CONTROL_ID'].'" data-notif="'.$row['notif_id'].'" data-priority="'.$row['notif_priority'].'" style="cursor:pointer;border-bottom: 1px solid rgb(135, 135, 135);background-color: rgba(255, 151, 0, 0.7);"><b>'.$poster.' '.$date.':</b><br/><p style="margin:0px;">'.$row['notif_message'].'</p></div>');
	}else{
	echo (
	'<div class="notif_item" data-uid="'.$_SESSION['SESS_CONTROL_ID'].'" data-notif="'.$row['notif_id'].'" data-priority="'.$row['notif_priority'].'" style="cursor:pointer;border-bottom: 1px solid rgb(135, 135, 135);"><b>'.$poster.' '.$date.':</b><br/><p style="margin:0px;">'.$row['notif_message'].'</p></div>');
	}
} 
echo('</div><break style="height:0.25em;"></break><a href="#" class="viewnotif">View All Notifications</a>');
}
else {
	echo ('<tr><td colspan="8">No new notifications!</td></tr>');
echo('</div><break style="height:0.25em;"></break><a href="#" class="viewnotif">View All Notifications</a>');
	}
}
?>

<script>
$(document).ready( function(){
// Replace Click with Each
	$('.notif_item').click( function(){
		var notif_priority = $(this).data('priority');
		if (notif_priority == '0') {
		var notif_id = $(this).data('notif');
		var notif_priority = $(this).data('priority');
		var uid = $(this).data('uid');
		$(this).addClass('notif-read').delay(1000).queue( function(){$(this).slideUp(200).dequeue();});
		$.ajax({
			type:"POST",
			url:"notification_push.php",
			data: {'action': 'read', 'notif_id': notif_id, 'notif_priority': notif_priority, 'user': uid},
			success: function(){
				$("div[data-location='qt_primary_notifications']").load(''+root+'widget_display.php?action=get_notifications_open');
			}
		}		
		);
		} else {
			puno("You cannot mark a flagged notification as read.","error");
		}
	});
$('a.viewnotif').click(function(){
	$('#overlay').fadeIn();	
	$('#notif_holder').load(''+root+'notifications.php?action=holder');
	$('#widget_notif').fadeIn();	
});
$('#widget_notif #exit, #overlay').click(function(){
	$('#overlay').fadeOut();	
	$('#widget_notif').fadeOut();
});
});
</script>